<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * InterventionsCandidates Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Interventions
 * @property \Cake\ORM\Association\BelongsTo $Candidates
 *
 * @method \App\Model\Entity\InterventionsCandidate get($primaryKey, $options = [])
 * @method \App\Model\Entity\InterventionsCandidate newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\InterventionsCandidate[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\InterventionsCandidate|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\InterventionsCandidate patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\InterventionsCandidate[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\InterventionsCandidate findOrCreate($search, callable $callback = null, $options = [])
 */
class InterventionsCandidatesTable extends Table
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

        $this->table('interventions_candidates');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Interventions', [
            'foreignKey' => 'intervention_id'
        ]);
        $this->belongsTo('Candidates', [
            'classname' => 'Users',
            'foreignKey' => 'user_id_candidate'
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
            ->datetime('date_candidate', 'create')
            ->requirePresence('date_candidate');

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
        $rules->add($rules->existsIn(['intervention_id'], 'Interventions'));
        $rules->add($rules->existsIn(['user_id_candidate'], 'Candidates'));

        return $rules;
    }
      */
    
}
