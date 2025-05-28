<?php
session_start();


ob_start();
include("header.php");
$buffer = ob_get_contents();
ob_end_clean();

$buffer = str_replace("%TITLE%", "Mes commandes", $buffer);
echo $buffer;
?>

<?php
include "my_functions.php";
include "database.php";

$products = listingOrders();
?>
<form action="/cart.php" method="POST" class="formulaireBoutique">
    <?php
    foreach ($products as $element) {
        ?>
        <div class="monProduit">
            <p> Commande n° <?php echo $element["number"] ?> <br> </p>
            <p> Montant de la commande <?php echo $element["total_commande"] . " €" ?> <br> </p>
            </div>

        <?php
    }
    ?>
</form>

<?php include "footer.php"; ?>

</body>

</html>