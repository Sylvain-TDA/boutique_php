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
$products = ["Scarpa", "LaSportiva", "Simond"];
$somme = 0;
$sumWeight = 0;
?>


<div class="monPanier">
    <div class="listeProduits">
        <?php
        foreach ($products as $x) {
            if (isset(($_GET["quantity$x" ])) && (int)$_GET["quantity$x"] != 0) {
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
                        $TVA = round(($montantHT * 0.2) / 100,2);
                        echo $TVA . "€";
                        ?>
                    </p>
                    <p>Total TTC :
                        <?php
                        $montantTTC = ((float)$_GET["prixCommande$x"] * (int)$_GET["quantity$x"]) * ((100 - (float)$_GET["discountCommande$x"]) / 100);
                        echo formatPrice($montantTTC);
                        ?>
                    </p>
                    <p>Poids :
                        <?php
                        $poids = (int)$_GET["weight$x"] * (int)$_GET["quantity$x"];
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
        <form method="POST">
            <label for="transporteur">Choisissez un transporteur :</label>
            <select id="transporteur" name="transporteur" onchange="this.form.submit()">
                <option value="1">DHL</option>
                <option value="2">UPS</option>
            </select>
            </p>
        </form>
        <p>Frais de port : <?php
        // echo $_POST["transpoteur"];
          if (isset($_POST["transporteur"])) {
        echo shippingCost($_POST["transporteur"], $sumWeight, $somme / 100);
        }; ?></p>
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