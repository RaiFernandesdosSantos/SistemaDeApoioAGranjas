<?php
    include_once '../../controladores/autenticacao_usuario.php';

    //Script para verificar o cargo do úsuario

    $cargo = $dados['cargo'];
    
    if($cargo == 1):
        $bl = "../../includes/barra_lateral_gerente.php";
        $bs = "../../includes/barra_superior_gerente.php";
        elseif($cargo == 2 || $cargo == 3):
            $bl = "../../includes/barra_lateral_outros.php";
            $bs = "../../includes/barra_superior_outros.php";
    endif;
    
    // ?>