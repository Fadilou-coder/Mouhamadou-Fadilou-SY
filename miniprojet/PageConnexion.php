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
                            <form action="" method="POST" id="form-connexion">
                                <br/>
                                <input class="inputText" type="text" error="error1" name="login" placeholder="&nbsp; Login" value="<?php if(!empty($_POST['login'])) echo $_POST['login'] ?>"/>
                                <img src="Images/Icones/ic-login.png" />
                                <div class="error-form" id="error1"></div>
                                <br/><br/>
                                    <input class="inputText" type="password" error="error2" name="password" placeholder="&nbsp; Password"/>
                                    <img src="Images/Icones/ic-psw.png" />
                                    <div class="error-form" id="error2"></div>
                                    <br/><br/><br/>
                                    <button class="submit" type="submit" name="connexion">Connexion</button>
                                    <a href="index.php?lien=creer_jr">S'inscrire pour Jouer?</a>
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
                $login = $js['Users'][$i]['login'];
                $prenom = $js['Users'][$i]['prenom'];
                $nom = $js['Users'][$i]['nom'];
                $profil = $js['Users'][$i]['profil'];
                $qst = file_get_contents('question.json');
                $qst = json_decode($qst, true);
                if (isset($js['Users'][$i]['qst-trouver'])) {
                    if (count($qst['Questions']) - count($js['Users'][$i]['qst-trouver'])>=$qst['nbre-qst'] ) {
                        $j = 0;
                    }
                    else{
                        $j = $qst['nbre-qst']-(count($qst['Questions'])-count($js['Users'][$i]['qst-trouver']));
                    }
                }
                else{
                    $j = 0;
                }
                $_SESSION['qst_a_jouer'] =  array();
                while($j < $qst['nbre-qst']){
                    $tmp = rand(0,(count($qst['Questions'])-1));
                    if(!isset($js['Users'][$i]['qst-trouver']) || !in_array($qst['Questions'][$tmp],$js['Users'][$i]['qst-trouver']) ) {
                        if(!in_array($tmp,$_SESSION['qst_a_jouer'])){
                            $_SESSION['qst_a_jouer'][] = $tmp;
                            $j++;
                        }
                    } 
                }
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
            $_SESSION['login'] = $login;
            $_SESSION['prenom'] = $prenom;
            $_SESSION['nom'] = $nom;
            $_SESSION['profil'] = $profil;
            $_SESSION['score'] = 0;
            header('location: index.php?lien='.$user);
        }
        else{
            if($user == "admin"){
                $_SESSION['Admin'] = 'connect';
                $_SESSION['prenom'] = $prenom;
                $_SESSION['nom'] = $nom;
                $_SESSION['profil'] = $profil;
                header('location: index.php?lien='.$user);
            }
            else{
                echo " <center><strong>Login ou mot de passe incorrecte</strong></center>";
            }
        }
    }

}

?>

            <script>
                const inputs = document.getElementsByTagName("input");
                for(input of inputs){
                    input.addEventListener("keyup",function(e){
                        if(e.target.hasAttribute("error")){
                            var idDivError = e.target.getAttribute("error");
                            document.getElementById(idDivError).innerText = ""
                        }
                    })
                }
                document.getElementById("form-connexion").addEventListener("submit",function(e){
                    const inputs = document.getElementsByTagName("input");
                    var error = false;
                    for(input of inputs){
                        if(input.hasAttribute("error")){
                            idDivError = input.getAttribute("error");
                            if(!input.value){
                                    document.getElementById(idDivError).innerText = "ce champs est obligatoire"
                                    error = true;
                            }
                            
                            
                        }else{
                                document.getElementById(idDivError).innerText = ""
                            }
                    }
                    if(error){
                        e.preventDefault();
                        return false;
                    }
                })
            </script>