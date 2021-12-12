<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ObservacionesLapsos Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Lapsos
 * @property \Cake\ORM\Association\BelongsTo $Students
 *
 * @method \App\Model\Entity\ObservacionesLapso get($primaryKey, $options = [])
 * @method \App\Model\Entity\ObservacionesLapso newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ObservacionesLapso[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ObservacionesLapso|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ObservacionesLapso patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ObservacionesLapso[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ObservacionesLapso findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ObservacionesLapsosTable extends Table
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

        $this->table('observaciones_lapsos');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Lapsos', [
            'foreignKey' => 'lapso_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Students', [
            'foreignKey' => 'student_id',
            'joinType' => 'INNER'
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
            ->allowEmpty('tipo_observacion');

        $validator
            ->allowEmpty('parrafo_1');

        $validator
            ->allowEmpty('parrafo_2');

        $validator
            ->allowEmpty('parrafo_3');

        $validator
            ->allowEmpty('parrafo_4');

        $validator
            ->allowEmpty('parrafo_5');

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
        $rules->add($rules->existsIn(['student_id'], 'Students'));

        return $rules;
    }
}
