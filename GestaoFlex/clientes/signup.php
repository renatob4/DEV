<?php
    // ==========================================================
    // SIGNUP DE CLIENTES
    // ==========================================================

    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }

    $erro = false;
    $sucesso = false;
    $mensagem = '';
    $gestor = new cl_gestorBD();

    //dados do cliente
    $nome_completo = '';
    $email = '';
    $utilizador = '';
    $codigo_validacao = '';

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        //busca os valores do form
        $nome_completo = $_POST['text_nome_completo'];
        $email = $_POST['text_email'];
        $utilizador = $_POST['text_utilizador'];
        $senha1 = $_POST['text_senha_1'];
        $senha2 = $_POST['text_senha_2'];
        //busca os valores de telefone do form
        $telefone_1    =   $_POST['text_tel_1'];
        $telefone_2    =   $_POST['text_tel_2'] == "" ? NULL : $_POST['text_tel_2'];

        //verifica se as senhas sao correspondentes
        if($senha1 != $senha2){
            $erro = true;
            $mensagem = "As senhas inseridas não coincidem.";
        }

        //verificar se já existe um cliente com os mesmo "dados"
        if(!$erro){
            $parametros = [
                ':nm_customer'      => $nome_completo,
                ':ds_email'         => $email,
                ':cd_login'         => $utilizador
            ];

            $dados = $gestor->EXE_QUERY('
                SELECT * FROM tab_customer WHERE
                nm_customer = :nm_customer OR
                ds_email = :ds_email OR
                cd_login = :cd_login
            ', $parametros);

            if(count($dados) != 0){
                $erro = true;
                $mensagem = 'Já existe um cliente com os mesmos dados.';
            }
        }

        //vamos criar condições para criar a conta de cliente (em validação)
        if(!$erro){
            $codigo_validacao = funcoes::CriarCodigoAlfanumerico(30);
            $data = new DateTime();
            $parametros = [
                ':nm_customer'         => $nome_completo,
                ':ds_email'            => $email,
                ':cd_login'            => $utilizador,
                ':cd_password'         => md5($senha1),
                ':cd_validation'       => funcoes::CriarCodigoAlfanumerico(30),
                ':ic_validation'       => 0,
                ':dt_register'         => $data->format('Y-m-d H:i:s'),
                ':dt_updated'          => $data->format('Y-m-d H:i:s')
            ];
            //registra o cliente na base de dados
            $gestor->EXE_NON_QUERY('
                INSERT INTO
                tab_customer(nm_customer, ds_email, cd_login, cd_password, cd_validation, ic_validation, dt_register, dt_updated)
                VALUES
                (:nm_customer, :ds_email, :cd_login, :cd_password, :cd_validation, :ic_validation, :dt_register, :dt_updated)', $parametros);

            //variavel auxiliar para segurar o código de validação
            $aux = $parametros[':cd_validation'];

            //inserir dados do tefone da companhia(cd_carrier = 3)
            if(!$erro){
                $parametros = [
                    ':cd_login'       => $utilizador
                ];
                $codigo=$gestor->EXE_QUERY('SELECT cd_customer FROM tab_customer WHERE cd_login = :cd_login', $parametros);

                $parametros = [
                    ':cd_phone'         => $telefone_1,
                    ':cd_carrier'       => $codigo[0]['cd_customer'],
                    ':cd_type_carrier'  => 3,
                    ':dt_register'      => DATAS::DataHoraAtualBD(),
                    ':dt_updated'       => DATAS::DataHoraAtualBD()
                ];
                $gestor->EXE_NON_QUERY(
                        'INSERT INTO tab_phone(cd_phone, cd_carrier, cd_type_carrier, dt_register, dt_updated)
                        VALUES(:cd_phone, :cd_carrier, :cd_type_carrier, :dt_register, :dt_updated)', $parametros);

                if($telefone_2 != NULL)
                {
                    $parametros = [
                        ':cd_phone'         => $telefone_2,
                        ':cd_carrier'       => $codigo[0]['cd_customer'],
                        ':cd_type_carrier'  => 3,
                        ':dt_register'      => DATAS::DataHoraAtualBD(),
                        ':dt_updated'       => DATAS::DataHoraAtualBD()
                    ];
                    $gestor->EXE_NON_QUERY(
                            'INSERT INTO tab_phone(cd_phone, cd_carrier, cd_type_carrier, dt_register, dt_updated)
                            VALUES(:cd_phone, :cd_carrier, :cd_type_carrier, :dt_register, :dt_updated)', $parametros);
                }
            }

            if(!$erro){
                //envio do email para o cliente validar a sua nova conta
                $email_a_enviar = new emails();

                //criar o link de ativação
                $config = include('class/config.php');
                $link = $config['BASE_URL'].'?a=validar&v='.$aux;  

                //preparação dos dados do email
                $temp = [               
                    $email,            
                    'GestãoFlex - Ativação da conta de cliente',            
                    '<p>Clique no link seguinte para validar a sua conta de cliente:</p>'.
                    '<a href="'.$link.'">'.$link.'</a>'                
                ];

                //envio do email
                $mensagem_enviada = $email_a_enviar->EnviarEmailCliente($temp);
            }

            $sucesso = true;
            $mensagem = "Conta de cliente criada com sucesso! verifique seu email!";
        }
    }

?>  

<?php if($erro) : { echo '<div class="alert alert-danger text-center">'.$mensagem.'</div>'; } ?>  
<?php elseif($sucesso): { echo '<div class="alert alert-success text-center mb-3">'.$mensagem.'</div>'; } ?>
<?php endif; ?>  


    <div class="container signup">
        <div class="row mt-3 mb-3">
            <div class="col-sm-6 offset-sm-3 mb-3 card">

                <h3 class="text-center m-2">Cadastrar-se como cliente</h3>          
                <form action="" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" name="text_nome_completo" placeholder="Nome completo" value="<?php echo $nome_completo ?>" required>    
                    </div>

                    <div class="form-group">
                        <input type="email" class="form-control" name="text_email" placeholder="Email" value="<?php echo $email ?>" required>    
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" name="text_utilizador" placeholder="Utilizador" value="<?php echo $utilizador ?>" required>    
                    </div>

                    <div class="form-group">
                        <input type="password" class="form-control" name="text_senha_1" placeholder="Senha" required>    
                    </div>

                    <div class="form-group">
                        <input type="password" class="form-control" name="text_senha_2" placeholder="Repita a senha" required>    
                    </div>
                                                
                    <!--Telefones -->
                    <div class="form-row">
                        <div class="col">
                            <input type="number" name="text_tel_1" class="form-control mb-2" title="Telefone Comercial" placeholder="Telefone 1" required>
                        </div>
                        <div class="col">
                            <input type="number" name="text_tel_2" class="form-control mb-2" title="Celular" placeholder="Telefone 2">
                        </div>
                    </div>

                    <div class="text-center form-group"><input type="checkbox" name="check_termos" id="check_termos" class="mr-1" required>
                    <label for="check_termos">Li e aceito os <a href="">termos de utilização</a>.</label></div>

                    <div class="text-center">
                        <button class="btn btn-primary mb-3">Cadastrar</button>
                    </div>       
                </form>
            
            </div>
        </div>
    </div>