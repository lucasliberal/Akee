<?php
	session_start();

	if(!isset($_SESSION['usuario'])){
		header('Location: ./&erro=1');
	}

	$id_usuario = $_SESSION['id_usuario'];
	
	//Trazendo postagens da API
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
		<title>Akee - Buscar usuários</title>
		<!-- jquery - link cdn -->
		<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
		<!-- bootstrap - link cdn -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link rel="stylesheet" href="src\style\style.css">

		<script type="text/javascript">

			$(document).ready(function(){

				$('#btn-pesquisar').click(function(){
					if($('#input-busca').val().length > 0){
						
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

    <div class="barra-superior">
        <img id="logo-navbar" src="imagens\logo_transparent_branco.png" alt="Logomarca akee">
        <a href="./home" id="siteName">AKEE</a>
        <a class="glyphicon glyphicon-log-out" style="text-decoration: none;" id="btn-sair" href="./logout"><p>Sair</p></a>
        <a class="glyphicon glyphicon-home" style="text-decoration: none;" id="btn-home" href="./home"><p>Início</p></a>
    </div>

    <div class="container">
        <!-- painel da esquerda -->
        <div class="col-md-3" id="painel-esquerda">
            <h4 id="username" ><?= $_SESSION['usuario'] ?></h4>
            <div class="campo-info">
                <div class="user-info">
                    <h5>Postagens</h5>
                    <p><?= $qtd_posts ?></p>
                </div>
                
                <div class="user-info">
                    <h5>Seguidores</h5>
                    <p><?= $qtd_seguidores ?></p>
                </div>
            </div>
        </div>

        <!-- painel central -->
        <div class="col-md-9">
            <div class="panel-body">
                <div id="container-publicacao">
					<form id="form_procurar_pessoas" class="input-form" method="post">
						<input type="text" id="input-busca" name="nome_pessoa" class="inputBox" placeholder="Quem você está procurando?" maxlength="23"></input>
                    	<button id="btn-pesquisar" type="button">Procurar</button>
					</form> 
                </div>
            </div>
            <div id="pessoas" class="list-group">
                
            </div>
        </div>

    </div>
    </div>

<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>