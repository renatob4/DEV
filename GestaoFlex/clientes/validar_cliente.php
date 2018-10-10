<?php 

    // ==========================================================
    // SCRIPT DE VALIDAÇAO DE NOVOS CLIENTES
    // ==========================================================

    //Controle de sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }

    $gestor = new cl_gestorBD();
    $erro = false;
    $sucesso = false;
    $mensagem = '';

    //verifica se existe V definido
    if(!isset($_GET['v'])){
        $erro = true;
        $mensagem = 'Codigo de validação não esta definido.';
    } 
    //busca o codigo de validação do cliente na URL
    if(!$erro){

        $cod_validacao = $_GET['v'];

        //pesquisa se existe cliente com esse codigo na base
        $parametros = [
            ':cd_validation'   =>  $cod_validacao
        ];
        $dados = $gestor->EXE_QUERY('SELECT * FROM tab_customer WHERE cd_validation = :cd_validation', $parametros);

        //verifica se existe utilizador
        if(count($dados) == 0){
            $erro = true;
            $mensagem = 'Codigo de validação incorreto, nenhum cliente encontrado.';
        }
        //verifica se validada ja estava como valor um (conta ja estava validada)
        if(!$erro){
            if($dados[0]['ic_validation'] == 1){
                $erro = true;
                $mensagem = 'Esta conta ja esta validada.';
            }
        }
        //finalmente, ultrapassados os erros possivels então alterar a vonta para validada
        if(!$erro){
            $parametros = [
                ':cd_login'   =>  $dados[0]['cd_login']
            ];  
            $gestor->EXE_NON_QUERY('UPDATE tab_customer SET ic_validation = 1 WHERE cd_login = :cd_login', $parametros);
            //Informar o cliente que sua conta foi ativada
            $sucesso = true;
            $mensagem = 'Conta ativada com sucesso!';
        }
    }         
?>

<?php if($erro) : ?>
    <div class="alert alert-danger text-center"><?php echo $mensagem ?></div>
<?php elseif($sucesso) : ?>
    <div class="alert alert-success text-center"><?php echo $mensagem ?></div>
<?php endif; ?>