<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Proyectos Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Lapsos
 *
 * @method \App\Model\Entity\Proyecto get($primaryKey, $options = [])
 * @method \App\Model\Entity\Proyecto newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Proyecto[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Proyecto|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Proyecto patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Proyecto[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Proyecto findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProyectosTable extends Table
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

        $this->table('proyectos');
        $this->displayField('identificador_proyecto');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Lapsos', [
            'foreignKey' => 'lapso_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Sections', [
            'foreignKey' => 'section_id',
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
            ->requirePresence('identificador_proyecto', 'create')
            ->notEmpty('identificador_proyecto');

        $validator
            ->date('fecha_proyecto')
            ->allowEmpty('fecha_proyecto');

        $validator
            ->allowEmpty('descripcion_proyecto');

        $validator
            ->allowEmpty('instrumento_proyecto');

        $validator
            ->integer('ponderacion_proyecto')
            ->allowEmpty('ponderacion_proyecto');

        $validator
            ->allowEmpty('comentario_proyecto');

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
        $rules->add($rules->existsIn(['section_id'], 'Sections'));

        return $rules;
    }
}
