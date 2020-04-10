<?php
session_start();
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link href="style.css" rel="stylesheet" type="text/css">
</head>
    <body>
    
        <img class="img-haut" src="Images/logo-QuizzSA.png" />
        <center>
            <div class="haut">
                
                <h2> Le Plaisir de Jouer </h2>
            </div>
            <div class = "admin">
            <br/><br/><br/><br/>
            <div class = "loginForm"><h1>&nbsp; Login Form: </h1></div>
                    <div class = "forme">
                        <form action="PageConnexion.php" method="POST">
                            <br/>
                            <input class="inputText" type="text" name="login" placeholder="&nbsp; Login" value="<?php if(!empty($_POST['login'])) echo $_POST['login'] ?>"/>
                            <img src="Images/Icônes/ic-login.png" />
                            <br/><br/><br/>
                                <input class="inputText" type="password" name="password" placeholder="&nbsp; Password"/>
                                <img src="Images/Icônes/ic-login.png" />
                                <br/><br/><br/>
                                <input class="submit" type="submit" name="connexion" value="Connexion" />
                                <a href="CreationCompteUser.php">S'inscrire pour Jouer?</a>
                        </form>
                    </div>
            </div>
        </center>
        
    </body>
</html>
<?php

if(isset($_POST['connexion'])){
    if(!empty($_POST['login']) && !empty($_POST['password'])){
        $login = $_POST['login'];
        $password = $_POST['password'];
        $js = file_get_contents('fichier.json');
        $js = json_decode($js, true);
        $user = "";
        for ($i=0; $i < count($js['Users']) ; $i++) { 
            if($js['Users'][$i]['login'] == $login && $js['Users'][$i]['password'] == $password){
                $user = "user";
                $prenom = $js['Users'][$i]['prenom'];
                $nom = $js['Users'][$i]['nom'];
                $profil = $js['Users'][$i]['profil'];
            break;
            }
        }
        for ($i=0; $i < count($js['Admins']) ; $i++) {
            
                if ($js['Admins'][$i]['login'] == $login && $js['Admins'][$i]['password'] == $password) {
                    $user = "admin";
                    $prenom = $js['Admins'][$i]['prenom'];
                    $nom = $js['Admins'][$i]['nom'];
                    $profil = $js['Admins'][$i]['profil'];
                break;
                }
            
        }
        
        if($user == "user"){
            $_SESSION['User'] = 'connect';
            $_SESSION['prenom'] = $prenom;
            $_SESSION['nom'] = $nom;
            $_SESSION['profil'] = $profil;
            $user = "";
            header('location: Interface_Joueur.php');
        }
        else{
            if($user == "admin"){
                $_SESSION['Admin'] = 'connect';
                $_SESSION['prenom'] = $prenom;
                $_SESSION['nom'] = $nom;
                $_SESSION['profil'] = $profil;
                $_SESSION['nbreM'] = 0;
                $_SESSION['nbreS'] = 0;
                $user = "";
                header('location: CreationCompteAdmin.php');
            }
            else{
                echo " <center><strong>Login ou mot de passe incorrecte</strong></center>";
            }
        }
    }
    else{
        echo " <center><strong>Saisir le Login et le mot de passe </strong></center>";
    }
}

?>