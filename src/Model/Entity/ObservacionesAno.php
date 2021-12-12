<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ObservacionesAno Entity
 *
 * @property int $id
 * @property int $student_id
 * @property string $periodo_escolar
 * @property string $tipo_observacion
 * @property string $parrafo_1
 * @property string $parrafo_2
 * @property string $parrafo_3
 * @property string $parrafo_4
 * @property string $parrafo_5
 * @property bool $registro_eliminado
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Student $student
 */
class ObservacionesAno extends Entity
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
