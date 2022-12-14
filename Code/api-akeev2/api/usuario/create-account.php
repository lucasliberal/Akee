<?php
    require_once('classes\db.class.php');

    $usuario = $_POST['usuario'];
    $email = $_POST['email'];
    $senha = md5($_POST['senha']);

    $usuario_existe = false;
    $email_existe = false;

    $db = db::connect_users_db();

    //Verifica se usuario existe
    $response = $db->prepare("SELECT * FROM usuarios WHERE usuario = '$usuario'");
    $response->execute();
    if($response){
        $dados_usuario = $response->fetch();
        if(isset($dados_usuario['usuario'])){
            $usuario_existe = true;
        }
    } else {
    echo json_encode(["erro" => 'erro_db', "message" => 'Erro ao tentar localizar registro de usuario.']);
    }

    //verificar se o email ja existe
    $response = $db->prepare("SELECT * FROM usuarios WHERE email = '$email'");
    $response ->execute();
    if($response){
        $dados_usuario = $response->fetch();
        if(isset($dados_usuario['email'])){
            $email_existe = true;
        }
    } else {
    echo json_encode(["erro" => 'erro_db', "message" => 'Erro ao tentar localizar registro de email.']);
    }
    
    if($usuario_existe || $email_existe){
        $retorno_get = '';
        if($usuario_existe){
            $retorno_get.="erro_usuario=1&";
        }

        if($email_existe){
            $retorno_get.="erro_email=1&";
        }

        echo json_encode(["erro" => 'conta_existe', "message" => $retorno_get]);
        die();
    }

    //Inserir no BD
    $response = $db->prepare("INSERT INTO usuarios(usuario, email, senha) VALUES ('$usuario', '$email', '$senha')");
    if($response->execute()){
        echo json_encode(["erro" => null, "message" => 'Conta criada com sucesso.']);
    } else {
        echo json_encode(["erro" => 'conta_nao_criada', "message" => 'Erro ao tentar criar conta.']);
    }
?>