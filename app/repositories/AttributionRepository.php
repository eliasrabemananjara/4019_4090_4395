<?php
class AttributionRepository
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findById($id)
    {
        $st = $this->pdo->prepare("SELECT * FROM attribution WHERE idattribution = ? LIMIT 1");
        $st->execute([(int)$id]);
        return $st->fetch(PDO::FETCH_ASSOC);
    }

    public function findAll()
    {
        $st = $this->pdo->query("SELECT a.*, p.nom_produit, v.nom_ville, r.nom_region 
                             FROM attribution a 
                             LEFT JOIN produit p ON a.idproduit = p.idproduit 
                             LEFT JOIN ville v ON a.id_ville = v.idville 
                             LEFT JOIN region r ON v.idregion = r.idregion 
                             ORDER BY a.created_at DESC");
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByVille($id_ville)
    {
        $st = $this->pdo->prepare("SELECT a.*, p.nom_produit 
                               FROM attribution a 
                               LEFT JOIN produit p ON a.idproduit = p.idproduit 
                               WHERE a.id_ville = ? 
                               ORDER BY a.created_at DESC");
        $st->execute([(int)$id_ville]);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByProduit($idproduit)
    {
        $st = $this->pdo->prepare("SELECT a.*, v.nom_ville, r.nom_region 
                               FROM attribution a 
                               LEFT JOIN ville v ON a.id_ville = v.idville 
                               LEFT JOIN region r ON v.idregion = r.idregion 
                               WHERE a.idproduit = ? 
                               ORDER BY a.created_at DESC");
        $st->execute([(int)$idproduit]);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($quantite, $idproduit, $id_ville)
    {
        $st = $this->pdo->prepare("INSERT INTO attribution(quantite, idproduit, id_ville) VALUES(?, ?, ?)");
        $st->execute([(int)$quantite, (int)$idproduit, (int)$id_ville]);
        return $this->pdo->lastInsertId();
    }

    public function update($id, $quantite, $idproduit, $id_ville)
    {
        $st = $this->pdo->prepare("UPDATE attribution SET quantite = ?, idproduit = ?, id_ville = ? WHERE idattribution = ?");
        return $st->execute([(int)$quantite, (int)$idproduit, (int)$id_ville, (int)$id]);
    }

    public function delete($id)
    {
        $st = $this->pdo->prepare("DELETE FROM attribution WHERE idattribution = ?");
        return $st->execute([(int)$id]);
    }

    public function getTotalByProduit($idproduit)
    {
        $st = $this->pdo->prepare("SELECT SUM(quantite) as total FROM attribution WHERE idproduit = ?");
        $st->execute([(int)$idproduit]);
        $result = $st->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    public function getTotalByVille($id_ville)
    {
        $st = $this->pdo->prepare("SELECT SUM(quantite) as total FROM attribution WHERE id_ville = ?");
        $st->execute([(int)$id_ville]);
        $result = $st->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    public function getAttributionsByRegion($idregion)
    {
        $st = $this->pdo->prepare("SELECT a.*, p.nom_produit, v.nom_ville 
                               FROM attribution a 
                               LEFT JOIN produit p ON a.idproduit = p.idproduit 
                               LEFT JOIN ville v ON a.id_ville = v.idville 
                               WHERE v.idregion = ? 
                               ORDER BY a.created_at DESC");
        $st->execute([(int)$idregion]);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function removeAttribution($quantite, $idproduit, $id_ville)
    {
        return $this->create(-$quantite, $idproduit, $id_ville);
    }
}
