<?php 
session_start();
$_SESSION['current_page'] = 'servicios'; 
include "head.php"; 

if(isset($_POST['btnguardaritem'])){
    $fechar = date('Y-m-d H:i:s');
    $titulo = $_POST['titulo'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $tipo = $_POST['tipo'] ?? '';
    $precio = $_POST['precio'] ?? '';
    /* $cupon = $_POST['cupon'] ?? '';
    $dscto = $_POST['dscto'] ?? ''; */
    $moneda = $_POST['moneda'] ?? '';
    /* $estado = $_POST['estado'] ?? 'activo'; */
    //$link = $_POST['link'] ?? '';
    $slug = strtolower($titulo);
    $link = preg_replace('/[^a-z0-9]+/', '-', $slug);
    $obs = $_POST['obs'] ?? ''; // TAGS OPCIONALES
    /* $obs1 = $_POST['obs1'] ?? '';
    $obs2 = $_POST['obs2'] ?? ''; */
    
    // Procesar la imagen
    $foto = '';
    $upload_dir = "items/";
    
    // Crear el directorio si no existe
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    
    // Procesar imagen
    if(isset($_FILES['imagenitem']) && $_FILES['imagenitem']['error'] === UPLOAD_ERR_OK) {
        $logo_file = $_FILES['imagenitem'];
        $logo_tmp = $logo_file['tmp_name'];
        
        // Generar nombre único para la imagen
        $extension = pathinfo($logo_file['name'], PATHINFO_EXTENSION);
        $nuevo_nombre = $link . '.' . $extension;
        $logo_path = $upload_dir . $nuevo_nombre;
        
        if(move_uploaded_file($logo_tmp, $logo_path)) {
            $foto = $nuevo_nombre;
        }
    }
    
    // Escapar variables para prevenir SQL injection
    $titulo = mysqli_real_escape_string($connection, $titulo);
    $descripcion = mysqli_real_escape_string($connection, $descripcion);
    $tipo = mysqli_real_escape_string($connection, $tipo);
    $precio = mysqli_real_escape_string($connection, $precio);
    /* $cupon = mysqli_real_escape_string($connection, $cupon);
    $dscto = mysqli_real_escape_string($connection, $dscto); */
    $estado = mysqli_real_escape_string($connection, $estado);
    $link = mysqli_real_escape_string($connection, $link);
    $obs = mysqli_real_escape_string($connection, $obs);
   /*  $obs1 = mysqli_real_escape_string($connection, $obs1);
    $obs2 = mysqli_real_escape_string($connection, $obs2); */
    $foto = mysqli_real_escape_string($connection, $foto);
/*     die("'$fechar',       
        '$titulo',       
        '$descripcion',       
        '$tipo',       
        '$foto',       
        '$link',       
        '$precio',
        '$cupon',
        '$dscto',
        '$estado',
        '$obs' "); */
    // Query corregida - sin coma extra antes del paréntesis de cierre
    $query = "INSERT INTO a_servicios (
        fechar,
        titulo,
        descripcion,
        tipo,
        img,
        link,
        precio,        
        estado,
        obs,
        moneda
    ) VALUES (
        '$fechar',       
        '$titulo',       
        '$descripcion',       
        '$tipo',       
        '$foto',       
        '$link',       
        '$precio',        
        'desactivado',
        '$obs',
        '$moneda'    )";
    
    if(mysqli_query($connection, $query)) {
        echo "<script>alert('Servicio guardado correctamente'); window.location='servicios.php';</script>";
    } else {
        echo "<script>alert('Error al guardar: " . mysqli_error($connection) . "');</script>";
    }
}
?>

<link rel="stylesheet" href="blite.css">
<style>
    .contenedor-general{box-shadow: 2px 6px 15px 0px rgba(69, 65, 78, 0.1);background-color: white; padding: 20px; border-radius: 8px; margin-top: 20px;}
    .main-content{margin-top: 72px;}.row div{margin-bottom: 15px;}
    .labels-input {display: block; margin-bottom: 5px; font-size: 14px; color: #333;}
    input, select, textarea {width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;}
    @media (max-width: 768px) {body{background-color: #ffffffff;} .contenedor-general{box-shadow: none !important;padding:0px;border-radius: 0px;} .row div{margin-bottom: 10px;}}
</style>

<div class="container-fluid">
    <div class="contenedor-general">        
        <div class="row" style="margin: 0px;">
            <div style="display: flex; flex-direction: column; justify-content: flex-start; align-items: flex-start; border-bottom: 1px solid #ebebeb; padding-bottom: 15px; margin-bottom: 20px;">
                <h5 style="margin-bottom: 0;">Nuevo Servicio</h5>                
            </div>
            <form method="post" enctype="multipart/form-data">
                <div id="datos-cargardos-usuario">
                    <div class="row" style="margin: 0px;">                                
                        <div class="col-md-3 col-12">
                            <strong class="labels-input">Tipo</strong>
                            <select name="tipo" id="tipo" required>
                                <option value="" selected disabled>Seleccionar tipo</option>
                                <option value="recurso">Recurso</option>
                                <option value="pagina">Página</option>
                                <!-- <option value="grabacion">Grabación</option> -->
                                <option value="edicion">Edición</option>
                                <option value="diseno">Diseño</option>
                            </select>                            
                        </div>
                        <div class="col-md-3 col-12">
                            <strong class="labels-input">Título *</strong>
                            <input type="text" name="titulo" id="titulo" class="mb-1" required>
                        </div> 
                        <div class="col-md-3 col-12">
                            <strong class="labels-input">Descripción *</strong>
                            <input type="text" name="descripcion" id="descripcion" class="mb-1" required>
                        </div> 
                        <div class="col-md-2 col-12">
                            <strong class="labels-input">Precio</strong>
                            <input type="text" name="precio" id="precio" class="mb-1" placeholder="Ej: 50.00">
                        </div>                         
                        <div class="col-md-1 col-12">
                            <strong class="labels-input">Moneda</strong>
                            <select name="moneda" id="moneda">
                                <option value="sol" selected>SOL</option>                                
                                <option value="usd">USD</option>
                            </select>
                        </div>    
                        <!-- <div class="col-md-3 col-12">
                            <strong class="labels-input">Estado</strong>
                            <select name="estado" id="estado">
                                <option value="activo" selected>Activo</option>
                                <option value="desactivado">desactivado</option>
                            </select>
                        </div>         -->               
                    </div>
                    
                    <!-- <div class="row" style="margin: 15px 0 0 0;">                                
                        <div class="col-md-3 col-12">
                            <strong class="labels-input">Cupón</strong>
                            <input type="text" name="cupon" id="cupon" class="mb-1" placeholder="Código de cupón">
                        </div>
                        <div class="col-md-3 col-12">
                            <strong class="labels-input">Descuento (%)</strong>
                            <input type="text" name="dscto" id="dscto" class="mb-1" placeholder="Ej: 10">
                        </div> 
                                                                
                    </div> -->
                    
                    <div class="row" style="margin: 15px 0 0 0;">                                
                        <div class="col-md-4 col-12">
                            <strong class="labels-input">Imagen</strong>
                            <input type="file" name="imagenitem" id="imagenitem" class="mb-1" accept="image/*">
                        </div>
                        <div class="col-md-4 col-12">
                            <strong class="labels-input">Tags (obs)</strong>
                            <input type="text" name="obs" id="obs" class="mb-1" placeholder="Tags separados por comas">
                        </div>                                                
                    </div>
                </div>                            
                
                <div class="row" style="margin: 0px;">        
                    <div class="container" style="display: flex; justify-content: center; margin-top: 20px;border-top: 1px solid #ebebeb; padding-top: 15px;">
                        <button class="btn btn-primary" type="submit" name="btnguardaritem" style="padding: 8px 30px;">Guardar Servicio</button>
                    </div>
                </div>  
            </form>         
        </div>    
    </div>
</div>

<?php include 'footer.php'; ?>