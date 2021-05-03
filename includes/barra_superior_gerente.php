<?php 
    include_once '../../controladores/verificar_galpao.php';
?>

<nav class="navbar navbar-expand-md navbar-light bg-light fixed-top"> 
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="navbar-brand" href="../geral/pagina_restrita_gerente.php"> SWMES </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"> Sistema de engorda </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../cadastros/registro.php"> Cadastro de Funcionarios </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $pagina; ?>"> Galpões </a>
            </li>
        </ul>
        <div class="my-2 my-lg-0">
            <p> Olá <a href="#"> <?php echo $dados['nome']; ?> </a>, <a href="../../controladores/logout.php"> Sair </a></p>
        </div>
    </div>
</nav>