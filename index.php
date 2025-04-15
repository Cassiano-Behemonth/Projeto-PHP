    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $paginaAtual ?? 'Catálogo de Jogos' ?></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="css/estilos.css">
        <style>
            body {
                background-image: url('img/background.jpg');
                background-repeat: no-repeat;
                background-size: cover;
                background-attachment: fixed;
                color:black; 
            }

            .container {
                background-color: transparent; 
                padding: 20px;
                border-radius: 10px;
                margin-top: 20px;
                margin-bottom: 20px;
            }

            h2{
                color: white !important; 
            }


            .col-auto p.text-muted {
                color: white !important; 
            }
        </style>
    </head>
    <body>

    <?php
    require_once 'config.php';
    require_once 'auth.php';
    require_once 'header.php';
    require_once 'db.php'; 

    $paginaAtual = 'Catálogo de Jogos';
    $acao = $_GET['acao'] ?? '';
    $idEditar = $_GET['id'] ?? null;
    $idDeletar = $_GET['deletar'] ?? null;
    $mensagemErro = $_SESSION['msg_erro'] ?? null;
    unset($_SESSION['msg_erro']);
    $mensagemSucesso = $_SESSION['msg_sucesso'] ?? null;
    unset($_SESSION['msg_sucesso']);

    $jogoParaEditar = null;
    if ($acao === 'editar_jogo' && estaLogado() && $idEditar) {
        $jogoParaEditar = buscarJogoSimulado($idEditar);
        if (!$jogoParaEditar) {
            $_SESSION['msg_erro'] = "Jogo não encontrado para edição.";
            header('Location: index.php');
            exit;
        }
    }

    if ($acao === 'excluir_jogo' && estaLogado() && $idDeletar) {
        if (deletarJogoSimulado($idDeletar)) {
            $_SESSION['msg_sucesso'] = "Jogo excluído com sucesso!";
        } else {
            $_SESSION['msg_erro'] = "Erro ao excluir o jogo. Tente novamente.";
        }
        header('Location: index.php');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome = $_POST['nome'] ?? '';
        $genero = $_POST['genero'] ?? '';
        $plataforma = $_POST['plataforma'] ?? '';
        $ano = $_POST['ano'] ?? '';

        $dadosJogo = [
            'nome' => $nome,
            'genero' => $genero,
            'plataforma' => $plataforma,
            'ano' => $ano
        ];

        if (empty($nome) || empty($genero) || empty($plataforma) || empty($ano)) {
            $mensagemErro = "Todos os campos são obrigatórios.";
        } else {
            if ($acao === 'cadastrar_jogo' && !isset($_POST['id'])) {
                if (addJogoSimulado($dadosJogo)) {
                    $mensagemSucesso = "Jogo cadastrado com sucesso!";
                    $acao = ''; 
                } else {
                    $mensagemErro = "Erro ao cadastrar o jogo. Tente novamente.";
                }
            } elseif ($acao === 'cadastrar_jogo' && isset($_POST['id'])) { 
                $dadosJogo['id'] = $_POST['id'];
                if (atualizarJogoSimulado($dadosJogo)) {
                    $mensagemSucesso = "Jogo atualizado com sucesso!";
                    $acao = ''; 
                } else {
                    $mensagemErro = "Erro ao atualizar o jogo. Tente novamente.";
                }
            }
        }
    }

    $filtro = [];
    if (isset($_GET['genero'])) $filtro['genero'] = $_GET['genero'];
    if (isset($_GET['plataforma'])) $filtro['plataforma'] = $_GET['plataforma'];
    $jogos = getJogosSimulados($filtro);
    ?>

    <div class="row mb-4">
        <div class="col">
            <h2 class="display-6">Catálogo de Jogos</h2>
        </div>
        <?php if (estaLogado()): ?>
        <div class="col-auto">
            <a href="index.php?acao=cadastrar_jogo" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Adicionar Jogo
            </a>
        </div>
        <?php else: ?>
        <div class="col-auto">
            <p class="text-muted">Faça <a href="login.php">login</a> ou <a href="cadastro_usuario.php">cadastre-se</a> para adicionar jogos.</p>
        </div>
        <?php endif; ?>
    </div>

    <?php if ($mensagemErro): ?>
        <div class="alert alert-danger"><?= $mensagemErro ?></div>
    <?php endif; ?>
    <?php if ($mensagemSucesso): ?>
        <div class="alert alert-success"><?= $mensagemSucesso ?></div>
    <?php endif; ?>

    <?php if (($acao === 'cadastrar_jogo' && estaLogado())): ?>
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Cadastrar Novo Jogo</h5>
            </div>
            <div class="card-body">
                <form method="post" action="index.php?acao=cadastrar_jogo" id="jogoForm">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome do Jogo</label>
                        <input type="text" class="form-control" id="nome" name="nome" value="" required>
                    </div>
                    <div class="mb-3">
                        <label for="genero" class="form-label">Gênero</label>
                        <input type="text" class="form-control" id="genero" name="genero" value="" required>
                    </div>
                    <div class="mb-3">
                        <label for="plataforma" class="form-label">Plataforma</label>
                        <input type="text" class="form-control" id="plataforma" name="plataforma" value="" required>
                    </div>
                    <div class="mb-3">
                        <label for="ano" class="form-label">Ano de Lançamento</label>
                        <input type="number" class="form-control" id="ano" name="ano" value="" required min="1950" max="<?= date('Y') ?>">
                    </div>
                    <div id="capa_preview" class="mb-3">
                        </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="index.php" class="btn btn-outline-secondary me-md-2">
                            <i class="bi bi-x-circle"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Salvar Jogo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <?php if (($acao === 'editar_jogo' && estaLogado() && $jogoParaEditar)): ?>
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Editar Jogo</h5>
            </div>
            <div class="card-body">
                <form method="post" action="index.php?acao=cadastrar_jogo" id="jogoForm">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($jogoParaEditar['id']) ?>">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome do Jogo</label>
                        <input type="text" class="form-control" id="nome" name="nome" value="<?= htmlspecialchars($jogoParaEditar['nome'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="genero" class="form-label">Gênero</label>
                        <input type="text" class="form-control" id="genero" name="genero" value="<?= htmlspecialchars($jogoParaEditar['genero'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="plataforma" class="form-label">Plataforma</label>
                        <input type="text" class="form-control" id="plataforma" name="plataforma" value="<?= htmlspecialchars($jogoParaEditar['plataforma'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="ano" class="form-label">Ano de Lançamento</label>
                        <input type="number" class="form-control" id="ano" name="ano" value="<?= htmlspecialchars($jogoParaEditar['ano'] ?? '') ?>" required min="1950" max="<?= date('Y') ?>">
                    </div>
                    <div id="capa_preview" class="mb-3">
                        <?php if ($acao === 'editar_jogo' && $jogoParaEditar['nome']): ?>
                            <img id="preview_capa" src="" alt="Capa do Jogo" style="max-width: 200px;">
                            <script>
                                buscarCapaEdicao('<?= htmlspecialchars($jogoParaEditar['nome']) ?>');
                            </script>
                        <?php endif; ?>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="index.php" class="btn btn-outline-secondary me-md-2">
                            <i class="bi bi-x-circle"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Salvar Alterações
                        </button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php if (!empty($jogos) && $acao !== 'cadastrar_jogo' && $acao !== 'editar_jogo'): ?>
            <?php foreach ($jogos as $jogo): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div id="capa_card_<?= $jogo['id'] ?>" class="card-img-top" style="height: 200px; background-color: #f0f0f0; display: flex; justify-content: center; align-items: center;">
                            <div class="spinner-border spinner-border-sm" role="status">
                                <span class="visually-hidden">Carregando...</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($jogo['nome']) ?></h5>
                            <div class="card-text">
                                <span class="badge bg-info text-dark mb-2"><?= htmlspecialchars($jogo['genero']) ?></span>
                                <p><strong>Plataforma:</strong> <?= htmlspecialchars($jogo['plataforma']) ?></p>
                                <p><strong>Ano:</strong> <?= htmlspecialchars($jogo['ano']) ?></p>
                            </div>
                            <?php if (estaLogado()): ?>
                            <div class="card-footer bg-white">
                                <a href="index.php?acao=editar_jogo&id=<?= $jogo['id'] ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i> Editar</a>
                                <form method="post" action="index.php?acao=excluir_jogo&deletar=<?= $jogo['id'] ?>" class="d-inline">
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirmarExclusao(<?= $jogo['id'] ?>)"><i class="bi bi-trash"></i> Excluir</button>
                                </form>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <script>
                        function buscarECarregarCapaCard_<?= $jogo['id'] ?>() {
                            const nomeJogo = '<?= htmlspecialchars($jogo['nome']) ?>';
                            const apiKey = 'b5406e9c5aa840efa8f30feddbde9a99'; 
                            const capaCardElement = document.getElementById('capa_card_<?= $jogo['id'] ?>');
                            const apiUrl = `https://api.rawg.io/api/games?key=${apiKey}&search=${encodeURIComponent(nomeJogo)}`;

                            fetch(apiUrl)
                                .then(response => response.json())
                                .then(data => {
                                    capaCardElement.innerHTML = '';
                                    if (data.results && data.results.length > 0 && data.results[0].background_image) {
                                        const img = document.createElement('img');
                                        img.src = data.results[0].background_image;
                                        img.style.height = '200px';
                                        img.style.objectFit = 'cover';
                                        img.alt = `Capa de ${nomeJogo}`;
                                        capaCardElement.appendChild(img);
                                    } else {
                                        capaCardElement.innerText = 'Sem Capa';
                                        capaCardElement.style.display = 'flex';
                                        capaCardElement.style.justifyContent = 'center';
                                        capaCardElement.style.alignItems = 'center';
                                        capaCardElement.style.color = '#888';
                                    }
                                })
                                .catch(error => {
                                    console.error('Erro ao buscar capa:', error);
                                    capaCardElement.innerText = 'Erro ao carregar a capa.';
                                    capaCardElement.style.display = 'flex';
                                    capaCardElement.style.justifyContent = 'center';
                                    capaCardElement.style.alignItems = 'center';
                                    capaCardElement.style.color = '#dc3545';
                                });
                        }

                        buscarECarregarCapaCard_<?= $jogo['id'] ?>();
                    </script>
                </div>
            <?php endforeach; ?>
        <?php elseif ($acao !== 'cadastrar_jogo' && $acao !== 'editar_jogo'): ?>
            <div class="col">
                <div class="alert alert-warning">Nenhum jogo encontrado no catálogo.</div>
            </div>
        <?php endif; ?>
    </div>


    <script>
        function confirmarExclusao(id) {
            if (confirm("Tem certeza que deseja excluir este jogo?")) {
                window.location.href = "index.php?acao=excluir_jogo&deletar=" + id;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const capaPreviewDiv = document.getElementById('capa_preview');
            if (capaPreviewDiv && window.location.search.includes('acao=editar_jogo')) {
                capaPreviewDiv.innerHTML = '';
            }
        });
    </script>
    </body>
    </html
    <?php require_once 'footer.php'; ?>