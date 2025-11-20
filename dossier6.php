<?php
session_start();

// --- Déconnexion ---
if (isset($_GET["action"]) && $_GET["action"] === "logout") {
    unset($_SESSION["username"]);
}

// --- Connexion à la BDD ---
try {
    $dbh = new PDO('mysql:host=localhost;dbname=formulaire;charset=utf8', 'root', '');
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die($e->getMessage());
}
      // INSCRIPTION

if(isset($_POST['register'])) {
    if($_POST['username'] != "" && $_POST['password'] != "") {

        $hash = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $sth = $dbh->prepare("INSERT INTO `user` (username, password) VALUES (:username, :password)");
        $sth->execute([
            'username' => $_POST['username'],
            'password' => $hash
        ]);

        echo "<p style='color:green;'>Inscription réussie ! Vous pouvez vous connecter.</p>";
    }
}

     //  CONNEXION

if(isset($_POST['connect'])) {
    
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $dbh->prepare("SELECT * FROM `user` WHERE username = :username");
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user){
        if(password_verify($password, $user['password'])){
            $_SESSION['username'] = $username;
            echo "<p style='color:green;'>Connexion réussie ! Bienvenue, " . htmlspecialchars($username) . ".</p>";
        } else {
            echo "<p style='color:red;'>Mot de passe incorrect.</p>";
        }
    } else {
        echo "<p style='color:red;'>Utilisateur introuvable.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>TP Session PHP</title>
</head>
<body>

<?php if (!isset($_SESSION["username"])) : ?>
    <!-- Pour les nouveaux utilisateurs -->

    <h1>INSCRIPTION</h1>

    <form method="post" action="">
        <input type="hidden" name="register" value="1">

        <label>Username :</label>
        <input type="text" name="username" required><br>

        <label>Password :</label>
        <input type="password" name="password" required><br>

        <button type="submit">Créer le compte</button>
    </form>


    <hr><br>

<!-- pour se connecter -->
    
    <h1>CONNEXION</h1>

    <form method="post" action="">
        <input type="hidden" name="connect" value="1">

        <label>Username :</label>
        <input type="text" name="username" required><br>

        <label>Password :</label>
        <input type="password" name="password" required><br>

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
