<?php
    $existe = "SELECT * FROM galpao";
    $resul = mysqli_query($conexao, $existe);
    if(mysqli_num_rows($resultado) == 1):
        $pagina = "../geral/lista_baia_galpao.php";
    else:
        $pagina = "../cadastros/cadastro_galpoes.php";
    endif;
?>