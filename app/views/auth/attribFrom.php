<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attribution</title>
</head>

<body>
    <h1>Formulaire d'Attribution</h1>

    <form action="/accueil" method="GET">
        <input type="hidden" name="idstock" value="<?php echo $idstock; ?>">
        <p>Quantité: <input type="number" name="quantite" required></p>
        <input type="hidden" name="idproduit" value="<?php echo $idproduit; ?>">
        <select name="idville" id="idville">
            <?php foreach ($villes as $ville) : ?>
                <option value="<?php echo $ville['idville']; ?>"><?php echo $ville['nom_ville']; ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Attribuer</button>
    </form>

    <br>
    <a href='/accueil'>Retour à l'accueil</a>
</body>
    
</html>