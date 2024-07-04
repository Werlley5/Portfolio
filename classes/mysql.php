<?php

    class mysql
    {
        private static $pdo;
        
        public static function conectar() {

            if(self::$pdo == null){
                try{
                    self::$pdo = new PDO('mysql:host='.HOST.';dbname='.DATABASE,USER,PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND =>"SET NAMES utf8"));
                    self::$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

                }catch(Exception $e) {
                    echo '<h2 style="color: red;">Erro ao conectar</h2>'; 

                }
            }
            
            return self::$pdo;

            /*if(isset(self::$pdo)){
                return self::$pdo;

            }else{
                self::$pdo = new PDO('mysql:host='.HOST.';dbname='.DATABASE,USER,PASSWORD);

            }*/
        }
    }

?>