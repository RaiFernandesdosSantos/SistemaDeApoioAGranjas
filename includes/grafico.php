<?php
    $soma = array();
    $sum = array();
    $ano = date('Y');
    for($i = 0; $i <= 11; $i++)
    {
        $mes = $i + 1;
        $soma[$i] = mysqli_query($conexao, "SELECT SUM(media_peso) FROM historico_baia WHERE 
        EXTRACT(month from data_hora) = '$mes' AND EXTRACT(year from data_hora) = '$ano'");
        $rs[$i] = mysqli_fetch_row($soma[$i]);
        if(empty($rs[$i][0])):
            $rs[$i][0] = 0;
        endif;
        $sum[$i] = mysqli_query($conexao, "SELECT SUM(qtde_porcos) FROM historico_baia WHERE 
        EXTRACT(month from data_hora) = '$mes' AND EXTRACT(year from data_hora) = '$ano'");
        $res[$i] = mysqli_fetch_row($sum[$i]);
        if(empty($res[$i][0])):
            $res[$i][0] = 0;
        endif;
    }
?>


<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.2.0/chart.js"></script>
<div class="offset-md-2 offset-lg-2 col-md-10 col-lg-10 bg-light">
    <canvas id="grafico"></canvas>
    <script>
        const labels = 
        [
            'Janeiro',
            'Fevereiro',
            'Março',
            'Abril',
            'Maio',
            'Junho',
            'Julho',
            'Agosto',
            'Setembro',
            'Outubro',
            'Novembro',
            'Dezembro',
        ];
        const data = 
        {
            labels: labels,
            datasets:  
            [
                {
                    label: 'Total da Media de Pesos da Granja',
                    backgroundColor: 'rgb(255, 255, 0)',
                    borderColor: 'rgb(255, 255, 0)',
                    data: [<?php echo $rs[0][0]; ?>, <?php echo $rs[1][0]; ?>, <?php echo $rs[2][0]; ?>, <?php echo $rs[3][0]; ?>, 
                    <?php echo $rs[4][0]; ?>, <?php echo $rs[5][0]; ?>, <?php echo $rs[6][0]; ?>, <?php echo $rs[7][0]; ?>, 
                    <?php echo $rs[8][0]; ?>, <?php echo $rs[9][0]; ?>, <?php echo $rs[10][0]; ?>,  <?php echo $rs[11][0]; ?>],
                },
                {
                    label: 'Total de Porcos',
                    backgroundColor: 'rgb(0, 191, 255)',
                    borderColor: 'rgb(0, 191, 255)',
                    data: [<?php echo $res[0][0]; ?>, <?php echo $res[1][0]; ?>, <?php echo $res[2][0]; ?>, <?php echo $res[3][0]; ?>, 
                    <?php echo $res[4][0]; ?>, <?php echo $res[5][0]; ?>, <?php echo $res[6][0]; ?>, <?php echo $res[7][0]; ?>, 
                    <?php echo $res[8][0]; ?>, <?php echo $res[9][0]; ?>, <?php echo $res[10][0]; ?>, <?php echo $res[11][0]; ?>],
                }
            ]
        };
        const config = 
        {
            type: 'line',
            data,
            options: {}
        };
        var myChart = new Chart(
            document.getElementById('grafico'),
            config
        );
    </script>
</div>