<?php

session_start();

require_once __DIR__ . '/src/conexao-bd.php';
require_once __DIR__ . '/src/Modelo/Usuario.php';
require_once __DIR__ . '/src/Repositorio/UsuarioRepositorio.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

$email = trim($_POST['email'] ?? '');
$registro = $_POST['registro'] ?? '';

if ($email === '' || $registro === '') {
    header('Location: login.php?erro=campos');
    exit;
}

$repo = new UsuarioRepositorio($pdo);
$usuario = $repo->buscarPorEmail($email);


if ($repo->autenticar($email, $registro)) {
    session_regenerate_id(true); 
    
    $funcao = $usuario->getFuncao();
    $_SESSION['usuario'] = $email; 
    $_SESSION['permissoes'] = $funcao === 'Administrador' ? ['usuarios.listar',  'distintivos.listar', 'requisicoes.listar', 'escoteiros.listar'] : ['escoteiros.listar', 'requisicoes.listar'];
    header('Location: dashboard.php'); 
    exit;
}

header('Location: login.php?erro=credenciais');
exit;