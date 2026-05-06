<?php
require_once './app/models/Model.php';

class CategoryModel extends Model {

    public function getCategories() {
        $query = $this->db->prepare("SELECT * FROM categoria ORDER BY nombre ASC");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getCategoryById($id) {
        $query = $this->db->prepare("SELECT * FROM categoria WHERE id_categoria = ?");
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function getTeamsByCategory($id) {
        $query = $this->db->prepare("
            SELECT e.*, c.nombre AS categoria
            FROM equipo e
            JOIN categoria c ON e.id_categoria = c.id_categoria
            WHERE c.id_categoria = ?
            ORDER BY e.nombre ASC
        ");
        $query->execute([$id]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function insertCategory($nombre, $imagen_url) {
        $query = $this->db->prepare("INSERT INTO categoria (nombre, imagen_url) VALUES (?, ?)");
        $query->execute([$nombre, $imagen_url]);
    }

    public function updateCategory($id, $nombre, $imagen_url) {
        $query = $this->db->prepare("UPDATE categoria SET nombre = ?, imagen_url = ? WHERE id_categoria = ?");
        $query->execute([$nombre, $imagen_url, $id]);
    }

    public function deleteCategory($id) {
        $query = $this->db->prepare("DELETE FROM categoria WHERE id_categoria = ?");
        $query->execute([$id]);
    }
}