<?php 
// ESTO DEBE IR AL INICIO, ANTES DE CUALQUIER HTML
session_start();
$_SESSION['current_page'] = 'servicios';
include "head.php";
$idage = $_GET['id'] ?? null;

/* if(isset($_POST['btnanular'])){
    mysqli_query($connection, "UPDATE INTO agenda set est = 'C' WHERE id = '$id'");
} */
if(isset($_POST['btneditaroferta'])){
    //$cupon = $_POST['cupon'] ?? null; 
    $dscto = $_POST['dscto'] ?? null; 
    $fechalim = $_POST['fechalim'] ?? null; 
    $horalim = $_POST['horalim'] ?? null; 
    $user = $_SESSION['nomcli'] ?? 'system'; // Usuario de sesión

    mysqli_query($connection, "UPDATE a_servicios SET 
        dscto = '$dscto',
        fecha_oferta_limite = '$fechalim',
        hora_oferta_limite = '$horalim',
        usuariomod = '$user'        
     WHERE id = '$idage'");    
}
if(isset($_POST['btneditar'])){
    $titulo = $_POST['titulo'] ?? null; // es el campo de evento
    $slug = strtolower($titulo);
    $link = preg_replace('/[^a-z0-9]+/', '-', $slug);
    $descripcion = $_POST['descripcion'] ?? null;
    $precio = $_POST['precio'] ?? NULL;
    $moneda = $_POST['moneda'] ?? NULL;
    $obs = $_POST['obs'] ?? NULL;
    $servobt = mysqli_fetch_array(mysqli_query($connection, "SELECT * FROM a_servicios WHERE id = '$idage'"));
    $foto = $_POST['imagenitem'] ?? $servobt['img']; // Mantener la imagen actual si no se sube una nueva
    $upload_dir = "items/";

    $user = $_SESSION['nomcli'] ?? 'system'; // Usuario de sesión

    if(isset($_FILES['imagenitem']) && $_FILES['imagenitem']['error'] === UPLOAD_ERR_OK) {
        $logo_file = $_FILES['imagenitem'];
        //$logo_name = basename($logo_file['name']);
        $logo_tmp = $logo_file['tmp_name'];
        $extension = pathinfo($logo_file['name'], PATHINFO_EXTENSION);
        $nuevo_nombre = $link . '.' . $extension;
        $logo_path = $upload_dir . $nuevo_nombre;
        
        if(move_uploaded_file($logo_tmp, $logo_path)) {
            // Eliminar la imagen anterior si existe y si es diferente a la nueva
            if(!empty($imagen_actual) && $logo_name != $imagen_actual && file_exists($upload_dir . $imagen_actual)) {
                unlink($upload_dir . $imagen_actual);
            }
            $foto = $nuevo_nombre;
        }
    }

    $nuevoorga = isset($_POST['nuevoorga']) ? "promotor = '$orga'," : '';    
    mysqli_query($connection, "UPDATE a_servicios SET 
        img = '$foto',
        titulo = '$titulo',
        descripcion = '$descripcion',
        precio = '$precio',
        moneda = '$moneda',
        usuariomod = '$user',
        link = '$link',
        obs = '$obs'
     WHERE id = '$idage'");    
}

function formatear12($hora) {
    return date("g:i A", strtotime($hora));
}
if (isset($_POST['btnEliminarArchivo'])) {

    $id = intval($_POST['idproductoarchivo']);

    // 1. Obtener la ruta del archivo
    $query = mysqli_query($connection, "SELECT url FROM a_producto_archivos WHERE id = $id");
    $row = mysqli_fetch_assoc($query);

    if ($row) {
        $rutaArchivo = $row['url'];
        // 2. Eliminar archivo físico si existe
        if (file_exists("uploads/productos/$rutaArchivo")) {
            unlink("uploads/productos/$rutaArchivo");
        }

        // 3. Eliminar registro de la base de datos
        mysqli_query($connection, "DELETE FROM a_producto_archivos WHERE id = $id");
    }
}

?>
<link rel="stylesheet" href="blite.css">
<style>
    #progressBar {
    transition: width 0.3s ease;
}
    .contenedor-general{box-shadow: 2px 6px 15px 0px rgba(69, 65, 78, 0.1);background-color: white; padding: 20px; border-radius: 8px;}
    .main-content{margin-top: 72px;}.row div{margin-bottom: 15px;}
    @media (max-width: 768px) {body{background-color: #ffffffff;} .contenedor-general{box-shadow: none !important;padding:0px;border-radius: 0px;} .row div{margin-bottom: 0px;}}
    @media (max-width: 768px) {.valor-tabla{font-size: x-small;}} .table thead th{ background-color: transparent; }
    #formTipo {
        margin-bottom: 20px;
        }
        
        .radio-group {
            display: flex;
            gap: 0;
            border-bottom: 2px solid #dee2e6;
            /* margin-bottom: 20px; */
        }
        
        .radio-option {
            flex: 1;
            text-align: center;
            padding: 12px 20px;
            cursor: pointer;
            background-color: #f9f9f9;
            /* border: 1px solid #dee2e6; */
            border-bottom: none;
            border-radius: 8px 8px 0 0;
            margin: 0;
            transition: all 0.3s ease;
            font-weight: 500;
            color: #6c757d;
            position: relative;
            bottom: -2px;
        }
        
        .radio-option:hover {
            background-color: #e9ecef;
        }
        
        .radio-option input[type="radio"] {
            display: none;
        }
        
        .radio-option input[type="radio"]:checked + span,
        .radio-option:has(input[type="radio"]:checked) {
            background-color: white;
            color: #007bff;
            font-weight: 600;
            border-bottom: 3px solid #007bff;
        }
        
        /* Responsive para tabs */
        @media (max-width: 768px) {
            .radio-group {
                flex-direction: row;
                gap: 5px;
                flex-wrap: wrap;
            }
            
            .radio-option {
                padding: 10px 15px;
                font-size: 0.9em;
            }
        }
</style>
<div class="container-fluid">
    
    <div class="contenedor-general" >                 
        <div class="row " style="margin: 0;">
            <div style="display: flex; justify-content: space-between;padding-bottom: 15px;">
                <h5 style="margin-bottom: 20px;position: relative;top: 10px;">Recaudado</h5>
                <div>
                    <a  href="nuevo_servicio.php" class="btn btn-primary">Nuevo</a>
                    <button type="button" class="btn btn-primary" onclick="window.location.href='utils/exportar_inventario.php'">Excel</button>

                </div>
            </div>
        </div>
        <div class="row " style="margin: 0;">
            <div class="table-responsive">                
                <table class="table" id="tbdoytipousuarios">
                    <thead >
                        <tr style="background-color: transparent;"> 
                            <th>Cliente</th>                           
                            <th>Concepto</th>                            
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Monto</th>
                            <th>Pago</th>
                            <th>Fecha</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="tbodyitems">
                        <?php 
                        $query = "SELECT * FROM a_panel_movimientos where referencia = '$idage' and tipo = 'ingreso' order by id desc";
                        $result = mysqli_query($connection, $query);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                if(explode(":", $row['cliente'])[0] == "cliente"){
                                    echo "<td> <a href='cliente.php?id=" . explode(":", $row['cliente'])[2] . "'>" . explode(":", $row['cliente'])[1] . "</a></td>";
                                } else {
                                    echo "<td>" . $row['cliente'] . "</td>";
                                }
                                echo "<td>" . $row['concepto'] . "</td>";
                                echo "<td>" . $row['cantidad'] . "</td>";
                                echo "<td>" . $row['precio'] . "</td>";
                                echo "<td>" . $row['monto'] . "</td>";                                
                                echo "<td>" . $row['modo'] . " - " . $row['metodopago'] . "</td>";                                
                                echo "<td>" . $row['fecha'] . "</td>";                                
                                echo "<td> <a class='btn btn-info' href='movimiento_detalle.php?id=" . $row['id'] . "'><i class='bi bi-info'></i></a></td>";                                                                
                            }
                        } else {
                            echo "<tr><td colspan='7'>No se encontraron resultados.</td></tr>";
                        }

                        mysqli_close($connection);
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>