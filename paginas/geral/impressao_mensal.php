<?php
    include '../../controladores/autenticacao_usuario.php';
    require_once '../../controladores/verificar_cargo.php';
    $data = date("d / m / y");
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
		<meta charset = "UTF-8">
		<title class="no-print"> Estoque </title>
		<?php include '../../includes/head.php'; ?>
	</head>
    <body style="background-color: lightgray;">
        <div class="container">
            <nav class="navbar navbar-expand-md navbar-dark bg-primary fixed-top"> 
                <div class="collapse navbar-collapse">
                    <div class="my-2 my-lg-0">
                        <a href="../geral/pagina_restrita_gerente.php" class="btn btn-outline-warning noprint"> Voltar </a>
                        <button class="btn btn-outline-success noprint" onclick="print()"> Imprimir </button>
                    </div>
                </div>
            </nav>
            <div class="row">
                <div class=" offset-md-1 offset-lg-1 col-md-10 col-lg-10 bg-light">
                    <h3> Relatório Mensal - <?php echo $data; ?></h3>
                    <h5> Galpões </h5>
                    <table class="table table-light table-striped">
                        <thead>
                            <tr>
                                <th scope="col"> Galpão </th>
                                <th scope="col"> Quantidade de Porcos Atual </th>
                                <th scope="col"> Média Peso Atual </th>
                                <th scope="col"> Crescimento de porcos comparado com mês anterior </th>
                                <th scope="col"> Crescimento de peso comparado com mês anterior </th>
                            </tr>
                        </thead>
                        <?php
                            $galpoes = mysqli_query($conexao, "SELECT * FROM galpao");
                            while($gp = mysqli_fetch_array($galpoes))
                            {
                                $idg = $gp['id'];
                                $tq = 0;
                                $tm = 0;
                                $tqa = 0;
                                $tma = 0;
                                $baia = mysqli_query($conexao, "SELECT * FROM baia WHERE id_galpao = '$idg'");
                                while($ba = mysqli_fetch_array($baia))
                                {
                                    $mes = date('m');
                                    $ano = date('Y');
                                    $idba = $ba['id'];
                                    $sql = mysqli_query($conexao, "SELECT * FROM historico_baia WHERE 
                                    EXTRACT(month from data_hora) = '$mes' AND EXTRACT(year from data_hora) = '$ano' AND id_baia = '$idba'");
                                    $histo = mysqli_fetch_array($sql);
                                    $tq += $histo['qtde_porcos'];
                                    $tm += $histo['media_peso'];
                                    $anterior = $mes - 1;
                                    $sql = mysqli_query($conexao, "SELECT * FROM historico_baia WHERE 
                                    EXTRACT(month from data_hora) = '$anterior' AND EXTRACT(year from data_hora) = '$ano' 
                                    AND id_baia = '$idba'");
                                    $hs = mysqli_fetch_array($sql);
                                    $tqa += $hs['qtde_porcos'];
                                    $tma += $hs['media_peso'];
                                }
                                $cresq = $tq - $tqa;
                                $porq = ($cresq * 100) / $tqa;
                                $cresm = $tm - $tma;
                                $porm = ($cresm * 100) / $tma;
                                $porq = round($porq, 2);
                                $porm = round($porm, 2);
                        ?>
                        <tbody>
                            <tr>
                                <td rowspan="2"><?php echo $gp['identificacao']; ?></td>
                                <td> Quantidade de Porcos Atual do Galpão: <?php echo $tq; ?></td>
                                <td> Média Peso do Atual do Galpão: <?php echo $tm; ?></td>
                                <td><?php echo $porq; ?>% (<?php echo $cresq; ?>) </td>
                                <td><?php echo $porm; ?>% (<?php echo $cresm; ?>) </td>
                            </tr>
                        </tbody>
                        <?php } ?>
                    </table>
                    <h5> Historico de Ações nas Baias </h5>
                    <table class="table table-light table-striped">
                        <thead>
                            <tr>
                                <th scope="col"> Baia </th>
                                <th scope="col"> Produto Utilizado </th>
                                <th scope="col"> Quantidade </th>
                                <th scope="col"> Data </th>
                                <th scope="col"> Quem Utilizou </th>
                            </tr>
                        </thead>
                        <?php
                            $historico = mysqli_query($conexao, "SELECT * FROM historico_itens_baia");
                            while($hib = mysqli_fetch_array($historico))
                            {
                                $idp = $hib['id_item'];
                                $idb = $hib['id_baia'];
                                $idu = $hib['id_usuario'];
                                $sql = "SELECT * FROM baia WHERE id = '$idb'";
                                $rs = mysqli_query($conexao, $sql);
                                $ba = mysqli_fetch_array($rs);
                                $sql = "SELECT * FROM item WHERE id = '$idp'";
                                $rs = mysqli_query($conexao, $sql);
                                $it = mysqli_fetch_array($rs);
                                $sql = "SELECT * FROM usuario WHERE id = '$idu'";
                                $rs = mysqli_query($conexao, $sql);
                                $us = mysqli_fetch_array($rs);
                        ?>
                        <tbody>
                            <tr>
                                <td rowspan="2"><?php echo $ba['identificacao']; ?></td>
                                <td><?php echo $it['nome']; ?></td>
                                <td><?php echo $hib['qtde']; ?></td>
                                <td><?php echo $hib['data_hora']; ?></td>
                                <td><?php echo $us['nome']; ?></td>
                            </tr>
                        </tbody>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>

<?php
    mysqli_close($conexao);
    unset($conexao);
?>