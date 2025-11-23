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
require_once __DIR__ . '/../src/Repositorio/DistintivoRepositorio.php';

$id = (int) ($_POST['id'] ?? 0);

if ($id <= 0) {
    echo "ID inválido.";
    exit;
}

$repo = new DistintivoRepositorio($pdo);
$repo->excluirDistintivo($id);

header('Location: listar-distintivos.php?delete=1');
exit;