<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: ../login.php');
    exit;
}

require_once __DIR__ . '/../src/conexao-bd.php';
require_once __DIR__ . '/../src/Modelo/Requisicao.php';
require_once __DIR__ . '/../src/Modelo/Distintivo.php';
require_once __DIR__ . '/../src/Repositorio/RequisicaoRepositorio.php';
require_once __DIR__ . '/../src/Repositorio/DistintivoRepositorio.php';

$repoReq = new RequisicaoRepositorio($pdo);
$repoDist = new DistintivoRepositorio($pdo);

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$modoEdicao = false;
$requisicao = null;

if ($id) {
    $requisicao = $repoReq->buscarPorId($id);

    if ($requisicao) {
        $modoEdicao = true;
    } else {
        header("Location: listar-requisicoes.php?erro=notfound");
        exit;
    }
}

$valorId        = $modoEdicao ? $requisicao->getId() : '';
$valorData      = $modoEdicao ? $requisicao->getData() : '';
$valorStatus    = $modoEdicao ? $requisicao->getStatus() : '';
$valorDist      = $modoEdicao ? $requisicao->getDistintivo() : ''; 

$todosDist = $repoDist->buscarTodos();

$tituloPagina  = $modoEdicao ? "Editar Requisição" : "Cadastrar Requisição";
$textoBotao    = $modoEdicao ? "Salvar Alterações" : "Cadastrar Requisição";
$actionForm    = "salvar-requisicao.php";
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
                <select name="distintivo" id="distintivo">
                    <option value="">Selecione...</option>

                    <?php foreach ($todosDist as $d): ?>
                        <?php $nome = $d->getNome(); ?>
                        <option value="<?= htmlspecialchars($nome) ?>"
                            <?= $valorDist === $nome ? 'selected' : '' ?>>
                            <?= htmlspecialchars($nome) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="data_requisicao">Data da Requisição</label>
                <input type="date" name="data_requisicao" id="data_requisicao"
                       value="<?= htmlspecialchars($valorData) ?>">

                <label for="status">Status</label>
                <select name="status" id="status">
                    <option value="pendente"   <?= $valorStatus === 'pendente' ? 'selected' : '' ?>>Pendente</option>
                    <option value="aprovada"   <?= $valorStatus === 'aprovada' ? 'selected' : '' ?>>Aprovada</option>
                    <option value="rejeitada"  <?= $valorStatus === 'rejeitada' ? 'selected' : '' ?>>Rejeitada</option>
                </select>

                <input class="botao-cadastrar" type="submit" value="<?= $textoBotao ?>">

            </form>
        </section>
    </main>

</body>
</html>