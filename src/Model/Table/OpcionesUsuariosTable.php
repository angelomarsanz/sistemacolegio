<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OpcionesUsuarios Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $Lapsos
 * @property \Cake\ORM\Association\BelongsTo $Materias
 * @property \Cake\ORM\Association\HasMany $RasgosPersonalidads
 *
 * @method \App\Model\Entity\OpcionesUsuario get($primaryKey, $options = [])
 * @method \App\Model\Entity\OpcionesUsuario newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OpcionesUsuario[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OpcionesUsuario|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OpcionesUsuario patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OpcionesUsuario[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OpcionesUsuario findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OpcionesUsuariosTable extends Table
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

        $this->table('opciones_usuarios');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Lapsos', [
            'foreignKey' => 'lapso_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Materias', [
            'foreignKey' => 'materia_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('RasgosPersonalidads', [
            'foreignKey' => 'opciones_usuario_id'
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
            ->allowEmpty('tipo_opcion');

        $validator
            ->allowEmpty('descripcion_opcion');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['lapso_id'], 'Lapsos'));
        $rules->add($rules->existsIn(['materia_id'], 'Materias'));

        return $rules;
    }
}
