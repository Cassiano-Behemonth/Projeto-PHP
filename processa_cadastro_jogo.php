<?php

require_once '../includes/auth.php';
require_once '../includes/db.php';
require_once '../includes/config.php';

if (!estaLogado()) {
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [
        'nome' => $_POST['nome'] ?? '',
        'genero' => $_POST['genero'] ?? '',
        'plataforma' => $_POST['plataforma'] ?? '',
        'ano' => $_POST['ano'] ?? ''
    ];

    
    if (empty($dados['nome']) || empty($dados['genero']) || empty($dados['plataforma']) || empty($dados['ano'])) {
        $_SESSION['msg_erro'] = "Todos os campos são obrigatórios.";
        header('Location: cadastrar_jogo.php');
        exit;
    }

    if (addJogo($dados)) {
        $_SESSION['msg_sucesso'] = "Jogo cadastrado com sucesso!";
        header('Location: /Ver1/index.php'); 
        exit;
    } else {
        $_SESSION['msg_erro'] = "Erro ao cadastrar o jogo. Tente novamente.";
        header('Location: cadastrar_jogo.php');
        exit;
    }
} else {
    
    header('Location: cadastrar_jogo.php');
    exit;
}
?>