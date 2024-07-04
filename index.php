<?php
    include('config.php');

    Router::addRoute('/', function(){
        \views\mainView::index('home');
    });

    Router::render();
?>