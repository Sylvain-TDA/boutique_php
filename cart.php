<?php
ob_start();
include("header.php");
$buffer = ob_get_contents();
ob_end_clean();

$buffer = str_replace("%TITLE%", "Votre panier", $buffer);
echo $buffer;
?>

<?php
include "my_functions.php";
?>

<div>
    <ul>
        <li>
            <?php
            echo $_GET["nomCommande"];
            ?>
        </li>
        <li>
            <?php
            echo formatPrice($_GET["prixCommande"]);
            ?>
        </li>
        <li>
            <?php
            echo $_GET["discountCommande"] . "%";
            ?>
        </li>
        <li>
            <?php
            echo "Quantité : " . $_GET["quantity"];
            ?>
        </li>
        <li>
            <img src="<?php $_GET["urlImg"]?>" alt="Photo">
        </li>
    </ul>
    <br>
    <p>Total :
        <?php
        echo formatPrice(($_GET["prixCommande"] * $_GET["quantity"]) * (100 - ($_GET["discountCommande"])) / 100);
        ?>
    </p>
</div>

<?php
include "footer.php";
?>