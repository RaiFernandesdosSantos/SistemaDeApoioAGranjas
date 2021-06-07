<?php
    include '../../controladores/autenticacao_usuario.php';
    require_once '../../controladores/verificar_cargo.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
		<meta charset = "UTF-8">
		<title> Estoque </title>
		<?php include '../../includes/head.php'; ?>
	</head>
    <body style="background-color: lightgray;">
        <div class="container">
            <nav class="navbar navbar-expand-md navbar-dark bg-primary fixed-top"> 
                <div class="collapse navbar-collapse">
                    <div class="my-2 my-lg-0">
                        <a href="../cadastros/cadastrar_produto.php" class="btn btn-outline-warning"> Voltar </a>
                        <a href="../movimentacao/entrada.php" class="btn btn-outline-success"> Imprimir </a>
                    </div>
                </div>
            </nav>
            <div class="row">
                <div class=" offset-md-1 offset-lg-1 col-md-10 col-lg-10 bg-light">
                    <h4> Relatorio Diario - /Data/ </h4>
                    <?php
                        $galpoes = mysqli_query($conexao, "SELECT * FROM galpao");
                        while($gp = mysqli_fetch_array($galpoes))
                        {
                            $idg = $gp['id'];
                    ?>
                    <h6> <?php echo $gp['identificacao']; ?> </h6>
                    <table class="table table-dark table-striped">
                        <thead>
                            <tr>
                                <th scope="col"> Baia </th>
                                <th scope="col"> Quantidade de Porcos </th>
                                <th scope="col"> Media Peso </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $baia = mysqli_query($conexao, "SELECT * FROM baia WHERE id_galpao = '$idg'");
                                while($ba = mysqli_fetch_array($baia))
                                {
                                    $mes = date('m');
                                    $ano = date('Y');
                                    $idba = $ba['id'];
                                    $historico = mysqli_query($conexao, "SELECT * FROM historico_baia WHERE 
                                    EXTRACT(month from data_hora) = '$mes' AND EXTRACT(year from data_hora) = '$ano' AND id_baia = '$idba'");
                                    $histo = mysqli_fetch_array($historico);
                                    $anterior = $mes - 1;
                                    $hsitory = mysqli_query($conexao, "SELECT * FROM historico_baia WHERE 
                                    EXTRACT(month from data_hora) = '$anterior' AND EXTRACT(year from data_hora) = '$ano' 
                                    AND id_baia = '$idba'");
                                    $story = mysqli_fetch_array($hsitory);
                            ?>
                            <tr>
                                <td rowspan="2"><?php echo $ba['identificacao']; ?></td>
                                <td> Quantidade de Porcos Atual do Galpão: <?php echo $histo['qtde_porcos']; ?> </td>
                                <td> Media Peso do Atual do Galpão: <?php echo $histo['media_peso']; ?> </td>
                            </tr>
                            <tr>
                                <td> Quantidade de Porcos do mês anterior: <?php echo $story['qtde_porcos']; ?> </td>
                                <td> Media Peso do mês anterior do Galpão: <?php echo $story['media_peso']; ?> </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?php } ?>
                    <a href="../cadastros/cadastrar_produto.php" class="btn btn-outline-primary"> Voltar </a>
                    <a href="../movimentacao/entrada.php" class="btn btn-outline-success"> Imprimir </a>
                </div>
            </div>
        </div>
    </body>
</html>

<?php
    mysqli_close($conexao);
    unset($conexao);
?>