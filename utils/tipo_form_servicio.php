<?php include '../cn.php';$idage = $_POST['id'] ?? null; ini_set("display_errors",1);
/* function formatear12($hora) {
    return date("g:i A", strtotime($hora));
} */
if($_POST['tipo'] == "detalles"){
    $agendaobt = mysqli_fetch_array(mysqli_query($connection, "SELECT * FROM a_servicios WHERE id = '$idage'"));
?>
<form method="post"  enctype="multipart/form-data">
    <div style="display: flex; justify-content: center; border-bottom: 1px solid #ebebeb;">
        <h5 style="margin-bottom: 20px;">Editar Detalle</h5>
    </div>
    <div class="row" style="margin: 0px;">                                        
        <div class="col-md-6 col-12">
            <strong class="labels-input">Título</strong>
            <input type="text" name="titulo" id="titulo" class="mb-1" value="<?php echo $agendaobt['titulo'] ?? ''; ?>" required>
        </div>         
        <div class="col-md-3">
            <strong class="labels-input">Precio</strong>
            <input type="text" name="precio" id="precio" class="mb-1" placeholder="Ej: 50.00" value="<?php echo $agendaobt['precio'] ?? ''; ?>">
        </div>  
        <div class="col-md-3 col-12">
            <strong class="labels-input">Moneda</strong>
            <select name="moneda" id="moneda">
                <option value="sol" <?php echo ($agendaobt['moneda'] == 'sol') ? 'selected' : ''; ?>>SOL</option>                                
                <option value="usd" <?php echo ($agendaobt['moneda'] == 'usd') ? 'selected' : ''; ?>>USD</option>
            </select>
        </div>                            
    </div>
    <div class="row" style="margin: 0px;">
        <div class="col-md-12">
            <strong class="labels-input">Descripción</strong>
            <textarea type="text" name="descripcion" id="descripcion" class="mb-1" ><?php echo $agendaobt['descripcion'] ?? ''; ?></textarea>
        </div> 
    </div>
    <div class="row" style="margin: 15px 0 0 0;">                                
        <div class="col-md-4 col-12">
            <strong class="labels-input">Imagen</strong>            
            <?php if(!empty($agendaobt['img'])): ?>
                <img src="items/<?php echo ($agendaobt['img']); ?>"  class="imagen-actual" style="max-width: 50%; height: auto;" alt="Imagen actual">
                <br>
                <!-- <label>
                    <input type="checkbox" name="eliminar_imagen" value="1"> Eliminar imagen actual
                </label> -->
            <?php else: ?>
                <p>No hay imagen cargada</p>
            <?php endif; ?>
            <input type="file" name="imagenitem" id="imagenitem" class="mb-1" accept="image/*">
        </div>                                               
    </div>
    <div class="row" style="margin: 0px;">
        <div class="col-md-12">
            <strong class="labels-input">Tags (obs)</strong>
            <input type="text" name="obs" id="obs" class="mb-1" placeholder="Tags separados por comas" value="<?php echo $agendaobt['obs'] ?? ''; ?>">
        </div> 
    </div>
    <button type="submit" name="btneditar" class="btn btn-primary">Guardar</button>       
</form>     
<?php } else
if($_POST['tipo'] == "oferta"){
    $agendaobt = mysqli_fetch_array(mysqli_query($connection, "SELECT * FROM a_servicios WHERE id = '$idage'"));
?>
<form method="post"  enctype="multipart/form-data">
    <div style="display: flex; justify-content: center; border-bottom: 1px solid #ebebeb;">
        <h5 style="margin-bottom: 20px;">Editar Oferta</h5>
    </div>
    
    <div class="row" style="margin: 15px 0 0 0;">                                
        <!-- <div class="col-md-3 col-12">
            <strong class="labels-input">Cupón</strong>
            <input type="text" name="cupon" id="cupon" class="mb-1" placeholder="Código de cupón" value="<?php echo $agendaobt['cupon'] ?? ''; ?>">
        </div> -->
        <div class="col-md-3 col-12">
            <strong class="labels-input">Descuento (%)</strong>
            <input type="text" name="dscto" id="dscto" class="mb-1" placeholder="Ej: 10" value="<?php echo $agendaobt['dscto'] ?? ''; ?>">
        </div>         
        <div class="col-md-3 col-12">
            <strong class="labels-input">Fecha limite</strong>
            <input type="date" name="fechalim" id="fechalim" class="mb-1" min="<?php echo date('Y-m-d'); ?>" placeholder="Ej: 10" value="<?php echo $agendaobt['fecha_oferta_limite'] ?? ''; ?>">
        </div> 
        <div class="col-md-3 col-12">
            <strong class="labels-input">Hora limite</strong>
            <input type="time" name="horalim" id="horalim" class="mb-1" placeholder="Ej: 10" value="<?php echo $agendaobt['hora_oferta_limite'] ?? ''; ?>">
        </div>                                           
    </div>
    <button type="submit" name="btneditaroferta" class="btn btn-primary">Guardar</button>       
</form> 
<?php } else if($_POST['tipo'] == "archivo"){ ?>
<form method="post">    
    <div class="row" style="margin: 0px;">      
        <div id="progressContainer" style="margin-top:15px; display:none;">
            <div style="background:#e9ecef;border-radius:5px;overflow:hidden;height:22px;">
                <div id="progressBar" style="width:0%;height:100%;background:#0d6efd;color:#fff;text-align:center;font-size:12px;line-height:22px;">
                    0%
                </div>
            </div>
            <small id="progressText">Subiendo archivo...</small>
        </div>
        <div style="display: flex; justify-content: center; border-bottom: 1px solid #ebebeb;">
            <h5 style="margin-bottom: 20px;">Archivos vinculado (⬆️)</h5>
        </div>
        <div class="row" style="margin: 0px;">                    
            <div class="col-6">
                <strong class="labels-input">Subir archivo</strong>
                <input type="file" name="archivosubir" id="archivosubir" class="mb-1">
            </div>    
            <div class="col-6">
                <strong class="labels-input">Nombre</strong>
                <input type="text" name="nombrearchivo" id="nombrearchivo" class="mb-1" required>
            </div>    
            <button type="button" onclick="subirArchivoChunks()" class="btn btn-primary">
            Subir archivo
            </button>
        </div>
        
    </div>    
</form> 
    <div class="row">
            <div class="table-responsive">
                <table class="table table-bordered" id="tbdoytipousuarios">
                    <thead>
                        <tr>
                            <th>Archivo</th>
                            <th>Tamaño</th>
                            <th></th>                                        
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $prodarchreg = mysqli_query($connection, "SELECT * FROM a_producto_archivos WHERE productoid = '$idage'");
                        while ($rowartire = mysqli_fetch_array($prodarchreg)){
                            echo "<tr>";
                            echo "<td>" . $rowartire['nombre'] . "</td>";
                            echo "<td>" . $rowartire['tamano'] . "</td>";
                            echo "<td><form method='post' style='margin: 0;'><input type='hidden' name='idproductoarchivo' value='$rowartire[id]'><button type='submit' name='btnEliminarArchivo' class='btn btn-danger'><i class='bi bi-trash-fill'></i></button></form></td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
        </div>
<?php } ?>