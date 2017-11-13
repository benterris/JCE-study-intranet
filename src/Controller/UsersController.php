<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\I18n\Time;
use Cake\Routing\Router;
use Cake\Mailer\Email;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController{
    
    /*
     * Initialisation, and access authorizations
     */
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['add', 'logout','password','reset']);
        $loggedIn = $this->Auth->user();
        if($loggedIn){
            $this->set(compact('loggedIn'));
        }
        if(isset($loggedIn['role']))
        {
            $this->Auth->allow(['viewSelf','edit']);
            switch($loggedIn['role']){
            case 'teacher':
                if($loggedIn['active']===TRUE)
                {
                    $this->Auth->allow(['accueil', 'oldInterventionsTeacher', 'accueilProf', 'cancelAsk', 'view', 'viewSelf']);
                }
                else
                {
                    $this->Flash->error("Vous ne pouvez pas accéder à cette page, votre compte est en attente d'activation");
                }
            break;
            case 'volunteer':
                if($loggedIn['active']===TRUE)
                {
                    $this->Auth->allow(['accueil', 'accueilBenevoles', 'cancelCandidate', 'candidatedInterventions', 'oldInterventionsVolunteer', 'view', 'viewSelf']);
                }
                else
                {
                    $this->Flash->error("Vous ne pouvez pas accéder à cette page, votre compte est en attente d'activation");
                }
            break;
            case 'poleManager':
                if($loggedIn['active']===TRUE)
                {
                    $this->Auth->allow(['accueil','accueilRespoPole', 'oldInterventionsRespoPole', 'toAssignInterventions', 'toValidateInterventions', 'view', 'viewSelf']);
                }
                else
                {
                    $this->Flash->error("Vous ne pouvez pas accéder à cette page, votre compte est en attente d'activation");
                }
            break;
            case 'highschool':
                if($loggedIn['active']===TRUE)
                {
                    $this->Auth->allow(['accueil','accueilLycees','listTeachersHighschool','oldInterventionsHighschool', 'view', 'viewSelf']);
                }
                else
                {
                    $this->Flash->error("Vous ne pouvez pas accéder à cette page, votre compte est en attente d'activation");
                }
            break;
            case 'admin':
                if($loggedIn['active']===TRUE)
                {
                    $this->Auth->allow();
                    //$this->Auth->allow(['accueil','viewUserAdmin','accueilAdmin','listBenevoles','listProfesseurs','listLycees','add','edit','delete','validateUser','adminValidateUser','adminAdd']);
                }
                else    
                {
                    $this->Flash->error("Vous ne pouvez pas accéder à cette page, votre compte est en attente d'activation");
                }
            break;
	}
        }
    }
    
    public function isAuthorized($user)
    {
       return parent::isAuthorized($user);
    }
    
    public function login()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error("Mauvaise combinaison d'e-mail / password");
        }
        
    }
    
    
    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $users = $this->paginate($this->Users);
        $user = $this->Auth->user();
        
        
        //$this->Flash->success($a);

        $this->set(compact('users', 'user'));
        $this->set('_serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Highschool']
        ]);

        $this->set('user', $user);
        $this->set('_serialize', ['user']);
        
    }
    
    /*
     * To see your own details
     */
    public function viewSelf()
    {
        $loggedIn = $this->Auth->user();
        
        $user = $this->Users->get($loggedIn['id'], [
            'contain' => ['Highschool']
        ]);

        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }
    
    /*
     * See full user details (for admin)
     */
    public function viewUserAdmin($id = null)
    {
        
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        
        if($user->role == 'teacher'){
            $user = $this->Users->get($id, ['contain' => 'Highschool']);
        }
        
        $this->set('user', $user);
        $this->set('_serialize', ['user']);
        
    }
    
    public function accueilBenevoles()
    {
        $loggedIn = $this->Auth->user();
        $id = $loggedIn['id'];
        $interventionsTable = TableRegistry::get('Interventions');
        
        //Interventions validées
        $query1 = $interventionsTable->find('all', ['contain' => ['Teacher.Highschool', 'Candidates', 'Volunteer', 'InterventionsCandidates'], 'order' => ['type_intervention' => 'ASC']]);
        $query1->matching('Candidates', function ($q) use ($id) { //necessaire pour forcer le join sur Candidates ?
            return $q->where(['Candidates.id' => $id]);
        });
        $query1->where(['Volunteer.id' => $loggedIn['id'], 'status' => 2, 'date >' => Time::now('Europe/Paris')]);
        
        //Interventions candidatées
        $query2 = $interventionsTable->find('all', ['contain' => ['Teacher.Highschool', 'Candidates', 'Volunteer', 'InterventionsCandidates']]);
        $query2->matching('Candidates', function ($q) use ($id) {
            return $q->where(['Candidates.id' => $id]);
        })
            ->where(['status' => 1]);
        
        
        
        
        
        $query2->union($query1);
        
        $query2->order(['type_intervention' => 'ASC']);
        
        $interventionsCandidatedAndApproved = $this->paginate($query2);
        
        //recupérer la date candidatée :
        $ICTable = TableRegistry::get('InterventionsCandidates');
        
        foreach ($interventionsCandidatedAndApproved as $interv) {
            $query = $ICTable->find('all')
                    ->where(['user_id_candidate' => $id, 'intervention_id' => $interv->id]); //Il ne doit y avoir qu'un record de ce type
            $linkData = $query->toArray();
            $interv['date_display'] = $linkData[0]['date_candidate'];
        }
        
        
        
        //Nouvelles interventions
        $query3 = $interventionsTable->find('all', ['contain' => ['Teacher.Highschool', 'Candidates'], 'order' => ['asked' => 'ASC']])
                ->where(['status' => 1, 'Interventions.pole' => $loggedIn['pole']])
                ->notMatching('Candidates', function ($q) use ($id) {
            return $q->where(['Candidates.id' => $id]);
        });
        $interventionsNew = $this->paginate($query3);
        
        //Responsables de pôle (pour contact)
        $query4 = $this->Users->find('all')
                ->where(['role' => 'poleManager', 'poleManaged' => $loggedIn['pole']]);
        
        $resposPole = $this->paginate($query4);
        
        
        $this->set(compact('interventionsCandidatedAndApproved', 'interventionsNew', 'resposPole'));
        $this->set('_serialize', ['user']);
        
    }
    
    /*
     * Interventions history for volunteers
     */
    public function oldInterventionsVolunteer()
    {
        $loggedIn = $this->Auth->user();
        $interventionsTable = TableRegistry::get('Interventions');
        $query = $interventionsTable->find('all', ['contain' => ['Teacher.Highschool', 'Volunteer'], 'order' => ['date' => 'ASC']])
                ->where(['status' => 2, 'date <' => Time::now('Europe/Paris'), 'Volunteer.id' => $loggedIn['id']]);
        
        $interventions = $this->paginate($query);
        
        $this->set(compact('interventions'));
        $this->set('_serialize', ['interventions']);
    }
    
    /*
     * Interventions history for teacher
     */
    public function oldInterventionsTeacher()
    {
        $loggedIn = $this->Auth->user();
        $interventionsTable = TableRegistry::get('Interventions');
        $query = $interventionsTable->find('all', ['contain' => ['Teacher.Highschool'], 'order' => ['date' => 'ASC']])
                ->where(['Teacher.id' => $loggedIn['id'], 'status' => 2, 'date <' => Time::now('Europe/Paris')]);
        
        $interventions = $this->paginate($query);
        
        $this->set(compact('interventions'));
        $this->set('_serialize', ['interventions']);
    }
    
    public function accueilLycees()
    {
        
        $loggedIn = $this->Auth->user();
        $interventionsTable = TableRegistry::get('Interventions');
        $query = $interventionsTable->find('all', ['contain' => 'Teacher.Highschool', 'order' => ['date' => 'ASC']])
                ->where(['Highschool.id' => $loggedIn['id'], 'status' => 2, 'date >' => Time::now('Europe/Paris')]);
        
        
        
        $interventions = $this->paginate($query);
        $this->set(compact('interventions'));
        $this->set('_serialize', ['user']); 
        
    }
    
    public function accueilProf()
    {
        $loggedIn = $this->Auth->user();
        $interventionsTable = TableRegistry::get('Interventions');
        
        $query1 = $interventionsTable->find('all', ['contain' => 'Teacher.Highschool', 'order' => ['asked' => 'ASC']])
                ->where(['Teacher.id' => $loggedIn['id'], 'status' => 0]);
        $interventionsNotValidated = $this->paginate($query1);
        
        $query2 = $interventionsTable->find('all', ['contain' => 'Teacher.Highschool', 'order' => ['asked' => 'ASC']])
                ->where(['Teacher.id' => $loggedIn['id'], 'status' => 1]);
        $interventionsNotAssigned = $this->paginate($query2);
        
        $query3 = $interventionsTable->find('all', ['contain' => 'Teacher.Highschool', 'order' => ['date' => 'ASC']])
                ->where(['Teacher.id' => $loggedIn['id'], 'status' => 2, 'date >' => Time::now('Europe/Paris')]);
        $interventionsPlanned = $this->paginate($query3);
        
        /*
        $query3 = $interventionsTable->find('all', ['contain' => 'Teacher.Highschool'])
                ->where(['Teacher.id' => $loggedIn['id'], 'status' => 1, 'date <' => Time::now('Europe/Paris')]);
        $interventionsPlanned = $this->paginate($query3);
         * 
         */
        
        
        
        $this->set(compact('interventionsNotValidated', 'interventionsNotAssigned', 'interventionsPlanned'));
        $this->set('_serialize', ['user']); 
    }
    
    public function accueilAdmin()
    {
        $loggedIn = $this->Auth->user();
        
        $interventionsTable = TableRegistry::get('Interventions');
        
        $query = $interventionsTable->find('all', ['contain' => ['Teacher.Highschool', 'Candidates'],  'order' => ['date' => 'ASC']]);
                
        $interventions = $this->paginate($query);
        
        
        $this->set(compact('interventions', 'loggedIn'));
        $this->set('_serialize', ['interventions']);
        
    }
    
    public function accueilRespoPole()
    {
        $loggedIn = $this->Auth->user();
        
        $interventionsTable = TableRegistry::get('Interventions');
        
        $query = $interventionsTable->find('all', ['contain' => ['Teacher.Highschool', 'Candidates'],  'order' => ['date' => 'ASC']])
               ->where(['Interventions.pole' => $loggedIn['poleManaged'], 'status' => '2', 'date >' => Time::now('Europe/Paris')]);
                
        $interventions = $this->paginate($query);
        
        
        $this->set(compact('interventions', 'loggedIn'));
        $this->set('_serialize', ['interventions']);
    }
    
    /*
     * Function to redirect user towards the right accueil, according to his role
     */
    public function accueil()
    {
        $this->autoRender = false;
        $loggedIn = $this->Auth->user();
        if($loggedIn){
            if($loggedIn['role'] == 'volunteer'){
                $this->redirect('/users/accueil_benevoles');
            }
            elseif($loggedIn['role'] == 'highschool'){
                $this->redirect('/users/accueil_lycees');
            }
            elseif($loggedIn['role'] == 'teacher'){
                $this->redirect('/users/accueil_prof');
            }
            elseif($loggedIn['role'] == 'poleManager'){
                $this->redirect('/users/accueil_respo_pole');
            }
            elseif($loggedIn['role'] == 'admin'){
                $this->redirect('/users/accueil_admin');
            }
        }
        else{
            $this->Flash->error('No user logged in');
        }
        
    }
    
    /*
     * See the list of volunteers, for admin
     */
    public function listBenevoles()
    {
        
        
        $query = $this->Users->find('all')
                ->where(['role' => 'volunteer']);
        
        $users = $this->paginate($query);
        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
        
    }
    
    /*
     * See the list of pole managers, for admin
     */
    public function listResposPole()
    {
        
        
        $query = $this->Users->find('all')
                ->where(['role' => 'poleManager']);
        
        $users = $this->paginate($query);
        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
        
    }
    
    /*
     * See the list of teachers, for admin
     */
    public function listProfesseurs()
    {
        
        
        $query = $this->Users->find('all')
                ->where(['role' => 'teacher']);
        
        $users = $this->paginate($query);
        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }
    
    /*
     * See the list of highschools, for admin
     */
    public function listLycees()
    {
        
        
        $query = $this->Users->find('all')
                ->where(['role' => 'highschool']);
        
        $users = $this->paginate($query);
        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
        
    }
    
    /*
     * See the list of teachers within a highschool, for this highschool
     */
    public function listTeachersHighschool()
    {
        $loggedIn = $this->Auth->user();
        $query = $this->Users->find('all', ['contain' => 'Highschool'])
                ->where(['Users.role' => 'teacher', 'Highschool.id' => $loggedIn['id']]);
        $users = $this->paginate($query);
        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }
    
    
    /*
     * See the interventions a volunteer candidated to (unused but functionnal, may be reintroduced if necessary)
     */
    public function candidatedInterventions()
    {
        $loggedIn = $this->Auth->user();
        $id = $loggedIn['id'];
        
        $interventionsTable = TableRegistry::get('Interventions');
        $query = $interventionsTable->find('all', ['contain' => ['Teacher.Highschool', 'Candidates'], 'order' => ['asked' => 'ASC']]);
        $query->matching('Candidates', function ($q) use ($id) {
            return $q->where(['Candidates.id' => $id]);
        });
        
        $interventions = $this->paginate($query);
        
        $this->set(compact('interventions'));
        $this->set('_serialize', ['interventions']);
    }
    
    /*
     * See the interventions with candidates waiting, for pole manager (and admin)
     */
    public function toAssignInterventions()
    {
        $loggedIn = $this->Auth->user();
        $id = $loggedIn['id'];
        
        $interventionsTable = TableRegistry::get('Interventions');
        $query = $interventionsTable->find('all', ['contain' => ['Teacher.Highschool', 'Candidates'], 'order' => ['asked' => 'ASC']]);
        if($loggedIn['role']==='admin')
        {
            $query->where(['status' => 1]);
        }
        else
        {
            $query->where(['status' => 1, 'Interventions.pole' => $loggedIn['poleManaged']]);
        }
        
        $interventions = $this->paginate($query);
        
        //récupérer le nombre de candidats
        
        foreach ($interventions as $interv) {
            
            $query2 = $this->Users->find('all', ['contain' => 'CandidatedInterventions'])
                    ->matching('CandidatedInterventions', function ($q) use ($interv) {
                        return $q->where(['CandidatedInterventions.id' => $interv['id']]);
                    });
            $count = $query2->count();
            $interv['count'] = $count;
        }
        
        
        $this->set(compact('interventions'));
        $this->set('_serialize', ['interventions']);
    }
    
    /*
     * See the interventions to be validated, for pole manager (and admin)
     */
    public function toValidateInterventions()
    {
        $loggedIn = $this->Auth->user();
        
        $interventionsTable = TableRegistry::get('Interventions');
        $query = $interventionsTable->find('all', ['contain' => ['Teacher.Highschool', 'Candidates'], 'order' => ['asked' => 'ASC']]);
        if($loggedIn['role']==='admin')
        {
            $query->where(['status' => 0]);
        }
        else
        {
            $query->where(['status' => 0, 'Interventions.pole' => $loggedIn['poleManaged']]);
        }
        $interventions = $this->paginate($query);
        
        
        $this->set(compact('interventions', 'loggedIn'));
        $this->set('_serialize', ['interventions']);
    }
    
    
    /*
     * See the intervention history, for highschool
     */
    public function oldInterventionsHighschool()
    {
        $loggedIn = $this->Auth->user();
        $id = $loggedIn['id'];
        
        $interventionsTable = TableRegistry::get('Interventions');
        $query = $interventionsTable->find('all', ['contain' => ['Teacher.Highschool', 'Candidates'], 'order' => ['date' => 'ASC']]);
        $query->matching('Teacher.Highschool', function ($q) use ($id) {
            return $q->where(['Highschool.id' => $id]);
        })
            ->where(['date <' => Time::now('Europe/Paris')]);
        
        
        $interventions = $this->paginate($query);
        
        $this->set(compact('interventions'));
        $this->set('_serialize', ['interventions']);
    }
    
    /*
     * See the intervention history, for pole manager
     */
    public function oldInterventionsRespoPole()
    {
        $loggedIn = $this->Auth->user();
        $id = $loggedIn['id'];
        
        $interventionsTable = TableRegistry::get('Interventions');
        $query = $interventionsTable->find('all', ['contain' => ['Teacher.Highschool', 'Candidates'], 'order' => ['date' => 'ASC']]);
        $query->where(['date <' => Time::now('Europe/Paris'), 'Interventions.pole' => $loggedIn['poleManaged']]);
        
        
        $interventions = $this->paginate($query);
        
        $this->set(compact('interventions'));
        $this->set('_serialize', ['interventions']);
    }
    
    /*
     * Function that deals with volunteer proposing themselves as candidates
     
    public function candidate($id = null)
    {
        $loggedIn = $this->Auth->user();
        $ICTable = TableRegistry::get('InterventionsCandidates');
        $query = $ICTable->query();
        $query->insert(['intervention_id', 'candidate_id'])
                ->values(['intervention_id' => $id, 'candidate_id' => $loggedIn['id']])
                ->execute();
        
        $this->Flash->success($loggedIn['id'] . ' user | interv ' . $id);
        $this->redirect('/users/accueil');
    }
    */
    
    /*
     * Function to remove its candidature, for volunteer
     */
    public function cancelCandidate($id = null)
    {
        $loggedIn = $this->Auth->user();
        $ICTable = TableRegistry::get('InterventionsCandidates');
        $query = $ICTable->query();
        $query->delete()
            ->where(['user_id_candidate' => $loggedIn['id'], 'intervention_id' => $id])
            ->execute();
        $this->Flash->success("Vous avez retiré votre candidature pour cette intervention");
        $this->redirect(['action' => 'accueil']);
    }
    
    /*
     * Function to remove the ask of an intervention, for a teacher
     */
    public function cancelAsk($id = null)
    {
        $interventionsTable = TableRegistry::get('Interventions');
        $intervention = $interventionsTable->get($id);
        if($interventionsTable->delete($intervention)) {
            $this->Flash->success("La demande d'intervention a bien été supprimée.");
            return $this->redirect(['controller' => 'Users', 'action' => 'accueil']);
        }
        $this->Flash->error("La demande n'a pas pu être supprimée ; veuillez réessayer plus tard.");
        $this->redirect(['controller' => 'Users', 'action' => 'accueil']);
    }
    
    /*
     * See the interventions needing candidates (unused but functionnal, may be reintroduced if necessary)
     */
    public function newInterventions() {
        
        
        $interventionsTable = TableRegistry::get('Interventions');
        $query = $interventionsTable->find('all', ['contain' => 'Teacher.Highschool'])
                ->where(['status' => 1]);
        $interventions = $this->paginate($query);
        $this->set(compact('interventions'));
        $this->set('_serialize', ['interventions']);
    }
    
    /**
     * Function that adds users
     *
     */
    public function add()
    {
        $user = $this->Users->newEntity();        
        if ($this->request->is('post')) {
            if($this->verifyRecatpcha($this->request->data))
            {
                $user = $this->Users->patchEntity($user, $this->request->data);
                $user->active = 0;
                
                if ($this->Users->save($user)) {
                    $this->Flash->success(__("Vous avez envoyé une demande de création de compte."));
                    $mail = "Nouvelle demande de validation de compte :\nNom : " . $user->last_name . "\nPrénom : " . $user->first_name . "\nConnectez-vous sur le site pour valider la demande.";
                    
                    $query = $this->Users->find('all')->where(['role' => 'admin']);
                    $admins = $query->toArray();
                    foreach ($admins as $admin) {
                        $this->sendMail($admin->email, "Nouvelle demande de validation de compte", $mail);
                    }
                    
                    $this->sendMail($user->email, "Demande de création de compte enregistrée",
                                "Bonjour, \nVotre demande de création de compte a bien été enregistrée. Vous recevrez un mail lorsque votre compte aura été validé par un administrateur.\nMerci pour votre engagement !\nL'équipe **association name**");
                    
                    return $this->redirect(['action' => 'login']);
                }
                $this->Flash->error("L'utilisateur n'a pas pu être enregistré : veuillez corriger les données ci-dessous");
            }
            else{
                $this->Flash->error('Captcha invalide : veuillez cocher la case "Je ne suis pas un robot"');
            }
        }
        
        
        $query = $this->Users->find('list', [
            'keyField' => 'id', 
            'valueField' => function ($highschool) {
                return $highschool->get('label');
            }])
                ->where(['role' => 'highschool']);
        //$query = $this->Users->find('all')->where(['role' => 'highschool']);
        
        $highschools = $query->toArray();
        
        $this->set(compact('user', 'highschools'));
        $this->set('_serialize', ['user']);
    }
    
    /*
     * Function that adds users, specific for the admin (allows the creation of pole managers)
     */
    public function adminAdd()
    {
        $user = $this->Users->newEntity();        
        if ($this->request->is('post')) {

            $user = $this->Users->patchEntity($user, $this->request->data);
            $user->active = 1;
            if ($this->Users->save($user)) {
                $this->Flash->success(__("Le nouveau compte a bien été enregistré et activé."));
                return $this->redirect(['action' => 'accueil']);
            }
            $this->Flash->error("L'utilisateur n'a pas pu être enregistré : veuillez corriger les données ci-dessous");
        }
        
        
        $query = $this->Users->find('list', [
            'keyField' => 'id', 
            'valueField' => function ($highschool) {
                return $highschool->get('label');
            }])
                ->where(['role' => 'highschool']);
        $highschools = $query->toArray();
        
        $this->set(compact('user', 'highschools'));
        $this->set('_serialize', ['user']);
    }
    

    /**
     * Function to edit users
     *
     */
    public function edit()
    {
        $loggedIn = $this->Auth->user();
        $user = $this->Users->get($loggedIn['id'], [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__("L'utilisateur n'a pas pu être enregistré."));
        }
        $query = $this->Users->find('list', ['keyField' => 'id', 'valueField' => 'highschool_name'])->where(['role' => 'highschool']);
        $highschools = $query->toArray();
        
        $this->set(compact('user','highschools'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Function to delete users
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        
        
        $interventionsTable = TableRegistry::get('Interventions');
        $ICTable = TableRegistry::get('InterventionsCandidates');
        
        //$query1 = $interventionsTable->find('all', ['contain' => ['Teacher.Highschool', 'Volunteer', 'InterventionsCandidates']]);
        
        
        
        
        if($user->role == 'highschool') {
            $query2 = $this->Users->query();
            $query2->delete()
                    ->where(['role' => 'teacher', 'user_id_highschool' => $id])
                    ->execute();
        }
        
        $query3 = $ICTable->query();
        $query3->delete()
                ->where(['user_id_candidate' => $id])
                ->execute();
        
        $query1 = $interventionsTable->query();
        $query1->delete()
               ->where(['user_id_teacher' => $id])
               ->orWhere(['user_id_volunteer' => $id])
               ->execute();
        
        if ($this->Users->delete($user)) {
            $this->Flash->success(__("L'utilisateur a été supprimé"));
        } else {
            $this->Flash->error(__("L'utilisateur n'a pas pu être supprimé. Veuillez essayer à nouveau."));
        }

        return $this->redirect(['controller' => 'users', 'action' => 'accueil']);
    }
    
    /*
     * Function to display the accounts to be validated, for admin
     */
    public function adminValidateUsers() {
        $loggedIn = $this->Auth->user();
        $query = $this->Users->find('all')
                ->where(['active' => 0]);
        $users = $this->paginate($query);

        $this->set(compact('users', 'loggedIn'));
        $this->set('_serialize', ['users']);
    }
    
    /*
     * Logic of user validation (called when admin validates accounts)
     */
    public function validateUser($id = null) {
        $this->autoRender = false;
        
        $user = $this->Users->get($id);
        
        $user->active = 1;
        
        if($this->Users->save($user)){
            $this->Flash->success("Le compte de " . $user->first_name . " " . $user->last_name . " a bien été validé.");
            $this->sendMail($user->email, "Votre compte a été activé",
                                "Bonjour, \nVotre demande de création de compte a été acceptée par un administrateur. Vous pouvez désormais vous connecter en utilisant votre identifiant et votre mot de passe.\nMerci pour votre engagement !\nL'équipe **association name**");
            return $this->redirect(['controller' => 'users', 'action' => 'adminValidateUsers']);
        }
        
        $this->Flash->error("Le compte n'a pas pu être supprimé. Veuillez essayer à nouveau.");
        return $this->redirect(['controller' => 'users', 'action' => 'adminValidateUsers']);
    }
    
    /*
     * Function to change password 
     */
    public function password()
    {
        if ($this->request->is('post')) {
            $query = $this->Users->findByEmail($this->request->data['email']);
            $user = $query->first();
            if (is_null($user)) {
                $this->Flash->error('L\'adresse mail fournie n\'as pas été trouvée sur notre site' );
            } else {
                $passkey = uniqid();
                $url = Router::Url(['controller' => 'users', 'action' => 'reset'], true) . '/' . $passkey;
                $timeout = time() + DAY;
                 if ($this->Users->updateAll(['passkey' => $passkey, 'timeout' => $timeout], ['id' => $user->id])){
                    $this->sendResetEmail($url, $user);
                    $this->redirect(['action' => 'login']);
                } else {
                    $this->Flash->error('Error saving reset passkey/timeout');
                }
            }
        }
    }

    /*
     * Function to send the password reset email
     */
    public function sendResetEmail($url, $user)
    {
        Email::config('default');
        $email = new Email('default');
        $email->emailFormat('both');
        $email->to($user->email);
        $email->subject('Mettre à jour votre mot de passe');
        $message = 'Vous avez demandé un chagement de mot de passe sur le site de l\'association XXX. <br>'
                . '- Si cette demande ne provient pas de vous, ne faites rien. <br>'
                . '- Si vous souhaitez réinitialiser votre mot de passe cliquez sur le lien ci dessous : <br> '
                . '';
        try{
            $email->send($message.$url);
            $this->Flash->success('Vérifiez vos mails, un lien de mise à jour du mot de passe vous a été envoyé');
        } catch (Exception $ex) {
            $this->Flash->error('Erreur lors de l\'envoi du mail: ' . $email->smtpError);
        }
        /*
        if ($email->send($message.$url)) {
            $this->Flash->success('Vérifiez vos mails, un lien de mise à jour du mot de passe vous a été envoyé');
        } else {
            $this->Flash->error('Erreur lors de l\'envoi du mail: ' . $email->smtpError);
        }*/
    }
    
    /*
     * Logic to reset password
     */
    public function reset($passkey = null) {
        if ($passkey) {
            $query = $this->Users->find('all', ['conditions' => ['passkey' => $passkey, 'timeout >' => time()]]);
            $user = $query->first();
            if ($user) {
                if (!empty($this->request->data)) {
                    // Clear passkey and timeout
                    $this->request->data['passkey'] = null;
                    $this->request->data['timeout'] = null;
                    $user = $this->Users->patchEntity($user, $this->request->data);
                    if ($this->Users->save($user)) {
                        $this->Flash->set('Votre mot de passe a été mis à jour.');
                        return $this->redirect(array('action' => 'login'));
                    } else {
                        $this->Flash->error('Le mot de passe n\'as pas pu être mis à jour, réessayez.');
                    }
                }
            } else {
                $this->Flash->error('Passkey invalide, vérifiez vos emails ou réessayez');
                $this->redirect(['action' => 'password']);
            }
            unset($user->password);
            $this->set(compact('user'));
        } else {
            $this->redirect('/');
        }
    }
    
    /*
     * Generic mail sending function
     */
    public function sendMail($to, $subject, $message){
        Email::config('default');
        $email = new Email('default');
        //TODO : uncomment next lines
        $message = $message . "\n\nCeci est un mail automatique, merci de ne pas répondre. Si vous avez une question, merci de contacter contact@XXX-asso.fr";
        try {
            $email->to($to)
                ->subject($subject)
                ->send($message);
        } catch (\Exception $e) {
            $this->Flash->error("L'adresse email non valide");
        }
        //$this->Flash->success("Un mail récapitulatif a été envoyé à l'adresse : ". $to);
    }
    
}
