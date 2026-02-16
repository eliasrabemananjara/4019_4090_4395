<?php
class TypeProduitRepository
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findById($id)
    {
        $st = $this->pdo->prepare("SELECT * FROM type_produit WHERE idtype_produit = ? LIMIT 1");
        $st->execute([(int)$id]);
        return $st->fetch(PDO::FETCH_ASSOC);
    }

    public function findAll()
    {
        $st = $this->pdo->query("SELECT * FROM type_produit ORDER BY nom_type_produit");
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($nom_type_produit)
    {
        $st = $this->pdo->prepare("INSERT INTO type_produit(nom_type_produit) VALUES(?)");
        $st->execute([(string)$nom_type_produit]);
        return $this->pdo->lastInsertId();
    }

    public function update($id, $nom_type_produit)
    {
        $st = $this->pdo->prepare("UPDATE type_produit SET nom_type_produit = ? WHERE idtype_produit = ?");
        return $st->execute([(string)$nom_type_produit, (int)$id]);
    }

    public function delete($id)
    {
        $st = $this->pdo->prepare("DELETE FROM type_produit WHERE idtype_produit = ?");
        return $st->execute([(int)$id]);
    }
}
