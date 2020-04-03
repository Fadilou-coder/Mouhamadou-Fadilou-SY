<?php
function phrase_valide($phrase){
    return preg_match("#^[A-Z].*[\.|?|!]$#",$phrase);   
}

// function decouper($texte){
//     preg_match_all('/[^.|?|!|\n]*[.|!|?]/', $texte, $phrases);   
// return $phrases[0];
// }

function decouper($texte){
    $Tphrases = array();
    $phrase = "";
    for ($i=0; $i < nbr_caractere($texte) ; $i++) { 
        if($texte[$i] != "." && $texte[$i] != "!" && $texte[$i] != "?"){
            $phrase .= $texte[$i];
        }
        else{
            if ($texte[$i] == "." && is_numeric($texte[$i-1]) && is_numeric($texte[$i+1])) {
                $phrase .= $texte[$i];
            }
            else{
                $phrase .= $texte[$i];
                $Tphrases[] = $phrase;
                $phrase = "";
            }
        }
    }
return $Tphrases;
}

// $test = "j'adore le codage. Papa a donné 2.500 à maman 3.500 à frère ? c'est bien de tester!";
// print_r(decouper($test));

function enlever_space($phrase){
    $phrase_corrigé = "";
    if($phrase[0] != " ")
        $phrase_corrigé = $phrase[0]; 
    for ($i=1; $i < nbr_caractere($phrase) - 1 ; $i++) { 
        if ($phrase[$i] != " ") {
            $phrase_corrigé .= $phrase[$i];
        }
        else{
            if ($phrase_corrigé[nbr_caractere($phrase_corrigé)-1] != " " && !preg_match("#[,|;|.|?|!|'|-|~|\s]#", $phrase[$i+1])) {
                $phrase_corrigé .= $phrase[$i];
            }
        }
    }
    $phrase_corrigé .= $phrase[nbr_caractere($phrase) - 1 ];

return $phrase_corrigé;
}

function nbr_caractere($chaine){
    $i=0;
    while(isset($chaine[$i])){
        $i++;
    }
    return $i;
}


?>