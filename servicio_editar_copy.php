<?php 
session_start();
$_SESSION['current_page'] = 'servicios'; 
include "head.php"; 

// Verificar si se ha proporcionado un ID para editar
if(!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('ID no proporcionado'); window.location='inventario.php';</script>";
    exit();
}

$id = $_GET['id'];

// Obtener los datos actuales del registro
$query = mysqli_query($connection, "SELECT * FROM a_servicios WHERE id = '$id'");
if(mysqli_num_rows($query) == 0) {
    echo "<script>alert('Registro no encontrado'); window.location='inventario.php';</script>";
    exit();
}

$row = mysqli_fetch_assoc($query);

// Asignar valores a variables
$nserie = $row['nserie'];
$tipo = $row['tipo'];
$cantidad = $row['cantidad'];
$descripcion = $row['descripcion'];
$marca = $row['marca'];
$num_serie_model = $row['num_serie_model'];
$color = $row['color'];
$ubicacion = $row['ubicacion'];
$estado = $row['estado'];
$proveedor = $row['proveedor'];
$forma_adquisicion = $row['forma_adquisicion'];
$fechacompra = $row['fechacompra'];
$preciounidad = $row['preciounidad'];
$valortotal = $row['valortotal'];
$operativo = $row['operativo'];
$chkbox1 = $row['chkbox1'];
$imagen_actual = $row['imag'];
// Procesar actualización
if(isset($_POST['btnactualizaritem'])){
    // Sanitizar los datos para prevenir SQL injection
    $tipo = $_POST['tipo'] ?? null;
    $cantidad = $_POST['cantidad'] ?? null;
    $descripcion = $_POST['descripcion'] ?? null;
    $marca = $_POST['marca'] ?? null;
    $num_serie_model = $_POST['num_serie_model'] ?? null;
    $color = $_POST['color'] ?? null;
    $ubicacion = $_POST['ubicacion'] ?? null;
    $estado = $_POST['estado'] ?? null;
    $proveedor = $_POST['proveedor'] ?? null;
    $forma_adquisicion = $_POST['forma_adquisicion'] ?? null;
    $fechacompra = $_POST['fechacompra'] ?? null;
    $preciounidad = $_POST['preciounidad'] ?? null;
    $valortotal = $_POST['valortotal'] ?? null;
    $operativo = $_POST['operativo'] ?? null;
    $nserie = $row['nserie']; 
    $comentario = $_POST['comentario'] ?? null;

    $chkbox1 = isset($_POST['chkbox1']) ? 1 : 0;
    
    // Variables para los nombres de archivo
    $foto = $imagen_actual; // Mantener la imagen actual por defecto
    
    // Directorio donde se guardarán las imágenes
    $upload_dir = "inventario/";
    
    // Crear el directorio si no existe
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    
    // Procesar nueva imagen si se subió
    if(isset($_FILES['imagenitem']) && $_FILES['imagenitem']['error'] === UPLOAD_ERR_OK) {
        $logo_file = $_FILES['imagenitem'];
        $logo_name = basename($logo_file['name']);
        $logo_tmp = $logo_file['tmp_name'];
        $logo_path = $upload_dir . $logo_name;
        
        if(move_uploaded_file($logo_tmp, $logo_path)) {
            // Eliminar la imagen anterior si existe y si es diferente a la nueva
            if(!empty($imagen_actual) && $logo_name != $imagen_actual && file_exists($upload_dir . $imagen_actual)) {
                unlink($upload_dir . $imagen_actual);
            }
            $foto = $logo_name;
        }
    }
    
    // Opción para eliminar imagen existente
    if(isset($_POST['eliminar_imagen']) && $_POST['eliminar_imagen'] == '1') {
        if(!empty($imagen_actual) && file_exists($upload_dir . $imagen_actual)) {
            unlink($upload_dir . $imagen_actual);
        }
        $foto = '';
    }
    
    // Actualizar en la base de datos
    $query_update = "UPDATE vega_inventario SET 
        nserie = '$nserie',
        tipo = '$tipo',
        cantidad = '$cantidad',
        descripcion = '$descripcion',
        marca = '$marca',
        num_serie_model = '$num_serie_model',
        color = '$color',
        ubicacion = '$ubicacion',
        estado = '$estado',
        proveedor = '$proveedor',
        forma_adquisicion = '$forma_adquisicion',
        fechacompra = '$fechacompra',
        preciounidad = '$preciounidad',
        valortotal = '$valortotal',
        operativo = '$operativo',
        chkbox1 = '$chkbox1',
        imag = '$foto',
        obs = '$comentario'
    WHERE id = '$id'";
    
    if(mysqli_query($connection, $query_update)) {
        echo "<script>
            window.location='inventario.php';
        </script>";
    } else {
        echo "<script>
            alert('Error al actualizar: " . mysqli_error($connection) . "');
        </script>";
    }
}

// También puedes agregar una función para eliminar
if(isset($_POST['btneliminaritem'])) {
    // Eliminar la imagen asociada si existe
    if(!empty($imagen_actual) && file_exists($upload_dir . $imagen_actual)) {
        unlink($upload_dir . $imagen_actual);
    }
    
    // Eliminar de la base de datos
    mysqli_query($connection, "DELETE FROM vega_inventario WHERE id = '$id'");
    
    echo "<script>
        window.location='inventario.php';
    </script>";
}
?>
<link rel="stylesheet" href="blite.css">
<style>
    .contenedor-general{box-shadow: 2px 6px 15px 0px rgba(69, 65, 78, 0.1);background-color: white; padding: 20px; border-radius: 8px; margin-top: 20px;}
    .main-content{margin-top: 72px;}.row div{margin-bottom: 15px;}
    @media (max-width: 768px) {body{background-color: #ffffffff;} .contenedor-general{box-shadow: none !important;padding:0px;border-radius: 0px;} .row div{margin-bottom: 0px;}}
    .imagen-actual {max-width: 200px; max-height: 200px; margin-top: 10px; border: 1px solid #ddd; padding: 5px;}
    .btn-eliminar {background-color: #dc3545; border-color: #dc3545; margin-left: 10px;}
    .btn-eliminar:hover {background-color: #c82333; border-color: #bd2130;}
</style>
<div class="container-fluid" >
    <div class="contenedor-general" >        
        <div class="row" style="margin: 0px;">
            <div style="display: flex; flex-direction: column; justify-content: center; align-items: center; border-bottom: 1px solid #ebebeb;">
                <h5 style="margin-bottom: 20px;">Editar Item [<?php echo $nserie; ?>]</h5>                
            </div>
            <form method="post" enctype="multipart/form-data">
                <div id="datos-cargardos-usuario">
                    <div class="row" style="margin: 0px;">                                
                        <div class="col-3">
                            <strong class="labels-input" >Número de Serie</strong>
                            <input type="text" value="<?php echo htmlspecialchars($nserie); ?>" class="mb-1" name="nserie" style="background-color: #f8f9fa;">
                        </div>
                        <div class="col-3">
                            <strong class="labels-input" >Tipo</strong>
                            <select name="tipo" id="tipo" class="mb-1">
                                <option value="dispositivo" <?php echo ($tipo == 'dispositivo') ? 'selected' : ''; ?>>Dispositivo</option>
                                <option value="mueble" <?php echo ($tipo == 'mueble') ? 'selected' : ''; ?>>Mueble</option>
                                <option value="documento" <?php echo ($tipo == 'documento') ? 'selected' : ''; ?>>Documento</option>
                                <option value="electronico" <?php echo ($tipo == 'electronico') ? 'selected' : ''; ?>>Electronico</option>
                                <option value="accesorio" <?php echo ($tipo == 'accesorio') ? 'selected' : ''; ?>>Accesorio</option>
                            </select>                            
                        </div>
                        <div class="col-3">
                            <strong class="labels-input" >Cantidad</strong>
                            <input type="text" name="cantidad" id="cantidad" onchange="calculartotal()" class="mb-1" value="<?php echo htmlspecialchars($cantidad); ?>">
                        </div> 
                        <div class="col-3">
                            <strong class="labels-input" >Descripción</strong>
                            <input type="text" name="descripcion" id="descripcion" class="mb-1" value="<?php echo htmlspecialchars($descripcion); ?>">
                        </div>
                        <div class="col-3">
                            <strong class="labels-input" >Marca</strong>
                            <input type="text" name="marca" id="marca" class="mb-1" value="<?php echo htmlspecialchars($marca); ?>">
                        </div>
                        <div class="col-3">
                            <strong class="labels-input" >Num. Serie/Model</strong>
                            <input type="text" name="num_serie_model" id="num_serie_model" class="mb-1" value="<?php echo htmlspecialchars($num_serie_model); ?>">
                        </div>
                        <div class="col-3">
                            <strong class="labels-input" >Color</strong>
                            <input type="text" name="color" id="color" class="mb-1" value="<?php echo htmlspecialchars($color); ?>">
                        </div>
                        <div class="col-3">
                            <strong class="labels-input" >Ubicación</strong>
                            <input type="text" name="ubicacion" id="ubicacion" class="mb-1" value="<?php echo htmlspecialchars($ubicacion); ?>">
                        </div>  
                        <div class="col-3">
                            <strong class="labels-input" >Estado</strong>
                            <select name="estado" id="estado" class="mb-1">
                                <option value="nuevo" <?php echo ($estado == 'nuevo') ? 'selected' : ''; ?>>Nuevo</option>
                                <option value="usado" <?php echo ($estado == 'usado') ? 'selected' : ''; ?>>Usado</option>
                                <option value="reparacion" <?php echo ($estado == 'reparacion') ? 'selected' : ''; ?>>En Reparación</option>
                            </select>
                        </div>
                        <div class="col-3">
                            <strong class="labels-input" >Proveedor</strong>
                            <input type="text" name="proveedor" id="proveedor" class="mb-1" value="<?php echo htmlspecialchars($proveedor); ?>">
                        </div>
                        <div class="col-3">
                            <strong class="labels-input" >Fm.Adquisición</strong>
                            <input type="text" name="forma_adquisicion" id="forma_adquisicion" class="mb-1" value="<?php echo htmlspecialchars($forma_adquisicion); ?>">
                        </div>
                        <div class="col-3">
                            <strong class="labels-input" >Fecha de Compra</strong>
                            <input type="date" name="fechacompra" id="fechacompra" class="mb-1" value="<?php echo htmlspecialchars($fechacompra); ?>">
                        </div>
                        <div class="col-3">
                            <strong class="labels-input" >Precio Unidad</strong>
                            <input type="text" name="preciounidad" onchange="calculartotal()" id="preciounidad" class="mb-1" value="<?php echo ($preciounidad); ?>">
                        </div>
                        <div class="col-3">
                            <strong class="labels-input" >Valor Total</strong>
                            <input type="text" name="valortotal" id="valortotal" class="mb-1" value="<?php echo ($valortotal); ?>">
                        </div>
                        <div class="col-3">
                            <strong class="labels-input" >Operativo</strong>
                            <select name="operativo" id="operativo" class="mb-1">
                                <option value="operativo" <?php echo ($operativo == 'operativo') ? 'selected' : ''; ?>>Operativo</option>
                                <option value="desgastado" <?php echo ($operativo == 'desgastado') ? 'selected' : ''; ?>>Desgastado</option>
                                <option value="malogrado" <?php echo ($operativo == 'malogrado') ? 'selected' : ''; ?>>Malogrado</option>
                                <option value="mantenimiento" <?php echo ($operativo == 'mantenimiento') ? 'selected' : ''; ?>>Mantenimiento</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <strong class="labels-input" >Imagen Actual</strong><br>
                            <?php if(!empty($imagen_actual)): ?>
                                <img src="inventario/<?php echo htmlspecialchars($imagen_actual); ?>" alt="Imagen actual" class="imagen-actual">
                                <br>
                                <label>
                                    <input type="checkbox" name="eliminar_imagen" value="1"> Eliminar imagen actual
                                </label>
                            <?php else: ?>
                                <p>No hay imagen cargada</p>
                            <?php endif; ?>
                        </div>
                        <div class="col-3">
                            <strong class="labels-input" >Nueva Imagen</strong>
                            <input type="file" name="imagenitem" id="imagenitem" class="mb-1">
                        </div>                                                                 
                        <div class="col-12">                            
                            <strong class="labels-input" >Habido</strong>
                            <input type="checkbox" name="chkbox1" id="chkbox1" class="mb-1" <?php echo ($chkbox1 == 1) ? 'checked' : ''; ?>>
                        </div>
                    </div>    
                </div>        
                <div class="row" style="margin:0px">
                    <div class="col-12">
                        <strong class="labels-input" >Observaciones</strong>
                        <textarea name="comentario" id="comentario" class="mb-1" style="width: 100%; height: 100px;"><?php echo htmlspecialchars($row['obs']); ?></textarea>
                    </div>
                </div>
                <div class="row" style="margin: 0px;">        
                    <div class="container" style="display: flex; justify-content: center; margin-top: 20px;border-top: 1px solid #ebebeb; padding-top: 15px;">
                        <button class="btn btn-primary" type="submit" name="btnactualizaritem">Actualizar</button>
                        <button class="btn btn-eliminar" type="submit" name="btneliminaritem" onclick="return confirm('¿Está seguro que desea eliminar este registro?')">Eliminar</button>
                        <a href="inventario.php" class="btn btn-secondary" style="margin-left: 10px;">Cancelar</a>
                    </div>
                </div>  
                <script>
                    function calculartotal(){
                        var cantidad = document.getElementById('cantidad').value;
                        var preciounidad = document.getElementById('preciounidad').value;
                        var valortotal = parseFloat(cantidad) * parseFloat(preciounidad);
                        document.getElementById('valortotal').value = valortotal;
                    }
                    window.onload = function() {
                        calculartotal();
                    };
                    
                </script>
            </form>         
        </div>    
    </div>
</div>
<?php include 'footer.php'; ?>