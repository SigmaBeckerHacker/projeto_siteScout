<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$usuarioLogado = $_SESSION['usuario'] ?? null;

function pode(string $perm): bool
{
    return in_array($perm, $_SESSION['permissoes'] ?? [], true);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Distintivos</title>
    <link rel="icon" href="img/logo-escoteiros.png" type="image/x-icon">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/dashboard.css">
</head>

<body>

    <!-- BARRAS LATERAIS COLORIDAS -->
    <div class="side left red"></div>
    <div class="side left purple"></div>
    <div class="side right purple"></div>
    <div class="side right yellow"></div>

    <!-- LOGO CENTRAL -->
    <div class="logo-container">
        <img src="img/logo-escoteiros.png" alt="Logo do Grupo" class="logo">
    </div>

    <!-- TÍTULO -->
      <?php if (pode('usuarios.listar')): ?>
                <h1 class="titulo">ADMINISTRADOR</h1>
            <?php endif; ?>
    <?php if (!pode('usuarios.listar')): ?>
                <h1 class="titulo">USUÁRIO</h1>
            <?php endif; ?>
    

    </section>
    <!-- CARD CENTRAL -->
    <div class="card">

        <div class="linha-superior">
            <span class="bemvindo">Bem vindo, <?= htmlspecialchars($usuarioLogado) ?></span>
            
            <span class="icone">👤</span>

            <form action="logout.php" method="POST">
                <button type="submit" class="botao-sair">Sair</button>
            </form>
        </div>

        <hr>

        <div class="botoes-container">

            <?php if (pode('usuarios.listar')): ?>
                <a class="botao" href="usuario/listar-usuarios.php">Usuarios</a>
            <?php endif; ?>

            <?php if (pode('distintivos.listar')): ?>
                <a class="botao" href="distintivo/listar-distintivos.php">Distintivos</a>
            <?php endif; ?>

            <?php if (pode('escoteiros.listar')): ?>
                <a class="botao" href="escoteiro/listar-escoteiros.php">Escoteiros</a>
            <?php endif; ?>
            
            <?php if (pode('todasrequisicoes.listar')): ?>
                <a class="botao" href="requisicao/listar-todas-requisicoes.php">Todas Requisições</a>
            <?php endif; ?>

            <?php if (pode('requisicoes.listar')): ?>
                <a class="botao" href="requisicao/listar-minhas-requisicoes.php">Minhas Requisições</a>
            <?php endif; ?>
        </div>

    </div>

</body>
</html>