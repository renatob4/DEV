<?php
    // ==========================================================
    // Dados do cliente (via ID)
    // ==========================================================

    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }

    //Capturar ID do cliente
    $id = -1;
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
    
    //carregar os dados dos clientes
    $gestor = new cl_gestorBD();
    $cliente = null;

    if($id != -1){  
        $parametros = [ 'cd_login'    =>  $id ];
        $dados = $gestor->EXE_QUERY('SELECT * FROM tab_customer WHERE cd_login = :cd_login', $parametros);
        $cliente = $dados[0];
    }
?>   

<div class="container-fluid">
    <?php if($id != -1) :?>
        <!--Apresenta os dados do cliente-->
        <h4><?php echo $cliente['nm_customer'] ?></h4>
    <?php else :?>
        <!--Erro-->
        <div class="text-center"><p class="alert alert-danger p-2">O cliente não existe.</p><a href="?a=clientes_listagem" class="btn btn-primary m-2">Voltar</a></div>
    <?php endif; ?>
</div>