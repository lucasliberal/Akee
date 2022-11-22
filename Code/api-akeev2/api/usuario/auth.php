<?php
    require_once('classes\db.class.php');

    $usuario = $_POST['usuario']; 
    $senha =  md5($_POST['senha']);

    $sql = "SELECT id, usuario, email FROM usuarios WHERE usuario='$usuario' AND senha='$senha'";
    $db = db::connect_users_db();
    //$response = $db->prepare("SELECT id, usuario, email FROM usuarios WHERE usuario='$usuario' AND senha='$senha'");
    //$response ->execute();
    $response = mysqli_query($db, $sql);

    if($response){
        $dados_usuario = mysqli_fetch_assoc($response);
        //$dados_usuario = $response->fetchAll(PDO::FETCH_ASSOC);

        if(isset($dados_usuario['usuario'])){
            echo json_encode(["erro"=>'false', "user" => $dados_usuario]);
        }
        else{
            echo json_encode(["erro"=>'true', "user" => NULL]);
        }
    } else{
        echo json_encode(["erro" => 'true']);
    }
?>