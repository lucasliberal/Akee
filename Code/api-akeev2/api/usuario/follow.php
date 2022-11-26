<?php
    require_once('classes\db.class.php');

    $id_usuario = $_POST['id_usuario'];
    $seguir_id_usuario = $_POST['seguir_id_usuario'];

    $db = db::connect_users_db();
    $response = $db->prepare("INSERT INTO usuarios_seguidores(id_usuario, seguindo_id_usuario)values($id_usuario, $seguir_id_usuario)");
    $response->execute();
?>