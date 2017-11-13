  <script>
  $( function() {
    $( "#datepicker" ).datepicker();
  } );
  </script>
                     


<div class="row">
    <div class="col-sm-3 col-md-2 sidebar">
        <ul class="nav nav-sidebar">
            <li>
                <div align="center">
                <?=$this->Html->image('logo-XXX.jpg', ['alt' => 'C\'possible logo', 'class' => 'img-thumbnail', 'align' => 'center']) ?>
                </div>
            </li>
        </ul>
        <ul class="nav nav-sidebar">
            <li><?= $this->Html->link('Accueil professeur', ['controller' => 'Users', 'action' => 'accueil']) ?></li>
            <li class="active"><?= $this->Html->link('Demander une intervention', ['controller' => 'Interventions', 'action' => 'ask']) ?></li>
            <li><?= $this->Html->link('Mon historique', ['controller' => 'Users', 'action' => 'oldInterventionsTeacher']) ?></li>
        </ul>
    </div>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <?= $this->Flash->render() ?>
        
    <?= $this->Form->create($intervention) ?>
        <fieldset>
            <h2><?= __('Demander une intervention') ?></h2>
            <?= $this->Html->script('scriptAsk'); ?>
        <?php
            
            echo $this->Form->input('section_name', ['label' => 'Nom de la classe']);
            
            echo '<div class="form-group">';
            //echo '<label for="pole">Pôle</label>';
            echo '<p class="label-ask">Pôle</p>';
            echo 'Des interventions inter-pôles sont possibles.';
            
            echo $this->Form->select('pole', ['Entreprise' => 'Entreprise', 'Culture' => 'Culture', 'Valeurs' => 'Valeurs'], ['empty' => true, 'onchange' => 'updateVisibleCatalogue()', 'id' => 'intervType']);
            echo "</div>";
            ?>
            <div id="Culture">
                <label>Thème de l'intervention demandée (Culture)</label>
                <p>Le menu déroulant présente une liste non exhaustive d'exemples d'interventions à adapter en fonction de vos besoins</p>
            <?php echo $this->Form->input('type_intervention_c', ['label' => "", 'type' => 'select', 'options' => 
                [
                    "L'apport de l'Art africain à l'art occidental" => "L'apport de l'Art africain à l'art occidental",
                    "Apport de l’art islamique à l’architecture et à l’art des jardins en Espagne" => "Apport de l’art islamique à l’architecture et à l’art des jardins en Espagne",
                    "Nous nous souvenons : pérennité des formes architecturales depuis 2500 ans" => "Nous nous souvenons : pérennité des formes architecturales depuis 2500 ans",
                    "Les Prisons de Piranèse : un visionnaire du XVIIIe siècle et son impact jusqu’à Blade Runner" => "Les Prisons de Piranèse : un visionnaire du XVIIIe siècle et son impact jusqu’à Blade Runner",
                    "L’hippogriffe de Harry Potter et ses ancêtres, de l’Arioste à Vallotton" => "L’hippogriffe de Harry Potter et ses ancêtres, de l’Arioste à Vallotton",
                    "Art et Mémoire : enjeux du monument" => "Art et Mémoire : enjeux du monument",
                    "L'Art et la Publicité" => "L'Art et la Publicité",
                    "Le Street Art" => "Le Street Art",
                    "L'écoute musicale" => "L'écoute musicale",
                    "Les Pouvoirs extraordinaires de la voix" => "Les Pouvoirs extraordinaires de la voix",
                    "Musée du Luxembourg" => "Musée du Luxembourg",
                    "Musée du Louvre" => "Musée du Louvre",
                    "Musée du Mobilier National" => "Musée du Mobilier National",
                    "Musée des Arts Décoratifs" => "Musée des Arts Décoratifs",
                    "Musée du Quai Branly / programme Chercheurs d'Art" => "Musée du Quai Branly / programme Chercheurs d'Art",
                    "Musée Bourdelle" => "Musée Bourdelle",
                    "Maison de Balzac" => "Maison de Balzac",
                    "Autre (à préciser)" => "Autre (à préciser)"
                    ]
                ]); ?>
            </div>
            
            <div id="Entreprise">
                <label>Thème de l'intervention demandée (Entreprise)</label>
                <p>Le menu déroulant présente une liste non exhaustive d'exemples d'interventions à adapter en fonction de vos besoins</p>
            <?= $this->Form->input('type_intervention_e', ['label' => "", 'type' => 'select', 'options' => 
                [
                    "Le rôle et le fonctionnement d'une banque" => "Le rôle et le fonctionnement d'une banque",
                    "A la découverte des métiers de la DRH" => "A la découverte des métiers de la DRH",
                    "Initiation aux marchés financiers" => "Initiation aux marchés financiers",
                    "Le droit de la concurrence" => "Le droit de la concurrence",
                    "La fonction commerciale" => "La fonction commerciale",
                    "Les enjeux du numérique" => "Les enjeux du numérique",
                    '"Bien dans ses godasses"' => '"Bien dans ses godasses"',
                    "Entretiens Session 1" => "Entretiens Session 1",
                    "Entretiens Session 2" => "Entretiens Session 2",
                    "Présentation d'une entreprise (à préciser)" => "Présentation d'une entreprise (à préciser)",
                    "Présentation d'une fonction (à préciser)" => "Présentation d'une fonction (à préciser)",
                    "Autre (à préciser)" => "Autre (à préciser)"
                    ]
                ]) ?>
            <p>La session 2 du module de préparation aux Entretiens a lieu 3 semaines après la session 1. Nous vous remercions donc de bien vouloir prendre en compte dans vos souhaits de date.</p>
            </div>
            
            <div id="Valeurs">
                <label>Thème de l'intervention demandée (Valeurs)</label>
                <p>Le menu déroulant présente une liste non exhaustive d'exemples d'interventions à adapter en fonction de vos besoins</p>
            <?= $this->Form->input('type_intervention_v', ['label' => "", 'type' => 'select', 'options' => 
                [
                    "La valeur du temps" => "La valeur du temps",
                    "Connaissance de soi / connaissance des autres" => "Connaissance de soi / connaissance des autres",
                    "La valeur travail" => "La valeur travail",
                    "La laïcité" => "La laïcité",
                    "La concurrence et la compétition" => "La concurrence et la compétition",
                    "Tout peut-il s'acheter" => "Tout peut-il s'acheter",
                    "La prise de parole" => "La prise de parole",
                    "Le droit du travail" => "Le droit du travail",
                    "Le traitement de l'information" => "Le traitement de l'information",
                    "Autre (à préciser)" => "Autre (à préciser)"
                ]]) ?>
            </div>
            
            <?php
            /*
            echo '<div class="form-group">';
            echo '<label for="date_intervention_starts">Date souhaitée</label>';
            echo '<div class="form-inline">';
            echo '<row>';
            echo $this->Form->input('date_intervention_starts', [
                'label' => false,
                'empty' => true, 
                'interval' => 5,
             ]);
            echo '</div></row></div>';
            
            
            echo '<div class="form-group">';
            echo "<label for='length_intervention'>Durée de l'intervention</label>";
            echo '<div class="form-inline">';
            echo '<row>';
            echo $this->Form->input('length_intervention', [
                'label' => false,
                'empty' => true, 
                'day' => false, 
                'month' => false, 
                'year' => false, 
                'interval' => 5
            ]);
            echo '</div></row></div>';
             * 
             */
            echo '<div class="form-group">';
            echo '<label for="possible_dates">Créneaux proposés</label>';
            echo "<p>Vous pouvez proposer plusieurs dates et heures. Par exemple : «Vendredi 6 juin de 14h à 18h, Mardi 13 juin de 9h à 13h, etc.. »</p>";
            echo $this->Form->input('possible_dates', ['label' => false]);
            //echo $this->Form->input('length_intervention', ['label' => "Durée de l'intervention"]); -> toutes les interventions durent 1h
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="comment">Détails</label>';
            echo "<p>C’Possible vous propose de créer votre intervention « sur-mesure ». Précisez ici les détails de l'intervention demandée.</p>";
            echo $this->Form->input('comment', ['label' => false]);
            echo "</div>";
        ?>
        <!-- <p>Date: <input type="text" id="datepicker"></p>  Pas de date ici -->
        </fieldset>
    <?= $this->Form->button('Envoyer') ?>
    <?= $this->Form->end() ?>
    </div>
</div>
                          