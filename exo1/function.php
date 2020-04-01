<?php

function couleurtr($i){
    if($i%2==0){
        return "background-color: rgb(240, 204, 158);";
    }
}


function compte($tab){
    $cpt=0;
    foreach($tab as $val){
        $cpt++;
    }
    return $cpt;
}

function premier($n){
    $tmp=2;
    while ($tmp <= ($n/2) and $tmp!=0) {
        if ($n%$tmp==0) {
            $tmp=0;
        }else{
            $tmp++;
        }
    }
    if($tmp!=0) {
        return 1;
    }else{
        return 0;
    }
}

function moyenne($tab){
    $som = 0;
    for ($i=0; $i < compte($tab) ; $i++) { 
       $som = $som + $tab[$i];
    }

    return ($som/compte($tab));
}

function nbr_caractere($chaine){
    $i=0;
    $nbre=0;
    while(!empty($chaine[$i])){
        $nbre++;
        $i++;
    }
    return $nbre;
}


?>