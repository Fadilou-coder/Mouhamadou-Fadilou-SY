<html>
    <body>
        <center><br/><h1>Saisir Le nombre de mots: </h1><br/>

            <form action="Exercice3TD.php" method="POST">
            <input type="text" name="n" value="<?php if (!empty($_POST['n'])) echo $_POST['n']; ?>"/><br/><br/>
                <input type="submit" name="valider"/><br/>
            
        </center>
    </body>
</html>

<?php
include('function.php');
    
    if(!empty($_POST['n'])){
        if ($_POST['n']>0) {
            
            $n = $_POST['n'];
            $mot = array();
            ?>
            <center><br/><h1>Saisir des mots: </h1>
            <?php
            for ($i=0; $i < $n; $i++) { 
            ?>
                    <label>
                        Mot N°<?php echo $i+1;
                                if (empty($_POST['mot'.$i])) {
                                    echo "<strong> (Remplir le Champ svp)<strong>";
                                }
                                else{
                                    if (lettres($_POST['mot'.$i])) {
                                        echo "<strong> (Des lettres uniquement.)<strong>";
                                    }
                                    else{
                                        if (nbr_caractere($_POST['mot'.$i]) > 20) {
                                            echo "<strong> (Le mot ne doit pas dépasser 20 caractères.)<strong>";
                                        }

                                    }
                                }
                        ?>
                    </label><br/>
                    <input type="text" name="mot<?php echo $i; ?>" value="<?php if (!empty($_POST['mot'.$i])) echo $_POST['mot'.$i]; ?>"/><br/><br/>
                    
                
                <?php
            }
            ?>
            <input type="submit" name="Envoyer" value="Envoyer"/><br/>
            </form>
            
        <?php
            if(isset($_POST['Envoyer'])){
                $tmp = 1;
                for ($i=0; $i < $n ; $i++) { 
                    if(empty($_POST['mot'.$i]) || lettres($_POST['mot'.$i]) || nbr_caractere($_POST['mot'.$i]) > 20){
                        $tmp = 0;
                    }
                }

                if ($tmp) {
                    $test = 0;
                    $mot_m = array();
                    for ($i=0; $i < $n ; $i++) {
                        $mots[] = $_POST['mot'.$i];
                        for ($a=0; $a < nbr_caractere($mots[$i]) ; $a++) { 
                            if ($mots[$i][$a] == 'm' || $mots[$i][$a] == 'M') {
                                $test=1;
                            break;
                            }        
                        }
                        if($test){
                            $mot_m[] = $mots[$i];
                        }   
                        $test = 0;
                    }
                        echo "<center><br/><table border : '1'><tr><td> Les mots saisis sont: </td>";
                        echo "<td>Les mots contenants 'm' : </td></tr>";
                        for ($i=0; $i < compte($mots) ; $i++) { 
                            echo "<tr><td>".$mots[$i]."</td><td>";
                            if($i < compte($mot_m)){
                                echo $mot_m[$i];
                            }
                            echo "</td></tr>";
                
                        }
                         echo "</table>";
                        
                        
                    
                } 
        }
        else{
            echo "<center>saisir un entier positif</center>";
        }

    }


?>

</center>