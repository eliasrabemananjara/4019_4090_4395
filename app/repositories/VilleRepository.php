<?php
class VilleRepository
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findById($id)
    {
        $st = $this->pdo->prepare("SELECT * FROM ville WHERE idville = ? LIMIT 1");
        $st->execute([(int)$id]);
        return $st->fetch(PDO::FETCH_ASSOC);
    }

    public function findAll()
    {
        $st = $this->pdo->query("SELECT v.*, r.nom_region FROM ville v 
                             LEFT JOIN region r ON v.idregion = r.idregion 
                             ORDER BY v.nom_ville");
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByRegion($idregion)
    {
        $st = $this->pdo->prepare("SELECT * FROM ville WHERE idregion = ? ORDER BY nom_ville");
        $st->execute([(int)$idregion]);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($nom_ville, $idregion)
    {
        $st = $this->pdo->prepare("INSERT INTO ville(nom_ville, idregion) VALUES(?, ?)");
        $st->execute([(string)$nom_ville, (int)$idregion]);
        return $this->pdo->lastInsertId();
    }

    public function update($id, $nom_ville, $idregion)
    {
        $st = $this->pdo->prepare("UPDATE ville SET nom_ville = ?, idregion = ? WHERE idville = ?");
        return $st->execute([(string)$nom_ville, (int)$idregion, (int)$id]);
    }

    public function delete($id)
    {
        $st = $this->pdo->prepare("DELETE FROM ville WHERE idville = ?");
        return $st->execute([(int)$id]);
    }
}
