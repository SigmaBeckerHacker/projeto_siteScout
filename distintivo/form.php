<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: ../login.php');
    exit;
}

require_once __DIR__ . '/../src/conexao-bd.php';
require_once __DIR__ . '/../src/Modelo/Distintivo.php';
require_once __DIR__ . '/../src/Repositorio/DistintivoRepositorio.php';

$repo = new DistintivoRepositorio($pdo);

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$modoEdicao = false;
$distintivo = null;

if ($id) {
    $distintivo = $repo->buscarPorId($id);

    if ($distintivo) {
        $modoEdicao = true;
    } else {
        header("Location: listar-distintivos.php?erro=notfound");
        exit;
    }
}

$valorId        = $modoEdicao ? $distintivo->getId()         : '';
$valorNome      = $modoEdicao ? $distintivo->getNome()       : '';
$valorQtd       = $modoEdicao ? $distintivo->getQuantidade() : '';
$valorCategoria = $modoEdicao ? $distintivo->getCategoria()  : '';
$valorImagem    = $modoEdicao ? $distintivo->getImagem()     : '';

$categorias = [
    "progressao" => "Progressão",
    "especialidades" => "Especialidades",
    "interesse" => "Interesse Especial",
    "modalidade" => "Modalidade",
    "eficiencia" => "Eficiência",
    "condecoracao" => "Condecoração"
];

$tituloPagina  = $modoEdicao ? "Editar Distintivo" : "Cadastrar Distintivo";
$textoBotao    = $modoEdicao ? "Salvar Alterações" : "Cadastrar Distintivo";
$actionForm    = "salvar-distintivo.php";
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

        <form action="<?= $actionForm ?>" method="POST" enctype="multipart/form-data">

            <?php if ($modoEdicao): ?>
                <input type="hidden" name="id_original" value="<?= $valorId ?>">
            <?php endif; ?>

            <label for="nome">Nome do distintivo</label>
            <input type="text" name="nome" id="nome"
                   value="<?= htmlspecialchars($valorNome) ?>"
                   placeholder="Digite o nome do distintivo">

            <label for="quantidade">Quantidade em estoque</label>
            <input type="number" name="quantidade" id="quantidade"
                   value="<?= htmlspecialchars($valorQtd) ?>"
                   placeholder="Quantidade disponível">

            <label>Categoria</label>
            <div class="container-radio">

                <?php foreach ($categorias as $key => $label): ?>
                    <label>
                        <input type="radio" name="categoria" value="<?= $key ?>"
                            <?= $valorCategoria === $key ? 'checked' : '' ?>>
                        <?= $label ?>
                    </label>
                <?php endforeach; ?>

            </div>

            <label for="imagem">Imagem do distintivo</label>
            <input type="file" name="imagem" id="imagem">

            <?php if ($modoEdicao && $valorImagem): ?>
                <p>Imagem atual:</p>
                <img src="../uploads/distintivos/<?= htmlspecialchars($valorImagem) ?>" 
                     width="120" alt="Imagem do distintivo">
            <?php endif; ?>

            <input class="botao-cadastrar" type="submit" value="<?= $textoBotao ?>">

        </form>

    </section>
</main>

</body>
</html>