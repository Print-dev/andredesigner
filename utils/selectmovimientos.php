<?php include '../cn.php';
$tipo = $_POST['tipo'] ?? null;
$servicio = $_POST['servicio'] ?? '';
$where = "WHERE 1=1";
if (!empty($tipo)) {
    $where .= " AND tipo = '$tipo'";
}
if (!empty($servicio)) {
    $where .= " AND unidad_negocio_id = '$servicio'";
}
if($tipo != "empresa" && $tipo != "promotor" && $tipo != "artista") { 
?>
<thead>
    <tr>
        <th>Concepto</th>                            
        <th>Monto</th>
        <th>Pago</th>
        <th>Fecha</th>
        <th></th>
    </tr>
</thead>
<tbody>                                           
<?php 
    $query = "SELECT * FROM a_panel_movimientos $where order by id desc";
    $result = mysqli_query($connection, $query);

    // Verificar si hay resultados
    if (mysqli_num_rows($result) > 0) {
        // Recorrer los resultados y mostrarlos en la tabla
        while ($row = mysqli_fetch_assoc($result)) {
            //echo "<tr ".($row['estado'] == 'Retirado' || $row['estado'] == 'Suspendido' || $row['estado'] == 'Despedido').">";
            echo "<tr>";
            echo "<td>" . ($row['concepto'] ?? null) . "</td>";
            echo "<td>" . ($row['monto'] ?? null) . "</td>";
            echo "<td>" . ($row['modo'] ?? null) . " - " . ($row['metodopago'] ?? null) . "</td>";
            echo "<td>" . ($row['fecha'] ?? null) . "</td>";
            //echo "<td><a href='usuario_editar.php?id=" . $row['cod'] . "&tipo=1' class='btn btn-sm btn-warning'>Editar</a></td>";
            echo "<td class='acciones-columna' >
                    <div class='menu-acciones'>
                        <button class='btn-menu' onclick='toggleMenu({$row['id']})'>&#8942;</button>
                        <div class='menu-opciones' id='menu-{$row['id']}'>                            
                            <form action=''><a class='btneditar-acc'  href='movimiento_editar.php?id=" . $row['id'] . "&tipo=1'>Editar</a></form>
                            <form action=''><a class='btneditar-acc' href='movimiento_detalle.php?id=$row[id]'>Detalles</a></form>
                            <form method='post'>
                                <input type='hidden' name='idevento' value='$row[id]'>
                                <button type='submit' class='btneditar-acc btn btn-danger' name='btnborrar' style='background:transparent;border:none;'>Borrar</button>
                            </form>                            
                        </div>
                    </div>
                </td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No se encontraron resultados.</td></tr>";
    }

    // Cerrar la conexión
    mysqli_close($connection);
}
?> 
</tbody>