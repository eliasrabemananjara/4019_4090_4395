<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil | SOS Cyclone</title>

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
                <a href="/accueil" class="nav-link active">Accueil</a>
                <a href="/logout" class="btn btn-outline btn-sm text-danger" style="border-color: var(--color-error); color: var(--color-error);">
                    <i class="bi bi-box-arrow-right"></i> Déconnexion
                </a>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container">

        <div class="row mb-5">
            <div class="col-12 text-center">
                <h1 class="mb-3">Tableau de Bord</h1>
                <p style="max-width: 600px; margin: 0 auto; color: var(--color-text-muted);">
                    Bienvenue sur la plateforme de gestion humanitaire. Sélectionnez une action ci-dessous pour gérer les besoins, les dons et les achats.
                </p>
            </div>
        </div>

        <div class="dashboard-grid">

            <!-- Actions Cards -->
            <a href="/insertBesoins" class="card stat-card" style="text-decoration: none; border-left: 4px solid var(--color-primary);">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <i class="bi bi-clipboard-plus text-primary" style="font-size: 1.5rem;"></i>
                    <h3 class="h5 mb-0 text-dark">Saisir Besoins</h3>
                </div>
                <p class="text-muted text-sm">Ajouter des besoins pour une ville ou une zone sinistrée.</p>
                <span class="btn btn-sm btn-outline mt-auto w-100">Accéder</span>
            </a>

            <a href="/insertDons" class="card stat-card" style="text-decoration: none; border-left: 4px solid var(--color-success);">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <i class="bi bi-gift text-success" style="font-size: 1.5rem;"></i>
                    <h3 class="h5 mb-0 text-dark">Saisir Dons</h3>
                </div>
                <p class="text-muted text-sm">Enregistrer les dons financiers reçus.</p>
                <span class="btn btn-sm btn-outline mt-auto w-100">Accéder</span>
            </a>

            <a href="/listesbesoins" class="card stat-card" style="text-decoration: none; border-left: 4px solid var(--color-warning);">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <i class="bi bi-list-check text-warning" style="font-size: 1.5rem;"></i>
                    <h3 class="h5 mb-0 text-dark">Liste & Attribution</h3>
                </div>
                <p class="text-muted text-sm">Voir les besoins par ville et attribuer les dons/stocks.</p>
                <span class="btn btn-sm btn-outline mt-auto w-100">Accéder</span>
            </a>

            <a href="/vente" class="card stat-card" style="text-decoration: none; border-left: 4px solid var(--color-danger);">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <i class="bi bi-cart4 text-danger" style="font-size: 1.5rem;"></i>
                    <h3 class="h5 mb-0 text-dark">Vente de Stock</h3>
                </div>
                <p class="text-muted text-sm">Vendre des produits en stock.</p>
                <span class="btn btn-sm btn-outline mt-auto w-100">Accéder</span>
            </a>

            <a href="/historiqueAchat" class="card stat-card" style="text-decoration: none; border-left: 4px solid var(--color-info);">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <i class="bi bi-cart-check text-info" style="font-size: 1.5rem;"></i>
                    <h3 class="h5 mb-0 text-dark">Achats</h3>
                </div>
                <p class="text-muted text-sm">Consulter l'historique des achats effectués.</p>
                <span class="btn btn-sm btn-outline mt-auto w-100">Accéder</span>
            </a>

            <a href="/recapitulatif" class="card stat-card" style="text-decoration: none; border-left: 4px solid var(--color-secondary);">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <i class="bi bi-bar-chart-fill text-secondary" style="font-size: 1.5rem;"></i>
                    <h3 class="h5 mb-0 text-dark">Récapitulatif Global</h3>
                </div>
                <p class="text-muted text-sm">Vues d'ensemble des chiffres clés et répartition.</p>
                <span class="btn btn-sm btn-outline mt-auto w-100">Accéder</span>
            </a>

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