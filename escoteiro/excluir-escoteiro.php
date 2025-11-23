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
require_once __DIR__ . '/../src/Repositorio/EscoteiroRepositorio.php';

$registro = (int) ($_POST['registro'] ?? 0);

if ($registro === '') {
    echo "Registro inválido.";
    exit;
}

$repo = new EscoteiroRepositorio($pdo);
$repo->excluirEscoteiro($registro);

header('Location: listar-escoteiros.php?delete=1');
exit;