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

CREATE TABLE prix_unitaires (
    idprix_unitaires INT PRIMARY KEY AUTO_INCREMENT,
    idproduit INT NOT NULL,
    valeur INT NOT NULL,
    FOREIGN KEY (idproduit) REFERENCES produit(idproduit)
);

CREATE TABLE achat (
    idachat INT PRIMARY KEY AUTO_INCREMENT,
    montant INT NOT NULL,
    idproduit INT NOT NULL,
    idville INT NOT NULL,
    FOREIGN KEY (idproduit) REFERENCES produit(idproduit),
    FOREIGN KEY (idville) REFERENCES ville(idville)
);

CREATE OR REPLACE TABLE comission (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idProduit INT NOT NULL,
    pourcentage DECIMAL(10, 2) NOT NULL,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (idProduit) REFERENCES produit(idproduit)
);

CREATE OR REPLACE TABLE vente (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idProduit INT NOT NULL,
    quantite INT NOT NULL,
    prix_unitaire DECIMAL(10, 2) NOT NULL,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (idProduit) REFERENCES produit(idproduit)
);
