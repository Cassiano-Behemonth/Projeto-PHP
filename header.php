<?php
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= SITE_NOME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    </head>
<body>
    <header class="bg-dark text-white py-3">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h1><a href="index.php" class="text-white text-decoration-none"><?= SITE_NOME ?></a></h1>
                <div>
                    <?php if (estaLogado()): ?>
                        <span class="me-3">Olá, <?= htmlspecialchars($_SESSION['usuario']) ?></span>
                        <a href="logout.php" class="btn btn-danger"><i class="bi bi-box-arrow-right"></i> Sair</a>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-primary me-2"><i class="bi bi-box-arrow-in-right"></i> Entrar</a>
                        <a href="cadastro_usuario.php" class="btn btn-secondary"><i class="bi bi-person-plus"></i> Cadastrar</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>
    <div class="container mt-4">