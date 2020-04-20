<?php
session_start();
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création Compte</title>
    <link href="style.css" rel="stylesheet" type="text/css">
</head>
    <body>
    
        <img class="img-haut" src="Images/logo-QuizzSA.png" />
        <center>
            <div class="haut">    
                <h2> Le Plaisir de Jouer </h2>
            </div>
            <div class="milieuCCUser">
                <div class="FormCCUser">
                    <h1>S'INSCRIRE</h1>
                    <h3>Pour tester votre niveau de culture générale</h3>
                    <div class="trait"></div>
                    <div class="img-user">
                        <img id="output" class="output"/>
                    </div>
                <div class = "forme">
                    <form action="CreationCompteUser.php" method="POST" enctype="multipart/form-data">
                        <br/>
                        <label>Prénom</label>
                        <input class="inputText" type="text" name="prenom" placeholder="&nbsp; Aaaaa" value="<?php if(!empty($_POST['prenom'])) echo $_POST['prenom'] ?>"/>
                        <br/>
                        <label>Nom&nbsp;&nbsp;&nbsp;</label>
                        <input class="inputText" type="tex" name="nom" placeholder="&nbsp; BBBB" value="<?php if(!empty($_POST['nom'])) echo $_POST['nom'] ?>"/>
                        <br/>
                        <label>Login&nbsp;&nbsp;</label>
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

        </center>
        <script>
            var loadFile = function(event) {
                var output = document.getElementById('output');
                output.src = URL.createObjectURL(event.target.files[0]);
                output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
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
        /* ranger les données dans un tableau user*/
            $user = array();
            $user['prenom'] = $prenom;
            $user['nom'] = $nom;
            $user['login'] = $login;
            $user['password'] = $password;
            $user['pts'] = 0;

            /* Stocker le tableau user dans le fichier.json*/

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
            /* stocker l'image dans le fichier img-user*/
                $chemin = "img-user/";
                $photo = $chemin.basename($_FILES["fichier"]["name"]);
                $uploadOk = 1;
                $Type = strtolower(pathinfo($photo,PATHINFO_EXTENSION));   
                $profil = $login.".";
                $profil .= $Type;
                $profil = $chemin.$profil;
                $user['profil'] = $profil;
            
                if($Type != "jpg" && $Type != "png" && $Type != "jpeg"
                && $Type != "gif" ) {
                    echo "Désolé, les fichiers JPG, JPEG, PNG & GIF sont autorisés.";
                    $uploadOk = 0;
                }
            
                if ($uploadOk == 0) {
                    echo "<br/><strong>Désolé, Votre photo n'est pas téléchargé.</strong>";
            
                } else {
                    if (move_uploaded_file($_FILES["fichier"]["tmp_name"], $profil)) {
                        $js['Users'][] = $user;
                        $js = json_encode($js);
                        file_put_contents('fichier.json', $js);
                        header('location: PageConnexion.php');
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