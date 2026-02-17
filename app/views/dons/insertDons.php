<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrer un Don | SOS Cyclone</title>

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- CSS System -->
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/pages/main.css">
</head>

<body>
    <!-- Navbar -->
    <header class="app-header">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="/accueil" class="app-brand">
                <i class="bi bi-heart-pulse-fill"></i> SOS Cyclone
            </a>
            <nav class="nav-menu">
                <a href="/accueil" class="nav-link">Accueil</a>
                <a href="/insertDons" class="nav-link active">Dons</a>
                <a href="/logout" class="nav-link text-danger">Déconnexion</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <div class="row justify-content-center">
            <div class="col-8"> <!-- Using standard col-8 width for form centering -->

                <div class="d-flex align-items-center gap-3 mb-4">
                    <a href="/accueil" class="btn btn-outline btn-sm">
                        <i class="bi bi-arrow-left"></i> Retour
                    </a>
                    <h1 class="h2 mb-0">Enregistrer un Don</h1>
                </div>

                <div class="card" style="border-top: 4px solid var(--color-success);">
                    <div class="card-header">
                        <span class="text-success"><i class="bi bi-gift-fill me-2"></i>Saisie d'un nouveau don</span>
                    </div>

                    <div class="card-body">

                        <?php if (isset($success) && $success): ?>
                            <div class="alert alert-success">
                                <i class="bi bi-check-circle-fill me-2"></i> <?= htmlspecialchars($success) ?>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($error) && $error): ?>
                            <div class="alert alert-danger">
                                <i class="bi bi-exclamation-octagon-fill me-2"></i> <?= htmlspecialchars($error) ?>
                            </div>
                        <?php endif; ?>

                        <form action="/insertDons" method="POST">

                            <div class="form-group">
                                <label for="idproduit" class="form-label">Nature du Don (Produit)</label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="bi bi-box2-heart"></i></div>
                                    <select name="idproduit" id="idproduit" class="form-control" required>
                                        <option value="">-- Sélectionnez le type de don --</option>
                                        <?php if (isset($produits)): ?>
                                            <?php foreach ($produits as $produit): ?>
                                                <option value="<?= $produit['idproduit'] ?>"><?= htmlspecialchars($produit['nom_produit']) ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="text-muted text-sm mt-1">Le type de produit reçu ou la contre-valeur monétaire.</div>
                            </div>

                            <div class="form-group">
                                <label for="quantite" class="form-label">Quantité / Montant</label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="bi bi-123"></i></div>
                                    <input type="number" name="quantite" id="quantite" class="form-control" min="1" placeholder="Ex: 1000" required>
                                </div>
                            </div>

                            <div class="d-grid gap-2 mt-5">
                                <button type="submit" class="btn btn-success" style="background-color: var(--color-success); border-color: var(--color-success); color: white;">
                                    <i class="bi bi-check-lg"></i> Valider ce don
                                </button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </main>

</body>

</html>