<?php 
// ==========================================================
// ELIMINAR UTILIZADORES - NECESSARIA PERMISSAO DE ADM - 0
// ==========================================================

//verificar a sessão.
if(!isset($_SESSION['a'])){
    exit();
}

//verificar permissão de acesso
$erro_permissao = false;
if(!funcoes::Permissao(0)){
    $erro_permissao = true;
}

//verificar se pode editar as permissoes do utilizador
$id_utilizador = -1;
if(isset($_GET['id'])){
    $id_utilizador = $_GET['id'];
}else{
    $erro_permissao = true;
}

//verifica se pode avançar
if($id_utilizador == 1 || $id_utilizador == $_SESSION['cd_login_partner']){
    $erro_permissao = true;
} 

$dados_utilizador = null;
$gestor = new cl_gestorBD();
if(!$erro_permissao){
    //buscar dados do utilizador
    $parametros = [
        ':cd_login'    =>  $id_utilizador
    ];
    $dados_utilizador = $gestor->EXE_QUERY('SELECT * FROM tab_partner WHERE cd_login = :cd_login', $parametros);
}

$sucesso = false;
//verifica se foi dada resposta afirmativa para eliminação
if(isset($_GET['r'])){
    if($_GET['r'] == 1){
        //remover utilizador da base
        $parametros = ['cd_login'  =>  $id_utilizador];
        $gestor->EXE_NON_QUERY('DELETE FROM tab_partner WHERE cd_login = :cd_login', $parametros);
        //informa o sistema que a remoção foi bem sucedida
        $sucesso = true;
    }
}

?>

<!--________________________________________________________________________ HTML ____________________________________________________________________________-->


<?php if($erro_permissao) : ?>
    <?php include('../class/sem_permissao.php')?>
<?php else : ?>

<?php if($sucesso) : ?>
    <div class="container">
        <div class="row mt-5 mb-5">
            <div class="col-md-6 offset-md-3 text-center">
                <p class="alert alert-success">Sócio removido com sucesso!</p>
                <a href="?a=utilizadores_gerir" class="btn btn-primary btn-size-100">Voltar</a>
            </div>
        </div>
    </div> 

    <?php else : ?>
            <div class="container">
                    <div class="row justify-content-center">
                        <div class="col card m-3 p-3">
                            <h4 class="text-center">Remover Sócio</h4>               
                        </div>
                        <!--Dados do utilizador-->
                        <div class="row">
                            <div class="col-md-8 offset-md-2 card mt-3 mb-3 p-3">

                                <p class="text-center">Tem a certeza que pretende eliminar o Sócio:<br><strong>
                                <?php echo $dados_utilizador[0]['nm_partner'] ?></strong>, cujo email é <strong><?php echo $dados_utilizador[0]['ds_email'] ?></strong> ?</p>

                                <!-- botões não e sim -->
                                <div class="text-center mt-3 mb-3">
                                    <a href="?a=utilizadores_gerir" class="btn btn-primary btn-size-100">Não</a>
                                    <a href="?a=eliminar_utilizador&id=<?php echo $id_utilizador ?>&r=1" class="btn btn-primary btn-size-100">Sim</a>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
    <?php endif; ?>

<?php endif; ?>