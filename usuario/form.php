<?php
session_start();



if (!isset($_SESSION['usuario'])) {
    header('Location: ../login.php');
    exit;
}


require_once __DIR__ . '/../src/conexao-bd.php';
require_once __DIR__ . '/../src/Modelo/Usuario.php';
require_once __DIR__ . '/../src/Repositorio/UsuarioRepositorio.php';

$repo = new UsuarioRepositorio($pdo);

$registro = filter_input(INPUT_GET, 'registro', FILTER_VALIDATE_INT);
$modoEdicao = false;
$usuario = null;

if ($registro) {
    $usuario = $repo->buscarPorRegistro($registro);

    if ($usuario) {
        $modoEdicao = true;
    } else {
        header("Location: listar-usuarios.php?erro=notfound");
        exit;
    }
}

$valorRegistro = $modoEdicao ? $usuario->getRegistro() : '';
$valorNome     = $modoEdicao ? $usuario->getNome()     : '';
$valorFuncao     = $modoEdicao ? $usuario->getFuncao()     : '';
$valorEmail    = $modoEdicao ? $usuario->getEmail()    : '';


$tituloPagina  = $modoEdicao ? "Editar Usuário" : "Cadastrar Usuário";
$textoBotao    = $modoEdicao ? "Salvar Alterações" : "Cadastrar Usuário";
$actionForm    = "salvar-usuario.php";
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
               
                    <input type="hidden" name="registro_original" value="<?= $valorRegistro ?>">
                <?php endif; ?>

                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome"
                       value="<?= htmlspecialchars($valorNome) ?>"
                       placeholder="Digite o nome do usuario">

                <label for="email">Email</label>
                <input type="text" name="email" id="email"
                       value="<?= htmlspecialchars($valorEmail) ?>"
                       placeholder="Digite o email do usuario">

                <label for="ramo">Função</label>
                <div class="container-radio">

                    <label>
                        <input type="radio" name="funcao" value="Administrador"
                            <?= $valorFuncao === 'Administrador' ? 'checked' : '' ?>> Administrador
                    </label>

                    <label>
                        <input type="radio" name="funcao" value="Usuário Comum"
                            <?= $valorFuncao === 'Usuario' ? 'checked' : '' ?>> Usuário Comum
                    </label>
                </div>

                <label for="registro">Registro</label>
                <input type="number" name="registro" id="registro"
                       value="<?= htmlspecialchars($valorRegistro) ?>"
                       placeholder="Digite o registro do usuario" 
                       <?= $modoEdicao ? "readonly" : "" ?>>

                <div class="action-row">
                    <input class="botao-cadastrar" type="submit" value="<?= $textoBotao ?>">
                    <button type="button" class="botao-cancelar" onclick="window.location.href='listar-usuarios.php'">Cancelar</button>
                </div>

            </form>
        </section>
    </main>

</body>
</html>
