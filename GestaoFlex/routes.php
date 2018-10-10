<?php
    // ==========================================================
    // ROUTES
    // ==========================================================

    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }
    //vefigica pagina a ser carregada
    $a = 'home';
    if(isset($_GET['a'])){
        $a = $_GET['a'];
    }
 
    switch ($a) {

        case 'home':                include_once('webgeral/inicio.php'); break;

        // ========================= LOGIN/LOGOUT =============================

        case 'login':               include_once('clientes/login.php'); break;

        case 'logout':              include_once('clientes/logout.php'); break;

        case 'signup':              include_once('clientes/signup.php'); break;

        // ============================ SCRIPTS ===============================

        case 'validar':             include_once('clientes/validar_cliente.php'); break;

        // ============================ CLIENTE ===============================

        case 'perfil':              include_once('clientes/perfil.php'); break;

    }    
        
?>                    

