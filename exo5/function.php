<?php

function compte($tab){
    $cpt=0;
    foreach($tab as $val){
        $cpt++;
    }
    return $cpt;
}

function nbr_caractere($chaine){
    $i=0;
    while(isset($chaine[$i])){
        $i++;
    }
    return $i;
}

function recuperer($nums){
    $Tnums = preg_split("/[\s|;|-]+/", $nums);
return $Tnums;
}

function num_valide($Tnums){
        foreach($Tnums as $key){
            if(preg_match("#[^0-9]+# ", $key) ||  nbr_caractere($key) != 9){
                return false;
            }
        }
return true;
}

function afficher($tab, $Tnums){
    echo (compte($tab)/compte($Tnums))." %</strong></td>";
    foreach($tab as $key){
        if($key)
            echo"<td>".$key."</td>";
    }
}

?>