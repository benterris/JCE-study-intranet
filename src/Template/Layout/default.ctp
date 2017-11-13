<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'XXX';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    
    <?= $this->Html->css('custom.css') ?>
    <!--
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('cake.css') ?>
    -->
    <?= $this->Html->meta('icon') ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://www.google.com/recaptcha/api.js?hl=fr"></script>
</head>
<body>
   
 
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            
            <ul class="nav navbar-nav">
                <li>
                    <?php
                    
                        if(isset($loggedIn)){
                            echo $this->Html->link('Connecté en tant que ' . $loggedIn['first_name'] . " " . $loggedIn['last_name'], ['controller' => 'users', 'action' => 'accueil']);

                        }
                    ?>  
                </li>
            </ul>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><?= $this->Html->link('Accueil', ['controller' => 'users', 'action' => 'accueil']) ?></li>
                <li><?= $this->Html->link('Mes infos', ['controller' => 'users', 'action' => 'view_self']) ?></li>
                <li><?= $this->Html->link('F.A.Q.', ['controller' => 'pages', 'action' => 'faq']) ?></li>
                <li><?= $this->Html->link("Exemples d'interventions", ['controller' => 'pages', 'action' => 'description_interventions']) ?></li>
                <li>
                     <?php
                        echo $this->Html->link('Déconnexion', ['controller' => 'users', 'action' => 'logout']);
                        /*
                        if(isset($loggedIn)){
                            echo $this->Html->link('Déconnexion', ['controller' => 'users', 'action' => 'logout']);
                        }
                         * 
                         */
                    ?>  
                </li>
            </ul>
        </div>
            
    </div>
</nav>

    <!--<?= $this->Flash->render() ?>-->
    <div class="container-fluid">
        <?= $this->fetch('content') ?>
    </div>
    <footer>
    </footer>
    
</body>
</html>

