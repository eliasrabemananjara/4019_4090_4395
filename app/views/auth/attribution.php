<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attribution</title>
</head>

<body>
    <h1>Attribution</h1>

    <?php 
        foreach ($stocks as $stock) { ?>
            <p><a href="/attribForm?idproduit=<?php echo $stock['idproduit']; ?>&idstock=<?php echo $stock['idstock']; ?>">Id stock: <?php echo $stock['idstock']; ?></a> - id produit: <?php echo $stock['idproduit']; ?> - quantité: <?php echo $stock['quantite']; ?> - Created at: <?php echo $stock['created_at']; ?></p>
        <?php }
    ?>

    <br>
    <a href='/accueil'>Retour à l'accueil</a>
</body>
    
</html>