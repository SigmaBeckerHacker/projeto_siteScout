<?php
require "../src/conexao-bd.php";
require "../src/Modelo/Produto.php";
require "../src/Repositorio/ProdutoRepositorio.php";

date_default_timezone_set('America/Sao_Paulo');
$rodapeDataHora = date('d/m/Y H:i');

$requisicaoRepositorio = new RequisicaoRepositorio($pdo);
$requisicoes = $requisicaoRepositorio->buscarTodos();


?>
<head>
    <meta charset="UTF-8">

<style>
    body,
    table,
    th,
    td,
    h3 {
        font-family: Arial, Helvetica, sans-serif;
    }

    table {
        width: 90%;
        margin: auto 0;
    }

    table,
    th,
    td {
        border: 1px solid #000;
        
    }

    table th {
        padding: 11px 0 11px;
        font-weight: bold;
        font-size: 14px;
        text-align: left;
        padding: 8px;
    }

    table tr {
        border: 1px solid #000;
    }

    table td {
        font-size: 12px;
        padding: 8px;
    }

    h3 {
        text-align: center;
        margin-top: 0.5rem;
        margin-bottom: 1rem;
    }

    .container-admin-banner h1 {
        margin-top: 40px;
        font-size: 30px;
    }

    .pdf-footer {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        height: 30px;
        text-align: center;
        font-size: 12px;
        color: #444;
        border-top: 1px solid #ddd;
        padding-top: 6px;
    }

    body {
        margin-bottom: 50px;
        margin-top: 0;
    }

</style>
</head>


<h3>Listagem de requisicoes</h3>

<table>
    <thead>
        <tr>
            <th>Distintivod</th>
            <th>Data</th>
            <th>Chefe</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($produtos as $produto): ?>
            <tr>
                <td><?= $produto->getDistintivo() ?></td>
                <td><?= $produto->getData() ?></td>
                 <td><?= htmlspecialchars($req->getChefe() ? $req->getChefe()->getNome() : '-') ?></td>
            </tr>
        <?php endforeach; ?>


    </tbody>
</table>

<div class="pdf-footer">
    Gerado em: <?= htmlspecialchars($rodapeDataHora) ?>
</div>