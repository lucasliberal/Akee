<?php 
	session_start();

	if(!isset($_SESSION['usuario'])){
		header('Location: ./&erro=1');
	}

	$input_post = $_POST['input-post'];
	$id_usuario = $_SESSION['id_usuario'];

	$init = curl_init('http://localhost/api-akeev2/posts/add');

	curl_setopt($init, CURLOPT_RETURNTRANSFER, true);

	$dados = array(
		"postagem" => $input_post, 
		"id_usuario" => $id_usuario
	);

	curl_setopt($init, CURLOPT_POST, true);
	curl_setopt($init, CURLOPT_POSTFIELDS, $dados);
	curl_exec($init);
	curl_close($init);
?>