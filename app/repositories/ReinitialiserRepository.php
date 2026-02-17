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
        $tables = [
            'vente',
            'comission',
            'achat',
            'prix_unitaires',
            'attribution',
            'stock',
            'dons',
            'besoin',
            'produit',
            'type_produit',
            'ville',
            'region'
        ];
        foreach ($tables as $table) {
            $this->pdo->query("DELETE FROM $table");
            $this->pdo->query("ALTER TABLE $table AUTO_INCREMENT = 1");
        }

        $this->pdo->query("INSERT INTO region (nom_region) VALUES 
                        ('Analamanga'),
                        ('Vakinankaratra')");

        $this->pdo->query("INSERT INTO ville (nom_ville, idregion) VALUES 
                        ('Antananarivo', 1),
                        ('Manjakandriana', 1),
                        ('Antsirabe', 2),
                        ('Betafo', 2) ");

        $this->pdo->query("INSERT INTO type_produit (nom_type_produit) VALUES 
                        ('Nature'),
                        ('Materiaux'),
                        ('Argent') ");

        $this->pdo->query("INSERT INTO produit (nom_produit, idtype_produit) VALUES 
                                        ('Riz', 1),
                                        ('Huile', 1),
                                        ('Tole', 2),
                                        ('Clou', 2),
                                        ('Argent', 3) ");

        $this->pdo->query("INSERT INTO prix_unitaires (idproduit, valeur) VALUES 
                                        (1, 1000),
                                        (2, 500),
                                        (3, 300),
                                        (4, 100); "); 

        $this->pdo->query("INSERT INTO comission (idProduit, pourcentage) VALUES 
                                        (1, 10),
                                        (2, 10),
                                        (3, 10),
                                        (4, 10); ");

        $this->pdo->query("INSERT INTO besoin (quantite, idproduit, id_ville) VALUES 
                                        (3000, 5, 1); ");
    }
    }
