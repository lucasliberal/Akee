<?php 
	session_start();

	if(!isset($_SESSION['usuario'])){
		header('Location: erro-login');
	}
	$id_usuario = $_SESSION['id_usuario'];

	//Traz dados JSON da API
	$apiData = file_get_contents("http://localhost/api-akeev2/posts/list");
	$posts = json_decode($apiData);

	foreach($posts->posts as $postagem){

		$init = curl_init('http://localhost/api-akeev2/user/info/username');
		curl_setopt($init, CURLOPT_RETURNTRANSFER, true);
		$dados = array(
			"id_usuario" => $postagem->id_usuario
		);

		curl_setopt($init, CURLOPT_POST, true);
		curl_setopt($init, CURLOPT_POSTFIELDS, $dados);
		curl_exec($init);
		$content = curl_multi_getcontent($init);
		curl_close($init);	
		$json = json_decode($content);
		$username = $json->usuario;

		if($postagem->id_usuario == $id_usuario){
			echo ' <a href="#" class="list-group-item"> ';
			echo ' <h4 class="list-group-item-heading">'.$username.' <small> - '.$postagem->data_inclusao.'</small></h4> ';
			echo '<p class="list-group-item-text">'.$postagem->conteudo.'</p>';
			echo ' </a >';
		}
		
		else{
			//Consulta retorna se o usuario autenticado segue o usuario que fez a postagem
			$init = curl_init('http://localhost/api-akeev2/user/info/isfollowed');
			curl_setopt($init, CURLOPT_RETURNTRANSFER, true);
			$dados = array(
				"id_usuario_postagem" => $postagem->id_usuario,
				"id_usuario" => $id_usuario
			);

			curl_setopt($init, CURLOPT_POST, true);
			curl_setopt($init, CURLOPT_POSTFIELDS, $dados);
			curl_exec($init);
			$content = curl_multi_getcontent($init);
			curl_close($init);	
			$isFollowed = json_decode($content);	

			//Mostra a postagem se o usuario autenticado segue o usuario que fez a postagem
			if (isset($isFollowed)){
				echo ' <a href="#" class="list-group-item"> ';
				echo ' <h4 class="list-group-item-heading">'.$username.' <small> - '.$postagem->data_inclusao.'</small></h4> ';
				echo '<p class="list-group-item-text">'.$postagem->conteudo.'</p>';
				echo ' </a >';
			}	
		}
	}
?>