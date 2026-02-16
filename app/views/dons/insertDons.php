<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Don à la Banque</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-5">
    <h1>Faire un Don</h1>

    <?php if (isset($success) && $success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <?php if (isset($error) && $error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="/insertDons" method="POST" class="mt-4">
        <div class="mb-3">
            <label for="idproduit" class="form-label">Produit</label>
            <select name="idproduit" id="idproduit" class="form-select" required>
                <option value="">Sélectionnez un produit a donner</option>
                <?php foreach ($produits as $produit): ?>
                    <option value="<?= $produit['idproduit'] ?>"><?= htmlspecialchars($produit['nom_produit']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="quantite" class="form-label">Quantité</label>
            <input type="number" name="quantite" id="quantite" class="form-control" min="1" required>
        </div>

        <button type="submit" class="btn btn-primary">Envoyer</button>
        <a href="/accueil" class="btn btn-secondary">Retour</a>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>