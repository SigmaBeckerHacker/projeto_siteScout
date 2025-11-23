<?php 
    session_start();

   
    $usuarioValido = 'admin@exemplo.com';
    $senhaValida = '1234';

  
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        header('Location: login.php');
        exit;
    }

    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

  
   if($email === '' || $senha === ''){
        header('Location: login.php?erro=campos');
        exit;
   }

  
   if($email === $usuarioValido && $senha === $senhaValida){
        session_regenerate_id(true);
        $_SESSION['usuario'] = $email;
       
        header('Location: escoteiro/listar-escoteiros.php');
        exit;
   }


   header('Location: login.php?erro=credenciais');
   exit;

?>