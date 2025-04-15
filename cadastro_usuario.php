<?php
require_once 'config.php';
require_once 'auth.php';
$paginaAtual = 'Cadastro de Usuário';
require_once 'header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0"><i class="bi bi-person-plus"></i> Criar Conta</h4>
            </div>
            <div class="card-body">
                <?php if (isset($_SESSION['msg_erro'])): ?>
                <div class="alert alert-danger"><?= $_SESSION['msg_erro']; unset($_SESSION['msg_erro']); ?></div>
                <?php endif; ?>
                <?php if (isset($_SESSION['msg_sucesso'])): ?>
                <div class="alert alert-success"><?= $_SESSION['msg_sucesso']; unset($_SESSION['msg_sucesso']); ?></div>
                <?php endif; ?>
                <form method="post" action="processa_cadastro_usuario.php">
                    <div class="mb-3">
                        <label for="usuario" class="form-label">Nome de Usuário</label>
                        <input type="text" class="form-control" id="usuario" name="usuario" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="senha" name="senha" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirmar_senha" class="form-label">Confirmar Senha</label>
                        <input type="password" class="form-control" id="confirmar_senha" name="confirmar_senha" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-person-plus"></i> Cadastrar
                    </button>
                </form>
            </div>
            <div class="card-footer text-center">
                <a href="login.php" class="text-decoration-none">
                    <i class="bi bi-box-arrow-in-right"></i> Já tem uma conta? Entrar
                </a> |
                <a href="index.php" class="text-decoration-none">
                    <i class="bi bi-arrow-left"></i> Voltar ao catálogo
                </a>
            </div>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>