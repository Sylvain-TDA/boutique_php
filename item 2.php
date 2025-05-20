
<body>

    <div class="monProduit">
        <?php
        $nom = "Chaussons La Sportiva Katana";
        $prix = 140;
        $urlImg = "https://www.bfgcdn.com/1500_1500_90/301-0448-0111/la-sportiva-solution-climbing-shoes.jpg";
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
        <p><br> <img src=<?php echo $urlImg ?> alt="La sportiva" width="300px"></p>
        <?php
        ?>
    </div>

</body>

</html>