<?php
    require_once('./classes/db.class.php');

    if($action == '' && $param == ''){
        echo json_encode(['erro' => 'Acao nao definida ou esta incorreta.']);
        exit;
    }

    if($action == 'add' && $param == ''){
        var_dump ('Recebendo dados do outro servidor ...');

        $postagem = $_POST['postagem'];
        $id_usuario = $_POST['id_usuario'];
    
        if($postagem != ''){
            $db = DB::connect_posts_db();
            $rs = $db -> prepare("INSERT INTO post(id_usuario, conteudo)values($id_usuario, '$postagem')");
            $exec = $rs -> execute();

            if($exec){
                echo json_encode(["dados" => 'Postagem inserida com sucesso.']);
            }else{
                echo json_encode(["dados" => 'Houve algum erro ao inserir postagem.']);
            }
        }

    }else if($action != 'add'){
        echo json_encode(['erro' => 'Acao nao definida ou esta incorreta.']);
        exit;
    }
?>