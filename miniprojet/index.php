<?php
    if (isset($_GET['lien'])) {
        switch ($_GET['lien']) {
            case 'admin':
                require_once("CreationCompteAdmin.php");
                break;
            case 'user':
                require_once("Interface_Joueur.php");
                break;
            case 'liste_qst':
                require_once("ListeQuestions.php");
                break;
            case 'liste_jr':
                require_once("ListeJoueur.php");
                break;
            case 'creer_qst':
                require_once("CreerQuestions.php");
                break;
            case 'creer_jr':
                require_once("CreationCompteUser.php");
                break;
            case 'statistiques':
                require_once("Statistiques.php");
                break;
        }
    }
    else{
        require_once("PageConnexion.php");
    }
?>