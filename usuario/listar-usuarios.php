<?php
session_start();

if(!isset($_SESSION['usuario'])){
    header('Location: login.php');
    exit;
}

$usuarioLogado = $_SESSION['usuario'];

require_once __DIR__ . '/../src/conexao-bd.php';
require_once __DIR__ . '/../src/Repositorio/UsuarioRepositorio.php';
require_once __DIR__ . '/../src/Modelo/Usuario.php';

$repo = new UsuarioRepositorio($pdo);

 
$page = max(1, intval($_GET['page'] ?? 1));
$perPage = max(1, min(100, intval($_GET['per_page'] ?? 10)));
$sort = $_GET['sort'] ?? 'nome';
$order = strtoupper($_GET['order'] ?? 'ASC') === 'DESC' ? 'DESC' : 'ASC';

$total = $repo->contarTodos();
$offset = ($page - 1) * $perPage;
$usuarios = $repo->buscarTodos($perPage, $offset, $sort, $order);

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
    <title>Usuario - Admin</title>
</head>

<body>
<main>

   

    <section class="container-admin-banner">
        <img src="../img/logo-escoteiros.png" class="logo-admin" alt="logo-escoteiro">
        <h1>Administração Usuarios</h1>
    </section>

    <section class="container-table">
        <table>
            <thead>
                <tr>
                    <th><a href="<?= buildQuery(['sort' => 'registro', 'order' => ($sort === 'registro' && $order === 'ASC') ? 'DESC' : 'ASC', 'page' => 1]) ?>">Registro</a></th>
                    <th><a href="<?= buildQuery(['sort' => 'nome', 'order' => ($sort === 'nome' && $order === 'ASC') ? 'DESC' : 'ASC', 'page' => 1]) ?>">Nome</a></th>
                    <th><a href="<?= buildQuery(['sort' => 'funcao', 'order' => ($sort === 'funcao' && $order === 'ASC') ? 'DESC' : 'ASC', 'page' => 1]) ?>">Funcao</a></th>
                    <th><a href="<?= buildQuery(['sort' => 'email', 'order' => ($sort === 'email' && $order === 'ASC') ? 'DESC' : 'ASC', 'page' => 1]) ?>">Email</a></th>
                    <th colspan="2">Ação</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($usuarios as $usuario): ?>
                    <tr>
                        <td><?= htmlspecialchars($usuario->getRegistro()) ?></td>
                        <td><?= htmlspecialchars($usuario->getNome()) ?></td>
                        <td><?= htmlspecialchars($usuario->getFuncao()) ?></td>
                        <td><?= htmlspecialchars($usuario->getEmail()) ?></td>
                        <td>
                            <a class="botao-editar"
                               href="form.php?registro=<?= urlencode($usuario->getRegistro()) ?>">
                               Editar
                            </a>
                        </td>

                        <td>
                            <form method="POST" action="excluir-usuario.php">
                                <input type="hidden" name="registro"
                                       value="<?= htmlspecialchars($usuario->getRegistro()) ?>">
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
            <a href="form.php" class="botao-cadastrar">Cadastrar usuario</a>
            <a href="../dashboard.php" class="botao-voltar">Voltar</a>
        </div>

    </section>
</main>
</body>
</html>