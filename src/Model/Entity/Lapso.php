<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Lapso Entity
 *
 * @property int $id
 * @property string $periodo_escolar
 * @property int $numero_lapso
 * @property bool $registro_eliminado
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\EstudianteLapso[] $estudiante_lapsos
 * @property \App\Model\Entity\LiteralLapso[] $literal_lapsos
 * @property \App\Model\Entity\LiteralMateria[] $literal_materias
 * @property \App\Model\Entity\Objetivo[] $objetivos
 * @property \App\Model\Entity\Observacion[] $observacions
 * @property \App\Model\Entity\ParametrosCargaCalificacion[] $parametros_carga_calificacions
 * @property \App\Model\Entity\PruebaLapso[] $prueba_lapsos
 */
class Lapso extends Entity
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
