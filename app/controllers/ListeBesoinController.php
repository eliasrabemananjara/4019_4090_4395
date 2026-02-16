<?php
class ListeBesoinController
{

    public static function listeBesoin()
    {
        session_start();

        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            Flight::redirect('/login');
            return;
        }

        $pdo = Flight::db();

        // Instancier les repositories
        $villeRepo = new VilleRepository($pdo);
        $besoinRepo = new BesoinRepository($pdo);
        $attributionRepo = new AttributionRepository($pdo);

        // Récupérer toutes les villes
        $villes = $villeRepo->findAll();

        // Organiser les données par ville avec les besoins et attributions
        $donnees = [];
        foreach ($villes as $ville) {
            $idville = $ville['idville'];

            // Récupérer les besoins pour cette ville
            $besoins = $besoinRepo->findByVille($idville);

            // Récupérer les attributions pour cette ville
            $attributions = $attributionRepo->findByVille($idville);

            // Créer un index pour les attributions par produit
            $attributionsByProduit = [];
            foreach ($attributions as $attribution) {
                $idproduit = $attribution['idproduit'];
                if (!isset($attributionsByProduit[$idproduit])) {
                    $attributionsByProduit[$idproduit] = 0;
                }
                $attributionsByProduit[$idproduit] += $attribution['quantite'];
            }

            // Ajouter les calculs de reste pour chaque besoin
            $besoinsAvecReste = [];
            foreach ($besoins as $besoin) {
                $idproduit = $besoin['idproduit'];
                $quantiteDemandee = $besoin['quantite'];
                $quantiteAttribuee = $attributionsByProduit[$idproduit] ?? 0;
                $reste = $quantiteDemandee - $quantiteAttribuee;

                $besoin['quantite_attribuee'] = $quantiteAttribuee;
                $besoin['reste'] = max(0, $reste); // Eviter les nombres négatifs

                $besoinsAvecReste[] = $besoin;
            }

            $donnees[] = [
                'ville' => $ville,
                'besoins' => $besoinsAvecReste,
                'total_demande' => array_sum(array_column($besoins, 'quantite')),
                'total_attribue' => array_sum($attributionsByProduit)
            ];
        }

        // Afficher la vue avec les données
        Flight::render('auth/liste_besoin', [
            'donnees' => $donnees
        ]);
    }
}
?>