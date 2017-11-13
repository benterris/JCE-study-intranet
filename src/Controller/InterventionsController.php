<?php
namespace App\Controller;


use App\Controller\AppController;
use Cake\Mailer\Email;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
/**
 * Interventions Controller
 *
 * @property \App\Model\Table\InterventionsTable $Interventions
 */
class InterventionsController extends AppController
{
    /*
     * Initialisation, and access authorizations
     */
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $loggedIn = $this->Auth->user();
        if($loggedIn){
            $this->set(compact('loggedIn'));
        }
        switch($loggedIn['role']){
            case 'teacher':
                if($loggedIn['active']===TRUE)
                {
                    $this->Auth->allow(['ask', 'viewAskedTeacher', 'viewCompletedTeacher','viewFinal']);
                }
                else
                {
                    $this->Flash->error("Vous ne pouvez pas accéder à cette page, votre compte est en attente d'activation");
                }
            break;
            case 'volunteer':
                if($loggedIn['active']===TRUE)
                {
                    $this->Auth->allow(['viewCandidate','viewCompletedVolunteer','viewNew', 'viewFinal']);
                }
                else
                {
                    $this->Flash->error("Vous ne pouvez pas accéder à cette page, votre compte est en attente d'activation");
                }
            break;
            case 'poleManager':
                if($loggedIn['active']===TRUE)
                {
                    $this->Auth->allow(['assign','viewFinal','viewFinalWithFeedback','viewValidate']);
                }
                else
                {
                    $this->Flash->error("Vous ne pouvez pas accéder à cette page, votre compte est en attente d'activation");
                }
            break;
            case 'highschool':
                if($loggedIn['active']===TRUE)
                {
                    $this->Auth->allow(['viewFinal']);
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
                }
                else 
                {
                    $this->Flash->error("Vous ne pouvez pas accéder à cette page, votre compte est en attente d'activation");
                }
            break;
	}
    }

    /**
     * Index method (access to a functionnal page, unnecessary for daily use)
     */
    public function index()
    {
        
        $interventions = $this->paginate($this->Interventions);

        $this->set(compact('interventions'));
        $this->set('_serialize', ['interventions']);
    }

    /**
     * Basic view method
     */
    public function view($id = null)
    {
        
        $intervention = $this->Interventions->get($id);

        $this->set('intervention', $intervention);
        $this->set('_serialize', ['intervention']);
    }
    
    /*
     * View a candidated intervention waiting for affectation, for volunteer. Allows cancelling of candidature.
     */
    public function viewCandidate($id = null)
    {
        $loggedIn = $this->Auth->user();
        
        $intervention = $this->Interventions->get($id, ['contain' => 'Teacher.Highschool']);
        //$intervention->length_intervention = $intervention->length_intervention->i18nFormat([\IntlDateFormatter::NONE, \IntlDateFormatter::SHORT]);
        
        //récupérer la date candidatée
        $ICTable = TableRegistry::get('InterventionsCandidates');
        
        $query = $ICTable->find('all')
                ->where(['user_id_candidate' => $loggedIn['id'], 'intervention_id' => $intervention->id]); //Il ne doit y avoir qu'un record de ce type
        $linkData = $query->toArray();
        $intervention['date_asked'] = $linkData[0]['date_candidate'];

        
        $this->set(compact(['intervention', 'loggedIn']));
        $this->set('_serialize', ['intervention']);
    }
    
    /*
     * View an intervention that needs validation, for pole manager (and admin)
     */
    public function viewValidate($id = null)
    {
        $loggedIn = $this->Auth->user();
        
        $intervention = $this->Interventions->get($id, ['contain' => 'Teacher.Highschool']);
        
        if($this->request->is('post')) {
            $intervention->status = 1;
            if($this->Interventions->save($intervention)){
                $this->Flash->success('Vous avez validé une intervention. Un mail récapitulatif a été envoyé aux bénévoles du pôle.');
                
                $UsersTable = TableRegistry::get('Users');
                $query1 = $UsersTable->find('all');
                $query1->where(['role' => 'volunteer', 'pole' => $intervention->pole]);
                $poleVolunteers = $query1->toArray();
                
                foreach ($poleVolunteers as $volunteer) {
                    $mail = "Chèr(e) " . $volunteer->first_name . " " . $volunteer->last_name . "\n\n";
                    $mail .= "Nous vous soumettons la demande d'intervention suivante, qui concerne votre pôle (" . $volunteer->pole . ") : \n";
                    $mail .= "Lycée : " . $intervention->teacher->highschool->highschool_name . "\n";
                    $mail .= "Adresse : " . $intervention->teacher->highschool->address . "\n";
                    $mail .= "Durée : 1h\n";
                    $mail .= "Type d'intervention : " . $intervention->type_intervention . "\n";
                    $mail .= "Commentaires : " . $intervention->comment . "\n";
                    $mail .= "Si vous êtes intéressé(e), connectez-vous sur votre espace personnel à l’adresse http://www.XXX-asso.fr/XXX/users/login/.\nMerci pour votre engagement,\nLes responsables du pôle " . $intervention->pole . "\n\n";
                    
                    $this->sendMail($volunteer->email, "Nouvelle demande d'intervention", $mail);
                }
                
                $this->sendMail($intervention->teacher->email, "Votre demande d'intervention a été validée, id : ".$intervention->id,
                        "Bonjour, \nVotre demande d'intervention a bien été validée. Les bénévoles peuvent y candidater. Nous vous contacterons par mail lorsqu'un bénévole y aura été affecté.\nMerci pour votre engagement !\n\nLéquipe **association name**");
                
                return $this->redirect(['controller' => 'users', 'action' => 'accueil']);
            }
            $this->Flash->error('Impossible de valider cette intervention. Veulliez réessayer plus tard.');
        }
        
        $this->set(compact(['intervention', 'loggedIn']));
        $this->set('_serialize', ['intervention']);
    }
    
    /*
     * View final details of an intervention, not modifiable
     */
    public function viewFinal($id = null)
    {
        $loggedIn = $this->Auth->user();
        
        $intervention = $this->Interventions->get($id, ['contain' => ['Teacher.Highschool', 'Volunteer']]);
        
        $this->set(compact(['intervention', 'loggedIn']));
        $this->set('_serialize', ['intervention']);
    }
    
    /*
     * View final details of an intervention including feedback from teacher and volunteer, not modifiable, meant for admin only
     */
    public function viewFinalWithFeedback($id = null)
    {
        $loggedIn = $this->Auth->user();
        
        $intervention = $this->Interventions->get($id, ['contain' => ['Teacher.Highschool', 'Volunteer']]);
        
        $this->set(compact(['intervention', 'loggedIn']));
        $this->set('_serialize', ['intervention']);
    }
    
    /*
     * Function to view and asked intervention, for the teacher. Allows cancelling the asked intervention
     */
    public function viewAskedTeacher($id = null)
    {
        $loggedIn = $this->Auth->user();
        
        $intervention = $this->Interventions->get($id, ['contain' => 'Teacher.Highschool']);
        
        $this->set(compact(['intervention', 'loggedIn']));
        $this->set('_serialize', ['intervention']);
    }
    
    /*
     * View a completed intervention, for volunteer. Allows the registration of a feedback.
     */
    public function viewCompletedVolunteer($id = null)
    {
        $loggedIn = $this->Auth->user();
        
        $intervention = $this->Interventions->get($id, ['contain' => 'Teacher.Highschool']);
        
        if($this->request->is(['post', 'put'])){
            
            $intervention->feedback_intervenant = $this->request->data['feedback_intervenant'];
            
            if ($this->Interventions->save($intervention)) {
                $this->Flash->success(__('Vous avez enregistré un feedback.'));
                //$intervention->status = 1;
                //$this->Interventions->save($intervention);
                return $this->redirect(['controller' => 'users', 'action' => 'accueil']);
            }
            $this->Flash->error(__("Erreur lors de l'enregistrement du feedback, veuillez essayer à nouveau"));
            
        }
        
        $this->set(compact(['intervention', 'loggedIn']));
        $this->set('_serialize', ['intervention']);
    }
    
    /*
     * View a completed intervention, for teacher. Allows the registration of a feedback.
     */
    public function viewCompletedTeacher($id = null)
    {
        $loggedIn = $this->Auth->user();
        
        $intervention = $this->Interventions->get($id, ['contain' => 'Teacher.Highschool']);
        
        if($this->request->is(['post', 'put'])){
            
            $intervention->feedback_prof = $this->request->data['feedback_prof'];
            
            if ($this->Interventions->save($intervention)) {
                $this->Flash->success(__('Vous avez enregistré un feedback.'));
                //$intervention->status = 1;
                //$this->Interventions->save($intervention);
                return $this->redirect(['controller' => 'users', 'action' => 'accueil']);
            }
            $this->Flash->error(__("Erreur lors de l'enregistrement du feedback, veuillez essayer à nouveau"));
            
        }
        
        $this->set(compact(['intervention', 'loggedIn']));
        $this->set('_serialize', ['intervention']);
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
     * Function to see new interventions proposed, for volunteers. Allows them to candidate.
     */
    public function viewNew($id = null)
    {
        $loggedIn = $this->Auth->user();
        
        $intervention = $this->Interventions->get($id, ['contain' => 'Teacher.Highschool']);
        //$intervention->length_intervention = $intervention->length_intervention->i18nFormat([\IntlDateFormatter::NONE, \IntlDateFormatter::SHORT]);
        
        $ICTable = TableRegistry::get('InterventionsCandidates');
        $linkIC = $ICTable->newEntity();
        if($this->request->is('post')){
            $linkIC = $ICTable->patchEntity($linkIC, $this->request->data);
            //debug($linkIC = $ICTable->patchEntity($linkIC, $this->request->data));
            $linkIC->intervention_id = $id;
            $linkIC->user_id_candidate = $loggedIn['id'];
            if ($ICTable->save($linkIC)) {
                $this->Flash->success(__('Vous avez postulé pour une intervention.'));
                //$intervention->status = 1;
                //$this->Interventions->save($intervention);
                return $this->redirect(['controller' => 'users', 'action' => 'accueil']);
            }
            $this->Flash->error(__("Erreur lors de la candidature, veuillez vérifier les champs remplis"));
            
        }
        $this->set(compact(['intervention', 'loggedIn', 'linkIC']));
        $this->set('_serialize', ['intervention']);
    }
    
    /*
     * Logic of assignment of an intervention to a candidate
     */
    public function assign($id = null)
    {
        $loggedIn = $this->Auth->user();
        
        $intervention = $this->Interventions->get($id, ['contain' => ['Teacher.Highschool', 'Candidates']]);
        
        //recupérer la date candidatée :
        $ICTable = TableRegistry::get('InterventionsCandidates');
        
        foreach ($intervention->candidates as $candidate) {
            $query = $ICTable->find('all')
                    ->where(['user_id_candidate' => $candidate->id, 'intervention_id' => $id]); //Il ne doit y avoir qu'un record de ce type
            $linkData = $query->toArray();
            $candidate['date_display'] = $linkData[0]['date_candidate'];
        }
        
        
        if($this->request->is(['post', 'put'])){
            
            $usersTable = TableRegistry::get('Users');
            $intervention = $this->Interventions->patchEntity($intervention, $this->request->data, ['validate' => 'assign']);
            $intervention->status = 2;
            $volunteer = $usersTable->get($this->request->data['user_id_volunteer']);
            //get the date :
            $ICTable = TableRegistry::get('InterventionsCandidates');
            $query = $ICTable->find('all')
                ->where(['user_id_candidate' => $volunteer->id, 'intervention_id' => $intervention->id]); //Il ne doit y avoir qu'un record de ce type
            $linkData = $query->toArray();
            $intervention->date = $linkData[0]['date_candidate'];
            $intervention->user_id_volunteer = $volunteer->id;
            
            
            if ($this->Interventions->save($intervention)) {
                
                $this->Flash->success(__('Vous avez bien affecté le bénévole ' . $volunteer->first_name . " " . $volunteer->last_name . " pour cette intervention."));
                
                $mail = "Bonjour,\n\nVous avez été affecté(e) à l'intervention pour laquelle vous vous êtes proposé(e) :\n";
                $mail .= "Date : " . $intervention->date . "\n";
                $mail .= "Lycée : " . $intervention->teacher->highschool->highschool_name . "\n";
                $mail .= "Adresse : " . $intervention->teacher->highschool->address . "\n";
                $mail .= "Durée : 1h\n";
                $mail .= "Type d'intervention : " . $intervention->type_intervention . "\n";
                $mail .= "Commentaires : " . $intervention->comment . "\n";
                $mail .= "Voici les coordonnées de " . $intervention->teacher->first_name . " " . $intervention->teacher->last_name . " qui est le professeur de cette classe : \n";
                $mail .= "Email : " . $intervention->teacher->email . "\n";
                $mail .= "Téléphone : " . $intervention->teacher->phone_number . "\n";
                $mail .= "Vous trouverez plus d'informations en vous connectant sur votre espace personnel à l’adresse http://www.XXX-asso.fr/XXX/users/login/.\n\nMerci pour votre engagement,\n\nLes responsables du pôle " . $intervention->pole . "\n\n";
                $this->sendMail($volunteer->email, 'Votre candidature a été validée, id : '.$intervention->id,$mail);
                
                $mail2 = "Bonjour,\n\nNous avons affecté un bénévole à l'intervention que vous avez demandée.";
                $mail2 .= "Celle-ci aura lieu le " . $intervention->date . " au lycée " . $intervention->teacher->highschool->highschool_name . ".\n";
                $mail2 .= "Voici les coordonnées du bénévole : \n";
                $mail2 .= "Nom : " . $volunteer->first_name . " " . $volunteer->last_name . "\n"; 
                $mail2 .= "Email : " . $volunteer->email . "\n";
                $mail2 .= "Téléphone : " . $volunteer->phone_number . "\n";
                $mail2 .= "Vous trouverez plus d'informations en vous connectant à votre espace personnel.\nMerci de votre confiance !\nL'équipe **association name**\n\n";
                $this->sendMail($intervention->teacher->email, "Votre intervention est confirmée, id : " . $intervention->id, $mail2);
                        
                
                return $this->redirect(['controller' => 'users', 'action' => 'toAssignInterventions']);
            }
            $this->Flash->error(__("Veuillez sélectionner un bénévole parmi ceux proposés"));
        }
        
        
        $this->set(compact(['intervention', 'candidates']));
        $this->set('_serialize', ['intervention']);
    }
    

    /**
     * Creation of an intervention (for maintenance purposes only. The one to be usually used is ask - see below)
     */
    public function add()
    {
        $intervention = $this->Interventions->newEntity();
        if ($this->request->is('post')) {
            $intervention = $this->Interventions->patchEntity($intervention, $this->request->data);
            if ($this->Interventions->save($intervention)) {
                $this->Flash->success(__('The intervention has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The intervention could not be saved. Please, try again.'));
        }
        
        $this->set(compact('intervention'));
        $this->set('_serialize', ['intervention']);
    }
    
    /*
     * Function to ask a new intervention, for the teacher
     */
    public function ask()
    {
        $loggedIn = $this->Auth->user();
        $intervention = $this->Interventions->newEntity();
        if ($this->request->is('post')) {
            $intervention = $this->Interventions->patchEntity($intervention, $this->request->data);
            $intervention->user_id_teacher = $loggedIn['id'];
            $intervention->user_id_highschool = $loggedIn['user_id_highschool'];
            $intervention->status = 0;
            $intervention->asked = Time::now();
            if($intervention->pole == 'Culture'){
                $intervention->type_intervention = $this->request->data['type_intervention_c'];
            }
            elseif($intervention->pole == 'Entreprise'){
                $intervention->type_intervention = $this->request->data['type_intervention_e'];
            }
            elseif($intervention->pole == 'Valeurs'){
                $intervention->type_intervention = $this->request->data['type_intervention_v'];
            }
            
            
            if ($this->Interventions->save($intervention)) {
                $this->Flash->success("Vous avez demandé une intervention.");
                
                $mail = "Bonjour,\n\nVous avez demandé une intervention :\nType d'intervention : " . $intervention->type_intervention . "\nDates proposées : " . $intervention->possible_dates . "\nVous receverez un mail lorsque votre demande aura été validée par le responsable de pôle.\nMerci pour votre confiance !\nL'équipe **association name**";
                $this->sendMail($loggedIn['email'], 'Vous avez demandé une intervention, id : '.$intervention->id,$mail);
                
                $UsersTable = TableRegistry::get('Users');
                $query = $UsersTable->find('all');
                $query->where(['role' => 'poleManager', 'poleManaged' => $intervention->pole]);
                $reposPole = $query->toArray();
                
                $mailRespoPole = "Bonjour, \nUne nouvelle intervention vient d'être demandée par un professeur, et est en attente de validation. Veuillez vous connecter sur le site pour la valider ou la refuser.\nMerci !\n\n";
                
                foreach($reposPole as $respo) {
                    $this->sendMail($respo['email'], "Nouvelle demande d'intervention à valider", $mailRespoPole);
                }
              
                return $this->redirect(['controller' => 'users', 'action' => 'accueil']);
            }
            $this->Flash->error(__('The intervention could not be saved. Please, try again.'));
        }
        $this->set(compact('intervention', 'user'));
        $this->set('_serialize', ['intervention']);
    }
    
   
    
    

    /**
     * Edit an intervention details (maintenance purposes only)
     */
    public function edit($id = null)
    {
        $intervention = $this->Interventions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $intervention = $this->Interventions->patchEntity($intervention, $this->request->data);
            if ($this->Interventions->save($intervention)) {
                $this->Flash->success(__('The intervention has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The intervention could not be saved. Please, try again.'));
        }
        
        $this->set(compact('intervention'));
        $this->set('_serialize', ['intervention']);
    }

    /**
     * Delete an intervention
     */
    public function delete($id = null)
    {
        $loggedIn = $this->Auth->user();
        $this->request->allowMethod(['post', 'delete']);
        $intervention = $this->Interventions->get($id);
        
        $ICTable = TableRegistry::get('InterventionsCandidates');
        $query1 = $ICTable->query();
        $query1->delete()
                ->where(['intervention_id' => $id])
                ->execute();
        
        $UsersTable = TableRegistry::get('Users');
        $query2 = $UsersTable->find('all');
        $query2->where(['role' => 'poleManager', 'poleManaged' => $intervention->pole]);
        $reposPole = $query2->toArray();
        
        if ($this->Interventions->delete($intervention)) {        
            $mail = "Un professeur a annulé sa demande d'intervention.\nType d'intervention : " . $intervention->type_intervention . "\nDates proposées : " . $intervention->possible_dates . "\nNom du professeur :" . $loggedIn['first_name'] . " " . $loggedIn['last_name'];
            foreach ($reposPole as $respo) {
                $this->sendMail($respo['email'], "Demande d'intervention annulée, id : ".$intervention->id, $mail);
            }
            
            if(isset($intervention->volunteer)){
                $mailBenevole = "Bonjour, \n\nL'intervention pour laquelle vous aviez été affecté a été annulée.\nThème : " . $intervention->type_intervention . "\nDate : " . $intervention->date_intervention_starts->nice() . "\nMerci pour votre engagement !\n\n L'équipe **association name**\n\n";
                $this->sendMail($intervention->volunteer->email, "Intervention annulée, id : ".$intervention->id, $mailBenevole);      
            }
            
            $this->Flash->success("L'intervention a été supprimée. Le responsable de pôle a été notifié.");
            
        } else {
            $this->Flash->error(__('The intervention could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller' => 'users', 'action' => 'accueil']);
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
    
    /*
    public function aaa($id = null) {
        
        $this->autoRender = false;
        $intervention = $this->Interventions->get($id);
        //$a = 'bijour';
        /*
        $mail = "Bonjour,\n\nVous avez demandé une intervention :\nType d'intervention : " . $intervention->type_intervention;
        $mail .= "\nDates proposées : " . $intervention->possible_dates;
        $mail .= "\nVous receverez un mail lorsque votre demande aura été validée par le responsable de pôle.\nMerci pour votre confiance !\nL'équipe **association name**";
        
        
        $mail = "Bonjour,\n\nVous avez demandé une intervention :\nType d'intervention : " . $intervention->type_intervention . "\nDates proposées : " . $intervention->possible_dates . "\nVous receverez un mail lorsque votre demande aura été validée par le responsable de pôle.\nMerci pour votre confiance !\nL'équipe **association name**";
        
        
        
        $this->Flash->success($mail);
        
        $this->sendMail('benjamin.terris@student.ecp.fr', 'Vous avez demandé une intervention, id : ', $mail);
        $this->redirect(['controller' => 'users', 'action' => 'index']);
    }
    */

    
}
