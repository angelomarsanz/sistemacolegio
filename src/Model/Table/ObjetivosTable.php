<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Objetivos Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Lapsos
 * @property \Cake\ORM\Association\BelongsTo $Materias
 * @property \Cake\ORM\Association\BelongsTo $Profesors
 * @property \Cake\ORM\Association\HasMany $Calificacions
 *
 * @method \App\Model\Entity\Objetivo get($primaryKey, $options = [])
 * @method \App\Model\Entity\Objetivo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Objetivo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Objetivo|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Objetivo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Objetivo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Objetivo findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ObjetivosTable extends Table
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

        $this->table('objetivos');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Lapsos', [
            'foreignKey' => 'lapso_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Materias', [
            'foreignKey' => 'materia_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Profesors', [
            'foreignKey' => 'profesor_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Calificacions', [
            'foreignKey' => 'objetivo_id'
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
            ->integer('numero_objetivo')
            ->requirePresence('numero_objetivo', 'create')
            ->notEmpty('numero_objetivo');

        $validator
            ->date('fecha_objetivo')
            ->allowEmpty('fecha_objetivo');

        $validator
            ->allowEmpty('descripcion_objetivo');

        $validator
            ->allowEmpty('instrumento_objetivo');

        $validator
            ->integer('ponderacion_objetivo')
            ->allowEmpty('ponderacion_objetivo');

        $validator
            ->allowEmpty('comentario_objetivo');

        $validator
            ->boolean('registro_eliminado')
            ->allowEmpty('registro_eliminado');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['lapso_id'], 'Lapsos'));
        $rules->add($rules->existsIn(['materia_id'], 'Materias'));
        $rules->add($rules->existsIn(['profesor_id'], 'Profesors'));

        return $rules;
    }
}
