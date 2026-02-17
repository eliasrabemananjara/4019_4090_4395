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
        // Désactiver les contraintes temporairement
        $this->pdo->query("SET FOREIGN_KEY_CHECKS = 0");

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
            'region',
            'users'
        ];

        foreach ($tables as $table) {
            $this->pdo->query("DELETE FROM $table");
            $this->pdo->query("ALTER TABLE $table AUTO_INCREMENT = 1");
        }

        $this->pdo->query("SET FOREIGN_KEY_CHECKS = 1");

        /* ==========================
           REGION
        ========================== */
        $this->pdo->query("INSERT INTO region (nom_region) VALUES
            ('Atsinanana'),
            ('Vatovavy'),
            ('Atsimo Atsinanana'),
            ('Diana'),
            ('Menabe')
        ");

        /* ==========================
           VILLE
        ========================== */
        $this->pdo->query("INSERT INTO ville (nom_ville, idregion) VALUES
            ('Toamasina', 1),
            ('Mananjary', 2),
            ('Farafangana', 3),
            ('Nosy Be', 4),
            ('Morondava', 5)
        ");

        /* ==========================
           TYPE PRODUIT
        ========================== */
        $this->pdo->query("INSERT INTO type_produit (nom_type_produit) VALUES
            ('nature'),
            ('materiel'),
            ('argent')
        ");

        /* ==========================
           PRODUIT
        ========================== */
        $this->pdo->query("INSERT INTO produit (nom_produit, idtype_produit) VALUES
            ('Riz (kg)', 1),
            ('Eau (L)', 1),
            ('Huile (L)', 1),
            ('Haricots', 1),
            ('Tôle', 2),
            ('Bâche', 2),
            ('Clous (kg)', 2),
            ('Bois', 2),
            ('groupe', 2),
            ('Argent', 3)
        ");

        /* ==========================
           PRIX UNITAIRES
        ========================== */
        $this->pdo->query("INSERT INTO prix_unitaires (idproduit, valeur) VALUES
            (1, 3000),
            (2, 1000),
            (3, 6000),
            (4, 4000),
            (5, 25000),
            (6, 15000),
            (7, 8000),
            (8, 10000),
            (9, 6750000),
            (10, 1)
        ");

        /* ==========================
           COMMISSION
        ========================== */
        $this->pdo->query("INSERT INTO comission (idProduit, pourcentage) VALUES
            (1, 10),
            (2, 10),
            (3, 10),
            (4, 10),
            (5, 10),
            (6, 10),
            (7, 10),
            (8, 10),
            (9, 10),
            (10, 10)
        ");

        /* ==========================
           USERS
        ========================== */
        $this->pdo->query("INSERT INTO users (email) VALUES
            ('donateur1@mail.com'),
            ('donateur2@mail.com')
        ");

        /* ==========================
           BESOIN
        ========================== */
        $this->pdo->query("INSERT INTO besoin (quantite, idproduit, created_at, id_ville) VALUES

            -- Toamasina
            (800, 1, '2026-02-16', 1),
            (1500, 2, '2026-02-15', 1),
            (120, 5, '2026-02-16', 1),
            (200, 6, '2026-02-15', 1),
            (12000000, 10, '2026-02-16', 1),
            (3, 9, '2026-02-15', 1),

            -- Mananjary
            (500, 1, '2026-02-15', 2),
            (120, 3, '2026-02-16', 2),
            (80, 5, '2026-02-15', 2),
            (60, 7, '2026-02-16', 2),
            (6000000, 10, '2026-02-15', 2),

            -- Farafangana
            (600, 1, '2026-02-16', 3),
            (1000, 2, '2026-02-15', 3),
            (150, 6, '2026-02-16', 3),
            (100, 8, '2026-02-15', 3),
            (8000000, 10, '2026-02-16', 3),

            -- Nosy Be
            (300, 1, '2026-02-15', 4),
            (200, 4, '2026-02-16', 4),
            (40, 5, '2026-02-15', 4),
            (30, 7, '2026-02-16', 4),
            (4000000, 10, '2026-02-15', 4),

            -- Morondava
            (700, 1, '2026-02-16', 5),
            (1200, 2, '2026-02-15', 5),
            (180, 6, '2026-02-16', 5),
            (150, 8, '2026-02-15', 5),
            (10000000, 10, '2026-02-16', 5)
        ");

        /* ==========================
           DONS
        ========================== */
        $this->pdo->query("INSERT INTO dons (iduser, quantite, idproduit, created_at) VALUES
            (1, 5000000, 10, '2026-02-16'),
            (1, 3000000, 10, '2026-02-16'),
            (2, 4000000, 10, '2026-02-17'),
            (2, 1500000, 10, '2026-02-17'),
            (1, 6000000, 10, '2026-02-17'),
            (1, 400, 1, '2026-02-16'),
            (2, 600, 2, '2026-02-16'),
            (1, 50, 5, '2026-02-17'),
            (2, 70, 6, '2026-02-17'),
            (1, 100, 4, '2026-02-17'),
            (2, 2000, 1, '2026-02-18'),
            (1, 300, 5, '2026-02-18'),
            (2, 5000, 2, '2026-02-18'),
            (1, 20000000, 10, '2026-02-19'),
            (2, 500, 6, '2026-02-19'),
            (1, 88, 4, '2026-02-17')
        ");

        /* ==========================
           STOCK (résumé manuel)
        ========================== */
        $this->pdo->query("INSERT INTO stock (idproduit, quantite, created_at) VALUES
            (10, 39500000, '2026-02-19'),
            (1, 2400, '2026-02-18'),
            (2, 5600, '2026-02-18'),
            (5, 350, '2026-02-18'),
            (6, 570, '2026-02-19'),
            (4, 188, '2026-02-17')
        ");
    }
}
