<?php
session_start();
if(!$_SESSION['User']){
    header('location: index.php');
}
$js = file_get_contents('fichier.json');
$js = json_decode($js, true);
$qst = file_get_contents('question.json');
$qst = json_decode($qst, true);
foreach ($js['Users'] as $key => $row) {
    $pts[$key]  = $row['pts'];;
}
array_multisort($pts, SORT_DESC, $js['Users']);
for($i=0; $i < count($js['Users']); $i++) {
    if ($js['Users'][$i]['login'] == $_SESSION['login']) {
        $ind_user = $i;
    }
}
$NbrValeurParPage = 1;
if ($qst['nbre-qst']<count($_SESSION['qst_a_jouer'])) {
    $totalValeur = $qst['nbre-qst'];
}
else{
    $totalValeur = count($_SESSION['qst_a_jouer']);
}
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
if (!isset($_GET['score'])) {
    $_GET['score'] = 'top_score';
}

if (isset($_GET['jeu'])) {
    $jeu = $_GET['jeu'];
}
else {
    $jeu = 'encours';
}
if (isset($_POST['suivant'])) {
        $_SESSION['reponse'][$pageActuelle] = array();
        $_SESSION['reponse'][$pageActuelle][] = "";
        if($qst['Questions'][$_SESSION['qst_a_jouer'][$pageActuelle-1]]['type'] == "choixM"){
            $tmp = 0;
            for ($i=0; $i < 3 ; $i++) {
                if (isset($_POST['vrai'.$i])) {
                    $_SESSION['reponse'][$pageActuelle][$tmp++] = $_POST['vrai'.$i];
                }
            }
            if (count($_SESSION['reponse'][$pageActuelle]) == count($qst['Questions'][$_SESSION['qst_a_jouer'][$pageActuelle-1]]['vrai'])) {
                if(in_array($_SESSION['reponse'][$pageActuelle][0], $qst['Questions'][$_SESSION['qst_a_jouer'][$pageActuelle-1]]['vrai']) && in_array($_SESSION['reponse'][$pageActuelle][1], $qst['Questions'][$_SESSION['qst_a_jouer'][$pageActuelle-1]]['vrai'])){
                    $_SESSION['score']+=$qst['Questions'][$_SESSION['qst_a_jouer'][$pageActuelle-1]]['score'];
                    $_SESSION['qst-trouver'][$pageActuelle-1] = $qst['Questions'][$_SESSION['qst_a_jouer'][$pageActuelle-1]];
                }
                else{
                    $_SESSION['qst-trouver'][$pageActuelle-1] = null; 
                }
            }
        }
        else{
            if ($qst['Questions'][$_SESSION['qst_a_jouer'][$pageActuelle-1]]['type'] == "choixS") {
                $_SESSION['reponse'][$pageActuelle][0] = $_POST['vrai'];
                if (isset($_POST['vrai']) && $_POST['vrai'] == $qst['Questions'][$_SESSION['qst_a_jouer'][$pageActuelle-1]]['vrai'][0]) {
                    $_SESSION['score']+=$qst['Questions'][$_SESSION['qst_a_jouer'][$pageActuelle-1]]['score'];
                    $_SESSION['qst-trouver'][$pageActuelle-1] = $qst['Questions'][$_SESSION['qst_a_jouer'][$pageActuelle-1]];
                }
                else{
                    $_SESSION['qst-trouver'][$pageActuelle-1] = null; 
                }
            }
            elseif($qst['Questions'][$_SESSION['qst_a_jouer'][$pageActuelle-1]]['type'] == "choixT"){
                $_SESSION['reponse'][$pageActuelle][0] = $_POST['reponse'];
                if (isset($_POST['reponse']) && !strcasecmp($_POST['reponse'], $qst['Questions'][$_SESSION['qst_a_jouer'][$pageActuelle-1]]['reponse'])) {
                    $_SESSION['score']+=$qst['Questions'][$_SESSION['qst_a_jouer'][$pageActuelle-1]]['score'];
                    $_SESSION['qst-trouver'][$pageActuelle-1] = $qst['Questions'][$_SESSION['qst_a_jouer'][$pageActuelle-1]];
                }
                else{
                    $_SESSION['qst-trouver'][$pageActuelle-1] = null; 
                }
            }
        }
        header('location: index.php?lien=user&page=' . ($pageActuelle+1));    
}
if (isset($_POST['prec'])) {
    if($qst['Questions'][$_SESSION['qst_a_jouer'][$pageActuelle-2]]['type'] == "choixM"){
        if (count($_SESSION['reponse'][$pageActuelle - 1]) == count($qst['Questions'][$_SESSION['qst_a_jouer'][$pageActuelle-2]]['vrai'])) {
            if(in_array($_SESSION['reponse'][$pageActuelle-1][0], $qst['Questions'][$_SESSION['qst_a_jouer'][$pageActuelle-2]]['vrai']) && in_array($_SESSION['reponse'][$pageActuelle-1][1], $qst['Questions'][$_SESSION['qst_a_jouer'][$pageActuelle-2]]['vrai'])){
                $_SESSION['score']-=$qst['Questions'][$_SESSION['qst_a_jouer'][$pageActuelle-2]]['score'];
                $_SESSION['qst-trouver'][$pageActuelle-2] = null;
            }
        }
    }
    else{
        if ($qst['Questions'][$_SESSION['qst_a_jouer'][$pageActuelle-2]]['type'] == "choixS") {
            if (isset($_SESSION['reponse'][$pageActuelle-1][0]) && $_SESSION['reponse'][$pageActuelle-1][0] == $qst['Questions'][$_SESSION['qst_a_jouer'][$pageActuelle-2]]['vrai'][0]) {
                $_SESSION['score']-=$qst['Questions'][$_SESSION['qst_a_jouer'][$pageActuelle-2]]['score'];
                $_SESSION['qst-trouver'][$pageActuelle-2] = null;
            }
        }
        elseif($qst['Questions'][$_SESSION['qst_a_jouer'][$pageActuelle-2]]['type'] == "choixT"){
            if (isset($_SESSION['reponse'][$pageActuelle-1][0]) && $_SESSION['reponse'][$pageActuelle-1][0] == $qst['Questions'][$_SESSION['qst_a_jouer'][$pageActuelle-2]]['reponse']) {
                $_SESSION['score']-=$qst['Questions'][$_SESSION['qst_a_jouer'][$pageActuelle-2]]['score'];
                $_SESSION['qst-trouver'][$pageActuelle-2] = null;
            }
        }
    }
    header('location: index.php?lien=user&page=' . ($pageActuelle-1));
}
if (isset($_POST['terminer']) || isset($_POST['quitter'])) {
    $_SESSION['reponse'][$pageActuelle] = array();
        $_SESSION['reponse'][$pageActuelle][] = "";
        if($qst['Questions'][$_SESSION['qst_a_jouer'][$pageActuelle-1]]['type'] == "choixM"){
            $tmp = 0;
            for ($i=0; $i < 3 ; $i++) {
                if (isset($_POST['vrai'.$i])) {
                    $_SESSION['reponse'][$pageActuelle][$tmp++] = $_POST['vrai'.$i];
                }
            }
            if (count($_SESSION['reponse'][$pageActuelle]) == count($qst['Questions'][$_SESSION['qst_a_jouer'][$pageActuelle-1]]['vrai'])) {
                if(in_array($_SESSION['reponse'][$pageActuelle][0], $qst['Questions'][$_SESSION['qst_a_jouer'][$pageActuelle-1]]['vrai']) && in_array($_SESSION['reponse'][$pageActuelle][1], $qst['Questions'][$_SESSION['qst_a_jouer'][$pageActuelle-1]]['vrai'])){
                    $_SESSION['score']+=$qst['Questions'][$_SESSION['qst_a_jouer'][$pageActuelle-1]]['score'];
                    $_SESSION['qst-trouver'][$pageActuelle-1] = $qst['Questions'][$_SESSION['qst_a_jouer'][$pageActuelle-1]];
                }
            }
        }
        else{
            if ($qst['Questions'][$_SESSION['qst_a_jouer'][$pageActuelle-1]]['type'] == "choixS") {
                $_SESSION['reponse'][$pageActuelle][0] = $_POST['vrai'];
                if (isset($_POST['vrai']) && $_POST['vrai'] == $qst['Questions'][$_SESSION['qst_a_jouer'][$pageActuelle-1]]['vrai'][0]) {
                    $_SESSION['score']+=$qst['Questions'][$_SESSION['qst_a_jouer'][$pageActuelle-1]]['score'];
                    $_SESSION['qst-trouver'][$pageActuelle-1] = $qst['Questions'][$_SESSION['qst_a_jouer'][$pageActuelle-1]];
                }
            }
            elseif($qst['Questions'][$_SESSION['qst_a_jouer'][$pageActuelle-1]]['type'] == "choixT"){
                $_SESSION['reponse'][$pageActuelle][0] = $_POST['reponse'];
                if (isset($_POST['reponse']) && $_POST['reponse'] == $qst['Questions'][$_SESSION['qst_a_jouer'][$pageActuelle-1]]['reponse']) {
                    $_SESSION['score']+=$qst['Questions'][$_SESSION['qst_a_jouer'][$pageActuelle-1]]['score'];
                    $_SESSION['qst-trouver'][$pageActuelle-1] = $qst['Questions'][$_SESSION['qst_a_jouer'][$pageActuelle-1]];
                }
            }
        }
    header('location: index.php?lien=user&jeu=terminer&page='.$NbreDePage);
}
if (isset($_POST['reinitialiser'])) {
    $js['Users'][$ind_user]['qst-trouver'] = array();
    $js = json_encode($js);
    file_put_contents('fichier.json', $js);
    $js = file_get_contents('fichier.json');
    $js = json_decode($js, true);
    $_SESSION['qst_a_jouer'] =  array();
    $j = 0;
    while($j < $qst['nbre-qst']){
        $tmp = rand(0,(count($qst['Questions'])-1));
            if(!isset($js['Users'][$ind_user]['qst-trouver']) || (!in_array($qst['Questions'][$tmp],$js['Users'][$ind_user]['qst-trouver']) && !in_array($tmp,$_SESSION['qst_a_jouer']))) {
                $_SESSION['qst_a_jouer'][] = $tmp;
                $j++;
            }
        
    }
    header('location: index.php?lien=user');
}
$IndiceDepart = ($pageActuelle - 1)*$NbrValeurParPage;
$IndiceFin = $IndiceDepart + $NbrValeurParPage - 1;
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interface Joueur</title>
    <link href="style.css" rel="stylesheet" type="text/css">
</head>
    <body>
    
        <img class="img-haut" src="Images/logo-QuizzSA.png" />
        
            <div class="haut">  
                <h2> Le Plaisir de Jouer </h2>
            </div>
            <div class="milieuIJ">
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
                <div class="milieu1IJ">
                    <br/>
                    <div class="score">
                        <div class="T-score" <?php if ($_GET['score']) echo 'style ="background-color: white"' ?>><a href='index.php?lien=user&score=top_score&jeu=<?php echo $jeu ?>&page=<?php echo $pageActuelle ?>'>Top Score</a></div>
                        <div class="M-score"  <?php if (!$_GET['score']) echo 'style ="background-color: white"' ?>><a href='index.php?lien=user&score=mn_meilleur&jeu=<?php echo $jeu ?>&page=<?php echo $pageActuelle ?>'>Mon meilleur score</a></div>
                        <div class="affich-score" >
                            
                            <center>
                            <table>

                                <?php
                                    if (isset($_GET['score'])) {
                                        if ($_GET['score'] === 'top_score') {
                                            for ($i = 0; $i < 5  ; $i++) { 
                                                if(isset($js['Users'][$i])){
                                                    echo "<tr></tr><tr> <td>&nbsp;".$js['Users'][$i]['prenom']."</td> <td>".$js['Users'][$i]['nom']."</td> <td>".$js['Users'][$i]['pts']."  pts</td>   </tr>";
                                                }
                                            }
                                        }
                                        else{
                                            echo "<tr> <td>&nbsp;&nbsp;Meilleur Score</td> <td></td> <td>".$js['Users'][$ind_user]['pts']."  pts</td>   </tr>";
                                        }
                                    }
                                    
                                ?>
                            </table>
                            </center>

                        </div>
                    </div>
                    <div class="questions">
                        <div class="question">

                        
                            <?php  for ($i = $IndiceDepart; $i <= $IndiceFin  ; $i++) {
                                        if ($jeu === 'terminer') {
                                            $tmp = 0;
                                            echo '<h2><br/>Jeu terminer</h2><br/>Votre Score est '.$_SESSION['score'];
                                            echo '<div><br/><h2>Vous avez trouvé les questions suivantes:</h2>';
                                            if (isset($_SESSION['qst-trouver'])) {
                                                for ($j=0; $j < count($_SESSION['qst-trouver']); $j++) { 
                                                    if (in_array($qst['Questions'][$_SESSION['qst_a_jouer'][$j]],$_SESSION['qst-trouver'])) {
                                                        echo $_SESSION['qst-trouver'][$j]['question'].': '.$_SESSION['qst-trouver'][$j]['score'].' pts<br/>';
                                                        $tmp = 1;
                                                    }
                                                }
                                            }
                                            if (!$tmp) {
                                                echo 'Vous avez rien trouvé';
                                            }
                                            $tmp = 0;
                                            echo '<h2>Vous avez faussé les questions suivantes:</h2>';
                                            if (isset($_SESSION['qst-trouver'])) {
                                                for ($j=0; $j < $NbreDePage; $j++) { 
                                                    if (!in_array($qst['Questions'][$_SESSION['qst_a_jouer'][$j]],$_SESSION['qst-trouver'])) {
                                                        echo $qst['Questions'][$_SESSION['qst_a_jouer'][$j]]['question'].': '.$qst['Questions'][$_SESSION['qst_a_jouer'][$j]]['score'].' pts<br/>';
                                                        $tmp = 1;
                                                    }
                                                }
                                            }
                                            if (!$tmp) {
                                                echo 'Vous avez rien faussé';
                                            }
                                            
                                        }
                                        else{
                                            if (count($_SESSION['qst_a_jouer'])) {
                                                echo '<h2><br/>Question '.($i+1).'/'.$totalValeur.': </h2>';
                                                echo '<h2>'.   $qst['Questions'][$_SESSION['qst_a_jouer'][$i]]['question'].  '</h2>';
                                                echo '</div><br/><div class="pts">';
                                            
                                            
                                                echo '<h2 style="margin:0;text-align:center">'. $qst['Questions'][$_SESSION['qst_a_jouer'][$i]]['score'].' pts'. '</h2></div>';
                                            
                                                echo '<div class="reponses"><form method="POST">';
                                                if($qst['Questions'][$_SESSION['qst_a_jouer'][$i]]['type'] == "choixM"){
                                                    for($j = 0; $j < count($qst['Questions'][$_SESSION['qst_a_jouer'][$i]]['reponse']); $j++){ 
                                                        echo '<input type="checkbox" name="vrai'.$j.'" value= "'.$qst['Questions'][$_SESSION['qst_a_jouer'][$i]]['reponse'][$j].'"';
                                                        if (isset($_SESSION['reponse'][$pageActuelle]) && in_array($qst['Questions'][$_SESSION['qst_a_jouer'][$i]]['reponse'][$j], $_SESSION['reponse'][$pageActuelle])) {
                                                            echo 'checked';
                                                        }
                                                        echo '/>'.$qst['Questions'][$_SESSION['qst_a_jouer'][$i]]['reponse'][$j].'<br/>'; 
                                                    }
                                                }
                                                else{
                                                    if($qst['Questions'][$_SESSION['qst_a_jouer'][$i]]['type'] == "choixS"){
                                                        
                                                        echo '<form method="POST">'; 
                                                        
                                                        for($j = 0; $j < count($qst['Questions'][$_SESSION['qst_a_jouer'][$i]]['reponse']); $j++){
                                                            echo '<input type="radio" name="vrai" value= "'.$qst['Questions'][$_SESSION['qst_a_jouer'][$i]]['reponse'][$j].'"';
                                                        if (isset($_SESSION['reponse'][$pageActuelle]) && in_array($qst['Questions'][$_SESSION['qst_a_jouer'][$i]]['reponse'][$j],$_SESSION['reponse'][$pageActuelle])) {
                                                                echo 'id = "choqué"';
                                                            }
                                                            echo '/> '.$qst['Questions'][$_SESSION['qst_a_jouer'][$i]]['reponse'][$j].'<br/>';
                                                        }
                                                            echo '<script> document.getElementById("choqué").checked = true; </script>';
                                                        
                                                        echo '<form/>';
                                                    break;

                                                    }
                                                    else{
                                                        echo '<input class="inputText" type="text" name="reponse" placeholder="&nbsp; Reponse"';
                                                        if (isset($_SESSION['reponse'][$pageActuelle])) {
                                                            echo 'value="'.$_SESSION['reponse'][$pageActuelle][0].'"';
                                                        }
                                                        echo '/>';
                                                        }

                                                }
                                            }
                                            else{
                                                echo '<h2><br/>Vous avez Touver tous les questions de ce Quizz</h2>';
                                            }
                                        }
                                    }
                            ?>
                        </div>
                        <div class="bouton"> 
                            <form method="POST">
                                <?php 
                                    if( $pageActuelle != 1  && $jeu != 'terminer'){
                                        echo '<input class="prec" type="submit" name="prec" value="Précédent">';
                                    }
                                    if( $pageActuelle != $NbreDePage && $NbreDePage){
                                        echo '<input class="Suiv" type="submit" name="suivant" value="Suivant"/>';
                                        echo '<input class="quit" type="submit" name="quitter" value="Quitter"/>';
                                    }
                                    else{

                                        if ($jeu === "terminer" && !isset($_POST['rejouer'])) {
                                            echo '<input class="rejouer" type="submit" name="rejouer" value="Rejouer" />';
                                            if($js['Users'][$ind_user]['pts'] < $_SESSION['score']){
                                                $js['Users'][$ind_user]['pts'] = $_SESSION['score'];
                                            }
                                            if (isset($_SESSION['qst-trouver'])) {
                                                for ($i=0; $i < count($_SESSION['qst-trouver']) ; $i++) { 
                                                    if (isset($_SESSION['qst-trouver'][$i])){
                                                        $js['Users'][$ind_user]['qst-trouver'][] = $_SESSION['qst-trouver'][$i];
                                                    }
                                                }
                                            }
                                            $js = json_encode($js);
                                            file_put_contents('fichier.json', $js);
                                        }
                                        elseif($NbreDePage){
                                            echo '<input class="Suiv" type="submit" name="terminer" value="Terminer" />';
                                        }
                                        else{
                                            echo '<input class="Suiv" type="submit" name="reinitialiser" value="Reinitialiser" />';
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
                            </form>
                        </div>
                    

                    </div>
                    
                    
                    
                    

                </div>
            </div>
        
    </body>
</html>

