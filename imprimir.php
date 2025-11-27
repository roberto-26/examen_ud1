<?php
include "datos.php";
global $conceptos;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tienda de Informática</title>
    <style>
        table {
            text-align: center;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
        }

    </style>
</head>
<body>
<h1>Productos en venta</h1>
<table border="1">
    <tr>
        <th></th>
        <th>Uds.</th>
        <th>Referencia</th>
        <th>Concepto</th>
        <th>Precio ud.</th>
        <th>Subtotal</th>
    </tr>
    <?php
    $suma_subtotal = 0;
    $unidades = 0;
    $contadorID = 0;
    $descuento = 0;
    foreach ($conceptos as $concepto) {
        echo "<tr>";
        echo "<td>" . ++$contadorID . "</td>";
        echo "<td>" . $concepto['unidades'] . "</td>";
        echo "<td>" . $concepto['referencia'] . "</td>";
        echo "<td>" . $concepto['concepto'] . "</td>";
        echo "<td>" . number_format($concepto['precio_unidad'], 2) . " € </td>";
        echo "<td>" . number_format($concepto['precio_unidad']*$concepto['unidades'], 2) . " € </td>";
        echo "</tr>";
        $suma_subtotal += $concepto['precio_unidad']*$concepto['unidades'];
        $unidades += $concepto['unidades'];
    }

    if ($suma_subtotal >= 2000 and $suma_subtotal < 3000) {
        $descuento = 0.10;
    }
    else if ($suma_subtotal >= 3000) {
        $descuento = 0.20;
    }

    echo "<tr>";
    echo "<td></td>";
    echo "<td>" . $unidades . "</td>";
    echo "<td colspan='3' style='text-align: right;'> Bruto: </td>";
    echo "<td>" . $suma_subtotal . " €</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td colspan='5' style='text-align: right;'> Descuento (" . $descuento*100 . " %):</td>";
    echo "<td>-" . number_format($suma_subtotal*$descuento,2) . " €</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td colspan='5' style='text-align: right;'> IVA:</td>";
    echo "<td>" . number_format(($suma_subtotal-$suma_subtotal*$descuento)*0.21,2) . " €</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td colspan='5' style='text-align: right;'>Neto:</td>";
    $totalSinDescuento = $suma_subtotal-$suma_subtotal*$descuento;
    echo "<td>" . number_format($totalSinDescuento+($totalSinDescuento*0.21),2) . " €</td>";
    echo "</tr>";

    ?>

</table>

</body>
</html>
