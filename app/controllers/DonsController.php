<?php

class DonsController
{
    public static function showInsert()
    {
        $pdo = Flight::db();
        $produitRepo = new ProduitRepository($pdo);
        $produits = $produitRepo->findAll();

        Flight::render('dons/insertDons', [
            'produits' => $produits,
            'success' => Flight::request()->query['success'] ?? null,
            'error' => Flight::request()->query['error'] ?? null
        ]);
    }

    public static function postInsert()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $req = Flight::request();
        $pdo = Flight::db();

        $idproduit = $req->data->idproduit;
        $quantite = $req->data->quantite;
        $iduser = $_SESSION['user_id'] ?? 1;

        if (!$idproduit || !$quantite || $quantite < 1) {
            Flight::redirect('/insertDons?error=Quantité invalide');
            return;
        }

        $donsRepo = new DonsRepository($pdo);
        $stockRepo = new StockRepository($pdo);

        // Insérer le don dans la table dons
        $donsRepo->create($iduser, $quantite, $idproduit);

        // Vérifier si le produit existe dans la table stock
        $stocks = $stockRepo->findByProduit($idproduit);

        if (count($stocks) > 0) {
            // Cas 1 : Produit déjà existant -> UPDATE
            // On prend la première ligne trouvée (supposant unicité ou mise à jour de la dernière entrée)
            $stock = $stocks[0];
            $currentQuantite = $stock['quantite'];
            $newQuantite = $currentQuantite + $quantite;

            $stockRepo->update($stock['idstock'], $idproduit, $newQuantite);
            $msg = "Don enregistré et stock mis à jour (ajouté)";
        } else {
            // Cas 2 : Produit non existant -> INSERT
            $stockRepo->create($idproduit, $quantite);
            $msg = "Don enregistré et produit ajouté au stock";
        }

        Flight::redirect('/insertDons?success=' . urlencode($msg));
    }
}
