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
require_once __DIR__ . '/../src/Repositorio/RequisicaoRepositorio.php';
require_once __DIR__ . '/../src/Repositorio/UsuarioRepositorio.php';

$id = (int) ($_POST['id'] ?? 0);

if ($id <= 0) {
    echo "ID inválido.";
    exit;
}

$repo = new RequisicaoRepositorio($pdo);
$repoUser = new UsuarioRepositorio($pdo);

$usuarioLogadoEmail = trim($_SESSION['usuario']);
$usuario = $repoUser->buscarPorEmail($usuarioLogadoEmail);

if (!$usuario) {
    header('Location: ../login.php');
    exit;
}

$canDeleteAll = !empty($_SESSION['permissoes']) && in_array('todasrequisicoes.listar', $_SESSION['permissoes']);

if (!$canDeleteAll) {
    $req = $repo->buscarPorId($id);
    if (!$req || $req->getChefe()->getRegistro() !== $usuario->getRegistro()) {
        echo "Não autorizado.";
        exit;
    }
}

$repo->excluir($id);

 
if ($canDeleteAll) {
    header('Location: listar-todas-requisicoes.php?delete=1');
} else {
    header('Location: listar-minhas-requisicoes.php?delete=1');
}
exit;