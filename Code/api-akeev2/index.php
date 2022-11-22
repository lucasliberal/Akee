<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-type:application/json');
    date_default_timezone_set("America/Sao_Paulo");

    if(isset($_GET['path'])){
        $path = explode("/", $_GET['path']);
    } else {
        echo 'Caminho inexistente!';
        exit;
    }

    if(isset($path[0]) && $path[0] == 'posts' || $path[0] == 'user'){
        $api = $path[0];
    } else {
        echo "O endereço '/$path[0]' nao existe!";
        exit;
    }

    if(isset($path[1])){
        $action = $path[1];
    } else {
        $action = '';
    }

    if(isset($path[2])){
        $param = $path[2];
    } else {
        $param = '';
    }
    
    $method = $_SERVER['REQUEST_METHOD'];

    include_once 'classes/db.class.php';
    include_once 'api/routes.php';
?>