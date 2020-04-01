<?php
include('function.php');
?>

<html>
    <head>
        <link href="exercice.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <center><br/><h1>Saisir des numeros séparés par '-' ou ';' ou espace: </h1><br/>

            <form action="exo5.php" method="POST">
                <textarea name="nums" cols="60" rows="10"><?php if(!empty($_POST['nums'])) echo $_POST['nums'];
                   
                ?></textarea><br/><br/>
                <input type="submit" name="valider"/><br/>
            </form>
        </center>
    </body>
</html>

<?php
if(isset($_POST['valider'])){
    $orange = array();
    $free = array();
    $expresso = array();
    $promobile = array();
    $Tnums = array();
    $nums = $_POST['nums'];

    if (!empty($nums)) {
        $Tnums = recuperer($nums);
        if(num_valide($Tnums)){
            foreach($Tnums as $key){
                if(preg_match("#^[7][7,8]#",$key)){
                    $orange[]=$key;
                }
                else{
                    if (preg_match("#^[7][6]#",$key)) {
                        $free[]=$key;
                    }
                    else{
                        if (preg_match("#^[7][5]#",$key)) {
                            $promobile[] = $key;
                        }
                        else
                        $expresso[]=$key;
                    }
                }
            }
            echo "<center><br/><table border='1'>";
            echo "<tr><td>Orange <strong>";
            afficher($orange,$Tnums);
            echo "<tr><td>Free <strong>";
            afficher($free,$Tnums);
            echo "<tr><td>Expresso <strong>";
            afficher($expresso,$Tnums);
            echo "<tr><td>Promobile <strong>";
            afficher($promobile,$Tnums);
        }
        else{
            echo "<br/><br/><center><strong>Saisis incorrecte!!!</strong></center>";
        }
    }
    else
        echo "<center><strong>Remplir le champs</strong></center>";
}
?>