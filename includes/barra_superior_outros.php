<?php
    include_once '../../controladores/autenticacao_usuario.php';
    include_once '../../controladores/verificar_galpao.php';

    $cargo = $dados['cargo'];
    
    if($cargo == 2):
        $link = "../geral/pagina_restrita_veterinario.php";
    elseif($cargo == 3):
        $link = "../geral/pagina_restrita_funcionario.php";
    endif;
?>

<!-- Barra de navegação superior dos outros cargos -->

<nav class="navbar navbar-expand-md navbar-light bg-light fixed-top"> 
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">

            <li class="nav-item active">
                <a class="navbar-brand" href="<?php echo $link; ?>"> SWAGS </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?php echo $pagina; ?>"> Galpões </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="../geral/estoque.php"> Estoque </a>
            </li>

        </ul>
        <div class="my-2 my-lg-0">
            <p> Olá <?php echo $dados['nome']; ?> <a href="../../controladores/logout.php"> Sair </a></p>
        </div>
    </div>
</nav>

<!-- -->