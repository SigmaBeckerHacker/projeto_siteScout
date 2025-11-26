<?php
    $pdo = new PDO(
        'mysql:host=localhost;dbname=db_escoteiro;charset=utf8mb4','root','0000',
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );

?>