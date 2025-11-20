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

// relions la base de données formulaire dont sa table on l'a appelé user

try {
    $dbh = new PDO('mysql:host=localhost;dbname=formulaire;charset=utf8', 'root', '');
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die( $e->getMessage());
}

// Traitement du formulaire d'enregistrement
if(isset($_POST['register'])) {
   if($_POST['username'] != "" && $_POST['password'] != "") {
       
       $hash= password_hash($_POST['password'], PASSWORD_BCRYPT);
       $sth = $dbh->prepare("INSERT INTO `user` (username, password) VALUES (:username, :password)");
       $sth->bindParam(':username', $username);
       $sth->bindParam(':password', $password);
       $sth->execute([
              'username' => $_POST['username'],
              'password' => $hash
       ]);
   
}}

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

if (isset($_POST["register"]))
     {
    
    //pour enregistrer un nouvel utilisateur
    echo '
    <form method="post" action="">
        <label for="username">Username :</label>
        <input type="text" name="username" id="username" required><br>

        <label for="password">Password :</label>
        <input type="password" name="password" id="password" required><br>

        <button type="submit">Valider</button>
    </form>
    ';

     }

     
?>

<h1>connection </h1>
<?php 
if(isset($_POST['connect'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Récupérer l'utilisateur depuis la base de données
    $stmt = $dbh->prepare("SELECT * FROM `user` WHERE username = :username");
    $stmt->execute([':username' => $username]);
    $user = $stmt=$sth->fetch(PDO::FETCH_ASSOC);
 if($user){
    if(password_verify($password, $user['password'])){
        $_SESSION['username'] = $username;
        echo "Connexion réussie ! Bienvenue, " . htmlspecialchars($username) . ". <a href='?action=logout'>Se déconnecter</a>";
    } else {
        echo "Mot de passe incorrect.";
    }
 }
    

// pour se connecter les anciens utilisateurs
echo '<form method="post" action="">
    <label for="username">Username :</label>
    <input type="text" name="username" id="username" required><br>

    <label for="password">Password :</label>
    <input type="password" name="password" id="password" required><br>

    <button type="submit">Valider</button>';
    }
    ?>
    
</form>
</body>
</html>
