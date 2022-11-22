<?php
    require_once('classes\db.class.php');

    //retorna qtde de seguidores de um usuario
    if($param == 'num-followers'){
        $id_usuario = $_POST['id_usuario'];
        $db = db::connect_users_db();
        $sql = ("SELECT COUNT(*) AS qtd_followers FROM usuarios_seguidores 
                WHERE seguindo_id_usuario = $id_usuario;");
        $response = mysqli_query($db, $sql);
        $qtd_seguidores = mysqli_fetch_assoc($response);
        echo json_encode([$qtd_seguidores]);
    }

    //retorna qtde de postagens de um usuario
    else if($param == 'num-posts'){
        $id_usuario = $_POST['id_usuario'];
        $db = db::connect_posts_db();
        $response = $db->prepare("SELECT COUNT(*) AS qtd_posts FROM post WHERE id_usuario = $id_usuario;");
        $response->execute();
        $qtd_posts = $response->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["output" => $qtd_posts]);
    }

    //retorna nome do usuario
    else if($param == 'username'){
        $id_usuario = $_POST['id_usuario'];
        $db = db::connect_users_db();
        $sql = ("SELECT usuario FROM usuarios where id=$id_usuario;");
        $response = mysqli_query($db, $sql);
        $username = mysqli_fetch_assoc($response);
        echo json_encode($username);
    }

    //retorna se o autor da postagem é seguido pelo usuario
    else if($param == 'isfollowed'){
        $id_usuario = $_POST['id_usuario'];
        $id_usuario_postagem = $_POST['id_usuario_postagem'];

        $db = db::connect_users_db();
        $sql = "SELECT us.seguindo_id_usuario AS isFollowed FROM usuarios AS u 
                JOIN usuarios_seguidores AS us ON (u.id = us.id_usuario)
                WHERE u.id=$id_usuario AND us.seguindo_id_usuario=$id_usuario_postagem;";
        $response = mysqli_query($db, $sql);
        $output = mysqli_fetch_assoc($response);
        echo json_encode($output); 
    }

    else{
        echo 'Parametro invalido!';
    }
?>