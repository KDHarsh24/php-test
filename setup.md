
# PHP Dockerized Recipe API Setup

This document describes how to build, run, and use the PHP RESTful API for managing recipes with authentication, ratings, and PostgreSQL integration.

---

## 🐳 Docker Setup

### 1. Clone the Repository

```bash
git clone <your-repo-url>
cd php-test
```

### 2. Build the Docker Image

```bash
docker-compose build
```

### 3. Run the Container

```bash
docker-compose up
```

This will:
- Wait for PostgreSQL to be ready.
- Automatically run `seed.php` to populate the database.
- Start Apache and expose the app at `http://localhost:8080`.

---

## 📦 Features Overview

- PHP 8 with Apache
- PostgreSQL with Docker
- RESTful API with Bramus Router
- JWT Auth (Login, Registration)
- Recipes CRUD
- Ratings system (1-5, multiple entries allowed)
- Protected routes

---

## 📄 API Endpoints

### 📌 Auth

- **POST /register**  
```json
{ "username": "harsh", "password": "123456" }
```

- **POST /login**  
Returns JWT token.

---

### 📌 Recipes

> Requires `Authorization: Bearer <token>` header.

- **GET /recipes**  
- **GET /recipes/{id}**  
- **POST /recipes**  
```json
{
  "name": "New Recipe",
  "prep_time": 20,
  "difficulty": 2,
  "vegetarian": true
}
```

- **PUT /recipes/{id}**  
Checks recipe belongs to user before updating.

- **DELETE /recipes/{id}**  
Checks ownership before deleting.

---

### 📌 Ratings

- **POST /recipes/{id}/rate**  
```json
{ "rating": 4 }
```

Multiple ratings by same user are allowed.

---

## ✅ Database Tables

- **users(id, username, password)**
- **recipes(id, name, prep_time, difficulty, vegetarian)**
- **ratings(id, recipe_id, user_id, rating, rated_at)**

---

## 📥 Seed Script

Run automatically during Docker build. To run manually:

```bash
docker exec -it php-test-app-1 php src/seed.php
```

---

## 🔐 Notes

- Uses JWT-based authentication.
- Protected routes return `401 Unauthorized` if token is missing or invalid.
- Users can only modify their own recipes.

---

## 🧪 Testing

Use Postman or `curl` to test API endpoints. Example:

```bash
curl -X POST http://localhost:8080/recipes   -H "Authorization: Bearer <your_token>"   -H "Content-Type: application/json"   -d '{ "name": "Test", "prep_time": 30, "difficulty": 2, "vegetarian": true }'
```

---

Happy Coding! 🚀
