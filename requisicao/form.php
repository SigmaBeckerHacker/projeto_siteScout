<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: ../login.php');
    exit;
}

require_once __DIR__ . '/../src/conexao-bd.php';
require_once __DIR__ . '/../src/Modelo/Requisicao.php';
require_once __DIR__ . '/../src/Repositorio/RequisicaoRepositorio.php';

$repoReq = new RequisicaoRepositorio($pdo);

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$modoEdicao = false;
$requisicao = null;

if ($id) {
    $requisicao = $repoReq->buscarPorId($id);

    if ($requisicao) {
        $modoEdicao = true;
    } else {
        header("Location: listar-minhas-requisicoes.php?erro=notfound");
        exit;
    }
}

$valorId        = $modoEdicao ? $requisicao->getId() : '';
$valorData      = $modoEdicao ? $requisicao->getData() : '';
$valorDist      = $modoEdicao ? $requisicao->getDistintivo() : ''; 

$tituloPagina  = $modoEdicao ? "Editar Requisição" : "Cadastrar Requisição";
$textoBotao    = $modoEdicao ? "Salvar Alterações" : "Cadastrar Requisição";
$actionForm    = "salvar-requisicao.php";
$listTarget = (!empty($_SESSION['permissoes']) && in_array('todasrequisicoes.listar', $_SESSION['permissoes'])) ? 'listar-todas-requisicoes.php' : 'listar-minhas-requisicoes.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?= $tituloPagina ?></title>

    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/cadastroEscoteiro.css">
</head>

<body>
    <main>

        <section class="container-admin-banner">
            <img src="../img/logo-escoteiros.png" class="logo-admin" alt="logo">
            <h1><?= $tituloPagina ?></h1>
        </section>

        <section class="container-form">

            <?php if (isset($_GET['erro']) && $_GET['erro'] === 'campos'): ?>
                <p class="mensagem-erro">Preencha todos os campos.</p>
            <?php endif; ?>

            <form action="<?= $actionForm ?>" method="POST">

                <?php if ($modoEdicao): ?>
                    <input type="hidden" name="id_original" value="<?= $valorId ?>">
                <?php endif; ?>

                <label for="distintivo">Distintivo</label>
                <input type="text" name="distintivo" id="distintivo" placeholder="Informe o nome do distintivo"
                       value="<?= htmlspecialchars($valorDist) ?>">

                <div class="action-row">
                    <input class="botao-cadastrar" type="submit" value="<?= $textoBotao ?>">
                    <button type="button" class="botao-cancelar" onclick="window.location.href='<?= $listTarget ?>'">Cancelar</button>
                </div>

            </form>
        </section>
    </main>

</body>
</html>