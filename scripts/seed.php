<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Database\DB;

try {
    $pdo = DB::connect();

    // Drop in correct order to avoid foreign key errors
    $pdo->exec("DROP TABLE IF EXISTS ratings");
    $pdo->exec("DROP TABLE IF EXISTS recipes");
    $pdo->exec("DROP TABLE IF EXISTS users");

    // Create tables
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id SERIAL PRIMARY KEY,
            username VARCHAR(255) UNIQUE NOT NULL,
            password TEXT NOT NULL
        );
    ");

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS recipes (
            id SERIAL PRIMARY KEY,
            name TEXT NOT NULL,
            prep_time INT NOT NULL,
            difficulty INT CHECK (difficulty BETWEEN 1 AND 3),
            vegetarian BOOLEAN NOT NULL
        );
    ");

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS ratings (
            id SERIAL PRIMARY KEY,
            recipe_id INT REFERENCES recipes(id),
            user_id INT REFERENCES users(id),
            rating INT CHECK (rating BETWEEN 1 AND 5),
            rated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
    ");

    // Insert demo data (optional: skip if already exists)
    $pdo->exec("
        INSERT INTO users (username, password) VALUES
        ('harsh', '123456'),
        ('user1', 'pass');
    ");

    $pdo->exec("
        INSERT INTO recipes (name, prep_time, difficulty, vegetarian) VALUES
        ('Paneer Butter Masala', 45, 2, TRUE),
        ('Chicken Biryani', 60, 3, FALSE),
        ('Dal Tadka', 30, 1, TRUE);
    ");

    $pdo->exec("
        INSERT INTO ratings (recipe_id, user_id, rating) VALUES
        (1, 1, 5),
        (2, 1, 4),
        (3, 2, 3);
    ");

    echo "✅ Database seeded successfully!\n";

} catch (PDOException $e) {
    echo "❌ Seeding failed: " . $e->getMessage() . "\n";
}
