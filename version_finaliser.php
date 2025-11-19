

<?php
// Connexion PDO
try {
    $dbh = new PDO('mysql:host=localhost;dbname=jo_100;charset=utf8', 'root', '');
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die( $e->getMessage());
}

// FORMULAIRE HTML 
?>
<form method="post">
    <label>Nom : <input type="text" name="nom" required></label><br>
    <label>Pays (3 lettres) : <input type="text" name="pays" maxlength="3" required></label><br>
    <label>Course : 
        <select name="course" required>
            <?php
            // Récupérer les courses existantes
            $sth_courses = $dbh->query("SELECT DISTINCT course FROM `100`");
            $courses = $sth_courses->fetchAll(PDO::FETCH_COLUMN);
            foreach ($courses as $c) {
                echo "<option value='" . htmlspecialchars($c) . "'>" . htmlspecialchars($c) . "</option>";
            }
            ?>
        </select>
    </label><br>
    <label>Temps (en secondes) : <input type="number" step="0.01" name="temps" required></label><br>
    <button type="submit">Ajouter</button>
</form>

<?php
//  TRAITEMENT DU FORMULAIRE 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom']);
    $pays = strtoupper(trim($_POST['pays']));
    $course = $_POST['course'];
    $temps = $_POST['temps'];

    $errors = [];
    if (strlen($pays) !== 3) $errors[] = "Le code pays doit faire 3 lettres.";
    if (!is_numeric($temps)) $errors[] = "Le temps doit être un nombre.";

    if (empty($errors)) {
        $sth = $dbh->prepare("INSERT INTO `100` (nom, pays, course, temps) VALUES (:nom, :pays, :course, :temps)");
        $sth->execute([
            ':nom' => $nom,
            ':pays' => $pays,
            ':course' => $course,
            ':temps' => $temps
        ]);
        echo "<p style='color:green;'>Résultat ajouté avec succès !</p>";
    } else {
        foreach ($errors as $err) {
            echo "<p style='color:red;'>$err</p>";
        }
    }
}

// AFFICHAGE DU TABLEAU AVEC TRI
$sort = $_GET['sort'] ?? 'nom';
$order = strtolower($_GET['order'] ?? 'asc');
$colonnes_valides = ['nom', 'pays', 'course', 'temps'];
if (!in_array($sort, $colonnes_valides)) die("Invalid sort column");
if (!in_array($order, ['asc', 'desc'])) die("Invalid order");

$sth = $dbh->prepare("SELECT * FROM `100` ORDER BY $sort $order");
$sth->execute();
$data = $sth->fetchAll(PDO::FETCH_ASSOC);

// Fonction pour afficher les flèches de tri
function arrow($colonne, $direction) {
    global $sort, $order;
    $style = ($sort === $colonne && $order === $direction) ? "style='color:red; font-weight:bold;'" : "";
    return "<span $style>" . ($direction === 'asc' ? "↑" : "↓") . "</span>";
}

// Affichage du tableau
echo "<table border='1'>
    <thead>
        <tr>
            <th>Nom <a href='?sort=nom&order=asc'>" . arrow('nom','asc') . "</a> <a href='?sort=nom&order=desc'>" . arrow('nom','desc') . "</a></th>
            <th>Pays <a href='?sort=pays&order=asc'>" . arrow('pays','asc') . "</a> <a href='?sort=pays&order=desc'>" . arrow('pays','desc') . "</a></th>
            <th>Course <a href='?sort=course&order=asc'>" . arrow('course','asc') . "</a> <a href='?sort=course&order=desc'>" . arrow('course','desc') . "</a></th>
            <th>Temps <a href='?sort=temps&order=asc'>" . arrow('temps','asc') . "</a> <a href='?sort=temps&order=desc'>" . arrow('temps','desc') . "</a></th>
        </tr>
    </thead>
    <tbody>
";

if (count($data) === 0) {
    echo "<tr><td colspan='4'>Aucun résultat</td></tr>";
} else {
    foreach ($data as $row) {
        echo "<tr>
            <td>" . htmlspecialchars($row['nom']) . "</td>
            <td>" . htmlspecialchars($row['pays']) . "</td>
            <td>" . htmlspecialchars($row['course']) . "</td>
            <td>" . htmlspecialchars($row['temps']) . "</td>
        </tr>";
    }
}

echo "</tbody></table>";
// Nombre de résultats par page
$limit = 10;

// Page actuelle depuis $_GET
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

// Calcul de l'offset
$offset = ($page - 1) * $limit;
// Récupération des résultats avec LIMIT et OFFSET
$sth = $dbh->prepare("SELECT * FROM `100` LIMIT :limit OFFSET :offset");
$sth->bindValue(':limit', $limit, PDO::PARAM_INT);
$sth->bindValue(':offset', $offset, PDO::PARAM_INT);
$sth->execute();
$data = $sth->fetchAll(PDO::FETCH_ASSOC);



// Pagination simple
$totalRows = $dbh->query("SELECT COUNT(*) FROM `100`")->fetchColumn();
$totalPages = ceil($totalRows / $limit);

for ($i = 1; $i <= $totalPages; $i++) {
    if ($i == $page) {
        echo "<strong>$i</strong> ";
    } else {
        echo "<a href='?page=$i'>$i</a> ";
    }
}
// Fermer la connexion
$dbh = null;
?>
