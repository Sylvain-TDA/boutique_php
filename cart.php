<?php
session_start();

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
                $_SESSION["commande" . $x] = array($_GET['nomCommande' . $x], $_GET['quantity' . $x], $_GET['prixCommande' . $x], $_GET['discountCommande' . $x], $_GET["urlImg" . $x], $_GET["weight" . $x] );
            }
        }
        foreach ($products as $x) {
            if (!empty($_SESSION["commande" . $x])) {
                ?>
                <div class="monProduitPanier">
                    <h2><?php print_r($_SESSION["commande" . $x][0]); ?></h2>
                    <img src="<?php print_r($_SESSION["commande" . $x][4]); ?>" alt="Photo" width="50px">
                    <p>Quantité : <?php print_r($_SESSION["commande" . $x][1]); ?> </p>
                    <h3>P.U : <?php $formatedPrice = ($_SESSION["commande" . $x][2]);
                    echo formatPrice($formatedPrice);  ?> </h3>
                    <p>Solde : <?php print_r($_SESSION["commande" . $x][3]); ?> % </p>
                    <p>Poids :
                        <?php
                        $poids = $_SESSION["commande" . $x][5] * $_SESSION["commande" . $x][1];
                        echo $poids;
                        ?> gr
                    </p>
                    <p>Total HT:
                        <?php
                        $montantHT = ($_SESSION["commande" . $x][2] * (int) $_SESSION["commande" . $x][1]) * (100 - ($_SESSION["commande" . $x][3])) / 100;
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
                        $montantTTC = (($_SESSION["commande" . $x][2] * (int) $_SESSION["commande" . $x][1]))* (1-(($_SESSION["commande" . $x][3])/100));
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
                <option value="transporteur" selected="Transporteur">Choisir un transporteur</option>
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