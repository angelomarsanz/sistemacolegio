<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Observacion Entity
 *
 * @property int $id
 * @property int $lapso_id
 * @property int $student_id
 * @property string $observacion
 * @property bool $registro_elimindo
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Lapso $lapso
 * @property \App\Model\Entity\Student $student
 */
class Observacion extends Entity
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
