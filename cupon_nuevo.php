<?php 
session_start();
$_SESSION['current_page'] = 'cupones'; 
include "head.php"; 

if(isset($_POST['btnguardar'])){
    $codigo = $_POST['codigo'] ?? '';
    $dscto = $_POST['dscto'] ?? '';
    $referenciahijo = $_POST['referenciahijo'] ?? '';
    $fecha_fin = $_POST['fecha_fin'] ?? '';
    $query = "INSERT INTO a_cupones (
        codigo,
        dscto,
        hijo,
        fechafin,
        estado
    ) VALUES (
        '$codigo',
        '$dscto',
        '$referenciahijo',
        '$fecha_fin',
        'activo'
    )";       
    
    if(mysqli_query($connection, $query)) {
        //echo "<script>alert('Servicio guardado correctamente'); window.location='servicios.php';</script>";
        echo "<script>window.location='cupones.php';</script>";
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
                <h5 style="margin-bottom: 0;">Nuevo Cupón</h5>                
            </div>
            <form method="post" enctype="multipart/form-data">
                <div id="datos-cargardos-usuario">
                    <div class="row" style="margin: 0px;">                                                        
                        <div class="col-md-6 ">
                            <strong class="labels-input">Codigo</strong>
                            <input type="text" name="codigo" id="codigo" class="mb-1" required placeholder="RDSC10">
                        </div>                                  
                        <div class="col-md-3 ">
                            <strong class="labels-input">Descuento</strong>
                            <input type="text" name="dscto" id="dscto" class="mb-1" required placeholder="Ej: 10">
                        </div>                          
                        <div class="col-md-3 ">
                            <strong class="labels-input">Fecha Fin</strong>
                            <input type="date" name="fecha_fin" id="fecha_fin" class="mb-1" required min="<?php echo date('Y-m-d'); ?>">
                        </div>                          
                        <div class="col-md-3 ">
                            <strong class="labels-input">Referencia</strong>
                            <select name="referenciahijo" id="referenciahijo">
                                <option value=""></option>
                                <?php $result = mysqli_query($connection, "SELECT id, titulo FROM a_servicios order by id desc");
                                while($row = mysqli_fetch_array($result)) { ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['titulo']; ?></option>
                                <?php } ?>
                            </select>
                        </div>                                         
                    </div>                    
                </div>                            
                
                <div class="row" style="margin: 0px;">        
                    <div class="container" style="display: flex; justify-content: center; margin-top: 20px;border-top: 1px solid #ebebeb; padding-top: 15px;">
                        <button class="btn btn-primary" type="submit" name="btnguardar" style="padding: 8px 30px;">Guardar</button>
                    </div>
                </div>  
            </form>         
        </div>    
    </div>
</div>

<?php include 'footer.php'; ?>