<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Profesors Model
 *
 * @method \App\Model\Entity\Profesor get($primaryKey, $options = [])
 * @method \App\Model\Entity\Profesor newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Profesor[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Profesor|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Profesor patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Profesor[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Profesor findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProfesorsTable extends Table
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

        $this->table('profesors');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

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
            ->allowEmpty('user_id');

        $validator
            ->allowEmpty('nacionalidad');

        $validator
            ->allowEmpty('numero_documento_identidad');

        $validator
            ->allowEmpty('titulo_universitario');

        $validator
            ->allowEmpty('direccion_habitacion');

        $validator
            ->allowEmpty('celular');

        $validator
            ->allowEmpty('telefono_fijo');

        $validator
            ->allowEmpty('correo_electronico');

        $validator
            ->allowEmpty('created');

        $validator
            ->allowEmpty('modified');

        return $validator;
    }
}
