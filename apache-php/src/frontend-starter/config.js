<!DOCTYPE html>
<html>
<head>
    <title>Escape Game Avignon - Mapa Básico</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #map { 
            height: 600px; 
            width: 100%;
            border: 2px solid #333;
            border-radius: 8px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎮 Escape Game Avignon - Test</h1>
        <div id="map"></div>
        <div id="info">
            <h3>Objetos carregados: <span id="object-count">0</span></h3>
            <div id="inventory"></div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="config.js"></script>
    <script>
        // Mapa básico
        const map = L.map('map').setView(GAME_CONFIG.MAP_CENTER, GAME_CONFIG.MAP_ZOOM);
        
        // Camada do OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        // Carregar objetos da API
        async function loadObjects() {
            try {
                const response = await fetch(`${GAME_CONFIG.API_BASE_URL}/objets`);
                const objects = await response.json();
                
                document.getElementById('object-count').textContent = objects.length;
                
                // Adicionar marcadores
                objects.forEach(obj => {
                    const coords = obj.position.coordinates;
                    const marker = L.marker([coords[1], coords[0]]).addTo(map);
                    
                    marker.bindPopup(`
                        <strong>${obj.nom}</strong><br>
                        Type: ${obj.type}<br>
                        ID: ${obj.id}
                    `);
                });
                
            } catch (error) {
                console.error('Erro ao carregar objetos:', error);
            }
        }

        loadObjects();
    </script>
</body>
</html>