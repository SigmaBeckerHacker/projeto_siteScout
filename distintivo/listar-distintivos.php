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
$distintivos = $repo->buscarTodos();
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

    <section class="container-topo">
        <div class="topo-direita">
            <p>Bem vindo, <strong><?= htmlspecialchars($usuarioLogado) ?></strong></p>
            <form action="logout.php" method="POST">
                <button type="submit" class="botao-sair">Sair</button>
            </form>
        </div>
    </section>

    <section class="container-admin-banner">
        <img src="../img/logo-escoteiros.png" class="logo-admin" alt="logo-escoteiro">
        <h1>Administração - Distintivos</h1>
    </section>

    <section class="container-table">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Imagem</th>
                    <th>Nome</th>
                    <th>Quantidade</th>
                    <th>Categoria</th>
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

        <a href="form.php" class="botao-cadastrar">Cadastrar distintivo</a>

    </section>
</main>
</body>
</html>