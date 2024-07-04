<?php

    session_start();
    date_default_timezone_set('America/Sao_Paulo');

    include('classes/mysql.php');
    include('classes/painel.php');
    include('classes/controller/controller.php');
    include('classes/model/model.php');
    include('classes/view/view.php');
    include('classes/router.php');

    define('INCLUDE_PATH','http://localhost/e-commerce_curso/');
    define('INCLUDE_PATH_PAINEL', INCLUDE_PATH.'painel/');
    define('BASE_DIR_PAINEL', __DIR__.'/painel');

    //banco de daddos
    define('HOST','localhost');
    define('USER','root');
    define('PASSWORD','');
    define('DATABASE','sistemas');
?>