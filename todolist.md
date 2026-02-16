-Creation de base de donnes
    -Creation de table 
        -Table users(iduser,email,created_at)
        -Table region(idregion,nom_region,created_at)
        -Table ville(idville,nom_ville,idregion,created_at)
        -Table type_produit(idtype_produit,nom_type_produit,created_at)
        -Table produit(idproduit,nom_produit,idtype_produit,created_at)
        -Table besoin(idbesoin,quantite, idproduit,created_at,id_ville)
        -Table dons(iddons,iduser, quantite, idproduit,created_at)
        -Table stock(idstock,idproduit,quantite,created_at)

-Creation page login
    -autologin

-Creation page d'accueil qui contient des liens pour
    -page pour inserer les besoins(formulaire)
        -liste deroulante pour afficher produits
        -liste deroulante pour afficher villes

    page pour inserer les dons(formulaire)
        -liste deroulante pour afficher produits
        -quantite
        -bouton envoyer

    page pour attribuer les dons
        -Affichage de stock avec bouton donner
            -Boutton -> page formulaire pour distribuer les dons
                -liste deroulante de ville
                -quantite
                -bouton envoyer

    page pour lister les besoins (tableau)
        -Ville
        -Besoins Total
        -Dons Attribués
        -Reste