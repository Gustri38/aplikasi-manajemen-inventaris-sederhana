<?php

class Product {
    private $pdo;
    private $table_name = "products";

    public function __construct($db) {
        $this->pdo = $db;
    }

    // CREATE
    public function create($name, $kode_aset, $location, $responsible_person_name, $description) {
        $query = "INSERT INTO " . $this->table_name . " (name, kode_aset, location, responsible_person_name, description) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([$name, $kode_aset, $location, $responsible_person_name, $description]);
    }

    // READ ALL
    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY name ASC";
        $stmt = $this->pdo->query($query); // Gunakan query() untuk SELECT tanpa parameter
        return $stmt->fetchAll(); // Mengambil semua baris hasil sebagai array asosiatif
    }

    // READ ONE
    public function readOne($kode_aset) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE kode_aset = ? LIMIT 0,1";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$kode_aset]); 
        return $stmt->fetch(); 
    }

    // UPDATE
    public function update($old_kode_aset, $name, $new_kode_aset, $location, $responsible_person_name, $description) {
        $query = "UPDATE " . $this->table_name . " SET name = ?, kode_aset = ?, location = ?, responsible_person_name = ?, description = ? WHERE kode_aset = ?";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([$name, $new_kode_aset, $location, $responsible_person_name, $description, $old_kode_aset]);
    }

    // DELETE
    public function delete($kode_aset) {
        $query = "DELETE FROM " . $this->table_name . " WHERE kode_aset = ?";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([$kode_aset]);
    }
}
?>