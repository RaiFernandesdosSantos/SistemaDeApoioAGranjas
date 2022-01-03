<?php
    include '../../controladores/autenticacao_usuario.php';
    $final = date("d / m / y");
    $inicial = mktime (0, 0, 0, date("m")-1, date("d"),  date("y"));
    $end = mktime (0, 0, 0, date("m")-1, date("d"),  date("y"));
    $begin = mktime (0, 0, 0, date("m")-2, date("d"),  date("y"));
?>

<div class="row">
    <div class=" offset-md-1 offset-lg-1 col-md-10 col-lg-10 bg-light">
        <table class="table table-light table-striped">
            <thead>
                <tr>
                    <th scope="col"> Galpão </th>
                    <th scope="col"> Quantidade de Porcos </th>
                    <th scope="col"> Média Peso </th>
                    <th scope="col"> Crescimento de porcos no periodo selecionado </th>
                    <th scope="col"> Crescimento de peso no periodo selecionado </th>
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
                        $idba = $ba['id'];
                        $sql = mysqli_query($conexao, "SELECT * FROM historico_baia WHERE data_hora >= '$inicial' and 
                        data_hora <= '$final' AND id_baia = '$idba'");
                        $histo = mysqli_fetch_array($sql);
                        $tq += $histo['qtde_porcos'];
                        $tm += $histo['media_peso'];
                        $sql = mysqli_query($conexao, "SELECT * FROM historico_baia WHERE data_hora >= '$begin' and 
                        data_hora <= '$end' AND id_baia = '$idba'");
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
                    <td> Peso Atual do Galpão: <?php echo $tm; ?></td>
                    <td><?php echo $porq; ?>% (<?php echo $cresq; ?>) </td>
                    <td><?php echo $porm; ?>% (<?php echo $cresm; ?>) </td>
                </tr>
            </tbody>
            <?php } ?>
        </table>
    </div>
</div>

<?php
    mysqli_close($conexao);
    unset($conexao);
?>