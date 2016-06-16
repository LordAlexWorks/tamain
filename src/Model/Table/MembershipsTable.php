<?php
namespace App\Model\Table;

use App\Model\Entity\Membership;
use Cake\Core\Configure;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Mailchimp\Mailchimp;

/**
 * Memberships Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Members
 */
class MembershipsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('memberships');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Members', [
            'foreignKey' => 'member_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('starts_on', 'create')
            ->notEmpty('starts_on');

        $validator
            ->requirePresence('expires_on', 'create')
            ->notEmpty('expires_on');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['member_id'], 'Members'));
        return $rules;
    }

    /**
     * Return date in which a new membership expires
     * by default
     *
     * @return date
     */
    public function getMembershipDefaultExpiration()
    {
        return (new \DateTime('now'))->modify('+1 year');
    }


    /**
     * Query to return memberships expiring within interval
     * Does not include max_date
     *
     * @param \Cake\ORM\Query $query Query
     * @param array $options Query options
     * @return \Cake\ORM\Query Updated query
     */
    public function findWithinDates(\Cake\ORM\Query $query, array $options)
    {
        if (isset($options['min_date']) && isset($options['max_date'])) {
            $query
                ->where([
                    'Memberships.expires_on >=' => $options['min_date'],
                    'Memberships.expires_on <' => $options['max_date'],
                ]);
        }
        
        return $query;
    }

    /**
     * Fired after an entity is saved.
     *
     * @param Event $event Event
     * @param EntityInterface $entity Entity membership (already saved)
     * @param \ArrayObject $options Options
     * @return void
     */
    public function afterSave(Event $event, EntityInterface $entity, \ArrayObject $options)
    {
        $initialDate = $entity->starts_on;
        $expirationDate = $entity->expires_on;
        
        $member = $this->Members->findById($entity->member_id)->first();

        $mailchimpKey = Configure::read('App.mailchimpKey');
        $listId = "eaad0ec6e1";
        $mc = new Mailchimp($mailchimpKey);

        $membershipsActiveOrRecent = $this->find('all')
            ->where([
                'Memberships.member_id =' => $entity->member_id,
                'Memberships.expires_on >=' => date_format(new \DateTime("- 30 days"), 'Y-m-d')
            ])
            ->order(['Memberships.expires_on' => 'DESC']);

        if ((!$entity->isNew()) || ($membershipsActiveOrRecent->count() > 1)) {
            // Already subscribed to mailchimp in previous membership
            // Update expiration field if this one is higher
            try {
                $subscriberHash = md5(strtolower($member->email));
                $mc->patch("lists/$listId/members/$subscriberHash", [
                    "merge_fields" => [
                        "STARTS_ON" => date_format($initialDate, 'Y-m-d'),
                        "EXP_ON" => date_format($expirationDate, 'Y-m-d')
                    ]
                ]);
            } catch (Exception $e) {
                if ($e->getMessage()) {
                    $this->error = $e->getMessage();
                } else {
                    $this->error = 'An unknown error occurred when registering user in Mailchimp.';
                }
            }
        } elseif ($expirationDate >= new \DateTime) {
            // Active membership (not retroactive) and no memberships are active
            // or expired less than 30 days ago
            // Subscribe member
            try {
                $mc->post("lists/$listId/members", [
                    "status" => "subscribed",
                    "email_address" => $member->email,
                    "merge_fields" => [
                        "FNAME" => $member->firstname,
                        "LNAME" => $member->lastname,
                        "STARTS_ON" => date_format($initialDate, 'Y-m-d'),
                        "EXP_ON" => date_format($expirationDate, 'Y-m-d')
                    ]
                ]);
            } catch (Exception $e) {
                if ($e->getMessage()) {
                    $this->error = $e->getMessage();
                } else {
                    $this->error = 'An unknown error occurred when registering user in Mailchimp.';
                }
            }
        }
    }
}
