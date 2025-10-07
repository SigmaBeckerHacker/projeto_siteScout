<?php
    require_once __DIR__ . '/src/conexao-bd.php';
    require_once __DIR__ . '/src/Repositorio/EscoteiroRepositorio.php';
    require_once __DIR__ . '/src/Modelo/Escoteiro.php';


    $nome = $_POST['nome'] ?? '';
    $ramo = $_POST['tipo'] ?? '';
    $registro = $_POST['registro'] ?? '';


    if (empty($nome) || empty($ramo) || empty($registro)) {
        echo "Preencha todos os campos.";
        exit;
    }

    $repo = new EscoteiroRepositorio($pdo);


    if($repo->buscarPorNome($nome)){
        echo "Escoteiro já existe! {$nome}\n";
        exit; 
    }

    $escoteiro = new Escoteiro((int)$registro, $nome, $ramo);
    $repo->salvar($escoteiro);

    echo "Escoteiro inserido: {$nome}\n";
    header('Location: mostrar-escoteiros.php');
    exit;
?>