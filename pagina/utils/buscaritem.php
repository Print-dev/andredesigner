<?php 
include('../../cn.php');
$item = $_POST['item'] ?? '';
$rowe = mysqli_query($connection, "SELECT id, nserie,chkbox1,cantidad, descripcion,imag,marca FROM vega_inventario WHERE descripcion LIKE '%$item%' or nserie LIKE '%$item%' or marca LIKE '%$item%' order by id desc");
// LLAMADA A LA API DE RENIEC
if (mysqli_num_rows($rowe) > 0) {
        // Recorrer los resultados y mostrarlos en la tabla
        while ($row = mysqli_fetch_assoc($rowe)) {
            echo "<tr>";
            echo "<td><input type='checkbox' ".($row['chkbox1'] == 1 ? 'checked' : '')." onchange='detallescheckboxagenda(\"chkbox1\",this.checked,\"{$row['id']}\")'></td>";
            echo "<td>" . $row['nserie'] . "</td>";
            echo "<td>" . $row['marca'] . "</td>";
            echo "<td>" . $row['descripcion'] . "</td>";
            echo "<td>" . $row['cantidad'] . "</td>";
            echo "<td><a href='inventario/".$row['imag']."' target='_blank'><img src='inventario/".$row['imag']."' width='50' height='50' alt='Imagen'></a></td>";
            echo "<td><a href='inventario_editar.php?id=" . $row['id'] . "' class='btn btn-sm btn-warning'>Editar</a></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No se encontraron usuarios.</td></tr>";
    }
?>
