<?php
class RecapitControleur
{
    public static function showRecap()
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            Flight::redirect('/login');
            return;
        }

        $pdo = Flight::db();

        $villeRepo = new VilleRepository($pdo);
        $besoinRepo = new BesoinRepository($pdo);
        $attributionRepo = new AttributionRepository($pdo);
        $prixRepo = new Prix_unitaireRepository($pdo);

        $villes = $villeRepo->findAll();

        $donnees = [];
        foreach ($villes as $ville) {
            $idville = $ville['idville'];

            $besoins = $besoinRepo->findByVille($idville);
            $attributions = $attributionRepo->findByVille($idville);

            // Calcul des besoins en ariary
            $total_besoins_ariary = 0;
            foreach ($besoins as $b) {
                if ($b['idproduit'] == 5) { // Argent
                    $total_besoins_ariary += (int)$b['quantite'];
                } else {
                    $prix = $prixRepo->getLatestByProduit($b['idproduit']);
                    $q = (int)($b['quantite'] ?? 0);
                    $total_besoins_ariary += $q * $prix;
                }
            }

            // Calcul des dons attribués en ariary
            $total_attributions_ariary = 0;
            foreach ($attributions as $a) {
                if ($a['idproduit'] == 5) { // Argent
                    $total_attributions_ariary += (int)$a['quantite'];
                } else {
                    $prix = $prixRepo->getLatestByProduit($a['idproduit']);
                    $q = (int)($a['quantite'] ?? 0);
                    $total_attributions_ariary += $q * $prix;
                }
            }

            $reste_ariary = max(0, $total_besoins_ariary - $total_attributions_ariary);

            $donnees[] = [
                'ville' => $ville,
                'besoins_ariary' => $total_besoins_ariary,
                'attributions_ariary' => $total_attributions_ariary,
                'reste_ariary' => $reste_ariary
            ];
        }

        Flight::render('auth/recapitulation', [
            'donnees' => $donnees
        ]);
    }

    public static function getGlobalStats()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            Flight::halt(403, 'Forbidden');
            return;
        }

        $pdo = Flight::db();
        $besoinRepo = new BesoinRepository($pdo);
        $attributionRepo = new AttributionRepository($pdo);
        $donsRepo = new DonsRepository($pdo);
        $prixRepo = new Prix_unitaireRepository($pdo);

        // 1. Calcul Global Besoins
        $total_besoins = 0;
        $allBesoins = $besoinRepo->findAll(); // Assuming findAll returns all needs
        foreach ($allBesoins as $b) {
            if ($b['idproduit'] == 5) {
                $total_besoins += (int)$b['quantite'];
            } else {
                $prix = $prixRepo->getLatestByProduit($b['idproduit']);
                $total_besoins += (int)$b['quantite'] * $prix;
            }
        }

        // 2. Calcul Global Attributions (Satisfaits / Dispatchés)
        $total_satisfaits = 0;
        $allAttributions = $attributionRepo->findAll();
        foreach ($allAttributions as $a) {
            if ($a['idproduit'] == 5) {
                $total_satisfaits += (int)$a['quantite'];
            } else {
                $prix = $prixRepo->getLatestByProduit($a['idproduit']);
                $total_satisfaits += (int)$a['quantite'] * $prix;
            }
        }

        // 3. Calcul Global Dons Reçus
        $total_dons_recus = 0;
        $donsTotals = $donsRepo->getAllTotals(); // [idproduit => total_qty]
        foreach ($donsTotals as $idproduit => $quantite) {
            if ($idproduit == 5) {
                $total_dons_recus += (int)$quantite;
            } else {
                $prix = $prixRepo->getLatestByProduit($idproduit);
                $total_dons_recus += (int)$quantite * $prix;
            }
        }

        Flight::json([
            'total_besoins' => $total_besoins,
            'total_satisfaits' => $total_satisfaits,
            'total_dons_recus' => $total_dons_recus,
            'total_dons_dispatches' => $total_satisfaits // Same as satisfaits in this context
        ]);
    }
}
