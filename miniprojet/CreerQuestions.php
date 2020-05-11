<?php
session_start();
if(!$_SESSION['Admin']){
    header('location: index.php');
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
            var nbre = 3;
            var ind = 0;
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
                        champ.setAttribute("id","error-"+(nbInput+4));
                        formulaire.appendChild(label);
                        formulaire.appendChild(champ);
                        err = document.createElement("div");
                        err.setAttribute("id","error-"+(nbInput+4));
                        err.setAttribute("class","error-form");
                        ligne.appendChild(err);
                    }
                }
                else{
                    if(type == 'choixM'){
                        if (tmp && tmp != 'choixM') {
                            formulaire.innerText = '';
                            formulaire.innerHTML = '</br>';
                            nbInput = 0;
                            nbre = 3;
                            tmp = 'choixM'
                        }
                        if(nbInput >= nbre){
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
                            champ.setAttribute("id","error-"+(nbInput+4));
                            ligne.appendChild(champ);
                            check = document.createElement("input");
                            check.setAttribute("type","checkbox");
                            check.setAttribute("name","vrai"+nbInput);
                            ligne.appendChild(check);
                            btn = document.createElement("button");                                
                            btn.setAttribute("type","button");
                            btn.setAttribute("name","supp"+nbInput);
                            btn.setAttribute("class","btn-supp");
                            btn.innerHTML = '<img  class= "ic-supp" src="Images/Icones/ic-supprimer.png" onclick="supp_champs('+nbInput+')" />';
                            ligne.appendChild(btn);
                            err = document.createElement("div");
                            err.setAttribute("id","error-"+(nbInput+4));
                            err.setAttribute("class","error-form");
                            ligne.appendChild(err);
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
                                nbre = 3;
                                tmp = 'choixS'
                            }
                            if(nbInput >= nbre){
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
                                champ.setAttribute("id","error-"+(nbInput+4));
                                ligne.appendChild(champ);
                                radio = document.createElement("input");
                                radio.setAttribute("type","radio");
                                radio.setAttribute("name","vrai");
                                radio.setAttribute("value",champ.name);
                                ligne.appendChild(radio);
                                btn = document.createElement("button");
                                btn.setAttribute("type","button");
                                btn.setAttribute("name","ligne"+nbInput);
                                btn.setAttribute("class","btn-supp");
                                btn.innerHTML = '<img  class= "ic-supp"  src="Images/Icones/ic-supprimer.png" onclick="supp_champs('+nbInput+')" />';
                                ligne.appendChild(btn);
                                err = document.createElement("div");
                                err.setAttribute("id","error-"+(nbInput+4));
                                err.setAttribute("class","error-form");
                                ligne.appendChild(err);
                                nbInput++;
                            }
                        }
                    }
                }    
            }
            function supp_champs(l){
                var inp = document.getElementById("ligne"+l);
                inp.remove();
                if (nbInput>=nbre) {
                    nbre = l+1; 
                }
                if (l==2) {
                    if (nbre == 2) {
                        nbre=3;
                        l=1;
                    }
                    if (nbre == 1) {
                        var inp = document.getElementById("ligne"+1);
                        inp.remove();
                        nbre = 3;
                        l=0;
                    }
                    
                }
                if (l==1 && nbre==1) {
                    l=0;
                    nbre = 2;
                }
                nbInput = l;
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
                    
                    
                       <br/><h2 class="h">CREER ET PARAMETRER VOS QUIZZ</h2>
                   
                    
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
                            <li><a href="index.php?lien=admin">&nbsp;&nbsp;&nbsp;Creer Admin <img class="icones" src="Images\Icones\ic-ajout-active.png"/> </a></li>
                            <li><a href="index.php?lien=liste_jr">&nbsp;&nbsp;&nbsp;Liste Joueurs <img class="icones" src="Images\Icones\ic-liste.png"/> </a></li>
                            <li><a class="active" href="index.php?lien=creer_qst"><div></div>&nbsp;&nbsp;&nbsp;Creer Questions <img class="icones" src="Images\Icones\ic-ajout-active.png"/> </a></li>
                            <li><a href="index.php?lien=statistiques">&nbsp;&nbsp;&nbsp;Statistiques <img class="icones" src="Images\Icones\ic-sta.png"/> </a></li>
                        </ul>

                    </div>
                    <div class="CreerAdmin">
                        
                        <h1 class="Parametrer">PARAMETRER VOTRE QUESTION</h1>
                        <div class="bordure-bleu">
                        <form  action="" method="POST" id="form-creer">
                        
                                <label style="margin-top: 50px">QUESTIONS&nbsp;&nbsp;&nbsp;</label>
                                <textarea error="error-1" class="TEXT-AREA" name="questions"><?php if(!empty($_POST['questions'])) echo $_POST['questions']; ?></textarea><br/>
                                <div class="error-form" id="error-1"></div><br/>
                                <label >Nbre de Points</label>&nbsp;&nbsp;
                                <input error="error-2" type="number" name="score" class="inputText" style="width: 10%;" value="<?php if(!empty($_POST['score'])) echo $_POST['score']; ?>"/>
                                <br/><div class="error-form" id="error-2"></div><br/>
                                    <label>Type de Reponse&nbsp;&nbsp;&nbsp;</label>
                                    <select error="error-3"  id="type" onchange="ajouterChamps()" class="select" name="type">
                                        <option  value= "<?php if(!empty($_POST['type'])) echo $_POST['type']; ?>">Choisiser un type</option>
                                        <option value="choixM">Choix Multiple</option>
                                        <option value="choixS">Choix Simple</option>
                                        <option value="choixT">Choix Texte</option>
                                    </select>
                                    <button class="AjoutReponse" name="ajout" type="button" onclick="ajouterChamps()" >
                                        <img style="margin:0;"  src="Images\Icones\ic-ajout-reponse.png"/>
                                    </button>
                                    <div class="error-form" id="error-3"></div><br/>
                                <div class="rps" id="formulaire" >
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
                    if (!isset($questions['vrai'])) {
                        $tmp = 0;
                    }
                    $i++;
                }
            }
            else{
                if ($_POST['type'] == "choixS") {
                    $i = 0;
                    while(isset($_POST['reponse'.$i])){
                        if (!empty($_POST['reponse'.$i]) && !empty($_POST['vrai'])) {
                            $questions['reponse'][$i] = $_POST['reponse'.$i];
                        }
                        else{
                            $tmp = 0;
                        }
                        $i++;
                    }
                    if ($tmp) {
                        $questions['vrai'][] = $_POST[$_POST['vrai']];
                    }
                    
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
                echo '<script>
                            alert("Coché une reponse vrai");
                    </script>';
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
    const types = document.getElementsByTagName("select");
    for(type of types){
        type.addEventListener("keyup",function(e){
            if(e.target.hasAttribute("error")){
                var idDivError = e.target.getAttribute("error");
                document.getElementById(idDivError).innerText = ""
            }
        })
    }
    const textareas = document.getElementsByTagName("textarea");
    for(textarea of textareas){
        textarea.addEventListener("keyup",function(e){
            if(e.target.hasAttribute("error")){
                var idDivError = e.target.getAttribute("error");
                document.getElementById(idDivError).innerText = ""
            }
        })
    }
    document.getElementById("form-creer").addEventListener("submit",function(e){
        var error = false;
        const textareas = document.getElementsByTagName("textarea");
        for(textarea of textareas){
            if(textarea.hasAttribute("error")){
                idDiv = textarea.getAttribute("error");
                if(!textarea.value){
                    document.getElementById(idDiv).innerText = "ce champs est obligatoire";
                    error = true;
                }
                else{
                    document.getElementById(idDiv).innerText = "";
                }
            }
        }
        const inputs = document.getElementsByTagName("input");
        for(input of inputs){
            if(input.hasAttribute("error")){
                idDivError = input.getAttribute("error");
                if(!input.value){
                    document.getElementById(idDivError).innerText = "ce champs est obligatoire";
                    error = true;
                }
                else{
                    document.getElementById(idDivError).innerText = "";
                }              
            }
        }

        const inputs_rep = document.getElementById("formulaire");
        const Reps = inputs_rep.getElementsByTagName("div");
        for(input of Reps){
            input_div = input.getElementsByTagName("input");
            divs = input.getElementsByTagName("div");
            for(inp of input_div){
                if(inp.hasAttribute("id")){
                    if(!inp.value){
                        for(div of divs){
                            div.innerText = "ce champs est obligatoire";
                            error = true;
                        }
                    }
                    else{
                        for(div of divs){
                            div.innerText = "";
                        }
                    }              
                }
            }
        }
                            
        const types = document.getElementsByTagName("select");
        for(type of types){
            if(type.hasAttribute("error")){
                idDiv = type.getAttribute("error");
                if(!type.value){
                    document.getElementById(idDiv).innerText = "Veuillez Choisir un type";
                    error = true;
                }
                else{
                    document.getElementById(idDiv).innerText = "";
                }
            }
        }
        if(error){
            e.preventDefault();
            return false; 
        }               
    })
</script>
