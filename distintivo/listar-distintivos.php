<?php
session_start();

if(!isset($_SESSION['usuario'])){
    header('Location: login.php');
    exit;
}

$usuarioLogado = $_SESSION['usuario'];

require_once __DIR__ . '/../src/conexao-bd.php';
require_once __DIR__ . '/../src/Repositorio/DistintivoRepositorio.php';
require_once __DIR__ . '/../src/Modelo/Distintivo.php';

$repo = new DistintivoRepositorio($pdo);

// Pagination and sorting
$page = max(1, intval($_GET['page'] ?? 1));
$perPage = max(1, min(100, intval($_GET['per_page'] ?? 10)));
$sort = $_GET['sort'] ?? 'nome_distintivo';
$order = strtoupper($_GET['order'] ?? 'ASC') === 'DESC' ? 'DESC' : 'ASC';

$total = $repo->contarTodos();
$offset = ($page - 1) * $perPage;
$distintivos = $repo->buscarTodos($perPage, $offset, $sort, $order);

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
   
    <title>Distintivos - Admin</title>
</head>

<body>
<main>
    <section class="container-admin-banner">
        <img src="../img/logo-escoteiros.png" class="logo-admin" alt="logo-escoteiro">
        <h1>Administração - Distintivos</h1>
    </section>

    <section class="container-table">
        <table>
            <thead>
                <tr>
                    <th><a href="<?= buildQuery(['sort' => 'id_distintivo', 'order' => ($sort === 'id_distintivo' && $order === 'ASC') ? 'DESC' : 'ASC', 'page' => 1]) ?>">ID</a></th>
                    <th>Imagem</th>
                    <th><a href="<?= buildQuery(['sort' => 'nome_distintivo', 'order' => ($sort === 'nome_distintivo' && $order === 'ASC') ? 'DESC' : 'ASC', 'page' => 1]) ?>">Nome</a></th>
                    <th><a href="<?= buildQuery(['sort' => 'quantidade', 'order' => ($sort === 'quantidade' && $order === 'ASC') ? 'DESC' : 'ASC', 'page' => 1]) ?>">Quantidade</a></th>
                    <th><a href="<?= buildQuery(['sort' => 'categoria_distintivo', 'order' => ($sort === 'categoria_distintivo' && $order === 'ASC') ? 'DESC' : 'ASC', 'page' => 1]) ?>">Categoria</a></th>
                    <th colspan="2">Ação</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($distintivos as $d): ?>
                    <tr>
                        <td><?= htmlspecialchars($d->getId()) ?></td>

                        <td>
                            <?php if ($d->getImagem()): ?>
                                <img src="../uploads/distintivos/<?= htmlspecialchars($d->getImagem()) ?>"
                                     alt="imagem distintivo"
                                     style="width: 60px; height: 60px; object-fit: cover; border-radius: 6px;">
                            <?php else: ?>
                                <span>Sem imagem</span>
                            <?php endif; ?>
                        </td>

                        <td><?= htmlspecialchars($d->getNome()) ?></td>
                        <td><?= htmlspecialchars($d->getQuantidade()) ?></td>
                        <td><?= htmlspecialchars($d->getCategoria()) ?></td>

                        <td>
                            <a class="botao-editar"
                               href="form.php?id=<?= urlencode($d->getId()) ?>">
                               Editar
                            </a>
                        </td>

                        <td>
                            <form method="POST" action="excluir-distintivo.php">
                                <input type="hidden" name="id"
                                       value="<?= htmlspecialchars($d->getId()) ?>">
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
            <a href="form.php" class="botao-cadastrar">Cadastrar distintivo</a>
            <a href="../dashboard.php" class="botao-voltar">Voltar</a>
        </div>

    </section>
</main>
</body>
</html>