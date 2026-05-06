<?php

require_once './app/controllers/CategoryController.php';
require_once './app/controllers/AuthController.php';

$action = $_GET['action'] ?? 'categorias';

$categoryController = new CategoryController();
$authController = new AuthController();

switch ($action) {

    case 'categorias':
        $categoryController->showCategories();
        break;

    case 'categoria':
        $categoryController->showTeamsByCategory();
        break;

    case 'admin/categorias':
        $categoryController->adminCategories();
        break;

    case 'admin/categorias/agregar':
        $categoryController->addCategory();
        break;

    case 'admin/categorias/editar':
        $categoryController->editCategory();
        break;

    case 'admin/categorias/eliminar':
        $categoryController->deleteCategory();
        break;

    case 'logout':
        $authController->logout();
        break;

    default:
        $categoryController->showError("Página no encontrada");
        break;
}