<?php
require_once './config.php';

class Model {
    protected $db;

    public function __construct() {
        $this->createDatabaseIfNotExists();

        $this->db = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
            DB_USER,
            DB_PASS
        );

        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->deploy();
    }

    private function createDatabaseIfNotExists() {
        $pdo = new PDO(
            "mysql:host=" . DB_HOST . ";charset=utf8",
            DB_USER,
            DB_PASS
        );

        $pdo->exec("CREATE DATABASE IF NOT EXISTS " . DB_NAME . " CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
    }

    private function deploy() {
        $this->db->exec("
            CREATE TABLE IF NOT EXISTS categoria (
                id_categoria INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                nombre VARCHAR(100) NOT NULL,
                imagen_url VARCHAR(255) DEFAULT NULL
            )
        ");

        $this->db->exec("
            CREATE TABLE IF NOT EXISTS equipo (
                id_equipo INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                id_categoria INT UNSIGNED NULL,
                nombre VARCHAR(100) NOT NULL,
                pais VARCHAR(50) NOT NULL,
                estadio VARCHAR(100) NOT NULL,
                anio_fundacion INT NOT NULL,
                copas_libertadores INT NOT NULL,
                director_tecnico VARCHAR(100) NOT NULL,
                apodo_club VARCHAR(50) DEFAULT NULL,
                FOREIGN KEY (id_categoria) REFERENCES categoria(id_categoria)
                    ON DELETE SET NULL
            )
        ");

        $query = $this->db->query("SELECT COUNT(*) FROM categoria");
        $count = $query->fetchColumn();

        if ($count == 0) {
            $this->db->exec("
                INSERT INTO categoria (nombre, imagen_url) VALUES
                ('Argentina', NULL),
                ('Brasil', NULL),
                ('Colombia', NULL),
                ('Ecuador', NULL),
                ('Uruguay', NULL)
            ");
        }
    }
}