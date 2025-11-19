<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/images/favicon_io/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/images/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon_io/favicon-16x16.png">

    <title>Aventure | Le Secret Maudit d'Avignon</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=MedievalSharp&family=Work+Sans:wght@400;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../assets/styles/map.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
          crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
            crossorigin=""></script>

    <style>[v-cloak] { display: none; }</style>
</head>
<body>
<div id="main" v-cloak>
    <header class="navbar navbar-dark">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">🎭 Le Secret Maudit</span>
            <div class="d-flex align-items-center gap-2">
                <span class="score-badge">
                    <i class="fas fa-star me-1"></i> Score: {{ score }}
                </span>
                <div class="form-check form-switch ms-2 me-2">
                    <input class="form-check-input heatmap-switch" type="checkbox" v-model="showHeatmap"
                           @change="toggleHeatmap" title="Mode Triche">
                </div>
                <button @click="toggleInventory" class="btn btn-theme-secondary btn-sm">
                    <i class="fas fa-backpack me-1"></i> Inventaire ({{ inventoryItems.length }})
                </button>
                <a href="/" class="btn btn-theme-secondary btn-sm">
                    <i class="fas fa-home me-1"></i> Accueil
                </a>
            </div>
        </div>
    </header>

    <main>
        <div class="game-container">
            <div class="map-wrapper">
                <div id="map"></div>
            </div>

            <aside v-if="inventoryOpen" class="sidebar">
                <h5 class="sidebar-title mb-3">
                    <i class="fas fa-backpack me-2"></i>Inventaire
                </h5>
                <div v-if="inventoryItems.length === 0" class="text-muted small text-center py-3">
                    <i class="fas fa-box-open fa-2x mb-2 d-block"></i>
                    Votre inventaire est vide.
                </div>
                <ul v-else class="list-group list-group-flush">
                    <li v-for="item in inventoryItems" :key="item.id"
                        class="list-group-item d-flex align-items-center bg-transparent text-light border-secondary">
                        <img v-if="item.icon_url" :src="item.icon_url" :alt="item.name" class="icon-inventory me-3">
                        <span>{{ item.name }}</span>
                    </li>
                </ul>
            </aside>
        </div>

        <div v-if="modalVisible" class="modal-backdrop fade show"></div>
        <div v-if="modalVisible" class="modal show d-block" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <h5 class="modal-title">
                            <i v-if="modalType === 'success'" class="fas fa-check me-2"></i>
                            <i v-else-if="modalType === 'error'" class="fas fa-times me-2"></i>
                            <i v-else-if="modalType === 'info'" class="fas fa-info-circle me-2"></i>
                            <i v-else-if="modalType === 'codeInput'" class="fas fa-key me-2"></i>
                            <i v-else-if="modalType === 'endGame'" class="fas fa-trophy me-2"></i>
                            {{ modalTitle }}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" @click="closeNotification" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div v-if="modalPoints" class="alert alert-primary fw-bold text-center mb-3">
                            <i class="fas fa-star me-2"></i>{{ modalPoints }}
                        </div>

                        <div v-html="modalMessage" class="text-center"></div>

                        <div v-if="modalType === 'codeInput'" class="mt-4">
                            <input
                                    v-model="userInputCode"
                                    type="text"
                                    class="form-control text-center py-2"
                                    placeholder="Entrez le code secret..."
                                    @keyup.enter="validateCode"
                                    autofocus
                            >
                            <small class="text-muted mt-2 d-block">Appuyez sur Entrée pour valider</small>
                        </div>

                        <div v-if="modalType === 'endGame'" class="mt-4">
                            <label class="form-label text-light">Entrez votre nom pour l'éternité :</label>
                            <input
                                    v-model="playerPseudo"
                                    type="text"
                                    class="form-control text-center py-2"
                                    placeholder="Votre nom de légende..."
                                    @keyup.enter="saveGameScore"
                                    autofocus
                                    maxlength="20"
                            >
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button v-if="modalType === 'codeInput'" type="button" class="btn btn-theme-primary" @click="validateCode">
                            <i class="fas fa-check me-1"></i> Vérifier
                        </button>
                        <button v-else-if="modalType === 'endGame'" type="button" class="btn btn-theme-primary" @click="saveGameScore">
                            <i class="fas fa-save me-1"></i> Enregistrer
                        </button>

                        <button type="button" class="btn btn-theme-secondary" @click="closeNotification">
                            <i class="fas fa-times me-1"></i>
                            {{ (modalType === 'codeInput' || modalType === 'endGame') ? 'Annuler' : 'Fermer' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="../assets/js/game_store.js"></script>

</body>
</html>