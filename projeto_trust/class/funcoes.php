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

        public static function VerificarLogin(){
            //verifica se o utilizador tem sessão ativa
            $resultado = false;
            if(isset($_SESSION['id_utilizador'])){
                $resultado = true;
            }
            return $resultado;
        }

        public static function VerificarLoginCliente(){
            //verifica se o utilizador cLiente tem sessão ativa
            $resultado = false;
            if(isset($_SESSION['id_cliente'])){
                $resultado = true;
            }
            return $resultado;
        }

        public static function IniciarSessao($dados){
            //iniciar a sessão
            $_SESSION['id_utilizador'] = $dados[0]['id_utilizador'];
            $_SESSION['nome'] = $dados[0]['nome'];
            $_SESSION['permissoes'] = $dados[0]['permissoes'];
            $_SESSION['email'] = $dados[0]['email'];
        }

        public static function IniciarSessaoCliente($dados){
            //iniciar a sessão do cliente
            $_SESSION['id_cliente'] = $dados[0]['id_cliente'];
            $_SESSION['nome_cliente'] = $dados[0]['nome'];
            $_SESSION['email_cliente'] = $dados[0]['email'];
        }

        public static function DestroiSessao(){
            //Abandona uma Sessão ativa
            unset($_SESSION['id_utilizador']);
            unset($_SESSION['nome']);
            unset($_SESSION['permissoes']);
            unset($_SESSION['email']);
        }

        
        public static function DestroiSessaoCliente(){
            //Abandona uma Sessão ativa
            unset($_SESSION['id_cliente']);
            unset($_SESSION['nome_cliente']);
            unset($_SESSION['email_cliente']);
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
                ':data_hora'        => $data_hora->format('Y-m-d H:i:s'),
                ':utilizador'       => $utilizador,
                ':mensagem'         => $mensagem
            ];
            $gestor->EXE_NON_QUERY(
                'INSERT INTO logs(data_hora, utilizador, mensagem)
                 VALUES(:data_hora, :utilizador, :mensagem)', $parametros);
        }

        public static function Permissao($index){
            //Verifica se o utilizador com sessão ativa tem permissão para determinada funcionalidade
            if(substr($_SESSION['permissoes'], $index, 1) == 1){
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

    }
?>