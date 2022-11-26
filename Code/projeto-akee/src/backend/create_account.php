<?php 
	$usuario = $_POST['usuario'];
	$email = $_POST['email'];
	$senha = $_POST['senha'];

	$init = curl_init('http://localhost/api-akeev2/user/create-account');
	curl_setopt($init, CURLOPT_RETURNTRANSFER, true);

	$dados = array(
		"usuario" => $usuario, 
		"email" => $email,
		"senha" => $senha
	);

	curl_setopt($init, CURLOPT_POST, true);
	curl_setopt($init, CURLOPT_POSTFIELDS, $dados);
	curl_exec($init);
	$content = curl_multi_getcontent($init);
	curl_close($init);

	$response = json_decode($content);
	
	if($response->erro == null){
		//CONTA CRIADA COM SUCESSO
		header('Location: ./&msg=successful');
		}

	if(isset($response->erro)){
		if($response->erro == 'conta_existe'){
			header('Location: ./signin&'.$response->message);
		}
		if($response->erro == 'conta_nao_criada'){
			echo $response->message;
		}
		if($response->erro == 'erro_db'){
			header('Location: ./&msg=erro');
		}
	}
?>

