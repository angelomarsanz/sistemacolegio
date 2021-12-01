<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Objetivo Entity
 *
 * @property int $id
 * @property int $lapso_id
 * @property int $materia_id
 * @property int $profesor_id
 * @property int $numero_objetivo
 * @property \Cake\I18n\Time $fecha_objetivo
 * @property string $descripcion_objetivo
 * @property string $instrumento_objetivo
 * @property int $ponderacion_objetivo
 * @property string $comentario_objetivo
 * @property bool $registro_eliminado
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Lapso $lapso
 * @property \App\Model\Entity\Materia $materia
 * @property \App\Model\Entity\Profesor $profesor
 * @property \App\Model\Entity\Calificacion[] $calificacions
 */
class Objetivo extends Entity
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
