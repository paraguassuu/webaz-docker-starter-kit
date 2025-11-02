<?php
header('Content-Type: application/json');

// Configurações do banco
$host = 'db';
$port = 5432;
$dbname = 'avignon_escape';
$user = 'postgres';
$pass = 'postgres';

// Rota: /api/objets
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['REQUEST_URI'] === '/api/objets') {
    try {
        $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $stmt = $pdo->query("SELECT id, nom, type, ST_AsGeoJSON(position) as position, zoom_min, icone_url FROM objets");
        $objets = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode($objets);
    } catch(PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
    exit;
}

// Rota: /api/objets/[id]
if ($_SERVER['REQUEST_METHOD'] === 'GET' && preg_match('#^/api/objets/(\d+)$#', $_SERVER['REQUEST_URI'], $matches)) {
    $id = $matches[1];
    
    try {
        $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $stmt = $pdo->prepare("SELECT * FROM objets WHERE id = ?");
        $stmt->execute([$id]);
        $objet = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($objet) {
            echo json_encode($objet);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Objet non trouvé']);
        }
    } catch(PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
    exit;
}

// Rota principal
echo "🎮 API Escape Game Avignon - Fonctionnelle! 🎮<br>";
echo "<a href='/api/objets'>Voir tous les objets</a><br>";
echo "<a href='/api/objets/1'>Voir objet 1</a>";
?>