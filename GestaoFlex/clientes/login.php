<?php 

    // ==========================================================
    // Login do cliente
    // ==========================================================

    //Controle de sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }

    //verifica se os dados de login estão corretos
    $utilizador = $_POST['text_utilizador'];
    $senha = md5($_POST['text_senha']);

    $erro = false;
    $mensagem = '';

    //prepara a query para o login
    $gestor = new cl_gestorBD();
    $parametros = [
        ':cd_login'       =>  $utilizador,
        ':cd_password'    =>  $senha,
    ];
    $dados = $gestor->EXE_QUERY('SELECT * FROM tab_customer WHERE cd_login = :cd_login AND cd_password = :cd_password', $parametros);

    //verifica se existe usuario
    if(count($dados) == 0){
        $erro = true;
        $mensagem = "Não existe utilizador com este ID ou Senha.";
    }
    //Verifica se a conta do cliente ja esta validada
    if(!$erro){
        if($dados[0]['ic_validation'] == 0){
            $erro = true;
            $mensagem = "Esta conta ainda não foi validada, verifique seu email.";
        } else{
            //login efetuado com sucesso
            funcoes::IniciarSessaoCliente($dados);
        }
    }
?>

<?php if($erro) : ?>
    <div class="alert alert-danger text-center"><?php echo $mensagem ?></div>
<?php else : ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-4 offset-4 card mt-5 mb-5 p-4 text-center">
                <p style="color: black">Bem-vindo(a), <b><?php echo $dados[0]['nm_customer']?></b>.</p>
                <a href="?a=home" class="btn btn-primary">Ok</a>
            </div>
        </div>
    </div>
<?php endif; ?>