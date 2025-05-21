<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


ob_start();
include("header.php");
$buffer = ob_get_contents();
ob_end_clean();

$buffer = str_replace("%TITLE%", "Votre panier", $buffer);
echo $buffer;
?>

<?php
include "my_functions.php";
$products = ["Scarpa", "LaSportiva", "Simond"];
$somme = 0;
$sumWeight = 0;
?>


<div class="monPanier">
    <div class="listeProduits">
        <?php
        foreach ($products as $x) {
            if (isset(($_GET["quantity" . $x])) && $_GET["quantity" . $x] != 0) {
                ?>
                <div class="monProduitPanier">
                    <p><?php echo $_GET["nomCommande$x"]; ?></p>
                    <p><?php echo formatPrice($_GET["prixCommande$x"]); ?> </p>
                    <p><?php echo $_GET["discountCommande$x"] . "%"; ?> </p>
                    <p><?php echo "Quantité : " . $_GET["quantity$x"]; ?> </p>
                    <img src="<?php echo $_GET["urlImg$x"]; ?>" alt="Photo" width="50px">
                    <p>Total HT:
                        <?php
                        $montantHT = priceExcludingVAT(((int) $_GET["prixCommande$x"] * (int) $_GET["quantity$x"]) * (100 - ((int) $_GET["discountCommande$x"])) / 100);
                        echo (formatPrice($montantHT));
                        ?>
                    </p>
                    <p>Total TVA:
                        <?php
                        $TVA = ($montantHT * 0.2) / 100;
                        echo $TVA . "€";
                        ?>
                    </p>
                    <p>Total TTC :
                        <?php
                        $montantTTC = ($_GET["prixCommande$x"] * $_GET["quantity$x"]) * ((100 - $_GET["discountCommande$x"]) / 100);
                        echo formatPrice($montantTTC);
                        ?>
                    </p>
                    <p>Poids :
                        <?php
                        $poids = $_GET["weight$x"] * $_GET["quantity$x"];
                        echo $_GET["weight$x"];
                        ?> gr
                    </p>
                </div>
                <?php
                $somme += $montantTTC;
                $sumWeight += $poids;
            }
        }
        ?>

    </div>
    <div class="monTotal">
        <p>Frais de port : <?php
        echo shippingCost($sumWeight, $somme / 100) ?></p>
        <p>Total général :
            <?php
            echo formatPrice($somme);
            ?>
        </p>
    </div>
</div>

<?php
include "footer.php";
?>