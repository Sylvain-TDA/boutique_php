<?php
session_start();
// echo phpinfo();

ob_start();
include("header.php");
$buffer = ob_get_contents();
ob_end_clean();

$buffer = str_replace("%TITLE%", "Votre panier", $buffer);
echo $buffer;
?>

<?php
include "my_functions.php";
include "database.php";


$somme = 0;
$sumWeight = 0;
$products = getProductName();
$today = (new DateTime())->format("Y-m-d H:i:s");

// echo    "<br>";
// print_r($products);
// echo    "<br>";
// print_r($_POST);

if (isset($_POST["emptyMyCart"])) {
     emptyMyCart();
}
?>

<div class="monPanier">
    <div class="listeProduits">
        <?php
        // if ($_SESSION["commandeScarpa"][1] == 0 && $_SESSION["commandeLaSportiva"][1] == 0 && $_SESSION["commandeSimond"][1] == 0 && $_SESSION["commandeEB"][1] == 0) {
        //     echo "<h2>Votre panier est vide</>";
        // }
        foreach ($products as $product) {
            $name = $product["name"];
            $nameKey = str_replace(' ', '_', $name);
            $quantityKey = "quantity" . $nameKey;
            $nomCommandeKey = "nomCommande" . $nameKey;

            if (isset($_POST[$quantityKey]) && (int) $_POST[$quantityKey] != 0) {
                $nom = htmlspecialchars($_POST[$nomCommandeKey]);
                $qty = (int) $_POST[$quantityKey];
                $prix = (float) htmlspecialchars($_POST["prixCommande" . $nameKey]);
                $discount = (float) htmlspecialchars($_POST["discountCommande" . $nameKey]);
                $img = htmlspecialchars($_POST["img_url" . $nameKey]);
                $weight = (float) htmlspecialchars($_POST["weight" . $nameKey]);
                $product_id = htmlspecialchars($_POST["product_id" . $nameKey]);
                if (isset($_POST['form_token']) && $_POST['form_token'] === $_SESSION['form_token']) {
                    if (isset($_SESSION["commande$nameKey"]) && isset($_SESSION['form_token'])) {
                        $_SESSION["commande$nameKey"][1] += $qty;
                    } else {
                        $_SESSION["commande$nameKey"] = [$nom, $qty, $prix, $discount, $img, $weight, $product_id];
                    }
                }
            }
        }

        foreach ($products as $x) {
            $name = $x["name"];
            $nameKey = str_replace(' ', '_', $name);
            if (!empty($_SESSION["commande" . $nameKey])) {
                ?>
                <div class="monProduitPanier">
                    <h2><?php print_r($_SESSION["commande" . $nameKey][0]); ?></h2>
                    <img src="<?php print_r($_SESSION["commande" . $nameKey][4]); ?>" alt="Photo" width="50px">
                    <p>Quantité :
                        <?php
                        print_r($_SESSION["commande" . $nameKey][1]);
                        ;
                        ?>
                        <!-- Product_id :
                        <?php
                        print_r($_SESSION["commande" . $nameKey][6]);
                        ?> -->
                    </p>
                    <h3 class="reducedPrice">P.U : <?php $formatedPrice = ($_SESSION["commande" . $nameKey][2]);
                    echo formatPrice($formatedPrice); ?> </h3>
                    <p class="solde">Solde : <?php print_r($_SESSION["commande" . $nameKey][3]); ?> % </p>
                    <p>Poids :
                        <?php
                        $poids = $_SESSION["commande" . $nameKey][5] * $_SESSION["commande" . $nameKey][1];
                        echo $poids;
                        ?> gr
                    </p>
                    <p>Total HT avec solde:
                        <?php
                        $montantHT = (discountedPrice($_SESSION["commande" .$nameKey][2], $_SESSION["commande". $nameKey][3])) * $_SESSION["commande". $nameKey][1];
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
                        $montantTTC = $montantHT + $TVA;
                        $_SESSION["commande" . $nameKey][7] = $montantTTC;
                        $_SESSION["commande" . $nameKey][8] = $poids;
                        echo $montantTTC . "€";
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
        foreach ($products as $element) {
            if (isset($_SESSION["commande" . $element[1]][7])) {
                $sumWeight += $_SESSION["commande" . $element][7];
                $somme += $_SESSION["" . $element][8];
            }
        }

        $shippingCost = shippingCost($_POST["transporteur"], $sumWeight, $somme);
        if (isset($_POST["transporteur"])) {
            echo "Vous avez choisi : " . $_POST["transporteur"] . ", pour un montant de " . $shippingCost . "€ <br>";
            $_SESSION['shipping_cost'] = $shippingCost;
        }
        ;
        ?>
        </p>
        <p>Total général :
            <?php
            echo $somme . " €";
            ?>
        </p>
        <form method="POST">
            <input type="submit" value="Vider mon panier" name="emptyMyCart">
        </form>
    </div>
    <div>
        <form method="POST">
            <input type="submit" value="Commander" name="commander">
        </form>
    </div>
</div>

<?php

if ($_POST['commander'] == "Commander") {
    placeOrder($somme, $_SESSION['shipping_cost'], $sumWeight, 1, 1, $_SESSION);
}

include "footer.php";
?>