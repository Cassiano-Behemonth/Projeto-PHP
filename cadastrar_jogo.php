<?php
require_once 'auth.php';
require_once 'db.php';

if (!estaLogado()) {
    header('Location: ../login.php');
    exit;
}

$paginaAtual = 'Cadastrar Jogo';
require_once '../includes/header.php';
?>

<div class="row">
    <div class="col-md-3">
        <div class="list-group">
            <a href="../admin/dashboard.php" class="list-group-item list-group-item-action">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="cadastrar_jogo.php" class="list-group-item list-group-item-action active">
                <i class="bi bi-plus-circle"></i> Cadastrar Jogo</a>
            <a href="sair.php" class="list-group-item list-group-item-action text-danger">
                <i class="bi bi-box-arrow-right"></i> Sair
            </a>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Cadastrar Novo Jogo</h5>
            </div>
            <div class="card-body">
                <form method="post" action="processa_cadastro_jogo.php">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome do Jogo</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>

                    <div class="mb-3">
                        <label for="genero" class="form-label">Gênero</label>
                        <input type="text" class="form-control" id="genero" name="genero" required>
                    </div>

                    <div class="mb-3">
                        <label for="plataforma" class="form-label">Plataforma</label>
                        <input type="text" class="form-control" id="plataforma" name="plataforma" required>
                    </div>

                    <div class="mb-3">
                        <label for="ano" class="form-label">Ano de Lançamento</label>
                        <input type="number" class="form-control" id="ano" name="ano" required min="1950" max="<?= date('Y') ?>">
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="../../index.php" class="btn btn-outline-secondary me-md-2">
                            <i class="bi bi-x-circle"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Salvar Jogo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>