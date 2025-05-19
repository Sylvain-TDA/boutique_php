<body>

    <div class="monProduit">
        <?php
        $nom = "Chaussons Scarpa Vapor V";
        $prix = 120;
        $urlImg = "https://content.backcountry.com/images/items/large/SCR/SCR008R/OCE.jpg";
        ?>
        <h1> <?php
        echo $nom;
        ?></h1>
        <p>
            <?php
            echo "\n Le prix est de " . $prix . " euros";
            echo "\n";
            ?>
        </p>
        <p><br> <img src=<?php echo $urlImg ?> alt="scarpa"></p>
        <?php
        ?>
    </div>

</body>

</html>