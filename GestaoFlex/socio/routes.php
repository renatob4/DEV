<?php
    // ==========================================================
    // ROUTES
    // ==========================================================

    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }
    
    //vefigica pagina a ser carregada
    $a = 'inicio';
    if(isset($_GET['a'])){
        $a = $_GET['a'];
    }

    //verificar o login ativo
    if(!funcoes::VerificarLoginSocio()){
        //casos especiais
        $routes_especiais = [
            'recuperar_senha',
            'setup',
            'setup_criar_bd',
            'setup_inserir_utilizadores',
            'setup_inserir_clientes',
            'cadastrar_utilizador'
        ];
        //bypass do sistema normal
        if(!in_array($a, $routes_especiais)){
            $a='login';
        }   
    }


    switch ($a) {
        // ========================= LOGIN/LOGOUT =============================
        case 'login':                          include_once('users/login.php'); break;

        case 'logout':                         include_once('users/logout.php'); break;

        case 'recuperar_senha':                include_once('users/recuperar_senha.php'); break;

        // ============================ PERFIL ================================
        case 'perfil':                         include_once('users/perfil/perfil_menu.php'); break;

        case 'perfil_alterar_senha':           include_once('users/perfil/perfil_alterar_senha.php'); break;

        case 'perfil_alterar_email':           include_once('users/perfil/perfil_alterar_email.php'); break;

        // ======================== OPÇÕES DO ADM ==============================

        case 'utilizadores_gerir':             include_once('admin/utilizadores_gerir.php'); break;

        case 'utilizadores_adicionar':         include_once('admin/utilizadores_adicionar.php'); break;

        case 'editar_utilizador':              include_once('admin/utilizadores_editar.php'); break;

        case 'editar_permissoes':              include_once('admin/utilizadores_editar_permissoes.php'); break;

        case 'eliminar_utilizador':            include_once('admin/utilizadores_eliminar.php'); break;

        // ============================ PAGINAS ===============================
        //Apresentar a pagina inicial.
        case 'inicio':                         include_once('inicio.php'); break;
        //Apresenta a pagina about
        case 'about':                          include_once('about.php'); break;
        //Apresenta o menu do setup
        case 'setup':                          include_once('setup/setup.php'); break;

        // ============================ SETUP =================================
        //Criar a base de dados
        case 'setup_criar_bd':                 include_once('setup/setup.php'); break;
        //Inserir utilizadores
        case 'setup_inserir_utilizadores':     include_once('setup/setup.php'); break;
        //Inserir utilizadores
        case 'setup_inserir_clientes':         include_once('setup/setup.php'); break;

        // ========================== CLIENTES ================================
        //Lista de clientes
        case 'clientes_listagem':              include_once('clientes/clientes_listagem.php'); break;

        case 'clientes_dados':                 include_once('clientes/clientes_dados.php'); break;

        case 'clientes_eliminar':              include_once('clientes/clientes_eliminar.php'); break;

        // =========================== SOCIOS =================================

        case 'cadastrar_utilizador':           include_once('admin/utilizadores_cadastrar.php'); break;

        // ========================== NEGOCIOS ================================

        case 'negocios_nova_loja':             include_once('negocios/negocios_nova_loja.php'); break;

        case 'negocios_editar_loja':           include_once('negocios/negocios_editar_loja.php'); break;

        // =========================== ESTOQUE ================================

        case 'gerenciar_estoque':              include_once('estoque/gerenciar_estoque.php'); break;

        case 'entrada_produtos':               include_once('estoque/entrada_produtos.php'); break;

        case 'saida_produtos':                 include_once('estoque/saida_produtos.php'); break;

        case 'cadastro_produtos':              include_once('estoque/cadastro_produtos.php'); break;
    }        
?>                    

