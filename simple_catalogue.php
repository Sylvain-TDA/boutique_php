<?php

$products = ["Scarpa", "La sportiva", "Simond"];

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

?>