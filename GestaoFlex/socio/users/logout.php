<?php 
// ========================================
// logout
// ========================================

// verificar a sessão
if(!isset($_SESSION['a'])){
    exit();
}

$nome = $_SESSION['nm_partner'];
//executa o logout (destruição) da sessão
funcoes::DestroiSessaoSocio();

//log
funcoes::CriarLOG('utilizador: '.$nome.'Fez logout.', $nome);

?>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-4 card m-3 p-3 text-center">            
            <p>Até à próxima visita, <?php echo $nome ?></p>
            <a href="?a=inicio" class="btn btn-primary">Início</a>
        </div>        
    </div>
</div>