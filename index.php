<?php
session_start();

include "my_functions.php";

ob_start();
include("header.php");
$buffer = ob_get_contents();
ob_end_clean();

$buffer = str_replace("%TITLE%", "Accueil", $buffer);
echo $buffer;

echo "<h1> Bienvenue sur la boutique de la grimpe </h1>";
echo "<div class='backgroundImg'><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br></div>";
?>


<?php
include "footer.php";
?>