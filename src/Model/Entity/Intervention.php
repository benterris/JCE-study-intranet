<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Intervention Entity
 *
 * @property int $id
 * @property int $user_id_volunteer
 * @property int $user_id_highschool
 * @property int $user_id_teacher
 * @property int $section_id
 * @property string $pole
 * @property string $type_intervention
 * @property \Cake\I18n\Time $date_intervention_starts
 * @property \Cake\I18n\Time $length_intervention
 * @property string $feedback_prof
 * @property string $feedback_intervenant
 * @property bool $intervention_realised
 *
 * @property \App\Model\Entity\Section $section
 */
class Intervention extends Entity
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
}
