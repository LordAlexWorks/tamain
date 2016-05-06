<?php
namespace App\Model\Table;

use App\Model\Entity\FileUpload;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FileUploads Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 */
class FileUploadsTable extends Table
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

        $this->table('file_uploads');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);

        // Adds file upload behavior through Proffer plugin
        $this->addBehavior('Proffer.Proffer', [
            'file_name' => [
                'root' => WWW_ROOT,
                'dir' => 'file_dir',
            ]
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
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('file_name', 'create')
            ->notEmpty('file_name');

        $validator
            ->requirePresence('file_dir', 'create')
            ->notEmpty('file_dir');

        $validator
            ->requirePresence('type', 'create')
            ->notEmpty('type');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        return $rules;
    }

    /**
     * Before entities are created, prevent files with the same name
     *
     * @param \Cake\Event\Event $event The beforeMarshal event.
     * @param \ArrayObject $data Event data
     * @param \ArrayObject $options Event options
     * @return void
     */
    public function beforeMarshal(\Cake\Event\Event $event, \ArrayObject $data, \ArrayObject $options)
    {
        if (isset($data['file_name']["name"])) {
            $filenameExtension = pathinfo($data['file_name']["name"], PATHINFO_EXTENSION);
            $filename = preg_replace('/^(.*)\.' . $filenameExtension . '$/', '$1', $data['file_name']["name"]);

            $number = 0;
            do {
                if ($number > 0) {
                    $data['file_name']["name"] = $filename . "_" . mt_rand() . "." . $filenameExtension;
                }

                $sameNameFiles = $this->findByFileName($data['file_name']["name"]);
                $number = $sameNameFiles->count();
            } while ($number > 0);
        }
    }
}
