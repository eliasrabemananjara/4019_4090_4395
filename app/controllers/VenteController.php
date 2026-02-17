<?php

require_once __DIR__ . '/../repositories/VenteRepository.php';
require_once __DIR__ . '/../repositories/ProduitRepository.php';

class VenteController
{
    public static function index()
    {
        $pdo = Flight::db();
        $venteRepo = new VenteRepository($pdo);

        $produits = $venteRepo->getProduitsAVendre();

        // Enrich products with calculated remaining needs
        foreach ($produits as &$produit) {
            $produit['besoin_restant'] = $venteRepo->getBesoinRestant($produit['idproduit']);
        }

        Flight::render('vente', ['produits' => $produits]);
    }

    public static function vendre()
    {
        $pdo = Flight::db();
        $venteRepo = new VenteRepository($pdo);

        $req = Flight::request();
        $data = $req->data;

        $idProduit = $data->idproduit;
        $quantiteAVendre = $data->quantite;

        if (!$idProduit || !$quantiteAVendre || $quantiteAVendre <= 0) {
            Flight::json(['success' => false, 'message' => 'Données invalides.']);
            return;
        }

        // 1. Get current stock
        $stockActuel = $venteRepo->getStockQuantite($idProduit);

        // 2. Check stock sufficiency
        if ($quantiteAVendre > $stockActuel) {
            Flight::json(['success' => false, 'message' => 'Stock insuffisant.']);
            return;
        }

        // 3. Check remaining needs
        $besoinRestant = $venteRepo->getBesoinRestant($idProduit);
        $stockRestant = $stockActuel - $quantiteAVendre;

        if ($stockRestant < $besoinRestant) {
            // Get details of unfulfilled needs
            $details = $venteRepo->getDetailsBesoinsNonCouverts($idProduit);

            // Format details for UI
            $detailsHtml = '<ul class="list-group list-group-flush">';
            foreach ($details as $detail) {
                $detailsHtml .= '<li class="list-group-item d-flex justify-content-between align-items-center">';
                $detailsHtml .= htmlspecialchars($detail['nom_ville']);
                $detailsHtml .= '<span class="badge bg-danger rounded-pill">' . $detail['reste'] . ' manquants</span>';
                $detailsHtml .= '</li>';
            }
            $detailsHtml .= '</ul>';

            Flight::json([
                'success' => false,
                'message' => 'Besoins des villes non couverts.',
                'details' => $detailsHtml
            ]);
            return;
        }

        // 4. Proceed with Sale
        $produitDetails = $venteRepo->getProduitDetails($idProduit);

        $valeur = $produitDetails['valeur'];
        $pourcentage = $produitDetails['pourcentage'];

        // Calculate sale price
        $prixVenteUnitaire = $valeur + ($valeur * $pourcentage / 100);
        $totalVente = $prixVenteUnitaire * $quantiteAVendre;

        // Insert into vente
        $venteRepo->recordVente($idProduit, $quantiteAVendre, $prixVenteUnitaire);

        // Update product stock (decrease)
        $venteRepo->updateStock($idProduit, -$quantiteAVendre);

        // Update 'Argent' stock (increase)
        $idArgent = $venteRepo->getProductArgent();
        if ($idArgent) {
            $venteRepo->updateStock($idArgent, $totalVente);
        }

        Flight::json([
            'success' => true,
            'message' => 'Vente effectuée avec succès.',
            'montant_total' => $totalVente
        ]);
    }

    public static function updateCommission()
    {
        $pdo = Flight::db();
        $venteRepo = new VenteRepository($pdo);

        $pourcentage = Flight::request()->data->pourcentage;

        if (!isset($pourcentage) || !is_numeric($pourcentage) || $pourcentage < 0) {
            Flight::json(['success' => false, 'message' => 'Pourcentage invalide.']);
            return;
        }

        $venteRepo->updateGlobalCommission($pourcentage);

        Flight::json([
            'success' => true,
            'message' => 'Commission mise à jour pour tous les produits.'
        ]);
    }
}
