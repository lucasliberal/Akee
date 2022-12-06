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

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <!-- jquery - link cdn -->
		<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <!-- bootstrap - link cdn -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link rel="stylesheet" href="src\style\style.css">

        <script type="text/javascript">
            function auto_grow(element) {
                element.style.height = "50px";
                element.style.height = ((element.scrollHeight)+5)+"px";
            }

			$(document).ready(function(){
				$('#btn_postar').click(function(){
					if($('#input-post').val().length > 0){
						
						$.ajax({
							url: 'src/backend/addPost.php',
							method: 'post',
							data: $('#input-form').serialize(),
							success: function(data){
								$('#input-post').val('');
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

    <div class="barra-superior">
        <img id="logo-navbar" src="imagens\logo_transparent_branco.png" alt="Logomarca akee">
        <a href="" id="siteName">AKEE</a>
        <a class="glyphicon glyphicon-log-out" style="text-decoration: none;" id="btn-sair" href="./logout"><p>Sair</p></a>
		<a class="glyphicon glyphicon-search" style="text-decoration: none;" id="btn-buscar" href="./search"><p>Buscar</p></a>
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
				<form class="input-form" class="input-group">
					<textarea type="text" oninput="auto_grow(this)" id="input-post" name="input-post" class="inputBox" placeholder="O que está acontecendo agora?" maxlength="140"></textarea>
					<button id="btn_postar" type="button">Postar</button>
				</form>
            </div>

            <div id="posts" class="list-group"></div>
        </div>

    </div>
    </div>

	<!-- JavaScript Bundle with Popper -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>