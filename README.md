# 🎬 Netflux - Plateforme de Streaming

Une application web complète de type Netflix permettant la consultation de films et séries avec système d'authentification, gestion des favoris et interface d'administration.

## 🎯 Présentation générale

Netflux est une plateforme de streaming qui offre :
- **Catalogue public** : Parcourir les films et séries sans inscription
- **Espace personnel** : Gérer ses favoris et listes de visionnage après authentification
- **Administration** : Interface complète pour la gestion des contenus et utilisateurs
- **API REST** : Backend robuste avec API Platform
- **Interface moderne** : Frontend responsive inspiré de Netflix avec Vue.js 3

## 🏗️ Architecture technique

- **Backend** : Symfony 7.3 + API Platform
- **Frontend** : Vue.js 3 + Vue Router + Pinia
- **Base de données** : MySQL
- **Authentification** : JWT (LexikJWTAuthenticationBundle)
- **API** : REST avec documentation automatique (OpenAPI)

---

## 📦 Installation

### Prérequis

- PHP 8.1+
- Composer 2.x
- Symfony 7.3
- MySQL 8+

### Backend (Symfony)

```bash
# Cloner le repository
git clone <url-du-repo>
cd backend

# Installer les dépendances PHP
composer install

# Configurer les variables d'environnement
cp .env .env.local
# Éditer .env.local avec vos paramètres de BDD et JWT

# Configuration de la base de données dans .env.local
# DATABASE_URL="postgresql://user:password@127.0.0.1:5432/netflux?serverVersion=14&charset=utf8"

# Créer la base de données
php bin/console doctrine:database:create

# Exécuter les migrations
php bin/console doctrine:migrations:migrate

# Générer les clés JWT
php bin/console lexik:jwt:generate-keypair

# Charger les fixtures (optionnel - données de test)
php bin/console doctrine:fixtures:load

# Lancer le serveur de développement
symfony serve -d
# ou
php -S localhost:8000 -t public/
```

### Frontend (Vue.js)

```bash
# Se placer dans le dossier frontend
cd frontend

# Installer les dépendances
npm install
# ou
yarn install

# Configurer l'URL de l'API
cp .env.example .env
# Éditer .env avec l'URL du backend (ex: VITE_API_URL=http://localhost:8000)

# Lancer le serveur de développement
npm run dev
# ou
yarn dev

# Build pour la production
npm run build
# ou
yarn build
```

---

## 🚀 Lancement

### Mode développement

1. **Backend** : `http://localhost:8000`
   ```bash
   cd backend symfony serve
   ```

2. **Frontend** : `http://localhost:5173`
   ```bash
   cd frontend && npm run dev
   ```

### Mode production

```bash
# Backend
composer install --no-dev --optimize-autoloader
php bin/console cache:clear --env=prod

# Frontend
cd frontend
npm run build
# Les fichiers sont générés dans frontend/dist
```

---

## 📡 API Endpoints

### Authentification

#### POST `/api/auth/register`
Créer un nouveau compte utilisateur

**Request:**
```json
{
  "email": "user@example.com",
  "username": "johndoe",
  "password": "SecurePass123!",
  "confirmPassword": "SecurePass123!"
}
```

**Response (201):**
```json
{
  "id": 1,
  "email": "user@example.com",
  "username": "johndoe",
  "roles": ["ROLE_USER"]
}
```

#### POST `/api/auth/login`
Se connecter et obtenir un token JWT

**Request:**
```json
{
  "email": "user@example.com",
  "password": "SecurePass123!"
}
```

**Response (200):**
```json
{
  "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9...",
  "user": {
    "id": 1,
    "email": "user@example.com",
    "username": "johndoe",
    "roles": ["ROLE_USER"]
  }
}
```

### Films

#### GET `/api/movies`
Récupérer la liste des films

**Query Parameters:**
- `page` (int): Numéro de page (défaut: 1)
- `itemsPerPage` (int): Nombre d'items par page (défaut: 30)
- `genre` (string): Filtrer par genre
- `year` (int): Filtrer par année
- `search` (string): Recherche par titre

**Response (200):**
```json
{
  "hydra:member": [
    {
      "@id": "/api/movies/1",
      "@type": "Movie",
      "id": 1,
      "title": "Inception",
      "description": "Un voleur qui s'introduit dans les rêves...",
      "releaseDate": "2010-07-16",
      "duration": 148,
      "genre": ["Science-Fiction", "Thriller"],
      "imagePath": "/images/movies/inception.jpg",
      "videoUrl": "https://youtube.com/watch?v=...",
      "rating": 8.8,
      "favorites": [
          "user": "",
      ]
    }
  ],
  "hydra:totalItems": 150,
  "hydra:view": {
    "hydra:first": "/api/movies?page=1",
    "hydra:last": "/api/movies?page=5",
    "hydra:next": "/api/movies?page=2"
  }
}
```

#### GET `/api/movies/{id}`
Récupérer les détails d'un film

**Response (200):**
```json
{
  "@context": "/api/contexts/Movie",
  "@id": "/api/movies/1",
  "@type": "Movie",
  "id": 1,
  "title": "Inception",
  "description": "Un voleur qui s'introduit dans les rêves des autres...",
  "releaseDate": "2010-07-16",
  "duration": 148,
  "genre": ["Science-Fiction", "Thriller"],
  "imageUrl": "/images/movies/inception.jpg",
  "videoUrl": "https://youtube.com/watch?v=...",
  "rating": 8.8,
  "favorites": [
    "user": "",
    ]
}
```

#### POST `/api/movies` (Admin uniquement)
Créer un nouveau film

**Request:**
```json
{
  "title": "The Matrix",
  "description": "Un hacker découvre la vérité sur la réalité...",
  "releaseDate": "1999-03-31",
  "duration": 136,
  "genre": ["Science-Fiction", "Action"],
  "imagePath": "/images/movies/matrix.jpg",
  "videoUrl": "https://youtube.com/watch?v=..."
}
```

#### PUT `/api/movies/{id}` (Admin uniquement)
Mettre à jour un film

#### DELETE `/api/movies/{id}` (Admin uniquement)
Supprimer un film

### Séries

#### GET `/api/series`
Récupérer la liste des séries

**Query Parameters:**
- `page` (int): Numéro de page
- `itemsPerPage` (int): Items par page
- `genre` (string): Filtrer par genre
- `search` (string): Recherche par titre

**Response (200):**
```json
{
  "hydra:member": [
    {
      "@id": "/api/series/1",
      "@type": "Series",
      "id": 1,
      "title": "Stranger Things",
      "description": "Des événements surnaturels dans une petite ville...",
      "releaseDate": "2016-07-15",
      "duration": 89,
      "genre": ["Science-Fiction", "Horreur", "Drame"],
      "imagePath": "/images/series/stranger-things.jpg",
      "rating": 8.7,
      "favorites": [
        "user": ""
      ]
    }
  ],
  "hydra:totalItems": 85
}
```

#### GET `/api/series/{id}`
Récupérer les détails d'une série

**Response (200):**
```json
{
  "@id": "/api/series/1",
  "@type": "Serie",
  "id": 1,
  "title": "Stranger Things",
  "description": "Des événements surnaturels frappent une petite ville...",
  "releaseDate": "2016-07-15",
  "duration": 89,
  "genres": ["Science-Fiction", "Horreur", "Drame"],
  "imagePath": "/images/series/stranger-things.jpg",
  "videoUrl": "https://youtube.com/watch?v=...",
  "rating": 8.7,
  "favorites": [
        "user": ""
      ]
}
```

#### POST `/api/series` (Admin uniquement)
Créer une nouvelle série

#### PUT `/api/series/{id}` (Admin uniquement)
Mettre à jour une série

#### DELETE `/api/series/{id}` (Admin uniquement)
Supprimer une série

### Favoris

#### GET `/api/users/{userId}/favorites`
Récupérer les favoris d'un utilisateur (authentification requise)

**Response (200):**
```json
{
  "movies": [
    {
      "id": 1,
      "title": "Inception",
      "imagePath": "/images/movies/inception.jpg",
      "CreatedAt": "2024-01-15T10:30:00+00:00"
    },
    {
      "id": 1,
      "title": "Stranger Things",
      "imagePath": "/images/series/stranger-things.jpg",
    }
  ]
}
```

#### POST `/api/favorites`
Ajouter un contenu aux favoris (authentification requise)

**Request:**
```json
{
  "contentType": "movie",
  "contentId": 1
}
```

**Response (201):**
```json
{
  "id": 1,
  "user": "/api/users/1",
  "contentType": "movie",
  "contentId": 1,
}
```

#### DELETE `/api/favorites/{id}`
Retirer un contenu des favoris (authentification requise)

### Utilisateurs (Admin uniquement)

#### GET `/api/users`
Liste tous les utilisateurs

**Response (200):**
```json
{
  "hydra:member": [
    {
      "@id": "/api/users/1",
      "id": 1,
      "email": "user@example.com",
      "username": "johndoe",
      "roles": ["ROLE_USER"],
      "createdAt": "2024-01-01T10:00:00+00:00",
      "isActive": true
    }
  ],
  "hydra:totalItems": 245
}
```

#### PUT `/api/users/{id}`
Mettre à jour un utilisateur (modification des rôles, statut)

#### DELETE `/api/users/{id}`
Supprimer un utilisateur

---

## 🔐 Rôles et Permissions

### ROLE_USER (Utilisateur standard)
- ✅ Consulter le catalogue de films et séries
- ✅ Gérer ses propres favoris
- ✅ Voir les détails des contenus
- ✅ Consulter son profil personnel
- ❌ Ajouter/modifier/supprimer des contenus
- ❌ Gérer les autres utilisateurs

### ROLE_ADMIN (Administrateur)
- ✅ Toutes les permissions ROLE_USER
- ✅ Créer, modifier, supprimer des films
- ✅ Créer, modifier, supprimer des séries
- ✅ Gérer tous les utilisateurs

### Hiérarchie des rôles
```
ROLE_ADMIN
    └── ROLE_USER
```

---

## 🎨 Guide d'utilisation Frontend

### Navigation principale

#### Page d'accueil
- **URL** : `/`
- Boutons redirections vers films/séries,
- Profil (si connecté)
- Inscription
- Connexion

#### Catalogue Films
- **URL** : `/movies`
- Grille de tous les films disponibles
- Filtres : genre, année, note
- Tri : popularité, date de sortie, note
- Pagination

#### Détails d'un contenu
- **URL** : `/movies/:id`
- Informations complètes
- Bande-annonce intégrée
- Bouton "Ajouter aux favoris"

### Fonctionnalités utilisateur

#### Mes Favoris
- **URL** : `/favorites` (authentification requise)
- Liste personnalisée des films et séries favoris
- Suppression rapide d'un favori
- Tri par date d'ajout

#### Mon Profil
- **URL** : `/profile` (authentification requise)
- Consultation du nombre de favoris
- Consultation des identifiants

#### Recherche
- Accessible depuis la barre de navigation
- Recherche en temps réel (debounce)
- Résultats mixtes (films + séries)
- Filtres appliquables aux résultats

### Interface d'administration

#### Dashboard Admin
- **URL** : `/admin` (ROLE_ADMIN requis)
- Statistiques globales :
  - Navigation `/admin/movies`
  - Navigation `/admin/users`

#### Gestion des Films
- **URL** : `/admin/movies`
- Liste complète avec actions rapides
- Formulaire de création/édition
- Upload d'images (poster, backdrop)
- Gestion des genres et tags

#### Gestion des Séries
- **URL** : `/admin/movies`
- Liste complète avec statut
- Formulaire de création/édition
- Gestion des saisons et épisodes
- Upload d'images
- Gestion des genres et tags
- 
#### Gestion des Utilisateurs
- **URL** : `/admin/users`
- Liste de tous les utilisateurs
- Modification des rôles
- Suppression de compte

### Navigation et UX

#### Menu de navigation
```
[Logo Netflux] [Films/Séries] [Favoris] [Profil]
```

#### Authentification
- Modal de connexion/inscription 
- Formulaires avec validation en temps réel
- Messages d'erreur explicites
- Redirection automatique après connexion

#### Responsive Design
- Desktop : Grille de 5 colonnes
- Mobile : Grille de 2 colonnes
---

## 📚 Dépendances et Versions

### Backend (Symfony)

**Version PHP** : ^8.1

**Packages principaux** :
```json
{
  "symfony/framework-bundle": "^6.4",
  "symfony/security-bundle": "^6.4",
  "symfony/validator": "^6.4",
  "symfony/serializer": "^6.4",
  "doctrine/orm": "^2.17",
  "doctrine/doctrine-bundle": "^2.11",
  "api-platform/core": "^3.2",
  "lexik/jwt-authentication-bundle": "^2.20",
  "nelmio/cors-bundle": "^2.4",
  "symfony/maker-bundle": "^1.52",
  "doctrine/doctrine-fixtures-bundle": "^3.5",
  "fakerphp/faker": "^1.23"
}
```

**Packages de développement** :
```json
{
  "symfony/debug-bundle": "^6.4",
  "symfony/web-profiler-bundle": "^6.4",
  "symfony/browser-kit": "^6.4",
}
```

### Frontend (Vue.js)

**Version Node.js** : >=18.0.0

**Packages principaux** :
```json
{
  "vue": "^3.4.0",
  "vue-router": "^4.2.5",
  "pinia": "^2.1.7",
  "axios": "^1.6.2",
  "vite": "^5.0.0"
}
```

**Packages UI/UX** :
```json
{
  "@headlessui/vue": "^1.7.16",
  "@heroicons/vue": "^2.1.1",
  "swiper": "^11.0.5",
}
```

**Packages de développement** :
```json
{
  "@vitejs/plugin-vue": "^5.0.0",
  "@vue/test-utils": "^2.4.3",
  "vitest": "^1.1.0",
  "eslint": "^8.56.0",
  "eslint-plugin-vue": "^9.19.2",
  "prettier": "^3.1.1"
}
---

```
## 🔧 Configuration

### Variables d'environnement Backend (.env.local)

```env
# Base de données
DATABASE_URL="postgresql://user:password@127.0.0.1:5432/netflux"

```
# JWT
JWT_SECRET_KEY=%kernel.project_dir%/config/jwt/private.pem
JWT_PUBLIC_KEY=%kernel.project_dir%/config/jwt/public.pem
JWT_PASSPHRASE=your_passphrase_here

# CORS
CORS_ALLOW_ORIGIN='^https?://(localhost|127\.0\.0\.1)(:[0-9]+)?$'

## 📖 Documentation API

La documentation interactive de l'API est disponible à :
- **Swagger UI** : `http://localhost:8000/api/docs`
- **Format OpenAPI** : `http://localhost:8000/api/docs.json`

---

## 🤝 Contribution

1. Fork le projet
2. Créer une branche (`git checkout -b feature/AmazingFeature`)
3. Commit les changements (`git commit -m 'Add AmazingFeature'`)
4. Push vers la branche (`git push origin feature/AmazingFeature`)
5. Ouvrir une Pull Request

---

## 👥 Auteurs

- **Kyllian** - *Développement initial* - [Mon GitHub](https://github.com/KyllianLerousseau)

---

## 🙏 Remerciements

- Design inspiré de Netflix
- API Platform pour l'architecture REST
- La communauté Symfony et Vue.js
