<?php
require_once '../includes/auth.php';

if (!estaLogado()) {
    header('Location: ../login.php');
    exit;
}

$paginaAtual = 'Painel Admin';
require_once '../includes/header.php';
?>

<div class="row">
    <div class="col-md-3">
        <div class="list-group">
            <a href="dashboard.php" class="list-group-item list-group-item-action active">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="../usuario/cadastrar_jogo.php" class="list-group-item list-group-item-action">
                <i class="bi bi-plus-circle"></i> Cadastrar Jogo
            </a>
            <a href="sair.php" class="list-group-item list-group-item-action text-danger">
                <i class="bi bi-box-arrow-right"></i> Sair
            </a>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Bem-vindo, <?= $_SESSION['usuario'] ?>!</h5>
            </div>
            <div class="card-body">
                <p>Você está na área administrativa do catálogo de jogos.</p>

                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> Aqui você pode gerenciar todos os jogos do catálogo.
                </div>

                <a href="../index.php" class="btn btn-outline-primary">
                    <i class="bi bi-eye"></i> Ver Catálogo Público
                </a>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>