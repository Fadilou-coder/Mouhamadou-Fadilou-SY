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

$users = file_get_contents('fichier.json');
$users = json_decode($users, true);
$qst = file_get_contents('question.json');
$qst = json_decode($qst, true);
$nbr_Joueurs = count($users['Users']);
$nbr_Admins = count($users['Admins']);
foreach ($users['Users'] as $key => $row) {
    $pts[$key]  = $row['pts'];
}
array_multisort($pts, SORT_DESC, $users['Users']);

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
                        
                        <div class="liste">
                            <a class="icones" href="index.php?lien=liste_qst">
                               <img  src="Images\Icônes\ic-liste.png"/>
                            </a>
                            &nbsp;&nbsp;&nbsp; Liste Questions    
                        </div>
                        
                        <div class="liste">
                            <a class="icones" href="index.php?lien=admin">
                               <img  src="Images\Icônes\ic-ajout-active.png"/>
                            </a>
                            &nbsp;&nbsp;&nbsp; Créer Admin 
                        </div>
                        <div class="liste">           
                               <a class="icones" href="index.php?lien=liste_jr">
                               <img  src="Images\Icônes\ic-liste.png"/>
                               </a>
                            &nbsp;&nbsp;&nbsp; Liste Joueurs   
                        </div>
                        
                        <div class="liste">
                            <a class="icones" href="index.php?lien=creer_qst">
                               <img  src="Images\Icônes\ic-ajout-active.png"/>
                            </a>
                            &nbsp;&nbsp;&nbsp; Créer Questions 
                        </div>

                        <div class="liste" style="background-color:   silver;">
                            <div class="list-courant"></div>
                            <a class="icones" href="index.php?lien=statistiques">
                            <img  src="Images\Icônes\ic-sta.png"/>
                            </a>
                            &nbsp;&nbsp;&nbsp; Statistiques 
                        </div>

                    </div>
                    <div class="Liste-qst">
                        <div class="bordure-silver">                       
                                <div style="width: 33%; float: left; text-align: center"> <a href='Statistiques.php?page=1'>Utilisateurs</a> </div>
                                <div style="width: 33%; float: left; text-align: center"> <a href='Statistiques.php?page=2'>Questions</a> </div>
                                <div style="width: 34%; float: left; text-align: center"> <a href='Statistiques.php?page=3'>Scores</a> </div>
                                <div>
                                    <center>

                                        <?php
                                                if ($_GET['page'] == 1) {
                                                    echo '<div style="width: 90%"><canvas id="Compte"></canvas></div>';
                                                }
                                                else{
                                                    if ($_GET['page'] == 2) {
                                                        echo '<div style="width: 90%"><canvas id="Questions"></canvas></div>';
                                                    }
                                                    else{
                                                        echo '<div style="width: 90%"><canvas id="Score"></canvas></div>';
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
                            data: [10, 25, 2]
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

