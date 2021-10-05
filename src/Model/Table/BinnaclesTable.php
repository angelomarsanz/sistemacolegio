<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Binnacles Model
 *
 * @method \App\Model\Entity\Binnacle get($primaryKey, $options = [])
 * @method \App\Model\Entity\Binnacle newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Binnacle[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Binnacle|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Binnacle patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Binnacle[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Binnacle findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BinnaclesTable extends Table
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

        $this->table('binnacles');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->allowEmpty('novelty');

        $validator
            ->allowEmpty('type_class');

        $validator
            ->allowEmpty('class_name');

        $validator
            ->allowEmpty('method_name');

        $validator
            ->allowEmpty('extra_column1');

        $validator
            ->allowEmpty('extra_column2');

        $validator
            ->allowEmpty('extra_column3');

        $validator
            ->allowEmpty('extra_column4');

        $validator
            ->allowEmpty('extra_column5');

        $validator
            ->allowEmpty('extra_column6');

        $validator
            ->allowEmpty('extra_column7');

        $validator
            ->allowEmpty('extra_column8');

        $validator
            ->allowEmpty('extra_column9');

        $validator
            ->allowEmpty('extra_column10');

        $validator
            ->allowEmpty('columna_extra11');

        $validator
            ->allowEmpty('columna_extra12');

        $validator
            ->allowEmpty('columna_extra13');

        $validator
            ->allowEmpty('columna_extra14');

        $validator
            ->allowEmpty('columna_extra15');

        $validator
            ->allowEmpty('columna_extra16');

        $validator
            ->allowEmpty('columna_extra17');

        $validator
            ->allowEmpty('columna_extra18');

        $validator
            ->allowEmpty('columna_extra19');

        $validator
            ->allowEmpty('columna_extra20');

        $validator
            ->allowEmpty('columna_extra21');

        $validator
            ->allowEmpty('columna_extra22');

        $validator
            ->allowEmpty('columna_extra23');

        $validator
            ->allowEmpty('columna_extra24');

        $validator
            ->allowEmpty('columna_extra25');

        $validator
            ->allowEmpty('columna_extra26');

        $validator
            ->allowEmpty('columna_extra27');

        $validator
            ->allowEmpty('columna_extra28');

        $validator
            ->allowEmpty('columna_extra29');

        $validator
            ->allowEmpty('columna_extra30');

        $validator
            ->allowEmpty('registration_status');

        $validator
            ->allowEmpty('reason_status');

        $validator
            ->dateTime('date_status')
            ->allowEmpty('date_status');

        $validator
            ->allowEmpty('responsible_user');

        return $validator;
    }
}
