<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ParametrosCargaCalificacion Entity
 *
 * @property int $id
 * @property int $profesor_id
 * @property int $lapso_id
 * @property int $materia_id
 * @property int $section_id
 * @property bool $registro_eliminado
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Profesor $profesor
 * @property \App\Model\Entity\Lapso $lapso
 * @property \App\Model\Entity\Materia $materia
 * @property \App\Model\Entity\Section $section
 */
class ParametrosCargaCalificacion extends Entity
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
