<?php

    class Router 
    {

        private static $routes = [];

        public static function addRoute($par, $arg){
            self::$routes[] = ['path' => $par, 'callback' => $arg];
        }

        public static function render(){
            $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $base_path = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']); 
            $route = str_replace($base_path, '', $uri);
            $route = trim($route, '/');

            foreach (self::$routes as $routeConfig) {
                $par = trim($routeConfig['path'], '/');

                if ($route == $par) {
                    $routeConfig['callback']();
                    die();
                }

                $parArray = explode('/', $par);
                $routeArray = explode('/', $route);
                $success = true;
                $vars = [];

                if (count($parArray) == count($routeArray)) {
                    foreach ($parArray as $key => $value) {
                        if ($value == '?') {
                            $vars[$key] = $routeArray[$key];
                        } else if ($routeArray[$key] != $value) {
                            $success = false;
                            break;
                        }
                    }

                    if ($success) {
                        $routeConfig['callback']($vars);
                        die();
                    }
                }
            }

            //include('views/404.php');
            die("Página não encontrada!");
            
        }
        
    }

?>