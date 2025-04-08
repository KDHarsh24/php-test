<?php
namespace App\Controllers;

use App\Database\DB;

class RecipeController {
    public function index() {
        $db = DB::connect();
        $stmt = $db->query("SELECT * FROM recipes ORDER BY id DESC");
        echo json_encode($stmt->fetchAll(\PDO::FETCH_ASSOC));
    }

    public function create() {
        $data = json_decode(file_get_contents('php://input'), true);
        $db = DB::connect();
        $stmt = $db->prepare("INSERT INTO recipes (name, prep_time, difficulty, vegetarian) VALUES (?, ?, ?, ?)");
        $stmt->execute([$data['name'], $data['prep_time'], $data['difficulty'], $data['vegetarian']]);
        echo json_encode(['status' => 'Recipe created']);
    }

    public function show($id) {
        $db = DB::connect();
        $stmt = $db->prepare("SELECT * FROM recipes WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode($stmt->fetch(\PDO::FETCH_ASSOC));
    }

    public function update($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        $db = DB::connect();
        $stmt = $db->prepare("UPDATE recipes SET name=?, prep_time=?, difficulty=?, vegetarian=? WHERE id=?");
        $stmt->execute([$data['name'], $data['prep_time'], $data['difficulty'], $data['vegetarian'], $id]);
        echo json_encode(['status' => 'Recipe updated']);
    }

    public function delete($id) {
        $db = DB::connect();
        $stmt = $db->prepare("DELETE FROM recipes WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['status' => 'Recipe deleted']);
    }
}
