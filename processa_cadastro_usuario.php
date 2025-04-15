<?php


require_once 'config.php';
require_once 'auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $confirmar_senha = $_POST['confirmar_senha'] ?? '';


    if (empty($usuario) || empty($email) || empty($senha) || empty($confirmar_senha)) {
        $_SESSION['msg_erro'] = "Todos os campos são obrigatórios.";
        header('Location: cadastro_usuario.php');
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['msg_erro'] = "Formato de email inválido.";
        header('Location: cadastro_usuario.php');
        exit;
    }

    if ($senha !== $confirmar_senha) {
        $_SESSION['msg_erro'] = "As senhas não coincidem.";
        header('Location: cadastro_usuario.php');
        exit;
    }

 
    if (registrarUsuario($usuario, $senha, $email)) {
        $_SESSION['msg_sucesso'] = "Cadastro realizado com sucesso! Você foi logado.";
        header('Location: index.php'); 
        exit;
    } else {
        $_SESSION['msg_erro'] = "Nome de usuário já existe. Escolha outro.";
        header('Location: cadastro_usuario.php');
        exit;
    }

} else {
   
    header('Location: cadastro_usuario.php');
    exit;
}
?>