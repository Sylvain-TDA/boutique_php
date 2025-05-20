<?php
$nom = "Chaussons Scarpa Vapor V";
$prix = 120;
$urlImg = "https://content.backcountry.com/images/items/large/SCR/SCR008R/OCE.jpg";
?>

<body>
    <div class="objectCenter">
        <div class="monProduit">
            <h1> <?php
            echo $nom;
            ?></h1>
            <p>
                <?php
                echo "\n Le prix est de " . $prix . " euros";
                echo "\n";
                ?>
            </p>
            <p><br> <img src=<?php echo $urlImg ?> alt="scarpa" width="300px"></p>
            <?php
            ?>
        </div>
    </div>
</body>

</html>