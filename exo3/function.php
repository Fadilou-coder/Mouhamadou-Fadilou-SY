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

function lettres($mot){
    
    for ($i=0; $i < nbr_caractere($mot) ; $i++) { 
        if (!(($mot[$i] >= 'a' && $mot[$i] <= 'z') || ($mot[$i] >= 'A' && $mot[$i] <= 'Z'))) {
            return 1;
        }
    }

return 0;

}



function couleur($couleur){
    foreach($couleur as $key){
        echo "<option value = '$key'>".$key."</option>";
    }
}

function matrice($taille, $c1, $c2){

    ?><center><table><?php
    for ($i=1; $i <= $taille ; $i++) { 
        ?><tr><?php
        for ($j=1; $j <= $taille ; $j++) {
            if($j<=$i OR ($i+$j)==($taille+1)){ 
                echo "<td style='background-color: $c1;'></td>";
            }
            else{
                echo "<td style='background-color: $c2;'></td>";
            }
        }
        echo "</tr>";
        
    }
    echo "</center></table>";

}

function matrice1($taille, $c1, $c2, $c3){

    ?><center><table><?php
    for ($i=1; $i <= $taille ; $i++) { 
        ?><tr><?php
        for ($j=1; $j <= $taille ; $j++) {
            if($j<$i and $j+$i>($taille+1)){ 
                echo "<td style='background-color: $c1;'></td>";
            }
            else{
                if(($i<$j && $i+$j<$taille+1) || $i==$j || $i+$j==$taille+1){
                    echo "<td style='background-color: $c2;'></td>";
                }
                else{
                    echo "<td style='background-color: $c3;'></td>";
                }
            }
            
        }
        echo "</tr>";
        
    }
    echo "</center></table>";

}

?>