<?php

    session_start();
    date_default_timezone_set('America/Sao_Paulo');

    define('INCLUDE_PATH', 'https://werlley5.github.io/Portfolio/');

    define('HOST','localhost');
    define('USER','root');
    define('PASSWORD','');
    define('DATABASE','nome do banco de dados');

    $autoload = function ($class) {
        // Caminho para as classes gerais
        $classPath = __DIR__ . '/classes/' . $class . '.php';
    
        // Caminho para os controladores
        $controllerPath = __DIR__ . '/classes/controller/' . str_replace('controllers\\', '', $class) . '.php';

        // Caminho para os modelos
        $modelPath = __DIR__ . '/classes/model/' . str_replace('models\\', '', $class) . '.php';

        // Caminho para as views
        $viewPath = __DIR__ . '/classes/view/' . str_replace('views\\', '', $class) . '.php';
    
        if(file_exists($classPath)){
            include $classPath;

        }else if(file_exists($controllerPath)){
            include $controllerPath;

        }else if(file_exists($modelPath)){
            include $modelPath;

        }else if(file_exists($viewPath)){
            include $viewPath;
            
        }
        
    };
    
    spl_autoload_register($autoload);

?>