<?php 
	session_start();

	if(!isset($_SESSION['usuario'])){
		header('Location: ./&erro=1');
	}

	$id_usuario = $_SESSION['id_usuario'];
	$seguir_id_usuario = $_POST['seguir_id_usuario'];


	if($seguir_id_usuario != '' && $id_usuario != ''){
		$init = curl_init('http://localhost/api-akeev2/user/follow');
		curl_setopt($init, CURLOPT_RETURNTRANSFER, true);

		$dados = array(
			"id_usuario" => $id_usuario, 
			"seguir_id_usuario" => $seguir_id_usuario
		);
	
		curl_setopt($init, CURLOPT_POST, true);
		curl_setopt($init, CURLOPT_POSTFIELDS, $dados);
		curl_exec($init);
		curl_close($init);	
	}
?>

