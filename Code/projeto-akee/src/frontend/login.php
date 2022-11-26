<?php 
	$erro = isset($_GET['erro']) ? $_GET['erro'] : 0;
    $mensagem = isset($_GET['msg']) ? $_GET['msg'] : 0; 
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akee - Login</title>

    <!-- bootstrap - link cdn -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="src\style\style.css" />
</head>
<body>
    <div class="background">
        <?php
            /* ERRO LOGIN INVÁLIDO */
            if($erro == 1){
                echo '<div class="msg-error">';
                echo '<p>Usuário ou Senha inválidos!</p>';
                echo '</div>';
            }

            /* MENSAGENS AO CRIAR CONTA */
            if($mensagem == 'successful'){
                echo '<div class="msg-success">';
                echo "<p>Conta criada com sucesso!</p>";
                echo '</div>';
            }
            if($mensagem == 'erro'){
                echo '<div class="msg-error">';
                echo "<p>Erro interno, tente mais tarde!</p>";
                echo '</div>';
            }
        ?>
        <div class="box" style="">
            <img id="logo" src="imagens\logo_transparent.png" alt="logomarca">
            <div class="campo1">
                <h1>Login</h1>
                <form method="post" action="" id="formLogin">
                    <div class="container-input">
                        <input class="textBox" type="usuario" id="usuario" name="usuario" placeholder="Usuário" required="required">
                    </div> 
                    <div class="container-input">
                        <input class="textBox" type="password" id="senha" name="senha" placeholder="Senha" required="required">
                    </div>
                    <input class="botao1" type="submit" value="Entrar">
                </form>
            </div>
            <div class="campo2">
                <p>Ainda não possui conta?</p>
                <a class="botao2" href="signin">Cadastre-se</a>
            </div>
        </div>
    </div>
</body>
</html>