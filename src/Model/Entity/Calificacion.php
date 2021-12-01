<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Calificacion Entity
 *
 * @property int $id
 * @property int $objetivo_id
 * @property int $student_id
 * @property float $puntaje
 * @property float $puntaje_112
 * @property bool $registro_eliminado
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Objetivo $objetivo
 * @property \App\Model\Entity\Student $student
 */
class Calificacion extends Entity
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
