<?php
ob_start();
    include("header.php");
    $buffer=ob_get_contents();
    ob_end_clean();

    $buffer=str_replace("%TITLE%","Simple catalogue",$buffer);
    echo $buffer;
?>

<!-- <?php
include ("header.php");
?> -->

<?php
$products = ["Scarpa", "La sportiva", "Simond"];

foreach ($products as $product) {
    echo "<h3>" . $product . "<br>" . "<br>" . "</h3>";
}

// $i = 0;

// while ($i < 4) {
//     echo $products[$i] . "<br>" . "<br>";
//     $i++;
// }

?>

<?php
include ("footer.php");
?>

<!-- <?php

include ("header.php");


// pour trier le tableau

sort($products);

// afficher chaque élément du tableau une fois trié

foreach ($products as $product) {
    echo "" . $product . " ";
}

// afficher le premier élément du tableau

echo $products[0] . " " ;

// affiche le dernier élément du tableau

echo end($products) ;

include ("footer.php");

?> -->