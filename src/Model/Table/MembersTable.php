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

        $this->belongsTo('Organizations');
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
        "newMembers" => [
            "dateModifier" => '- 30 days'
        ],
        "deactivatedMembers" => [
            "dateModifier" => '- 30 days'
        ],
        "expirationWarnings" => [
            "beforeExpiration" => '- 15 days',
            "afterExpiration" => '+ 15 days'
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
        $today = (array_key_exists("referenceDate", $options) ? $options['referenceDate'] : new \DateTime());
        
        $query->matching('Memberships', function ($q) use ($today) {
            return $q->where([
                'AND' => [
                    'Memberships.starts_on <=' => $today,
                    'Memberships.expires_on >=' => $today
                ]
            ]);
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
        $today = (array_key_exists("referenceDate", $options) ? $options['referenceDate'] : new \DateTime());

        $query
            ->contain('Memberships')
            ->notMatching('Memberships', function ($q) use ($today) {
                return $q->where([
                    'AND' => [
                        'Memberships.starts_on <=' => $today,
                        'Memberships.expires_on >=' => $today
                    ]
                ]);
            });
        
        return $query;
    }


    /**
     * Query to return members created after a certain date
     * from settings' filter "newMembers"
     *
     * @param \Cake\ORM\Query $query Query
     * @param array $options Query options
     * @return \Cake\ORM\Query Updated query
     */
    public function findNewMembers(\Cake\ORM\Query $query, array $options)
    {
        $today = (array_key_exists("referenceDate", $options) ? $options['referenceDate'] : new \DateTime());

        $dateModifier = $this->settingsFilters['newMembers']['dateModifier'];

        $minDate = clone $today;
        $minDate = $minDate->modify($dateModifier);

        $query = $query->where(function ($exp, $q) use ($minDate, $today) {
             return $exp->between('created', $minDate->format('Y-m-d H:i:s'), $today->format('Y-m-d H:i:s'));
        });

        return $query;
    }

    /**
     * Query to return members who have been deactivated: they have had
     * no memberships active after date from filter "deactivatedMembers"
     * Attention: this is not the same as 'inactive'.
     *
     * @param \Cake\ORM\Query $query Query
     * @param array $options Query options
     * @return \Cake\ORM\Query Updated query
     */
    public function findDeactivatedMembers(\Cake\ORM\Query $query, array $options)
    {
        $today = (array_key_exists("referenceDate", $options) ? $options['referenceDate'] : new \DateTime());

        $dateModifier = $this->settingsFilters['deactivatedMembers']['dateModifier'];
        $maxDate = clone $today;
        $maxDate = $maxDate->modify($dateModifier);
        
        $query->notMatching('Memberships', function ($q) use ($today, $maxDate) {
            return $q->where([
                'AND' => [
                    'Memberships.starts_on <=' => $today,
                    'Memberships.expires_on >=' => $maxDate
                ]
            ]);
        });

        return $query;
    }

    /**
     * Query to return members who have been recently deactivated
     * (within 30 days before date from filter "deactivatedMembers")
     *
     * @param \Cake\ORM\Query $query Query
     * @param array $options Query options
     * @return \Cake\ORM\Query Updated query
     */
    public function findRecentlyDeactivatedMembers(\Cake\ORM\Query $query, array $options)
    {
        $today = (array_key_exists("referenceDate", $options) ? $options['referenceDate'] : new \DateTime());

        $dateModifier = $this->settingsFilters['deactivatedMembers']['dateModifier'];
        $minDate = clone $today;
        $minDate->modify($dateModifier);
        $minDate->modify('- 30 days');

        $deactivated = $this->find('deactivatedMembers', $options)->extract('id')->toArray();

        if (empty($deactivated)) {
            return $query;
        }

        $query
            ->where(['Members.id IN ' => $deactivated])
            ->matching('Memberships', function ($q) use ($today, $minDate) {
                return $q->where([
                    'AND' => [
                        'Memberships.starts_on <=' => $today,
                        'Memberships.expires_on >=' => $minDate
                    ]
                ]);
            })
            ->distinct('Members.id');

        return $query;
    }

    /**
     * Query to return members who are in the "limbo": last membership
     * expired between today and the "deactivatedMembers" filter date
     *
     * @param \Cake\ORM\Query $query Query
     * @param array $options Query options
     * @return \Cake\ORM\Query Updated query
     */
    public function findLimboMembers(\Cake\ORM\Query $query, array $options)
    {
        $today = (array_key_exists("referenceDate", $options) ? $options['referenceDate'] : new \DateTime());

        $dateModifier = $this->settingsFilters['deactivatedMembers']['dateModifier'];
        $minDate = clone $today;
        $minDate = $minDate->modify($dateModifier);
        
        $inactive = $this->find('inactiveMembers')->extract('id')->toArray();

        if (empty($inactive)) {
            return $query;
        }

        $query
            ->where(['Members.id IN ' => $inactive])
            ->matching('Memberships', function ($q) use ($today, $minDate) {
                return $q->where([ 'AND' => [
                    'Memberships.starts_on <=' => $today,
                    'Memberships.expires_on <' => $today,
                    'Memberships.expires_on >=' => $minDate
                ] ]);
            })
            ->distinct('Members.id');

        return $query;
    }

    /**
     * Query to return members who will be deactivated soon
     *
     * @param \Cake\ORM\Query $query Query
     * @param array $options Query options
     * @return \Cake\ORM\Query Updated query
     */
    public function findSoonToDeactivateMembers(\Cake\ORM\Query $query, array $options)
    {
        $today = (array_key_exists("referenceDate", $options) ? $options['referenceDate'] : new \DateTime());
        $mapByCall = (array_key_exists("mapByCall", $options) ? $options['mapByCall'] : false);

        $dateBeforeExpiration = clone $today;
        $dateBeforeExpiration->modify($this->settingsFilters['expirationWarnings']['beforeExpiration']);

        $dateAfterExpiration = clone $today;
        $dateAfterExpiration->modify($this->settingsFilters['expirationWarnings']['afterExpiration']);

        $dateNoNotices = clone $dateAfterExpiration;
        $dateNoNotices->modify('+ 1 days');

        // Memberships in interval
        $soonToDeactivate = $this->find('all')
            ->select(['Members.id'])
            ->matching('Memberships', function ($q) use ($dateNoNotices, $dateBeforeExpiration) {
                return $q->where([ 'AND' => [
                    'Memberships.starts_on <=' => $dateNoNotices,
                    'Memberships.expires_on <=' => $dateNoNotices,
                    'Memberships.expires_on >=' => $dateBeforeExpiration
                ] ]);
            })
            ->distinct('Members.id');

        $soonToDeactivateIds = $soonToDeactivate->extract('id')->toArray();
        if (empty($soonToDeactivateIds)) {
            return $soonToDeactivate;
        }

        // Make sure member had not renewed membership already (at the time)
        $soonToDeactivateNotRenewed = $query
            ->where(['Members.id IN ' => $soonToDeactivateIds])
            ->notMatching('Memberships', function ($q) use ($dateNoNotices) {
                return $q->where([ 'AND' => [
                    'Memberships.starts_on <=' => $dateNoNotices,
                    'Memberships.expires_on >' => $dateNoNotices
                ] ]);
            })
            ->contain(['Memberships' => [
                    'sort' => ['Memberships.expires_on' => 'DESC']
                ]])
            ->distinct('Members.id');

        // If not needed to map by call
        if (!$mapByCall) {
            return $soonToDeactivateNotRenewed;
        }

        // Map by call (Add information about which warning has been sent)
        $mapper = function ($member, $key, $mapReduce) use ($today) {
            $call = 2;
            $exp = date_format($member->memberships[0]->expires_on, 'Y-m-d');
            $tday = date_format($today, 'Y-m-d');
            if ($exp < $tday) {
                $call = 3;
            } elseif ($exp > $tday) {
                $call = 1;
            }
            $mapReduce->emitIntermediate($member, $call);
        };

        $reducer = function ($members, $call, $mapReduce) {
            $mapReduce->emit($members, $call);
        };

        $soonToDeactivateClassified = $soonToDeactivateNotRenewed
            ->mapReduce($mapper, $reducer);

        return $soonToDeactivateClassified;
    }

    /**
     * Query to return members who have had more than one membership
     * (they reregistrated)
     *
     * @param \Cake\ORM\Query $query Query
     * @param array $options Query options
     * @return \Cake\ORM\Query Updated query
     */
    public function findReregistratedMembers(\Cake\ORM\Query $query, array $options)
    {
        $today = (array_key_exists("referenceDate", $options) ? $options['referenceDate'] : new \DateTime());

        $query->select(['total_memberships' => $query->func()->count('Memberships.id')])
            ->leftJoinWith('Memberships', function ($q) use ($today) {
                return $q->where(['Memberships.starts_on <=' => $today]);
            })
            ->group(['Members.id'])
            ->having(['total_memberships >=' => 2])
            ->autoFields(true);

        return $query;
    }

    /**
     * Query to return the most common values of a field and its total count
     * of members created up to the reference date
     *
     * @example Query option parameters could be:
     *      $options['referenceDate'] => '2016-05-05' (default: today)
     *      $options['mostCommonField'] => 'Members.firstname' (default: Members.job)
     * And each of its results would have two keys, 'value' and 'count':
     *      $oneResult['value'] => 'Mary'
     *      $oneResult['value_count'] => 18
     *
     * @param \Cake\ORM\Query $query Query
     * @param array $options Query options. May include "mostCommonField" and "referenceDate"
     * @return \Cake\ORM\Query Updated query
     */
    public function findMostCommon(\Cake\ORM\Query $query, array $options)
    {
        $today = (array_key_exists("referenceDate", $options) ? $options['referenceDate'] : new \DateTime());
        $field = (array_key_exists("mostCommonField", $options) ? $options['mostCommonField'] : 'Members.job');

        $query->where(function ($exp, $q) use ($today, $field) {
                return $exp->lte('Members.created', $today)
                    ->isNotNull($field)
                    ->notEq($field, '');
        })
            ->select([
                'value' => $field,
                'value_count' => $query->func()->count($field)
            ])
            ->group([$field])
            ->order(['value_count' => 'DESC', $field => 'ASC']);

        return $query;
    }

    /**
     * Average age of all members created up to the reference date
     *
     * @example Query option parameters could be:
     *      $options['referenceDate'] => '2016-05-05' (default: today)
     * Result:
     *      $result->first()['age'] => 38
     *
     * @param \Cake\ORM\Query $query Query
     * @param array $options Query options
     * @return \Cake\ORM\Query Updated query
     */
    public function findAverageAge(\Cake\ORM\Query $query, array $options)
    {
        $today = (array_key_exists("referenceDate", $options) ? $options['referenceDate'] : new \DateTime());

        $query->where(function ($exp, $q) use ($today) {
                return $exp->lte('Members.created', $today)
                    ->isNotNull('Members.birthdate')
                    ->gt('Members.birthdate', '0000-00-00');
        })
            ->select([
                'age' => 'avg(TIMESTAMPDIFF(YEAR,birthdate,CURDATE()))'
            ])
            ->limit(1);

        return $query;
    }


    /**
     * Create members based on data from a CSV file
     *
     * @param string $fileUploadId ID of the uploaded CSV file
     * @param string $organizationId ID of the organization the members will belong to
     * @return array Messages and errors during import
     */
    public function import($fileUploadId, $organizationId)
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
                'active' => true,
                'organization_id' => $organizationId
            ];
            
            $data = implode(", ", $memberData);

            // Birthdate (optional)
            if (!is_null($csvRow[33])) {
                $memberData['birthdate'] = \DateTime::createFromFormat("d/m/Y", $csvRow[33]);
            }

            // CREATE MEMBER ENTITY AND SAVE
            $member = $this->newEntity();
            $member = $this->patchEntity($member, $memberData);

            if ($this->save($member)) {
                // Change member email to a variation of the admin's email,
                // so that no one is spammed by tests
                if (Configure::read('debug')) {
                    $this->updateAll(
                        [ 'email' => "lobobot+tamarin" . $member->id . "@lordalexworks.com" ],
                        [ 'id' => $member->id ]
                    );
                }

                // Create default membership
                if ((count($header) >= 63) && isset($csvRow[62])) {
                    $membershipStartsOn = \DateTime::createFromFormat("d/m/Y", $csvRow[62]);
                } else {
                    $membershipStartsOn = new \DateTime();
                }

                if ((count($header) >= 64) && isset($csvRow[63])) {
                    $membershipExpiresOn = \DateTime::createFromFormat("d/m/Y", $csvRow[63]);
                } else {
                    $membershipExpiresOn = $this->Memberships->getMembershipDefaultExpiration();
                }

                $membership = $this->Memberships->newEntity();
                $membership = $this->Memberships->patchEntity($membership, [
                    'member_id' => $member->id,
                    'starts_on' => $membershipStartsOn,
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
