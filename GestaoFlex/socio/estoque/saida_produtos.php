<?php 

    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }

    //Limpar interações anteriores
    // if(isset($_SESSION['result-inp'])){
    //     unset($_SESSION['result-inp']);
    // }
    // if(isset($_SESSION['result-out'])){
    //     unset($_SESSION['result-out']);
    // }

    // --------------------------------------------------------

    //Variaveis uteis de controle
    $gestor = new cl_gestorBD();

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        //Busca o valor a ser acrescentado definido no form
        $qt_rem  =  $_POST['qt_rem'];
        //Busca o código do produto armazenado na variavel de sessão para puxar a quantidade atual contida no banco.
        $busca = $_SESSION['cod_prod'];

        //Pesquisa no banco pelo código fornecido pela sessão.
        $parametros = [
            ':cd_alternative_product'  =>  $busca 
        ];
        $aux = $gestor->EXE_QUERY('SELECT * FROM tab_product WHERE cd_alternative_product = :cd_alternative_product', $parametros);

        //Retira a quantidade a ser adicionada com a quantidade previamente contida no banco.
        $qt_atual = ($aux[0]['qt_product'] - $qt_rem);

        $parametros = [
            ':cd_alternative_product'  =>   $busca, 
            ':qt_product'              =>   $qt_atual,
            ':dt_updated'              =>   DATAS::DataHoraAtualBD()
        ];  
        //Atualiza a quantidade do produto no banco de dados.
        $gestor->EXE_NON_QUERY('UPDATE tab_product SET qt_product = :qt_product, dt_updated = :dt_updated 
                                WHERE cd_alternative_product = :cd_alternative_product', $parametros);

    } 

    //Redireciona após terminar a execução
    $_SESSION['result-out'] = '<b>'.$busca.'</b>'.' Quantidade ('.$qt_rem.') Retirada com sucesso!';
    header("Location:?a=gerenciar_estoque&action=out");
    
?>