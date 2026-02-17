<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Récapitulatif | SOS Cyclone</title>

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
                <span class="nav-link active" style="cursor: default;">Récapitulatif</span>
                <a href="/logout" class="btn btn-outline btn-sm text-danger ms-3" style="border-color: var(--color-error); color: var(--color-error);">
                    <i class="bi bi-box-arrow-right"></i> Déconnexion
                </a>
            </nav>
        </div>
    </header>

    <main class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="mb-1">Récapitulatif Financier</h1>
                <p class="text-muted mb-0">Vue d'ensemble des besoins et des dons</p>
            </div>
            <button id="btn-refresh" class="btn btn-primary">
                <i class="bi bi-arrow-clockwise"></i> Actualiser
            </button>
        </div>

        <!-- KPI Cards -->
        <div class="row mb-5">
            <div class="col-3"> <!-- Using col-3 from layout.css which is standard mostly but might need adjustment if I didn't define col-3 in my basic layout.css. Let's check layout.css. I defined col-4, col-8, col-12. I should probably stick to col-4 or add col-3. I'll use col-4 with wrap or just flex. Let's assume standard grid utility or use flex. I'll use simple flex grid here for safety or update layout.css. I'll trust standard layout usage but since I wrote layout.css minimally, let's use style="flex: 1" approach for safety or row with col-4. 4 columns fits 12 grid if I have 3 cols, but I have 4 KPIs. 12/4 = 3. I didn't define col-3. I'll stick to 2 rows of 2 or define grid style inline for this page or use flex-wrap. Let's use CSS Grid for dashboard-grid defined in main.css! It's responsive. -->
                <!-- dashboard-grid is auto-fit minmax 250px. Perfect. -->
            </div>
        </div>

        <div class="dashboard-grid">
            <div class="card stat-card" style="border-top: 4px solid var(--color-primary);">
                <div class="stat-label">Besoins Totaux</div>
                <div class="stat-value" id="total-besoins">- Ar</div>
                <i class="bi bi-cash-stack text-muted mt-2"></i>
            </div>

            <div class="card stat-card" style="border-top: 4px solid var(--color-success);">
                <div class="stat-label">Besoins Satisfaits</div>
                <div class="stat-value text-success" id="total-satisfaits">- Ar</div>
                <i class="bi bi-check-circle text-muted mt-2"></i>
            </div>

            <div class="card stat-card" style="border-top: 4px solid var(--color-info);">
                <div class="stat-label">Dons Reçus</div>
                <div class="stat-value text-info" id="total-dons-recus">- Ar</div>
                <i class="bi bi-piggy-bank text-muted mt-2"></i>
            </div>

            <div class="card stat-card" style="border-top: 4px solid var(--color-warning);">
                <div class="stat-label">Dispatchés</div>
                <div class="stat-value text-warning" id="total-dons-dispatches">- Ar</div>
                <i class="bi bi-box-seam text-muted mt-2"></i>
            </div>
        </div>

        <!-- Detailed List -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Détail par Ville</span>
                <span class="badge bg-info">En Ariary</span>
            </div>
            <div class="card-body">
                <?php if (empty($donnees)): ?>
                    <div class="text-center py-4">
                        <p class="text-muted">Aucune ville trouvée.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Ville</th>
                                    <th class="text-end">Besoins</th>
                                    <th class="text-end">Attribués</th>
                                    <th class="text-end">Reste à couvrir</th>
                                    <th class="text-end">Progression</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($donnees as $section):
                                    $percent = ($section['besoins_ariary'] > 0) ? round(($section['attributions_ariary'] / $section['besoins_ariary']) * 100) : 0;
                                ?>
                                    <tr>
                                        <td class="fw-bold">
                                            <i class="bi bi-geo-alt-fill text-primary me-2"></i>
                                            <?= htmlspecialchars($section['ville']['nom_ville']) ?>
                                        </td>
                                        <td class="text-end text-muted">
                                            <?= number_format($section['besoins_ariary'], 0, ',', ' ') ?> Ar
                                        </td>
                                        <td class="text-end text-success fw-bold">
                                            <?= number_format($section['attributions_ariary'], 0, ',', ' ') ?> Ar
                                        </td>
                                        <td class="text-end text-danger fw-bold">
                                            <?= number_format($section['reste_ariary'], 0, ',', ' ') ?> Ar
                                        </td>
                                        <td style="width: 20%; min-width: 150px;">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="progress">
                                                    <div class="progress-bar" style="width: <?= $percent ?>%"></div>
                                                </div>
                                                <span class="text-xs text-muted"><?= $percent ?>%</span>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
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
            fetchStats();
        });

        const btnRefresh = document.getElementById('btn-refresh');
        if (btnRefresh) {
            btnRefresh.addEventListener('click', function() {
                fetchStats();
            });
        }

        function fetchStats() {
            const btn = document.getElementById('btn-refresh');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> ...';
            btn.disabled = true;

            fetch('/api/recap')
                .then(response => response.json())
                .then(data => {
                    updateCard('total-besoins', data.total_besoins);
                    updateCard('total-satisfaits', data.total_satisfaits);
                    updateCard('total-dons-recus', data.total_dons_recus);
                    updateCard('total-dons-dispatches', data.total_dons_dispatches);
                })
                .catch(error => console.error('Error:', error))
                .finally(() => {
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                });
        }

        function updateCard(id, value) {
            const formatted = new Intl.NumberFormat('fr-FR').format(value);
            const el = document.getElementById(id);
            if (el) el.innerText = formatted + ' Ar';
        }
    </script>
</body>

</html>