DROP DATABASE IF EXISTS 4019_4090_4395;
CREATE DATABASE IF NOT EXISTS 4019_4090_4395;
USE 4019_4090_4395;

CREATE TABLE users (
iduser INT PRIMARY KEY AUTO_INCREMENT,
email VARCHAR(255) NOT NULL,
created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
UNIQUE KEY uniq_users_email (email)
);

CREATE TABLE region (
    idregion INT PRIMARY KEY AUTO_INCREMENT,
    nom_region VARCHAR(255) NOT NULL
);

CREATE TABLE ville (
    idville INT PRIMARY KEY AUTO_INCREMENT,
    nom_ville VARCHAR(255) NOT NULL,
    idregion INT NOT NULL,
    FOREIGN KEY (idregion) REFERENCES region(idregion)
);

CREATE TABLE type_produit (
    idtype_produit INT PRIMARY KEY AUTO_INCREMENT,
    nom_type_produit VARCHAR(255) NOT NULL
);

CREATE TABLE produit (
    idproduit INT PRIMARY KEY AUTO_INCREMENT,
    nom_produit VARCHAR(255) NOT NULL,
    idtype_produit INT NOT NULL,
    FOREIGN KEY (idtype_produit) REFERENCES type_produit(idtype_produit)
);

CREATE TABLE besoin (
    idbesoin INT PRIMARY KEY AUTO_INCREMENT,
    quantite INT NOT NULL,
    idproduit INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    id_ville INT NOT NULL,
    FOREIGN KEY (idproduit) REFERENCES produit(idproduit),
    FOREIGN KEY (id_ville) REFERENCES ville(idville)
);

CREATE TABLE dons (
    iddons INT PRIMARY KEY AUTO_INCREMENT,
    iduser INT NOT NULL,
    quantite INT NOT NULL,
    idproduit INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (iduser) REFERENCES users(iduser),
    FOREIGN KEY (idproduit) REFERENCES produit(idproduit)
);

CREATE TABLE stock (
    idstock INT PRIMARY KEY AUTO_INCREMENT,
    idproduit INT NOT NULL,
    quantite INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (idproduit) REFERENCES produit(idproduit)
);

CREATE TABLE attribution (
    idattribution INT PRIMARY KEY AUTO_INCREMENT,
    quantite INT NOT NULL,
    idproduit INT NOT NULL,
    id_ville INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (idproduit) REFERENCES produit(idproduit),
    FOREIGN KEY (id_ville) REFERENCES ville(idville)
);

INSERT INTO region (nom_region) VALUES 
('Analamanga'),
('Vakinankaratra');

INSERT INTO ville (nom_ville, idregion) VALUES 
('Antananarivo', 1),
('Manjakandriana', 1),
('Antsirabe', 2),
('Betafo', 2);

INSERT INTO type_produit (nom_type_produit) VALUES 
('Nature'),
('Materiaux'),
('Argent');

INSERT INTO produit (nom_produit, idtype_produit) VALUES 
('Riz', 1),
('Huile', 1),
('Tole', 2),
('Clou', 2),
('Argent', 3);

CREATE TABLE prix_unitaires (
    idprix_unitaires INT PRIMARY KEY AUTO_INCREMENT,
    idproduit INT NOT NULL,
    valeur INT NOT NULL,
    FOREIGN KEY (idproduit) REFERENCES produit(idproduit)
);

INSERT INTO prix_unitaires (idproduit, valeur) VALUES 
(1, 1000),
(2, 500),
(3, 300),
(4, 100);

<<<<<<< HEAD
CREATE TABLE achat (
    idachat INT PRIMARY KEY AUTO_INCREMENT,
    montant INT NOT NULL,
    idproduit INT NOT NULL,
    idville INT NOT NULL,
    FOREIGN KEY (idproduit) REFERENCES produit(idproduit),
    FOREIGN KEY (idville) REFERENCES ville(idville)
);
=======
>>>>>>> e455dab106875e79a89f2a97ecca6bcb62e2b892
