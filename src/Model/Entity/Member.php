<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Member Entity.
 *
 * @property int $id
 * @property string $firstname
 * @property string $lastname
 * @property \Cake\I18n\Time $birthdate
 * @property string $email
 * @property string $job
 * @property string $company
 * @property string $twitter
 * @property bool $active
 * @property \App\Model\Entity\Membership[] $membership
 */
class Member extends Entity
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
     */
    protected $_virtual = ['full_name'];
    
    /**
     * Return first and last name concatenated
     * @return string
     */
    protected function _getFullName() {
        return $this->_properties['firstname'] . '  ' .
                $this->_properties['lastname'];
    }
}
