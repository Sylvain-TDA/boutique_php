<?php

function formatPrice($price) {
    echo (number_format(($price/100), 2, ",", " ")) . "€";
} ;

function priceExcludingVAT($price) {
    $price = (100 * $price) / (100 +20) ;
    return $price;
} ;


function discountedPrice ($price, $discount) {
    (float) $priceDiscounted = $price * ((100-$discount)/100);
    return $priceDiscounted;
} ; 

?>