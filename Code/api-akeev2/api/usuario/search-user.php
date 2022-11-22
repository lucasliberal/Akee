<?php
    $nome_pessoa = $_POST['nome_pessoa'];
    $id_usuario = $_POST['id_usuario'];

     $db = db::connect_users_db();
     //utilizamos o LIKE ao invés do = para retornarmos resultados que possuam cadeias de caracteres similares
     $sql = "SELECT u.*, us.* FROM usuarios AS u 
            LEFT JOIN usuarios_seguidores AS us 
            ON (us.id_usuario = $id_usuario AND u.id = us.seguindo_id_usuario) 
            WHERE u.usuario like '%$nome_pessoa%' AND u.id <> $id_usuario";

     $response = mysqli_query($db, $sql);
     $output = mysqli_fetch_all($response, MYSQLI_ASSOC);
 
     if($output){
            echo json_encode(["users" => $output]);
     }else{
        echo json_encode(["users" => null]);
     }
?>