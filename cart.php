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
        foreach ($products as $x) {
            if (isset($_POST["quantity$x"]) && (int) $_POST["quantity$x"] != 0) {
                $nom = htmlspecialchars($_POST["nomCommande$x"]);
                $qty = (int) $_POST["quantity$x"];
                $prix = (float) htmlspecialchars($_POST["prixCommande$x"]);
                $discount = (float) htmlspecialchars($_POST["discountCommande$x"]);
                $img = htmlspecialchars($_POST["img_url$x"]);
                $weight = (float) htmlspecialchars($_POST["weight$x"]);
                $product_id = $_POST["product_id$x"];
                print_r($product_id);
                if (isset($_POST['form_token']) && $_POST['form_token'] === $_SESSION['form_token']) {
                    if (isset($_SESSION["commande$x"]) && isset($_SESSION['form_token'])) {
                        $_SESSION["commande$x"][1] += $qty;
                    } else {
                        $_SESSION["commande$x"] = [$nom, $qty, $prix, $discount, $img, $weight, $product_id];
                    }
                }
            }
        }

        foreach ($products as $x) {

            if (!empty($_SESSION["commande" . $x])) {
                ?>
                <div class="monProduitPanier">
                    <h2><?php print_r($_SESSION["commande" . $x][0]); ?></h2>
                    <img src="<?php print_r($_SESSION["commande" . $x][4]); ?>" alt="Photo" width="50px">
                    <p>Quantité :
                        <?php
                        print_r($_SESSION["commande" . $x][1]);
                        ;
                        ?>
                        <!-- Product_id :
                        <?php
                        print_r($_SESSION);
                        ?> -->
                    </p>
                    <h3 class="reducedPrice">P.U : <?php $formatedPrice = ($_SESSION["commande" . $x][2]);
                    echo formatPrice($formatedPrice); ?> </h3>
                    <p class="solde">Solde : <?php print_r($_SESSION["commande" . $x][3]); ?> % </p>
                    <p>Poids :
                        <?php
                        $poids = $_SESSION["commande" . $x][5] * $_SESSION["commande" . $x][1];
                        echo $poids;
                        ?> gr
                    </p>
                    <p>Total HT avec solde:
                        <?php
                        $montantHT = (discountedPrice($_SESSION["commande$x"][2], $_SESSION["commande$x"][3])) * $_SESSION["commande$x"][1];
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
                        $_SESSION["commande" . $x][6] = $montantTTC;
                        $_SESSION["commande" . $x][7] = $poids;
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
            if (isset($_SESSION["commande" . $element[1]][6])) {
                $sumWeight += $_SESSION["commande" . $element][6];
                $somme += $_SESSION["" . $element][7];
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
    placeOrder($somme, $_SESSION['shipping_cost'], $sumWeight, 1, 1, );
}

include "footer.php";
?>