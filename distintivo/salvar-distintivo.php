<?php
require_once __DIR__ . '/../src/conexao-bd.php';
require_once __DIR__ . '/../src/Modelo/Distintivo.php';
require_once __DIR__ . '/../src/Repositorio/DistintivoRepositorio.php';

$repo = new DistintivoRepositorio($pdo);

$nome       = trim($_POST['nome'] ?? '');
$quantidade = $_POST['quantidade'] ?? '';
$categoria  = $_POST['categoria'] ?? '';
$id         = $_POST['id_original'] ?? null;

if (empty($nome) || empty($quantidade) || empty($categoria)) {
    header("Location: form-distintivo.php?erro=campos");
    exit;
}

$quantidade = (int)$quantidade;

$imagemFinal = null;

if ($id !== null) {
    $id = (int)$id;
    $distAntigo = $repo->buscarPorId($id);
    if (!$distAntigo) {
        header("Location: listar-distintivos.php?erro=notfound");
        exit;
    }
    $imagemFinal = $distAntigo->getImagem();
}

if (!empty($_FILES['imagem']['name'])) {

    $pastaUpload = __DIR__ . '/../uploads/distintivos/';

    if (!is_dir($pastaUpload)) {
        mkdir($pastaUpload, 0777, true);
    }

    $nomeImagem = time() . "-" . basename($_FILES["imagem"]["name"]);
    $caminhoDestino = $pastaUpload . $nomeImagem;

    if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $caminhoDestino)) {
        $imagemFinal = $nomeImagem;
    }
}

if ($id === null) {

    if ($repo->buscarPorNome($nome)) {
        header("Location: form-distintivo.php?erro=duplicado");
        exit;
    }

    $distintivo = new Distintivo(
        0,         
        $nome,
        $quantidade,
        $categoria,
        $imagemFinal ?? ''
    );

    $repo->salvar($distintivo);

    header("Location: listar-distintivos.php?ok=cadastrado");
    exit;

}


$distintivo = new Distintivo(
    $id,
    $nome,
    $quantidade,
    $categoria,
    $imagemFinal ?? ''
);

$repo->atualizar($distintivo);

header("Location: listar-distintivos.php?ok=editado");
exit;