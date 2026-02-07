<?php include '../cn.php'; if($_POST['tipo'] == "afiliado"){ ?>
<div class="col-3">
    <strong class="labels-input">Artista ... <a href="usuario_nuevo.php?tipo=artista">[+]</a></strong>
    <select name="artis" id="artis">
        <option value=""></option>
        <?php 
        $sqlresp = mysqli_query($connection, "SELECT * FROM vega_sucursal where nivel = 'artista'");
        while ($rowp = mysqli_fetch_array($sqlresp)){ 
        ?>
        <option value="<?php echo $rowp['cod'] .':::'.$rowp['id']; ?>"><?php echo $rowp['nombre'] ?? '';?></option>
        <?php } ?>
    </select>
</div>
<div class="col-3">
    <strong class="labels-input">Hora Inicio</strong>
    <input type="time" name="horainicio" id="horainicio" class="mb-1">
</div>                
<div class="col-3">
    <strong class="labels-input">Horas</strong>
    <input type="text" name="canthoras" id="canthoras" class="mb-1">
</div>   
<button type="submit" name="btnguardarartisinvi" class="btn btn-primary">Guardar</button>
<?php } else if($_POST['tipo'] == "invitado") { ?>
<div class="col-3">
    <strong class="labels-input">Invitado (Externo)... <a href="usuario_nuevo.php?tipo=artista&externo=si">[+]</a></strong>
    <select name="artis" id="artis">
        <option value=""></option>
        <?php 
        $sqlresp = mysqli_query($connection, "SELECT * FROM vega_sucursal where nivel = 'artistaexterno'");
        while ($rowp = mysqli_fetch_array($sqlresp)){ 
        ?>
        <option value="<?php echo $rowp['cod'] .':::'.$rowp['id']; ?>"><?php echo $rowp['nombre'] ?? '';?></option>
        <?php } ?>
    </select>
    </div>
    <div class="col-3">
        <strong class="labels-input">Hora Inicio</strong>
        <input type="time" name="horainicio" id="horainicio" class="mb-1">
    </div>                
    <div class="col-3">
        <strong class="labels-input">Horas</strong>
        <input type="text" name="canthoras" id="canthoras" class="mb-1">
    </div>   
    <button type="submit" name="btnguardarartisinvi" class="btn btn-primary">Guardar</button>
<?php } ?>