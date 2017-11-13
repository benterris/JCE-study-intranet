<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;

/**
 * User Entity
 *
 * @property int $id
 * @property string $password
 * @property string $role
 * @property string $first_name
 * @property string $last_name
 * @property string $address
 * @property string $email
 * @property string $phone_number
 * @property \Cake\I18n\Time $birth_date
 * @property string $occupation
 * @property string $company
 * @property string $professional_background
 * @property string $desired_interventions
 * @property string $disponibilites
 * @property string $notes_admin
 * @property bool $tutor
 * @property bool $membership_fee
 * @property bool $code_ethics
 * @property string $subject
 * @property int $user_id_highschool
 * @property string $highschool_name
 * @property string $first_name_delegate
 * @property string $last_name_delegate
 * @property string $email_delegate
 * @property string $phone_number_delegate
 * @property string $formation
 * @property string $pole
 * @property string $poleManaged
 */
class User extends Entity
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
        'id' => false
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];
    
    protected function _setPassword($password)
    {
        return (new DefaultPasswordHasher)->hash($password);
    }
    
    protected function _getLabel()
    {
        return $this->_properties['highschool_name'] . ' - ' . $this->_properties['address'];
    }
    
}
