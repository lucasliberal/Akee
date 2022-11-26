<?php
	session_start();

	if(!isset($_SESSION['usuario'])){
		header('Location: ./&erro=1');
	}

	$id_usuario = $_SESSION['id_usuario'];

	$dados = file_get_contents('http://localhost/api-akeev2/posts/list');
	$dadosDecode = json_decode($dados);

	$inputData = array(
		"id_usuario" => $id_usuario, 
	);

	// recupera qtd de postagens e seguidores
	$init = curl_init('http://localhost/api-akeev2/user/info/numberOf');
	curl_setopt($init, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($init, CURLOPT_POST, true);
	curl_setopt($init, CURLOPT_POSTFIELDS, $inputData);
	curl_exec($init);
	$response = curl_multi_getcontent($init);
	curl_close($init);	
	$json = json_decode($response, TRUE);

	$qtd_seguidores = $json['followers']['qtd_followers'];
	$qtd_posts = $json['posts']['qtd_posts'];
?>

<!DOCTYPE HTML>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">

		<title>Akee - Home</title>
		
		<!-- jquery - link cdn -->
		<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

		<!-- bootstrap - link cdn -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="src\style\style.css" />


		<script type="text/javascript">

			$(document).ready(function(){

				$('#btn_post').click(function(){
					if($('#texto_post').val().length > 0){
						
						$.ajax({
							url: 'src/backend/addPost.php',
							method: 'post',
							data: $('#form_post').serialize(),
							success: function(data){
								$('#texto_post').val('');
								atualizaPost(); 
							} 
						});
					}

				});

				function atualizaPost(){
					$.ajax({
						url: 'src/backend/get_posts.php',
						success: function(data){
							$('#posts').html(data);
						}
					});
				}

				atualizaPost();
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
	          <img id="logo_home" src="imagens/logo_transparent.png" />
	        </div>
	        
	        <div id="navbar" class="navbar-collapse collapse">
	          <ul class="nav navbar-nav navbar-right">
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
						<form id="form_post" class="input-group">
							<input type="text" id="texto_post" name="texto_post" class="form-control" placeholder="O que está acontecendo agora?" maxlength="140" />
							<span class="input-group-btn">
								<button class="btn btn-default" id="btn_post" type="button">Publicar</button>
							</span>
						</form>
					</div>

					<div id="posts" class="list-group"></div>

				</div>
			</div>

			<!-- painel da direita -->
			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-body">
						<h4><a href="./search">Procurar por pessoas</a></h4>
					</div>
				</div>
			</div>

		</div>
	    </div>
	
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</body>
</html>