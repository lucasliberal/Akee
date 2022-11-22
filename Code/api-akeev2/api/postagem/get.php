<?php 
	require_once('classes\db.class.php');

	if ($action == 'list' && $param == ''){
		//lista todas as postagens
		$db = DB::connect_posts_db();
		$rs = $db->prepare("SELECT p.id_postagem, p.id_usuario, p.conteudo, DATE_FORMAT(p.data_inclusao, '%d %b %Y %T') AS data_inclusao FROM post AS p ORDER BY data_inclusao DESC;");
		$rs->execute();
		$obj = $rs->fetchAll(PDO::FETCH_ASSOC);

		if($obj){
			echo json_encode(["posts" => $obj]);
		}else{
			echo json_encode(["posts" => 'Usuário nao possui nenhuma postagem.']);
		}
	}else if ($action == 'list' && $param != '') {
		//lista apenas postagens de determinado usuário
		$db = DB::connect_posts_db();
		$rs = $db->prepare("SELECT p.id_postagem, p.id_usuario, p.conteudo, DATE_FORMAT(p.data_inclusao, '%d %b %Y %T') AS data_inclusao FROM post AS p WHERE id_usuario={$param} ORDER BY data_inclusao DESC;");
		$rs->execute();
		$obj = $rs->fetchAll(PDO::FETCH_ASSOC);

		if($obj){
			echo json_encode(["posts" => $obj]);
		}else{
			json_encode(["posts" => 'Usuário nao possui nenhuma postagem.']);
		}
	}	
	else{
		echo json_encode(["erro" => 'Acao nao definida ou esta incorreta.']);
	}
?>
