<?php

require_once 'config.php';

function estaLogado() {
    return isset($_SESSION['usuario']);
}

function registrarUsuario($usuario, $senha, $email) {
    if (!isset($_SESSION['usuarios_cadastrados'])) {
        $_SESSION['usuarios_cadastrados'] = [];
    }
    if (!isset($_SESSION['usuarios_cadastrados'][$usuario])) {
        $_SESSION['usuarios_cadastrados'][$usuario] = password_hash($senha, PASSWORD_DEFAULT);
        $_SESSION['usuario'] = $usuario; 
        return true;
    }
    return false; 
}

function fazerLogin($usuario, $senha) {
    if (isset($_SESSION['usuarios_cadastrados'][$usuario]) && password_verify($senha, $_SESSION['usuarios_cadastrados'][$usuario])) {
        $_SESSION['usuario'] = $usuario;
        return true;
    }
    return false;
}

function fazerLogout() {
    unset($_SESSION['usuario']); 
    header('Location: index.php');
    exit;
}