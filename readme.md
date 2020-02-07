# BE PHP

Application de gestion de librairie en ligne avec LAMP  

URL : http://localhost/devweb/  

## Gestion des doublons dans la base de données

Au cours de ce TP nous avons remarqué dans la table `lignescmd` plusieurs lignes partageant les mêmes `idouvrage` et `idcmd`. On ne peut pas gérer l'ajout/la suppression de livres dans une commande en faisant seulement des insertions dans la table `lignescmd` sans se soucier des entrées déjà existantes, puisque celles-ci pouvaient générer des conflits de clé. Ainsi, à chaque insertion et chaque suppression on a fait une disjonction de cas afin de ne garder qu'une seule ligne par instance commande-ouvrage.

## Mémorisation du panier d'un client

On a considéré que le client pouvait valider ou supprimer sa commande à partir de la page "Mon Panier", et que la mémorisation en base de données de son panier (commande non validée) se fait automatiquement à chaque ajout.

Cela garantit également que le panier sera mémorisé dans la base de données même après que l'utilisateur soit déconnecté.

Nous avons considéré que le client ne peut avoir qu'une seule commande non validée (qu'on appelle le Panier).  
Nous n'avons pas implémenté de page pour que le client puisse voir ses commandes validées ( pas explicitement demandé ), le panier apparaitra donc vide après validation.   
On aurait pu le faire avec une requête SQL similaire à celle de la page commandes réservée aux libraires (avec un WHERE sur l'idpersonne en plus)  