<?php

function formatPrice($price): string {
    $formatedPrice = (number_format($price / 100, 2, ",", " ")) . "€";
    return $formatedPrice;
}
;

function priceExcludingVAT($price):float {
    $price = (100 * $price) / (100 + 20);
    return $price;
}
;

function discountedPrice($price, $discount):float{
    if ($discount == 0) {
        return $price;
    } else {
        (float) $priceDiscounted = $price * ((100 - $discount) / 100);
        return $priceDiscounted;
    }
};

function sum($price, $quantity):float{
    $sum = $price * $quantity;
    return $sum;
}

function shippingCost($carrier, $weight, $sum):float{
    if ($carrier = 1) {
        if ($weight >= 0 && $weight < 500) {
            return (int) 5;
        } elseif ($weight >= 500 && $weight <= 2000) {
            return (int) $sum * 0.1;
        } else {
            return (int) 0;
        }
    } else {
   if ($weight >= 0 && $weight < 400) {
            return (int) 3;
        } elseif ($weight >= 500 && $weight <= 2500) {
            return (int) $sum * 0.12;
        } else {
            return (int) 0;
        }
    }
}

?>