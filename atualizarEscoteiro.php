<?php
require_once __DIR__ . '/src/conexao-bd.php';
require_once __DIR__ . '/src/Repositorio/EscoteiroRepositorio.php';
require_once __DIR__ . '/src/Modelo/Escoteiro.php';

$registro = $_POST['registro'] ?? '';
$nome = $_POST['nome'] ?? '';
$ramo = $_POST['tipo'] ?? '';

if (empty($registro) || empty($nome) || empty($ramo)) {
    echo "Preencha todos os campos.";
    exit;
}

$repo = new EscoteiroRepositorio($pdo);

$sql = "UPDATE tbEscoteiro SET nome = ?, ramo = ? WHERE registro = ?";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(1, $nome);
$stmt->bindValue(2, $ramo);
$stmt->bindValue(3, $registro);
$stmt->execute();

header('Location: mostrar-escoteiros.php');
exit;
?>
