<html>
    <body>
        <center><br/><h1>Choisir une langue</h1><br/>

            <form action="Exercice2.php" method="POST">
                <select name="langue">
                    <option value= "0">
                             Choisissez une langue
                    </option>
                    <option value="français">
                        Français
                    </option>
                    <option value="anglais">
                        Anglais
                    </option>
                </select><br/><br/>
                <input type="submit" name="valider" />
            </form>
        </center>
    </body>
</html>


<?php
    $couleur = array('#EFE4F5', '#C3ACCF', '#EBE7EE', '#C3ACCF');
    $tab = array('français' => array(1 => 'Janvier',
                                     2 => 'Frévrier',
                                     3 => 'Mars',
                                     4 => 'Avril',
                                     5 => 'Mai',
                                     6 => 'Juin',
                                     7 => 'Juillet',
                                     8 => 'Aout',
                                     9 => 'Septembre',
                                     10 => 'Octobre',
                                     11 => 'Novembre',
                                     12 => 'Décembre',),
                 'anglais' => array(1 => 'January',
                                    2 => 'February',
                                    3 => 'March',
                                    4 => 'April',
                                    5 => 'May',
                                    6 => 'June',
                                    7 => 'July',
                                    8 => 'August',
                                    9 => 'September',
                                    10 => 'October',
                                    11 => 'November',
                                    12 => 'Décember',));
    
if(isset($_POST['valider'])){
    if (strcmp($_POST['langue'], "0")) {


    $j=0;
    $col = 3;
    $ligne = 4;

?>

        <center><table style="text-align: center; line-height: 50px">
<?php  for ($i=1; $i<= $ligne ; $i++) { 
?>
    
        <tr style = "background-color: <?php echo $couleur[$i - 1]?>">
<?php 
    for ($a=1; $a <= $col ; $a++) { 
        
?>
            <td><h1> <?php echo ++$j; ?></h1></td>
            <td><h1> <?php echo $tab[$_POST['langue']][$j]; ?></h1></td>
        
<?php 
    }
?>
         </tr>
<?php  
        
}

?>
        </table></center>

<?php
    }
                                   
}
    
?>