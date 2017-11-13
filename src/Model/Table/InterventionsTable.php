<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;



/**
 * Interventions Model
 *
 * 
 *
 * @method \App\Model\Entity\Intervention get($primaryKey, $options = [])
 * @method \App\Model\Entity\Intervention newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Intervention[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Intervention|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Intervention patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Intervention[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Intervention findOrCreate($search, callable $callback = null, $options = [])
 */
class InterventionsTable extends Table
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

        $this->table('interventions');
        $this->displayField('id');
        $this->primaryKey('id');
        /*
        $this->belongsTo('Users', [
            'classname' => 'Teacher'
        ])->foreignKey('user_id_teacher'); 
         * 
         */
        $this->belongsTo('Teacher', [
            'className' => 'Users',
            'foreignKey' => 'user_id_teacher',
            'propertyName' => 'teacher',
            /*
            'dependent' => true,
            'cascadeCallbacks' => true,
             * 
             */
        ]);
        
        $this->belongsTo('Volunteer', [
            'className' => 'Users',
            'foreignKey' => 'user_id_volunteer',
            'propertyName' => 'volunteer',
            /*
            'dependent' => true,
            'cascadeCallbacks' => true,
             * 
             */
        ]);
        
        $this->belongsToMany('Candidates', [
            'className' => 'Users',
            'through' => 'InterventionsCandidates',
            'foreignKey' => 'intervention_id',
            'targetForeignKey' => 'user_id_candidate'
        ]);
        
        $this->hasMany('InterventionsCandidates',[
            'foreignKey' => 'intervention_id'
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
            ->integer('user_id_volunteer')
            ->allowEmpty('user_id_volunteer');

        $validator
            ->integer('user_id_highschool')
            ->allowEmpty('user_id_highschool');

        $validator
            ->integer('user_id_teacher')
            ->allowEmpty('user_id_teacher');

        $validator
            ->allowEmpty('pole');

        $validator
            ->allowEmpty('type_intervention');

        $validator
            ->allowEmpty('possible_dates');

        $validator
            ->allowEmpty('length_intervention');

        $validator
            ->allowEmpty('feedback_prof');

        $validator
            ->allowEmpty('feedback_intervenant');
        
        
        $validator
            ->integer('status')
            ->allowEmpty('status');

        return $validator;
    }
    
    public function validationAssign()
    {
        $validator = new Validator();
        
        $validator->notEmpty('user_id_volunteer')
                ->requirePresence('user_id_volunteer');
        
        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     
    public function buildRules(RulesChecker $rules)
    {
        $rules = null;
        return $rules;
    }
     * 
     */
}
