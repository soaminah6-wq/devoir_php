<?php
$fichier = "table.txt";
$table_size = 10;
$output = "";
for ($i = 1; $i <= $table_size; $i++) {
    for ($j = 1; $j <= $table_size; $j++) {
        $output .= str_pad($i * $j, 4, ' ', STR_PAD_LEFT);
    }
    $output .= PHP_EOL;
}
echo nl2br($output);
file_put_contents($fichier, $output);   
?>