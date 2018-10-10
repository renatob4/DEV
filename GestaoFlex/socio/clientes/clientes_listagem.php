<?php
    // ==========================================================
    // Listagem de clientes
    // ==========================================================

    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }

    //Verifica se foi definida clear
    if(isset($_GET['clear'])){
        if(isset($_SESSION['texto_pesquisa'])){
            unset($_SESSION['texto_pesquisa']);
        }
    }

    //Veficica se ocorreu um POST
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if($_POST['text_pesquisa'] != ''){
            $_SESSION['texto_pesquisa'] = $_POST['text_pesquisa'];
        }
    }

    //carregar os dados dos clientes
    $gestor = new cl_gestorBD();
    $clientes = null;
    //paginação
    $total_clientes = 0;
    $pagina = 1;

    if(isset($_GET['p'])){
        $pagina = $_GET['p'];
    }

    $itens_por_pagina = 10;
    $item_inicial = ($pagina * $itens_por_pagina) - $itens_por_pagina;

    if(isset($_SESSION['texto_pesquisa'])){
        //Pesquisa com filtro       
        $parametros = ['pesquisa'   =>  '%' . $_SESSION['texto_pesquisa'] . '%'];

        $clientes = $gestor->EXE_QUERY('SELECT * FROM tab_customer 
                                        WHERE nm_customer LIKE :pesquisa 
                                        OR ds_email LIKE :pesquisa 
                                        ORDER BY nm_customer ASC 
                                        LIMIT '.$item_inicial.','.$itens_por_pagina, $parametros);

        $total_clientes = count($gestor->EXE_QUERY('SELECT * FROM tab_customer WHERE nm_customer LIKE :pesquisa OR ds_email LIKE :pesquisa ORDER BY nm_customer ASC', $parametros));

    } else {
        //Pesquisa sem filtro       
         $clientes = $gestor->EXE_QUERY('SELECT * FROM tab_customer ORDER By nm_customer ASC LIMIT '.$item_inicial.','.$itens_por_pagina);
         $total_clientes = count($gestor->EXE_QUERY('SELECT * FROM tab_customer'));
    }

?>    

<div class="container p-0 mt-2">

    <nav class="navbar navbar-light bg-light">
        <a class="navbar-brand"><h5 class="ml-2 mt-2">Listagem de clientes: <label style="opacity: 0.3" class=""><?php echo $total_clientes?> <?php echo $total_clientes > 1 ? 'Clientes' : 'Cliente'; ?></label></h5></a>
            <form class="form-inline text-right" action="?a=clientes_listagem" method="post">
                <input type="search" class="form-control mr-sm-2 borda-text" style="min-width:300px;" name="text_pesquisa" placeholder="Pesquisar" value="<?php echo (isset($_SESSION['texto_pesquisa'])) ? $_SESSION['texto_pesquisa'] : ''; ?>">
                <button class="btn btn-primary p-2 text-center mt-2 mb-2" ><i class="fa fa-search" aria-hodden="true"></i></button>
                <a href="?a=clientes_listagem&clear=true" class="btn btn-secondary text-center ml-1 p-2"><i class="fa fa-times" aria-hodden="true"></i></a>                          
            </form>
    </nav>
    
    <!--Inicio da tabela-->
    <div class="table-responsive ml-0 mr-0">
        <table class="table table-striped table-bordered table-hover borda">
            <!--Cabeçalho da tabela-->
            <thead class="thead-dark">
                <th>Nome</th>
                <th>Email</th>
                <th>Utilizador</th>
                <th class="text-center">Eliminar</th>
            </thead>
            <!--Corpo/Dados da tabela-->
                <?php foreach ($clientes as $cliente) : ?>
                <tr>
                    <td><a href="?a=clientes_dados&id=<?php echo $cliente['cd_login']?>"><?php echo $cliente['nm_customer'] ?></a></td>
                    <td><a href="mailto:<?php echo $cliente['ds_email'] ?>"><?php echo $cliente['ds_email'] ?></a></td>
                    <td><?php echo $cliente['cd_login'] ?></td>
                    <td class="text-center"> <a href="?a=clientes_eliminar&id=<?php echo $cliente['cd_login']?>"> <i class="fa fa-trash"></i> </a></td>
                </tr>
                <?php endforeach; ?>    
        </table>
    </div>

    <div class="row mt-0 mb-3 mr-1 ml-1">
        <!--Pagina Atual-->
        <div class="col-sm-6 text-left">
            <label style="opacity: 0.5"><?php echo 'Pagina: ' . $pagina ?></label>
        </div>
        <!--Mecanismo de paginação-->
        <div class="col-sm-6 text-right">
            <?php funcoes::Paginacao('?a=clientes_listagem', $pagina, $itens_por_pagina, $total_clientes) ?>
        </div>
    </div>
      
</div>
