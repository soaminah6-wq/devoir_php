<?php
session_start(); // On démarre la session

// Si on clique sur "se déconnecter"
if (isset($_GET["action"]) && $_GET["action"] === "logout") {
    unset($_SESSION["username"]); // On supprime uniquement le username
}

// Si le formulaire est envoyé
if ($_SERVER["REQUEST_METHOD"] === "POST") {
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

<h1>Formulaire</h1>

<?php

// Vérifier si la variable de session username existe
if (!isset($_SESSION["username"])) {

    // Si elle n'existe pas → afficher le formulaire (SE CONNECTER)
    echo '
    <form method="post" action="">
        <label for="username">Username :</label>
        <input type="text" name="username" id="username" required><br>

        <label for="password">Password :</label>
        <input type="password" name="password" id="password" required><br>

        <button type="submit">Se connecter</button>
    </form>
    ';

} else {

    // Si elle existe → message de bienvenue + bouton SE DÉCONNECTER
    echo "<h2>Bienvenue " . htmlspecialchars($_SESSION['username']) . " !</h2>";

    // Bouton se déconnecter = retourne au formulaire
    echo '<a href="?action=logout"><button>Se déconnecter</button></a>';
}

?>

</body>
</html>
