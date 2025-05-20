<?php

include ("my_functions.php");

ob_start();
include("header.php");
$buffer = ob_get_contents();
ob_end_clean();

$buffer = str_replace("%TITLE%", "Index", $buffer);
echo $buffer;

echo 'Bienvenue dans mon projet';
include('footer.php');
?>
>>>>>>> master
