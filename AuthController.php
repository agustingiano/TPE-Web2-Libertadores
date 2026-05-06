<?php

class AuthController {
    public function logout() {
        session_start();
        session_destroy();

        header("Location: index.php?action=categorias");
        exit;
    }
}