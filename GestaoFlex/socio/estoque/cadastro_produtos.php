<?php 

    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }

    //Principal
    if(isset($_SESSION['reg-product'])){
        unset($_SESSION['reg-product']);
    }
    if(isset($_SESSION['out-product'])){
        unset($_SESSION['out-produto']);
    }
    if(isset($_SESSION['inp-product'])){
        unset($_SESSION['inp-product']);
    }

    // --------------------------------------------------------

    //Variaveis uteis de controle
    $gestor = new cl_gestorBD();
    $erro = false;
    $cadastrado = false;
    $sucesso = false;
    $mensagem = '';
   
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        //Busca valores do form
        $code_prod      =  $_POST['code_prod'];
        $cate_prod      =  $_POST['cate_prod'];
        $qt_prod        =  $_POST['qt_prod'];
        $nm_prod        =  $_POST['nm_prod'];
        $text_info      =  $_POST['text_info'];
        $vl_prod        =  $_POST['vl_prod'];
        $vl_prod_sale   =  $_POST['vl_prod_sale'];
        $pc_desc        =  $_POST['pc_desc'];
        $un_prod        =  $_POST['un_prod'];
        $prov_prod      =  $_POST['prov_prod'];

        //Verificações -------------------------------------------
    
        if(!$erro){
            //Verifica se o codigo do produto ja existe na base de dados
            $parametros = [
                ':cd_alternative_product'  =>  $code_prod 
            ];
            $dtemp = $gestor->EXE_QUERY('SELECT cd_alternative_product FROM tab_product WHERE cd_alternative_product = :cd_alternative_product', $parametros);
            if(count($dtemp) != 0){
                $erro = true;
                $mensagem = 'Já existe um produto com este mesmo Código :(';
            }
        }

        //Inserções ----------------------------------------------
      
        if(!$erro){
            $parametros = [
                ':cd_alternative_product'  => $code_prod,
                ':ds_product'              => $nm_prod,
                ':ds_category'             => $cate_prod,
                ':ds_info'                 => $text_info,
                ':vl_product'              => $vl_prod,
                ':vl_product_sale'         => $vl_prod_sale,
                ':pc_discount'             => $pc_desc,
                ':qt_product'              => $qt_prod,
                ':ds_unity'                => $un_prod,
                ':ds_provider'             => $prov_prod,
                ':dt_register'             => DATAS::DataHoraAtualBD(),
                ':dt_updated'              => DATAS::DataHoraAtualBD()
            ];
            //inserir o produto na base
            $gestor->EXE_NON_QUERY(
                    'INSERT INTO tab_product(cd_alternative_product, ds_product, ds_category, ds_info, vl_product, vl_product_sale, pc_discount, qt_product, ds_unity, ds_provider, dt_register, dt_updated)
                    VALUES(:cd_alternative_product, :ds_product, :ds_category, :ds_info, :vl_product, :vl_product_sale, :pc_discount, :qt_product, :ds_unity, :ds_provider, :dt_register, :dt_updated)', $parametros);            
        }

        if(!$erro){
            $parametros = [
                ':cd_partner'              => $_SESSION['cd_partner'],
                ':cd_alternative_product'  => $code_prod
            ];
            //Inserir relação entre o produto e o sócio que cadastrou o produto.
            $gestor->EXE_NON_QUERY(
                    'INSERT INTO tab_partner_product(cd_partner, cd_alternative_product)
                     VALUES(:cd_partner, :cd_alternative_product)', $parametros);
        } 

    }

    //Finalização e retorno de resultado via string.
    if(!$erro){
        $_SESSION['reg-product'] = '<b>'.$code_prod.'</b>'.' Cadastrado com sucesso !';
        header("Location:?a=gerenciar_estoque");
    } else{
        $_SESSION['reg-product'] = $mensagem;
        header("Location:?a=gerenciar_estoque");
    }

?>