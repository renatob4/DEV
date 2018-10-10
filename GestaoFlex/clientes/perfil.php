<?php 

    // ==========================================================
    // PERFIL DO CLIENTE
    // ==========================================================

    //Controle de sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }

    if(!funcoes::VerificarLoginCliente()){
        exit();
    }

    $erro = false;
    $sucesso = false;
    $mensagem = '';

    //verificar qual informação o cliente deseja alterar
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $p = $_GET['p'];
        $id_cliente = $_SESSION['cd_login_customer'];
        $gestor = new cl_gestorBD();
        $data = new DateTime();

        switch ($p) {
            //--------------------------------------
            case 1:   //Alterar o nome do cliente   
            
                $parametros = [
                    ':cd_login'          =>  $id_cliente,
                    ':nm_customer'       =>  $_POST['text_nome']
                ];
                $dados = $gestor->EXE_QUERY('SELECT cd_login, nm_customer FROM tab_customer WHERE cd_login <> :cd_login AND nm_customer = :nm_customer', $parametros);

                if(count($dados) != 0){
                    //foi encontrado outro cliente com o mesmo nome
                    $erro = true;
                    $mensagem = 'Já existe outro cliente com este mesmo nome!';
                } else {

                    $parametros = [
                        ':cd_login'         =>  $id_cliente,
                        ':nm_customer'      =>  $_POST['text_nome'],
                        ':dt_updated'       =>  $data->format('Y-m-d H:i:s')
                    ];
                    $gestor->EXE_NON_QUERY('UPDATE tab_customer 
                                            SET nm_customer = :nm_customer,
                                            dt_updated = :dt_updated 
                                                WHERE cd_login = :cd_login', $parametros);
                    $sucesso = true;
                    $mensagem = 'Nome alterado com sucesso!';
                }

            break;
            //--------------------------------------
            case 2:   //Alterar o email do cliente   
            
                // alterar o email do cliente
                $text_email_1 = $_POST['text_email'];
                $text_email_2 = $_POST['text_email_repetir'];

                //verifica se os emails introduzidos correspondem
                if($text_email_1 != $text_email_2){
                    $erro = true;
                    $mensagem = 'Os emails não correspondem.';
                }

                //verifica se já existe outro cliente com o mesmo email
                if(!$erro){                    
                    $parametros = [
                        ':cd_login'     => $id_cliente,
                        ':ds_email'     => $text_email_1
                    ];
                    $dados = $gestor->EXE_QUERY('SELECT cd_login, ds_email FROM tab_customer
                                                 WHERE cd_login <> :cd_login
                                                 AND ds_email = :ds_email', $parametros);
                    if(count($dados) != 0){
                        $erro = true;
                        $mensagem = 'Já existe outro cliente com o mesmo email.';
                    }
                }

                //atualização do email do cliente na base de dados
                if(!$erro){ 
                    $parametros = [
                        ':cd_login'         => $id_cliente,
                        ':ds_email'         => $text_email_1,
                        ':dt_updated'       => $data->format('Y-m-d H:i:s')
                    ];
                    $gestor->EXE_NON_QUERY('UPDATE tab_customer SET
                                            ds_email = :ds_email,
                                            dt_updated = :dt_updated
                                            WHERE cd_login = :cd_login',$parametros);
                    $sucesso = true;
                    $mensagem = 'Email do cliente alterado com sucesso.';
                }
            
            break;
            //--------------------------------------
            case 3:   //Alterar a senha do cliente   
            
                // alterar a senha do cliente
                $text_senha_atual = $_POST['text_senha_atual'];
                $text_senha_nova1 = $_POST['text_senha_nova1'];
                $text_senha_nova2 = $_POST['text_senha_nova2'];
                
                //verificar se senha atual é a mesma da base de dados
                $parametros = [
                    ':cd_login'           => $id_cliente,
                    ':cd_password'        => md5($text_senha_atual)
                ];
                $dados = $gestor->EXE_QUERY('SELECT cd_login, cd_password FROM tab_customer
                                             WHERE cd_login = :cd_login 
                                             AND cd_password = :cd_password', $parametros);
                if(count($dados)==0){
                    //existe um erro - a senha não é igual à que se encontra na bd
                    $erro = true;
                    $mensagem = 'Senha atual não corresponde.';
                }

                //verificar se nova senha e senha repetida são iguais
                if(!$erro){
                    if($text_senha_nova1 != $text_senha_nova2){
                        //as senhas novas não correspondem
                        $erro = true;
                        $mensagem = 'As senhas novas não correspondem.';
                    }
                }   

                //atualizar nova senha na base de dados
                if(!$erro){
                    $parametros = [
                        ':cd_login'       =>  $id_cliente,
                        ':cd_password'    =>  md5($text_senha_nova1),
                        ':dt_updated'     =>  $data->format('Y-m-d H:i:s')
                    ];
                    $gestor->EXE_NON_QUERY('UPDATE tab_customer SET
                                            cd_password = :cd_password,
                                            dt_updated = :dt_updated
                                            WHERE cd_login = :cd_login', $parametros);
                    $sucesso = true;
                    $mensagem = 'Senha alterada com sucesso!.';
                }  

            break;
        }          
    }

    //buscar dados do cliente na BD
    $parametros = [
        ':cd_login'   =>  $_SESSION['cd_login_customer']
    ];
    $gestor = new cl_gestorBD();
    $dados = $gestor->EXE_QUERY('SELECT * FROM tab_customer WHERE cd_login = :cd_login', $parametros);

?>

<!-- Erro -->
<?php if($erro) : ?>
    <div class="alert alert-danger text-center"><p><?php echo $mensagem ?></p></div>
<?php endif; ?>

<!-- Sucesso -->
<?php if($sucesso) : ?>
    <div class="alert alert-success text-center"><p><?php echo $mensagem ?></p></div>
<?php endif; ?>

<div class="container-fluid perfil">
    <div class="container pb-3 pt-3">
        <h3 Class="text-center mt-3 mb-3">Editar perfil de cliente</h3>
        <div class="row">
            <div class="col-sm-8 offset-sm-2 col-12">
                <div id="accordion">
                    <!--Componente alterar utilizador __________________________________________________________________________________________________________________-->
                    <div class="card">
                        <div class="card-header" id="caixa_utilizador">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#t_1" aria-expanded="true" aria-controls="collapseOne">
                                <i class="fas fa-id-card mr-3"></i> Alterar nome de cliente
                                </button>
                            </h5>
                        </div>

                        <div id="t_1" class="collapse show" aria-labelledby="caixa_utilizador" data-parent="#accordion">
                            <div class="card-body">
                                <!--=================================FORM=================================-->
                                Nome atual: <b><?php echo $dados[0]['nm_customer'] ?></b>
                                <form action="?a=perfil&p=1" method="post">
                                    <div class="form-group mt-3">
                                        <input class="form-control" type="text" name="text_nome" placeholder="Novo nome de cliente" required>
                                    </div>
                                    <div class="text-right">
                                        <input type="submit" value="alterar" class="btn btn-primary">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!--Componente alterar email ______________________________________________________________________________________________________________________-->
                    <div class="card">
                        <div class="card-header" id="caixa_email">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <i class="fas fa-envelope mr-3"></i> Alterar email da conta
                                </button>
                            </h5>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="caixa_email" data-parent="#accordion">
                            <div class="card-body">
                                <!--=================================FORM=================================-->
                                Email atual: <b><?php echo $dados[0]['ds_email'] ?></b>
                                <form action="?a=perfil&p=2" method="post">
                                    <div class="form-group mt-3">
                                        <input class="form-control" type="email" name="text_email" placeholder="Novo email do cliente" required>
                                    </div>
                                    <div class="form-group mt-3">
                                        <input class="form-control" type="email" name="text_email_repetir" placeholder="Repita o novo email" required>
                                    </div>
                                    <div class="text-right">
                                        <input type="submit" value="alterar" class="btn btn-primary">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!--Component alterar senha ______________________________________________________________________________________________________________________-->
                    <div class="card">
                        <div class="card-header" id="caixa_senha">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <i class="fas fa-unlock-alt mr-3"></i> Alterar senha
                                </button>
                            </h5>
                        </div>
                        <div id="collapseThree" class="collapse" aria-labelledby="caixa_senha" data-parent="#accordion">
                            <div class="card-body">
                                <!--=================================FORM=================================-->
                                <form action="?a=perfil&p=3" method="post">
                                    <div class="form-group mt-3">
                                        <input class="form-control" type="password" name="text_senha_atual" placeholder="Senha atual" required>
                                    </div>
                                    <div class="form-group mt-3">
                                        <input class="form-control" type="password" name="text_senha_nova1" placeholder="Nova senha" required>
                                    </div>
                                    <div class="form-group mt-3">
                                        <input class="form-control" type="password" name="text_senha_nova2" placeholder="Repita a nova senha" required>
                                    </div>
                                    <div class="text-right">
                                        <input type="submit" value="alterar" class="btn btn-primary">
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>