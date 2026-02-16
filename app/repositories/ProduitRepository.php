<?php
class ProduitRepository
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findById($id)
    {
        $st = $this->pdo->prepare("SELECT * FROM produit WHERE idproduit = ? LIMIT 1");
        $st->execute([(int)$id]);
        return $st->fetch(PDO::FETCH_ASSOC);
    }

    public function findAll()
    {
        $st = $this->pdo->query("SELECT p.*, t.nom_type_produit FROM produit p 
                             LEFT JOIN type_produit t ON p.idtype_produit = t.idtype_produit 
                             ORDER BY p.nom_produit");
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByType($idtype_produit)
    {
        $st = $this->pdo->prepare("SELECT * FROM produit WHERE idtype_produit = ? ORDER BY nom_produit");
        $st->execute([(int)$idtype_produit]);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($nom_produit, $idtype_produit)
    {
        $st = $this->pdo->prepare("INSERT INTO produit(nom_produit, idtype_produit) VALUES(?, ?)");
        $st->execute([(string)$nom_produit, (int)$idtype_produit]);
        return $this->pdo->lastInsertId();
    }

    public function update($id, $nom_produit, $idtype_produit)
    {
        $st = $this->pdo->prepare("UPDATE produit SET nom_produit = ?, idtype_produit = ? WHERE idproduit = ?");
        return $st->execute([(string)$nom_produit, (int)$idtype_produit, (int)$id]);
    }

    public function delete($id)
    {
        $st = $this->pdo->prepare("DELETE FROM produit WHERE idproduit = ?");
        return $st->execute([(int)$id]);
    }
}
