<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saisir un Besoin | SOS Cyclone</title>

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
    <!-- Sidebar -->
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/../app/views/partials/sidebar.php'; ?>

    <header class="app-header">
        <div class="container d-flex justify-content-between align-items-center">

            <div class="d-flex align-items-center">
                <button class="sidebar-toggle" id="sidebarToggle" title="Menu">
                    <i class="bi bi-list"></i>
                </button>
                <a href="/accueil" class="app-brand" style="margin:0; font-size: 1.25rem;">
                    SOS Cyclone
                </a>
            </div>

            <nav class="nav-menu">
                <span class="nav-link active" style="cursor: default;">Saisir Besoins</span>
                <a href="/logout" class="btn btn-outline btn-sm text-danger ms-3" style="border-color: var(--color-error); color: var(--color-error);">
                    <i class="bi bi-box-arrow-right"></i> Déconnexion
                </a>
            </nav>
        </div>
    </header>

    <main class="container">
        <div class="row justify-content-center">
            <div class="col-8"> <!-- Using standard col-8 width for form centering -->

                <div class="d-flex align-items-center gap-3 mb-4">
                    <a href="/listesbesoins" class="btn btn-outline btn-sm">
                        <i class="bi bi-arrow-left"></i> Retour
                    </a>
                    <h1 class="h2 mb-0">Déclarer un Besoin</h1>
                </div>

                <div class="card">
                    <div class="card-header">
                        <span class="text-primary-dark"><i class="bi bi-clipboard-plus me-2"></i>Formulaire de saisie</span>
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

                        <form action="/insertBesoins" method="POST">

                            <div class="form-group">
                                <label for="id_ville" class="form-label">Ville ou Zone Sinistrée</label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="bi bi-geo-alt"></i></div>
                                    <select name="id_ville" id="id_ville" class="form-control" required>
                                        <option value="">-- Sélectionnez une ville --</option>
                                        <?php if (isset($villes)): ?>
                                            <?php foreach ($villes as $ville): ?>
                                                <option value="<?= $ville['idville'] ?>"><?= htmlspecialchars($ville['nom_ville']) ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="text-muted text-sm mt-1">La ville concernée par ce besoin.</div>
                            </div>

                            <div class="form-group">
                                <label for="idproduit" class="form-label">Type de besoin (Produit)</label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="bi bi-box-seam"></i></div>
                                    <select name="idproduit" id="idproduit" class="form-control" required>
                                        <option value="">-- Sélectionnez un produit --</option>
                                        <?php if (isset($produits)): ?>
                                            <?php foreach ($produits as $produit): ?>
                                                <option value="<?= $produit['idproduit'] ?>"><?= htmlspecialchars($produit['nom_produit']) ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="quantite" class="form-label">Quantité Nécessaire</label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="bi bi-123"></i></div>
                                    <input type="number" name="quantite" id="quantite" class="form-control" min="1" placeholder="Ex: 50" required>
                                </div>
                            </div>

                            <div class="d-grid gap-2 mt-5">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-send-check"></i> Enregistrer ce besoin
                                </button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <footer class="app-footer">
        <div class="container text-center">
            <p class="footer-numbers">4019-4090-4395</p>
            <p class="footer-copyright">&copy; 2026 SOS Cyclone. Tous droits réservés.</p>
        </div>
    </footer>

</body>

</html>