<?php 
	session_start();

	if(!isset($_SESSION['usuario'])){
		header('Location: erro-login');
	}

	$nome_pessoa = $_POST['nome_pessoa'];
	$id_usuario = $_SESSION['id_usuario'];

	$init = curl_init('http://localhost/api-akeev2/user/search-user');
	curl_setopt($init, CURLOPT_RETURNTRANSFER, true);

	$dados = array(
		"nome_pessoa" => $nome_pessoa, 
		"id_usuario" => $id_usuario
	);

	curl_setopt($init, CURLOPT_POST, true);
	curl_setopt($init, CURLOPT_POSTFIELDS, $dados);
	curl_exec($init);
	$content = curl_multi_getcontent($init);
	curl_close($init);	

	$json = json_decode($content);

	$users = $json->users;

	if($users != null){
		foreach($users as $usuarios){
			echo ' <a href="#" class="list-group-item"> ';
				echo '<strong>'.$usuarios->usuario.'</strong> <small> - '.$usuarios->email.' </small>';
				echo'<p class="list-group-item-text pull-right">';

					$esta_seguindo_usuario_sn = isset($usuarios->id_usuario_seguidor) && !empty($usuarios->id_usuario_seguidor) ? 'S' : 'N';
					$btn_seguir_display = 'block';
					$btn_deixar_seguir_display = 'block';

					if($esta_seguindo_usuario_sn == 'N'){
						$btn_deixar_seguir_display = 'none';
					} else{
						$btn_seguir_display = 'none';
					}

					echo '<button type="button" id="btn_seguir_'.$usuarios->id.'" style="display: '.$btn_seguir_display.'" class="btn btn-default btn_seguir" data-id_usuario="'.$usuarios->id.'">Seguir</button>';

					echo '<button type="button" id="btn_deixar_seguir_'.$usuarios->id.'" style="display: '.$btn_deixar_seguir_display.'" class="btn btn-primary btn_deixar_seguir" data-id_usuario="'.$usuarios->id.'">Deixar de seguir</button>';
				echo'</p>';
				echo '<div class="clearfix"></div>';
			echo ' </a >';
		}

	}else{
		echo 'Usuario nao encontrado';
	}
?>

