<?php
session_start();

if(!isset($_SESSION['usuario'])){
    header('Location: login.php');
    exit;
}

$usuarioLogadoEmail = $_SESSION['usuario'];

require_once __DIR__ . '/../src/conexao-bd.php';
require_once __DIR__ . '/../src/Repositorio/RequisicaoRepositorio.php';
require_once __DIR__ . '/../src/Repositorio/UsuarioRepositorio.php';
require_once __DIR__ . '/../src/Modelo/Requisicao.php';
require_once __DIR__ . '/../src/Modelo/Usuario.php';

$repoReq = new RequisicaoRepositorio($pdo);
$repoUsuario = new UsuarioRepositorio($pdo);

$usuario = $repoUsuario->buscarPorEmail(trim($usuarioLogadoEmail));

// Pagination & sorting params
if (!$usuario) {
    // Usuário não encontrado: redireciona para login para evitar acesso indevido
    header('Location: login.php');
    exit;
}




$page = max(1, intval($_GET['page'] ?? 1));
$perPage = max(1, min(100, intval($_GET['per_page'] ?? 10)));
$sort = $_GET['sort'] ?? 'data_requisicao';
$order = strtoupper($_GET['order'] ?? 'DESC') === 'ASC' ? 'ASC' : 'DESC';

$total = $repoReq->contarPorRegistroChefe($usuario->getRegistro());
$offset = ($page - 1) * $perPage;
$requisicoes = $repoReq->buscarPorRegistroChefe($usuario->getRegistro(), $perPage, $offset, $sort, $order);

function buildQuery(array $overrides = []): string
{
    $params = array_merge($_GET, $overrides);
    return '?' . http_build_query($params);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/listar-escoteiros.css">
    <title>Escoteiro - Admin</title>
</head>

<body>
<main>


    <section class="container-admin-banner">
        <img src="../img/logo-escoteiros.png" class="logo-admin" alt="logo-escoteiro">
        <h1>Minhas Requisições</h1>
    </section>

    <section class="container-table">
        <table>
            <thead>
                <tr>
                    <th><a href="<?= buildQuery(['sort' => 'distintivo', 'order' => ($sort === 'distintivo' && $order === 'ASC') ? 'DESC' : 'ASC', 'page' => 1]) ?>">Distintivo</a></th>
                    <th><a href="<?= buildQuery(['sort' => 'data_requisicao', 'order' => ($sort === 'data_requisicao' && $order === 'ASC') ? 'DESC' : 'ASC', 'page' => 1]) ?>">Data Requisição</a></th>
                    <th colspan="2">Ação</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($requisicoes as $req): ?>
                    <tr>
                        <td><?= htmlspecialchars($req->getDistintivo()) ?></td>
                        <td><?= htmlspecialchars($req->getData()) ?></td>

                        <td>
                            <a class="botao-editar" href="form.php?id=<?= urlencode($req->getId()) ?>">
                               Editar
                            </a>
                        </td>

                        <td>
                            <form method="POST" action="excluir-requisicao.php">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($req->getId()) ?>">
                                <input type="submit" value="Excluir" class="botao-excluir">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="pagination">
            <?php $totalPages = max(1, (int)ceil($total / $perPage)); ?>
            <?php if ($page > 1): ?>
                <a href="<?= buildQuery(['page' => $page - 1]) ?>">&laquo; Anterior</a>
            <?php endif; ?>
            <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                <?php if ($p == $page): ?>
                    <strong><?= $p ?></strong>
                <?php else: ?>
                    <a href="<?= buildQuery(['page' => $p]) ?>"><?= $p ?></a>
                <?php endif; ?>
            <?php endfor; ?>
            <?php if ($page < $totalPages): ?>
                <a href="<?= buildQuery(['page' => $page + 1]) ?>">Próxima &raquo;</a>
            <?php endif; ?>
        </div>

        <div class="action-list" style="margin-top:20px;">
            <a href="form.php" class="botao-cadastrar">Cadastrar Requisição</a>
            <a href="../dashboard.php" class="botao-voltar">Voltar</a>
        </div>

    </section>
</main>
</body>
</html>