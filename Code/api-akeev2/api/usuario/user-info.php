<?php
    require_once('classes\db.class.php');

    //retorna qtde de seguidores de um usuario
    if($param == 'numberOf'){
        $id_usuario = $_POST['id_usuario'];

        $db1 = db::connect_users_db();
        $db2 = db::connect_posts_db();

        $response_followers = $db1->prepare("SELECT COUNT(*) AS qtd_followers FROM usuarios_seguidores 
                                             WHERE seguindo_id_usuario = $id_usuario;");
        $response_posts     = $db2->prepare("SELECT COUNT(*) AS qtd_posts FROM post WHERE id_usuario = $id_usuario;");
        
        $response_followers->execute();
        $response_posts->execute();

        $qtd_seguidores = $response_followers->fetch();
        $qtd_posts      = $response_posts->fetch();

        echo json_encode(["followers" => $qtd_seguidores, "posts" => $qtd_posts]);
    }

    //retorna nome do usuario
    else if($param == 'username'){
        $id_usuario = $_POST['id_usuario'];
        $db = db::connect_users_db();
        $response = $db->prepare("SELECT usuario FROM usuarios where id=$id_usuario;");
        $response->execute();
        $username = $response->fetch();
        if($username){
            echo json_encode($username);
        }
    }

    //retorna se o autor da postagem é seguido pelo usuario
    else if($param == 'isfollowed'){
        $id_usuario = $_POST['id_usuario'];
        $id_usuario_postagem = $_POST['id_usuario_postagem'];

        $db = db::connect_users_db();
        $response = $db->prepare("SELECT us.seguindo_id_usuario AS isFollowed FROM usuarios AS u 
                                JOIN usuarios_seguidores AS us ON (u.id = us.id_usuario)
                                WHERE u.id=$id_usuario AND us.seguindo_id_usuario=$id_usuario_postagem;");
        $response->execute();
        $output = $response->fetch();
        echo json_encode($output); 
    }

    else{
        echo 'Parametro invalido!';
    }
?>