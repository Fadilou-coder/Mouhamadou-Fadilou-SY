<html>
    <body>
        <center><br/><h1>Saisir des phrases: </h1><br/>

            <form action="Exo4.php" method="POST">
                <textarea name="texte" cols="60" rows="10"><?php if(!empty($_POST['texte'])) echo $_POST['texte']; ?></textarea><br/><br/>
                <input type="submit" name="valider"/><br/>
            
        
    </body>
</html>

<?php
include('function.php');


if(isset($_POST['valider'])){
$texte = $_POST['texte'];
$phrases = array();
    if (!empty($texte)) {
        $texte = decouper($texte);
        $phrases = array();
        foreach($texte as $key){
            $key = enlever_space($key);
            if(phrase_valide($key)){
                $phrases[] = $key;
            }
            else{
                $phrases[] = ucfirst($key) ;
            }
        }


?>
<br/>
<textarea readonly cols="60" rows="10">
<?php 
foreach($phrases as $key){
    if (nbr_caractere($key)<=200) {
        echo $key." ";
    }
}
?>
</textarea>
</form>
</center>
<?php
    
    }
    else {
        echo "remplir le champ";
    }
}
?>
