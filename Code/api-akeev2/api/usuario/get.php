<?php
	require_once('./classes/db.class.php');

	if ($param == ''){
		//lista todas as postagens
		$db = DB::connect_users_db();
		$rs = $db->prepare("SELECT id, usuario, email, senha FROM usuarios;");
		$rs->execute();
		$obj = $rs->fetchAll(PDO::FETCH_ASSOC);

		if($obj){
			echo json_encode(["users" => $obj]);
		}else{
			echo json_encode(["users" => 'Nenhum usuario encontrado.']);
		}
	}
    
    if ($param != '') {
		//lista apenas postagens de determinado usuário
		$db = DB::connect_users_db();
		$rs = $db->prepare("SELECT id, usuario, email, senha FROM usuarios WHERE id={$param};");
		$rs->execute();
		$obj = $rs->fetchAll(PDO::FETCH_ASSOC);

		if($obj){
			echo json_encode(["posts" => $obj]);
		}else{
			json_encode(["posts" => 'Nenhum usuario encontrado.']);
		}
	}	
	else{
		echo json_encode(["erro" => 'Acao nao definida ou esta incorreta.']);
	}

?>