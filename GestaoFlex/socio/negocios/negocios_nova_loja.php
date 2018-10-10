<?php 

    // ==========================================================
    // CRIAR NOVO NEGOCIO - SOCIOS
    // ==========================================================

    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }

    //Variaveis uteis
    $gestor = new cl_gestorBD();
    $erro = false;
    $cadastrado = false;
    $sucesso = false;
    $mensagem = '';

    //Verificar se ja existe negocio vinculado ao socio logado.
    $parametros = [
        ':cd_partner'  =>  $_SESSION['cd_partner']
    ];
    $dtemp = $gestor->EXE_QUERY('SELECT cd_relationship FROM tab_company_partner WHERE cd_partner = :cd_partner', $parametros);
    if(count($dtemp) != 0){
        $cadastrado = true;
        $mensagem = 'Já existe um negócio ativo para esta conta!.';
    } 

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            //busca os valores do form
            $nome_empresa  =  $_POST['text_nome'];
            $descricao     =  $_POST['text_descricao'];
            $email         =  $_POST['text_email'];
            $documento     =  $_POST['text_doc'];

            $cep              =     $_POST['text_cep'];
            $neighborhood     =     $_POST['text_neighborhood'];
            $address          =     $_POST['text_address'];
            $city             =     $_POST['text_city'];
            $number           =     $_POST['text_number'];
            $uf               =     $_POST['text_uf'];
            $complement       =     $_POST['text_complement'];

            //busca os valores de telefone do form
            $telefone_1    =   $_POST['text_tel_1'];
            $telefone_2    =   $_POST['text_tel_2'] == "" ? NULL : $_POST['text_tel_2'];

            //Segurar dados na Session para manter form preenchido.
            $_SESSION['nm_empresa']     = $nome_empresa;
            $_SESSION['ds_desc']        = $descricao;
            $_SESSION['ds_mail']        = $email;
            $_SESSION['ds_doc']         = $documento;
            $_SESSION['tel_1']          = $telefone_1;
            $_SESSION['tel_2']          = $telefone_2;

            $_SESSION['cep']            = $cep;
            $_SESSION['neighborhood']   = $neighborhood;
            $_SESSION['address']        = $address;
            $_SESSION['city']           = $city;
            $_SESSION['number']         = $number;
            $_SESSION['uf']             = $uf;
            $_SESSION['complement']     = $complement;

            //Contruindo o codigo para relação com o cliente
            $codigo_relacao = "#" . strtoupper(str_replace(' ', '', $nome_empresa)) . date('Y');

            // ________________________________________ VERIFICAÇões ____________________________________________
            
            if(!$erro){
                //Verifica se o nome da empresa ja existe na base de dados
                $parametros = [
                    ':nm_company'   =>  $nome_empresa 
                ];
                $dtemp = $gestor->EXE_QUERY('SELECT nm_company FROM tab_company WHERE nm_company = :nm_company', $parametros);
                if(count($dtemp) != 0){
                    $erro = true;
                    $mensagem = 'Já existe uma empresa com este mesmo Nome.';
                }
            }

            if(!$erro){
                //Verifica se o Documento da empresa ja existe na base de dados
                $parametros = [
                    ':ds_document'   =>  $documento 
                ];
                $dtemp = $gestor->EXE_QUERY('SELECT ds_document FROM tab_company WHERE ds_document = :ds_document', $parametros);
                if(count($dtemp) != 0){
                    $erro = true;
                    $mensagem = 'Já existe uma empresa com este mesmo Documento.';
                }
            }

            if(!$erro){
                //Verifica se o Documento da empresa ja existe na base de dados
                $parametros = [
                    ':ds_email'   =>  $email 
                ];
                $dtemp = $gestor->EXE_QUERY('SELECT ds_email FROM tab_company WHERE ds_email = :ds_email', $parametros);
                if(count($dtemp) != 0){
                    $erro = true;
                    $mensagem = 'Já existe uma empresa com este mesmo Email.';
                }
            }

            if(!$erro){
                //Verificar se o telefone_1 ja existem na base
                $parametros = [
                    ':cd_phone'          => $telefone_1,
                    ':cd_type_carrier'   => 2
                ];
                $dtemp = $gestor->EXE_QUERY('SELECT cd_phone FROM tab_phone WHERE cd_type_carrier = :cd_type_carrier AND cd_phone = :cd_phone', $parametros);
                if(count($dtemp) != 0){
                    $erro = true;
                    $mensagem = 'Número de telefone 1 ja cadastrado anteriormente na base de dados.';
                }
            }

            if(!$erro){
                //Verificar se o telefone_2 ja existem na base
                $parametros = [
                    ':cd_phone'          => $telefone_2,
                    ':cd_type_carrier'   => 2
                ];
                $dtemp = $gestor->EXE_QUERY('SELECT cd_phone FROM tab_phone WHERE cd_type_carrier = :cd_type_carrier AND cd_phone = :cd_phone', $parametros);
                if(count($dtemp) != 0){
                    $erro = true;
                    $mensagem = 'Número de telefone 2 ja cadastrado na base de dados.';
                }
            }

            // ________________________________________ INSERÇÃO NA TAB_COMPANY ____________________________________

            //Guardar a empresa na base de dados
            if(!$erro){
                $parametros = [
                    ':nm_company'       => $nome_empresa,
                    ':ds_company'       => $descricao,
                    ':ds_email'         => $email,
                    ':ds_document'      => $documento,
                    ':cd_relationship'  => $codigo_relacao,
                    ':dt_register'      => DATAS::DataHoraAtualBD(),
                    ':dt_updated'       => DATAS::DataHoraAtualBD()
                ];
                //inserir o utilizador
                $gestor->EXE_NON_QUERY(
                        'INSERT INTO tab_company(nm_company, ds_company, ds_email, ds_document, cd_relationship, dt_register, dt_updated)
                        VALUES(:nm_company, :ds_company, :ds_email, :ds_document, :cd_relationship, :dt_register, :dt_updated)', $parametros);
            }

            //inserir dados do tefone da companhia(cd_carrier = 2)
            if(!$erro){
                $parametros = [
                    ':nm_company'       => $nome_empresa
                ];
                $codigo = $gestor->EXE_QUERY('SELECT cd_company FROM tab_company WHERE nm_company = :nm_company', $parametros);

                $parametros = [
                    ':cd_phone'         => $telefone_1,
                    ':cd_carrier'       => $codigo[0]['cd_company'],
                    ':cd_type_carrier'  => 2,
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
                        ':cd_carrier'       => $codigo[0]['cd_company'],
                        ':cd_type_carrier'  => 2,
                        ':dt_register'      => DATAS::DataHoraAtualBD(),
                        ':dt_updated'       => DATAS::DataHoraAtualBD()
                    ];
                    $gestor->EXE_NON_QUERY(
                            'INSERT INTO tab_phone(cd_phone, cd_carrier, cd_type_carrier, dt_register, dt_updated)
                            VALUES(:cd_phone, :cd_carrier, :cd_type_carrier, :dt_register, :dt_updated)', $parametros);
                }
            }

            // __________________________________________________ INSERÇÃO DE RELAÇão ______________________________________________

            //inserir a relação entre a empresa e o socio na base
            if(!$erro){
                $parametros = [
                    ':cd_relationship'  => $codigo_relacao,
                    ':cd_partner'       => $_SESSION['cd_partner'],
                ];
                $gestor->EXE_NON_QUERY(
                        'INSERT INTO tab_company_partner(cd_relationship, cd_partner)
                        VALUES(:cd_relationship, :cd_partner)', $parametros);
            } 

            // __________________________________________________ INSERÇÃO ENDEREÇO ______________________________________________

            if(!$erro){
                // $parametros = [
                //     ':cd_cep'  => $cep
                // ];
                // $dtemp = $gestor->EXE_QUERY('SELECT 
                //     ts.cd_cep,
                //     ts.ds_street,
                //     tn.ds_neighborhood,
                //     tc.ds_city,
                //     tu.ds_uf_initials 
                // FROM tab_street ts 
                // INNER JOIN tab_neighborhood tn ON ts.cd_neighborhood = tn.cd_neighborhood
                // INNER JOIN tab_city tc ON tc.cd_city = tn.cd_city
                // INNER JOIN tab_uf tu ON tu.cd_uf = tc.cd_uf
                // WHERE ts.cd_cep = :ts.cd_cep;', $parametros);

                // if(count($dtemp) != 0){                        
                //     $address = $dtemp[0]['ds_street'];
                //     $neighborhood = $dtemp[0]['ds_neighborhood'];
                //     $city = $dtemp[0]['ds_city'];
                //     $uf = $dtemp[0]['ds_uf_initials'];
                // }
            }
            
            // __________________________________________________  PASSe de CONTROLE _________________________________________________
            if(!$erro){
                $sucesso = true;
                $cadastrado = true;
                $mensagem = "Novo negócio criado com sucesso!";
            }
             
    }
    
?>

 <!-- ================================================================= FRONT ================================================================= -->

<div class="container">
    <?php if(!$cadastrado) :?>
                <div class="row p-2 mt-0">
                    <div class="col">
                    <h4 class="text-left mt-0 mb-3">Cadastre seu novo negócio</h4>
                        <!--Inicio do Form -->
                        <form action="?a=negocios_nova_loja" method="post">
                            <div class="card p-3 mb-3 field">
                                    <div class="text-center mb-1"><h5>Informações de identificação da empresa</h5></div>
                                    <!--Importar imagem da empresa -->
                                    <div class="imagem-company mb-2 img-fluid"><a class="btn btn-success m-2" href=""> <i class="fas fa-upload mr-2"></i>Definir uma imagem</a></div><hr>

                                    <!--Campo para definir o Nome da Empresa -->
                                    <div class="form-row">
                                        <div class="col-md-8">
                                            <label><i class="far fa-id-badge mr-2" id="icons"></i> <b>Nome da Empresa/Loja/Negócio:</b></label>
                                            <input type="text" name="text_nome" value="<?php echo (isset($_SESSION['nm_empresa'])) ? $_SESSION['nm_empresa'] : ''; ?>" 
                                                   class="form-control mb-2" title="Defina um nome até 60 caracteres." maxlength="60" placeholder="Defina um nome." pattern=".{2,60}" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label><i class="fas fa-globe mr-2" id="icons"></i> <b>Relação com cliente:</b></label>
                                            <input type="text" name="text_codigo" class="form-control mb-2" title="Definido automaticamente" placeholder="Este código é gerado automaticamente!." readonly>
                                        </div>
                                    </div>
                                    <!--Campo para definir descrição do negocio-->
                                    <div class="form-goup">
                                        <label><i class="fas fa-align-left mr-2" id="icons"></i> <b>Descrição do negócio:</b></label>
                                        <textarea type="text" 
                                        name="text_descricao" 
                                        class="form-control mb-2" 
                                        title="Defina uma descrição do seu negócio"
                                        maxlength="256"
                                        placeholder="<?php echo (isset($_SESSION['ds_desc'])) ? $_SESSION['ds_desc'] : 'Exemplo: Assine nossa plataforma e usufrua de todo controle sobre seus estoque e suas vendas!'; ?>"
                                        pattern=".{25,256}" 
                                        required></textarea>                   
                                    </div>
                            </div> 
                            <div class="card p-3 mb-3 field">
                                    <div class="text-center mb-1"><h5>Documentação e Contatos</h5></div>
                                    <!--Campo para definir o cnpj/cpf -->
                                    <div class="form-row">
                                        <div class="col-md-3">
                                            <label><i class="far fa-user mr-2" id="icons"></i> <b>CNPJ ou CPF:</b></label>
                                            <input type="text" name="text_doc" value="<?php echo (isset($_SESSION['ds_doc'])) ? $_SESSION['ds_doc'] : '';?>"
                                                   class="form-control mb-2" title="Defina o CNPJ ou CPF" placeholder="xx.xxx.xxx/xxxx-xx" pattern=".{11,14}" maxlength="14" required>
                                        </div>
                                        <!--Campo para definir o email -->
                                        <div class="col-md-9">
                                            <label><i class="fas fa-at mr-2" id="icons"></i> <b>Email:</b></label>
                                            <input type="email" name="text_email" pattern=".{7,50}" value="<?php echo (isset($_SESSION['ds_mail'])) ? $_SESSION['ds_mail'] : '';?>" 
                                                   class="form-control mb-2" title="Defina o Email Comercial" placeholder="contato@gestaoflex.com" maxlength="50" required>
                                        </div>  
                                    </div>        
                                    <!--Telefones -->
                                    <div class="form-row">
                                        <div class="col">
                                            <label><i class="fas fa-phone-square mr-2" id="icons"></i> <b>Telefone 1:</b></label>
                                            <input type="tel" name="text_tel_1" value="<?php echo (isset($_SESSION['tel_1'])) ? $_SESSION['tel_1'] : '';?>" 
                                                   class="form-control mb-2" title="Telefone comercial" placeholder="(00) 0000-0000" maxlength="15" pattern=".[0-9]{9,15}" required>
                                        </div>
                                        <div class="col">
                                            <label><i class="fas fa-phone-square mr-2" id="icons"></i> <b>Telefone 2:</b></label>
                                            <input type="tel" name="text_tel_2" value="<?php echo (isset($_SESSION['tel_2'])) ? $_SESSION['tel_2'] : '';?>" 
                                                   class="form-control mb-2" title="Telefone celular" placeholder="(00) 0000-0000" maxlength="15" pattern=".[0-9]{9,15}">
                                        </div>
                                    </div>
                            </div>

                            <div class="card p-3 mb-3 field">
                                <div class="form-inline">
                                    <div class="mb-1 mt-2"><h5>Endereço</h5>
                                    </div><a class="btn btn-success ml-2 p-2" onclick="trocaBotao()" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><i id="extend" class="fas fa-plus-square"></i></a></div>
                                        <div class="collapse mt-2" id="collapseExample">
                                           
                                            <div class="form-row">
                                                <div class="col-md-2">
                                                    <label><i class="fas fa-road mr-2" id="icons"></i> <b>CEP:</b></label>                                                                                                       
                                                    <input type="text" id="cep" name="text_cep" onfocusout="preencheForm()" class="form-control mb-2" title="" placeholder="00000-000" maxlength="" pattern="">
                                                </div>
                                                <div class="col-md-6">  
                                                    <label><i class="fas fa-map-marker-alt mr-2" id="icons"></i> <b>Endereço:</b></label>
                                                    <input type="text" name="text_address" value="" class="form-control mb-2" title="" placeholder="Exemplo: Rua da boa Gestão" maxlength="" pattern="">
                                                </div>
                                                <div class="col-md-2"> 
                                                    <label><b>Número:</b></label>                                                   
                                                    <input type="text" name="text_number" value="" class="form-control mb-2" title="" placeholder="1234" maxlength="" pattern="">
                                                </div>
                                                <div class="col-md-2">
                                                    <label><b>Complemento: </b></label>
                                                    <input type="text" name="text_complement" value="" class="form-control mb-2" title="" placeholder="Exemplo: AP 27" maxlength="" pattern="">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <label><b>Bairro:</b></label>
                                                    <input type="text" name="text_neighborhood" value="" class="form-control mb-2" title="" placeholder="Exemplo: Bairro Sucesso" maxlength="" pattern="">
                                                </div>
                                                <div class="col-md-5">   
                                                    <label><b>Cidade:</b></label>
                                                    <input type="text" name="text_city" value="" class="form-control mb-2" title="" placeholder="São Paulo" maxlength="" pattern="">
                                                </div>
                                                <div class="col-md-1">    
                                                    <label><b>UF:</b></label>
                                                    <input type="text" name="text_uf" value="" class="form-control mb-2" title="" placeholder="SP" maxlength="" pattern="">
                                                </div>
                                            </div>
                                    </div>            
                                </div>

                            <div class="card p-2 mb-3 field">
                                <div class="text-center">
                                    <div class="row p-0 mt-1">
                                        <div class="col">
                                            <a class="btn btn-primary botao-card-form" href="http://localhost:8080/GestaoFlex/socio">
                                            <span class="fas fa-undo"></span></a>
                                            <p class="m-0 p-0 mb-0">Cancelar / Voltar</p>
                                        </div>
                                        <div class="col">
                                            <button class="btn btn-primary botao-card-form">
                                            <span class="fas fa-check"></span></button>
                                            <p class="m-0 p-0 mb-0">Concluir</p>
                                        </div>
                                    </div>
                                </div>                            
                            </div>

                        </form>  
                    </div>
                </div>
            <?php endif;?>

        <?php if($sucesso == true AND $erro == false) :?>
            <div class="alert alert-success text-center m-0 mb-4"><?php echo $mensagem ?></div>
            <div class="text-center m-2"><a href="?a=inicio" class="btn btn-primary btn-size-150">Voltar</a></div>
            <?php echo funcoes::DestroiSessaoForms() ?>
        <?php elseif($erro) :?>
            <div class="alert alert-danger text-center m-0 mb-4"><?php echo $mensagem ?></div>
        <?php endif;?>

</div>