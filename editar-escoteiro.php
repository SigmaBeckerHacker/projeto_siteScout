<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/editar-escoteiro.css">
    <title>Editar Jovens</title>
</head>
<body>
    <main>
        <section class="container-admin-banner">
            <img src="img/logo-escoteiros.png" class="logo-admin" alt="logo-granato">
            <h1>Editar Escoteiro</h1>
        </section>

        <section class="container-form">
            <form action="atualizarEscoteiro.php" method="POST">
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome" value="<?php if(isset($_GET['nome'])) echo htmlspecialchars($_GET['nome']); ?>">

                <label for="tipo">Ramo</label>
                <div class="container-radio">
                    <div>
                        <label for="lobinho">Lobinho</label>
                        <input type="radio" name="tipo" id="lobinho" value="lobinho" <?php if(isset($_GET['ramo']) && $_GET['ramo']=='lobinho') echo 'checked'; ?>>
                    </div>
                    <div>
                        <label for="escoteiro">Escoteiro</label>
                        <input type="radio" name="tipo" id="escoteiro" value="escoteiro" <?php if(isset($_GET['ramo']) && $_GET['ramo']=='escoteiro') echo 'checked'; ?>>
                    </div>
                    <div>
                        <label for="senior">Sênior</label>
                        <input type="radio" name="tipo" id="senior" value="senior" <?php if(isset($_GET['ramo']) && $_GET['ramo']=='senior') echo 'checked'; ?>>
                    </div>
                    <div>
                        <label for="pioneiro">Pioneiro</label>
                        <input type="radio" name="tipo" id="pioneiro" value="pioneiro" <?php if(isset($_GET['ramo']) && $_GET['ramo']=='pioneiro') echo 'checked'; ?>>
                    </div>
                </div>

                <label for="registro">Registro</label>
                <input type="number" name="registro" id="registro" value="<?php if(isset($_GET['registro'])) echo htmlspecialchars($_GET['registro']); ?>" readonly>

                <input class="botao-atualizar" type="submit" name="atualizar" value="Atualizar escoteiro">
                </form>
        </section>


    </main>
    
</body>
</html>