<?php
class PrixUnitaireRepository
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getLatestByProduit($idproduit)
    {
        try {
            $st = $this->pdo->prepare("SELECT valeur FROM prix_unitaires WHERE idproduit = ? ORDER BY idprix_unitaires DESC LIMIT 1");
            $st->execute([(int)$idproduit]);
            $row = $st->fetch(PDO::FETCH_ASSOC);
            if (!$row) {
                return 0;
            }
            return (int)$row['valeur'];
        } catch (\PDOException $e) {
            // Table missing or other SQL error — fail gracefully with 0
            return 0;
        }
    }
}
