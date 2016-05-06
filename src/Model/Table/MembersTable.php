<?php
namespace App\Model\Table;

use App\Model\Entity\Member;
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
     * Returns name of the default directory for uploading files
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
    protected function convertEncoding(array $array)
    {
        foreach ($array as &$value) {
            $value = utf8_encode($value);
        }
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
            if (!is_null($csvRow[33])) {
                $memberData['birthdate'] = \DateTime::createFromFormat("d/m/Y", $csvRow[33]);
            }

            // CREATE MEMBER ENTITY AND SAVE
            $member = $this->newEntity();
            $member = $this->patchEntity($member, $memberData);

            if ($this->save($member)) {
                $return['messages'][] = __(
                    'Successfully added member from row {0}! First name: {1}, Last name: {2}.',
                    $i,
                    $csvRow[1],
                    $csvRow[0]
                );
            } else {
                $data = implode(", ", $memberData);
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
