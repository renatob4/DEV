<?php
    // ==========================================================
    // FUNÇÕES ESTATICAS
    // ==========================================================

    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }

    // ==================== FUNÇÕES =============================
    class funcoes{

        public static function VerificarLoginSocio(){
            //verifica se o utilizador tem sessão ativa
            $resultado = false;
            if(isset($_SESSION['cd_login_partner'])){
                $resultado = true;
            }
            return $resultado;
        }

        public static function VerificarLoginCliente(){
            //verifica se o utilizador cLiente tem sessão ativa
            $resultado = false;
            if(isset($_SESSION['cd_login_customer'])){
                $resultado = true;
            }
            return $resultado;
        }

        public static function IniciarSessaoSocio($dados){
            //iniciar a sessão
            $_SESSION['cd_partner'] = $dados[0]['cd_partner'];
            $_SESSION['cd_login_partner'] = $dados[0]['cd_login'];
            $_SESSION['nm_partner'] = $dados[0]['nm_partner'];
            $_SESSION['cd_permition'] = $dados[0]['cd_permition'];
            $_SESSION['ds_email'] = $dados[0]['ds_email'];
        }

        public static function IniciarSessaoCliente($dados){
            //iniciar a sessão do cliente
            $_SESSION['cd_customer'] = $dados[0]['cd_customer'];
            $_SESSION['cd_login_customer'] = $dados[0]['cd_login'];
            $_SESSION['nm_customer'] = $dados[0]['nm_customer'];
            $_SESSION['ds_email'] = $dados[0]['ds_email'];
        }

        public static function DestroiSessaoSocio(){
            //Abandona uma Sessão ativa
            unset($_SESSION['cd_partner']);
            unset($_SESSION['cd_login_partner']);
            unset($_SESSION['nm_partner']);
            unset($_SESSION['cd_permition']);
            unset($_SESSION['ds_email']);
        }
        
        public static function DestroiSessaoCliente(){
            //Abandona uma Sessão ativa
            unset($_SESSION['cd_customer']);
            unset($_SESSION['cd_login_customer']);
            unset($_SESSION['nm_customer']);
            unset($_SESSION['ds_email']);
        }

        public static function CriarCodigoAlfanumerico($numChars){
            //Gera uma senha randomica para recuperação do password
            $codigo = '';
            $caracteres = 'abcdefghijlmnopqrstuvxywzABCDEFGHIJLMNOPQRSTUVXYWZ0123456789';
            for($i = 0; $i < $numChars; $i++){
                $codigo .= substr($caracteres, rand(0, strlen($caracteres)) ,1);
            }
            return $codigo;
        }
        
        public static function CriarLOG($mensagem, $utilizador){
            //cria um registo em LOGS
            $gestor = new cl_gestorBD();
            $data_hora = new DateTime();
            $parametros = [
                ':dt_hour'          => $data_hora->format('Y-m-d H:i:s'),
                ':cd_login'         => $utilizador,
                ':ds_message'       => $mensagem
            ];
            $gestor->EXE_NON_QUERY(
                'INSERT INTO tab_log(dt_hour, cd_login, ds_message)
                 VALUES(:dt_hour, :cd_login, :ds_message)', $parametros);
        }

        public static function Permissao($index){
            //Verifica se o utilizador com sessão ativa tem permissão para determinada funcionalidade
            if(substr($_SESSION['cd_permition'], $index, 1) == 1){
                return true;
            }
            else{
                return false;
            }
        }

        public static function Paginacao($source, $pagina_atual, $itens_por_pagina, $total_itens){
            //Criar e controlar o mecanismo de paginação e navegação
            $max_paginas = floor($total_itens/$itens_por_pagina);

            echo '<div>';
                //pagina anterior
                if($pagina_atual == 1){
                    echo 'Anterior';
                } else{
                    echo '<a href="'.$source.'&p='.($pagina_atual-1).'">Anterior</a>';
                }

                echo " | ";

                //proxima pagina
                if($pagina_atual == $max_paginas){
                    echo 'Próxima';
                } else{
                    echo '<a href="'.$source.'&p='.($pagina_atual+1).'">Próxima</a>';
                }
            echo '</div>';
        }

        public static function DestroiSessaoForms(){
            unset($_SESSION['nm_empresa']);
            unset($_SESSION['ds_desc']);
            unset($_SESSION['ds_mail']);
            unset($_SESSION['ds_doc']);
            unset($_SESSION['tel_1']);
            unset($_SESSION['tel_2']);
            unset($_SESSION['cep']);
            unset($_SESSION['neighborhood']);
            unset($_SESSION['address']);
            unset($_SESSION['city']);
            unset($_SESSION['number']);
            unset($_SESSION['uf']);
            unset($_SESSION['complement']);
        }


        // public static function Endereco($cep){
        //     $parametros = [
        //         ':cd_cep'  => $cep
        //     ];
        //     $dtemp = $gestor->EXE_QUERY('SELECT 
        //         ts.cd_cep,
        //         ts.ds_street,
        //         tn.ds_neighborhood,
        //         tc.ds_city,
        //         tu.ds_uf_initials 
        //     FROM tab_street ts 
        //     INNER JOIN tab_neighborhood tn ON ts.cd_neighborhood = tn.cd_neighborhood
        //     INNER JOIN tab_city tc ON tc.cd_city = tn.cd_city
        //     INNER JOIN tab_uf tu ON tu.cd_uf = tc.cd_uf
        //     WHERE ts.cd_cep = :ts.cd_cep;', $parametros);

        //     if(count($dtemp) != 0){                        
        //         // $address=$dtemp[0]['ds_street'];
        //         // $neighborhood=$dtemp[0]['ds_neighborhood'];
        //         // $city=$dtemp[0]['ds_city'];
        //         // $uf=$dtemp[0]['ds_uf_initials'];
        //         return $dtemp;
        //     }
        // }

    }
?>