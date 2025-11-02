\# 📦 Livrables du Projet - Escape Game Avignon



\## 📁 Structure des Fichiers à Rendre



\### 🔧 Code Source

\- \[x] `apache-php/src/` - Code source PHP complet

&nbsp; - `index.php` - API principale avec FlightPHP

&nbsp; - `composer.json` - Dépendances PHP

&nbsp; - `vendor/` - Bibliothèques (FlightPHP)

\- \[x] `frontend-starter/` - Kit de démarrage frontend

&nbsp; - `config.js` - Configuration du jeu

&nbsp; - `example-map.html` - Exemple de carte fonctionnelle

&nbsp; - `README.md` - Instructions frontend



\### 🗃️ Base de Données

\- \[x] `database-backup.sql` - Export complet PostgreSQL

\- \[x] Structure: 10 objets avec géolocalisation PostGIS

\- \[x] Données: Coordonnées réelles d'Avignon



\### 🗺️ Configuration GeoServer

\- \[x] Workspace: `avignon`

\- \[x] Store: Connexion PostgreSQL `avignon\_escape`

\- \[x] Layer: `objets` publiée en WMS

\- \[x] Style: Points colorés par type d'objet



\### 📚 Documentation

\- \[x] `README.md` - Guide d'installation et utilisation

\- \[x] `SOLUTIONS.md` - Solutions complètes des énigmes

\- \[x] `LIVRABLES.md` - Cette liste des livrables

\- \[x] Commentaires dans le code



\### 🐳 Environnement Docker

\- \[x] `docker-compose.yml` - Configuration des services

\- \[x] Ports: 1234 (API), 8080 (GeoServer), 5050 (pgAdmin)

\- \[x] Services: Apache/PHP, PostgreSQL, GeoServer, pgAdmin



\## 🎯 Éléments Fonctionnels Livrés



\### Backend (Complet)

\- \[x] \*\*API REST\*\* avec endpoints:

&nbsp; - `GET /api/objets` - Liste tous les objets

&nbsp; - `GET /api/objets/:id` - Détails d'un objet

\- \[x] \*\*Base de données\*\* avec 10 objets géolocalisés

\- \[x] \*\*5 types d'objets\*\* différents implémentés

\- \[x] \*\*Système de blocage\*\* entre objets

\- \[x] \*\*Service WMS\*\* via GeoServer



\### Frontend (Starter Kit)

\- \[x] \*\*Exemple de carte\*\* Leaflet fonctionnelle

\- \[x] \*\*Intégration API\*\* démontrée

\- \[x] \*\*Système d'inventaire\*\* basique

\- \[x] \*\*Base solide\*\* pour développement Vue.js



\## 🔗 URLs de Validation



\### Services Locaux

\- \*\*API Backend:\*\* http://localhost:1234/api/objets

\- \*\*GeoServer:\*\* http://localhost:8080/geoserver (admin/geoserver)

\- \*\*pgAdmin:\*\* http://localhost:5050 (admin@admin.com/admin)

\- \*\*Exemple Frontend:\*\* `frontend-starter/example-map.html`



\### Repository GitHub

\- \*\*URL:\*\* https://github.com/paraguassuu/webaz-docker-starter-kit

\- \*\*Branch:\*\* main

\- \*\*Dernier commit:\*\* \[Insérer hash du dernier commit]



\## 📊 Spécifications Techniques Respectées



\### Conformité PDF

\- ✅ PostgreSQL + PostGIS

\- ✅ API PHP avec FlightPHP

\- ✅ GeoServer avec WMS

\- ✅ Docker (Starter Kit fourni)

\- ✅ 4 types d'objets minimum (5 implémentés)

\- ✅ 10 objets au total

\- ✅ Documentation complète



\### Architecture

\- ✅ Séparation backend/frontend

\- ✅ API RESTful

\- ✅ Base de données relationnelle

\- ✅ Service cartographique WMS

\- ✅ Conteneurisation Docker



\## 👥 Répartition du Travail



\### J Mendes da Silveira  

\- Configuration environnement Docker

\- Base de données PostgreSQL/PostGIS

\- API PHP FlightPHP

\- Configuration GeoServer

\- Documentation backend



\### J Mendes da Silveira \& A Tebra 

\- Interface utilisateur Vue.js

\- Carte interactive Leaflet

\- Système d'inventaire avancé

\- Design et expérience utilisateur



\## 🚀 Instructions de Démarrage



```bash

\# 1. Cloner le repository

git clone https://github.com/paraguassuu/webaz-docker-starter-kit.git



\# 2. Démarrer les services

cd webaz-docker-starter-kit

docker-compose up -d



\# 3. Vérifier le fonctionnement

\# API: http://localhost:1234/api/objets

\# GeoServer: http://localhost:8080/geoserver

