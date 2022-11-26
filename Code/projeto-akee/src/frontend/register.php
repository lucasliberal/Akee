<?php
	$erro_usuario 	= isset($_GET['erro_usuario'])	? $_GET['erro_usuario'] : 0;
	$erro_email		= isset($_GET['erro_email']) 	? $_GET['erro_email'] 	: 0;

    
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akee - Cadastre-se</title>

    <!-- bootstrap - link cdn -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="src\style\style.css" />
</head>
<body>
    <div class="background">
        <?php
            if($erro_email && $erro_usuario == 1){
                echo '<div class="msg-error">';
                echo '<p>Usuário e E-mail já cadastrados!</p>';
                echo '</div>';
            }
            else if($erro_usuario == 1){
                echo '<div class="msg-error">';
                echo '<p>Usuário já cadastrado!</p>';
                echo '</div>';
            }
            else if($erro_email == 1){
                echo '<div class="msg-error">';
                echo '<p>E-mail já cadastrado!</p>';
                echo '</div>';
            }
        ?>

        <div class="box" style="">
            <img id="logo" src="imagens\logo_transparent.png" alt="logomarca">
            <div class="campo1">
                <h1>Cadastre-se</h1>
                <form method="post" action="" id="formCadastrarse">
                    <div class="container-input">
                        <input class="textBox" type="text" id="usuario" name="usuario" placeholder="Usuário" required="required">
                        <?php
                            if($erro_usuario == 1){
                                echo '<a class="glyphicon glyphicon-exclamation-sign" style="text-decoration: none;" id="alerta"></a>';
                            }
                        ?>
                    </div>
                    <div class="container-input">
                        <input class="textBox" type="email" id="email" name="email" placeholder="E-mail" required="required">
                        <?php
                            if($erro_email == 1){
                                echo '<a class="glyphicon glyphicon-exclamation-sign" style="text-decoration: none;" id="alerta"></a>';
                            }
                        ?>
                    </div>
                    <div class="container-input">
                        <input class="textBox" type="password" id="senha" name="senha" placeholder="Senha" required="required">
                    </div>             
                    <input class="botao1" type="submit" value="Criar conta">
                </form>
            </div>
            <div class="campo2">
                <p>Já possui conta?</p>
                <a href="./" id="btn_login" class="botao2">Entrar</a>
            </div>
        </div>
    </div>
</body>
</html>

