<?php
$monTitre = "Page Scarpa";
$maDescription = "Voici la page de $monTitre";

ob_start();
include("header.php");
$buffer = ob_get_contents();
ob_end_clean();

$buffer = str_replace("%TITLE%", "Page produit", $buffer);
echo $buffer;

include "item.php";

include "footer.php";
?>