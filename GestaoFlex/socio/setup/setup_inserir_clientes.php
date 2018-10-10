<?php 
    // ========================================
    // setup - inserir clientes
    // ========================================

    // verificar a sessão
    if(!isset($_SESSION['a'])){
        exit();
    } 

    //-----------------------------------------
    $nomes_homem = [
        'Carlos','Alberto','Adriano','Americo','Rodrigo','Manuel',
        'Joaquim','Antonio','Jose','Mario','Rogerio','Hugo','Joao',
        'Xavier','Pedro','Rui','Diogo','Fernando','Flavio','Andre','Amilcar'
    ];

    $nomes_mulher = [
        'Ana','Maria','Isabel','Laura','Teresa','Catarina','Carolina',
        'Patricia','Gisela','Sandra','Fernanda','Luisa','Tatiana','Laurinda',
        'Paula','Rita','Carla','Mariana','MAfalda','Elsa','Luciana'
    ];

    $apelidos = [
        'Marques','Alves','Silva','Pereira','Teixeira','Rodrigues','Martins','Oliveira',
        'Coimbra','Albino','Muniz','Monteiro','Duarte','Vasconcelos','Montenegro',
        'Fagundes','Trindade','Vargas','Ferraz','Carvalho','Andrade','Barcelos','Vilela',
        'Santana','Barros','Goncalves','CAstro','Torres','Novais','Resende',
        'Sampaio','Abrantes','Sanches','Campos','Cavalcante','Menezes'.'Marinho',
        'Noronha','Ribeiro','Simoes','Dias','Carolino'
    ];
    
    //-----------------------------------------

    //inserir o utilizador admin
    $gestor = new cl_gestorBD();
    $numero_clientes = 50;

    //Limpar a tabela de clientes e zerar o auto_increment
    $gestor->EXE_NON_QUERY('DELETE FROM tab_customer');
    $gestor->EXE_NON_QUERY('ALTER TABLE tab_customer AUTO_INCREMENT = 1');

    //Criar cada um dos clientes e inserir na base
    for($i=0; $i < $numero_clientes; $i++){
        //define o genero
        $genero = rand(1,2);

        //define o nome do cliente
        $nome = '';
        if($genero == 1){
            $nome = $nomes_homem[rand(0,count($nomes_homem)-1)] . ' ' . $apelidos[rand(0,count($apelidos)-1)] . ' ' . $apelidos[rand(0,count($apelidos)-1)];
        } else {
            $nome = $nomes_mulher[rand(0,count($nomes_mulher)-1)] . ' ' . $apelidos[rand(0,count($apelidos)-1)] . ' ' . $apelidos[rand(0,count($apelidos)-1)];
        }

        //Criar um email ficticio do cliente
        $email_temp = strtolower(substr($nome,0,10)) . rand(1980,2018) . "@gmail.com";
        $email = str_replace(' ', '.', $email_temp);

        //Criar um username/utilizador para o cliente
        $utilizador_temp = strtolower(substr($nome,0,6)) . rand(1000,9999);
        $utilizador = str_replace(' ', '', $utilizador_temp);

        //Cria senha
        $palavra_passe = md5('abc123');

        //validação
        $codigo_validacao = funcoes::CriarCodigoAlfanumerico(30);

        //Inserir o novo cliente na BD
        $data = new DateTime();
        
        $parametros = [
            ':nm_customer'    =>    $nome,
            ':ds_email'       =>    $email, 
            ':cd_login'       =>    $utilizador, 
            ':cd_password'    =>    $palavra_passe,
            ':cd_validation'  =>    $codigo_validacao, 
            ':ic_validation'  =>    1,
            ':dt_register'    =>    $data->format('Y-m-d H:i:s'), 
            ':dt_updated'     =>    $data->format('Y-m-d H:i:s'),    
        ];

        $gestor->EXE_NON_QUERY('INSERT INTO tab_customer(nm_customer, ds_email, cd_login, cd_password, cd_validation, ic_validation, dt_register, dt_updated)
                                VALUES (:nm_customer, :ds_email, :cd_login, :cd_password, :cd_validation, :ic_validation, :dt_register, :dt_updated)', $parametros);
    }
?>

<div class="alert alert-success text-center"><?php echo $numero_clientes ?> Clientes inseridos com sucesso.</div>