---

# 📚 Interactive Fiction API

Une API RESTful en Laravel pour gérer des histoires interactives composées de chapitres et de choix. Chaque utilisateur peut créer des histoires, ajouter des chapitres, et définir des choix pour une navigation narrative dynamique.

---

## 🚀 Fonctionnalités

* 🔐 Authentification via Laravel Sanctum
* 📘 CRUD complet sur les **histoires**
* 📄 CRUD complet sur les **chapitres**
* 🔀 CRUD sur les **choix** entre chapitres
* 🧪 Tests unitaires et fonctionnels inclus
* 🧾 Gestion centralisée des erreurs API (404, 422, 500...)

---

## 📦 Installation

```bash
git clone https://github.com/ton-utilisateur/interactive-fiction-api.git
cd interactive-fiction-api

composer install
cp .env.example .env
php artisan key:generate

# Crée la base de données et configure-la dans `.env`
php artisan migrate --seed
```

---

## 🧪 Lancer les tests

```bash
php artisan test
```

---

## 🛠️ Endpoints principaux

### 🔑 Authentification

* `POST /api/register` – S’inscrire
* `POST /api/login` – Se connecter

### 📘 Histoires

* `GET /api/v1/stories`
* `POST /api/v1/stories`
* `GET /api/v1/stories/{id}`
* `PATCH /api/v1/stories/{id}`
* `DELETE /api/v1/stories/{id}`

### 📄 Chapitres

* `GET /api/v1/stories/{story_id}/chapters`
* `POST /api/v1/stories/{story_id}/chapters`
* `GET /api/v1/chapters/{id}`
* `PATCH /api/v1/chapters/{id}`
* `DELETE /api/v1/chapters/{id}`

### 🔀 Choix

* `GET /api/v1/chapters/{chapter_id}/choices`
* `POST /api/v1/chapters/{chapter_id}/choices`
* `GET /api/v1/choices/{id}`
* `PATCH /api/v1/choices/{id}`
* `DELETE /api/v1/choices/{id}`

---

## 🧰 Stack Technique

* Laravel 10+
* Laravel Sanctum (authentification API)
* PHPUnit (tests)
* Eloquent (ORM)
* Laravel Resources & Requests

---

## 🧑‍💻 Auteur

* **Nom :** Michaël Desgalier

---