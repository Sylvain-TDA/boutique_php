<?php

function formatPrice($price): string
{
    $formatedPrice = (number_format($price / 100, 2, ",", " ")) . "€";
    return $formatedPrice;
}
;

function priceExcludingVAT($price)
{
    $price = (100 * $price) / (100 + 20);
    return $price;
}
;

function discountedPrice($price, $discount)
{
    if ($discount == 0) {
        return $price;
    } else {
        (float) $priceDiscounted = $price * ((100 - $discount) / 100);
        return $priceDiscounted;
    }
}
;

function sum($price, $quantity)
{
    $sum = $price * $quantity;
    return $sum;
}

?>