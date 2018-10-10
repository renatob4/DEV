<?php
    // ==========================================================
    // SETUP - CRIAR A BASE DE DADOS
    // ==========================================================

    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }

    //Cria a base de dados.
    $gestor = new cl_gestorBD();
    $configs = include('../class/config.php');

    //Apagar a base de dados caso ela exista.
    $gestor->EXE_NON_QUERY('DROP DATABASE IF EXISTS '.$configs['BD_DATABASE']);
    //Criar a nova base de dados.
    $gestor->EXE_NON_QUERY('CREATE DATABASE '.$configs['BD_DATABASE'].' CHARACTER SET UTF8 COLLATE utf8_general_ci');
    $gestor->EXE_NON_QUERY('USE '.$configs['BD_DATABASE']);

    // ===========================================================
    // CRIAÇãO DAS TABELAS
    // ===========================================================

    //tabela tab_partner
    $gestor->EXE_NON_QUERY(
        'CREATE TABLE tab_partner('.
        'cd_partner                     INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT, '.
        'cd_login                       NVARCHAR(50), '.
        'cd_password                    NVARCHAR(32), '.
        'nm_partner                     NVARCHAR(50), '.
        'ds_email                       NVARCHAR(50), '.
        'cd_permition                   NVARCHAR(32), '.
        'ic_status                      INT, '.
        'dt_register                    DATETIME, '.
        'dt_updated                     DATETIME)'
    );

    //tabela tab_customer
    $gestor->EXE_NON_QUERY(
        'CREATE TABLE tab_customer('.
        'cd_customer                     INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT, '.
        'nm_customer                     NVARCHAR(50), '.
        'ds_email                        NVARCHAR(50), '.
        'cd_login                        NVARCHAR(50), '.
        'cd_password                     NVARCHAR(32), '.        
        'cd_validation                   NVARCHAR(32), '.   
        'ic_validation                   INT, '.
        'dt_register                     DATETIME, '.
        'dt_updated                      DATETIME)'
    );

    //tabela tab_phone
    $gestor->EXE_NON_QUERY(
        //As categorias para o portador(cd_carrier) são: "1" = partner, "2" = company, "3" = customer
        'CREATE TABLE tab_phone('.
        'cd_phone                        NVARCHAR(20) NOT NULL, '.
        'cd_carrier                      INT, '.
        'cd_type_carrier                 INT, '.
        'dt_register                     DATETIME, '.
        'dt_updated                      DATETIME)'
    );

    //tabela tab_log
    $gestor->EXE_NON_QUERY(
        'CREATE TABLE tab_log('.
        'cd_log                          INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT, '.
        'dt_hour                         DATETIME, '.
        'cd_login                        NVARCHAR(50), '.
        'ds_message                      NVARCHAR(256))'
    );

    //tabela tab_profile
    $gestor->EXE_NON_QUERY(
        'CREATE TABLE tab_profile('.
        'cd_profile                      INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT, '.  
        'dt_register                     DATETIME, '.
        'dt_updated                      DATETIME)'
    );

    //tabela tab_configuration
    $gestor->EXE_NON_QUERY(
        'CREATE TABLE tab_configuration('.
        'cd_configuration                INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT, '.  
        'dt_register                     DATETIME, '.
        'dt_updated                      DATETIME)'
    );

    //tabela tab_order
    $gestor->EXE_NON_QUERY(
        'CREATE TABLE tab_order('.
        'cd_order                        INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT, '.  
        'dt_order                        DATETIME, '.
        'qt_order                        INT)'
    );
   
    //tabela tab_product
    $gestor->EXE_NON_QUERY(
        'CREATE TABLE tab_product('.
        'cd_product                      INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT, '.
        'cd_alternative_product          VARCHAR(12) UNIQUE, '.
        'ds_product                      NVARCHAR(32), '.        
        'ds_category                     NVARCHAR(20), '.
        'ds_info                         NVARCHAR(100), '.         
        'vl_product                      FLOAT, '.
        'vl_product_sale                 FLOAT, '.
        'pc_discount                     INT UNSIGNED, '.          
        'qt_product                      INT, '.
        'ds_unity                        VARCHAR(12), '.
        'ds_provider                     VARCHAR(50), '.    
        'dt_register                     DATETIME, '.
        'dt_updated                      DATETIME)'
    );

    //tabela tab_company
    $gestor->EXE_NON_QUERY(
        'CREATE TABLE tab_company('.
        'cd_company                      INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT, '.
        'nm_company                      NVARCHAR(60), '.
        'ds_company                      NVARCHAR(256), '.  
        'ds_email                        NVARCHAR(50), '.          
        'ds_document                     NVARCHAR(14), '.
        'cd_relationship                 NVARCHAR(32), '.    
        'dt_register                     DATETIME, '.
        'dt_updated                      DATETIME)'
    );

    //tabela tab_audit
    $gestor->EXE_NON_QUERY(
        'CREATE TABLE tab_audit('.
        'cd_audit                        INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT, '.
        'ds_audit                        NVARCHAR(100), '.    
        'dt_register                     DATETIME, '.
        'qt_updated                      DATETIME)'
    );

    //tabela de resolução tab_company_partner
    $gestor->EXE_NON_QUERY(
        'CREATE TABLE tab_company_partner('.
        'cd_relationship                            NVARCHAR(32) UNIQUE NOT NULL, '.
        'cd_partner                                 INT NOT NULL)' 
    );

    //tabela de resolução tab_company_customer
    $gestor->EXE_NON_QUERY(
        'CREATE TABLE tab_company_customer('.
        'cd_company_customer                        INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,'.
        'cd_relationship                            NVARCHAR(32) NOT NULL, '.
        'cd_customer                                INT NOT NULL)'   
    );

    //tabela de resolução tab_partner_product
    $gestor->EXE_NON_QUERY(
        'CREATE TABLE tab_partner_product('.
        'cd_partner_product                         INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,'.
        'cd_partner                                 INT NOT NULL, '.
        'cd_alternative_product                     VARCHAR(12) UNIQUE)'   
    );
    
    //tabela tab_uf
    $gestor->EXE_NON_QUERY(
        'CREATE TABLE tab_uf('.
        'cd_uf                                      INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,'.
        'ds_uf_initials                             NVARCHAR(2) NOT NULL, '.
        'ds_uf                                      NVARCHAR(19) NOT NULL)'   
    );

    //tabela tab_city
    $gestor->EXE_NON_QUERY(
        'CREATE TABLE tab_city('.
        'cd_city                                      INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,'.
        'cd_uf                                        INT UNSIGNED NOT NULL, '.
        'ds_city                                      NVARCHAR(58) NOT NULL,'.
        'FOREIGN KEY (cd_uf) REFERENCES tab_uf (cd_uf))'   
    );

    //tabela tab_neighborhood
    $gestor->EXE_NON_QUERY(
        'CREATE TABLE tab_neighborhood('.
        'cd_neighborhood                            INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,'.
        'cd_city                                    INT UNSIGNED NOT NULL, '.
        'ds_neighborhood                            NVARCHAR(63) NOT NULL,'.
        'FOREIGN KEY (cd_city) REFERENCES tab_city (cd_city))'
    );

    //tabela tab_street
    $gestor->EXE_NON_QUERY(
        'CREATE TABLE tab_street('.
        'cd_street                                  INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,'.
        'cd_neighborhood                            INT UNSIGNED NOT NULL, '.
        'cd_type                                    INT UNSIGNED NOT NULL, '.
        'ds_street                                  NVARCHAR(120) NOT NULL, '.
        'cd_cep                                     INT UNSIGNED NOT NULL,'.
        'FOREIGN KEY (cd_neighborhood) REFERENCES tab_neighborhood (cd_neighborhood))'
    );

    //tabela tab_address
    $gestor->EXE_NON_QUERY(
        'CREATE TABLE tab_address('.
        'cd_address                                 INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,'.
        'cd_street                                  INT UNSIGNED NOT NULL, '.
        'cd_number                                  INT UNSIGNED NOT NULL, '.
        'cd_complement                              NVARCHAR(20) NOT NULL, '.
        'cd_carrier                                 INT UNSIGNED NOT NULL, '.
        'cd_type_carrier                            INT UNSIGNED NOT NULL, '.
        'dt_register                                DATETIME, '.
        'dt_updated                                 DATETIME,'.
        'FOREIGN KEY (cd_street) REFERENCES tab_street (cd_street))'
    );

    //tabela de resolução tab_partner_customer
    //tabela de resolução partner_configuration
    //$gestor->EXE_NON_QUERY('ALTER TABLE clientes AUTO_INCREMENT = ' + 1);
?>

<div class="alert alert-success text-center">Base de dados criada com sucesso!</div>


