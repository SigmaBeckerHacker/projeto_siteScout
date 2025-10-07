<?php
session_start();

if(!isset($_SESSION['usuario'])){
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/src/conexao-bd.php';
require_once __DIR__ . '/src/Repositorio/EscoteiroRepositorio.php';
require_once __DIR__ . '/src/Modelo/Escoteiro.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $registro = $_POST['registro'] ?? '';

    if (!empty($registro)) {
        $repo = new EscoteiroRepositorio($pdo);
        
        $repo->deletarEscoteiro($registro);

        header('Location: mostrar-escoteiros.php');
        exit;
    } else {
        echo "Registro inválido.";
    }
} else {
    echo "Método inválido.";
}