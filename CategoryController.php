<?php
require_once './app/models/CategoryModel.php';

class CategoryController {
    private $model;

    public function __construct() {
        $this->model = new CategoryModel();
    }

    public function showCategories() {
        $categories = $this->model->getCategories();
        require './app/views/categories.phtml';
    }

    public function showTeamsByCategory() {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            $this->showError("Categoría no encontrada");
            return;
        }

        $category = $this->model->getCategoryById($id);
        $teams = $this->model->getTeamsByCategory($id);

        require './app/views/teamsByCategory.phtml';
    }

    public function adminCategories() {
        $categories = $this->model->getCategories();
        require './app/views/adminCategories.phtml';
    }

    public function addCategory() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'] ?? '';
            $imagen_url = $_POST['imagen_url'] ?? null;

            if (!empty($nombre)) {
                $this->model->insertCategory($nombre, $imagen_url);
            }

            header("Location: index.php?action=admin/categorias");
            exit;
        }

        $category = null;
        require './app/views/formCategory.phtml';
    }

    public function editCategory() {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            $this->showError("Categoría no encontrada");
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'] ?? '';
            $imagen_url = $_POST['imagen_url'] ?? null;

            $this->model->updateCategory($id, $nombre, $imagen_url);

            header("Location: index.php?action=admin/categorias");
            exit;
        }

        $category = $this->model->getCategoryById($id);
        require './app/views/formCategory.phtml';
    }

    public function deleteCategory() {
        $id = $_GET['id'] ?? null;

        if ($id) {
            $this->model->deleteCategory($id);
        }

        header("Location: index.php?action=admin/categorias");
        exit;
    }

    public function showError($message) {
        require './app/views/error.phtml';
    }
}