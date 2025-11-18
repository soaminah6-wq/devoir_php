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

//2 - Foo Bar : Écrire un script qui affiche les nombres de 1 à 100. Cependant, pour les multiples de 3, afficher "Foo" à la place du nombre, et pour les multiples de 5, afficher "Bar". Pour les nombres qui sont des multiples de 3 et 5, afficher "FooBar".
function fooBar() {
    for ($i = 1; $i <= 100; $i++) {
        if ($i % 3 == 0 && $i % 5 == 0) {
            echo "FooBar\n";
        } elseif ($i % 3 == 0) {
            echo "Foo\n";
        } elseif ($i % 5 == 0) {
            echo "Bar\n";
        } else {
            echo $i . "\n";
        }
    }
}
echo fooBar(90);
//3 - Double boucle : Ecrire une fonction qui retourne le résultat suivant si le paramètre est 5 


function doubleBoucle($n) {
    for ($i = 1; $i <= $n; $i++) {
        for ($j = 1; $j <= $i; $j++) {
            echo $i;
        }
        echo "\n";
    }
}
echo doubleBoucle(5);
//4 - Bonus : PGCD slide suivante
// Méthode 1 : 
function pgcd_1($a, $b) {
    while ($a != $b) {
        if ($a > $b) {
            $a -= $b;
        } else {
            $b -= $a;
        }
    }
    return $a;
}

// Méthode 2 : 
function pgcd_2($a, $b) {
    while ($b != 0) {
        $r = $a % $b;
        $a = $b;
        $b = $r;
    }
    return $a;
}

// Méthode 3 : 
function pgcd_3($a, $b) {
    if ($b == 0) {
        return $a;
    }
    return pgcd_3($b, $a % $b);
}

// --- Test des fonctions ---
$has_error = false;

if (pgcd_1(60, 25) != 5) {
    $has_error = true;
    echo "Erreur sur la fonction pgcd_1, le resultat de pgcd_1(60, 25) devrait etre 5\n";
}
if (pgcd_2(60, 25) != 5) {
    $has_error = true;
    echo "Erreur sur la fonction pgcd_2, le resultat de pgcd_2(60, 25) devrait etre 5\n";
}
if (pgcd_3(60, 25) != 5) {
    $has_error = true;
    echo "Erreur sur la fonction pgcd_3, le resultat de pgcd_3(60, 25) devrait etre 5\n";
}

if (pgcd_1(33, 25) != 1) {
    $has_error = true;
    echo "Erreur sur la fonction pgcd_1, le resultat de pgcd_1(33, 25) devrait etre 1\n";
}
if (pgcd_2(33, 25) != 1) {
    $has_error = true;
    echo "Erreur sur la fonction pgcd_2, le resultat de pgcd_2(33, 25) devrait etre 1\n";
}
if (pgcd_3(33, 25) != 1) {
    $has_error = true;
    echo "Erreur sur la fonction pgcd_3, le resultat de pgcd_3(33, 25) devrait etre 1\n";
}

if (pgcd_1(56, 98) != 14) {
    $has_error = true;
    echo "Erreur sur la fonction pgcd_1, le resultat de pgcd_1(56, 98) devrait etre 14\n";
}
if (pgcd_2(56, 98) != 14) {
    $has_error = true;
    echo "Erreur sur la fonction pgcd_2, le resultat de pgcd_2(56, 98) devrait etre 14\n";
}
if (pgcd_3(56, 98) != 14) {
    $has_error = true;
    echo "Erreur sur la fonction pgcd_3, le resultat de pgcd_3(56, 98) devrait etre 14\n";
}

if ($has_error == false) {
    echo "Aucune erreur, félicitation\n";
}
// exercice 2
//2.1 - Moyenne : Écrire une fonction calcMoy qui prend en paramètre un tableau de nombre et retourne la moyenne.
function calcMoy($numbers) {
    $sum = array_sum($numbers);
    $count = count($numbers);
    if ($count == 0) {
        return 0; 
    }
    return $sum / $count;
}
echo calcMoy([2, 4, 6, 8, 10]);
//2.2 - my_strrev : Écrire une fonction my_strrev qui reproduit le même fonctionnement que la fonction php strrev : Votre fonction ne doit utiliser aucune fonction php (sauf strlen, count et isset)

function my_strrev($str) {
    $reversed = '';
    $length = strlen($str);

    // Parcours de la chaîne de la fin vers le début
    for ($i = $length - 1; $i >= 0; $i--) {
        if (isset($str[$i])) { 
            $reversed .= $str[$i];
        }
    }

    return $reversed;
}
ECHO my_strrev("Hello World!");
//2.3 - my_str_contains : Écrire une fonction my_str_contains qui reproduit le même fonctionnement que la fonction php str_contains : Votre fonction ne doit utiliser aucune fonction php (sauf strlen, count et isset).
Function my_str_contains($haystack, $needle) {
    $haystack_length = strlen($haystack);
    $needle_length = strlen($needle);

    if ($needle_length == 0) {
        return true; 
    }

    for ($i = 0; $i <= $haystack_length - $needle_length; $i++) {
        $found = true;
        for ($j = 0; $j < $needle_length; $j++) {
            if (!isset($haystack[$i + $j]) || $haystack[$i + $j] != $needle[$j]) {
                $found = false;
                break;
            }
        }
        if ($found) {
            return true;
        }
    }

    return false;
}

echo my_str_contains("Bonjour", "jour") ? "true" : "false";  
echo "\n";
echo my_str_contains("Bonjour", "soir") ? "true" : "false"; 

//4.1 tableaux à 2 dimensions CALCULE DE NOTE DE CHQUE ELEVE


// Tableau des élèves
$eleves = [
    ["nom" => "Alice", "notes" => [15, 14, 16]],
    ["nom" => "Bob", "notes" => [12, 10, 11]],
    ["nom" => "Claire", "notes" => [18, 17, 16]]
];


// suite a notre logique 2.1 - Moyenne , la calcul se fait automatique pour chaque éléves grâce au devoir précedent en rajoutant la prochaine code
// Afficher le nom et la moyenne de chaque élève
foreach ($eleves as $eleve) {
    $nom = $eleve["nom"];
    $moyenne = calcMoy($eleve["notes"]);
    echo "Nom : $nom - Moyenne : " . number_format($moyenne, 2) . "<br>";
}
//4.3 - Table de multiplication
// sa réponse est dans le fichier table.php et table.txt 

?>





