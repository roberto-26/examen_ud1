<?php

session_name('ud1_25');
session_start();

if(isset($_POST['limpiar'])){
    session_destroy();

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

if(!isset($_SESSION["numero_version"])){
    $_SESSION["numero_version"] = 1;
} else {
    $version = $_SESSION["numero_version"];
    $version++;
    $_SESSION["numero_version"] = $version;
}

if (!isset($_SESSION['albaran'])){
    $_SESSION['albaran'] = [];
} else{
    $albaran = $_SESSION['albaran'];
}

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
<?php
echo "<h1>Albarán. Versión: " . $version . "</h1>";
if (isset($_SESSION['mensaje_error'])) {
    echo("<h2 style='color: red'>" . $_SESSION['mensaje_error'] . "</h2>");
    unset($_SESSION['mensaje_error']);
}
?>

<table border="1">
    <tr>
        <th></th>
        <th>Uds.</th>
        <th>Referencia</th>
        <th>Concepto</th>
        <th>Precio ud.</th>
        <th>Subtotal</th>
        <th></th>
    </tr>
    <?php
    $suma_subtotal = 0;
    $unidades = 0;
    $contadorID = 0;
    $descuento = 0;
    foreach ($albaran as $concepto) {
        echo "<tr>";
        echo "<td>" . ++$contadorID . "</td>";
        //Botones sumar y restar
        echo ("<form method='post'>
                <td> <button type='submit' name='sumar' value=".$concepto['referencia'].">+</button>" . $concepto['unidades'] . "
                <button type='submit' name='restar' value=".$concepto['referencia'].">-</button> </td>
                </form>");
        echo "<td>" . $concepto['referencia'] . "</td>";
        echo "<td>" . $concepto['concepto'] . "</td>";
        echo "<td>" . number_format($concepto['precio_unidad'], 2) . " € </td>";
        echo "<td>" . number_format($concepto['precio_unidad']*$concepto['unidades'], 2) . " € </td>";
        echo("<form method='post'>
                <td><button type='submit' name='eliminar' value=" . $concepto['referencia'] .">Eliminar</button>
               </form>");
        echo "</tr>";
        $suma_subtotal += $concepto['precio_unidad']*$concepto['unidades'];
        $unidades += $concepto['unidades'];
    }

    //Calcular descuento
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

<br>

<form method="post">
    Referencia: <input type="text" name="referencia" minlength="1">
    Concepto: <input type="text" name="concepto" minlength="1">
    <br><br>

    Unidades: <input type="number" name="unidades">
    Precio unidad: <input type="number" name="p_unidad">
    <br><br>

    <input type="hidden" name="crear" value="crear">
    <input type="submit" value="Nuevo Concepto">
</form>

<form method="post">
    <input type="hidden" name="limpiar" value="limpiar">
    <input type="submit" value="Limpiar Albarán (eliminar todo)">
</form>

</body>
</html>
