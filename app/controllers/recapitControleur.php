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
        $prixRepo = new PrixUnitaireRepository($pdo);

        $villes = $villeRepo->findAll();

        $donnees = [];
        foreach ($villes as $ville) {
            $idville = $ville['idville'];

                $besoins = $besoinRepo->findByVille($idville);
                $attributions = $attributionRepo->findByVille($idville);

                // Calcul des besoins en ariary: pour chaque besoin => quantite * prix_unitaire + montant 'argent' si présent
                $total_besoins_ariary = 0;
                foreach ($besoins as $b) {
                    $prix = $prixRepo->getLatestByProduit($b['idproduit']);
                    $q = (int)($b['quantite'] ?? 0);
                    $montant_argent = 0;
                    if (isset($b['argent'])) {
                        $montant_argent = (int)$b['argent'];
                    }
                    $total_besoins_ariary += $q * $prix + $montant_argent;
                }

                // Calcul des dons attribués en ariary: quantite * prix_unitaire + montant 'argent' si présent
                $total_attributions_ariary = 0;
                foreach ($attributions as $a) {
                    $prix = $prixRepo->getLatestByProduit($a['idproduit']);
                    $q = (int)($a['quantite'] ?? 0);
                    $montant_argent = 0;
                    if (isset($a['argent'])) {
                        $montant_argent = (int)$a['argent'];
                    }
                    $total_attributions_ariary += $q * $prix + $montant_argent;
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
}
