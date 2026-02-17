<?php

class VenteRepository
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getProduitsAVendre()
    {
        $sql = "SELECT 
                    p.idproduit, 
                    p.nom_produit, 
                    t.nom_type_produit,
                    COALESCE(s.quantite, 0) as quantite_stock,
                    COALESCE(pu.valeur, 0) as prix_unitaire,
                    COALESCE(c.pourcentage, 0) as commission_pourcentage
                FROM produit p
                JOIN type_produit t ON p.idtype_produit = t.idtype_produit
                LEFT JOIN stock s ON p.idproduit = s.idproduit
                LEFT JOIN prix_unitaires pu ON p.idproduit = pu.idproduit
                LEFT JOIN comission c ON p.idproduit = c.idProduit
                WHERE t.nom_type_produit != 'Argent'";

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBesoinRestant($idProduit)
    {
        // besion_restant = SUM(besoin.quantite) - SUM(attribution.quantite)
        // filtered by besoin.idproduit = produit.idproduit

        $sqlBesoin = "SELECT SUM(quantite) as total_besoin FROM besoin WHERE idproduit = ?";
        $stmtBesoin = $this->pdo->prepare($sqlBesoin);
        $stmtBesoin->execute([(int)$idProduit]);
        $resBesoin = $stmtBesoin->fetch(PDO::FETCH_ASSOC);
        $totalBesoin = $resBesoin['total_besoin'] ?? 0;

        $sqlAttrib = "SELECT SUM(quantite) as total_admin_attrib FROM attribution WHERE idproduit = ?";
        $stmtAttrib = $this->pdo->prepare($sqlAttrib);
        $stmtAttrib->execute([(int)$idProduit]);
        $resAttrib = $stmtAttrib->fetch(PDO::FETCH_ASSOC);
        $totalAttrib = $resAttrib['total_admin_attrib'] ?? 0;

        $besoinRestant = $totalBesoin - $totalAttrib;

        return max(0, $besoinRestant);
    }

    public function getStockQuantite($idProduit)
    {
        $sql = "SELECT quantite FROM stock WHERE idproduit = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([(int)$idProduit]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res['quantite'] ?? 0;
    }

    public function getDetailsBesoinsNonCouverts($idProduit)
    {
        // Liste des villes avec besoins restants
        // besoin.quantite, attribution déjà faite, reste par ville

        $sql = "SELECT 
                    v.nom_ville,
                    b.quantite as besoin_initial,
                    COALESCE((SELECT SUM(a.quantite) FROM attribution a WHERE a.idproduit = b.idproduit AND a.id_ville = b.id_ville), 0) as attribution_faite
                 FROM besoin b
                 JOIN ville v ON b.id_ville = v.idville
                 WHERE b.idproduit = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([(int)$idProduit]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $results = [];
        foreach ($rows as $row) {
            $reste = $row['besoin_initial'] - $row['attribution_faite'];
            if ($reste > 0) {
                $row['reste'] = $reste;
                $results[] = $row;
            }
        }
        return $results;
    }

    public function getProduitDetails($idProduit)
    {
        $sql = "SELECT 
                    p.idproduit, 
                    p.nom_produit, 
                    pu.valeur, 
                    c.pourcentage
                FROM produit p
                LEFT JOIN prix_unitaires pu ON p.idproduit = pu.idproduit
                LEFT JOIN comission c ON p.idproduit = c.idProduit
                WHERE p.idproduit = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([(int)$idProduit]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function recordVente($idProduit, $quantite, $prixUnitaire)
    {
        $sql = "INSERT INTO vente (idProduit, quantite, prix_unitaire) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([(int)$idProduit, (int)$quantite, $prixUnitaire]);
        return $this->pdo->lastInsertId();
    }

    public function updateStock($idProduit, $quantiteChange)
    {
        // If quantiteChange is negative, it decreases stock (sale)
        // If positive, increases stock

        // However, the directive says:
        // stock.quantite = stock.quantite - quantité_a_vendre
        // And regarding 'Argent': stock.quantite += prix_vente * quantité_a_vendre

        // We need to be careful if the row exists in stock table.
        // Assuming every product has an entry in stock table (even if 0).

        // Verify if exists
        $check = "SELECT idstock FROM stock WHERE idproduit = ?";
        $stmt = $this->pdo->prepare($check);
        $stmt->execute([(int)$idProduit]);
        $exists = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($exists) {
            $sql = "UPDATE stock SET quantite = quantite + ? WHERE idproduit = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([(int)$quantiteChange, (int)$idProduit]);
        } else {
            // Should verify if we should insert. For now assuming update only if exists, 
            // but for 'Argent' it might need insertion if not exists.
            $sql = "INSERT INTO stock (idproduit, quantite) VALUES (?, ?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([(int)$idProduit, (int)$quantiteChange]);
        }
    }

    public function getProductArgent()
    {
        $sql = "SELECT idproduit FROM produit WHERE nom_produit = 'Argent'";
        $stmt = $this->pdo->query($sql);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res ? $res['idproduit'] : null;
    }
}
