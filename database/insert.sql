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

INSERT INTO prix_unitaires (idproduit, valeur) VALUES 
(1, 1000),
(2, 500),
(3, 300),
(4, 100);

INSERT INTO comission (idProduit, pourcentage) VALUES 
(1, 10),
(2, 10),
(3, 10),
(4, 10);

INSERT INTO besoin (quantite, idproduit, id_ville) VALUES 
                                        (3000, 5, 1);
