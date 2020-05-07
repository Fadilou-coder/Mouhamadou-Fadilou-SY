<?php
session_start();
if(!$_SESSION['Admin']){
    header('location: index.php');
}

$js = file_get_contents('fichier.json');
$js = json_decode($js, true);

foreach ($js['Users'] as $key => $row) {
    $pts[$key]  = $row['pts'];;
}
array_multisort($pts, SORT_DESC, $js['Users']);

$NbrValeurParPage = 15;
$totalValeur = count($js['Users']);
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
    header('location: index.php?lien=liste_jr&page='.($pageActuelle+1));
}
if (isset($_POST['prec'])) {
    header('location: index.php?lien=liste_jr&page='.($pageActuelle-1));
}
$IndiceDepart = ($pageActuelle - 1)*$NbrValeurParPage;
$IndiceFin = $IndiceDepart + $NbrValeurParPage - 1;
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste Joueurs</title>
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
                        <div style="height: 50%; background-color: #73DEF0;">
                            <div style="width: 50%; margin-left:20%; margin-top: 10%" class="avatar">
                                <img class="photo"  src=" <?php echo $_SESSION['profil']  ?>" />
                                <h1>
                                    <?php echo $_SESSION['prenom']." ".$_SESSION['nom'] ?>
                                </h1>

                            </div>
                        </div>
                        
                        <ul>
                            <li><a href="index.php?lien=liste_qst">&nbsp;&nbsp;&nbsp;Liste Questions <img class="icones" src="Images\Icônes\ic-liste.png"/></a></li>
                            <li><a href="index.php?lien=admin">&nbsp;&nbsp;&nbsp;Creer Admin <img class="icones" src="Images\Icônes\ic-ajout-active.png"/> </a></li>
                            <li><a class="active" href="index.php?lien=liste_jr"><div></div>&nbsp;&nbsp;&nbsp;Liste Joueurs <img class="icones" src="Images\Icônes\ic-liste.png"/> </a></li>
                            <li><a href="index.php?lien=creer_qst">&nbsp;&nbsp;&nbsp;Creer Questions <img class="icones" src="Images\Icônes\ic-ajout-active.png"/> </a></li>
                            <li><a href="index.php?lien=statistiques">&nbsp;&nbsp;&nbsp;Statistiques <img class="icones" src="Images\Icônes\ic-sta.png"/> </a></li>
                        </ul>

                    </div>
                    <div class="CreerAdmin">
                        <center>
                        <h1>LISTE DES JOUEURS</h1>
                        <table>
                            <tr><th>&nbsp;&nbsp;Prénoms: </th><th>Noms: </th><th>Score: </th></tr>
                            <?php 
                                    for ($i = $IndiceDepart; $i <= $IndiceFin  ; $i++) { 
                                        if(isset($js['Users'][$i])){
                                            echo "<tr> <td>&nbsp;&nbsp;".$js['Users'][$i]['prenom']."</td> <td>".$js['Users'][$i]['nom']."</td> <td>".$js['Users'][$i]['pts']."  pts</td>   </tr>";
                                        }
                                    }
                            ?>
                        </table>
                        </center>
                        <div class="liste-Joueur-suivant">
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
