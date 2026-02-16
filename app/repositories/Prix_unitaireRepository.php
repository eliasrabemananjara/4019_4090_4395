<?php
class Prix_unitaireRepository
{
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllPrixUnitaires()
    {
        $st = $this->pdo->query("SELECT pu.*, p.nom_produit FROM prix_unitaires pu LEFT JOIN produit p ON pu.idproduit = p.idproduit ORDER BY p.nom_produit");
        return $st->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getPrixUnitaireById($id)
    {
        $st = $this->pdo->prepare("SELECT pu.*, p.nom_produit FROM prix_unitaires pu LEFT JOIN produit p ON pu.idproduit = p.idproduit WHERE pu.idprix_unitaires = ? LIMIT 1");
        $st->execute([(int)$id]);
        return $st->fetch(\PDO::FETCH_ASSOC);
    }

    public function insertPrixUnitaire($idproduit, $valeur)
    {
        $st = $this->pdo->prepare("INSERT INTO prix_unitaires(idproduit, valeur) VALUES (?, ?)");
        $st->execute([(int)$idproduit, (int)$valeur]);
        return $this->pdo->lastInsertId();
    }

    public function updatePrixUnitaire($id, $idproduit, $valeur)
    {
        $st = $this->pdo->prepare("UPDATE prix_unitaires SET idproduit = ?, valeur = ? WHERE idprix_unitaires = ?");
        return $st->execute([(int)$idproduit, (int)$valeur, (int)$id]);
    }

    public function deletePrixUnitaire($id)
    {
        $st = $this->pdo->prepare("DELETE FROM prix_unitaires WHERE idprix_unitaires = ?");
        return $st->execute([(int)$id]);
    }
}
