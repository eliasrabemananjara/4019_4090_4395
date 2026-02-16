<?php
class RegionRepository
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findById($id)
    {
        $st = $this->pdo->prepare("SELECT * FROM region WHERE idregion = ? LIMIT 1");
        $st->execute([(int)$id]);
        return $st->fetch(PDO::FETCH_ASSOC);
    }

    public function findAll()
    {
        $st = $this->pdo->query("SELECT * FROM region ORDER BY nom_region");
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($nom_region)
    {
        $st = $this->pdo->prepare("INSERT INTO region(nom_region) VALUES(?)");
        $st->execute([(string)$nom_region]);
        return $this->pdo->lastInsertId();
    }

    public function update($id, $nom_region)
    {
        $st = $this->pdo->prepare("UPDATE region SET nom_region = ? WHERE idregion = ?");
        return $st->execute([(string)$nom_region, (int)$id]);
    }

    public function delete($id)
    {
        $st = $this->pdo->prepare("DELETE FROM region WHERE idregion = ?");
        return $st->execute([(int)$id]);
    }
}
