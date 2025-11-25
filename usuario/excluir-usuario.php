<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Método inválido.";
    exit;
}

require_once __DIR__ . '/../src/conexao-bd.php';
require_once __DIR__ . '/../src/Repositorio/UsuarioRepositorio.php';

$registro = (int) ($_POST['registro'] ?? 0);

if ($registro === '') {
    echo "Registro inválido.";
    exit;
}

$repo = new UsuarioRepositorio($pdo);
$repo->excluirUsuario($registro);

header('Location: listar-usuarios.php?delete=1');
exit;