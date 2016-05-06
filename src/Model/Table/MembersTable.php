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
    public function getMemberImportUploadDir() {
        return "member_import_files";
    }

    private function convertEncoding( $array ) {
        foreach ( $array as &$value ) {
            $value = utf8_encode( $value );
        }
    }

    public function import($file_upload_id) {
        $file_uploads = TableRegistry::get('FileUploads');
        $members_file = $file_uploads->findById($file_upload_id)->first();

        // set the filename to read CSV from
        $filename = $members_file->full_dir . DS . $members_file->file_name;
        
        // create a message container
        $return = array(
            'messages' => array(),
            'errors' => array(),
        );

        // open the file
        $handle = fopen($filename, "r");
        
        // read the 1st row as headings
        $length = 0;
        $delimiter = ";";
        $enclosure = '"';
        $header = fgetcsv($handle,$length,$delimiter,$enclosure);

        // read each data row in the file
        $i = 0;
        while (($csv_row = fgetcsv($handle,$length,$delimiter,$enclosure)) !== FALSE) {
            $i++;

            $this->convertEncoding($csv_row);
            
            $member_data = [
                'firstname' => $csv_row[1],
                'lastname' => $csv_row[0],
                'job' => $csv_row[40],
                'company' => $csv_row[39],
                'twitter' => $csv_row[52],
                'email' => $csv_row[31],
                'active' => true
            ];
            if (!is_null($csv_row[33])) {
                $member_data['birthdate'] = \DateTime::createFromFormat("d/m/Y", $csv_row[33]);
            }

            // CREATE MEMBER ENTITY AND SAVE
            $member = $this->newEntity();
            $member = $this->patchEntity($member, $member_data);

            if ($this->save($member)) {
                $return['messages'][] = __('Successfully added member from row {0}! First name: {1}, Last name: {2}.',
                    $i,$csv_row[1], $csv_row[0]);
            } else {
                $data = implode(", ",$member_data);
                $errors = @json_encode($member->errors());
                $return['errors'][] = __('Adding member from row {0} failed. Data: {1}. Errors: {2}',
                    $i, $data, $errors);
            }
        }

        // close the file
        fclose($handle);
        
        // return the messages
        return $return;
        
    }
}
