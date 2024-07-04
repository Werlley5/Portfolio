<?php
    namespace views;

    class mainView
    {
        public static function index($home, $header = 'views/includes/header.php', $footer = 'views/includes/footer.php'){
            include($header);
            include('views/'.$home.'.php');
            include($footer);
        }
    }
    

?>