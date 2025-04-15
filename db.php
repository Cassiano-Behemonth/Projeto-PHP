<?php
require_once 'config.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['jogosSimulados'])) {
    $_SESSION['jogosSimulados'] = [
        ['id' => 1, 'nome' => 'The Witcher 3', 'genero' => 'RPG', 'plataforma' => 'PC', 'ano' => 2015],
        ['id' => 2, 'nome' => 'Red Dead Redemption 2', 'genero' => 'Ação/Aventura', 'plataforma' => 'PS4', 'ano' => 2018],
    ];
}

function getJogosSimulados($filtro = []) {
    if (!isset($_SESSION['jogosSimulados'])) {
        return [];
    }
    $resultados = $_SESSION['jogosSimulados'];
    if (!empty($filtro)) {
        $resultados = array_filter($resultados, function ($jogo) use ($filtro) {
            $atendeFiltro = true;
            foreach ($filtro as $chave => $valor) {
                if (isset($jogo[$chave]) && stripos($jogo[$chave], $valor) === false) {
                    $atendeFiltro = false;
                    break;
                }
            }
            return $atendeFiltro;
        });
    }
    return array_values($resultados); 
}

function buscarJogoSimulado($id) {
    if (!isset($_SESSION['jogosSimulados'])) {
        return null;
    }
    foreach ($_SESSION['jogosSimulados'] as $jogo) {
        if ($jogo['id'] == $id) {
            return $jogo;
        }
    }
    return null;
}

function addJogoSimulado($dados) {
    if (!isset($_SESSION['jogosSimulados'])) {
        $_SESSION['jogosSimulados'] = [];
    }
    if (empty(trim($dados['nome'])) || empty(trim($dados['genero'])) || empty(trim($dados['plataforma'])) || empty(trim($dados['ano']))) {
        $_SESSION['msg_erro'] = "Todos os campos são obrigatórios.";
        return false;
    }
    $novoId = count($_SESSION['jogosSimulados']) > 0 ? max(array_column($_SESSION['jogosSimulados'], 'id')) + 1 : 1;
    $_SESSION['jogosSimulados'][] = [
        'id' => $novoId,
        'nome' => trim(htmlspecialchars($dados['nome'])),
        'genero' => trim(htmlspecialchars($dados['genero'])),
        'plataforma' => trim(htmlspecialchars($dados['plataforma'])),
        'ano' => intval($dados['ano'])
    ];
    return true;
}

function atualizarJogoSimulado($dados) {
    if (!isset($_SESSION['jogosSimulados'])) {
        return false;
    }
    if (empty(trim($dados['nome'])) || empty(trim($dados['genero'])) || empty(trim($dados['plataforma'])) || empty(trim($dados['ano']))) {
        $_SESSION['msg_erro'] = "Todos os campos são obrigatórios.";
        return false;
    }
    foreach ($_SESSION['jogosSimulados'] as &$jogo) {
        if ($jogo['id'] == $dados['id']) {
            $jogo['nome'] = trim(htmlspecialchars($dados['nome']));
            $jogo['genero'] = trim(htmlspecialchars($dados['genero']));
            $jogo['plataforma'] = trim(htmlspecialchars($dados['plataforma']));
            $jogo['ano'] = intval($dados['ano']);
            return true;
        }
    }
    return false;
}

function deletarJogoSimulado($id) {
    if (!isset($_SESSION['jogosSimulados'])) {
        return false;
    }
    $indiceExcluir = -1;
    foreach ($_SESSION['jogosSimulados'] as $indice => $jogo) {
        if ($jogo['id'] == $id) {
            $indiceExcluir = $indice;
            break;
        }
    }
    if ($indiceExcluir !== -1) {
        unset($_SESSION['jogosSimulados'][$indiceExcluir]);
        $_SESSION['jogosSimulados'] = array_values($_SESSION['jogosSimulados']); 
        return true;
    }
    return false;
}
?>