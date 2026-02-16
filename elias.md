 -page pour inserer les besoins(formulaire)
        -liste deroulante pour afficher produits
        -liste deroulante pour afficher villes
        -quantite
        -bouton envoyer qui insere dans le table besoins
    si le meme ville a deux besoins de meme produit, ils seront additioner, si le meme ville a deux besoins
        de produits differents, alors on creera une nouvel ligne pour ce nouveau besoin

    page pour inserer les dons(formulaire)
        -liste deroulante pour afficher les produits
        -quantite
        -bouton envoyer qui insere dans la table dons et stock
        si le produit est deja dans le stock, alors on ajoute la quantite, si non on creera une nouvel ligne

Pour le besoin (insertBesoins.php):
1. Page 1 : Ajouter un besoin (Formulaire)
Éléments du formulaire
    -Liste déroulante dynamique des produits (chargée depuis la base)
    -Liste déroulante dynamique des villes
    -Champ quantité (type number, min=1)
    -Bouton Envoyer permet d'insérer dans la table besoins
    -Message de confirmation / erreur

2. Logique métier (Règles importantes)
Cas 1 : Même ville + même produit

Vérifier si un besoin existe déjà pour :
    -ville_id
    -produit_id

Si OUI :
    -Ajouter la nouvelle quantité à l’ancienne
    -Faire un UPDATE
Si NON :
    -Créer une nouvelle ligne (INSERT)

Cas 2 : Même ville + produit différent
    -Créer une nouvelle ligne dans la table besoins

//////

Pour le dons(insertDons.php):
1. Page 2 : Ajouter un don (Formulaire)
Éléments du formulaire
    -Liste déroulante dynamique des produits
    -Champ quantité
    -Bouton Envoyer permet d'insérer dans la table dons et stock
    -Message de confirmation

2. Logique métier (Gestion du stock)
Cas 1 : Produit déjà existant dans le stock
    -Récupérer la quantité actuelle
    -Ajouter la nouvelle quantité
    -Faire un UPDATE stock
Cas 2 : Produit non existant dans le stock
    -Créer une nouvelle ligne dans stock
    -Insérer la quantité donnée

Processus lors de l’envoi du formulaire
    -Insérer le don dans la table dons
    -Vérifier si le produit existe dans la table stock
    -UPDATE ou INSERT selon le cas
C'est a dire que le don est toujours inserer, pas d'update

Creer les controllers et les vues necessaires et ne met pas encore des styles long, juste les styles necessaires pour l'affichages.
utilise les models necessaires deja creer dans le repositories

DROP DATABASE IF EXISTS 4019_4090_4395;