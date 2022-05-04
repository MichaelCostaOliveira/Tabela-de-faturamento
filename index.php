<?php
$quantidadeMeses = isset($_POST['quantidadeMeses'])? (int) $_POST['quantidadeMeses']:0;
$numeroNovoContratosPorMes = isset($_POST['numeroNovoContratosPorMes'])? (int)$_POST['numeroNovoContratosPorMes']:0;
$valorDeCadaContrato = isset($_POST['valorDeCadaContrato'])? (float)$_POST['valorDeCadaContrato'] : 0;
echo "<form method='post'>";
echo "<label>Quantidade de mês para simular: </label>";
echo "<input type='text' name='quantidadeMeses' value='{$quantidadeMeses}'/><br>";
echo "<label>Número de novos contratos: </label>";
echo "<input type='text' name='numeroNovoContratosPorMes' value='{$numeroNovoContratosPorMes}'/><br>";
echo "<label>Valor de cada contrato: </label>";
echo "<input type='number' name='valorDeCadaContrato' value='{$valorDeCadaContrato}'/><br>";
echo "<button type='submit'>Mostrar resultado</button>";
echo "</form>";
if(!isset($_POST['quantidadeMeses'])){
    exit;
}
if(!$quantidadeMeses){
    exit("Informe a quantidade de meses para simular");
}
$transacoes = [];
$dataInicio = $mesAtual = date('Y-01-01');

while ($mesAtual <= date('Y-m-d', strtotime("+" . ($quantidadeMeses - 1) . "months", strtotime($dataInicio)))) {
    for ($cliente = 1; $cliente <= $numeroNovoContratosPorMes; $cliente++) {
        $transacoes[] = [
            'data' => $mesAtual,
            'cliente' => 'cliente-' . date('MY', strtotime($mesAtual)) . '-' . $cliente,
            'valor' => $valorDeCadaContrato
        ];
    }
    $mesAtual = date('Y-m-d', strtotime("+1months", strtotime($mesAtual)));
}
//Escreva seu código aqui, sem alterar o código acima
echo "<h3><strong>Dados de Entrada</strong></h3>";
echo "<strong>Quantidade de mês para simular: </strong> $quantidadeMeses<br>";
echo "<strong>Números de novos contratos por mês: </strong> $numeroNovoContratosPorMes<br>";
echo "<strong>Valor de cada Contrato: </strong>" . number_format($valorDeCadaContrato, 2, ',', '.') . '</br></br>';
echo "<strong> SAIDA: VISÃO GERAL DE CRESCIMENTO</strong></br></br>";
function formatArray($colunas){
    $array=[];
    $array_total=[];
    $limite = 0;
    for ($i=1; $i<=$colunas; $i++){
        if ($limite < 6){
            $array[$i]=$i;
            $limite++;
        }else{
            $limite = 1;
            $array_total[]=$array;
            $array=[];
            $array[$i]=$i;
        }

        if ($i == $colunas){

            $array_total[]=$array;
        }
    }
    return $array_total;
}

foreach (formatArray($quantidadeMeses) as $key=>$array){
    echo
    ' <table border="1">
        <thead>
            <tr>
                <td><strong>Meses</strong></td>';
                foreach ($array as $keyMes=>$ar){
                    echo '<td><strong>'.$keyMes.'° Mês</strong> </td>';
                }
    echo
            '</tr>
        </thead>
        <tbody>';
        for ($i=0; $i< array_key_last($array); $i++){
            echo
                '<tr>
                    <td></td>';
                foreach ($array as $key2=>$ar){
                    if ($i >= $ar ){
                        echo
                        '<td></td>';
                    }else{
                        echo
                        '<td>'.$numeroNovoContratosPorMes.'</td>';
                    }
                }
            echo
                '<tr>';
        }
    echo
        '</tbody>
         <tfoot style="color: green">
             <tr>
                <td>VALOR TOTAL ADESÕES NO MÊS</td>';
                foreach ($array as $key2=>$ar){
                    echo'<td>'.'R$ '.number_format($numeroNovoContratosPorMes*$valorDeCadaContrato, 2, ',', '.').'</td>';
                }
             echo '
            </tr>
            <tr>
                <td>VALOR TOTAL ADESÕES ACUMULADO</td>';
                    foreach ($array as $key2=>$ar){
                        echo'<td>'.'R$ '.number_format($ar*($numeroNovoContratosPorMes*$valorDeCadaContrato), 2, ',', '.').'</td>';
                    }
             echo '
             </tr>
        </tfoot>
    </table>
    <br>';
}

?>
