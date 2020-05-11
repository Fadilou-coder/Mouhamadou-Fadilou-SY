<?php
session_start();
if(!($_SESSION['Admin'])){
    header('location: index.php');
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
                            <li><a href="index.php?lien=liste_qst">&nbsp;&nbsp;&nbsp;Liste Questions <img class="icones" src="Images\Icones\ic-liste.png"/></a></li>
                            <li><a class="active" href="index.php?lien=admin"><div></div>&nbsp;&nbsp;&nbsp;Creer Admin <img class="icones" src="Images\Icones\ic-ajout-active.png"/> </a></li>
                            <li><a href="index.php?lien=liste_jr">&nbsp;&nbsp;&nbsp;Liste Joueurs <img class="icones" src="Images\Icones\ic-liste.png"/> </a></li>
                            <li><a href="index.php?lien=creer_qst">&nbsp;&nbsp;&nbsp;Creer Questions <img class="icones" src="Images\Icones\ic-ajout-active.png"/> </a></li>
                            <li><a href="index.php?lien=statistiques">&nbsp;&nbsp;&nbsp;Statistiques <img class="icones" src="Images\Icones\ic-sta.png"/> </a></li>
                        </ul>

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
                    <form action="CreationCompteAdmin.php" method="POST" enctype="multipart/form-data" id="form-creer">
                        <label>Prénom</label>
                        <input error="error-1" class="inputText" type="text" name="prenom" placeholder="&nbsp; Aaaaa" value="<?php if(!empty($_POST['prenom'])) echo $_POST['prenom'] ?>"/>
                        <div class="error-form" id="error-1"></div>
                        <br/><br/>
                        <label>Nom&nbsp;&nbsp;</label>
                        <input error="error-2" class="inputText" type="tex" name="nom" placeholder="&nbsp; BBBB" value="<?php if(!empty($_POST['nom'])) echo $_POST['nom'] ?>"/>
                        <div class="error-form" id="error-2"></div>
                        <br/><br/>
                        <label>Login</label>
                        <input error="error-3" class="inputText" type="text" name="login" placeholder="&nbsp; aabbaabb" value="<?php if(!empty($_POST['login'])) echo $_POST['login'] ?>"/>
                        <div class="error-form" id="error-3"></div>
                        <br/><br/>
                        <label>Password</label>
                        <input error="error-4" class="inputText" type="password" name="password1" placeholder="&nbsp; Password"/>
                        <div class="error-form" id="error-4"></div>
                        <br/><br/>
                        <label>Confirmer Password</label>
                        <input error="error-5" class="inputText" type="password" name="password" placeholder="&nbsp; Confirmer"/>
                        <div class="error-form" id="error-5"></div>
                        <br/><br/>
                        <label>Avatar</label>
                        <input error="error-6" class="fichier" type="file" name="fichier" id="fichier" accept="image/*" onchange="loadFile(event)"/>
                        <br/><br/><br/>
                        <div class="error-form" id="error-6"></div><br/>
                        <button class="submit1" type="submit" name="valider">Créer Compte</button>
                    </form>
                    </div>
                    </div>
                    
                    
                    

                </div>
            </div>

                    <script type="text/javascript">
                            const inputs = document.getElementsByTagName("input");
                            for(input of inputs){
                                input.addEventListener("keyup",function(e){
                                    if(e.target.hasAttribute("error")){
                                        var idDivError = e.target.getAttribute("error");
                                        document.getElementById(idDivError).innerText = ""
                                    }
                                })
                            }
                            document.getElementById("form-creer").addEventListener("submit",function(e){
                                const inputs = document.getElementsByTagName("input");
                                var error = false;
                                for(input of inputs){
                                    if(input.hasAttribute("error")){
                                        idDivError = input.getAttribute("error")
                                        if(!input.value){
                                                document.getElementById(idDivError).innerText = "ce champs est obligatoire";
                                                error = true;
                                        }
                                        
                                        
                                    }else{
                                            document.getElementById(idDivError).innerText = "";
                                        }
                                }
                                if(error){
                                    e.preventDefault();
                                    return false;
                                }

                                
                            })
                    
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
}  



?>