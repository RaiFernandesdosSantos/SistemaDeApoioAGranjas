<?php
    include '../../controladores/autenticacao_usuario.php';
    require_once '../../controladores/verificar_cargo.php';

    //Armazenagem das datas selecionadas para comparação

    $inicial = mysqli_escape_string($conexao, $_POST['inicial']);
    $final = mysqli_escape_string($conexao, $_POST['final']);
    $begin = mysqli_escape_string($conexao, $_POST['inicialp']);
    $end = mysqli_escape_string($conexao, $_POST['finalp']);
    
    //
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

            <!-- Barra de Navegação superior -->

            <nav class="navbar navbar-expand-md navbar-dark bg-primary fixed-top"> 
                <div class="collapse navbar-collapse">
                    <div class="my-2 my-lg-0">
                        <a href="../geral/pagina_restrita_gerente.php" class="btn btn-outline-warning noprint"> Voltar </a>
                        <button class="btn btn-outline-success noprint" onclick="print()"> Imprimir </button>
                    </div>
                </div>
            </nav>

            <!-- -->

            <div class="row">
                <div class=" offset-md-1 offset-lg-1 col-md-10 col-lg-10 bg-light pre-scrollable">
                    <h3> Periodo Selecionado - <?php echo $inicial; ?> || <?php echo $final; ?></h3>
                    <h3> Priodo de Comparação - <?php echo $begin; ?> || <?php echo $end; ?>
                    <h5> Galpões </h5>

                    <!-- Tabela com o crescimento de porcos e de pesos da granja durante o periodo selecionado -->

                    <table class="table table-light table-striped">
                        <thead>
                            <tr>
                                <th scope="col"> Galpão </th>
                                <th scope="col"> Quantidade de Porcos </th>
                                <th scope="col"> Média Peso </th>
                                <th scope="col"> Variação do Quantitativo de animais nos periodos selecionados </th>
                                <th scope="col"> Variação de Peso nos periodos selecionados (Kg) </th>
                            </tr>
                        </thead>

                        <?php
                            $galpoes = mysqli_query($conexao, "SELECT * FROM galpao");
                            while($gp = mysqli_fetch_array($galpoes))
                            {
                                if(empty($gp)):
                                    $quantidade = 0;
                                    $mediaPeso = 0;
                                    $cresciQtde = 0;
                                    $cresciPeso = 0;
                                    $porcentagemQtde = 0;
                                    $porcetagemPeso = 0;
                                    $identificacaoGalpao = "Galpão Vazio";
                                    continue;
                                else:
                                    $idGalpao = $gp['id'];
                                    $identificacaoGalpao = $gp['identificacao'];
                                    $quantidade = 0;
                                    $mediaPeso = 0;
                                    $qtdeAntiga = 0;
                                    $pesoAntigo = 0;

                                    $baia = mysqli_query($conexao, "SELECT * FROM baia WHERE id_galpao = '$idGalpao'");
                                    while($ba = mysqli_fetch_array($baia))
                                    {
                                        
                                        //Script para recuperar as informações contidas no Banco de dados
                                        if(empty($ba)):
                                            continue;
                                        else:
                                            $idba = $ba['id'];
                                            
                                            $sql = mysqli_query($conexao, "SELECT * FROM historico_baia WHERE data_hora >= '$begin' and 
                                            data_hora <= '$end' AND id_baia = '$idba' AND retirada = 0");
                                            $histoEnt = mysqli_fetch_array($sql);

                                            $sql = mysqli_query($conexao, "SELECT * FROM historico_baia WHERE data_hora >= '$begin' and 
                                            data_hora <= '$end' and id_baia = '$idba' and retirada = 1");
                                            $histoRet = mysqli_fetch_array($sql);

                                            if(empty($histoEnt) && empty($histoRet)):
                                                continue;
                                            elseif(empty($histoEnt)):
                                                continue;
                                            elseif(empty($histoRet)):
                                                $quantidade += $histoEnt['qtde_porcos'];
                                                $mediaPeso += $histoEnt['media_peso'];
                                            else:
                                                $quantidade = $histoEnt['qtde_porcos'] - $histoRet['qtde_porcos'];
                                                $mediaPeso = $histoEnt['media_peso'] - $histoRet['media_peso'];
                                            endif;

                                            $sql = mysqli_query($conexao, "SELECT * FROM historico_baia WHERE data_hora >= '$inicial' and 
                                            data_hora <= '$final' AND id_baia = '$idba' and retirada = 0");
                                            $hsEnt = mysqli_fetch_array($sql);

                                            $sql = mysqli_query($conexao, "SELECT * FROM historico_baia WHERE data_hora >= '$inicial' and 
                                            data_hora <= '$final' AND id_baia = '$idba' and retirada = 1");
                                            $hsRet = mysqli_fetch_array($sql);
                                            
                                            if(empty($hsEnt) && empty($hsRet)):
                                                continue;
                                            elseif(empty($hsEnt)):
                                                continue;
                                            elseif(empty($hsRet)):
                                                $qtdeAntiga += $hsEnt['qtde_porcos'];
                                                $pesoAntigo += $hsEnt['media_peso'];
                                            else:
                                                $qtdeAntiga = $hsEnt['qtde_porcos'] - $hsRet['qtde_porcos'];
                                                $pesoAntigo = $hsEnt['media_peso'] - $hsRet['media_peso'];
                                            endif;
                                        endif;

                                        //
                                    }

                                    //Parte responsavel por tranformar os dados comparados em porcentagem

                                    if($qtdeAntiga == 0):
                                        $qtdeAntiga = 1;
                                    elseif($pesoAntigo == 0):
                                        $pesoAntigo = 1;
                                    endif;

                                    if($quantidade == 0):
                                        $porcentagemQtde = -100;
                                    else:
                                        $porcentagemQtde = ($quantidade * 100) / $qtdeAntiga;
                                    endif;

                                    if($mediaPeso == 0):
                                        $porcetagemPeso = -100;
                                    else:
                                        $porcetagemPeso = ($mediaPeso * 100) / $pesoAntigo;
                                    endif;

                                    $cresciQtde = $quantidade - $qtdeAntiga;
                                    $cresciPeso = $mediaPeso - $pesoAntigo;
                                    
                                    $porcentagemQtde = round($porcentagemQtde, 2);
                                    $porcetagemPeso = round($porcetagemPeso, 2);
                                endif;

                                // ?>

                        <tbody>
                            <tr>
                                <td rowspan="2"><?php echo $identificacaoGalpao; ?></td>
                                <td> Quantidade de Porcos Atual do Galpão: <?php echo $quantidade; ?></td>
                                <td> Peso Atual do Galpão: <?php echo $mediaPeso; ?></td>
                                <td> <?php echo $cresciQtde; ?> (<?php echo $porcentagemQtde; ?>%) </td>
                                <td><?php echo $cresciPeso; ?> (<?php echo $porcetagemPeso; ?>%) </td>
                            </tr>
                        </tbody>
                        <?php } ?>
                    </table>

                    <!-- -->
                    <!-- Tabela com os produtos utilizados nas baias, como vacinas e rações -->

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
                            $historico = mysqli_query($conexao, "SELECT * FROM historico_itens_baia WHERE data_hora >= '$inicial' 
                            and data_hora <= '$final'");
                            while($hib = mysqli_fetch_array($historico))
                            {
                                $idp = $hib['id_item'];
                                $idb = $hib['id_baia'];
                                $idu = $hib['id_usuario'];
                                
                                //Buscando no Banco de Dados o item usado no periodo, a baia em que foi usado e quem usou

                                $sql = "SELECT * FROM baia WHERE id = '$idb'";
                                $rs = mysqli_query($conexao, $sql);
                                $ba = mysqli_fetch_array($rs);

                                $sql = "SELECT * FROM item WHERE id = '$idp'";
                                $rs = mysqli_query($conexao, $sql);
                                $it = mysqli_fetch_array($rs);

                                $sql = "SELECT * FROM usuario WHERE id = '$idu'";
                                $rs = mysqli_query($conexao, $sql);
                                $us = mysqli_fetch_array($rs);

                                // ?>

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

                    <!-- -->

                </div>
            </div>
        </div>
    </body>
</html>

<?php
    mysqli_close($conexao);
    unset($conexao);
?>