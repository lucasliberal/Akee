<?php
    require_once('classes\db.class.php');

    $id_usuario = $_POST['id_usuario'];
    $deixar_seguir_id_usuario = $_POST['deixar_seguir_id_usuario'];

    $sql = "DELETE FROM usuarios_seguidores WHERE id_usuario = $id_usuario AND seguindo_id_usuario = $deixar_seguir_id_usuario";
    $db = db::connect_users_db();
    $response = mysqli_query($db, $sql);
?>