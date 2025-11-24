Vue.createApp({
    data() {
        return {
            // ----- État de la carte & des objets -----
            map: null,
            allGameObjects: [],
            activeMarkers: {},

            // ----- État du joueur -----
            score: 0,
            inventoryItems: [],
            processedObjectIds: new Set(),

            // ----- État de l'interface (UI) -----
            showHeatmap: false,
            inventoryOpen: false,
            modalVisible: false,
            modalTitle: '',
            modalMessage: '',
            modalPoints: '',
            modalType: 'info',
            userInputCode: '',
            currentModalObject: null,
            correctCodeForModal: null,
            isGameOver: false,
            playerPseudo: '',
            nextAction: null,
            heatmapLayer: null
        };
    },
    mounted() {
        this.initializeMap();
        this.loadStartingObjects();
    },
    methods: {
        
        // INITIALISATION DE LA CARTE
        
        initializeMap() {
            this.map = L.map('map').setView([43.9510, 4.8075], 16);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(this.map);
            setTimeout(() => {
                this.map.invalidateSize();
            }, 50);
            this.map.on('zoomend', this.refreshMarkerVisibility);
            this.heatmapLayer = L.tileLayer.wms('http://localhost:8081/geoserver/wms', {
                layers: 'avignon_heatmap:avignon_points',
                format: 'image/png',
                opacity: 0,
                transparent: true,
                attribution: 'Données de carte &copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(this.map);
        },

        loadStartingObjects() {
            fetch('/api/objets')
                .then(response => {
                    if (!response.ok)
                    throw new Error('Erreur réseau');
                    return response.json();
                })
                .then(geojson => {
                    this.allGameObjects = geojson.features;
                    this.refreshMarkerVisibility();
                })
                .catch(error => {
                    console.error('Erreur lors du chargement des objets de départ:', error);
                    this.showNotification('Erreur', '', 'Impossible de charger le jeu. Veuillez réessayer.', 'error');
                });
        },

        
        // GESTION DES MARQUEURS
        
        refreshMarkerVisibility() {
            const currentZoom = this.map.getZoom();
            this.allGameObjects.forEach(feature => {
                const obj = feature.properties;
                if (this.processedObjectIds.has(obj.id) && obj.type === 'recuperable') return;
                const isOnMap = !!this.activeMarkers[obj.id];
                const shouldBeVisible = currentZoom >= obj.min_zoom_visible;
                if (shouldBeVisible && !isOnMap) this.addMarkerToMap(feature);
                else if (!shouldBeVisible && isOnMap) this.removeMarkerFromMap(obj.id);
            });
        },

        addMarkerToMap(feature) {
            const obj = feature.properties;
            if (this.activeMarkers[obj.id]) return;
            const marker = L.marker([feature.geometry.coordinates[1], feature.geometry.coordinates[0]], {
                icon: L.icon({
                    iconUrl: obj.icon_url || 'assets/images/icons/default.png',
                    iconSize: [obj.icon_size || 40, obj.icon_size || 40],
                    iconAnchor: obj.icon_anchor || [20, 40]
                })
            });
            marker.on('click', () => this.interactWithObject(obj));
            marker.addTo(this.map);
            this.activeMarkers[obj.id] = marker;
        },

        removeMarkerFromMap(objectId) {
            if (this.activeMarkers[objectId]) {
                this.map.removeLayer(this.activeMarkers[objectId]);
                delete this.activeMarkers[objectId];
            }
        },

        
        // LOGIQUE D'INTERACTION PRINCIPALE
        
        interactWithObject(obj) {
            if (this.isGameOver) return;
            switch (obj.type) {
                case 'recuperable': this.collectObject(obj); break;
                case 'code': this.displayCode(obj); break;
                case 'bloque_par_code': this.requestCode(obj); break;
                case 'bloque_par_objet': this.attemptUnlockWithObject(obj); break;
                case 'final': this.completeGame(obj); break;
            }
        },

        collectObject(obj) {
            if (this.processedObjectIds.has(obj.id)) return;
            this.inventoryItems.push(obj);
            this.score += 10;
            this.processedObjectIds.add(obj.id);
            this.removeMarkerFromMap(obj.id);
            this.showNotification(`${obj.name} récupéré !`, '+10 points', `${obj.description}. Cet objet a été ajouté à votre inventaire.`, 'success');
        },

        displayCode(obj) {
            if (this.processedObjectIds.has(obj.id)) {
                this.showNotification(obj.name, 'Code déjà découvert - Aucun point', `${obj.description}. <br><br>Code :  <strong>${obj.code}</strong>`, 'info');
                return;
            }
            this.score += 10;
            this.processedObjectIds.add(obj.id);
            this.showNotification(obj.name, '+10 points', `${obj.description}. <br><br>Code : <strong>${obj.code}</strong><br><br>`, 'codeDisplay');
        },

        requestCode(obj) {
            if (this.processedObjectIds.has(obj.id)) {
                this.showNotification(obj.name, 'Code déjà validé - Aucun point', `${obj.description}`, 'info');
                return;
            }
            this.currentModalObject = obj;
            this.fetchCodeItemInfo(obj.requires_object_id);
        },

        attemptUnlockWithObject(obj) {
            if (this.processedObjectIds.has(obj.id)) {
                this.showNotification(obj.name, 'Énigme déjà Résolue - Aucun point', `${obj.description}`, 'info');
                return;
            }
            const hasRequiredItem = this.inventoryItems.some(item => item.id === obj.requires_object_id);
            if (hasRequiredItem) {
                this.score += 15;
                this.processedObjectIds.add(obj.id);

                if (obj.liberates_object_id) {
                    this.nextAction = () => this.fetchAndDisplayUnlockedObject(obj.liberates_object_id);
                }

                this.showNotification(`${obj.name} déverrouillé !`, '+15 points', obj.description, 'success');

            } else {
                this.fetchBlockingItemInfo(obj.requires_object_id);
            }
        },

        validateCode() {
            if (this.userInputCode === this.correctCodeForModal) {
                const obj = this.currentModalObject;
                this.score += 15;
                this.processedObjectIds.add(obj.id);
                this.closeNotification();

                if (obj.liberates_object_id) {
                    this.nextAction = () => this.fetchAndDisplayUnlockedObject(obj.liberates_object_id);
                }

                this.showNotification('Code Valide ! Bravo 🎊🎉\'', '+15 points',"", 'success');
            } else {
                this.score = Math.max(0, this.score - 5);
                this.showNotification('Code Invalide', '-5 points', 'Mauvais code, essayez à nouveau !', 'error');
            }
        },

        
        // MÉTHODES DE FETCH
        
        fetchCodeItemInfo(codeProviderId) {
            fetch(`/api/objets/${codeProviderId}`)
                .then(response => response.json())
                .then(geojson => {
                    const codeProvider = geojson.features[0].properties;
                    this.correctCodeForModal = codeProvider.code;
                    this.userInputCode = '';
                    this.showNotification(`${this.currentModalObject.name}`, '', `💡 Indice du code secret : ${codeProvider.indice}`, 'codeInput');
                })
                .catch(err => console.error("Erreur fetchCodeItemInfo:", err));
        },

        fetchBlockingItemInfo(requiredObjectId) {
            fetch(`/api/objets/${requiredObjectId}`)
                .then(response => response.json())
                .then(geojson => {
                    const requiredObject = geojson.features[0].properties;
                    this.showNotification(`Objet Manquant`, '', `💡 Indice de l'objet manquant : ${requiredObject.indice}`, 'info');
                })
                .catch(err => console.error("Erreur fetchBlockingItemInfo:", err));
        },

        fetchAndDisplayUnlockedObject(objectId) {
            fetch(`/api/objets/${objectId}`)
                .then(response => response.json())
                .then(geojson => {
                    if (geojson.features && geojson.features.length > 0) {
                        const newFeature = geojson.features[0];
                        this.allGameObjects.push(newFeature);
                        this.refreshMarkerVisibility();
                        this.showNotification("Nouvel indice !", "", `Quelque chose est apparu sur la carte... Allez à sa recherche !`, "info");
                    }
                })
                .catch(error => console.error(`Erreur lors du chargement de l'objet ${objectId}:`, error));
        },

        
        // FIN DU JEU
        
        completeGame(obj) {
            this.score += 50;
            this.isGameOver = true;
            this.showNotification('🎉 Félicitations ! 🎉', `+50 points`, 'Vous avez brisé la malédiction d\'Avignon ! Entrez votre pseudo pour sauvegarder votre score.', 'endGame');
        },

        saveGameScore() {
            if (!this.playerPseudo.trim()) { alert('Veuillez entrer un pseudo !'); return; }
            const formData = new URLSearchParams();
            formData.append('pseudo', this.playerPseudo);
            formData.append('score', this.score);
            fetch('/api/update-player-score',
                {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: formData
                })
                .then(response => { if (!response.ok)
                    throw new Error('Erreur lors de la sauvegarde.'); return response.json(); })
                .then(() => {
                    this.showNotification('Score Sauvegardé !', '', 'Redirection vers le Hall of Fame...', 'success');
                    setTimeout(() => {
                        window.location.href = '/hall-of-fame';
                        }, 2000);
                })
                .catch(error => {
                    console.error('Erreur de sauvegarde:', error);
                    this.showNotification('Erreur', '', 'Impossible de sauvegarder le score.', 'error');
                });
        },

        // GESTION CARTE DE CHALEUR, NOTIFICATIONS ET INVENTAIRE

        toggleInventory() { this.inventoryOpen = !this.inventoryOpen; },

        toggleHeatmap() {
            if (this.showHeatmap) {
                this.heatmapLayer.setOpacity(1);
                this.score -= 35;
                this.showNotification('Aide cartographique activée 🗺️', '-35 points','L\'utilisation de la carte de chaleur vous coûte 35 points. ' +
                    'Cette assistance révèle les zones d\'intérêt mais diminue votre mérite. Persévérez sans artifice pour une gloire pure !', 'info');
            } else {
                this.heatmapLayer.setOpacity(0);
            }
        },

        showNotification(title, points, message, type) {
            this.modalTitle = title;
            this.modalPoints = points;
            this.modalMessage = message;
            this.modalType = type;
            this.modalVisible = true;
        },

        closeNotification() {
            this.modalVisible = false;
            if (typeof this.nextAction === 'function') {
                this.nextAction();
                this.nextAction = null;
            }
            this.userInputCode = '';
            this.currentModalObject = null;
            this.correctCodeForModal = null;
        }
    }
}).mount('#main');