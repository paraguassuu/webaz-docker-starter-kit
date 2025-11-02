# 📡 API AVIGNON QUEST

## 🔗 URLs 
- **API**: `http://localhost:1234/api`
- **GeoServer**: `http://localhost:8080/geoserver`

## 📊 ENDPOINTS

### 1. TOUTS LES OBJETS
**GET** `http://localhost:1234/api/objets`

**Retour:**
```json
[
  {
    "id": 1,
    "nom": "Clé ancienne",
    "type": "objet_recuperable", 
    "latitude": 43.9493,
    "longitude": 4.8054,
    "est_debloque": true
  }
]