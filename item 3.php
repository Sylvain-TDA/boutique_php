
<body>

    <div class="monProduit">
        <?php
        $nom = "Chaussons Simond Vertika soft";
        $prix = 65;
        $urlImg = "https://contents.mediadecathlon.com/p2402441/k$65ce62945e874c670bc44dea54bd96fb/sq/chausson-descalade-vertika-soft-homme-bleuocre.jpg?format=auto&f=800x0";
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
        <p><br> <img src=<?php echo $urlImg ?> alt="Simond Vertika soft" width="300px"></p>
        <?php
        ?>
    </div>

</body>

</html>