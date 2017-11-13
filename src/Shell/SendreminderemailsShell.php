<?php



/*
How to use this to send emails :
 create a cron job in crontab using the fellowing line :


 0 * * * * cd /full/path/to/root && bin/cake sendreminderemails
 */

namespace App\Shell;

use Cake\Console\Shell;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class SendreminderemailsShell extends Shell
{
    public function main()
    {
        //$this->out('Hello world.');
        
        $now1 = Time::now('Europe/Paris');
        $now2 = Time::now('Europe/Paris');
        
        $before = $now1->addDay(1);
        $after = $now2->addDay(1)->addHour(1);
        
        $this->out($before . " %%%%%% " . $after);
        
        
        
        $interventionsTable = TableRegistry::get('Interventions');
        
        /*
        $query = $interventionsTable->find('all', ['contain' => ['Teacher.Highschool', 'Volunteer']])
                ->where(['status' => 2, 'date >' => $before, 'date <' => $after]);
        */
        
        $query = $interventionsTable->find('all', ['contain' => ['Teacher.Highschool', 'Volunteer']])
                ->where(['status' => 2]);
        
        
        $interventions = $query->toArray();
        
        foreach ($interventions as $intervention) {
            $mail = "Chèr(e) " . $intervention->volunteer->first_name . " " . $intervention->volunteer->last_name . "\n";
            $mail .= "Vous animez l'intervention : " . $intervention->type_intervention . ", au lycée " . $intervention->teacher->highschool->highschool_name;
            $mail .= ", le " . $intervention->date->nice() . " dans la classe " . $intervention->section_name . ". Voici les coordonnées du lycée et du professeur :\n";
            $mail .= "Lycée : " . $intervention->teacher->highschool->highschool_name . ", " . $intervention->teacher->highschool->address . "\n";
            $mail .= "Professeur : " . $intervention->teacher->first_name . " " . $intervention->teacher->last_name . "\n";
            $mail .= "Email Professeur : " . $intervention->teacher->email . "\n";
            $mail .= "Téléphone Professeur : " . $intervention->teacher->phone_number . "\n";
            $mail .= "A l’issue de l’intervention, nous vous remercions de nous faire part de vos commentaires sur votre espace personnel à l’adresse http://www.XXX-asso.fr/XXX/users/login/.\n";
            $mail .= "En vous souhaitant une bonne intervention,\nLes responsables du pôle " . $intervention->pole;
            
            $this->sendMail($intervention->volunteer->email, "RAPPEL : vous animez bientôt une intervention", $mail);
            
            $mail2 = "Chèr(e) " . $intervention->teacher->first_name . " " . $intervention->teacher->last_name . "\n";
            $mail2 .= "Vous recevez dans votre classe " . $intervention->section_name . " l'intervention : " . $intervention->type_intervention . "\n";
            $mail2 .= "Celle-ci aura lieu le " . $intervention->date->nice() . ". Voici les coordonnées du bénévole :\n";
            $mail2 .= "Nom : " . $intervention->volunteer->first_name . " " . $intervention->volunteer->last_name;
            $mail2 .= "Email Bénévole : " . $intervention->volunteer->email . "\n";
            $mail2 .= "Téléphone Bénévole : " . $intervention->volunteer->phone_number . "\n";
            $mail2 .= "A l’issue de l’intervention, nous vous remercions de nous faire part de vos commentaires sur votre espace personnel à l’adresse http://www.XXX-asso.fr/XXX/users/login/.\n";
            $mail2 .= "En vous souhaitant une bonne intervention,\nLes responsables du pôle " . $intervention->pole;
            
            $this->sendMail($intervention->teacher->email, "RAPPEL : vous animez bientôt une intervention", $mail);

            //$this->out($mail);
            //$this->out($mail2);
        }
        
    }
    
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


