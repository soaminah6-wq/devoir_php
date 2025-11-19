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
