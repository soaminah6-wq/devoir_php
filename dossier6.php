<?php
session_start();

// Déconnexion 
if (isset($_GET["action"]) && $_GET["action"] === " logout") {
    unset($_SESSION["username"]);
}

// Connexion à la BDD 
try {
    $dbh = new PDO('mysql:host=localhost;dbname=formulaire;charset=utf8', 'root', '');
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die($e->getMessage());
}


//  INSCRIPTION

if(isset($_POST['register'])) {

    // Champ username vide
    if (empty($_POST['username'])) {
        echo "<p style='color:red;'>Le champ username de l'inscription est vide.</p>";
        echo '<button onclick="history.back()">Retour</button>';
        return;
    }

    // Champ password vide
    if (empty($_POST['password'])) {
        echo "<p style='color:red;'>Le champ password de l'inscription est vide.</p>";
        echo '<button onclick="history.back()">Retour</button>';
        return;
    }

    // Vérifier si username existe déjà
    $check = $dbh->prepare("SELECT * FROM user WHERE username = :username");
    $check->execute(['username' => $_POST['username']]);

    if ($check->fetch()) {
        echo "<p style='color:red;'>Ce username existe déjà. Choisissez-en un autre.</p>";
        echo '<button onclick="history.back()">Retour</button>';
        return;
    }

    // Inscription
    $hash = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sth = $dbh->prepare("INSERT INTO `user` (username, password) VALUES (:username, :password)");
    $sth->execute([
        'username' => $_POST['username'],
        'password' => $hash
    ]);

    echo "<p style='color:green;'>Inscription réussie ! Vous pouvez vous connecter.</p>";
}


//        CONNEXION

if(isset($_POST['connect'])) {

    // Username vide
    if (empty($_POST['username'])) {
        echo "<p style='color:red;'>Le champ username de la connexion est vide.</p>";
        echo '<button onclick="history.back()">Retour</button>';
        return;
    }

    // Password vide
    if (empty($_POST['password'])) {
        echo "<p style='color:red;'>Le champ password de la connexion est vide.</p>";
        echo '<button onclick="history.back()">Retour</button>';
        return;
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Vérifier si utilisateur existe
    $stmt = $dbh->prepare("SELECT * FROM `user` WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "<p style='color:red;'>Le username n’existe pas dans la base de données.</p>";
        echo '<button onclick="history.back()">Retour</button>';
        return;
    }

    // Vérifier mot de passe
    if (!password_verify($password, $user['password'])) {
        echo "<p style='color:red;'>Le mot de passe est invalide.</p>";
        echo '<button onclick="history.back()">Retour</button>';
        return;
    }

    // Connexion réussie
    $_SESSION['username'] = $username;
    echo "<p style='color:green;'>Connexion réussie ! Bienvenue, " . htmlspecialchars($username) . ".</p>";
}

// --- Compteur de visites ---
if (!isset($_SESSION['counter'])) {  
    $_SESSION['counter'] = 0;
}       
$_SESSION['counter']++;
echo "<h1>".$_SESSION['counter']."</h1>";

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>TP Session PHP</title>
</head>
<body>

<?php if (!isset($_SESSION["username"])) : ?>

    <h1>INSCRIPTION</h1>

    <form method="post" action="">
        <input type="hidden" name="register" value="1">

        <label>Username :</label>
        <input type="text" name="username"><br>

        <label>Password :</label>
        <input type="password" name="password"><br>

        <button type="submit">Créer le compte</button>
    </form>

    <hr><br>

    <h1>CONNEXION</h1>

    <form method="post" action="">
        <input type="hidden" name="connect" value="1">

        <label>Username :</label>
        <input type="text" name="username"><br>

        <label>Password :</label>
        <input type="password" name="password"><br>

        <button type="submit">Se connecter</button>
    </form>

<?php else : ?>

    <h2>Bienvenue <?php echo htmlspecialchars($_SESSION["username"]); ?> !</h2>

    <a href="?action=logout">
        <button>Se déconnecter</button>
    </a>

<?php endif; ?>

</body>
</html>
