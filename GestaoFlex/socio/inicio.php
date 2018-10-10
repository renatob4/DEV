<?php
    // ==========================================================
    // INICIO - SOCIOS
    // ==========================================================

    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }

    //limpa os filtros das pesquisas
    if(isset($_SESSION['texto_pesquisa'])){
        unset($_SESSION['texto_pesquisa']);
    }
    if(isset($_SESSION['nm_empresa'])){
        funcoes::DestroiSessaoForms();
    }

    $gestor = new cl_gestorBD();

    //Verificar se ja existe negocio vinculado ao socio logado na base de dados.
    $parametros = [
        ':cd_partner'  =>  $_SESSION['cd_partner']
    ];
    $dtemp = $gestor->EXE_QUERY('SELECT cd_relationship FROM tab_company_partner WHERE cd_partner = :cd_partner', $parametros);

    if(count($dtemp) == 0){
        $erro = true;
        $mensagem = 'Não existe negócio cadastrado ainda.';
    } else{    
        $parametros = [
            ':cd_relationship'  =>  $dtemp[0]['cd_relationship']
        ];
        $dados_company = $gestor->EXE_QUERY('SELECT * FROM tab_company WHERE cd_relationship = :cd_relationship', $parametros);
    }
    
?>    

<div class="container-fluid">

        <!-- Paineis da pagina principal -->
        <div class="text-center m-0 p-0">
            <div class="row p-2">
                <div class="col-sm-8 p-2">
                    <!-- Panel lateral Esquerdo-->
                    <div class="card p-2">
                        <div class="text-center mt-3"><h3>Bem vindo a sua sessão de administração no GestãoFlex</h3></div><hr class="bgreen">
                        <p>Aqui na área principal você pode criar ou editar a sua loja, cadastrar seus produtos, administrar seu estoque e visualizar seus clientes. Tenha um ótimo trabalho!</p>
                        <div class="row text-center m-2 p-2">
                            <div class="col">
                                <a class="btn btn-primary botao-card" href="?a=clientes_listagem" title="Lista de Clientes">
                                <span class="fas fa-clipboard-list"></span></a>
                                <p class="m-0 m-0 mb-1"><b>Seus clientes</b></p>
                            </div>
                            <div class="col">
                                <?php if(count($dtemp) != 0) : ?>
                                    <a class="btn btn-primary botao-card" href="?a=negocios_editar_loja" title="Criar Nova Loja">
                                    <span class="fas fa-shopping-cart"></span></a>
                                    <p class="m-0 p-0 mb-1"><b>Perfil da loja</b></p>
                                <?php else :?>
                                    <a class="btn btn-primary botao-card" href="?a=negocios_nova_loja" title="Criar Nova Loja">
                                    <span class="fas fa-shopping-cart"></span></a>
                                    <p class="m-0 p-0 mb-1"><b>Criar loja</b></p>
                                <?php endif; ?>
                            </div>
                            <div class="col">
                                <a class="btn btn-primary botao-card" href="?a=perfil" title="Gerenciar Estoque">
                                <span class="fas fa-user-circle"></span></a>
                                <p class="m-0 p-0 mb-1"><b>Seu perfil</b></p>
                            </div>
                            <div class="col">
                                <a class="btn btn-primary botao-card" href="" title="Suporte">
                                <span class="fas fa-question"></span></a>
                                <p class="m-0 p-0 mb-1"><b>Ajuda</b></p>
                            </div>
                        </div>

                        <!--  ______________ Painel do negocio com opçoes de gerenciamento ______________-->
                        <div class="card borda-loja p-0 m-2">
                            <div class="card p-5" style="background-color: grey;">
                                <!-- <img src="" alt=""> -->       
                                <div class="">
                                    <h5 class="card-title"><a class="btn btn-dark" data-toggle="collapse" href="#referencia" role="button" aria-expanded="true" aria-controls="collapseExample"><?php echo (count($dtemp) != 0) ? strtoupper($dados_company[0]['nm_company']) : 'NOME DO NEGOCIO'; ?></a></h5>
                                </div>        
                            </div>
                            <!-- div collapssada com os botoes -->
                            <div class="card-body p-0">
                                <div class="collapse show" id="referencia">
                                    <div class="card card-body">
                                        <!--Verifica quais opções carregar de acordo com a existencia do negocio-->
                                        <?php if(count($dtemp) != 0) : ?>
                                        <div class="row text-center m-0 p-0">
                                                <div class="col">
                                                    <a class="btn btn-success botao-card" href="" title="Estatisticas de Vendas">
                                                    <span class="fas fa-chart-line"></span></a>
                                                    <p class="m-0 m-0 mb-1">Estatisticas</p>
                                                </div>
                                                <div class="col">
                                                    <a class="btn btn-success botao-card" href="" title="Pedidos">
                                                    <span class="fas fa-tasks"></span></a>
                                                    <p class="m-0 m-0 mb-1">Pedidos</p>
                                                </div>
                                                <div class="col">
                                                    <a class="btn btn-success botao-card" href="" title="Produtos">
                                                    <span class="fas fa-cube"></span></a>
                                                    <p class="m-0 m-0 mb-1">Produtos</p>
                                                </div>
                                                <div class="col">
                                                    <a class="btn btn-success botao-card" href="?a=gerenciar_estoque" title="Gerenciar Estoque">
                                                    <span class="fas fa-boxes"></span></a>
                                                    <p class="m-0 p-0 mb-1">Gerenciar Estoque</p>
                                                </div>
                                        </div>
                                        <?php else :?>
                                            Cadastre um novo negócio/loja para acessar as opções de administração.
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- opções disponíveis apenas para admin - indice 0 -->
                        <?php if(funcoes::Permissao(0)): ?>
                            <hr><div class="text-center mb-2">
                                <h3 class="mb-3">Sessão de administrador</h3>
                                <!--Botão para entrar no Setup-->
                                <div class="row text-center m-0 p-0">
                                    <div class="col">
                                        <a class="btn btn-danger botao-card" href="?a=setup" title="SETUP">
                                        <span class="fas fa-cogs"></span></a>
                                        <p class="m-0 p-0 mb-1">Setup</p>
                                    </div>
                                </div>
                            </div>    
                         <?php endif; ?>     

                    </div> 

                    <!-- Painel final com o codigo de relacionamento da loja -->
                    <div class="card p-3 mt-3">
                        <div class="row p-0 m-0">
                            <div class="col pt-0 pb-0">
                                <?php if(count($dtemp) != 0) : ?>
                                    <div class="text-left p-0"><h5>Código de relacionamento com o cliente:</h5>
                                    <div class="text-center"><label style="font-size: 1.4em;"><b><?php echo $dados_company[0]['cd_relationship'] ?></b></label></div>
                                <?php else: ?>
                                    <div class="text-center p-0"><h5>Você ainda não possui um código.</h5>
                                    <div class="text-center"><label style="font-size: 0.8em;"><b>Crie um novo negócio para receber um código de relacionamento com o cliente.</b></label></div>
                                <?php endif; ?>
                            </div>
                            </div>
                            <div class="col p-2 bgreenfull">
                                <!-- espaço vago para funcionalidade -->
                            </div>
                        </div>
                    </div>

                    </div>
                    <div class="col-sm-4 p-2">
                        <!-- Panel lateral Direito -->
                        <div class="card p-1">
                            <div class="panel panel-default text-center espaco-paineis">                        
                                <p class="titulo-painel mt-1">GRÁFICO</p>
                                <?php if(count($dtemp) != 0) : ?>
                                    <div class="card p-0" style="background-color: lightgrey;">
                                        <div><img class="img-fluid" style="width: 333px; height: 180px; border: solid 1px green;" src="../_notas_e_material/grafico.jpg"></div>
                                    </div>
                                <?php else :?>
                                    <div class="card p-0" style="background-color: lightgrey; width: 333px; height: 180px;">
                                        <div class="text-center"><i class="fas fa-chart-pie" style="width: 170px; height: 170px; color: white;"></i></div>
                                    </div>
                                <?php endif; ?>
                                <a href="" class="btn btn-primary btn-size-200 mt-3"><i class="fas fa-exchange-alt"></i>&nbsp&nbsp<b>Trocar Gráfico</b></a>
                            </div> 
                            <div class="panel panel-default text-center espaco-paineis">
                                <p class="titulo-painel mt-1">INFORMAÇÕES VITAIS</p>
                                <!-- <p>Irure enim ipsum ullamco ut sint exercitation consectetur et do nostrud. Amet minim cupidatat nostrud Lorem laboris eu in sit ad dolore.</p> -->
                                <div class="text-left">
                                    <p class="mt-1 mb-1"><b>Contagem de clientes:</b>&nbsp<label>None</label></p>
                                    <p class="mt-1 mb-1"><b>Status dos estoques:</b>&nbsp<label>None</label></p>
                                    <p class="mt-1 mb-1"><b>Pedidos a atender:</b>&nbsp<label>None</label></p>
                                    <p class="mt-1 mb-2"><b>Mensagens:</b>&nbsp<label>None</label></p>
                                </div>
                                <a href="" class="btn btn-primary btn-size-200"><i class="fas fa-exchange-alt"></i>&nbsp&nbsp<b>Alterar informações</b></a>
                            </div> 
                        </div>
                    </div>
            </div>
        </div>
</div> 

