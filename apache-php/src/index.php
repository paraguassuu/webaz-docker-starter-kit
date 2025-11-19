<?php

declare(strict_types=1);
session_start();
require_once 'flight/Flight.php';

function getDatabaseConnection() {
    $db = null;
    try {
        $db = new PDO("pgsql:host=db;dbname=mydb", "postgres", "postgres");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo 'Erreur de connexion à la base de données : ' . $e->getMessage();
    }
    return $db;
}

Flight::route('/', function () {
    Flight::render('accueil');
});

Flight::route('/map', function () {
    Flight::render('map');
});


function createGeojson($queryResult)
{
    $features = [];
    foreach ($queryResult as $obj) {
        $features[] = [
            'type' => 'Feature',
            'geometry' => [
                'type' => 'Point',
                // Les coordonnées sont extraites des colonnes latitude/longitude de la table "points"
                'coordinates' => [(float)$obj['longitude'], (float)$obj['latitude']]
            ],
            'properties' => [
                // Propriétés de base de l'objet
                'id' => (int)$obj['id'],
                'name' => $obj['nom'],
                'description' => $obj['enigme'],
                'type' => $obj['objet_type'],
                'min_zoom_visible' => (int)$obj['min_zoom_visible'],
                'depart' => (bool)$obj['depart'],

                // Propriétés liées aux icônes (table "icones")
                'icon_url' => $obj['url'],
                'icon_size' => (float)$obj['taille'],
                'icon_anchor' => [(float)$obj['x'], (float)$obj['y']],

                // Propriétés pour la logique du jeu
                'code' => $obj['code_affiche'],
                'indice' => $obj['indice'],
                'requires_object_id' => $obj['objet_requis_id'] ? (int)$obj['objet_requis_id'] : null,
                'liberates_object_id' => $obj['objet_libere_id'] ? (int)$obj['objet_libere_id'] : null
            ]
        ];
    }
    return [
        'type' => 'FeatureCollection',
        'features' => $features
    ];
}

Flight::route('GET /api/objets', function () {
    $db = getDatabaseConnection();

    // La requête joint les 3 tables (objets, points et icones) pour récupérer toutes les informations nécessaires
    $query = "
        SELECT 
            o.id, o.nom, o.enigme, o.min_zoom_visible, o.depart, o.objet_type, 
            o.code_affiche, o.objet_requis_id, o.objet_libere_id, o.indice,
            p.latitude, p.longitude,
            i.url, i.taille, i.position[0] AS x, i.position[1] AS y
        FROM 
            objets o
        JOIN 
            points p ON o.point_id = p.id
        JOIN 
            icones i ON o.icone_id = i.id
        WHERE 
            o.depart = TRUE
    ";

    $stmt = $db->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Transformation des résultats en GeoJSON
    $geojson = createGeojson($result);
    Flight::json($geojson);
});

Flight::route('GET /api/objets/@id', function ($id) {
    $db = getDatabaseConnection();

    $query = "
        SELECT 
            o.id, o.nom, o.enigme, o.min_zoom_visible, o.depart, o.objet_type, 
            o.code_affiche, o.objet_requis_id, o.objet_libere_id, o.indice,
            p.latitude, p.longitude,
            i.url, i.taille, i.position[0] AS x, i.position[1] AS y
        FROM 
            objets o
        JOIN 
            points p ON o.point_id = p.id
        JOIN 
            icones i ON o.icone_id = i.id
        WHERE 
            o.id = :id
    ";

    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $geojson = createGeojson([$result]);
        Flight::json($geojson);
    } else {
        Flight::json(['error' => 'Désolé ! Cet objet n\'existe pas dans notre base de données.'], 404);
    }
});



Flight::route('POST /api/update-player-score', function() {
    $db = getDatabaseConnection();
    $data = Flight::request()->data;
    $pseudo = $data['pseudo'];
    $score = $data['score'];

    if (empty($pseudo) || !is_numeric($score)) {
        Flight::json(['error' => 'Le pseudo et le score sont requis.'], 400);
        return;
    }
    $score = (int)$score;

    try {
        $stmt_check = $db->prepare("SELECT score FROM players WHERE pseudo = :pseudo");
        $stmt_check->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
        $stmt_check->execute();
        $player = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if ($player) {
            // Le joueur existe : on met à jour uniquement si le nouveau score est meilleur
            if ($score > $player['score']) {
                $stmt_update = $db->prepare("UPDATE players SET score = :score WHERE pseudo = :pseudo");
                $stmt_update->bindParam(':score', $score, PDO::PARAM_INT);
                $stmt_update->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
                $stmt_update->execute();
                Flight::json(['status' => 'success', 'message' => 'Score mis à jour.']);
            } else {
                Flight::json(['status' => 'success', 'message' => 'Le score existant est meilleur.']);
            }
        } else {
            $stmt_insert = $db->prepare("INSERT INTO players (pseudo, score) VALUES (:pseudo, :score)");
            $stmt_insert->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
            $stmt_insert->bindParam(':score', $score, PDO::PARAM_INT);
            $stmt_insert->execute();
            Flight::json(['status' => 'success', 'message' => 'Joueur créé et score enregistré.'], 201);
        }
    } catch (PDOException $e) {
        Flight::json(['error' => 'Erreur de base de données : ' . $e->getMessage()], 500);
    }
});

Flight::route('GET /hall-of-fame', function () {
    $db = getDatabaseConnection();
    $query = "
        SELECT pseudo, score
        FROM players
        ORDER BY score DESC
        LIMIT 10
    ";

    try {
        $stmt = $db->prepare($query);
        $stmt->execute();
        $hallOfFame = $stmt->fetchAll(PDO::FETCH_ASSOC);
        Flight::render('hall_of_fame', ['hallOfFame' => $hallOfFame]);

    } catch (PDOException $e) {
        echo "Erreur : Impossible de récupérer le Hall of Fame.";

    }
});

Flight::start();

