<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RasgosPersonalidads Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Lapsos
 * @property \Cake\ORM\Association\BelongsTo $Materias
 * @property \Cake\ORM\Association\BelongsTo $Students
 * @property \Cake\ORM\Association\BelongsTo $OpcionesUsuarios
 *
 * @method \App\Model\Entity\RasgosPersonalidad get($primaryKey, $options = [])
 * @method \App\Model\Entity\RasgosPersonalidad newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\RasgosPersonalidad[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RasgosPersonalidad|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RasgosPersonalidad patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RasgosPersonalidad[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\RasgosPersonalidad findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RasgosPersonalidadsTable extends Table
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

        $this->table('rasgos_personalidads');
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
        $this->belongsTo('Students', [
            'foreignKey' => 'student_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('OpcionesUsuarios', [
            'foreignKey' => 'opciones_usuario_id',
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
            ->allowEmpty('calificacion');

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
        $rules->add($rules->existsIn(['student_id'], 'Students'));
        $rules->add($rules->existsIn(['opciones_usuario_id'], 'OpcionesUsuarios'));

        return $rules;
    }
}
