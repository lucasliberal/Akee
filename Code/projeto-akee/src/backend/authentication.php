<?php 
	session_start();

	$usuario = $_POST['usuario'];
	$senha = $_POST['senha'];

	$init = curl_init('http://localhost/api-akeev2/user/authentication');
	curl_setopt($init, CURLOPT_RETURNTRANSFER, true);

	$dados = array(
		"usuario" => $usuario, 
		"senha" => $senha
	);

	curl_setopt($init, CURLOPT_POST, true);
	curl_setopt($init, CURLOPT_POSTFIELDS, $dados);
	curl_exec($init);
	$content = curl_multi_getcontent($init);
	curl_close($init);	

	$auth = json_decode($content);

	if(isset($auth->user)){
		$_SESSION['id_usuario'] = $auth->user->id;			
		$_SESSION['usuario'] = $auth->user->usuario;
		$_SESSION['email'] = $auth->user->email;
		header('Location: ./home');
	}
	else{
		header('Location: ./&erro=1');
	}
?>