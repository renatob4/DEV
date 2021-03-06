<?php

   // ==========================================================
   // PERFIL - MENU INICIAL
   // PERMISSAO NECESSARIA INDICE = 0
   // ==========================================================

    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }

    $erro = false;
    $mensagem = '';

    //Verifica se utilizador tem permissão
    if(!funcoes::Permissao(1)){
        $erro = true;
        $mensagem = 'Não a tem permissão necessaria para acessar essa funcionalidade';
    }

    //Vai buscar todas as informações do utilizador
    $gestor = new cl_gestorBD();
    $parametros = [
        ':cd_login'    =>  $_SESSION['cd_login_partner']
    ];

    $dados = $gestor->EXE_QUERY(
        'SELECT * FROM tab_partner 
         WHERE cd_login = :cd_login', $parametros);

?>

<?php if($erro) :?>

    <div class="text-center m-3">
        <h3><?php echo $mensagem ?></h3>
        <a href="?a=inicio" class="btn btn-primary btn-size-150">Voltar</a>
    </div>

<?php else : ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col card m-3 p-3">
            <h4 class="text-center">PERFIL DE UTILIZADOR</h4>
                <!--DADOS DO UTILIZADOR-->
                <h5><i class="fa fa-user" aria-hidden="true"></i> <?php echo $dados[0]['nm_partner'] ?></h5>
                <p><i class="fa fa-envelope" aria-hidden="true"></i> <?php echo $dados[0]['ds_email'] ?></p>
                
            </div>  
        </div>
        <div class="text-center">
                <!--Voltar-->      
                <a href="?a=inicio" class="btn btn-primary btn-size-150 m-3">Voltar</a>
        </div>
    </div>

<?php endif;?>