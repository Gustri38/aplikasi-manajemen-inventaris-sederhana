<?php
class User {
    private $pdo;
    private $table_name = "users";

    public function __construct($db) {
        $this->pdo = $db;
    }

    public function findByUsername($username) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE username = ? LIMIT 0,1";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$username]);
        return $stmt->fetch();
    }

    public function verifyPassword($password, $hashedPassword) {
        return password_verify($password, $hashedPassword);
    }

    public function create($username, $password, $role) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO " . $this->table_name . " (username, password, role) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([$username, $hashed_password, $role]);
    }
}
?>