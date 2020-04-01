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

function lettres($mot){
    
    for ($i=0; $i < nbr_caractere($mot) ; $i++) { 
        if (!(($mot[$i] >= 'a' && $mot[$i] <= 'z') || ($mot[$i] >= 'A' && $mot[$i] <= 'Z'))) {
            return 1;
        }
    }

return 0;

}
?>