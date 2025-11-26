<?php
session_start();

if(!isset($_SESSION['usuario'])){
    header('Location: login.php');
    exit;
}

$usuarioLogado = $_SESSION['usuario'];

require_once __DIR__ . '/../src/conexao-bd.php';
require_once __DIR__ . '/../src/Repositorio/EscoteiroRepositorio.php';
require_once __DIR__ . '/../src/Modelo/Escoteiro.php';

$repo = new EscoteiroRepositorio($pdo);

// Pagination and sorting
$page = max(1, intval($_GET['page'] ?? 1));
$perPage = max(1, min(100, intval($_GET['per_page'] ?? 10)));
$sort = $_GET['sort'] ?? 'nome';
$order = strtoupper($_GET['order'] ?? 'ASC') === 'DESC' ? 'DESC' : 'ASC';

$total = $repo->contarTodos();
$offset = ($page - 1) * $perPage;
$escoteiros = $repo->buscarTodos($perPage, $offset, $sort, $order);

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
        <h1>Administração Escoteiros</h1>
    </section>

    <section class="container-table">
        <table>
            <thead>
                <tr>
                    <th><a href="<?= buildQuery(['sort' => 'registro', 'order' => ($sort === 'registro' && $order === 'ASC') ? 'DESC' : 'ASC', 'page' => 1]) ?>">Registro</a></th>
                    <th><a href="<?= buildQuery(['sort' => 'nome', 'order' => ($sort === 'nome' && $order === 'ASC') ? 'DESC' : 'ASC', 'page' => 1]) ?>">Nome</a></th>
                    <th><a href="<?= buildQuery(['sort' => 'ramo', 'order' => ($sort === 'ramo' && $order === 'ASC') ? 'DESC' : 'ASC', 'page' => 1]) ?>">Ramo</a></th>
                    <th colspan="2">Ação</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($escoteiros as $escoteiro): ?>
                    <tr>
                        <td><?= htmlspecialchars($escoteiro->getRegistro()) ?></td>
                        <td><?= htmlspecialchars($escoteiro->getNome()) ?></td>
                        <td><?= htmlspecialchars($escoteiro->getRamo()) ?></td>

                        <td>
                            <a class="botao-editar"
                               href="form.php?registro=<?= urlencode($escoteiro->getRegistro()) ?>">
                               Editar
                            </a>
                        </td>

                        <td>
                            <form method="POST" action="excluir-escoteiro.php">
                                <input type="hidden" name="registro"
                                       value="<?= htmlspecialchars($escoteiro->getRegistro()) ?>">
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
            <a href="form.php" class="botao-cadastrar">Cadastrar escoteiro</a>
            <a href="../dashboard.php" class="botao-voltar">Voltar</a>
        </div>

    </section>
</main>
</body>
</html>