<?php
class BesoinRepository
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findById($id)
    {
        $st = $this->pdo->prepare("SELECT * FROM besoin WHERE idbesoin = ? LIMIT 1");
        $st->execute([(int)$id]);
        return $st->fetch(PDO::FETCH_ASSOC);
    }

    public function findAll()
    {
        $st = $this->pdo->query("SELECT b.*, p.nom_produit, v.nom_ville 
                             FROM besoin b 
                             LEFT JOIN produit p ON b.idproduit = p.idproduit 
                             LEFT JOIN ville v ON b.id_ville = v.idville 
                             ORDER BY b.created_at DESC");
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByVille($id_ville)
    {
        $st = $this->pdo->prepare("SELECT b.*, p.nom_produit 
                               FROM besoin b 
                               LEFT JOIN produit p ON b.idproduit = p.idproduit 
                               WHERE b.id_ville = ? 
                               ORDER BY b.created_at DESC");
        $st->execute([(int)$id_ville]);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByProduit($idproduit)
    {
        $st = $this->pdo->prepare("SELECT b.*, v.nom_ville 
                               FROM besoin b 
                               LEFT JOIN ville v ON b.id_ville = v.idville 
                               WHERE b.idproduit = ? 
                               ORDER BY b.created_at DESC");
        $st->execute([(int)$idproduit]);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($quantite, $idproduit, $id_ville)
    {
        $st = $this->pdo->prepare("INSERT INTO besoin(quantite, idproduit, id_ville) VALUES(?, ?, ?)");
        $st->execute([(int)$quantite, (int)$idproduit, (int)$id_ville]);
        return $this->pdo->lastInsertId();
    }

    public function update($id, $quantite, $idproduit, $id_ville)
    {
        $st = $this->pdo->prepare("UPDATE besoin SET quantite = ?, idproduit = ?, id_ville = ? WHERE idbesoin = ?");
        return $st->execute([(int)$quantite, (int)$idproduit, (int)$id_ville, (int)$id]);
    }

    public function delete($id)
    {
        $st = $this->pdo->prepare("DELETE FROM besoin WHERE idbesoin = ?");
        return $st->execute([(int)$id]);
    }

    public function getTotalByProduit($idproduit)
    {
        $st = $this->pdo->prepare("SELECT SUM(quantite) as total FROM besoin WHERE idproduit = ?");
        $st->execute([(int)$idproduit]);
        $result = $st->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }
}
