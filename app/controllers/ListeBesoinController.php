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
        $stockRepo = new StockRepository($pdo);

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

                // Récupérer le stock actuel pour le produit
                $currentStock = $stockRepo->getCurrentStock($idproduit);
                $besoin['stock_disponible'] = $currentStock;

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
            'donnees' => $donnees,
            'success' => $_SESSION['success'] ?? null,
            'error' => $_SESSION['error'] ?? null
        ]);

        // Clean up session messages
        unset($_SESSION['success']);
        unset($_SESSION['error']);
    }

    public static function attribuer()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            Flight::redirect('/login');
            return;
        }

        $id_ville = Flight::request()->data->id_ville;
        $idproduit = Flight::request()->data->idproduit;
        $quantite = Flight::request()->data->quantite;

        if (empty($id_ville) || empty($idproduit) || empty($quantite) || $quantite <= 0) {
            $_SESSION['error'] = "Veuillez remplir correctement tous les champs.";
            Flight::redirect('/listesbesoins');
            return;
        }

        $pdo = Flight::db();
        $stockRepo = new StockRepository($pdo);
        $attributionRepo = new AttributionRepository($pdo);

        // Vérifier le stock
        $currentStock = $stockRepo->getCurrentStock($idproduit);

        if ($currentStock >= $quantite) {
            try {
                // Début de la transaction
                $pdo->beginTransaction();

                // 1. Décrémenter le stock (ajouter une ligne négative ou update selon implémentation, ici on utilise removeStock qui ajoute une ligne négative)
                // Mais attendez, StockRepository::removeStock ajoute une ligne avec quantité négative. 
                // Assurons-nous que c'est bien ce qu'on veut.
                $stockRepo->removeStock($idproduit, $quantite);

                // 2. Créer l'attribution
                $attributionRepo->create($quantite, $idproduit, $id_ville);

                $pdo->commit();
                $_SESSION['success'] = "Attribution de $quantite unités effectuée avec succès.";
            } catch (Exception $e) {
                $pdo->rollBack();
                $_SESSION['error'] = "Une erreur est survenue lors de l'attribution : " . $e->getMessage();
            }
        } else {
            $_SESSION['error'] = "Stock insuffisant. Disponible : $currentStock, Demandé : $quantite.";
        }

        Flight::redirect('/listesbesoins');
    }
}
