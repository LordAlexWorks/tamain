<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FileUpload Entity.
 *
 * @property int $id
 * @property string $file_name
 * @property string $file_dir
 * @property string $type
 * @property string $description
 * @property int $user_id
 * @property \App\Model\Entity\User $user
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 */
class FileUpload extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];


    /**
     * Virtual fields
     *
     * @var array
     */
    protected $_virtual = ['full_dir'];
    
    /**
     * Return full directory of the file (does not include file name)
     * @return string
     */
    protected function _getFullDir()
    {
        return WWW_ROOT . 'fileuploads' . DS . 'file_name' . DS .
                $this->_properties['file_dir'];
    }
}
