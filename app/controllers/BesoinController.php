<?php

class BesoinController
{
    public static function showInsert()
    {
        $pdo = Flight::db();
        $produitRepo = new ProduitRepository($pdo);
        $villeRepo = new VilleRepository($pdo);

        $produits = $produitRepo->findAll();
        $villes = $villeRepo->findAll();

        Flight::render('besoins/insertBesoins', [
            'produits' => $produits,
            'villes' => $villes,
            'success' => Flight::request()->query['success'] ?? null,
            'error' => Flight::request()->query['error'] ?? null
        ]);
    }

    public static function postInsert()
    {
        $req = Flight::request();
        $pdo = Flight::db();

        $idproduit = $req->data->idproduit;
        $id_ville = $req->data->id_ville;
        $quantite = $req->data->quantite;

        if (!$idproduit || !$id_ville || !$quantite || $quantite < 1) {
            Flight::redirect('/insertBesoins?error=Veuillez remplir correctement tous les champs');
            return;
        }

        $besoinRepo = new BesoinRepository($pdo);

        // Vérifier si un besoin existe déjà pour ville_id et produit_id
        $existingBesoins = $besoinRepo->findByVille($id_ville);
        $foundBesoin = null;

        foreach ($existingBesoins as $b) {
            if ($b['idproduit'] == $idproduit) {
                $foundBesoin = $b;
                break;
            }
        }

        if ($foundBesoin) {
            // Cas 1 : Même ville + même produit -> UPDATE
            $newQuantite = $foundBesoin['quantite'] + $quantite;
            $besoinRepo->update($foundBesoin['idbesoin'], $newQuantite, $idproduit, $id_ville);
            $msg = "Besoin mis à jour (quantité ajoutée)";
        } else {
            // Cas 2 : Même ville + produit différent (ou inexistant) -> INSERT
            $besoinRepo->create($quantite, $idproduit, $id_ville);
            $msg = "Besoin ajouté avec succès";
        }

        Flight::redirect('/insertBesoins?success=' . urlencode($msg));
    }
}
