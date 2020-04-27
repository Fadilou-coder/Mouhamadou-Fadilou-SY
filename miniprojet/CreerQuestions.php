<?php
session_start();
if(!$_SESSION['Admin']){
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
    <title>Creer Questions</title>
    <link href="style.css" rel="stylesheet" type="text/css">
    <script type="text/javascript">
            var nbInput = 0;
            var tmp = "";
            function ajouterChamps()
            {
                var formulaire = document.getElementById('formulaire');
                var type = document.getElementById('type').value;
                formulaire.appendChild(document.createElement("br"));
                formulaire.appendChild(document.createElement("br"));
                if(type == 'choixT'){
                    if (tmp && tmp != 'choixT') {
                        formulaire.innerText = '';
                        formulaire.innerHTML = '</br>';
                        nbInput = 0;
                        tmp = 'choixT'

                    }
                    if(nbInput > 0){
                        alert('Vous avez droit à un seul champs de type text');
                    }
                    else{
                        tmp = 'choixT';
                        nbInput++;
                        label = document.createElement("label");
                        label.innerHTML = "Reponse &nbsp;&nbsp;&nbsp;";
                        champ = document.createElement("input");
                        champ.setAttribute("type","text"); 
                        champ.setAttribute("name","reponse");
                        champ.setAttribute("class","inputText");
                        champ.setAttribute("style","background-color: #F5F5F5; width: 65%");
                        formulaire.appendChild(label);
                        formulaire.appendChild(champ);
                    }
                }
                else{
                    if(type == 'choixM'){
                        if (tmp && tmp != 'choixM') {
                            formulaire.innerText = '';
                            formulaire.innerHTML = '</br>';
                            nbInput = 0;
                            tmp = 'choixM'
                        }
                        if(nbInput >= 3){
                            alert('le nombre de reponses max est 3');
                        }
                        else{
                            tmp = 'choixM';
                            div = document.createElement("div");
                            div.setAttribute("id","ligne"+nbInput);
                            formulaire.appendChild(div);
                            var ligne = document.getElementById("ligne"+nbInput);
                            label = document.createElement("label");
                            label.innerHTML = "Reponse "+(nbInput+1)+" &nbsp;&nbsp;&nbsp;";
                            ligne.appendChild(label);
                            champ = document.createElement("input");
                            champ.setAttribute("type","text");
                            champ.setAttribute("name","reponse"+nbInput);
                            champ.setAttribute("class","inputText");
                            champ.setAttribute("style","background-color: #F5F5F5; width: 65%");
                            ligne.appendChild(champ);
                            check = document.createElement("input");
                            check.setAttribute("type","checkbox");
                            check.setAttribute("name","vrai"+nbInput);
                            ligne.appendChild(check);
                            btn = document.createElement("button");                                
                            btn.setAttribute("type","button");
                            btn.setAttribute("name","supp"+nbInput);
                            btn.innerHTML = '<img style="margin:0;"  src="Images/Icônes/ic-supprimer.png" onclick="supp_champs('+nbInput+')" />';
                            ligne.appendChild(btn);
                            nbInput++;
                        }
                                
                    }
                    else{
                        if(type == 'choixS')
                        {  
                            if (tmp && tmp != 'choixS') {
                                formulaire.innerText = '';
                                formulaire.innerHTML = '</br>';
                                nbInput = 0;
                                tmp = 'choixM'
                            }
                            if(nbInput >= 3){
                                alert('le nombre de reponses max est 3');
                            }
                            else{
                                tmp = 'choixS'; 
                                div = document.createElement("div");
                                div.setAttribute("id","ligne"+nbInput);
                                formulaire.appendChild(div);
                                var ligne = document.getElementById("ligne"+nbInput);
                                label = document.createElement("label");
                                label.innerHTML = "Reponse "+(nbInput+1)+" &nbsp;&nbsp;&nbsp;";
                                ligne.appendChild(label);
                                champ = document.createElement("input");
                                champ.setAttribute("type","text");
                                champ.setAttribute("name","reponse"+nbInput);
                                champ.setAttribute("class","inputText");
                                champ.setAttribute("style","background-color: #F5F5F5; width: 65%");
                                ligne.appendChild(champ);
                                radio = document.createElement("input");
                                radio.setAttribute("type","radio");
                                radio.setAttribute("name","vrai");
                                radio.setAttribute("value",champ.name);
                                ligne.appendChild(radio);
                                btn = document.createElement("button");
                                btn.setAttribute("type","button");
                                btn.setAttribute("name","ligne"+nbInput);
                                btn.innerHTML = '<img style="margin:0;"  src="Images/Icônes/ic-supprimer.png" onclick="supp_champs('+nbInput+')" />';
                                ligne.appendChild(btn);
                                nbInput++;
                            }
                        }
                    }
                }    
            }
            function supp_champs(l){
                var inp = document.getElementById("ligne"+l);
                inp.remove();
            }
        </script>
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
                        <form  action="" method="POST">
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
                        
                        <div class="liste">
                            <a class="icones" href="CreationCompteAdmin.php">
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
                        
                        <div class="liste" style="background-color:   silver;">
                            <div class="list-courant"></div>
                            <a class="icones" href="CreerQuestions.php">
                               <img  src="Images\Icônes\ic-ajout-active.png"/>
                            </a>
                            &nbsp;&nbsp;&nbsp; Créer Questions 
                        </div>
                    </div>
                    <div class="CreerAdmin">
                        
                        <h1 class="Parametrer">PARAMETRER VOTRE QUESTION</h1>
                        <div class="bordure-bleu">
                        <form  action="" method="POST" id="form-question">
                        
                                <label style="margin-top: 50px">QUESTIONS&nbsp;&nbsp;&nbsp;</label>
                                <textarea style="margin: 1%; background-color: #F5F5F5" name="questions" cols="60%" rows="8"><?php if(!empty($_POST['questions'])) echo $_POST['questions']; ?></textarea><br/>
                                <label >Nbre de Points</label>&nbsp;&nbsp;
                                <input type="number" name="score" class="inputText" style="width: 10%;" value="<?php if(!empty($_POST['score'])) echo $_POST['score']; ?>"/><br/><br/>
                                    <label>Type de Reponse&nbsp;&nbsp;&nbsp;</label>
                                    <select id="type" onchange="ajouterChamps()" style="width: 60%;" class="inputText" name="type">
                                        <option value= "<?php if(!empty($_POST['type'])) echo $_POST['type']; ?>">Choisiser un type</option>
                                        <option value="choixM">Choix Multiple</option>
                                        <option value="choixS">Choix Simple</option>
                                        <option value="choixT">Choix Texte</option>
                                    </select>
                                    <button class="AjoutReponse" name="ajout" type="button" onclick="ajouterChamps()" >
                                        <img style="margin:0;"  src="Images\Icônes\ic-ajout-réponse.png"/>
                                    </button>
                                <div id="formulaire" >
                                </div>
                                <button class="Enregistrer-qst" type="submit" name="valider">Enregistrer</button>
                        </form>
                        </div>
                    </div>
                    
                    

                </div>
            </div>
            
    </body>
</html>
<?php

if (isset($_POST['valider'])) {
    if (!empty($_POST['questions']) && !empty($_POST['score']) && !empty($_POST['type'])) {
        $questions = array();
        $questions['question'] = $_POST['questions'];
        $questions['score'] = $_POST['score'];
        $questions['type'] = $_POST['type'];
        $tmp = 1;
        if ($_POST['type'] == "choixT") {
            if (!empty($_POST['reponse'])) {
                $questions['reponse'] = $_POST['reponse'];  
            }
            else{
                $tmp = 0;
            }
        }
        else{
            if ($_POST['type'] == "choixM") {
                $i = 0;
                while(isset($_POST['reponse'.$i])){
                    if (!empty($_POST['reponse'.$i])) {
                        $questions['reponse'][$i] = $_POST['reponse'.$i];
                        if(isset($_POST['vrai'.$i])){
                            $questions['vrai'][] = $questions['reponse'][$i];
                        }  
                    }
                    else{
                        $tmp = 0;
                    }
                    $i++;
                }
            }
            else{
                if ($_POST['type'] == "choixS") {
                    $i = 0;
                    while(isset($_POST['reponse'.$i])){
                        if (!empty($_POST['reponse'.$i])) {
                            $questions['reponse'][$i] = $_POST['reponse'.$i];
                        }
                        else{
                            $tmp = 0;
                        }
                        $i++;
                    }
                    $questions['vrai'][] = $_POST[$_POST['vrai']];
                }
            }   
        }
        if($tmp){
            $js = file_get_contents('question.json');
            $js = json_decode($js, true);
            $js['Questions'][] = $questions;
            $js = json_encode($js);
            file_put_contents('question.json', $js);
        }
        else{
            echo "Remplir tous les champs!!!";
        }
        
    }
    else{
        echo "Remplir tous les champs!!!";
    }
}
?>
