<?php
session_start();
if($_SESSION){
if(isset($_POST['deconnexion'])){
    header('location: deconnexion.php');
}  
}
if(!$_SESSION['Admin']){
    header('location: PageConnexion.php');
}


$js = file_get_contents('question.json');
$js = json_decode($js, true);

$NbrValeurParPage = 5;
$totalValeur = count($js['Questions']);
$NbreDePage = ceil($totalValeur/$NbrValeurParPage);
if (isset($_GET['page'])) {
    $pageActuelle = $_GET['page'];
    
    if ($pageActuelle > $NbreDePage) {
        $pageActuelle = $NbreDePage;
    }
}
else{
    $pageActuelle = 1;
}
if (isset($_POST['suivant'])) {
    header('location: ListeQuestions.php?page=' . ($pageActuelle+1));
}
if (isset($_POST['prec'])) {
    header('location: ListeQuestions.php?page=' . ($pageActuelle-1));
}
$IndiceDepart = ($pageActuelle - 1)*$NbrValeurParPage;
$IndiceFin = $IndiceDepart + $NbrValeurParPage - 1;
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste Questions</title>
    <link href="style.css" rel="stylesheet" type="text/css">
</head>
    <body>
    
        <img class="img-haut" src="Images/logo-QuizzSA.png" />
        
            <div class="haut">  
                <h2> Le Plaisir de Jouer </h2>
            </div>
            <div class="milieuIJ">
                <div class="profil">
                    
                    
                       <br/><h2 style="color: white" class="h">CREER ET PARAMETRER VOS QUIZZ</h2>
                   
                    
                    <div class="deconnexion">
                        <form action="ListeQuestions.php" method="POST">
                            <input class="dec" type="submit" name="deconnexion" value="Déconnexion" />
                        </form>
                    </div>
                    
                </div>
                <div class="milieu1IJ" style="background-color:  rgb(233, 233, 233); ">
                    <br/>
                    <div class="MenuAdmin">
                        <div style="height: 50%; background-color: #73DEF0;">
                            <div style="width: 50%; margin-left:20%; margin-top: 10%" class="avatar">
                                <img class="photo"  src=" <?php echo $_SESSION['profil']  ?>" />
                                <h1>
                                    <?php echo $_SESSION['prenom']." ".$_SESSION['nom'] ?>
                                </h1>

                            </div>
                        </div>
                        
                        <div class="liste" style="background-color:   silver;">
                            <div class="list-courant"></div>
                            <a class="icones" href="ListeQuestions.php">
                               <img  src="Images\Icônes\ic-liste.png"/>
                            </a>
                            &nbsp;&nbsp;&nbsp; Liste Questions    
                        </div>
                        
                        <div class="liste">
                            <a class="icones" href="CreationCompteAdmin.php">
                               <img  src="Images\Icônes\ic-ajout-active.png"/>
                            </a>
                            &nbsp;&nbsp;&nbsp; Créer Admin 
                        </div>
                        <div class="liste">           
                               <a class="icones" href="ListeJoueur.php">
                               <img  src="Images\Icônes\ic-liste.png"/>
                               </a>
                            &nbsp;&nbsp;&nbsp; Liste Joueurs   
                        </div>
                        
                        <div class="liste">
                            <a class="icones" href="CreerQuestions.php">
                               <img  src="Images\Icônes\ic-ajout-active.png"/>
                            </a>
                            &nbsp;&nbsp;&nbsp; Créer Questions 
                        </div>
                    </div>
                    <div class="Liste-qst">
                        
                            <form action="" method="POST">
                                <br/>
                                <input class="input-OK" type="submit" name="OK" value="OK"/>
                                <input class="input-nbre" type="text" name="nbre"/>    
                                <label class="label-nbre">Nbre de questions/jeu</label>
                            </form>
                        <div class="bordure-silver">
                            <div class="list-question">
                                <?php

                                    $indice = 1;
                                    for ($i = $IndiceDepart; $i <= $IndiceFin  ; $i++) { 
                                        if(isset($js['Questions'][$i])){
                                            echo "<br/><br/>".$indice++.".".$js['Questions'][$i]['question']."<br/><br/>";
                                            if ($js['Questions'][$i]['type']=="choixS") {
                                                for ($j=0; $j < count($js['Questions'][$i]['reponse']) ; $j++) { 
                                                    echo '<br/><div class="choix-simple"';
                                                    if ($js['Questions'][$i]['reponse'][$j] == $js['Questions'][$i]['vrai'][0]) {
                                                        echo 'style = "background-color: #2ADDD6"';
                                                    }
                                                    echo '></div><div class="reponse">'.$js['Questions'][$i]['reponse'][$j].'</div><br/>';
                                                }
                                            }
                                            else {
                                                if ($js['Questions'][$i]['type']=="choixM") {
                                                    for ($j=0; $j < count($js['Questions'][$i]['reponse']) ; $j++) { 
                                                        echo '<br/><div class="choix-mult"';
                                                        if (in_array($js['Questions'][$i]['reponse'][$j], $js['Questions'][$i]['vrai'])) {
                                                            echo 'style = "background-color: #2ADDD6"';
                                                        }
                                                        echo '></div><div class="reponse">'.$js['Questions'][$i]['reponse'][$j].'</div><br/>';
                                                    }
                                                }
                                                else {
                                                    echo '<br/><div class="reponse-text"></div>';
                                                }
                                            }
                                            
                                        }
                                    }
                                    


                                ?>
                            </div>
                        </div>
                        <div class="liste-Qestion-suivant"> 
                            <form method="POST">
                               <?php 
                                    if( $pageActuelle != $NbreDePage ){
                                        echo '<input class="btn-suiv" type="submit" name="suivant" value="Suivant" />';
                                    }
                                    if( $pageActuelle != 1 ){
                                        echo '<input class="btn-prec" type="submit" name="prec" value="Précedent" />';
                                    }
                                ?>
                            </form>
                            
                        </div>
                        
                    
                    </div>
                    
                    

                </div>
            </div>
        
    </body>
</html>
<?php

   if (isset($_POST['OK'])) {
       if( $_POST['nbre'] > 0){
            $js['nbre-qst'] = $_POST['nbre'];
            $js = json_encode($js);
            file_put_contents('question.json', $js);
       }
   }

?>
