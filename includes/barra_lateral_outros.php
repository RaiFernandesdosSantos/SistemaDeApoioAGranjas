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

<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="sidebar-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="<?php echo $link; ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                Pagina Inicial
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../geral/estoque.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                Estoque
                </a>
            </li>
        </ul>
    </div>
</nav>