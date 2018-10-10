<?php 
// ==========================================================
// GESTÃO DE UTILIZADORES - NECESSARIA PERMISSAO DE ADM - 0
// ==========================================================

//verificar a sessão.
if(!isset($_SESSION['a'])){
    exit();
}

//verificar permissão de acesso
$erro_permissao = false;
if(!funcoes::Permissao(0)){
    $erro_permissao = true;
}

?>

<!--________________________________________________________________________ HTML ____________________________________________________________________________-->


<?php if($erro_permissao) : ?>
    <?php include('class/sem_permissao.php')?>
<?php else : ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col card mt-1 p-2">
                <h4 class="text-left mt-2 mb-0">Gestão de Sócios:</h4>

            <!-- Tabela dos utilizadores registrados na base de dados -->
                    <div class="table-responsive">          
                        <table class="table table-bordered table-striped table-hover">

                            <thead class="thead-dark">
                                <th></th>
                                <th>Utilizador</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th class="text-center">Editar</th>
                                <th class="text-center">Permissões</th>
                                <th class="text-center">Apagar</th>
                            </thead>

                            <?php 
                                $gestor = new cl_gestorBD();
                                $dados_utilizadores = $gestor->EXE_QUERY(
                                    'SELECT * FROM tab_partner ORDER BY nm_partner'
                                );                        
                            ?>

                            <?php foreach($dados_utilizadores as $utilizador) : ?>                    
                                <tr>
                                        <?php if(substr($utilizador['cd_permition'], 0, 1) == 1) : ?>
                                            <td><i class="fas fa-user"></i></td>
                                        <?php else : ?>
                                            <td><i class="far fa-user"></i></td>
                                        <?php endif; ?>

                                        <td><?php echo $utilizador['cd_login'] ?></td>
                                        <td><?php echo $utilizador['nm_partner'] ?></td>
                                        <td><?php echo $utilizador['ds_email'] ?></td>
                                        
                                        <!-- Coluna de Edição --> <!--+++++++++++++++++++++++++++++++++++++++++--> 
                                        <td> 
                                            <?php 
                                                $id = $utilizador['cd_login'] ;
                                                //definir se o dropdown vai aparecer
                                                $drop = true;
                                                if($id == 1 || $id == $_SESSION['cd_login_partner'] ){
                                                    $drop = false;
                                                }
                                            ?>

                                            <?php if($drop) : ?>
                                            <div class="text-center">
                                                    <a class="ml-2 mt-2 mb-2" href="?a=editar_utilizador&id=<?php echo $id ?>" title="Editar Utilizador"><i class="fas fa-edit"></i></a>                                                  
                                            </div>

                                            <?php else : ?>
                                                <div class="text-center">
                                                    <a class="text-muted ml-2 " href="?a=editar_utilizador&id=<?php echo $id ?>" title="Editar Utilizador"><i class="fas fa-edit"></i></a>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <!-- Coluna de Edição de Permissoes --> <!--+++++++++++++++++++++++++++++++++++++++++--> 
                                        <td> 
                                            <?php if($drop) : ?>
                                            <div class="text-center">
                                                    <a class="ml-2 " href="?a=editar_permissoes&id=<?php echo $id ?>" title="Editar Permissões"><i class="fas fa-list"></i></a>                              
                                            </div>

                                            <?php else : ?>
                                                <div class="text-center">
                                                    <a class="text-muted ml-2 " href="?a=editar_permissoes&id=<?php echo $id ?>" title="Editar Permissões"><i class="fas fa-list"></i></a>                                    
                                                </div>
                                            <?php endif; ?>
                                        
                                        </td>
                                        <!-- Coluna Delete --> <!--+++++++++++++++++++++++++++++++++++++++++--> 
                                        <td>
                                        <?php if($drop) : ?>
                                            <div class="text-center">
                                                    <a class="ml-2 " href="?a=eliminar_utilizador&id=<?php echo $id ?>" title="Eliminar Utilizador"><i class="fas fa-trash"></i></a>                                                                            
                                            </div>

                                            <?php else : ?>
                                                <div class="text-center">
                                                    <a class="text-muted ml-2 " href="?a=eliminar_utilizador&id=<?php echo $id ?>" title="Eliminar Utilizador"><i class="fas fa-trash"></i></a>  
                                                </div>
                                            <?php endif; ?>
                                        </td>                         
                                </tr>
                        <?php endforeach; ?>
                    </table>
                </div>

                <div class="text-center">
                    <a href="?a=inicio" class="btn btn-primary btn-size-150 mt-1 mb-1">Voltar</a>
                    <a href="?a=utilizadores_adicionar" class="btn btn-primary btn-size-150 mt-1 mb-1">Novo Sócio</a>
                </div> 

            </div>        
        </div>
    </div>

<?php endif; ?>
