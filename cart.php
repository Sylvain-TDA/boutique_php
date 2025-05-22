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
            if (isset(($_GET["quantity$x"])) && (int) $_GET["quantity$x"] != 0) {
                ?>
                <div class="monProduitPanier">
                    <h2><?php echo $_GET["nomCommande$x"]; ?></h2>
                    <img src="<?php echo $_GET["urlImg$x"]; ?>" alt="Photo" width="50px">
                    <p><?php echo "Quantité : " . $_GET["quantity$x"]; ?> </p>
                    <h3><?php echo "P.U : " . formatPrice($_GET["prixCommande$x"]); ?> </h3>
                    <p><?php echo "Solde : " . $_GET["discountCommande$x"] . "%"; ?> </p>
                    <p>Poids :
                        <?php
                        $poids = (int) $_GET["weight$x"] * (int) $_GET["quantity$x"];
                        echo $_GET["weight$x"];
                        ?> gr
                    </p>
                    <p>Total HT:
                        <?php
                        $montantHT = priceExcludingVAT(((int) $_GET["prixCommande$x"] * (int) $_GET["quantity$x"]) * (100 - ((int) $_GET["discountCommande$x"])) / 100);
                        echo (formatPrice($montantHT));
                        ?>
                    </p>
                    <p>Total TVA:
                        <?php
                        $TVA = round(($montantHT * 0.2) / 100, 2);
                        echo $TVA . "€";
                        ?>
                    </p>
                    <h2>Total TTC :
                        <?php
                        $montantTTC = ((float) $_GET["prixCommande$x"] * (int) $_GET["quantity$x"]) * ((100 - (float) $_GET["discountCommande$x"]) / 100);
                        echo formatPrice($montantTTC);
                        ?>
                    </h2>
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
            <select id="transporteurSelection" name="transporteur" onchange="this.form.submit()">
                <option value="transporteur" selected="Transporteur"></option>
                <option value="DHL">DHL</option>
                <option value="UPS">UPS</option>
                <option value="Fedex">Fedex</option>
            </select>
            </p>
        </form>
        <p><?php
        if (isset($_POST["transporteur"])) {
            echo "Vous avez choisi : " . $_POST["transporteur"] . ", pour un montant de " . shippingCost($_POST["transporteur"], $sumWeight, $somme / 100) . "€ <br>";
        }
        ;
        ?></p>
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