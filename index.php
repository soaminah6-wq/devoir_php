<?php
// 1 - School : Ecrire une fonction qui prend en paramètre l’âge d’un enfant et retourne “creche” s’il à moins de 3 ans, “maternelle” si il à moins de 6 ans, “primaire” s’il a moins de 11 ans, “college” pour les moins de 16 ans, lycée pour les moins de 18 ans et rien pour les autres.
function school($age) {
    if ($age < 3) {
        return "creche";
    } elseif ($age < 6) {
        return "maternelle";
    } elseif ($age < 11) {
        return "primaire";
    } elseif ($age < 16) {
        return "college";
    } elseif ($age < 18) {
        return "lycée";
    } else {
        return "";
    }
} 
echo school(15);
?>