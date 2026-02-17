<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Besoins | SOS Cyclone</title>

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
                <a href="/listesbesoins" class="nav-link active">Besoins</a>
                <a href="/logout" class="nav-link text-danger">Déconnexion</a>
            </nav>
        </div>
    </header>

    <main class="container">

        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h1 class="mb-1">Besoins par Ville</h1>
                <p class="text-muted mb-0">Gestion, attribution et achats</p>
            </div>
            <div class="d-flex gap-2">
                <a href="/historiqueAchat" class="btn btn-outline">
                    <i class="bi bi-clock-history"></i> Historique
                </a>
                <a href="/insertBesoins" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i> Nouveau Besoin
                </a>
            </div>
        </div>

        <?php if (!empty($success)): ?>
            <div class="alert alert-success">
                <i class="bi bi-check-circle-fill me-2"></i> <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <?php if (empty($donnees)): ?>
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="bi bi-geo-alt text-muted" style="font-size: 3rem;"></i>
                    <p class="text-muted mt-3">Aucune ville n'a encore signalé de besoins.</p>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($donnees as $section): ?>
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center bg-light-primary">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-geo-alt-fill text-primary"></i>
                            <h2 class="h5 mb-0 text-primary-dark"><?php echo htmlspecialchars($section['ville']['nom_ville']); ?></h2>
                        </div>
                        <!-- <div class="d-flex gap-3 text-sm">
                            <span class="badge bg-secondary">Total: <?php echo $section['total_demande']; ?></span>
                            <span class="badge bg-success">Attribué: <?php echo $section['total_attribue']; ?></span>
                        </div> -->
                    </div>

                    <div class="card-body p-0">
                        <?php if (empty($section['besoins'])): ?>
                            <div class="p-4 text-center text-muted">
                                Aucun besoin spécifique enregistré.
                            </div>
                        <?php else: ?>
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>Produit</th>
                                        <th class="text-center">Stock</th>
                                        <th class="text-center">Demande</th>
                                        <th class="text-center">Attribué</th>
                                        <th class="text-center">Reste</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($section['besoins'] as $besoin): ?>
                                        <tr>
                                            <td class="fw-bold">
                                                <?php echo htmlspecialchars($besoin['nom_produit']); ?>
                                            </td>
                                            <td class="text-center text-muted">
                                                <?php echo $besoin['stock_disponible']; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php echo $besoin['quantite']; ?>
                                            </td>
                                            <td class="text-center text-success">
                                                <?php echo $besoin['quantite_attribuee']; ?>
                                            </td>
                                            <td class="text-center text-danger fw-bold">
                                                <?php echo $besoin['reste']; ?>
                                            </td>
                                            <td class="text-end">
                                                <div class="d-flex align-items-center justify-content-end gap-2">

                                                    <!-- Actions Logic -->
                                                    <?php if ($besoin['reste'] <= 0): ?>
                                                        <span class="badge bg-success"><i class="bi bi-check-lg"></i> Complet</span>
                                                    <?php else: ?>

                                                        <!-- Attribuer Form -->
                                                        <?php if ($besoin['stock_disponible'] > 0): ?>
                                                            <form action="/attribuer" method="POST" class="d-flex gap-1">
                                                                <input type="hidden" name="id_ville" value="<?php echo $section['ville']['idville']; ?>">
                                                                <input type="hidden" name="idproduit" value="<?php echo $besoin['idproduit']; ?>">
                                                                <input type="number" name="quantite" class="form-control" style="width: 70px; padding: 4px 8px; font-size: 0.9em;" placeholder="Qté" min="1" max="<?php echo min($besoin['reste'], $besoin['stock_disponible']); ?>" required>
                                                                <button type="submit" class="btn btn-primary btn-sm" title="Attribuer">
                                                                    <i class="bi bi-box-seam"></i> Attribuer
                                                                </button>
                                                            </form>
                                                        <?php else: ?>
                                                            <span class="badge bg-warning text-dark"><i class="bi bi-exclamation-triangle"></i> Stock vide</span>
                                                        <?php endif; ?>

                                                        <!-- Acheter Form -->
                                                        <?php if ($besoin['idproduit'] != 5): // Special condition kept from original 
                                                        ?>
                                                            <form action="/acheter" method="POST" class="d-flex gap-1 ms-2" style="border-left: 1px solid #eee; padding-left: 8px;">
                                                                <input type="hidden" name="id_ville" value="<?php echo $section['ville']['idville']; ?>">
                                                                <input type="hidden" name="idproduit" value="<?php echo $besoin['idproduit']; ?>">
                                                                <input type="number" name="quantite" class="form-control" style="width: 70px; padding: 4px 8px; font-size: 0.9em;" placeholder="Qté" required>
                                                                <button type="submit" class="btn btn-accent btn-sm" title="Acheter">
                                                                    <i class="bi bi-cart"></i> Acheter
                                                                </button>
                                                            </form>
                                                        <?php endif; ?>

                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </main>

</body>

</html>