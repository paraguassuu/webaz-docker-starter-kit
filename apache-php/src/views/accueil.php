<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/images/favicon_io/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/images/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon_io/favicon-16x16.png">
    <title>Accueil | Le Secret Maudit d'Avignon</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=MedievalSharp&family=Work+Sans:wght@400;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../assets/styles/accueil.css">
</head>
<body>

<header class="navbar navbar-dark">
    <div class="container-fluid">
        <span class="navbar-brand mb-0 h1">🎭 Escape Game Avignon</span>
        <div>
            <a href="#missions" class="btn btn-theme-secondary btn-sm me-2">
                <i class="fas fa-flag me-1"></i> Missions
            </a>
            <a href="#regles" class="btn btn-theme-secondary btn-sm me-2">
                <i class="fas fa-book me-1"></i> Règles
            </a>
            <a href="/hall-of-fame" class="btn btn-theme-primary btn-sm me-2" target="_blank">
                <i class="fas fa-trophy me-1"></i> Hall of Fame
            </a>
        </div>
    </div>
</header>

<main class="py-5">
    <div class="container">
        <div class="row align-items-center hero-section">
            <div class="col-lg-7 text-center text-lg-start">
                <h1 class="display-3 fw-bold mb-3">Le Secret Maudit d'Avignon</h1>
                <p class="lead mb-4">
                    On raconte que sous les pierres dorées de la Cité des Papes, un murmure parcourt les siècles. Une malédiction, lancée par le cardinal Adalf pour protéger un terrible secret, emprisonne l'âme de la ville. Seule une relique oubliée, <strong>la Relique de Rédemption</strong>, peut briser le sort.
                </p>
                <p class="mb-4">
                    Les gardiens ont failli. Les érudits ont échoué. Aujourd'hui, le destin d'Avignon repose sur vous.
                </p>
                <a href="/map" class="btn btn-theme-primary btn-lg shadow-lg">
                    <i class="fas fa-compass me-2"></i> Accepter la Quête
                </a>
            </div>
            <div class="col-lg-5 d-none d-lg-block text-center">
                 <i class="fas fa-dungeon hero-icon"></i>
            </div>
        </div>

        <div id="missions" class="mission-section mt-5">
            <h2 class="text-center mb-5">Votre Quête, si vous l'acceptez...</h2>
            <div class="row">
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="mission-step">
                        <div class="icon-wrapper"><i class="fas fa-map-location-dot"></i></div>
                        <h5>Explorez</h5>
                        <p>Parcourez les lieux emblématiques d'Avignon sur une carte interactive et découvrez des points d'intérêt cachés.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="mission-step">
                        <div class="icon-wrapper"><i class="fas fa-eye"></i></div>
                        <h5>Déchiffrez</h5>
                        <p>Examinez parchemins, gravures et objets mystérieux. Chaque détail est un indice potentiel qui vous mènera à la vérité.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="mission-step">
                        <div class="icon-wrapper"><i class="fas fa-key"></i></div>
                        <h5>Assemblez</h5>
                        <p>Collectez des artefacts anciens et des codes secrets. Utilisez votre inventaire et votre logique pour déjouer les mécanismes du cardinal.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="mission-step">
                        <div class="icon-wrapper"><i class="fas fa-gem"></i></div>
                        <h5>Triomphez</h5>
                        <p>Surmontez l'ultime épreuve, mettez la main sur la Relique de Rédemption et libérez enfin la cité de son emprise séculaire.</p>
                    </div>
                </div>
            </div>
        </div>

        <div id="regles" class="row align-items-center hero-section mt-5">
            <div class="col-lg-4 text-center">
                <i class="fas fa-puzzle-piece hero-icon"></i>
            </div>

            <div class="col-lg-8">
                <h2 class="fw-bold mb-4">Règles du Jeu</h2>

                <div class="rules-content">
                    <div class="row h-100 position-relative">
                        <div class="col-md-5">
                            <h4 class="mb-3"><i class="fas fa-gamepad me-2"></i>Éléments de l'Interface</h4>

                            <div class="rule-item">
                                <strong>Score</strong><br>
                                <small><i class="fa-solid fa-angles-right me-2"></i> Votre progression totale</small>
                            </div>

                            <div class="rule-item">
                                <strong>Mode Triche</strong><br>
                                <small><i class="fa-solid fa-angles-right me-2"></i> Carte de chaleur (avec pénalité)</small>
                            </div>

                            <div class="rule-item">
                                <strong>Inventaire</strong><br>
                                <small><i class="fa-solid fa-angles-right me-2"></i> Objets collectés</small>
                            </div>

                            <div class="rule-item">
                                <strong>Page d'accueil</strong><br>
                                <small><i class="fa-solid fa-angles-right me-2"></i> Les missions et règles du jeu</small>
                            </div>
                        </div>

                        <div class="col-md-6 offset-md-1">
                            <h4 class="mb-3"><i class="fas fa-star me-2"></i>Système de Points</h4>

                            <div class="rule-item">
                                <strong><i class="fa-solid fa-angle-right me-2"></i>Objets récupérables</strong><br>
                                <small> <b>+10</b> points</small>
                            </div>

                            <div class="rule-item">
                                <strong><i class="fa-solid fa-angle-right me-2"></i>Codes découverts</strong><br>
                                <small> <b>+10</b> points</small>
                            </div>

                            <div class="rule-item">
                                <strong><i class="fa-solid fa-angle-right me-2"></i>Énigmes résolues</strong><br>
                                <small> <b>+15</b> points</small>
                            </div>

                            <div class="rule-item">
                                <strong><i class="fa-solid fa-angle-right me-2"></i>Activation de la carte chaleur</strong><br>
                                <small> <b>-35</b> points</small>
                            </div>

                            <div class="rule-item">
                                <strong><i class="fa-solid fa-angle-right me-2"></i>Codes incorrects</strong><br>
                                <small> <b>-5</b> points</small>
                            </div>

                            <div class="rule-item">
                                <strong><i class="fa-solid fa-angle-right me-2"></i>Victoire finale</strong><br>
                                <small> <b>+50</b> points</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<footer class="text-center text-light py-3 mt-auto">
    <p class="mb-0">&copy; <?= date('Y') ?> Avignon Escape Game - Tous droits réservés</p>
</footer>

</body>
</html>