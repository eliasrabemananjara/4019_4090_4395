<?php
class ReinitialiserRepository
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function reinitialiserDonnees()
    {
        $st = $this->pdo->prepare("DELETE FROM stock WHERE idstock = ?");
        $st->execute([(int)$id]);
    }
    }
