<?php
namespace App\Controllers;

use App\Database\DB;

class RatingController {
    public function rate($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        $db = DB::connect();

        $stmt = $db->prepare("INSERT INTO ratings (user_id, recipe_id, rating) VALUES (?, ?, ?)");
        $stmt->execute([$data['user_id'], $id, $data['rating']]);

        echo json_encode(['status' => 'Rating added']);
    }
}
