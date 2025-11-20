<?php
session_start(); // On démarre la session

// Si le formulaire est envoyé
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // On enregistre la valeur du champ texte dans la session
    $_SESSION["username"] = $_POST["username"];
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>TP Session PHP</title>
</head>
<body>

<?php

// Vérifier si la variable de session username existe
if (!isset($_SESSION["username"])) {

    // Si elle n'existe pas → afficher le formulaire
    echo '
    <form method="post" action="">
        <label for="username">Username :</label>
        <input type="text" name="username" id="username" required>
        <button type="submit">Valider</button>
    </form>
    ';

} else {

    // Si elle existe → afficher la valeur + message de bienvenue
    echo "<h2>Bienvenue " . htmlspecialchars($_SESSION['username']) . " !</h2>";
}

?>

</body>
</html>
