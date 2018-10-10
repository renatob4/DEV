<?php 
// ==========================================================
// EDIÇÃO PERMISSOES DE UTILIZADORES - NECESSARIA PERMISSAO DE ADM - 0
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

//=========================================================================================================================

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //permissoes
    $total_permissoes = (count(include('../class/permissoes.php')));
    $permissoes = [];
    if(isset($_POST['check_permissao'])){
        $permissoes = $_POST['check_permissao'];
    }
    $permissoes_finais = '';
    for ($i=0; $i < 32; $i++) { 
        if($i<$total_permissoes){
            if(in_array($i, $permissoes)){
                $permissoes_finais.='1';        
            } else {
                $permissoes_finais.='0';
            }
        } else {
            $permissoes_finais.='1';
        }        
    }
    //atualizar as permissões na base de dados
    $parametros = [
        ':cd_login'         => $id_utilizador,
        ':cd_permition'     => $permissoes_finais,
        ':dt_updated'       => DATAS::DataHoraAtualBD()
    ];
    $gestor->EXE_NON_QUERY('UPDATE tab_partner SET 
                            cd_permition = :cd_permition,
                            dt_updated = :dt_updated
                            WHERE cd_login = :cd_login', $parametros);
    
    //recarregar os dados do utilizador
    $parametros = [':cd_login' => $id_utilizador];
    $dados_utilizador = $gestor->EXE_QUERY('SELECT * FROM tab_partner 
                                            WHERE cd_login = :cd_login', $parametros);
    $sucesso = true;
    $mensagem = 'Permissoes atualizadas com sucesso.';
}

?>

<!--________________________________________________________________________ HTML ____________________________________________________________________________-->

<?php if($erro_permissao) : ?>
    <?php include('../class/sem_permissao.php') ?>
<?php else : ?>

    <!-- mensagem de sucesso -->
    <?php if($sucesso) :?>
    <div class="alert alert-success text-center"><?php echo $mensagem ?></div>
    <?php endif; ?>

    <div class="container">    
        <div class="row mt-3 mb-3 p-3">
            <div class="col-8 offset-2 card p-4">
                <h4 class="text-center">Editar Permissões</h4>

                 <!-- dados do utilizador -->
                 <hr><p>Sócio: <b><?php echo $dados_utilizador[0]['nm_partner'] ?></b></p><hr>

                    <form action="?a=editar_permissoes&id=<?php echo $id_utilizador ?>" method="post"> 
                        <!-- Caixa de permissoes -->
                        <div class="caixa_permissoes">
                            <?php 
                                $permissoes = include('../class/permissoes.php');
                                $id = 0;
                                foreach($permissoes as $permissao){ ?>                    
                                    <div class="checkbox text-left">
                                        <label>
                                            <?php 
                                                //buscar o valor da permissao no utilizador
                                                $ptemp = substr($dados_utilizador[0]['cd_permition'], $id, 1);
                                                $checked = $ptemp == '1' ? 'checked' : '';
                                            ?>
                                            <input type="checkbox" name="check_permissao[]" id="check_permissao" value="<?php echo $id?>" <?php echo $checked ?>>
                                            <span class="permissao-titulo"><?php echo $permissao['permissao'] ?></span>
                                        </label>
                                        <p class="permissao-sumario"><?php echo $permissao['sumario'] ?></p>
                                    </div>
                            <?php $id++; } ?>
                            <!--Todas | Nenhuma-->
                            <div class="text-left">
                                <a href="#" onClick="checks(true); return false">Todas as permissões</a> | <a href="#" onClick="checks(false); return false">Nenhuma permissão</a>
                            </div>  
                        </div>

                        <!-- botões -->
                        <div class="text-center mt-5">
                            <a href="?a=utilizadores_gerir" class="btn btn-primary btn-size-150">Cancelar</a>
                            <button type="submit" class="btn btn-primary btn-size-150">Atualizar</button>
                        </div>
                    </form>                   
            </div>
        </div>
    </div>

<?php endif; ?>

