# PROGRAMMATION  WEB - PROJET Escape Game Géographique 2025 – La Malédiction d'Avignon

Ce projet a été développé dans le cadre du cours de programmation web avancée à l'École Nationale des Sciences Géographiques. Il s'agit d'un jeu interactif d'Escape Game géographique, qui plonge les joueurs dans une quête mystérieuse à travers la ville de Avignon.
Le Projet web interactif est basé sur une carte, utilisant Leaflet, Vue.js, une API PHP et un environnement Docker complet (front-end, back-end, PostgreSQL/PostGIS et GeoServer).


##  Table des Matières

I. [Scénario du Jeu]
II. [Présentation du projet]
III.[Installation & Déploiement]
   

## I- Scénario du Jeu
Vous incarnez un historien passionné par les légendes ancestrales d'Avignon. Vos recherches vous ont mené sur la piste d'une ancienne malédiction papale, un sort jeté sur la ville il y a plusieurs siècles. Les anciens écrits racontent que cette malédiction ne peut être levée qu'en retrouvant la **Relique de Rédemption**, un artefact puissant caché par un cardinal énigmatique du nom d'Adalf.

La légende dit que l'emplacement de la relique est protégé par une série d'énigmes ingénieuses, disséminées à travers les lieux les plus emblématiques de la cité des Papes. Votre quête commence maintenant. Armé de votre sagacité, vous devez déchiffrer les indices, assembler les objets et percer les secrets d'Adalf pour sauver Avignon.


## II- Présentation du projet

Ce projet est un jeu web d’exploration géographique, dans lequel le joueur interagit avec une carte interactive pour récupérer des objets, 
résoudre des énigmes, entrer des codes et débloquer progressivement de nouveaux éléments jusqu’à atteindre l’objectif final.

Le jeu repose sur :

-Leaflet pour l’affichage cartographique

-Vue.js pour l’interface dynamique

-PHP / FlightPHP pour l'API serveur

-PostgreSQL + PostGIS pour stocker les objets du jeu

-GeoServer pour diffuser une couche WMS (carte de chaleur)

-Docker Compose pour orchestrer l’ensemble


 ## 1- Fonctionnalités du jeu

 ## a- Carte interactive

Affichage de la ville d’Avignon avec des marqueurs personnalisés

Les objets apparaissent selon un niveau de zoom minimum

Affichage optionnel d’une carte de chaleur WMS via GeoServer


## b- Objets & interactions

Chaque objet possède un type :

-recuperable (ramassable (+10 points))

-code  (un code est révélé)

-bloque_par_code (nécessite d’entrer un code)

-bloque_par_objet (nécessite de posséder un autre objet)

-final (déclenche la fin du jeu et la sauvegarde du score)


## c- Carte de chaleur (Mode Aide)

-Affiche les zones d’intérêt via GeoServer

-L'activation coûte –35 points


## d- Fin du jeu

-L’utilisateur entre son pseudo

-Le score est sauvegardé via /api/update-player-score

-Redirection vers le Hall of Fame


## 2- API disponible

## GET /api/objets

Retourne tous les objets à afficher au lancement.

## GET /api/objets/{id}

Retourne les informations d’un objet spécifique, basé sur son `id` (code, description, indice, position…).

## POST /api/update-player-score

Enregistre le score final du joueur et met  à jour le score du joueur dans la base de données



## III- Installation & Déploiement

Instructions pour le lancement du jeu

Prérequis:  Assurez-vous d'avoir **Docker Desktop** installé sur votre ordinateur 
   ### Commandes necessaires pour le lancement du jeu
Pour lancer le jeu avec docker, vous devrez exécuter cette commande dans le repertoire de base du projet : **docker compose up --build** et après taper **localhost:8989** dans notre navigateur.

Il peut arriver qu'il y ait des problèmes après une première éxécution ou des problèmes de port (car d'autres services écoutent déjà sur ce port). 
 - Problèmes de port
      - Pour régler ce problème, il faut changer le port d'écoute de votre machine hôte dans le fichier docker-compose.yml_ afin d'éviter les conflits de ports.
      - Rélancer le projet avec **docker compose up --build** pour reconstruire les images et lancer les differents conteneurs.
  - 
 - Problèmes de construction des images et conteneurs

    Pour régler ce problème, vous pouvez tout re-exécuter en suivant les étapes suivantes :
     - Supprimer tous les conteneurs arrêtés ou en cours d'exécution : **docker rm -f $(docker ps -aq)**
     - Supprimer toutes les images Docker : **docker rmi -f $(docker images -q)**
     - Supprimer tous les volumes : **docker volume rm $(docker volume ls -q)**
     - Supprimer tous les réseaux non utilisés (optionnel) : **docker network prune -f**
     - Reconstruire les images : **docker compose build --no-cache**
     - Lancer vos conteneurs : **docker compose up --force-recreate**.


