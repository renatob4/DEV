<?php 
    // ==========================================================
    // CADASTRO DE NOVOS SOCIOS
    // ==========================================================

    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }

    //Variaveis uteis
    $gestor = new cl_gestorBD();
    $erro = false;
    $sucesso = false;
    $mensagem = '';

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        //busca os valores do form
        $utilizador     =  $_POST['text_utilizador'];
        $password       =  $_POST['text_password'];
        $nome_completo  =  $_POST['text_nome'];
        $email          =  $_POST['text_email'];
        //busca os valores de telefone do form
        $telefone_1    =   $_POST['text_tel_1'];
        $telefone_2    =   $_POST['text_tel_2'] == "" ? NULL : $_POST['text_tel_2'];

        //Verificar os dados ja existentes na base de dados
        $parametros = [
            ':cd_login'   =>  $utilizador
        ];
        $dtemp = $gestor->EXE_QUERY('SELECT cd_login FROM tab_partner WHERE cd_login = :cd_login', $parametros);
        if(count($dtemp) != 0){
            $erro = true;
            $mensagem = 'Já existe um Socio com esta mesma id, favor escolher um diferente.';
        }
        if(!$erro){
            $parametros = [
                ':ds_email'   =>  $email
            ];
            $dtemp = $gestor->EXE_QUERY('SELECT ds_email FROM tab_partner WHERE ds_email = :ds_email', $parametros);
            if(count($dtemp) != 0){
                $erro = true;
                $mensagem = 'Já existe um Socio com este mesmo email, favor escolher um diferente.';
            }
        }

        //Guardar na base de dados
        if(!$erro){
            $parametros = [
                ':cd_login'       => $utilizador,
                ':cd_password'    => md5($password),
                ':nm_partner'     => $nome_completo,
                ':ds_email'       => $email,
                ':cd_permition'   => '0'.str_repeat('1', 31),
                ':ic_status'      => 1,
                ':dt_register'    => DATAS::DataHoraAtualBD(),
                ':dt_updated'     => DATAS::DataHoraAtualBD()
            ];
            //inserir o utilizador
            $gestor->EXE_NON_QUERY(
                    'INSERT INTO tab_partner(cd_login, cd_password, nm_partner, ds_email, cd_permition, ic_status, dt_register, dt_updated)
                     VALUES(:cd_login, :cd_password, :nm_partner, :ds_email, :cd_permition, :ic_status, :dt_register, :dt_updated)', $parametros);

            //inserir dados do tefone da companhia(cd_carrier = 1)
            if(!$erro){
                $parametros = [
                    ':cd_login'       => $utilizador
                ];
                $codigo = $gestor->EXE_QUERY('SELECT cd_partner FROM tab_partner WHERE cd_login = :cd_login', $parametros);

                $parametros = [
                    ':cd_phone'         => $telefone_1,
                    ':cd_carrier'       => $codigo[0]['cd_partner'],
                    ':cd_type_carrier'  => 1,
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
                        ':cd_carrier'       => $codigo[0]['cd_partner'],
                        ':cd_type_carrier'  => 1,
                        ':dt_register'      => DATAS::DataHoraAtualBD(),
                        ':dt_updated'       => DATAS::DataHoraAtualBD()
                    ];
                    $gestor->EXE_NON_QUERY(
                            'INSERT INTO tab_phone(cd_phone, cd_carrier, cd_type_carrier, dt_register, dt_updated)
                            VALUES(:cd_phone, :cd_carrier, :cd_type_carrier, :dt_register, :dt_updated)', $parametros);
                }
            }

            //Enviar o email para o novo utilizador
            $mensagem = [
                $email,
                'GestãoFlex - Criação de nova conta de Socio',
                "<h4>Sua ID de Socio: </h4>".$utilizador."<h4>Sua senha de Socio: </h4>".$password
            ];  
            $mail = new emails();
            $mail->EnviarEmail($mensagem);

            //Apresentar um alerta de sucesso
            echo '<div class="alert alert-success text-center">Novo Socio cadastrado com sucesso!</div>';
        }
    }

?>

<!--________________________________________________________________________ HTML ____________________________________________________________________________-->


<!-- apresenta o erro no caso de existir -->
<?php if($erro){ echo '<div class="alert alert-danger text-center">'.$mensagem.'</div>'; }?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-8 card m-3 p-3">
                <h4 class="text-center">CADASTRAR-SE COMO SOCIO</h4>
                <hr>
                <!--____________________________________Formulario para adicionar novo utilizador_______________________________________-->

                <form action="?a=cadastrar_utilizador" method="post">
                    <!--Campo para definir usuário da conta -->
                    <div class="form-goup">
                        <label>Utilizador:</label>
                        <input type="text" name="text_utilizador" class="form-control" pattern=".{3,50}" title="Entre 3 e 50 caracteres." required>
                    </div>

                    <!--Campo para definir a senha da conta -->
                    <div class="form-goup">
                        <label>Password:</label>
                        <div class="row">
                            <div class="col">
                                <input type="text" name="text_password" id="text_password" class="form-control" pattern=".{3,50}" title="Entre 3 e 30 caracteres." required>
                            </div>
                            <div class="col-sm-3">
                                <button type="button"  onclick="gerarPassword(10)" class="btn btn-secondary btn-size-150">Gerar password</button>
                            </div>
                        </div>                     
                    </div>

                    <!--Campo para definir o nome do utilizador -->
                    <div class="form-goup">
                        <label>Nome de usuário:</label>
                        <input type="text" name="text_nome" class="form-control" pattern=".{3,50}" title="Entre 3 e 50 caracteres." required>
                    </div>
                    
                    <!--Campo para definir o nome do utilizador -->
                    <div class="form-goup">
                        <label>E-mail:</label>
                        <input type="email" name="text_email" class="form-control" pattern=".{3,50}" title="Entre 3 e 50 caracteres." required>
                    </div>

                    <!--Telefones -->
                    <div class="form-row mt-2">
                        <div class="col">
                            <label>Telefone 1:</label>
                            <input type="number" name="text_tel_1" class="form-control mb-2" title="Telefone Comercial" placeholder="(XX)XXXX-XXXX" required>
                        </div>
                        <div class="col">
                            <label>Telefone 2:</label>
                            <input type="number" name="text_tel_2" class="form-control mb-2" title="Celular" placeholder="(XX)XXXX-XXXX">
                        </div>
                    </div>

                    <div class="text-center mt-3">
                        <a href="http://localhost:8080/GestaoFlex/socio" class="btn btn-primary btn-size-200">Cancelar</a>
                        <button class="btn btn-primary btn-size-200">Cadastrar</button>
                    </div>        
                </form> 

            </div>        
        </div>
    </div>

    <p class="text-center alert alert-warning">	Cadastro de socio mediante assinatura da plataforma. </p>