<?php
class DonsRepository
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findById($id)
    {
        $st = $this->pdo->prepare("SELECT * FROM dons WHERE iddons = ? LIMIT 1");
        $st->execute([(int)$id]);
        return $st->fetch(PDO::FETCH_ASSOC);
    }

    public function findAll()
    {
        $st = $this->pdo->query("SELECT d.*, p.nom_produit, u.email as user_email 
                             FROM dons d 
                             LEFT JOIN produit p ON d.idproduit = p.idproduit 
                             LEFT JOIN users u ON d.iduser = u.iduser 
                             ORDER BY d.created_at DESC");
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByUser($iduser)
    {
        $st = $this->pdo->prepare("SELECT d.*, p.nom_produit 
                               FROM dons d 
                               LEFT JOIN produit p ON d.idproduit = p.idproduit 
                               WHERE d.iduser = ? 
                               ORDER BY d.created_at DESC");
        $st->execute([(int)$iduser]);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByProduit($idproduit)
    {
        $st = $this->pdo->prepare("SELECT d.*, u.email as user_email 
                               FROM dons d 
                               LEFT JOIN users u ON d.iduser = u.iduser 
                               WHERE d.idproduit = ? 
                               ORDER BY d.created_at DESC");
        $st->execute([(int)$idproduit]);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($iduser, $quantite, $idproduit)
    {
        $st = $this->pdo->prepare("INSERT INTO dons(iduser, quantite, idproduit) VALUES(?, ?, ?)");
        $st->execute([(int)$iduser, (int)$quantite, (int)$idproduit]);
        return $this->pdo->lastInsertId();
    }

    public function update($id, $iduser, $quantite, $idproduit)
    {
        $st = $this->pdo->prepare("UPDATE dons SET iduser = ?, quantite = ?, idproduit = ? WHERE iddons = ?");
        return $st->execute([(int)$iduser, (int)$quantite, (int)$idproduit, (int)$id]);
    }

    public function delete($id)
    {
        $st = $this->pdo->prepare("DELETE FROM dons WHERE iddons = ?");
        return $st->execute([(int)$id]);
    }

    public function getTotalByProduit($idproduit)
    {
        $st = $this->pdo->prepare("SELECT SUM(quantite) as total FROM dons WHERE idproduit = ?");
        $st->execute([(int)$idproduit]);
        $result = $st->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    public function getTotalByUser($iduser)
    {
        $st = $this->pdo->prepare("SELECT SUM(quantite) as total FROM dons WHERE iduser = ?");
        $st->execute([(int)$iduser]);
        $result = $st->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }
}
