<?php

include("my_functions.php");

$products = [
    "scarpa" => [
        "name" => "Scarpa",
        "price" => 12000,
        "weight" => 550,
        "discount" => 10,
        "picture_url" => "https://content.backcountry.com/images/items/large/SCR/SCR008R/OCE.jpg",
    ],
    "laSportiva" => [
        "name" => "La Sportiva",
        "price" => 14000,
        "weight" => 520,
        "discount" => null,
        "picture_url" => "https://www.bfgcdn.com/1500_1500_90/301-0448-0111/la-sportiva-solution-climbing-shoes.jpg",
    ],
    "simond" => [
        "name" => "Simond",
        "price" => 6500,
        "weight" => 620,
        "discount" => 10,
        "picture_url" => "https://contents.mediadecathlon.com/p2402441/k$65ce62945e874c670bc44dea54bd96fb/sq/chausson-descalade-vertika-soft-homme-bleuocre.jpg?format=auto&f=800x0",
    ]
];
?>

<?php
ob_start();
include("header.php");
$buffer = ob_get_contents();
ob_end_clean();

$buffer = str_replace("%TITLE%", "Multidimensional catalogue", $buffer);
echo $buffer;
?>

<!-- Je préfère rendre obsolète ce code et je choisis celui d'après -->
<!-- ----------------------------------------------------------- -->
<!-- <?php

foreach ($products as $element) {
    echo "<div class='monProduit'>";
    echo "<h3>";
    echo $element["name"] . "<br>" . "</h3>";
    echo "<p>";
    echo "Prix : " . $element["price"] . "€" . "<br>";
    echo "</p>";
    echo "<img src=$element[picture_url] alt=$element[name] width='300px'>";
    echo "</div>";
}

include("footer.php");
?> -->
<!-- ----------------------------------------------------------- -->

<!-- code qui fait pareil que celui au dessus mais un peu plus propre -->
<!-- ----------------------------------------------------------- -->
<?php
foreach ($products as $element) {
    ?>
    <div class="monProduit">
        <h3> <?php echo $element["name"] ?> <br> </h3>
        <p> Prix HT : <?php echo formatPrice(priceExcludingVAT($element["price"])) ?> <br> </p>
        <p> Prix TTC : <?php echo formatPrice($element["price"]) ?> <br> </p>
        <img src="<?php echo $element['picture_url'] ?>" alt="<?php echo $element["name"] ?>" width="300px">
        <form action="/cart.php" method="GET">
            <label for="quantity">Quantité</label>
            <input type="hidden" name="nomCommande" id="nomCommande" value="<?php echo $element["name"] ?>">
            <input type="hidden" name="prixCommande" id="prixCommande" value="<?php echo $element["price"] ?>">
            <input type="hidden" name="discountCommande" id="discountCommande" value="<?php echo $element["discount"] ?>">
            <input type="hidden" name="urlImg" id="urlImg" value="<?php echo $element["picture_url"] ?>">
            <input type="number" name="quantity" id="quantity" min="0" max="5" value="<?php echo $quantity; ?>">
            <input type="submit" value="Je commande">
        </form>
    </div>

    <?php
}
?>
<!-- ----------------------------------------------------------- -->

</body>

</html>









<!-- Première version du code -->
<!-- ----------------------------------------------------------- -->
<!-- <body>
    <div class="monProduit">
        <h3>
            <?php
            echo $products["scarpa"]["name"];
            ?>
        </h3>
        <p><?php echo $products["scarpa"]["price"] ?> €</p>
        <img src="<?php echo $products["scarpa"]["picture_url"] ?>" alt="<?php echo $products["scarpa"]["name"]; ?>"
            width="300px">
    </div>

    <div class="monProduit">
        <h3>
            <?php
            echo $products["laSportiva"]["name"];
            ?>
        </h3>
        <p><?php echo $products["laSportiva"]["price"] ?> €</p>
        <img src="<?php echo $products["laSportiva"]["picture_url"] ?>"
            alt="<?php echo $products["laSportiva"]["name"]; ?>" width="300px">

    </div>
    <div class="monProduit">
        <h3>
            <?php
            echo $products["simond"]["name"];
            ?>
        </h3>
        <p><?php echo $products["simond"]["price"] ?> €</p>
        <img src="<?php echo $products["simond"]["picture_url"] ?>" alt="<?php echo $products["simond"]["name"]; ?>"
            width="300px">
    </div>

    <?php
    include("footer.php");
    ?> -->
<!-- ----------------------------------------------------------- -->