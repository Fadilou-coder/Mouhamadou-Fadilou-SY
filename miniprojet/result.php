<?php
session_start();
if(!$_SESSION['User']){
    header('location: index.php');
}
$js = file_get_contents('fichier.json');
$js = json_decode($js, true);
$qst = file_get_contents('question.json');
$qst = json_decode($qst, true);
$NbrValeurParPage = 5;
$totalValeur = count($_SESSION['qst_a_jouer']);
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
    header('location: index.php?lien=result&page=' . ($pageActuelle+1));
}
if (isset($_POST['prec'])) {
    header('location: index.php?lien=result&page=' . ($pageActuelle-1));
}
$IndiceDepart = ($pageActuelle - 1)*$NbrValeurParPage;
$IndiceFin = $IndiceDepart + $NbrValeurParPage - 1;
foreach ($js['Users'] as $key => $row) {
    $pts[$key]  = $row['pts'];;
}
array_multisort($pts, SORT_DESC, $js['Users']);
for($i=0; $i < count($js['Users']); $i++) {
    if ($js['Users'][$i]['login'] == $_SESSION['login']) {
        $ind_user = $i;
    }
}
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultats</title>
    <link href="style.css" rel="stylesheet" type="text/css">
</head>
    <body>
    
        <img class="img-haut" src="Images/logo-QuizzSA.png" />
        
            <div class="haut">  
                <h2> Le Plaisir de Jouer </h2>
            </div>
            <div class="milieuIJoueur">
                <div class="profil">
                    <div class="avatar">
                            <img class="photo" src=" <?php echo $_SESSION['profil']  ?>" />
                        <h2>
                            <?php echo $_SESSION['prenom']." ".$_SESSION['nom'] ?>
                        </h2>

                    </div>
                    
                       <h2 class="h">BIENVENUE SUR LA PLATEFORME DE JEU DE QUIZZ
                        JOUER ET TESTER VOTRE NIVEAU DE CULTURE GENERALE</h2>
                   
                    
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
                <div class="aff-score"><?php echo '<h2>Votre Score est: '.$_SESSION['score'].'</h2>' ?></div>
                <div class="result">
                    <div class="aff-result">
                            <form action="" method="POST">
                                <button class="rejouer" type="submit" name="rejouer">Rejouer</button>
                            </form>
                        <?php
                                    for ($i=$IndiceDepart; $i <= $IndiceFin; $i++) {
                                        if (isset($_SESSION['qst_a_jouer'][$i]) && isset($qst['Questions'][$_SESSION['qst_a_jouer'][$i]])) {
                                            echo '<h2>'.($i+1).'.'.$qst['Questions'][$_SESSION['qst_a_jouer'][$i]]['question'].'</h2>';
                                            if (isset($_SESSION['qst-trouver'])) {
                                                if (in_array($qst['Questions'][$_SESSION['qst_a_jouer'][$i]],$_SESSION['qst-trouver'])) {
                                                    echo '<div class="ic-valide"><img src="Images/valide.png" /></div>';
                                                }
                                                else{
                                                    echo '<div class="ic-valide"><img src="Images/nonvalide.png" /></div>';
                                                }
                                                
                                            }
                                        
                                            if ($qst['Questions'][$_SESSION['qst_a_jouer'][$i]]['type']=="choixS") {
                                                for ($j=0; $j < count($qst['Questions'][$_SESSION['qst_a_jouer'][$i]]['reponse']) ; $j++) { 
                                                    echo '<div class="choix-simple"';
                                                    if (isset($_SESSION['reponse'][$i+1]) && in_array($qst['Questions'][$_SESSION['qst_a_jouer'][$i]]['reponse'][$j], $_SESSION['reponse'][$i+1])) {
                                                        echo 'style = "background-color: #2ADDD6"';
                                                    }
                                                    echo '></div><div class="reponse">'.$qst['Questions'][$_SESSION['qst_a_jouer'][$i]]['reponse'][$j].'</div><br/>';
                                                }
                                            }
                                            else {
                                                if ($qst['Questions'][$_SESSION['qst_a_jouer'][$i]]['type']=="choixM") {
                                                    for ($j=0; $j < count($qst['Questions'][$_SESSION['qst_a_jouer'][$i]]['reponse']) ; $j++) { 
                                                        echo '<div class="choix-mult"';
                                                        if (isset($_SESSION['reponse'][$i+1]) && in_array($qst['Questions'][$_SESSION['qst_a_jouer'][$i]]['reponse'][$j], $_SESSION['reponse'][$i+1])) {
                                                            echo 'style = "background-color: #2ADDD6"';
                                                        }
                                                        echo '></div><div class="reponse">'.$qst['Questions'][$_SESSION['qst_a_jouer'][$i]]['reponse'][$j].'</div><br/>';
                                                    }
                                                }
                                                else {
                                                    if(isset($_SESSION['reponse'][$i+1][0])){ 
                                                        echo '<div class="reponse-text">'.$_SESSION['reponse'][$i+1][0].'</div>';
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    if (isset($_POST['rejouer'])) {
                                        
                                        $_SESSION['score'] = 0;
                                        $_SESSION['reponse'] = null;
                                        $js = file_get_contents('fichier.json');
                                        $js = json_decode($js, true);
                                        if (isset($js['Users'][$ind_user]['qst-trouver'])) {
                                            if (count($qst['Questions']) - count($js['Users'][$ind_user]['qst-trouver'])>=$qst['nbre-qst'] ) {
                                                $j = 0;
                                            }
                                            else{
                                                $j = $qst['nbre-qst']-(count($qst['Questions'])-count($js['Users'][$ind_user]['qst-trouver']));
                                            }
                                        }
                                        else{
                                            $j = 0;
                                        }
                                        $_SESSION['qst_a_jouer'] = array();
                                        while($j < $qst['nbre-qst']){
                                            $tmp = rand(0,(count($qst['Questions'])-1));
                                            if(!isset($js['Users'][$ind_user]['qst-trouver']) || (!in_array($qst['Questions'][$tmp],$js['Users'][$ind_user]['qst-trouver']))) {
                                               if(!in_array($tmp,$_SESSION['qst_a_jouer'])){
                                                    $_SESSION['qst_a_jouer'][] = $tmp;
                                                    $j++;
                                               }
                                            }
                                        }
                                        $_SESSION['qst-trouver'] = null;
                                        echo '<script>location.replace("index.php?lien=user");</script>';
                                    }
                                

                        ?>
                        <form method="POST">
                               <?php 
                                    if( $pageActuelle != $NbreDePage ){
                                        echo '<input  class="btn-suiv" type="submit" name="suivant" value="Suivant" />';
                                    }
                                    if( $pageActuelle != 1 ){
                                        echo '<input style="margin-left:-10%" class="btn-prec" type="submit" name="prec" value="Précedent" />';
                                    }

                                ?>
                        </form>
                    </div>
                </div>
            </div>
        
    </body>
</html>

