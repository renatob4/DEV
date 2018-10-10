<?php
    // ==========================================================
    // INICIO - GERENCIAR ESTOQUE
    // ==========================================================

    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }

    if(isset($_GET['action'])){
        $action = $_GET['action'];
    }

    //Carregar os dados dos produtos
    $gestor = new cl_gestorBD();
    $relação = null;
    $produtos = null;
    $erro = false;
    $mensagem = '';

    //Buscar relação entre este socio e produtos na base de dados.
    $parametros = [
        ':cd_partner'  =>  $_SESSION['cd_partner']
    ];
    $relação = $gestor->EXE_QUERY('SELECT cd_alternative_product FROM tab_partner_product WHERE cd_partner = :cd_partner', $parametros);

    //Armazena os registros recebidos da base num array $prod[].
    if(count($relação) != 0){
        foreach($relação as $cod){
            $parametros = [
                ':cd_alternative_product'  =>  $cod['cd_alternative_product']
            ];
            $produtos = $gestor->EXE_QUERY('SELECT * FROM tab_product WHERE cd_alternative_product = :cd_alternative_product', $parametros);
            $prod[] = $produtos[0];
        }
    }

    // ---------------------------------------------------

    //Verifica se foi definida clear ao pesquisar o produto
    if(isset($_GET['clear'])){
        header("Location:?a=gerenciar_estoque");
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        //Busca o valor do form
        $cd_search  =  $_POST['search_inp'];

        //Verificações -------------------------------------------
        if(!$erro){
            //Verifica se o codigo do produto ja existe na base de dados
            $parametros = [
                ':cd_alternative_product'  =>  $cd_search 
            ];
            $produto = $gestor->EXE_QUERY('SELECT * FROM tab_product WHERE cd_alternative_product = :cd_alternative_product', $parametros);
            if(count($produto) == 0){
                $erro = true;
                $mensagem = 'Não existe um produto com este Código :(';

                $_SESSION['inp-product'] = $cd_search;
                $_SESSION['out-product'] = $cd_search;
            }else{
                $_SESSION['cod_prod'] = $produto[0]['cd_alternative_product'];
                $_SESSION['nm_prod']  = $produto[0]['ds_product'];
                $_SESSION['vl_prod']  = $produto[0]['vl_product'];
                $_SESSION['un_prod']  = $produto[0]['ds_unity'];   
                     
                $_SESSION['inp-product'] = $cd_search;
                $_SESSION['out-product'] = $cd_search;
            }
        }
    }


?>

<div class="container-fluid mt-2"> <!-- ______________________________________________HTML_________________________________________________-->

    <div class="row text-center p-0 m-3">
        <div class="col-sm-3 offset-sm-0 ">
            <!-- botão de entrada de item em estoque -->
            <div class="card text-center mt-2" id="Ent" role="button" type="button" data-toggle="collapse" data-target="#entrada" aria-expanded="false" aria-controls="entrada">
                <div class="btn btn-info card-body"><span class="fas fa-arrow-alt-circle-right" id="btn-stock"></span></a></div>
                <div class="card-footer text-muted p-1">Entrada em Estoque</div>
            </div>
        </div>

        <div class="col-sm-3 offset-sm-6 ">
            <!-- botão de saida de item em estoque -->
            <div class="card text-center mt-2" id="Sai" role="button" type="button" data-toggle="collapse" data-target="#saida" aria-expanded="true" aria-controls="saida">
                <div class="btn btn-success card-body"><span class="fas fa-arrow-alt-circle-right" id="btn-stock"></span></a></div>
                <div class="card-footer text-muted p-1">Saída de Estoque</div>
            </div>
        </div>
    </div>
    <!-- Row escondida ativada com um dos botões acima -->
    <div class="row text-center p-0 m-3">
        <div class="col-sm-3 offset-sm-0 m-0">
            <div class="card p-0 mb-3">
                  <div class="card p-1">
                    <div class="panel panel-default text-center espaco-paineis">                        
                        <p class="titulo-painel mt-1">Produtos</p>
                        <div class="text-left">
                            <hr><p class="mt-1 mb-1"><b>Info:</b>&nbsp<label>None</label></p>
                            <hr><p class="mt-1 mb-1"><b>Info:</b>&nbsp<label>None</label></p>
                            <hr><p class="mt-1 mb-1"><b>Info:</b>&nbsp<label>None</label></p><hr>
                        </div>    
                    </div> 
                    <div class="card text-center m-4" href="" id="Cad" role="button" type="button" data-toggle="collapse" data-target="#cadastro" aria-expanded="true" aria-controls="cadastro">
                        <div class="btn btn-dark card-body"><span class="fas fa-archive" id="btn-stock"></span></a></div>
                        <div class="card-footer text-muted p-1">Cadastrar Produtos</div>
                    </div>      
                 </div>
            </div>
        </div>
        <div class="col-sm-6 offset-sm-6 p-0 m-0">
                <div class="<?php echo ((isset($_SESSION['inp-product']) || (isset($_SESSION['result-inp']))) && $action != 'out') ? 'collapse show mb-2' : 'collapse mb-2';?>" id="entrada">
                    <div class="card card-body m-0 p-3 borda-saida" >
                        <h5 class="mt-2">Entrada de produto em estoque</h5><hr>
                        <p>Pesquise por um produto ja cadastrado pelo seu código e defina a quantidade que deseja <b>INSERIR</b> no estoque.</p>

                        <form action="?a=gerenciar_estoque&action=inp" method="POST">
                            <div class="card borda-cinza p-2">
                                <div class="text-center">
                                    <div class="form-row">
                                        <div class="col-md-3 m-0 p-0">
                                            <label class="mt-1 lb-search"><b>Pesquisar:</b></label>
                                        </div>
                                        <div class="col-md-6 m-0 p-0">
                                            <input type="text" name="search_inp" class="form-control borda-text mt-0" placeholder="Código do Produto" value="<?php echo (isset($_SESSION['inp-product']) && $action != 'out') ? $_SESSION['inp-product'] : ''; ?>">
                                        </div>
                                        <div class="col-md-3 m-0 p-0">
                                            <button class="btn btn-outline-dark mt-1"><i class="fa fa-search"></i></button>
                                            <a href="?a=gerenciar_estoque&clear=true" class="btn btn-outline-danger mt-1"><i class="fa fa-times"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Verifica se a pesquisa retornou resultado. -->
                        <?php if((isset($_SESSION['inp-product']) || isset($_SESSION['result-inp'])) && (isset($action) && $action != 'out')) : ?>
                            <?php if($erro) : ?>
                                <div id="inp-suc" class="alert alert-danger m-3"><?php echo $mensagem ?></div>
                            <?php else : ?>
                                <form action="?a=entrada_produtos" method="POST">
                                    <div class="card borda-cadastro card-result mt-2 p-2">
                                        <div class="row m-1">
                                            <div class="col-md-3 borda-cinza card m-0">
                                                <label class="lb-search lb-code mt-1"><b><?php echo $_SESSION['cod_prod'] ?></b></label>
                                                <p><?php echo $_SESSION['nm_prod'] ?></p>
                                            </div>                                  
                                            <div class="col-md-6 borda-cinza m-0 p-0">
                                                <div class="card p-2 m-0">
                                                    <label class="mb-2 mt-0"><b>Quantidade a ser Adicionada:</b></label>
                                                    <div class="input-group">
                                                        <input value="1" type="number" class="form-control" name="qt_add">
                                                        <div class="input-group-prepend p-0"><span class="input-group-text m-0 p-3"><i class="fas fa-plus-square"></i></span></div>                            
                                                    </div>
                                                    <p class="mb-0 mt-2">Valor: R$ <label class="m-0 p-0"><b><?php echo $_SESSION['vl_prod'] ?></b>/<?php echo $_SESSION['un_prod'] ?></label><a class="ml-2" href="">Editar</a></p>   
                                                </div>                                     
                                            </div>
                                            <div class="col-md-3 m-0 p-0">
                                                <button type="submit" class="btn btn-info botao-card-conclui m-0 mt-1"><span class="fas fa-check-circle"></span></button>                                           
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            <?php endif; ?>                                   
                        <?php endif;?>

                        <!-- Verifica se o script entrada_produtos retornou resultado. -->
                        <?php if(isset($_SESSION['result-inp'])) : ?>
                            <!-- Se o resultado guardado na variavel de sessao result-inp tiver um final "!", ou seja, um codigo de sucesso, então a classe do alerta será success -->
                            <div id="inp-suc" class="<?php echo (substr($_SESSION['result-inp'], -1) == '!') ? 'alert alert-success m-3' : 'alert alert-danger m-3';?>"><?php echo $_SESSION['result-inp'] ?></div>
                        <?php endif;?>

                    </div>
                </div>

                <div class="<?php echo ((isset($_SESSION['out-product']) || (isset($_SESSION['result-out']))) && $action != 'inp') ? 'collapse show mb-2' : 'collapse mb-2';?>" id="saida">
                    <div class="card card-body m-0 p-3 borda-entrada" >
                        <h5 class="mt-2">Saida de estoque do produto</h5><hr>
                        <p>Pesquise por um produto ja cadastrado pelo seu código e defina a quantidade que deseja <b>REMOVER</b> do estoque.</p>

                        <form action="?a=gerenciar_estoque&action=out" method="POST">
                            <div class="card borda-cinza p-2">
                                <div class="text-center">
                                    <div class="form-row">
                                        <div class="col-md-3 m-0 p-0">
                                            <label class="mt-1 lb-search"><b>Pesquisar:</b></label>
                                        </div>
                                        <div class="col-md-6 m-0 p-0">
                                            <input type="text" name="search_inp" class="form-control borda-entrada mt-0" placeholder="Código do Produto" value="<?php echo (isset($_SESSION['out-product']) && $action != 'inp') ? $_SESSION['out-product'] : ''; ?>">
                                        </div>
                                        <div class="col-md-3 m-0 p-0">
                                            <button class="btn btn-outline-dark mt-1"><i class="fa fa-search"></i></button>
                                            <a href="?a=gerenciar_estoque&clear=true" class="btn btn-outline-danger mt-1"><i class="fa fa-times"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Verifica se a pesquisa retornou resultado. -->
                        <?php if((isset($_SESSION['out-product']) || (isset($_SESSION['result-out']))) && (isset($action) && $action != 'inp')) : ?>
                            <?php if($erro) : ?>
                                <div id="out-suc" class="alert alert-danger m-3"><?php echo $mensagem ?></div>
                            <?php else : ?>
                                <form action="?a=saida_produtos" method="POST">
                                    <div class="card borda-cadastro card-result mt-2 p-2">
                                        <div class="row m-1">
                                            <div class="col-md-3 borda-cinza card m-0">
                                                <label class="lb-search lb-code mt-1"><b><?php echo $_SESSION['cod_prod'] ?></b></label>
                                                <p><?php echo $_SESSION['nm_prod'] ?></p>
                                            </div>                                  
                                            <div class="col-md-6 borda-cinza m-0 p-0">
                                                <div class="card p-2 m-0">
                                                    <label class="mb-2 mt-0"><b>Quantidade a ser Removida:</b></label>
                                                    <div class="input-group">
                                                        <input value="1" type="number" class="form-control" name="qt_rem">
                                                        <div class="input-group-prepend p-0"><span class="input-group-text m-0 p-3"><i class="fas fa-minus-square"></i></span></div>                            
                                                    </div>
                                                    <p class="mb-0 mt-2">Valor: R$ <label class="m-0 p-0"><b><?php echo $_SESSION['vl_prod'] ?></b>/<?php echo $_SESSION['un_prod'] ?></label><a class="ml-2" href="">Editar</a></p>   
                                                </div>                                     
                                            </div>
                                            <div class="col-md-3 m-0 p-0">
                                                <button type="submit" class="btn btn-success botao-card-conclui m-0 mt-1"><span class="fas fa-check-circle"></span></button>                                           
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            <?php endif; ?>                                   
                        <?php endif;?>

                        <!-- Verifica se o script saida_produtos retornou resultado. -->
                        <?php if(isset($_SESSION['result-out'])) : ?>
                            <!-- Se o resultado guardado na variavel de sessao result-out tiver um final "!", ou seja, um codigo de sucesso, então a classe do alerta será success -->
                            <div id="out-suc" class="<?php echo (substr($_SESSION['result-out'], -1) == '!') ? 'alert alert-success m-3' : 'alert alert-danger m-3';?>"><?php echo $_SESSION['result-out'] ?></div>
                        <?php endif;?>

                    </div>
                </div>

                <div class="<?php echo (isset($_SESSION['reg-product'])) ? 'collapse show mb-2' : 'collapse mb-2';?>" id="cadastro">
                    <div class="card card-body m-0 p-3 borda-cadastro" >
                        <h5 class="mt-2">Cadastro de novo produto</h5><hr>
                        <form action="?a=cadastro_produtos" method="POST">
                            <div class="text-left">
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <label><b><i id="icons" class="fas fa-barcode mr-2"></i>Código:</b></label>
                                        <input type="text" name="code_prod" class="form-control" title="Defina um código para o produto">
                                    </div>
                                    <div class="col-md-5">
                                        <label><b>Categoria:</b></label>
                                        <input type="text" name="cate_prod" class="form-control" title="Escolha uma categoria para o produto">
                                    </div>
                                    <div class="col-md-3">
                                        <label><i id="icons" class="fas fa-balance-scale mr-2"></i><b>Quantidade:</b></label>
                                        <input type="number" name="qt_prod" class="form-control" title="Quantidade do produto em estoque">
                                    </div>
                                </div>
                                <div class="form-goup mt-2">
                                    <label><b>Descrição/Nome:</b></label>
                                    <input type="text" name="nm_prod" class="form-control" title="Nome do produto">
                                </div>
                                <div class="form-goup mt-2">
                                    <label><i id="icons" class="fas fa-info-circle mr-2"></i><b>Informações:</b></label>
                                    <textarea type="text" name="text_info" class="form-control" title="Informações do produto"></textarea>
                                </div>
                                <div class="form-row mt-2">
                                    <div class="col-md-5">
                                        <label><i id="icons" class="far fa-money-bill-alt mr-2"></i><b>Valor de Custo:</b></label>
                                        <input type="text" name="vl_prod" class="form-control" title="Preço de custo">
                                    </div>
                                    <div class="col-md-5">
                                        <label><b>Preço de Venda:</b></label>
                                        <input type="text" name="vl_prod_sale" class="form-control" title="Preço de venda">
                                    </div>
                                    <div class="col-md-2">
                                        <label><b>Desconto:</b></label>
                                        <input type="text" name="pc_desc" class="form-control " title="Desconto em porcentagem" placeholder="%">
                                    </div>
                                </div>
                                <div class="form-row mt-2">
                                    <div class="col-md-5">
                                        <label><i id="icons" class="fas fa-boxes mr-2"></i><b>Unidade de medida:</b></label>
                                        <input type="text" name="un_prod" class="form-control mb-2" title="Unidade de medida/quantidade">
                                    </div>
                                    <div class="col-md-7">
                                        <label><i id="icons" class="fas fa-truck mr-2"></i><b>Fornecedor:</b></label>
                                        <input type="text" name="prov_prod" class="form-control mb-2" title="Descrição do fornecedor">
                                    </div>
                                </div>
                            </div>
                            <div class="text-center mt-3">
                                <button class="btn btn-dark mb-2"><i class="fas fa-sign-in-alt mr-2"></i>Cadastrar Produto</button>
                            </div>        
                        </form>
                        
                        <!-- Verifica se o script cadastro_produtos retornou resultado. -->
                        <?php if(isset($_SESSION['reg-product'])) : ?>
                            <!-- Se o resultado guardado na variavel de sessao reg-product tiver um final "!", ou seja, um codigo de sucesso, então a classe do alerta será success -->
                            <div id="reg-suc" class="<?php echo (substr($_SESSION['reg-product'], -1) == '!') ? 'alert alert-success m-3' : 'alert alert-danger m-3';?>"><?php echo $_SESSION['reg-product'] ?></div>
                        <?php endif;?>

                    </div>
                </div>
                <!-- Tabela e pesquisa rapida de produtos -->
                <div class="card p-2 m-0 mb-3">
                    <div class="text-center">
                        <h5 class="mt-2">Pesquisa de produtos cadastrados</h5><hr>
                        <!--Inicio da tabela-->
                        <div class="table-responsive ml-0 mr-0">
                            <table class="table table-striped table-bordered table-hover borda">
                                <!--Cabeçalho da tabela-->
                                <thead class="thead-dark">
                                    <th>Código</th>
                                    <th>Produto</th>
                                    <th>Quantidade</th>
                                    <th>Valor</th>
                                    <th class="text-center">Opções</th>
                                </thead>
                                <!--Corpo/Dados da tabela-->
                                <?php if(count($produtos) != 0) : ?>                                                 
                                    <?php foreach ($prod as $register) : ?>
                                        <tr>
                                            <td><b><?php echo $register['cd_alternative_product'] ?></b></td>
                                            <td><?php echo $register['ds_product'] ?></td>
                                            <td><?php echo $register['qt_product'] ?></td>
                                            <td><?php echo $register['vl_product'] ?></td>
                                            <td class="text-center"> <a href="?a=produto_editar&id=<?php echo $register['cd_product']?>"><i class="fas fa-edit"></i></a></td>
                                        </tr>
                                    <?php endforeach; ?>                                    
                                <?php else :?>
                                    <p>Ainda não existem produtos cadastrados nessa conta!</p>
                                <?php endif;?>    
                            </table>
                        </div>
                    </div>
                </div>
        </div>
        <div class="col-sm-3 offset-sm-6 m-0">
            <div class="card m-0 p-0">
                <div class="card p-1">
                    <div class="panel panel-default text-center espaco-paineis">                        
                        <p class="titulo-painel mt-1">Informações</p>
                        <div class="text-left">
                            <hr><p class="mt-1 mb-1"><b>Info:</b>&nbsp<label>None</label></p>
                            <hr><p class="mt-1 mb-1"><b>Info:</b>&nbsp<label>None</label></p>
                            <hr><p class="mt-1 mb-1"><b>Info:</b>&nbsp<label>None</label></p>
                            <hr><p class="mt-1 mb-2"><b>Info:</b>&nbsp<label>None</label></p>
                        </div>                          
                    </div> 
                </div>
            </div>
        </div>

        <?php if(isset($_SESSION['inp-product']))unset($_SESSION['inp-product']); ?>
        <?php if(isset($_SESSION['out-product']))unset($_SESSION['out-product']); ?>
        <?php if(isset($_SESSION['reg-product']))unset($_SESSION['reg-product']); ?>
        <?php if(isset($_SESSION['result-inp']))unset($_SESSION['result-inp']); ?>
        <?php if(isset($_SESSION['result-out']))unset($_SESSION['result-out']); ?>

    </div>  
</div>
