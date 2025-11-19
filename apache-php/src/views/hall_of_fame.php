<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hall of Fame | Le Secret Maudit d'Avignon</title>

    <link rel="apple-touch-icon" sizes="180x180" href="../assets/images/favicon_io/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/images/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon_io/favicon-16x16.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=MedievalSharp&family=Work+Sans:wght@400;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../assets/styles/hall_of_fame.css">
</head>
<body>

<header class="navbar navbar-dark">
    <div class="container-fluid">
        <span class="navbar-brand mb-0 h1">🎭 Hall of Fame</span>
        <div>
            <a href="/map" class="btn btn-theme-primary btn-sm me-2"><i class="fas fa-play me-1"></i> Reprendre l'Aventure</a>
            <a href="/" class="btn btn-theme-secondary btn-sm"><i class="fas fa-home me-1"></i> Accueil</a>
        </div>
    </div>
</header>

<main>
    <div class="container my-5">
        <div class="score-card">
            <h2 class="text-center mb-4">
                <span class="trophy-icon">🏆</span>
                <br>
                Les Légendes d'Avignon
            </h2>

            <?php if (empty($hallOfFame)): ?>
                <div class="text-center p-4">
                    <p class="lead">Le panthéon est encore vide.</p>
                    <p class="text-white-50">La malédiction n'a pas encore été vaincue. Serez-vous le premier à inscrire votre nom dans l'histoire ?</p>
                </div>
                <div class="text-center mt-5">
                    <a href="/map" class="btn btn-theme-primary btn-lg">
                        <i class="fas fa-compass me-2"></i> Relever le Défi
                    </a>
                </div>
            <?php else: ?>
                <ol class="list-group list-group-flush score-list">
                    <?php foreach ($hallOfFame as $index => $player): ?>
                        <li class="list-group-item score-item">
                            <div class="rank-badge">
                                <?php if ($index == 0) echo '🥇'; elseif ($index == 1) echo '🥈'; elseif ($index == 2) echo '🥉'; else echo $index + 1; ?>
                            </div>
                            <div class="player-name"><?= htmlspecialchars($player['pseudo']) ?></div>
                            <div class="player-score ms-auto"><?= htmlspecialchars($player['score']) ?> pts</div>
                        </li>
                    <?php endforeach; ?>
                </ol>
            <?php endif; ?>


        </div>
    </div>
</main>

<footer class="text-center text-light py-3 mt-auto">
    <p class="mb-0">&copy; <?= date('Y') ?> Avignon Escape Game - Tous droits réservés</p>
</footer>

</body>
</html>