<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Migracions Model
 *
 * @method \App\Model\Entity\Migracion get($primaryKey, $options = [])
 * @method \App\Model\Entity\Migracion newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Migracion[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Migracion|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Migracion patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Migracion[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Migracion findOrCreate($search, callable $callback = null)
 */
class MigracionsTable extends Table
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

        $this->table('migracions');
        $this->displayField('id');
        $this->primaryKey('id');
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
            ->allowEmpty('campo_1');

        $validator
            ->allowEmpty('campo_2');

        $validator
            ->allowEmpty('campo_3');

        $validator
            ->allowEmpty('campo_4');

        $validator
            ->allowEmpty('campo_5');

        $validator
            ->allowEmpty('campo_6');

        $validator
            ->allowEmpty('campo_7');

        $validator
            ->allowEmpty('campo_8');

        $validator
            ->allowEmpty('campo_9');

        $validator
            ->allowEmpty('campo_10');

        $validator
            ->allowEmpty('campo_11');

        $validator
            ->allowEmpty('campo_12');

        $validator
            ->allowEmpty('campo_13');

        $validator
            ->allowEmpty('campo_14');

        $validator
            ->allowEmpty('campo_15');

        $validator
            ->allowEmpty('campo_16');

        $validator
            ->allowEmpty('campo_17');

        $validator
            ->allowEmpty('campo_18');

        $validator
            ->allowEmpty('campo_19');

        $validator
            ->allowEmpty('campo_20');

        $validator
            ->allowEmpty('campo_21');

        $validator
            ->allowEmpty('campo_22');

        $validator
            ->allowEmpty('campo_23');

        $validator
            ->allowEmpty('campo_24');

        $validator
            ->allowEmpty('campo_25');

        $validator
            ->allowEmpty('campo_26');

        $validator
            ->allowEmpty('campo_27');

        $validator
            ->allowEmpty('campo_28');

        $validator
            ->allowEmpty('campo_29');

        $validator
            ->allowEmpty('campo_30');

        $validator
            ->allowEmpty('campo_31');

        $validator
            ->allowEmpty('campo_32');

        $validator
            ->allowEmpty('campo_33');

        $validator
            ->allowEmpty('campo_34');

        $validator
            ->allowEmpty('campo_35');

        $validator
            ->allowEmpty('campo_36');

        $validator
            ->allowEmpty('campo_37');

        $validator
            ->allowEmpty('campo_38');

        $validator
            ->allowEmpty('campo_39');

        $validator
            ->allowEmpty('campo_40');

        $validator
            ->allowEmpty('campo_41');

        $validator
            ->allowEmpty('campo_42');

        $validator
            ->allowEmpty('campo_43');

        $validator
            ->allowEmpty('campo_44');

        $validator
            ->allowEmpty('campo_45');

        $validator
            ->allowEmpty('campo_46');

        $validator
            ->allowEmpty('campo_47');

        $validator
            ->allowEmpty('campo_48');

        $validator
            ->allowEmpty('campo_49');

        $validator
            ->allowEmpty('campo_50');

        return $validator;
    }
}
