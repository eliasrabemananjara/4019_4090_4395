<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Besoins</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f5f5f5;
            padding: 20px;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 8px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header h1 {
            margin: 0;
            font-size: 32px;
            font-weight: bold;
        }

        .header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
        }

        .ville-section {
            background: white;
            border-radius: 8px;
            margin-bottom: 25px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .ville-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .ville-name {
            font-size: 22px;
            font-weight: bold;
        }

        .ville-stats {
            display: flex;
            gap: 20px;
            font-size: 14px;
        }

        .stat {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .stat-badge {
            background: rgba(255, 255, 255, 0.3);
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: bold;
        }

        .besoins-list {
            padding: 0;
        }

        .besoin-item {
            padding: 20px;
            border-bottom: 1px solid #eee;
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr 1fr 1fr 2fr;
            gap: 15px;
            align-items: center;
        }

        .besoin-item:last-child {
            border-bottom: none;
        }

        .besoin-item:hover {
            background-color: #f9f9f9;
        }

        .besoin-produit {
            font-weight: bold;
            color: #333;
            font-size: 16px;
        }

        .besoin-quantity {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .quantity-label {
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
            font-weight: bold;
        }

        .quantity-value {
            font-size: 18px;
            font-weight: bold;
            color: #667eea;
        }

        .attribuee {
            color: #28a745;
        }

        .reste {
            color: #dc3545;
        }

        .stock {
            color: #17a2b8;
        }

        .empty-message {
            padding: 30px;
            text-align: center;
            color: #999;
            font-style: italic;
        }

        .progress-section {
            padding: 20px;
            background: #f8f9fa;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px;
            border-top: 1px solid #eee;
        }

        .progress-item {
            text-align: center;
        }

        .progress-label {
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .progress-value {
            font-size: 24px;
            font-weight: bold;
            color: #667eea;
        }

        .progress-bar-container {
            background: #e9ecef;
            border-radius: 20px;
            height: 8px;
            overflow: hidden;
            margin-top: 10px;
        }

        .progress-bar-fill {
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            height: 100%;
            border-radius: 20px;
        }

        .back-link {
            margin-bottom: 20px;
        }

        .back-link a {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #667eea;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .back-link a:hover {
            color: #764ba2;
            gap: 12px;
        }

        .besoin-grid-header {
            padding: 15px 20px;
            background: #f8f9fa;
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr 1fr 1fr 2fr;
            gap: 15px;
            font-weight: bold;
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
            border-bottom: 2px solid #e9ecef;
        }

        @media (max-width: 992px) {

            .besoin-item,
            .besoin-grid-header {
                grid-template-columns: 1fr 1fr;
            }

            .progress-section {
                grid-template-columns: 1fr;
            }

            .ville-stats {
                flex-direction: column;
                gap: 10px;
            }
        }

        @media (max-width: 576px) {

            .besoin-item,
            .besoin-grid-header {
                grid-template-columns: 1fr;
            }

            .ville-header {
                flex-direction: column;
                gap: 15px;
            }

            .header h1 {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="back-link">
            <a href="/accueil">← Retour à l'accueil</a>
        </div>

        <div class="header">
            <h1>📋 Liste des Besoins par Ville</h1>
            <p>Vue d'ensemble des besoins, attributions et stock disponible</p>
        </div>

        <?php if (!empty($success)): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <?php if (empty($donnees)): ?>
            <div class="ville-section">
                <div class="empty-message">
                    Aucune ville disponible pour le moment.
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($donnees as $section): ?>
                <div class="ville-section">
                    <div class="ville-header">
                        <div class="ville-name">
                            📍 <?php echo htmlspecialchars($section['ville']['nom_ville']); ?>
                        </div>
                        <div class="ville-stats">
                            <div class="stat">
                                <span>Demandé:</span>
                                <span class="stat-badge"><?php echo $section['total_demande']; ?> unités</span>
                            </div>
                            <div class="stat">
                                <span>Attribué:</span>
                                <span class="stat-badge"><?php echo $section['total_attribue']; ?> unités</span>
                            </div>
                        </div>
                    </div>

                    <?php if (empty($section['besoins'])): ?>
                        <div class="empty-message">
                            Aucun besoin enregistré pour cette ville.
                        </div>
                    <?php else: ?>
                        <div class="besoins-list">
                            <div class="besoin-grid-header">
                                <div>Produit</div>
                                <div>Stock Dispo</div>
                                <div>Demandée</div>
                                <div>Attribuée</div>
                                <div>Reste</div>
                                <div>Attribution</div>
                            </div>

                            <?php foreach ($section['besoins'] as $besoin): ?>
                                <div class="besoin-item">
                                    <div class="besoin-produit">
                                        🔹 <?php echo htmlspecialchars($besoin['nom_produit']); ?>
                                    </div>

                                    <div class="besoin-quantity">
                                        <span class="quantity-label">Stock</span>
                                        <span class="quantity-value stock"><?php echo $besoin['stock_disponible']; ?></span>
                                    </div>

                                    <div class="besoin-quantity">
                                        <span class="quantity-label">Demandée</span>
                                        <span class="quantity-value"><?php echo $besoin['quantite']; ?></span>
                                    </div>

                                    <div class="besoin-quantity">
                                        <span class="quantity-label">Attribuée</span>
                                        <span class="quantity-value attribuee"><?php echo $besoin['quantite_attribuee']; ?></span>
                                    </div>

                                    <div class="besoin-quantity">
                                        <span class="quantity-label">Reste</span>
                                        <span class="quantity-value reste"><?php echo $besoin['reste']; ?></span>
                                    </div>

                                    <div class="besoin-action">
                                        <?php if ($besoin['reste'] <= 0): ?>
                                            <span class="badge bg-success">Complet</span>
                                        <?php elseif ($besoin['stock_disponible'] <= 0): ?>
                                            <span class="badge bg-danger">Rupture de stock</span>
                                        <?php else: ?>
                                            <form action="/attribuer" method="POST" class="d-flex gap-2">
                                                <input type="hidden" name="id_ville" value="<?php echo $section['ville']['idville']; ?>">
                                                <input type="hidden" name="idproduit" value="<?php echo $besoin['idproduit']; ?>">
                                                <input type="number" name="quantite" class="form-control form-control-sm" placeholder="Qté" min="1" max="<?php echo min($besoin['reste'], $besoin['stock_disponible']); ?>" style="width: 80px;" required>
                                                <button type="submit" class="btn btn-sm btn-primary">Attribuer</button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>


                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>

</html>