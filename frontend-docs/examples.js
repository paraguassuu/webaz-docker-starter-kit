// 🎮 EXEMPLES DE CODE PRÊTS À L'EMPLOI - AVIGNON QUEST

// 📍 1. RÉCUPÉRER TOUS LES OBJETS
async function chargerTousObjets() {
    try {
        const reponse = await fetch('http://localhost:1234/api/objets');
        const objets = await reponse.json();
        console.log('🎯 Objets chargés:', objets);
        return objets;
    } catch (erreur) {
        console.error('❌ Erreur lors du chargement des objets:', erreur);
        return [];
    }
}

// 📍 2. RÉCUPÉRER UN OBJET SPÉCIFIQUE
async function chargerObjet(id) {
    try {
        const reponse = await fetch(`http://localhost:1234/api/objets/${id}`);
        const objet = await reponse.json();
        console.log('🔍 Objet trouvé:', objet);
        return objet;
    } catch (erreur) {
        console.error(`❌ Erreur lors du chargement de l'objet ${id}:`, erreur);
        return null;
    }
}

// 📍 3. EXEMPLE : AFFICHER LES OBJETS SUR LA CARTE
function afficherObjetsSurCarte(objets) {
    objets.forEach(objet => {
        console.log(`📍 ${objet.nom} - Lat: ${objet.latitude}, Lng: ${objet.longitude}`);
        
        // Si vous utilisez Leaflet :
        // L.marker([objet.latitude, objet.longitude])
        //   .addTo(carte)
        //   .bindPopup(`<b>${objet.nom}</b><br>${objet.description}`);
    });
}

// 📍 4. EXEMPLE : VÉRIFIER SI PEUT ÊTRE COLLECTÉ
function peutCollecter(objet) {
    if (objet.est_debloque) {
        return true;
    }
    
    if (objet.code_requis) {
        return false; // Nécessite un code
    }
    
    return objet.type === 'objet_recuperable';
}

// 📍 5. EXEMPLE : GESTION DES CODES
function verifierCode(objet, codeSaisi) {
    if (objet.code_requis && objet.code_requis === codeSaisi) {
        console.log('✅ Code correct !');
        return true;
    } else {
        console.log('❌ Code incorrect');
        return false;
    }
}

// 🚀 TEST RAPIDE - décommentez pour tester
/*
// Tester l'API
chargerTousObjets().then(objets => {
    console.log('Total des objets:', objets.length);
    afficherObjetsSurCarte(objets);
});

// Tester un objet spécifique
chargerObjet(1).then(objet => {
    if (objet) {
        console.log('Peut être collecté?', peutCollecter(objet));
    }
});
*/

// Export pour utilisation dans d'autres fichiers
export {
    chargerTousObjets,
    chargerObjet,
    afficherObjetsSurCarte,
    peutCollecter,
    verifierCode
};