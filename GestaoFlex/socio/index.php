<?php
    // ==========================================================
    // INDEX - AREA DE SOCIOS
    // ==========================================================

    //Controle de sessão.
    session_start();

    if(!isset($_SESSION['a'])){
        $_SESSION['a'] = 'inicio';
    }

    
    //incluir funções
    include_once('../class/funcoes.php');
    //incluir Classe de gestao de datas
    include_once('../class/cl_datas.php');
    //incluir classe de emails
    include_once('../class/emails.php');
    //inclui as funções necessarias do sistemas
    include_once('../class/gestorBD.php');
    //barra do utilizador
    include_once('users/barra_utilizador.php');
    //Cabeçalho
    include_once('_cabecalho.php');
    //Mecanismo de fluxo de paginas.
    include_once('routes.php');
    //Rodapé
    include_once('_rodape.php');
?>