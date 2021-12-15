<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Proyecto Entity
 *
 * @property int $id
 * @property int $lapso_id
 * @property string $identificador_proyecto
 * @property \Cake\I18n\Time $fecha_proyecto
 * @property string $descripcion_proyecto
 * @property string $instrumento_proyecto
 * @property int $ponderacion_proyecto
 * @property string $comentario_proyecto
 * @property bool $registro_eliminado
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Lapso $lapso
 */
class Proyecto extends Entity
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
