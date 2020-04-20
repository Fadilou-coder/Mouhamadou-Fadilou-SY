<?php
session_start();
if(!($_SESSION['Admin'])){
    header('location: PageConnexion.php');
}
if(isset($_POST['deconnexion'])){
    header('location: deconnexion.php');
}

?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création Compte Admin</title>
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
                        <form action="CreationCompteAdmin.php" method="POST">
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
                            <a class="icones" href="ListeQuestions.php">
                               <img  src="Images\Icônes\ic-liste.png"/>
                            </a>
                            &nbsp;&nbsp;&nbsp; Liste Questions    
                        </div>
                        
                        <div style="background-color:   silver;" class="liste">
                            <div class="list-courant"></div>
                            <a class="icones" href="CreerCompteAdmin.php">
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
                    <div class="CreerAdmin">
                    <div style="margin-left: 20px">
                    <h1>S'INSCRIRE</h1>
                    <h3>Pour proposer des quizz</h3>
                    <div class="trait" style="width: 60%; margin-left: 0%"></div>
                    </div>
                    <div class="img-admin">
                        <img id="output" class="output"/>
                    </div>
                    <div class = "forme" style="margin-left: 20px">
                    <form action="CreationCompteAdmin.php" method="POST" enctype="multipart/form-data">
                        <br/>
                        <label>Prénom</label>
                        <input class="inputText" type="text" name="prenom" placeholder="&nbsp; Aaaaa" value="<?php if(!empty($_POST['prenom'])) echo $_POST['prenom'] ?>"/>
                        <br/>
                        <label>Nom&nbsp;&nbsp;</label>
                        <input class="inputText" type="tex" name="nom" placeholder="&nbsp; BBBB" value="<?php if(!empty($_POST['nom'])) echo $_POST['nom'] ?>"/>
                        <br/>
                        <label>Login</label>
                        <input class="inputText" type="text" name="login" placeholder="&nbsp; aabbaabb" value="<?php if(!empty($_POST['login'])) echo $_POST['login'] ?>"/>
                        <br/>
                        <label>Password</label>
                        <input class="inputText" type="password" name="password1" placeholder="&nbsp; Password"/>
                        <br/>
                        <label>Confirmer Password</label>
                        <input class="inputText" type="password" name="password" placeholder="&nbsp; Confirmer"/>
                        <br/><br/>
                        <label>Avatar</label>
                        <input class="fichier" type="file" name="fichier" id="fichier" accept="image/*" onchange="loadFile(event)"/>
                        <br/><br/><br/>
                        <input class="submit1" type="submit" name="valider" value="Créer Compte" />
                    </form>
                    </div>
                    </div>
                    
                    

                </div>
            </div>
        <script>
            var loadFile = function(event) {
                var output = document.getElementById('output');
                output.src = URL.createObjectURL(event.target.files[0]);
                output.onload = function() {
                    URL.revokeObjectURL(output.src)
                }
            };
        </script>
        
    </body>
</html>

<?php

if(isset($_POST['valider'])){
    if(!empty($_POST['prenom']) && !empty($_POST['nom']) && !empty($_POST['login']) && !empty($_POST['password1']) &&  !empty($_POST['password'])){
       $login = $_POST['login'];
       $password = $_POST['password'];
       $password1 = $_POST['password1'];
       $prenom = $_POST['prenom'];
       $nom = $_POST['nom'];

       
       /* verifier si les mots de passe correspondent*/

       if ($password == $password1){
       /* ranger les données dans un tableau admin*/
           $admin = array();
           $admin['prenom'] = $prenom;
           $admin['nom'] = $nom;
           $admin['login'] = $login;
           $admin['password'] = $password;

           /* Stocker le tableau admin dans le fichier.json*/

           $js = file_get_contents('fichier.json');
           $js = json_decode($js, true);
           $tmp = 1;
           if ($js) {
                for ($i=0; $i < count($js['Users']) ; $i++) { 
                    if ($js['Users'][$i]['login'] == $login) {
                        $tmp = 0;
                    break;
                    }
                }
                for ($i=0; $i < count($js['Admins']) ; $i++) { 
                    if ($js['Admins'][$i]['login'] == $login) {
                        $tmp = 0;
                    break;
                    }
                }
           }
           
           if ($tmp) {
           /* stocker l'image dans le fichier img-admin*/
               $chemin = "img-admin/";
               $photo = $chemin.basename($_FILES["fichier"]["name"]);
               $uploadOk = 1;
               $Type = strtolower(pathinfo($photo,PATHINFO_EXTENSION));   
               $profil = $login.".";
               $profil .= $Type;
               $profil = $chemin.$profil;
               $admin['profil'] = $profil;
           
               if($Type != "jpg" && $Type != "png" && $Type != "jpeg") {
                   echo "Désolé, les fichiers JPG, JPEG et PNGsont autorisés.";
                   $uploadOk = 0;
               }
           
               if ($uploadOk == 0) {
                   echo "<br/><strong>Désolé, Votre photo n'est pas téléchargé.</strong>";
           
               } else {
                   if (move_uploaded_file($_FILES["fichier"]["tmp_name"], $profil)) {
                       $js['Admins'][] = $admin;
                       $js = json_encode($js);
                       file_put_contents('fichier.json', $js);
                       ?>
                       <script>alert('Créer avec succès')</script>
                       <?php
                   } else {
                       echo "<br/><strong>Désolé, Erreur de téléchargement du photo.</strong>";
                   }
               }
               
           }
           else{
               echo " <center><strong>Ce login existe deja!!!.</strong></center>";
           }
           
       }
       else
       {
           echo " <center><strong>Les deux mots de passe ne correspondent pas.</strong></center>";
       }
   }
   else
   {
       echo " <center><strong>Remplir tous les champs!!!</strong></center>";
   }
}  



?>