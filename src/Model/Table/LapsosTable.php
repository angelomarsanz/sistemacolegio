<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Lapsos Model
 *
 * @property \Cake\ORM\Association\HasMany $EstudianteLapsos
 * @property \Cake\ORM\Association\HasMany $LiteralLapsos
 * @property \Cake\ORM\Association\HasMany $LiteralMaterias
 * @property \Cake\ORM\Association\HasMany $Objetivos
 * @property \Cake\ORM\Association\HasMany $Observacions
 * @property \Cake\ORM\Association\HasMany $ParametrosCargaCalificacions
 * @property \Cake\ORM\Association\HasMany $PruebaLapsos
 *
 * @method \App\Model\Entity\Lapso get($primaryKey, $options = [])
 * @method \App\Model\Entity\Lapso newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Lapso[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Lapso|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Lapso patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Lapso[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Lapso findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LapsosTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('lapsos');
        $this->displayField('numero_lapso');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('EstudianteLapsos', [
            'foreignKey' => 'lapso_id'
        ]);
        $this->hasMany('LiteralLapsos', [
            'foreignKey' => 'lapso_id'
        ]);
        $this->hasMany('LiteralMaterias', [
            'foreignKey' => 'lapso_id'
        ]);
        $this->hasMany('Objetivos', [
            'foreignKey' => 'lapso_id'
        ]);
        $this->hasMany('Observacions', [
            'foreignKey' => 'lapso_id'
        ]);
        $this->hasMany('ParametrosCargaCalificacions', [
            'foreignKey' => 'lapso_id'
        ]);
        $this->hasMany('PruebaLapsos', [
            'foreignKey' => 'lapso_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->allowEmpty('periodo_escolar');

        $validator
            ->integer('numero_lapso')
            ->allowEmpty('numero_lapso');

        $validator
            ->boolean('registro_eliminado')
            ->allowEmpty('registro_eliminado');

        return $validator;
    }
}
