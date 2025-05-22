<?php
session_start();

// include ("my_functions.php");

$monTitre = "Page Scarpa";
$maDescription = "Voici la page de $monTitre";
include "multidimensional_catalogue.php";
include "my_functions.php";

ob_start();
include("header.php");
$buffer = ob_get_contents();
ob_end_clean();

$buffer = str_replace("%TITLE%", "Multidimensional catalogue", $buffer);
echo $buffer;
?>

<!-- ----------------------------------------------------------- -->

<!-- code qui fait pareil que celui au dessus mais un peu plus propre -->
<!-- ----------------------------------------------------------- -->
<form action="/cart.php" method="POST" class="formulaireBoutique">
    <?php
    foreach ($products as $element) {
        ?>
        <div class="monProduit">
            <h3> <?php echo $element["name"] ?> <br> </h3>
            <p> Prix HT : <?php echo formatPrice(priceExcludingVAT($element["price"])) ?> <br> </p>
            <p> Prix TTC : <?php echo formatPrice($element["price"]) ?> <br> </p>
            <img src="<?php echo $element["picture_url"] ?>" alt="<?php echo $element["name"] ?>" width="300px">
            <div>
                <label for="quantity">Quantité</label>
                <input type="hidden" name="nomCommande<?php echo $element["name"] ?>" id="nomCommande"
                    value="<?php echo $element["name"] ?>">
                <input type="hidden" name="weight<?php echo $element["name"] ?>" id="weight"
                    value="<?php echo $element["weight"] ?>">
                <input type="hidden" name="prixCommande<?php echo $element["name"] ?>" id="prixCommande"
                    value="<?php echo $element["price"] ?>">
                <input type="hidden" name="discountCommande<?php echo $element["name"] ?>" id="discountCommande"
                    value="<?php echo (int) $element["discount"] ?>">
                <input type="hidden" name="urlImg<?php echo $element["name"] ?>" id="urlImg"
                    value="<?php echo $element["picture_url"] ?>">
                <input type="number" name="quantity<?php echo $element["name"] ?>" id="quantity" min="0" max="5"
                    value="<?php echo (int) $quantity; ?>">
                <input type="submit" value="Je commande">
            </div>
        </div>

        <?php
    }
    ?>
</form>
<?php include "footer.php"; ?>
<!-- ----------------------------------------------------------- -->

</body>

</html>
