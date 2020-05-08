<?php
session_start();
if(!$_SESSION['Admin']){
    header('location: index.php');
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
    header('location: index.php?lien=liste_qst&page=' . ($pageActuelle+1));
}
if (isset($_POST['prec'])) {
    header('location: index.php?lien=liste_qst&page=' . ($pageActuelle-1));
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
                        <button class="dec" name="deconnexion" onclick="deconnexion()">Déconnexion</button>
                        <script>
                            function deconnexion() {
                                var r = confirm("Voulez vous vraiment vous deconnecter?");
                                if (r == true) {
                                    location.replace("deconnexion.php")
                                }
                            }
                        </script>
                    </div>
                    
                </div>
                <div class="milieu1IJ" style="background-color:  rgb(233, 233, 233); ">
                    <br/>
                    <div class="MenuAdmin">
                        <div class="profil-admin">
                            <div class="avatar-admin">
                                <img class="photo"  src=" <?php echo $_SESSION['profil']  ?>" />
                                <h1>
                                    <?php echo $_SESSION['prenom']." ".$_SESSION['nom'] ?>
                                </h1>

                            </div>
                        </div>
                        
                        <ul>
                            <li><a class="active" href="index.php?lien=liste_qst"><div></div>&nbsp;&nbsp;&nbsp;Liste Questions <img class="icones" src="Images\Icones\ic-liste.png"/></a></li>
                            <li><a href="index.php?lien=admin">&nbsp;&nbsp;&nbsp;Creer Admin <img class="icones" src="Images\Icones\ic-ajout-active.png"/> </a></li>
                            <li><a href="index.php?lien=liste_jr">&nbsp;&nbsp;&nbsp;Liste Joueurs <img class="icones" src="Images\Icones\ic-liste.png"/> </a></li>
                            <li><a href="index.php?lien=creer_qst">&nbsp;&nbsp;&nbsp;Creer Questions <img class="icones" src="Images\Icones\ic-ajout-active.png"/> </a></li>
                            <li><a href="index.php?lien=statistiques">&nbsp;&nbsp;&nbsp;Statistiques <img class="icones" src="Images\Icones\ic-sta.png"/> </a></li>
                        </ul>

                    </div>
                    <div class="Liste-qst">
                        
                            <form action="" method="POST">
                                <br/>
                                <input class="input-OK" type="submit" name="OK" value="OK"/>
                                <input class="input-nbre" type="text" name="nbre" value="<?php echo $js['nbre-qst'] ?>" />    
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
       if( $_POST['nbre'] >= 5){
            $js['nbre-qst'] = $_POST['nbre'];
            $js = json_encode($js);
            file_put_contents('question.json', $js);
       }
   }

?>
