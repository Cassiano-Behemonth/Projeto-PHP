<?php
require_once 'config.php';
require_once 'auth.php';

if (estaLogado()) {
    header('Location: index.php'); 
    exit;
}

$paginaAtual = 'Login';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if (fazerLogin($usuario, $senha)) {
        header('Location: index.php'); 
        exit;
    } else {
        $erro = "Usuário ou senha inválidos.";
    }
}

require_once 'header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="bi bi-box-arrow-in-right"></i> Acesso</h4>
            </div>
            <div class="card-body">
                <?php if (isset($erro)): ?>
                <div class="alert alert-danger"><?= $erro ?></div>
                <?php endif; ?>

                <form method="post">
                    <div class="mb-3">
                        <label for="usuario" class="form-label">Usuário</label>
                        <input type="text" class="form-control" id="usuario" name="usuario" required>
                    </div>
                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="senha" name="senha" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-box-arrow-in-right"></i> Entrar
                    </button>
                </form>
            </div>
            <div class="card-footer text-center">
                <a href="index.php" class="text-decoration-none">
                    <i class="bi bi-arrow-left"></i> Voltar ao catálogo
                </a> |
                <a href="cadastro_usuario.php" class="text-decoration-none">
                    <i class="bi bi-person-plus"></i> Cadastrar-se
                </a>
            </div>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>