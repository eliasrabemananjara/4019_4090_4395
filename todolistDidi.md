

creation de page recaputilatif qui affiche les :
    -faire l'affichage comme liste_besoins.php
    -les besoins totaux(en ariary) pour chaque ville:
        controleur:
            recapitControleur.php: 
                formule: quantite de besoin * prix unitaire + argent si il y a de l'argent dans la table besoin.
                boucler cette formule pour tous les produits et faire la somme total des besoins en ariary pour chaque ville
                afficher 
        view:
            recapitulatif.php: afficher les besoins totaux(en ariary) par  chaque ville
    -les dons attribués(en ariary) pour chaque ville
        controleur:
            recapitControleur.php: 
                formule: quantite de dons attribués * prix unitaire + argent si il y a de l'argent dans la table dons.
                boucler cette formule pour tous les produits et faire la somme total des dons attribués en ariary pour chaque ville
                afficher
        view:
            recapitulatif.php: ajouter une colonne pour afficher les dons attribués(en ariary) pour chaque ville
    -le reste(en ariary) pour chaque ville
             