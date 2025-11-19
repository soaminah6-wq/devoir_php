<?php
//connexion
try {
    $mysqlClient = new PDO(
        'mysql:host=localhost;dbname=jo_100;charset=utf8',
        'root',
        ''
    );
     
} catch (PDOException $e) {
    die($e->getMessage());
}
//requête
$query = $mysqlClient->prepare("SELECT * FROM `100`;");
$query -> execute();

$data = $query->fetchAll(PDO::FETCH_ASSOC);
var_dump ($data);
Echo "<table>
<thead>
<tr>
<th>Nom</th>
<th>Pays</th>
<th>Course</th>
<th>Temps</th>
</tr>
</thead>"

;
foreach ($data as $value) {
    echo "<tr>
    <td>" . $value['nom'] . "</td>
    <td>" . $value['pays'] . "</td>
    <td>" . $value['course'] . "</td>
    <td>" . $value['temps'] . "</td>
    </tr>";
}

//fermer la connexion
$mysqlClient = null;    
$dbh = null;
?>


<?php
// Connexion PDO
try {
    $dbh = new PDO('mysql:host=localhost;dbname=jo_100;charset=utf8', 'root', '');
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// --- Récupération du tri depuis $_GET ---
$nom = "nom";
if (isset($_GET['sort'])) $nom = $_GET['sort'];

$pays = "pays";
if (isset($_GET['sort'])) $pays = $_GET['sort'];

$course = "course";
if (isset($_GET['sort'])) $course = $_GET['sort'];

$temps = "temps";
if (isset($_GET['sort'])) $temps = $_GET['sort'];

// Définir la colonne et l'ordre de tri
$sort = $_GET['sort'] ?? 'nom';
$order = strtolower($_GET['order'] ?? 'asc');

// Sécuriser le tri
$colonnes_valides = ['nom', 'pays', 'course', 'temps'];
if (!in_array($sort, $colonnes_valides)) die("Invalid sort column");
if (!in_array($order, ['asc', 'desc'])) die("Invalid order");

// --- Requête triée ---
$sth = $dbh->prepare("SELECT * FROM `100` ORDER BY $sort $order");
$sth->execute();
$data = $sth->fetchAll(PDO::FETCH_ASSOC);

// --- Fonction pour la flèche ---
function arrow($colonne, $direction) {
    global $sort, $order;
    $style = ($sort === $colonne && $order === $direction) ? "style='color:red; font-weight:bold;'" : "";
    return "<span $style>" . ($direction === 'asc' ? "↑" : "↓") . "</span>";
}

// --- Affichage du tableau ---
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

// Fermer la connexion
$dbh = null;
?>
