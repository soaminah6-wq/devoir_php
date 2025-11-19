<?php

$fichier = "contact.txt";

// Contacts à ajouter
$contactsAAjouter = ["Alice Dupont", "John Doe", "Jean Martin", "Marie Curie", "Albert Einstein"];

// Si le fichier n'existe pas, on le crée vide
if (!file_exists($fichier)) {
    file_put_contents($fichier, "");
}

// Lire les contacts existants (même si vide)
$contactsExistants = file($fichier, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// Supprimer les espaces inutiles
$contactsExistants = array_map('trim', $contactsExistants);

// Ajouter les contacts absents
foreach ($contactsAAjouter as $contact) {
    if (!in_array($contact, $contactsExistants)) {
        file_put_contents($fichier, $contact . PHP_EOL, FILE_APPEND);
        echo "$contact ajouté<br>";
    } else {
        echo "$contact déjà présent<br>";
    }
}

echo "Terminé.";


?>
