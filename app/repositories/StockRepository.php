<?php
class StockRepository
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findById($id)
    {
        $st = $this->pdo->prepare("SELECT * FROM stock WHERE idstock = ? LIMIT 1");
        $st->execute([(int)$id]);
        return $st->fetch(PDO::FETCH_ASSOC);
    }

    public function findAll()
    {
        $st = $this->pdo->query("SELECT s.*, p.nom_produit, t.nom_type_produit 
                             FROM stock s 
                             LEFT JOIN produit p ON s.idproduit = p.idproduit 
                             LEFT JOIN type_produit t ON p.idtype_produit = t.idtype_produit 
                             ORDER BY s.created_at DESC");
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByProduit($idproduit)
    {
        $st = $this->pdo->prepare("SELECT * FROM stock WHERE idproduit = ? ORDER BY created_at DESC");
        $st->execute([(int)$idproduit]);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCurrentStock($idproduit)
    {
        $st = $this->pdo->prepare("SELECT SUM(quantite) as total FROM stock WHERE idproduit = ?");
        $st->execute([(int)$idproduit]);
        $result = $st->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    public function create($idproduit, $quantite)
    {
        $st = $this->pdo->prepare("INSERT INTO stock(idproduit, quantite) VALUES(?, ?)");
        $st->execute([(int)$idproduit, (int)$quantite]);
        return $this->pdo->lastInsertId();
    }

    public function update($id, $idproduit, $quantite)
    {
        $st = $this->pdo->prepare("UPDATE stock SET idproduit = ?, quantite = ? WHERE idstock = ?");
        return $st->execute([(int)$idproduit, (int)$quantite, (int)$id]);
    }

    public function decreaseQuantite($quantite, $idproduit, $idstock)
    {
        $st = $this->pdo->prepare("UPDATE stock SET quantite = quantite - ? WHERE idproduit = ? AND idstock = ?");
        return $st->execute([(int)$quantite, (int)$idproduit, (int)$idstock]);
    }

    public function delete($id)
    {
        $st = $this->pdo->prepare("DELETE FROM stock WHERE idstock = ?");
        return $st->execute([(int)$id]);
    }

    public function addStock($idproduit, $quantite)
    {
        // Helper method to add stock quantity
        return $this->create($idproduit, $quantite);
    }

    public function removeStock($idproduit, $quantite)
    {
        // Helper method to remove stock quantity (negative value)
        return $this->create($idproduit, -$quantite);
    }

    public function getAllCurrentStocks()
    {
        $st = $this->pdo->query("SELECT p.idproduit, p.nom_produit, t.nom_type_produit, 
                             COALESCE(SUM(s.quantite), 0) as quantite_totale 
                             FROM produit p 
                             LEFT JOIN type_produit t ON p.idtype_produit = t.idtype_produit 
                             LEFT JOIN stock s ON p.idproduit = s.idproduit 
                             GROUP BY p.idproduit, p.nom_produit, t.nom_type_produit 
                             ORDER BY p.nom_produit");
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }
}
