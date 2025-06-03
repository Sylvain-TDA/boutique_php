<?php
session_start();

// include ("my_functions.php");

$monTitre = "Page Scarpa";
$maDescription = "Voici la page de $monTitre";
$products = [];
include "database.php";
include "my_functions.php";

ob_start();
include("header.php");
$buffer = ob_get_contents();
ob_end_clean();

// Générer un jeton unique
if (empty($_SESSION['form_token'])) {
    $_SESSION['form_token'] = bin2hex(random_bytes(32));
}

$buffer = str_replace("%TITLE%", "Boutique", $buffer);
echo $buffer;
?>

<?php
$commandeDuJour = todayOrders();
foreach ($commandeDuJour as $element) {
    ?>
    <div>
        <p> Aujourd'hui, vous avez commandé pour : <?php echo $element["total"] . " €" ?> <br> </p>
    </div>

    <?php
}
?>


<form method="GET">
    <input type="radio" id="shortage" name="radio" value="shortage">
    <label for="shortage"> Produits en rupture</label><br>
    <input type="radio" id="everything" name="radio" value="everything">
    <label for="everything"> Tous les produits</label><br>
    <button type="submit">Raffrachir</button>
</form>


<?php
if ($_GET['radio'] == "shortage") {
    $products = changingProducts('shortage');
} else {
    $products = changingProducts('else');
}
;
?>

<form action="/cart.php" method="POST" class="formulaireBoutique">
    <?php
    foreach ($products as $element) {
        ?>
        <div class="monProduit">
            <h3> <?php echo $element["name"] ?> <br> </h3>
            <p> Prix HT : <?php echo formatPrice(priceExcludingVAT($element["price"])) ?> <br> </p>
            <p> Prix TTC : <?php echo formatPrice($element["price"]) ?> <br> </p>
            <img src="<?php echo $element["img_url"] ?>" alt="<?php echo $element["name"] ?>" width="300px">
            <div class="submitParent">
                <label for="quantity">Quantité</label>
                <input type="hidden" name="form_token" value="<?php echo $_SESSION['form_token']; ?>">
                <input type="hidden" name="nomCommande<?php echo $element["name"] ?>" id="nomCommande"
                    value="<?php echo $element["name"] ?>">
                <input type="hidden" name="weight<?php echo $element["name"] ?>" id="weight"
                    value="<?php echo $element["weight"] ?>">
                <input type="hidden" name="prixCommande<?php echo $element["name"] ?>" id="prixCommande"
                    value="<?php echo $element["price"] ?>">
                <input type="hidden" name="discountCommande<?php echo $element["name"] ?>" id="discountCommande"
                    value="<?php echo (int) $element["discount"] ?>">
                <input type="hidden" name="img_url<?php echo $element["name"] ?>" id="img_url"
                    value="<?php echo $element["img_url"] ?>">

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

</body>

</html>