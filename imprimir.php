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

    
    ?>

</table>

</body>
</html>
