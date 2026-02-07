<?php session_start();
$_SESSION['current_page'] = 'servicios'; include "head.php"; ?>

<?php  

if(isset($_POST['btnguardaritem'])){
    $fechar = date('Y-m-d H:i:s');
    $descripcion = $_POST['descripcion'] ?? null;
    $tipo = $_POST['tipo'] ?? null;
    $precio = $_POST['precio'] ?? null;
    $titulo = $_POST['titulo'] ?? null;
    $link = preg_replace('/[^a-z0-9]+/', '-', $slug);
    $foto = '';
    $obs = $_POST['obs'] ?? null; // -> TAGS OPCIONALES
    
    // Directorio donde se guardarán las imágenes
    $upload_dir = "items/";
    
    // Crear el directorio si no existe
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    
    // Procesar Logo (foto)
    if(isset($_FILES['imagenitem']) && $_FILES['imagenitem']['error'] === UPLOAD_ERR_OK) {
        $logo_file = $_FILES['imagenitem'];
        $logo_name = basename($logo_file['name']);
        $logo_tmp = $logo_file['tmp_name'];
        //$logo_path = $upload_dir . $logo_name;
        $logo_path = $upload_dir . $titulo . '.png';
        
        if(move_uploaded_file($logo_tmp, $logo_path)) {
            $foto = $logo_name;
        }
    }
    die("'$fechar',       
        '$titulo',       
        '$descripcion',       
        '$tipo',       
        '$foto',       
        '$link',       
        '$obs'");
    mysqli_query($connection, "INSERT INTO a_servicios (    
        fechar,
        titulo,
        descripcion,
        tipo,
        img,
        link,
        obs
    ) VALUES (
        '$fechar',       
        '$titulo',       
        '$descripcion',       
        '$tipo',       
        '$foto',       
        '$link',       
        '$obs',       
    )");
    
    echo "<script>window.location='servicios.php';</script>";
}
?>
<link rel="stylesheet" href="blite.css">
<style>
    .contenedor-general{box-shadow: 2px 6px 15px 0px rgba(69, 65, 78, 0.1);background-color: white; padding: 20px; border-radius: 8px; margin-top: 20px;}
    .main-content{margin-top: 72px;}.row div{margin-bottom: 15px;}
    @media (max-width: 768px) {body{background-color: #ffffffff;} .contenedor-general{box-shadow: none !important;padding:0px;border-radius: 0px;} .row div{margin-bottom: 0px;}}
</style>
<div class="container-fluid" >
    <div class="contenedor-general" >        
        <div class="row" style="margin: 0px;">
            <div style="display: flex; flex-direction: column; justify-content: flex-start; align-items: flex-start; border-bottom: 1px solid #ebebeb;">
                <h5 style="margin-bottom: 20px;">Nuevo Servicio</h5>                
            </div>
            <form method="post" enctype="multipart/form-data">
                <div id="datos-cargardos-usuario">
                    <!-- AQUI SE CARGAN LOS DATOS DESDE LA FUNCION BUSCARDNI() -->
                    <div class="row" style="margin: 0px;">                                
                        <div class="col-3">
                            <strong class="labels-input" >Tipo</strong>
                            <select name="tipo" id="tipo">
                                <option value="" selected></option>
                                <option value="recurso">recurso</option>
                                <option value="pagina">pagina</option>
                                <option value="grabacion">grabacion</option>
                                <option value="edicion">edicion</option>
                                <option value="diseño">diseño</option>
                            </select>                            
                        </div>
                        <div class="col-3">
                            <strong class="labels-input" >Cantidad</strong>
                            <input type="text" name="cantidad" id="cantidad" onchange="calculartotal(this.value)" class="mb-1" value="<?php echo $_SESSION['apematcli'] ?? null ?>">
                        </div> 
                        <div class="col-6">
                            <strong class="labels-input" >Descripción</strong>
                            <input type="text" name="descripcion" id="descripcion" class="mb-1" value="<?php echo $_SESSION['nrodoccli'] ?? null ?>">
                        </div>
                        <div class="col-3">
                            <strong class="labels-input" >Marca</strong>
                            <input type="text" name="marca" id="marca" class="mb-1" value="<?php echo $_SESSION['telefono'] ?? null ?>">
                        </div>
                        <div class="col-9">
                            <strong class="labels-input" >Num. Serie/Model</strong>
                            <input type="text" name="num_serie_model" id="num_serie_model" class="mb-1" value="<?php echo $_SESSION['email'] ?? null ?>">
                        </div>
                        <div class="col-3">
                            <strong class="labels-input" >Color</strong>
                            <input type="text" name="color" id="color" class="mb-1" value="<?php echo $_SESSION['usuario'] ?? null ?>">
                        </div>
                        <div class="col-3">
                            <strong class="labels-input" >Ubicación</strong>
                            <input type="text" name="ubicacion" id="ubicacion" class="mb-1" value="<?php echo $_SESSION['sucursal'] ?? null ?>">
                        </div>  
                        <div class="col-3">
                            <strong class="labels-input" >Estado</strong>
                            <select name="estado" id="estado">
                                <option value="nuevo">Nuevo</option>
                                <option value="usado">Usado</option>
                                <option value="reparacion">En Reparación</option>
                            </select>
                        </div>
                        <div class="col-3">
                            <strong class="labels-input" >Proveedor</strong>
                            <input type="text" name="proveedor" id="proveedor" class="mb-1" >
                            <!-- <?php 
                            echo "<strong class='labels-input' >Proveedor</strong> <a href='proveedor-nuevo.php?r=2' style='color:#0099Ff' title='agregar Proveedor'>...[+]</a><br>";
                            $SQL="Select * From vega_proveedores order by nomPro";
                            if(!($resultP=mysqli_query($connection,$SQL))){
                            echo "error :".mysqli_error();
                            exit();}
                            echo '<select required name="proveedor"  > ';
                            echo "<option value=''>Seleccione Canal</option>";
                            while ($row=mysqli_fetch_array($resultP)){ 
                            echo "<option  value='".$row["codPro"]."'>".$row["nomPro"];}
                            echo '</select>';
                            mysqli_free_result($resultP);	
                        ?> -->
                        </div>
                        <div class="col-3">
                            <strong class="labels-input" >Fm.Adquisición</strong>
                            <input type="text" name="forma_adquisicion" id="forma_adquisicion" class="mb-1" >
                        </div>
                        <div class="col-3">
                            <strong class="labels-input" >Fecha de Compra</strong>
                            <input type="date" name="fechacompra" id="fechacompra" class="mb-1" >
                        </div>
                        <div class="col-3">
                            <strong class="labels-input" >Precio Unidad</strong>
                            <input type="number" name="preciounidad" onchange="calculartotal(this.value)" id="preciounidad" class="mb-1" >
                        </div>
                        <div class="col-3">
                            <strong class="labels-input" >Valor Total</strong>
                            <input type="text" name="valortotal" id="valortotal" class="mb-1" >
                        </div>
                        <div class="col-3">
                            <strong class="labels-input" >Operativo</strong>
                            <select name="operativo" id="operativo">
                                <option value="operativo">Operativo</option>
                                <option value="desgastado">Desgastado</option>
                                <option value="malogrado">Malogrado</option>
                                <option value="mantenimiento">Mantenimiento</option>
                            </select>
                        </div>
                        <div class="col-3">
                            <strong class="labels-input" >Imagen del Ítem</strong>
                            <input type="file" name="imagenitem" id="imagenitem" class="mb-1">
                        </div>                                                                 
                        <div class="col-12">                            
                            <strong class="labels-input" >Habido</strong>
                            <input type="checkbox" name="chkbox1" id="chkbox1" class="mb-1">
                        </div>
                    </div>    
                </div>                            
                <div class="row" style="margin: 0px;">        
                    <div class="container" style="display: flex; justify-content: center; margin-top: 20px;border-top: 1px solid #ebebeb; padding-top: 15px;">
                        <button class="btn btn-primary" type="submit" name="btnguardaritem">Guardar</button>
                    </div>
                </div>  
                <script>
                    function calculartotal(){
                        var cantidad = document.getElementById('cantidad').value;
                        var preciounidad = document.getElementById('preciounidad').value;
                        var valortotal = cantidad * preciounidad;
                        document.getElementById('valortotal').value = valortotal;
                    }
                </script>
            </form>         
        </div>    
    </div>
</div>
<?php include 'footer.php'; ?>