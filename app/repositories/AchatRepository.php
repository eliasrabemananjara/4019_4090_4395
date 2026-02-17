<?php
class AchatRepository
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findById($id)
    {
        $st = $this->pdo->prepare("SELECT * FROM achat WHERE idachat = ? LIMIT 1");
        $st->execute([(int)$id]);
        return $st->fetch(PDO::FETCH_ASSOC);
    }

    public function findAll()
    {
        $st = $this->pdo->query("SELECT a.*, p.nom_produit, v.nom_ville 
                             FROM achat a 
                             LEFT JOIN produit p ON a.idproduit = p.idproduit 
                             LEFT JOIN ville v ON a.idville = v.idville 
                             ORDER BY a.idachat DESC");
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByVille($idville)
    {
        $st = $this->pdo->prepare("SELECT a.*, p.nom_produit, v.nom_ville 
                               FROM achat a 
                               LEFT JOIN produit p ON a.idproduit = p.idproduit 
                               LEFT JOIN ville v ON a.idville = v.idville 
                               WHERE a.idville = ? 
                               ORDER BY a.idachat DESC");
        $st->execute([(int)$idville]);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByProduit($idproduit)
    {
        $st = $this->pdo->prepare("SELECT a.*, p.nom_produit, v.nom_ville 
                               FROM achat a 
                               LEFT JOIN produit p ON a.idproduit = p.idproduit 
                               LEFT JOIN ville v ON a.idville = v.idville 
                               WHERE a.idproduit = ? 
                               ORDER BY a.idachat DESC");
        $st->execute([(int)$idproduit]);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($montant, $idproduit, $idville)
    {
        $st = $this->pdo->prepare("INSERT INTO achat(montant, idproduit, idville) VALUES(?, ?, ?)");
        $st->execute([(int)$montant, (int)$idproduit, (int)$idville]);
        return $this->pdo->lastInsertId();
    }

    public function update($id, $montant, $idproduit, $idville)
    {
        $st = $this->pdo->prepare("UPDATE achat SET montant = ?, idproduit = ?, idville = ? WHERE idachat = ?");
        return $st->execute([(int)$montant, (int)$idproduit, (int)$idville, (int)$id]);
    }

    public function delete($id)
    {
        $st = $this->pdo->prepare("DELETE FROM achat WHERE idachat = ?");
        return $st->execute([(int)$id]);
    }

    public function getTotalByProduit($idproduit)
    {
        $st = $this->pdo->prepare("SELECT SUM(montant) as total FROM achat WHERE idproduit = ?");
        $st->execute([(int)$idproduit]);
        $result = $st->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    public function getTotalByVille($idville)
    {
        $st = $this->pdo->prepare("SELECT SUM(montant) as total FROM achat WHERE idville = ?");
        $st->execute([(int)$idville]);
        $result = $st->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    public function getTotalsGroupByVille()
    {
        $st = $this->pdo->query("SELECT v.nom_ville, SUM(a.montant) as total_achat 
                                 FROM achat a 
                                 JOIN ville v ON a.idville = v.idville 
                                 GROUP BY a.idville, v.nom_ville
                                 ORDER BY total_achat DESC");
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }
}
