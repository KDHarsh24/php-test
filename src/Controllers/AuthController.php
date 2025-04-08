<?php
namespace App\Controllers;

use App\Database\DB;

class AuthController {
    public function login() {
        $data = json_decode(file_get_contents("php://input"), true);
        $db = DB::connect();
        $stmt = $db->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
        $stmt->execute([$data['username'], $data['password']]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($user) {
            echo json_encode(['message' => 'Login successful']);
        } else {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
        }
    }
}
