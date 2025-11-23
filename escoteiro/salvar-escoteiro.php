<?php
require_once __DIR__ . '/../src/conexao-bd.php';
require_once __DIR__ . '/../src/Modelo/Escoteiro.php';
require_once __DIR__ . '/../src/Repositorio/EscoteiroRepositorio.php';

$repo = new EscoteiroRepositorio($pdo);

$nome      = trim($_POST['nome'] ?? '');
$ramo      = $_POST['ramo'] ?? '';
$registro  = $_POST['registro'] ?? '';
$registro_original = $_POST['registro_original'] ?? null;


if (empty($nome) || empty($ramo) || empty($registro)) {
    header("Location: form.php?erro=campos");
    exit;
}

$registro = (int)$registro;

if ($registro_original === null) {

    if ($repo->buscarPorRegistro($registro)) {
        header("Location: form.php?erro=registroDuplicado");
        exit;
    }

    $escoteiro = new Escoteiro($registro, $nome, $ramo);
    $repo->salvar($escoteiro);

    header("Location: listar-escoteiros.php?ok=cadastrado");
    exit;

}

else {

    $registro_original = (int)$registro_original;

    $escExistente = $repo->buscarPorRegistro($registro_original);

    if (!$escExistente) {
        header("Location: listar-escoteiros.php?erro=notfound");
        exit;
    }

    $escoteiro = new Escoteiro($registro_original, $nome, $ramo);

    $repo->atualizar($escoteiro);

    header("Location: listar-escoteiros.php?ok=editado");
    exit;
}