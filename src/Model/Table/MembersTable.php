<?php
namespace App\Model\Table;

use App\Model\Entity\Member;
use Cake\Core\Configure;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * Members Model
 *
 * @property \Cake\ORM\Association\HasMany $Membership
 */
class MembersTable extends Table
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

        $this->table('members');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('GrowthStatistics');

        $this->hasMany('Memberships', [
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
            ->requirePresence('firstname', 'create')
            ->notEmpty('firstname');

        $validator
            ->requirePresence('lastname', 'create')
            ->notEmpty('lastname');

        $validator
            ->allowEmpty('birthdate')
            ->add('published', 'date', [
                'rule' => 'date'
            ]);

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmpty('email');

        $validator
            ->boolean('active');

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
        $rules->add($rules->isUnique(['email']));
        return $rules;
    }

    /**
     * Return name of the default directory for uploading files
     * related to importing members
     *
     * @return string Dir name
     */
    public function getMemberImportUploadDir()
    {
        return "member_import_files";
    }

    /**
     * Convert array encoding to UTF
     *
     * @param array $array Array to be converted
     * @return void
     */
    protected function convertEncoding(array &$array)
    {
        foreach ($array as &$value) {
            $value = utf8_encode($value);
        }
    }

    /**
     * Temporarily hardcoded variables that will be
     * in the settings DB table
     *
     * @var array
     */
    public $settingsFilters = [
        "new-members" => [
            "daysBeforeToday" => 30
        ],
        "deactivated-members" => [
            "daysBeforeToday" => 30
        ]
    ];

    /**
     * Query to return members with 1+ memberships
     * that expire after today
     *
     * @param \Cake\ORM\Query $query Query
     * @param array $options Query options
     * @return \Cake\ORM\Query Updated query
     */
    public function findActiveMembers(\Cake\ORM\Query $query, array $options)
    {
        $today = new \DateTime();
        $query->matching('Memberships', function ($q) use ($today) {
            return $q->where(['Memberships.expires_on >=' => $today]);
        });
        
        return $query;
    }

    /**
     * Query to return members with no memberships
     * that expire after today
     *
     * @param \Cake\ORM\Query $query Query
     * @param array $options Query options
     * @return \Cake\ORM\Query Updated query
     */
    public function findInactiveMembers(\Cake\ORM\Query $query, array $options)
    {
        $today = new \DateTime();
        $query->notMatching('Memberships', function ($q) use ($today) {
            return $q->where(['Memberships.expires_on >=' => $today]);
        });
        
        return $query;
    }


    /**
     * Query to return members created after a certain date
     * from settings' filter "new-members"
     *
     * @param \Cake\ORM\Query $query Query
     * @param array $options Query options
     * @return \Cake\ORM\Query Updated query
     */
    public function findNewMembers(\Cake\ORM\Query $query, array $options)
    {
        $daysBeforeToday = $this->settingsFilters['new-members']['daysBeforeToday'];
        $minDate = date_format(new \DateTime("- $daysBeforeToday days"), 'Y-m-d');

        $query->where(['Members.created >=' => $minDate]);
        
        return $query;
    }

    /**
     * Query to return members who have been deactivated: they have had
     * no memberships active after date from filter "deactivated-members"
     * Attention: this is not the same as 'inactive'.
     *
     * @param \Cake\ORM\Query $query Query
     * @param array $options Query options
     * @return \Cake\ORM\Query Updated query
     */
    public function findDeactivatedMembers(\Cake\ORM\Query $query, array $options)
    {
        $daysBeforeToday = $this->settingsFilters['deactivated-members']['daysBeforeToday'];
        $maxDate = date_format(new \DateTime("- $daysBeforeToday days"), 'Y-m-d');
        
        $query->notMatching('Memberships', function ($q) use ($maxDate) {
            return $q->where(['Memberships.expires_on >' => $maxDate]);
        });
        
        return $query;
    }

    /**
     * Query to return members who are in the "limbo": last membership
     * expired between today and the "deactivated-members" filter date
     *
     * @param \Cake\ORM\Query $query Query
     * @param array $options Query options
     * @return \Cake\ORM\Query Updated query
     */
    public function findLimboMembers(\Cake\ORM\Query $query, array $options)
    {
        $today = new \DateTime();
        $daysBeforeToday = $this->settingsFilters['deactivated-members']['daysBeforeToday'];
        $minDate = date_format(new \DateTime("- $daysBeforeToday days"), 'Y-m-d');
        
        $inactive = $this->find('inactiveMembers')->extract('id')->toArray();

        $query
            ->where(['Members.id IN ' => $inactive])
            ->matching('Memberships', function ($q) use ($today, $minDate) {
                return $q->where([ 'AND' => [
                    'Memberships.expires_on <' => $today,
                    'Memberships.expires_on >=' => $minDate
                ] ]);
            })
            ->distinct('Members.id');

        return $query;
    }

    /**
     * Create members based on data from a CSV file
     *
     * @param string $fileUploadId ID of the uploaded CSV file
     * @return array Messages and errors during import
     */
    public function import($fileUploadId)
    {
        $fileUploads = TableRegistry::get('FileUploads');
        $membersFile = $fileUploads->findById($fileUploadId)->first();

        // set the filename to read CSV from
        $filename = $membersFile->full_dir . DS . $membersFile->file_name;
        
        // create a message container
        $return = [
            'messages' => [],
            'errors' => [],
        ];

        // open the file
        $handle = fopen($filename, "r");
        
        // read the 1st row as headings
        $length = 0;
        $delimiter = ";";
        $enclosure = '"';
        $header = fgetcsv($handle, $length, $delimiter, $enclosure);

        // read each data row in the file
        $i = 0;
        while (($csvRow = fgetcsv($handle, $length, $delimiter, $enclosure)) !== false) {
            $i++;

            $this->convertEncoding($csvRow);

            $memberData = [
                'firstname' => $csvRow[1],
                'lastname' => $csvRow[0],
                'job' => $csvRow[40],
                'company' => $csvRow[39],
                'twitter' => $csvRow[52],
                'email' => $csvRow[31],
                'active' => true
            ];
            
            $data = implode(", ", $memberData);

            // Change member email to a variation of the admin's email,
            // so that no one is spammed by tests
            if (Configure::read('debug')) {
                $this->updateAll(
                    [ 'email' => "lobobot+tamarin" . $entity->id . "@lordalexworks.com" ],
                    [ 'id' => $entity->id ]
                );
            }

            // Birthdate (optional)
            if (!is_null($csvRow[33])) {
                $memberData['birthdate'] = \DateTime::createFromFormat("d/m/Y", $csvRow[33]);
            }

            // CREATE MEMBER ENTITY AND SAVE
            $member = $this->newEntity();
            $member = $this->patchEntity($member, $memberData);

            if ($this->save($member)) {
                // Create default membership
                if ((count($header) == 63) && isset($csvRow[62])) {
                    $membershipExpiresOn = \DateTime::createFromFormat("d/m/Y", $csvRow[62]);
                } else {
                    $membershipExpiresOn = $this->Memberships->getDefaultMembershipDate();
                }

                $membership = $this->Memberships->newEntity();
                $membership = $this->Memberships->patchEntity($membership, [
                    'member_id' => $member->id,
                    'expires_on' => $membershipExpiresOn
                ]);

                if ($this->Memberships->save($membership)) {
                    $return['messages'][] = __(
                        'Successfully added member from row {0}! Name: {1} {2} (active until {3}).',
                        $i,
                        $csvRow[1],
                        $csvRow[0],
                        $membershipExpiresOn->format('d/m/Y')
                    );
                } else {
                    $errors = json_encode($membership->errors());
                    $return['errors'][] = __(
                        'Member from row {0} was added, but a membership could not be created. Data: {1}. Errors: {2}',
                        $i,
                        $data,
                        $errors
                    );
                }
            } else {
                $errors = json_encode($member->errors());
                $return['errors'][] = __(
                    'Adding member from row {0} failed. Data: {1}. Errors: {2}',
                    $i,
                    $data,
                    $errors
                );
            }
        }

        // close the file
        fclose($handle);
        
        // return the messages
        return $return;
    }
}
