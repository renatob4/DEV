<?php 
// ==========================================================
// EDIÇÃO DE UTILIZADORES - NECESSARIA PERMISSAO DE ADM - 0
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

$erro = false;
$sucesso = false;
$mensagem = '';

if(!$erro_permissao){
    //buscar dados do utilizador
    $parametros = [
        ':cd_login'    =>  $id_utilizador
    ];
    $dados_utilizador = $gestor->EXE_QUERY('SELECT * FROM tab_partner WHERE cd_login = :cd_login', $parametros);
    //verifica se existem dados do utilizador
    if(count($dados_utilizador) == 0){
        $erro = true;
        $mensagem = 'Não foram encontrados dados do Sócio.';
    }
}
    // ==============================================================
    // POST
    // ==============================================================
    if($_SERVER['REQUEST_METHOD']== 'POST'){
        
        //buscar os dados das texts
        $nome = $_POST['text_nome'];
        $email = $_POST['text_email'];
        
        //verificações - verifica se existe outro utilizador com o mesmo email
        $parametros = [
            ':cd_login'     => $id_utilizador,
            ':ds_email'     => $email
        ];        
        $temp = $gestor->EXE_QUERY('SELECT * FROM tab_partner
                                    WHERE cd_login <> :cd_login
                                    AND ds_email = :ds_email', $parametros);
        if(count($temp) != 0){
            $erro = true;
            $mensagem = 'Já existe outro Sócio com o mesmo email.';
        }

        // ========================================
        // atualiza os dados na base de dados
        if(!$erro){
            $parametros = [
                ':cd_login'    => $id_utilizador,
                ':nm_partner'  => $nome,
                ':ds_email'    => $email,
                ':dt_updated'  => DATAS::DataHoraAtualBD()
            ];  
            
            $gestor->EXE_NON_QUERY(
                'UPDATE tab_partner SET
                 nm_partner  = :nm_partner,
                 ds_email = :ds_email,
                 dt_updated = :dt_updated
                 WHERE cd_login = :cd_login', $parametros);
            
            //sucesso
            $sucesso = true;
            $mensagem = 'Dados atualizados com sucesso.';
            $parametros = [':cd_login' => $id_utilizador];
            $dados_utilizador = $gestor->EXE_QUERY('SELECT * FROM tab_partner WHERE cd_login = :cd_login', $parametros);
        }
    }
?>

<!--________________________________________________________________________ HTML ____________________________________________________________________________-->

<?php if($erro_permissao) : ?>
    <?php include('../class/sem_permissao.php')?>
<?php else : ?>

    <!--erro de falta de dados-->
    <?php if($erro) : ?>

        <div class="container">
            <div class="row mt-5 mb-5">
                <div class="col-md-6 offset-md-3 text-center">
                    <p class="alert alert-danger"><?php echo $mensagem ?></p>
                    <a href="?a=utilizadores_gerir" class="btn btn-primary btn-size-100">Voltar</a>
                </div>
            </div>
        </div>

    <?php else : ?>

    <!--Apresenta uma mensagem de sucesso-->
    <?php if($sucesso): ?>
        <div class="alert alert-success text-center">
            <?php echo $mensagem ?>
        </div>
    <?php endif; ?>

    <!--Formulario com os dados para alteração-->
    <div class="container">
        <div class="row card mt-3 mb-3">
            <h4 class="text-center mt-4">Editar dados do Sócio</h4>
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="mt-3 mb-3">
                        <form action="?a=editar_utilizador&id=<?php echo $id_utilizador ?>" method="post">
                            <div class="form-group">
                                <label>Sócio: </label>
                                <p><strong><?php echo $dados_utilizador[0]['cd_login'] ?></strong></p>

                                <!-- nome completo -->
                                <div class="form-group">
                                    <label>Nome:</label>
                                    <input type="text"
                                        name="text_nome"
                                        class="form-control"
                                        pattern=".{3,50}"
                                        title="Entre 3 e 50 caracteres."
                                        placeholder="<?php echo $dados_utilizador[0]['nm_partner'] ?>"
                                        required>
                                </div>

                                <!-- email -->
                                <div class="form-group">
                                    <label>Email:</label>
                                    <input type="email"
                                        name="text_email"
                                        class="form-control"
                                        pattern=".{3,50}"
                                        title="Entre 3 e 50 caracteres."
                                        placeholder="<?php echo $dados_utilizador[0]['ds_email'] ?>"
                                        required>
                                </div>

                                <div class="text-center">
                                    <a href="?a=utilizadores_gerir" class="btn btn-primary btn-size-150">Cancelar</a>
                                    <button class="btn btn-primary btn-size-150">Atualizar</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php endif; ?>

<?php endif; ?>