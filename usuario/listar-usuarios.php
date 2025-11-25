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
$usuarios = $repo->buscarTodos();
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
        <h1>Administração Usuarios</h1>
    </section>

    <section class="container-table">
        <table>
            <thead>
                <tr>
                    <th>Registro</th>
                    <th>Nome</th>
                    <th>Funcao</th>
                    <th>Email</th>
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

        <a href="form.php" class="botao-cadastrar">Cadastrar usuario</a>

    </section>
</main>
</body>
</html>