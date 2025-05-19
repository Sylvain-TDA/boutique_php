<!DOCTYPE html>
<html lang="fr">
<link rel="stylesheet" href="style.css">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produits</title>
</head>

<body>

    <div>
        <?php

        $nom = "Chaussons Scarpa Vapor V";
        $prix = 120;
        $urlImg = "https://content.backcountry.com/images/items/large/SCR/SCR008R/OCE.jpg";

        echo $nom;
        echo "\n";
        echo $prix;
        echo "\n";
        ?>
        <p><br> <img src=<?php echo $urlImg ?> alt="scarpa"></p>

    </div>

</body>

</html>