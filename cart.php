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

<div class="monProduit">
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
    </ul>
    <br>
    <img src="<?php echo $_GET["urlImg"]; ?>" alt="Photo">
    <p>Total HT:
        <?php
        $montantHT = priceExcludingVAT(((int) $_GET["prixCommande"] * (int) $_GET["quantity"]) * (100 - ((int) $_GET["discountCommande"])) / 100);
        echo formatPrice($montantHT);
        ?>
    </p>
    <p>Total TVA:
        <?php
        echo $TVA = formatPrice($montantHT*0.2) ;
        ?>
    </p>
    <p>Total TTC :
        <?php
        $montantTTC = ((int) $_GET["prixCommande"] * (int) $_GET["quantity"]) * ((100 - (int) $_GET["discountCommande"]) / 100);
        echo formatPrice($montantTTC);

        ?>
    </p>
</div>

<?php
include "footer.php";
?>