<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique Achats | SOS Cyclone</title>

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
                <a href="/historiqueAchat" class="nav-link active">Historique</a>
                <a href="/logout" class="nav-link text-danger">Déconnexion</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Historique des Achats</h1>
            <a href="/listesbesoins" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Retour à la liste
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <?php if (empty($achats)): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-cart-x text-muted" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-3">Aucun achat enregistré pour le moment.</p>
                        <a href="/listesbesoins" class="btn btn-primary mt-2">Aller aux besoins</a>
                    </div>
                <?php else: ?>
                    <div style="overflow-x: auto;">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Ville</th>
                                    <th>Produit</th>
                                    <th class="text-end">Montant</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $grandTotal = 0;
                                foreach ($achats as $achat):
                                    $grandTotal += $achat['montant'];
                                ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="bi bi-geo-alt text-muted"></i>
                                                <?= htmlspecialchars($achat['nom_ville'] ?? 'N/A') ?>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info" style="background-color: var(--color-bg-body); color: var(--color-text-main); font-weight: normal;">
                                                <?= htmlspecialchars($achat['nom_produit'] ?? 'N/A') ?>
                                            </span>
                                        </td>
                                        <td class="text-end fw-bold" style="font-family: monospace;">
                                            <?= number_format($achat['montant'], 0, ',', ' ') ?> Ar
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr style="background-color: var(--color-bg-body);">
                                    <td colspan="2" class="text-end fw-bold">TOTAL GÉNÉRAL</td>
                                    <td class="text-end fw-bold text-primary">
                                        <?= number_format($grandTotal, 0, ',', ' ') ?> Ar
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

</body>

</html>