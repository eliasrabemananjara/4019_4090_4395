<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vente de Stock | SOS Cyclone</title>

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
                <span class="nav-link active" style="cursor: default;">Vente de Stock</span>
                <a href="/logout" class="btn btn-outline btn-sm text-danger ms-3" style="border-color: var(--color-error); color: var(--color-error);">
                    <i class="bi bi-box-arrow-right"></i> Déconnexion
                </a>
            </nav>
        </div>
    </header>

    <main class="container">
        <div class="row justify-content-center">
            <div class="col-12">

                <div class="d-flex align-items-center gap-3 mb-4">
                    <a href="/accueil" class="btn btn-outline btn-sm">
                        <i class="bi bi-house"></i> Accueil
                    </a>
                    <h1 class="h2 mb-0">Vente de Produits</h1>
                </div>

                <div class="card">
                    <div class="card-header">
                        <span class="text-primary-dark"><i class="bi bi-cart-check me-2"></i>Produits Disponibles</span>
                    </div>

                    <div class="card-body">

                        <!-- Alert Container -->
                        <div id="alert-container"></div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Produit</th>
                                        <th class="text-end">Stock Actuel</th>
                                        <th class="text-end">Prix Unitaire</th>
                                        <th class="text-end">Commission</th>
                                        <th class="text-center" style="width: 200px;">Quantité à Vendre</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($produits) && !empty($produits)): ?>
                                        <?php foreach ($produits as $produit): ?>
                                            <tr id="row-<?= $produit['idproduit'] ?>">
                                                <td class="fw-medium">
                                                    <?= htmlspecialchars($produit['nom_produit']) ?>
                                                    <br>
                                                    <small class="text-muted"><?= htmlspecialchars($produit['nom_type_produit']) ?></small>
                                                </td>
                                                <td class="text-end">
                                                    <span class="badge bg-info text-dark" id="stock-<?= $produit['idproduit'] ?>">
                                                        <?= number_format($produit['quantite_stock'], 0, ',', ' ') ?>
                                                    </span>
                                                </td>
                                                <td class="text-end"><?= number_format($produit['prix_unitaire'], 0, ',', ' ') ?> Ar</td>
                                                <td class="text-end"><?= number_format($produit['commission_pourcentage'], 1, ',', ' ') ?> %</td>
                                                <td class="text-center">
                                                    <input type="number" class="form-control form-control-sm text-center"
                                                        id="qty-<?= $produit['idproduit'] ?>"
                                                        min="1" placeholder="0">
                                                </td>
                                                <td class="text-center">
                                                    <button class="btn btn-primary btn-sm btn-vendre"
                                                        data-id="<?= $produit['idproduit'] ?>"
                                                        data-besoin="<?= $produit['besoin_restant'] ?? 0 ?>">
                                                        <i class="bi bi-cash-coin"></i> Vendre
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">Aucun produit disponible à la vente.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Details Section (Hidden by default) -->
                <div id="details-section" class="mt-4" style="display: none;">
                    <div class="card border-warning">
                        <div class="card-header bg-warning-subtle text-warning-emphasis">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> Impossible de vendre : Besoins non couverts
                        </div>
                        <div class="card-body">
                            <p class="mb-3">La vente ne peut pas être effectuée car elle compromettrait la couverture des besoins suivants :</p>
                            <div id="details-content"></div>
                        </div>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.btn-vendre');

            buttons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const idProduit = this.getAttribute('data-id');
                    const qtyInput = document.getElementById('qty-' + idProduit);
                    const quantite = parseInt(qtyInput.value);

                    // Reset UI
                    document.getElementById('alert-container').innerHTML = '';
                    document.getElementById('details-section').style.display = 'none';

                    if (!quantite || quantite <= 0) {
                        showAlert('Veuillez saisir une quantité valide.', 'danger');
                        return;
                    }

                    // AJAX Request
                    fetch('/vente/vendre', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                idproduit: idProduit,
                                quantite: quantite
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showAlert(data.message + ' Montant total: ' + new Intl.NumberFormat('fr-FR').format(data.montant_total) + ' Ar', 'success');
                                qtyInput.value = '';

                                // Optional: Update stock in UI or reload page
                                // For simplicity, let's reload after a short delay or just update the badge if we had the new stock
                                setTimeout(() => location.reload(), 2000);
                            } else {
                                showAlert(data.message, 'danger');
                                if (data.details) {
                                    document.getElementById('details-content').innerHTML = data.details;
                                    document.getElementById('details-section').style.display = 'block';
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showAlert('Une erreur technique est survenue.', 'danger');
                        });
                });
            });

            function showAlert(message, type) {
                const container = document.getElementById('alert-container');
                container.innerHTML = `
                    <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                        ${type === 'success' ? '<i class="bi bi-check-circle-fill me-2"></i>' : '<i class="bi bi-exclamation-octagon-fill me-2"></i>'}
                        ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
            }
        });
    </script>
</body>

</html>