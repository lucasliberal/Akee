<?php
    if($page == ''){
        if($method == 'POST')
            include_once 'backend/authentication.php';
        else              
            include_once 'frontend/login.php';
    }
    
    else if($page == 'home'){
        include_once 'frontend/home.php';
    }
    
    else if($page == 'logout'){
        include_once 'backend/logout.php';
    }
    
    else if($page == 'search'){
        include_once 'frontend/search_users.php';
    }
    
    else if ($page == 'signin'){
        if($method == 'POST')   
            include_once 'backend/create_account.php';
        else                    
            include_once 'frontend/register.php';
    }

    else{  
        echo 'Página não encontrada';
    }
?>