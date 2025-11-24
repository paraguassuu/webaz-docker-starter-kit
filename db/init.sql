CREATE EXTENSION IF NOT EXISTS postgis;

-- TABLE "points" qui renferme la position géographique des points
    -- La latitude et la longitude sont des colonnes de type real et ne peuvent pas être nulles
    -- La géométrie est une colonne de type geometry avec le SRID 4326 (WGS84).


CREATE TABLE points
(
    id SERIAL PRIMARY KEY,
    latitude real NOT NULL,
    longitude real NOT NULL,
    geom geometry(Point,4326)
);


-- Table "icones" qui renferme les icônes représentant les objets
    -- La taille est une colonne de type real pour la taille de l'icône
    -- La position est une colonne de type point pour la position de l'icône dans la carte. Sa valeur est obtenue en faisant (taille/2 , taille)
    -- L'url est une colonne de type chaine de caractère qui permet de spécifier le chemin de stockage de l'icône "assets/images/icones"

CREATE TABLE icones
(
    id SERIAL PRIMARY KEY,
    url VARCHAR(255)  NOT NULL,
    taille real,
    position Point
);

-- Table "objets" qui renferme tous les objets qui seront utilisés dans le cadre du jeu. Elle est liée à la table "icones" et la table "points"
    -- Le nom est une colonne de type chaine de caractère qui permet de spécifier le nom du lieu ou se trouve le point
    -- L'enigme est une colonne de type text qui permet d'orienter le joueur à travers des paraboles
    -- Le min_zoom_visible est une colonne de type integer pour le zoom minimum pour voir l'objet
    -- La départ est une colonne de type boolean pour savoir si l'objet sera sur la carte au lancement du jeu
    -- L'objet_type est une colonne de type chaine de caractère qui permet de spécifier le type d'objet (ex: "recupérable", "code",..)
    -- Le code_affiche est une colonne de type chaine de caractère qui permet au objet de type code d'afficher le code qu'il renferme
    -- L'objet_requis_id est une colonne de type integer qui permet de lier un objet à l'autre objet qui permet de le débloquer
    -- L'objet_libere_id est une colonne de type integer qui permet de lier un objet à un autre objet qui sera lié par la suite dans le jeu'
    -- L'indice est une colonne de type text qui permet d'afficher l'indice de l'objet bloquant
    -- La deja_visite est une colonne de type boolean pour savoir si l'objet a déjà été visité

CREATE TABLE objets
(
    id SERIAL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    enigme text,
    icone_id integer REFERENCES icones(id) ON DELETE CASCADE,
    point_id integer REFERENCES points(id) ON DELETE CASCADE,
    min_zoom_visible integer,
    depart boolean DEFAULT false,
    objet_type VARCHAR(20) NOT NULL,
    code_affiche VARCHAR(4),
    objet_requis_id integer REFERENCES objets(id) ON DELETE SET NULL,
    objet_libere_id integer REFERENCES objets(id) ON DELETE SET NULL,
    indice text,
    deja_visite boolean
);



-- Table "players" qui permet de gérer les différents joueurs
    -- Le pseudo est unique et ne peut pas être vide
    -- Le score est une colonne de type integer avec une valeur par défaut de 0 mais dans le jeu, il est à 10.

CREATE TABLE players
(
    pseudo VARCHAR(50) NOT NULL,
    score integer DEFAULT 0
);


-- =================================================================
-- REMPLISSAGE DE LA BASE DE DONNÉES POUR L'ESCAPE GAME "LA MALÉDICTION D'AVIGNON"
-- =================================================================


INSERT INTO icones (id, url, taille, position) VALUES
(1, 'assets/images/icons/parchemin.png', 40, '(20, 40)'),  -- Parchemin Codé
(2, 'assets/images/icons/cle.png', 40, '(20, 40)'),        -- Clé du Palais
(3, 'assets/images/icons/coffre.png', 40, '(20, 40)'),     -- Coffre du Jardin
(4, 'assets/images/icons/porte.png', 40, '(20, 40)'),      -- Porte Secrète
(5, 'assets/images/icons/amulette.png', 40, '(20, 40)'),   -- Amulette Magique
(6, 'assets/images/icons/sceau.png', 40, '(20, 40)'),      -- Sceau Papal
(7, 'assets/images/icons/carte.png', 40, '(20, 40)'),      -- Carte des Tunnels
(8, 'assets/images/icons/journal.png', 40, '(20, 40)'),    -- Journal d'Adalf
(9, 'assets/images/icons/relique.png', 50, '(25, 50)');     -- Relique Finale


INSERT INTO points (id, latitude, longitude, geom) VALUES
(1, 43.9537, 4.8050, ST_SetSRID(ST_MakePoint(4.8050, 43.9537), 4326)), -- Pont Saint-Bénezet (Parchemin)
(2, 43.9510, 4.8065, ST_SetSRID(ST_MakePoint(4.8065, 43.9510), 4326)), -- Place du Palais (Clé du Palais)
(3, 43.9528, 4.8072, ST_SetSRID(ST_MakePoint(4.8072, 43.9528), 4326)), -- Rocher des Doms (Coffre du Jardin)
(4, 43.9515, 4.8080, ST_SetSRID(ST_MakePoint(4.8080, 43.9515), 4326)), -- Cathédrale Notre-Dame-des-Doms (Porte Secrète)
(5, 43.9534, 4.8074, ST_SetSRID(ST_MakePoint(4.8074, 43.9534), 4326)), -- Panorama du rocher des Doms (Amulette Magique)
(6, 43.9508, 4.8077, ST_SetSRID(ST_MakePoint(4.8077, 43.9508), 4326)), -- Palais des Papes (Sceau Papal)
(7, 43.9485, 4.8033, ST_SetSRID(ST_MakePoint(4.8033, 43.9485), 4326)), -- Collège Joseph Vernet (Carte des Tunnels)
(8, 43.9450, 4.8140, ST_SetSRID(ST_MakePoint(4.8140, 43.9450), 4326)), -- Rue des Teinturiers (Journal d'Adalf)
(9, 43.9493, 4.8059, ST_SetSRID(ST_MakePoint(4.8059, 43.9493), 4326)); -- Centre-ville (Place de l'Horloge) (Relique Finale)


INSERT INTO objets (id, nom, enigme, icone_id, point_id, min_zoom_visible, depart, objet_type, code_affiche, objet_requis_id, objet_libere_id, indice, deja_visite) VALUES
-- Les 5 objets visibles au début du jeu (depart = true)
(1, 'Parchemin Codé', 'Un vieux parchemin posé sur le pont. Il semble contenir un message historique...', 1, 1, 17, true, 'code', '1378', NULL, NULL, 'Seul le poids de l''histoire peut la desceller.', false),
(2, 'Clé du Palais', 'Ceci est une clé en fer forgé. Elle doit ouvrir quelque chose d''important', 2, 2, 16, true, 'recuperable', NULL, NULL, NULL, 'Seule une clé portant l''empreinte du pouvoir peut l''ouvrir.', false),
(3, 'Coffre du Jardin', 'Un coffre lourd et robuste, scellé par une serrure complexe.', 3, 3, 18, true, 'bloque_par_objet', NULL, 2, 6, NULL, false),
(4, 'Porte Secrète', 'Une porte dissimulée dans une ruelle sombre, bloquée par un mécanisme à chiffres.', 4, 4, 15, true, 'bloque_par_code', NULL, 1, 7, NULL, false),
(5, 'Amulette Magique', 'Une amulette de pierre qui émet une faible lueur. Elle semble attendre un catalyseur.', 5, 5, 17, true, 'bloque_par_objet', NULL, 6, 8, NULL, false),

-- Les 4 objets qui apparaissent au cours du jeu (depart = false)
(6, 'Sceau Papal', 'Un sceau officiel, orné des armoiries papales. Un objet d''une grande autorité.', 6, 6, 15, false, 'recuperable', NULL, NULL, NULL,'Elle ne répondra qu''à l''autorité papale.', false),
(7, 'Carte des Tunnels', 'Une carte jaunie détaillant d''anciens passages sous la ville, avec une étrange séquence de chiffres.', 7, 7, 16, false, 'code', '5678', NULL, NULL, 'Les quatre points cardinaux de mon créateur guident vers le secret.', false),
(8, 'Journal d''Adalf', 'Le journal perdu du cardinal Adalf. Ses secrets sont protégés par une dernière énigme.', 8, 8, 16, false, 'bloque_par_code', NULL, 7, 9, NULL, false),
(9, 'Relique Finale', 'La Relique de Rédemption ! Sa lumière pure est prête à lever la malédiction.', 9, 9, 18, false, 'final', NULL, NULL, NULL, NULL, false);


INSERT INTO players (pseudo, score) VALUES
('Atac', 120),
('Avanturier', 150),
('Vini', 125),
('ASk', 100),
('FIB', 90);