<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Organization Entity.
 *
 * @property int $id
 * @property string $name
 * @property string $mailchimp_api_key
 * @property string $mailchimp_active_members_list
 * @property \App\Model\Entity\Member[] $members
 * @property \App\Model\Entity\User[] $users
 */
class Organization extends Entity
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
}
