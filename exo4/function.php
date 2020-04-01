<?php
function nbr_caractere($chaine){
    $i=0;
    while(isset($chaine[$i])){
        $i++;
    }
    return $i;
}

function phrase_valide($phrase){
    return preg_match("#^[A-Z].*[\.|?|!]$#",$phrase);   
}

function decouper($texte){
    preg_match_all('/[^.|?|!|\n]*[.|!|?]/', $texte, $phrases);
return $phrases[0];
}

function enlever_space($phrase){

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

?>