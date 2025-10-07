<?php 
    session_start();
    $usuarioLogado = $_SESSION['usuario'] ?? null;
    
    $erro = $_GET['erro'] ?? '';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/login.css">
    <title>Escoteiro - Login</title>
</head>

<body>
    <main>
        <?php 
        if($usuarioLogado): ?>
        <section class="container-topo">
            <div class="topo-direita">
                <p>Você já está logado como <strong><?php echo htmlspecialchars($usuarioLogado)?></strong></p>
                <form action="logout.php" method="post">
                    <button type="submit" class="botao-sair">Sair</button>
                </form>
            </div>
            <div class="conteudo">
                <a href="mostrar-escoteiros.php" class="link-adm">Ir para o painel administrativo</a>
            </div>
        </section>
        <?php else: ?>

        <section class="container-admin-banner">
            <img src="img/logo-escoteiros.png" class="logo-admin" alt="logo-granato">
            <h1>Login Escoteiro</h1>
        </section>
        <section class="container-form">
            <div class="form-wrapper">
                <?php if($erro === 'credenciais'): ?>
                <p class="mensagem-erro">Usuário e senha incorretos.</p>
                <?php elseif($erro === 'campos'): ?>
                <p class="mensagem-erro">Preencha e-mail e senha.</p>
                <?php endif; ?>

                <form action="autenticar.php" method="POST">
                    <label for="email">E-mail</label>
                    <input type="email" id="e-mail" name="email" placeholder="Digite o seu e-mail">

                    <label for="password">Senha</label>
                    <input type="password" id="password" name="senha" placeholder="Digite a sua senha">

                    <input type="submit" class="botao-cadastrar" value="Entrar">
                </form>
            </div>
        </section>
        <?php endif; ?>
    </main>

    <script>
    window.addEventListener('DOMContentLoaded', function() {
        var msg = document.querySelector('.mensagem-erro');
        if (msg) {
            setTimeout(function() {
                msg.classList.add('oculto');
            }, 5000);
        }
    });
    </script>
</body>

</html>