<?php
    namespace controllers;

    class homeController
    {
        public static function pageHome(){
            if(isset($_POST['acao'])){
                $email= $_POST['email'];
                $pergunta = $_POST['pergunta'];
                $token = md5(uniqid());

                $sql = \mysql::conectar()->prepare("INSERT INTO `chamadas` VALUES (null,?,?,?)");
                $sql->execute(array($email, $pergunta, $token));

                echo '<script>alert("Sua chamada foi aberta com sucesso!")</script>';
            }

            include('views/home.php');
        }

    }
    

?>