<?php
    session_start();

    if(!isset($_SESSION['usuario'])){
        header('Location: login.php');
        exit;
    }

    $usuarioLogado = $_SESSION['usuario'];

    require_once __DIR__ . '/src/conexao-bd.php';
    require_once __DIR__ . '/src/Repositorio/EscoteiroRepositorio.php';
    require_once __DIR__ . '/src/Modelo/Escoteiro.php';

    $repo = new EscoteiroRepositorio($pdo);
    $escoteiros = $pdo->query('SELECT registro, nome, ramo FROM tbEscoteiro')->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/mostrar-escoteiros.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <title>Escoteiro - Admin</title>
</head>

<body>
    <main>
        <section class="container-topo">
            <div class="topo-direita">
                <p>Bem vindo, <strong><?php echo htmlspecialchars($usuarioLogado)?></strong></p>
                <form action="logout.php" method="POST">
                    <button type="submit" class="botao-sair">Sair</button>
                </form>
            </div>
        
        </section>

        <section class="container-admin-banner">
            <img src="img/logo-escoteiros.png" class="logo-admin" alt="logo-escoteiro">
            <h1>Administração Escoteiros</h1>
        </section>
        <section class="container-table">
            <table>
                <thead>
                    <tr>
                        <th>Registro</th>
                        <th>Nome</th>
                        <th>Ramo</th>
                        <th colspan="2">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($escoteiros as $escoteiro): ?>
                    <tr>
                        <td><?= htmlspecialchars($escoteiro['registro']) ?></td>
                        <td><?= htmlspecialchars($escoteiro['nome']) ?></td>
                        <td><?= htmlspecialchars($escoteiro['ramo']) ?></td>
                        <td>
                          <a class="botao-editar" href="editar-escoteiro.php?registro=<?= urlencode($escoteiro['registro']) ?>&nome=<?= urlencode($escoteiro['nome']) ?>&ramo=<?= urlencode($escoteiro['ramo']) ?>">Editar</a>
                        <td>
                            <form method="POST" action="deletar-escoteiro.php">
                                <input type="hidden" name="registro" value="<?= htmlspecialchars($escoteiro['registro']) ?>">
                                <input type="submit" value="Excluir" class="botao-excluir">
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="cadastrar-escoteiro.html" class="botao-cadastrar">Cadastrar escoteiro</a>
            
        </section>
    </main>

</body>

</html>