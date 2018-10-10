<?php
    // ==========================================================
    // Eliminar cliente (Via ID)
    // ==========================================================

    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }

    $id_cliente = -1;
    if(isset($_GET['id'])){
        $id_cliente = $_GET['id'];
    }

    //variaveis
    $erro = false;
    $sucesso = false;
    $mensagem = '';

    //carregar os dados dos clientes
    $gestor = new cl_gestorBD();

    $parametros = [ 'cd_login'    =>  $id_cliente ];  
    $dados = $gestor->EXE_QUERY('SELECT * FROM tab_customer WHERE cd_login = :cd_login', $parametros);

    //verifica se o cliente existe
    if(count($dados)==0){
        $erro = true;
        $mensagem = "Cliente não encontrado.";
    }

    //Eliminar cliente
    if(!$erro){
        if(isset($_GET['eliminar'])){
            $eliminar = $_GET['eliminar'];
            if($eliminar){
                $gestor->EXE_NON_QUERY('DELETE FROM tab_customer WHERE cd_login = :cd_login', $parametros);
                $sucesso = true;
                $mensagem = "Cliente eliminado com sucesso!";
            }
        }
    }
?>   

<div class="container">
    <div class="row mt-3 mb-3">
        <div class="col-sm-6 offset-sm-3 text-center card">

            <?php if($erro) : ?>
                <p><?php echo $mensagem ?></p>
                <div class="text-center m-2"><a href="?a=clientes_listagem" class="btn btn-primary btn-size-150">Voltar</a></div>
            <?php else : ?>
                <?php if($sucesso) : ?>
                    <p><?php echo $mensagem ?></p>
                    <div class="text-center m-2"><a href="?a=clientes_listagem" class="btn btn-primary btn-size-150">Voltar</a></div>
                <?php else : ?>
                    <p>Pretende eliminar o cliente: <b><?php echo $dados[0]['nm_customer'] ?></b>?</p>
                    <div>
                        <a href="?a=clientes_listagem" class="btn btn-primary m-2 btn-size-150">Não</a> 
                        <a href="?a=clientes_eliminar&id=<?php echo $id_cliente ?>&eliminar=true" class="btn btn-primary m-2 btn-size-150">Sim</a>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

        </div>
    </div>
</div>