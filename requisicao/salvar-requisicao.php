<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: ../login.php');
    exit;
}

require_once __DIR__ . '/../src/conexao-bd.php';
require_once __DIR__ . '/../src/Modelo/Requisicao.php';
require_once __DIR__ . '/../src/Repositorio/RequisicaoRepositorio.php';
require_once __DIR__ . '/../src/Repositorio/UsuarioRepositorio.php';

$repoReq = new RequisicaoRepositorio($pdo);
$repoUsuario = new UsuarioRepositorio($pdo);

$usuarioLogadoEmail = trim($_SESSION['usuario']);
$usuario = $repoUsuario->buscarPorEmail($usuarioLogadoEmail);

if (!$usuario) {
    header('Location: ../login.php');
    exit;
}

$distintivo = trim($_POST['distintivo'] ?? '');
$postedData = trim($_POST['data_requisicao'] ?? '');
$postedStatus = trim($_POST['status'] ?? '');
$idOriginal = $_POST['id_original'] ?? null;

if (empty($distintivo)) {
    header("Location: form.php?erro=campos");
    exit;
}

if ($idOriginal === null) {

    $now = date('Y-m-d');
    $requisicao = new Requisicao(0, $distintivo, $now, $usuario);
    $repoReq->salvar($requisicao);
    $currentUserPerms = $_SESSION['permissoes'] ?? [];
    $isAdmin = in_array('todasrequisicoes.listar', $currentUserPerms, true);
    if ($isAdmin) {
        header('Location: listar-todas-requisicoes.php?ok=cadastrado');
    } else {
        header('Location: listar-minhas-requisicoes.php?ok=cadastrado');
    }
    exit;
}

$idOriginal = (int)$idOriginal;

$existing = $repoReq->buscarPorId($idOriginal);

if (!$existing) {
    header('Location: listar-minhas-requisicoes.php?erro=notfound');
    exit;
}

$currentUserPerms = $_SESSION['permissoes'] ?? [];
$isAdmin = in_array('todasrequisicoes.listar', $currentUserPerms, true);

$existingData = $existing->getData();


$chefeParaUsar = $isAdmin ? $usuario : $existing->getChefe();
$dataParaUsar = $isAdmin && !empty($postedData) ? $postedData : $existingData;

$requisicao = new Requisicao($idOriginal, $distintivo, $dataParaUsar, $chefeParaUsar);
$repoReq->atualizar($requisicao);

$currentUserPerms = $_SESSION['permissoes'] ?? [];
$isAdmin = in_array('todasrequisicoes.listar', $currentUserPerms, true);
if ($isAdmin) {
    header('Location: listar-todas-requisicoes.php?ok=editado');
} else {
    header('Location: listar-minhas-requisicoes.php?ok=editado');
}
exit;

?>
<?php
require_once __DIR__ . '/../src/conexao-bd.php';
require_once __DIR__ . '/../src/Modelo/Escoteiro.php';
require_once __DIR__ . '/../src/Repositorio/EscoteiroRepositorio.php';

$repo = new EscoteiroRepositorio($pdo);

$nome      = trim($_POST['nome'] ?? '');
$ramo      = $_POST['ramo'] ?? '';
$registro  = $_POST['registro'] ?? '';
$registro_original = $_POST['registro_original'] ?? null;


if (empty($nome) || empty($ramo) || empty($registro)) {
    header("Location: form.php?erro=campos");
    exit;
}

$registro = (int)$registro;

if ($registro_original === null) {

    if ($repo->buscarPorRegistro($registro)) {
        header("Location: form.php?erro=registroDuplicado");
        exit;
    }

    $escoteiro = new Escoteiro($registro, $nome, $ramo);
    $repo->salvar($escoteiro);

    header("Location: listar-escoteiros.php?ok=cadastrado");
    exit;

}

else {

    $registro_original = (int)$registro_original;

    $escExistente = $repo->buscarPorRegistro($registro_original);

    if (!$escExistente) {
        header("Location: listar-escoteiros.php?erro=notfound");
        exit;
    }

    $escoteiro = new Escoteiro($registro_original, $nome, $ramo);

    $repo->atualizar($escoteiro);

    header("Location: listar-escoteiros.php?ok=editado");
    exit;
}