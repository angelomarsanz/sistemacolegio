<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Positions Model
 *
 * @property \Cake\ORM\Association\HasMany $Employees
 *
 * @method \App\Model\Entity\Position get($primaryKey, $options = [])
 * @method \App\Model\Entity\Position newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Position[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Position|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Position patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Position[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Position findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PositionsTable extends Table
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

        $this->table('positions');
        $this->displayField('position');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Employees', [
            'foreignKey' => 'position_id'
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
            ->requirePresence('position', 'create')
            ->notEmpty('position');

        $validator
            ->requirePresence('short_name', 'create')
            ->notEmpty('short_name');

        $validator
            ->requirePresence('type_of_salary', 'create')
            ->notEmpty('type_of_salary');

        $validator
            ->numeric('minimum_wage')
            ->requirePresence('minimum_wage', 'create')
            ->notEmpty('minimum_wage');

        $validator
            ->allowEmpty('reason_salary_increase');

        $validator
            ->date('effective_date_increase')
            ->allowEmpty('effective_date_increase');

        $validator
            ->allowEmpty('registration_status');

        $validator
            ->allowEmpty('reason_status');
			
        $validator
            ->date('date_status')
            ->allowEmpty('date_status');
			
        $validator
            ->allowEmpty('responsible_user');

        return $validator;
    }
}
