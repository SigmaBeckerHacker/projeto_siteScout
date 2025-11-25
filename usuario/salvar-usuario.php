<?php
require_once __DIR__ . '/../src/conexao-bd.php';
require_once __DIR__ . '/../src/Modelo/Usuario.php';
require_once __DIR__ . '/../src/Repositorio/UsuarioRepositorio.php';

$repo = new UsuarioRepositorio($pdo);

$nome      = trim($_POST['nome'] ?? '');
$funcao      = $_POST['funcao'] ?? '';
$registro  = $_POST['registro'] ?? '';
$email     = trim($_POST['email'] ?? '');
$registro_original = $_POST['registro_original'] ?? null;


if (empty($nome) || empty($funcao) || empty($registro) || empty($email)) {
    header("Location: form.php?erro=campos");
    exit;
}

$registro = (int)$registro;

if ($registro_original === null) {

    if ($repo->buscarPorRegistro($registro)) {
        header("Location: form.php?erro=registroDuplicado");
        exit;
    }

    $usuario = new Usuario($registro, $nome, $funcao, $email);
    $repo->salvar($usuario);

    header("Location: listar-usuarios.php?ok=cadastrado");
    exit;

}

else {

    $registro_original = (int)$registro_original;

    $usExistente = $repo->buscarPorRegistro($registro_original);

    if (!$usExistente) {
        header("Location: listar-usuarios.php?erro=notfound");
        exit;
    }

    $usuario = new Usuario($registro_original, $nome, $funcao, $email);

    $repo->atualizar($usuario);

    header("Location: listar-usuarios.php?ok=editado");
    exit;
}