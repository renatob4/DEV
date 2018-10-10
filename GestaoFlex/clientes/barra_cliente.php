<?php 

    // ==========================================================
    // Barra de login do cliente
    // ==========================================================

    //Controle de sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }
?>

    <!--Barra de login do cliente-->
    <div class="container-fluid barra-cliente">
        <div class="text-right">  

            <!--Cliente Logado-->
            <?php if(funcoes::VerificarLoginCliente()): ?>

                <a href=""><i class="fas fa-user mr-2"></a></i><?php echo $_SESSION['nm_customer'] ?>
                <div class="dropdown d-inline">
                    <button class="btn btn-primary dropdown-toggle ml-2 mr-2 btnh-size-300 btn-config" type="button" id="d1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-cog"></i> 
                    </button>
                    <div class="dropdown-menu" aria-labelledby="d1">
                        <a class="dropdown-item" href="?a=perfil">Acesso ao perfil</a>
                        <div class="dropdown-divider"></div>       
                        <a class="dropdown-item" href="?a=logout">Logout</a>
                    </div>
                </div>

            <!--Cliente NÃO Logado-->
            <?php else : ?>

                <div class="dropdown">
                    <!--Interruptor-->
                    <a href="" class="mr-2" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-sign-in-alt"></i> Login</a> |
                    <!--Caixa-->
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"> 
                        <form class="p-3" action="?a=login" method="post">
                            <div class="form-group">
                                <label for="formLogin"><i class="fas fa-id-card"></i> ID de Utilizador:</label>
                                <input type="text" class="form-control" id="formLogin" placeholder="User" name="text_utilizador" required>
                            </div>
                            <div class="form-group">
                                <label for="formPass"><i class="fas fa-key"></i> Senha:</label>
                                <input type="password" class="form-control" id="formPass" placeholder="Password" name="text_senha" required>
                            </div>
                            <div class="text-center"><a href="">Esqueceu a senha?</a><hr></div>
                            <div class="text-center"><button type="submit" class="btn btn-primary btn-size-150">Login</button></div>
                        </form>
                    </div> 
                <a href="?a=signup" class="ml-2"><i class="fas fa-user-plus"></i> Signup</a></div>

            <?php endif; ?>
        </div>
    </div>

