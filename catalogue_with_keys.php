<?php

include("my_functions.php");

$scarpa = [
    "name" => "Scarpa",
    "price" => 12000,
    "weight" => 550,
    "discount" => 10,
    "picture_url" => "https://content.backcountry.com/images/items/large/SCR/SCR008R/OCE.jpg",
];

$laSportiva = [
    "name" => "La Sportiva",
    "price" => 14000,
    "weight" => 380,
    "discount" => null,
    "picture_url" => "https://www.bfgcdn.com/1500_1500_90/301-0448-0111/la-sportiva-solution-climbing-shoes.jpg",
];

$simond = [
    "name" => "Simond",
    "price" => 6500,
    "weight" => 620,
    "discount" => 10,
    "picture_url" => "https://contents.mediadecathlon.com/p2402441/k$65ce62945e874c670bc44dea54bd96fb/sq/chausson-descalade-vertika-soft-homme-bleuocre.jpg?format=auto&f=800x0",
];

?>

<?php
ob_start();
include("header.php");
$buffer = ob_get_contents();
ob_end_clean();

$buffer = str_replace("%TITLE%", "Catalogue with keys", $buffer);
echo $buffer;
?>

<body>
    <div class='monProduit'>
        <h3>
            <?php
            echo $scarpa["name"];
            ?>
        </h3>
        <p>Prix HT : <?php echo formatPrice(priceExcludingVAT(($scarpa["price"]))) ?></p>
        <p>Prix TTC : <?php echo formatPrice($scarpa["price"]) ?></p>
        <p>Prix remisé : <?php echo formatPrice(discountedPrice($scarpa["price"], $scarpa["discount"])) ?></p>
        <img src="<?php echo $scarpa["picture_url"] ?>" alt="<?php echo $scarpa["name"]; ?>" width="300px">
    </div>

    <div class='monProduit'>
        <h3>
            <?php
            echo $laSportiva["name"];
            ?>
        </h3>
        <p>Prix HT : <?php echo formatPrice(priceExcludingVAT($laSportiva["price"])) ?></p>
        <p>Prix TTC : <?php echo formatPrice($laSportiva["price"]) ?></p>
        <p>Prix remisé : <?php echo formatPrice(discountedPrice($laSportiva["price"], $laSportiva["discount"])) ?></p>
        <img src="<?php echo $laSportiva["picture_url"] ?>" alt="<?php echo $laSportiva["name"]; ?>" width="300px">
    </div>

    <div class='monProduit'>
        <h3>
            <?php
            echo $simond["name"];
            ?>
        </h3>
        <p>Prix HT : <?php echo formatPrice(priceExcludingVAT($simond["price"])) ?></p>
        <p>Prix HT : <?php echo formatPrice(($simond["price"])) ?></p>
        <p>Prix remisé : <?php echo formatPrice(discountedPrice($simond["price"], $simond["discount"])) ?></p>
        <img src="<?php echo $simond["picture_url"] ?>" alt="<?php echo $simond["name"]; ?>" width="300px">
    </div>

</body>

<?php
include("footer.php");
?>

</html>