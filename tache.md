# Taches du Projet

## Gestion des Besoins
- [x] Création du formulaire d'insertion des besoins (ville, produit, quantité)
- [x] Traitement de l'insertion des besoins en base de données
- [x] Affichage de la liste des besoins par ville (déjà fait, page liste_besoin)

## Gestion des Dons
- [x] Création de la page d'insertion des dons
    - [x] Formulaire avec : Produit (liste déroulante), Quantité
- [x] Traitement de l'insertion des dons
    - [x] Mise à jour de la table `stock` (Ajout de la quantité donnée au stock existant ou création d'une nouvelle ligne)
    - [x] Enregistrement dans la table `dons` (historique)

## Nouvelle Attribution des Dons (Intégrée à la liste des besoins)
> Ignorer l'ancienne logique d'attribution. Tout se fait depuis la liste des besoins.

- [x] Modification de la vue `liste_besoin.php` :
    - [x] Ajouter une colonne ou un formulaire pour chaque ligne de besoin (produit dans une ville).
    - [x] Champ : Input numérique "Quantité à attribuer".
    - [x] Bouton : "Attribuer".
- [x] Logique de Traitement (Backend/Controller) :
    - [x] Réception des données : `id_ville`, `id_produit`, `quantité_a_attribuer`.
    - [x] Vérification du Stock :
        - [x] Récupérer la quantité disponible dans la table `stock` pour ce produit.
        - [x] **Condition** :
            - Si `Stock >= Quantité à attribuer` :
                - [x] Insérer une ligne dans la table `attribution` (`id_ville`, `id_produit`, `quantité`).
                - [x] Décrémenter la quantité dans la table `stock`.
                - [x] Retourner un message de succès.
            - Si `Stock < Quantité à attribuer` :
                - [x] Ne rien insérer.
                - [x] Retourner un message d'erreur : "Stock insuffisant".

## Nettoyage
- [x] Suppression de l'ancienne page d'attribution et des routes associées.
