# 🎮 Frontend Starter - Escape Game Avignon

## Fichiers inclus:
- `config.js` - Configurations du jeu et API
- `example-map.html` - Carte de base fonctionnelle

## Comment utiliser:
1. Ouvrez `example-map.html` dans le navigateur
2. La carte devrait afficher les objets de l'API
3. Utilisez `config.js` pour personnaliser les couleurs et comportements

## URLs importantes:
- API: http://localhost:1234/api/objets
- GeoServer: http://localhost:8080/geoserver

## Prochaines étapes:
- Implémenter le système d'inventaire
- Ajouter les interactions par type d'objet
- Styliser l'interface

## Types d'objets:
- `recuperable` → va dans l'inventaire
- `code` → affiche un code
- `bloque_code` → demande un code
- `bloque_objet` → demande un objet de l'inventaire
- `final` → fin du jeu

## Développé par:
- Backend: Jackson Mendes da Silveira
- Frontend: Jackson Mendes da Silveira & Ange-Christelle Tebra