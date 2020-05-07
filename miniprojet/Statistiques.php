<?php
session_start();
if(!$_SESSION['Admin']){
    header('location: PageConnexion.php');
}

$users = file_get_contents('fichier.json');
$users = json_decode($users, true);
$qst = file_get_contents('question.json');
$qst = json_decode($qst, true);
$smpl = 0;
$mult = 0;
$text =0;
for ($i=0; $i < count($qst['Questions']) ; $i++) { 
    if ($qst['Questions'][$i]['type'] === 'choixM') {
        $mult++;
    }
    else {
        if ($qst['Questions'][$i]['type'] === 'choixS') {
            $smpl++;
        }
        else{
            $text++;
        }

    }
}
$nbr_Joueurs = count($users['Users']);
$nbr_Admins = count($users['Admins']);
if (!isset($_GET['page'])) {
    $_GET['page'] = 1;
}
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <title>Statistiques</title>
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
                            <li><a href="index.php?lien=liste_jr">&nbsp;&nbsp;&nbsp;Liste Joueurs <img class="icones" src="Images\Icônes\ic-liste.png"/> </a></li>
                            <li><a href="index.php?lien=creer_qst">&nbsp;&nbsp;&nbsp;Creer Questions <img class="icones" src="Images\Icônes\ic-ajout-active.png"/> </a></li>
                            <li><a class="active" href="index.php?lien=statistiques"><div></div>&nbsp;&nbsp;&nbsp;Statistiques <img class="icones" src="Images\Icônes\ic-sta.png"/> </a></li>
                        </ul>

                    </div>
                    <div class="Liste-qst">
                        <div class="bordure-silver">                       
                                <div class="lien-sta"> <a href='Statistiques.php?page=1'>Utilisateurs</a> </div>
                                <div class="lien-sta"> <a href='Statistiques.php?page=2'>Questions</a> </div>
                                <div class="lien-sta"> <a href='Statistiques.php?page=3'>Scores</a> </div>
                                <div>
                                    <center>

                                        <?php
                                                if ($_GET['page'] == 1) {
                                                    echo '<div "><canvas style="width: 70%; height:60%"  id="Compte"></canvas></div>';
                                                }
                                                else{
                                                    if ($_GET['page'] == 2) {
                                                        echo '<div><canvas style="width: 70%; height:60%"  id="Questions"></canvas></div>';
                                                    }
                                                    else{
                                                        echo '<div><canvas style="width: 70%; height:60%"  id="Score"></canvas></div>';
                                                    }
                                                }
                                        ?>
                                    </center>

                                </div>
                        </div>
                    </div>
                    
                    

                </div>
            </div>

            <script>
                var ctx = document.getElementById('Compte');
                var myChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ['Administrateur', 'Joueur'],
                        datasets: [{
                            data: [<?php echo $nbr_Admins.','.$nbr_Joueurs; ?>],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        },
                        title: {
                            display: true,
                            text: 'Représentation du Graphe des Utilisaters',
                            position: 'bottom'
                        },
                    }
                });
            </script>

            <script>
                var ctx = document.getElementById('Questions').getContext('2d');
                var chart = new Chart(ctx, {
                    // The type of chart we want to create
                    type: 'line',
                    data: {
                        labels: ['TEXT', 'Simple', 'Multiple'],
                        datasets: [{
                            label: 'Nombre',
                            backgroundColor: 'rgb(255, 99, 132, 0.25)',
                            borderColor: 'rgb(255, 99, 132)',
                            data: [<?php echo $text.','.$smpl.','.$mult  ?>]
                        }]
                    },

                    // Configuration options go here
                    options: {
                        title: {
                            display: true,
                            text: 'Représentation du nombre de questions en foncttion du type',
                            position: 'bottom'
                        },


                    }
                });
            </script>

            <script>
                var ctx = document.getElementById('Score');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: [
                            <?php
                                for ($i = 0; $i < 5  ; $i++) { 
                                    if(isset($users['Users'][$i])){
                                        echo "'".$users['Users'][$i]['prenom'].' '.$users['Users'][$i]['nom']."',";
                                    }
                                }
                            ?>
                        ],
                        datasets: [{
                            label: 'Score',
                            data: [
                                <?php
                                    for ($i = 0; $i < 5  ; $i++) { 
                                        if(isset($users['Users'][$i])){
                                            echo $users['Users'][$i]['pts'].",";
                                        }
                                    }
                                ?>
                            ],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)',
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)',
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        },
                        title: {
                            display: true,
                            text: 'Représentation des Meilleurs Scores',
                            position: 'bottom'
                        },
                    }
                });
            </script>
        
    </body>
</html>

