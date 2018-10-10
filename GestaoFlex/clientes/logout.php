<?php
    // ==========================================================
    // ROUTES
    // ==========================================================

    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }

    $visitante = $_SESSION['nm_customer'];
    //Executa a destruição da sessão do cliente
    funcoes::DestroiSessaoCliente();
?>

<div class="container">
    <div class="row">
        <div class="col-sm-4 offset-sm-4 text-center p-3 card mt-3 mb-3">
            <p style="color: black">Até a proxima visita <b><?php echo $visitante ?></b>.</p>
            <a href="?a=home" class="btn btn-primary">Ok</a>
        </div> 
    </div>
</div>