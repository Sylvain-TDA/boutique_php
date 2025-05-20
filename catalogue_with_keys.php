<?php

$scarpa = [
    "name" => "Scarpa",
    "price" => 120,
    "weight" => 550,
    "discount" => 10,
    "picture_url" => "https://content.backcountry.com/images/items/large/SCR/SCR008R/OCE.jpg",
];

$laSportiva = [
    "name" => "La Sportiva",
    "price" => 140,
    "weight" => 520,
    "discount" => 10,
    "picture_url" => "https://www.bfgcdn.com/1500_1500_90/301-0448-0111/la-sportiva-solution-climbing-shoes.jpg",
];

$simond = [
    "name" => "Simond",
    "price" => 65,
    "weight" => 620,
    "discount" => 10,
    "picture_url" => "https://contents.mediadecathlon.com/p2402441/k$65ce62945e874c670bc44dea54bd96fb/sq/chausson-descalade-vertika-soft-homme-bleuocre.jpg?format=auto&f=800x0",
];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogue with keys</title>
</head>

<body>
    <div>
        <h3>
            <?php
            echo $scarpa["name"];
            ?>
        </h3>
        <p><?php echo $scarpa["price"] ?></p>
        <img src="<?php echo $scarpa["picture_url"] ?>" alt="<?php echo $scarpa["name"]; ?>">
    </div>

        <div>
        <h3>
            <?php
            echo $laSportiva["name"];
            ?>
        </h3>
        <p><?php echo $laSportiva["price"] ?></p>
        <img src="<?php echo $laSportiva["picture_url"] ?>" alt="<?php echo $laSportiva["name"]; ?>">
    
    </div>
        <div>
        <h3>
            <?php
            echo $simond["name"];
            ?>
        </h3>
        <p><?php echo $simond["price"] ?></p>
        <img src="<?php echo $simond["picture_url"] ?>" alt="<?php echo $simond["name"]; ?>">
    </div>

</body>

</html>