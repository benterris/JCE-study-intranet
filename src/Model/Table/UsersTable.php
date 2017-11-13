<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 */
class UsersTable extends Table
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

        $this->table('users');
        $this->displayField('id');
        $this->primaryKey('id');
        
        $this->belongsTo('Highschool', [
            'className' => 'Users',
            'foreignKey' => 'user_id_highschool',
            'propertyName' => 'highschool',
            /*
            'dependent' => true,
            'cascadeCallbacks' => true,
             * 
             */
        ]);
        
        $this->belongsToMany('CandidatedInterventions', [
            'className' => 'Interventions',
            'through' => 'InterventionsCandidates',
            'foreignKey' => 'user_id_candidate',
            'targetForeignKey' => 'intervention_id'
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
            ->requirePresence('password', 'create')
            ->notEmpty('password');

        $validator
            ->notEmpty('role');

        $validator
            ->notEmpty('first_name');

        $validator
            ->notEmpty('last_name');

        $validator
            ->notEmpty('address');

        $validator
            ->email('email')
            ->notEmpty('email');

        $validator
            ->allowEmpty('phone_number');

        $validator
            ->date('birth_date')
            ->allowEmpty('birth_date');

        $validator
            ->allowEmpty('pole', function ($context) {
                if(isset($context['data']['role'])) {
                    return $context['data']['role'] != 'volunteer';
                }
                return true;
            });
        /*
        $validator
            ->allowEmpty('pole', function ($context) {
                if(isset($context['data']['role'])) {
                    return $context['data']['role'] != 'volunteer';
                }
                return true;
            });
         
        $validator
            ->allowEmpty('pole', function ($context) {
                if(isset($context['data']['role'])) {
                    return $context['data']['role'] != 'volunteer';
                }
                return true;
            });
         * 
         */

        $validator
            ->allowEmpty('desired_interventions');

        $validator
            ->allowEmpty('disponibilites');

        $validator
            ->allowEmpty('notes_admin');

        $validator
            ->boolean('tutor')
            ->allowEmpty('tutor');

        $validator
            ->boolean('membership_fee')
            ->allowEmpty('membership_fee');

        $validator
            ->boolean('code_ethics')
            ->allowEmpty('code_ethics');

        $validator
            ->allowEmpty('user_id_highschool', function ($context) {
                if(isset($context['data']['role'])) {
                    return $context['data']['role'] != 'teacher';
                }
                return true;
            });

        /*
        $validator
            ->integer('user_id_highschool')
            ->allowEmpty('user_id_highschool', function ($context) {
                if(isset($context['data']['role'])) {
                    return $context['data']['role'] != 'teacher';
                }
                return true;
            });
         * 
         */
        
        $validator
            ->allowEmpty('subject');
        
        /*
        
        $validator
            ->allowEmpty('pole', function ($context) {
                if(isset($context['data']['role'])) {
                    return $context['data']['role'] != 'volunteer';
                }
                return true;
            });
         * 
         */
         
            
        
        
        $validator
            ->allowEmpty('highschool_name', function ($context) {
                if(isset($context['data']['role'])) {
                    return $context['data']['role'] != 'highschool';
                }
                return true;
            });

        /*
            
        $validator
            ->allowEmpty('first_name_delegate', function ($context) {
                if(isset($context['data']['role'])) {
                    return $context['data']['role'] != 'highschool';
                }
                return true;
            });

        $validator
            ->allowEmpty('last_name_delegate', function ($context) {
                if(isset($context['data']['role'])) {
                    return $context['data']['role'] != 'highschool';
                }
                return true;
            });

        $validator
            ->allowEmpty('email_delegate', function ($context) {
                if(isset($context['data']['role'])) {
                    return $context['data']['role'] != 'highschool';
                }
                return true;
            });

        $validator
            ->allowEmpty('phone_number_delegate', function ($context) {
                if(isset($context['data']['role'])) {
                    return $context['data']['role'] != 'highschool';
                }
                return true;
            });
         * 
         */

        $validator
            ->allowEmpty('formation');

        return $validator;
    }

    /*
    
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('password', 'create')
            ->notEmpty('password');

        $validator
            ->notEmpty('role');

        $validator
            ->notEmpty('first_name');

        $validator
            ->notEmpty('last_name');

        $validator
            ->allowEmpty('address');

        $validator
            ->email('email')
            ->notEmpty('email');

        $validator
            ->allowEmpty('phone_number');

        $validator
            ->date('birth_date')
            ->allowEmpty('birth_date');

        $validator
            ->allowEmpty('occupation');

        $validator
            ->allowEmpty('company');

        $validator
            ->allowEmpty('professional_background');

        $validator
            ->allowEmpty('desired_interventions');

        $validator
            ->allowEmpty('disponibilites');

        $validator
            ->allowEmpty('notes_admin');

        $validator
            ->boolean('tutor')
            ->allowEmpty('tutor');

        $validator
            ->boolean('membership_fee')
            ->allowEmpty('membership_fee');

        $validator
            ->boolean('code_ethics')
            ->allowEmpty('code_ethics');

        $validator
            ->allowEmpty('subject');

        $validator
            ->integer('user_id_highschool')
            ->allowEmpty('user_id_highschool', function ($context) {
                if(isset($context['data']['role'])) {
                    return $context['data']['role'] != 'teacher';
                }
                return true;
            });
        
        
        $validator
            ->allowEmpty('pole', function ($context) {
                if(isset($context['data']['role'])) {
                    return $context['data']['role'] != 'volunteer';
                }
                return true;
            });
         
        
        
        $validator
            ->allowEmpty('highschool_name');

        $validator
            ->allowEmpty('first_name_delegate');

        $validator
            ->allowEmpty('last_name_delegate');

        $validator
            ->allowEmpty('email_delegate');

        $validator
            ->allowEmpty('phone_number_delegate');

        $validator
            ->allowEmpty('formation');

        return $validator;
    }
    
     */
    
    
    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['email']));
        return $rules;
    }
}
