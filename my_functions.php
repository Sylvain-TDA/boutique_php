<?php
function formatPrice($price): string
{
    $formatedPrice = (number_format($price, 2, ",", " ")) . "€";
    return $formatedPrice;
}
;

function priceExcludingVAT($price): float
{
    $price = (100 * $price) / (100 + 20);
    return $price;
}
;

function discountedPrice($price, $discount): float
{
    if ($discount == 0) {
        return $price;
    } else {
        (float) $priceDiscounted = $price * ((100 - $discount) / 100);
        return $priceDiscounted;
    }
}
;

function sum($price, $quantity): float
{
    $sum = $price * $quantity;
    return $sum;
}

function shippingCost($carrier, $weight, $sum): float
{
    if ($carrier == "DHL") {
        if ($weight >= 0 && $weight < 500) {
            return (float) 7;
        } elseif ($weight >= 500 && $weight <= 2000) {
            return (float) $sum * 0.1;
        } else {
            return (float) 0;
        }
    } elseif ($carrier == "UPS") {
        if ($weight >= 0 && $weight < 400) {
            return (float) 3;
        } elseif ($weight >= 400 && $weight <= 2500) {
            return (float) round($sum * 0.12,2);
        } else {
            return (float) 0;
        }
    } elseif ($carrier == "Fedex") {
        if ($weight >= 0 && $weight < 600) {
            return (float) 10;
        } elseif ($weight >= 600 && $weight <= 2300) {
            return (float) $sum * 0.12;
        } else {
            return (float) 0;
        }
    } else {
        return (float) 0;
    }
}
;

function emptyMyCart()
{
    $products = getProductName();
    foreach ($products as $x) {
        unset($_SESSION["commande" . $x]);
    }
}

?>