<?php
session_start();

// SE TIVER LOGIN NO SISTEMA, DESCOMENTE

if (!isset($_SESSION['usuario'])) {
    header('Location: ../login.php');
    exit;
}


require_once __DIR__ . '/../src/conexao-bd.php';
require_once __DIR__ . '/../src/Modelo/Escoteiro.php';
require_once __DIR__ . '/../src/Repositorio/EscoteiroRepositorio.php';

$repo = new EscoteiroRepositorio($pdo);

$registro = filter_input(INPUT_GET, 'registro', FILTER_VALIDATE_INT);
$modoEdicao = false;
$escoteiro = null;

if ($registro) {
    $escoteiro = $repo->buscarPorRegistro($registro);

    if ($escoteiro) {
        $modoEdicao = true;
    } else {
        header("Location: listar-escoteiros.php?erro=notfound");
        exit;
    }
}

$valorRegistro = $modoEdicao ? $escoteiro->getRegistro() : '';
$valorNome     = $modoEdicao ? $escoteiro->getNome()     : '';
$valorRamo     = $modoEdicao ? $escoteiro->getRamo()     : '';

$tituloPagina  = $modoEdicao ? "Editar Jovem" : "Cadastrar Jovem";
$textoBotao    = $modoEdicao ? "Salvar Alterações" : "Cadastrar Jovem";
$actionForm    = "salvar-escoteiro.php";
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
                       placeholder="Digite o nome do jovem">

                <label for="ramo">Ramo</label>
                <div class="container-radio">

                    <label>
                        <input type="radio" name="ramo" value="lobinho"
                            <?= $valorRamo === 'lobinho' ? 'checked' : '' ?>> Lobinho
                    </label>

                    <label>
                        <input type="radio" name="ramo" value="escoteiro"
                            <?= $valorRamo === 'escoteiro' ? 'checked' : '' ?>> Escoteiro
                    </label>

                    <label>
                        <input type="radio" name="ramo" value="senior"
                            <?= $valorRamo === 'senior' ? 'checked' : '' ?>> Sênior
                    </label>

                    <label>
                        <input type="radio" name="ramo" value="pioneiro"
                            <?= $valorRamo === 'pioneiro' ? 'checked' : '' ?>> Pioneiro
                    </label>
                </div>

                <label for="registro">Registro</label>
                <input type="number" name="registro" id="registro"
                       value="<?= htmlspecialchars($valorRegistro) ?>"
                       placeholder="Digite o registro do jovem" 
                       <?= $modoEdicao ? "readonly" : "" ?>>

                <input class="botao-cadastrar" type="submit" value="<?= $textoBotao ?>">

            </form>
        </section>
    </main>

</body>
</html>
