<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Récapitulatif par Ville</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <style>
        body { padding: 20px; font-family: Arial, sans-serif; background: #f5f5f5; }
        .container { max-width: 1100px; margin: 0 auto; }
        .card { padding: 20px; border-radius: 8px; background: #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
        table { width: 100%; }
        th { text-align: left; }
    </style>
</head>
<body>
    <div class="container">
        <div class="mb-3"><a href="/accueil">← Retour à l'accueil</a></div>
        <div class="card">
            <h2>Récapitulatif par ville (en Ariary)</h2>
            <?php if (empty($donnees)): ?>
                <p>Aucune ville trouvée.</p>
            <?php else: ?>
                <?php foreach ($donnees as $section): ?>
                    <div class="ville-section" style="margin-bottom:20px; padding:15px; border:1px solid #eee; border-radius:6px; background:#fafafa;">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                            <div style="font-weight:bold; font-size:18px;">📍 <?php echo htmlspecialchars($section['ville']['nom_ville']); ?></div>
                            <div>
                                <span style="margin-right:12px;">Besoins: <strong><?php echo number_format($section['besoins_ariary'],0,',',' '); ?> Ar</strong></span>
                                <span style="margin-right:12px;">Dons: <strong><?php echo number_format($section['attributions_ariary'],0,',',' '); ?> Ar</strong></span>
                                <span>Reste: <strong><?php echo number_format($section['reste_ariary'],0,',',' '); ?> Ar</strong></span>
                            </div>
                        </div>
                        <!-- Optionnel: on peut lister les détails des produits si besoin -->
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
