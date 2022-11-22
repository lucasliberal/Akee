<?php
	session_start();

	if(!isset($_SESSION['usuario'])){
		header('Location: erro-login');
	}

	$id_usuario = $_SESSION['id_usuario'];
	
	//Trazendo postagens da API
	$dados = file_get_contents('http://localhost/api-akeev2/posts/list');
	$dadosDecode = json_decode($dados);

	$inputData = array(
		"id_usuario" => $id_usuario, 
	);

	// recupera qtd de postagens
	$init = curl_init('http://localhost/api-akeev2/user/info/num-posts');
	curl_setopt($init, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($init, CURLOPT_POST, true);
	curl_setopt($init, CURLOPT_POSTFIELDS, $inputData);
	curl_exec($init);
	$response = curl_multi_getcontent($init);
	curl_close($init);	
	$json = json_decode($response);

	foreach($json->output as $output){
		$qtd_posts = $output->qtd_posts;
	}

	// recuperar qtd de seguidores
	$init = curl_init('http://localhost/api-akeev2/user/info/num-followers');
	curl_setopt($init, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($init, CURLOPT_POST, true);
	curl_setopt($init, CURLOPT_POSTFIELDS, $inputData);
	curl_exec($init);
	$response = curl_multi_getcontent($init);
	curl_close($init);	
	$json = json_decode($response);
	
	foreach($json as $output){
		$qtd_seguidores = $output->qtd_followers;
	}
?>

<!DOCTYPE HTML>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">

		<title>Akee - Buscar usuários</title>
		
		<!-- jquery - link cdn -->
		<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

		<!-- bootstrap - link cdn -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

		<script type="text/javascript">

			$(document).ready(function(){

				$('#btn_procurar_pessoa').click(function(){
					if($('#nome_pessoa').val().length > 0){
						
						$.ajax({
							url: 'src/backend/get_users.php',
							method: 'post',
							data: $('#form_procurar_pessoas').serialize(),
							success: function(data){
								$('#pessoas').html(data);


								$('.btn_seguir').click(function(){
									var id_usuario = $(this).data('id_usuario');

									$('#btn_seguir_'+id_usuario).hide();
									$('#btn_deixar_seguir_'+id_usuario).show();

									$.ajax({
										url: 'src/backend/follow.php',
										method: 'post',
										data: { seguir_id_usuario: id_usuario },
										success: function(data){
											alert('Registro efetuado com sucesso');
										}
									});
								});

								$('.btn_deixar_seguir').click(function(){
									var id_usuario = $(this).data('id_usuario');

									$('#btn_seguir_'+id_usuario).show();
									$('#btn_deixar_seguir_'+id_usuario).hide();

									$.ajax({
										url: 'src/backend/unfollow.php',
										method: 'post',
										data: { deixar_seguir_id_usuario: id_usuario },
										success: function(data){
											alert('Registro removido com sucesso');
										}
									});
								});
							} 
						});
					}
				});
			});

		</script>
	
	</head>

	<body>

		<!-- Static navbar -->
	    <nav class="navbar navbar-default navbar-static-top">
	      <div class="container">
	        <div class="navbar-header">
	          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
	            <span class="sr-only">Toggle navigation</span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
	          <img src="imagens/logo_transparent.png" />
	        </div>
	        
	        <div id="navbar" class="navbar-collapse collapse">
	          <ul class="nav navbar-nav navbar-right">
	          	<li><a href="home">Home</a></li>
	            <li><a href="./logout">Sair</a></li>
	          </ul>
	        </div><!--/.nav-collapse -->
	      </div>
	    </nav>
	    <div class="container">
	    	<!-- painel da esquerda -->
	    	<div class="col-md-3">
	    		<div class="panel panel-default">
	    			<div class="panel-body">
	    				<h4><?= $_SESSION['usuario'] ?></h4>

	    				<hr />
	    				<div class="col-md-6">
	    					POSTAGENS <br/> <?= $qtd_posts ?>
	    				</div>
	    				<div class="col-md-6">
	    					SEGUIDORES <br/> <?= $qtd_seguidores ?>
	    				</div>
	    			</div>
	    		</div>
	    	</div>

	    	<!-- painel central -->
	    	<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-body">
						<form id="form_procurar_pessoas" class="input-group">
							<input type="text" id="nome_pessoa" name="nome_pessoa" class="form-control" placeholder="Quem você está procurando?" maxlength="140" />
							<span class="input-group-btn">
								<button class="btn btn-default" id="btn_procurar_pessoa" type="button">Procurar</button>
							</span>
						</form>
					</div>

					<div id="pessoas" class="list-group"></div>

				</div>
			</div>

			<!-- painel da direita -->
			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-body">
					</div>
				</div>
			</div>

		</div>
	    </div>
	
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</body>
</html>