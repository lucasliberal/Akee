<?php
    if ($api == 'posts'){
        if($action == 'add'){
            include_once 'postagem/post.php';
        }
        if ($action == 'list'){
            include_once 'postagem/get.php';
        }
    }else if ($api == 'user'){
        if ($action == 'create-account')
            include_once 'usuario/create-account.php';
        if ($action == 'authentication'){
            include_once 'usuario/auth.php';
        } 
        if ($action == 'info'){
            include_once 'usuario/user-info.php';
        }
        if ($action == 'search-user'){
            include_once 'usuario/search-user.php';
        }
        if ($action == 'follow'){
            include_once 'usuario/follow.php';
        }
        if ($action == 'unfollow'){
            include_once 'usuario/unfollow.php';
        }
        if ($action == 'list'){
            include_once 'usuario/get.php';
        }
    }else {
        echo 'endereco invalido.';
    }
?>