<?php session_start(); ini_set('display_errors', 0);
$_SESSION['current_page'] = 'movimientos'; include "head.php";?>
<link rel="stylesheet" href="blite.css">
<link rel="stylesheet" href="tablas.css">
<style>
    .contenedor-general{box-shadow: 2px 6px 15px 0px rgba(69, 65, 78, 0.1);background-color: white; padding: 20px; border-radius: 8px; margin-top: 20px;}
    .main-content{margin-top: 72px;}.row div{margin-bottom: 15px;}
    @media (max-width: 768px) {body{background-color: #ffffffff;} .contenedor-general{box-shadow: none !important;padding:0px;border-radius: 0px;} .row div{margin-bottom: 0px;}}
    @media (max-width: 768px) {.valor-tabla{font-size: x-small;}} .table thead th{ background-color: transparent; } .labels-input {display: block; margin-bottom: 5px; font-size: 14px; color: #333;}
    .btneditar-acc{
      left: 12px;
    position: relative;
    color: black;
    text-decoration: none;
    font-size: 15px;
  }
  .acciones-columna {
    position: sticky !important;
    right: 0 !important;
    /*z-index: 10 !important;*/
    box-shadow: -2px 0 5px rgba(0,0,0,0.1);
    min-width: 80px;
    white-space: nowrap;
}

/* Contenedor del menú */
.menu-acciones {
    position: relative;
    display: inline-block;
}

/* Botón del menú */
.btn-menu {
    background: white;
    border: 1px solid #ddd;
    border-radius: 20px;
    padding: 2px 10px;
    cursor: pointer;
    font-size: 18px;
    transition: all 0.3s;
}

.btn-menu:hover {
    background: #f5f5f5;
}

/* Opciones del menú (ocultas por defecto) */
.menu-opciones {
    display: none;
    position: absolute;
    top: 50px;
    right: 0;
    background: white;
    border: 1px solid #ddd;
    border-radius: 4px;
    min-width: 180px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    display: none;
    z-index: 999999999999999999;
}

.menu-opciones .btneditar-acc{
    display: block;
    width: 100%;
    padding: 8px 12px;
    background: none;
    border: none;
    border-bottom: 1px solid #eee;
    text-align: left;
    cursor: pointer;
    transition: background 0.2s;
}

.menu-opciones button:hover {
    background: #f8f9fa;
}

.menu-opciones button:last-child {
    border-bottom: none;
}

.menu-opciones .btneditar-acc:last-child {
    border-bottom: none;
}

.menu-opciones form:hover {
    background: #f5f5f5;
}
</style>
<div class="container-fluid" >
    <div class="contenedor-general" >
         <div class="row" style="margin: 0px;">        
            <script>
                    let tipoSeleccionado = '';
                    let servicioSeleccionado = '';
                    function cambiartipo(origen, valor) {
                        if (origen === 'tipo') {
                            tipoSeleccionado = valor;
                        } else if (origen === 'servicio') {
                            servicioSeleccionado = valor;
                        }

                        const formdata = new FormData();
                        formdata.append('tipo', tipoSeleccionado);
                        formdata.append('servicio', servicioSeleccionado);

                        fetch("utils/selectmovimientos.php", {
                            method: "POST",
                            body: formdata
                        })
                        .then(response => response.text())
                        .then(resultado => {
                            document.querySelector("#tbdoytipousuarios").innerHTML = resultado;
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Error al cargar los datos');
                        });
                    }
                    /* function irANuevo() {
                        window.location.href = `usuario_nuevo.php?tipo=${tipoSeleccionado}`;
                    } */
                </script>
            <div style="display: flex; justify-content: space-between; border-bottom: 1px solid #ebebeb;padding-bottom: 15px;">
                <h5 style="margin-bottom: 20px;position: relative;top: 10px;">Movimientos</h5>
                <a  href="nuevo_movimiento.php" class="btn btn-primary">Nuevo</a>
            </div>
            <!-- <div style="display: flex; justify-content: space-between; border-bottom: 1px solid #ebebeb;padding-bottom: 15px;">                 -->
                <div class="row" style="margin: 0px;">
                    <div class="col-6">
                        <strong class="labels-input">Tipo</strong>
                        <select id="tipo_usuario" onchange="cambiartipo('tipo', this.value)">
                            <option value=""></option>
                            <option value="ingreso">Ingreso</option>
                            <option value="gasto">Gasto</option>
                        </select>
                    </div>         
                    <div class="col-6">
                        <strong class="labels-input">Servicio</strong>
                        <select name="" id="select_sucursal" onchange="cambiartipo('servicio', this.value)">                    
                            <option value=""></option>                    
                            <?php 
                            $tablapadre = mysqli_fetch_array(mysqli_query($connection, "SELECT id,tabla FROM a_tablas WHERE tabla ='unidad_negocio'"));
                            $tablahijo = mysqli_query($connection, "SELECT id,tabla FROM a_tablas WHERE hijo = '$tablapadre[id]' order by id desc");                            
                                while ($rowartire = mysqli_fetch_array($tablahijo)){
                                    echo "<option value='$rowartire[id]'>$rowartire[tabla]</option>";
                                }
                            ?>
                        </select> 
                    </div>
                </div>    
            <!-- </div> -->
        </div>            
        <div class="row" style="margin: 0;">
            <div class="table-responsive">             
                <table class="table" id="tbdoytipousuarios">
                    <thead >
                        <tr style="background-color: transparent;">                            
                            <th>Concepto</th>                            
                            <th>Monto</th>
                            <th>Pago</th>
                            <th>Fecha</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="tbodyitems">
                        
                    </tbody>
                </table>
        </div>
    </div>
</div>
<!-- <script>
    function detallescheckboxagenda(campo, estado, id){
    const formdata = new FormData();                        
    formdata.append("campo", campo); 
    formdata.append("estado", estado ? 1 : 0); 
    formdata.append("id", id); 
    
    fetch("utils/actualizar_checkbox_inventario.php", {
        method: "POST",
        body: formdata
    })
    .then(response => response.text())
    .then(resultado => {
        console.log("Actualizado:", resultado);
    })
    .catch(error => {
        console.error("error:", error);
        alert("Error al actualizar");
    });     
}
</script> -->
<!-- <script>
    // Mostrar/ocultar select de sucursal según el tipo seleccionado
    document.getElementById('tipo_usuario').addEventListener('change', function() {
        const sucursalSelect = document.getElementById('select_sucursal');
        
        if (this.value === "1") {
            sucursalSelect.style.display = 'block';
        } else {
            sucursalSelect.style.display = 'none';
            sucursalSeleccionada = ""; // Limpiar selección de sucursal
        }
    });
</script> -->
<script>
    let menuAbierto = null;

    // Alternar menú
function toggleMenu(id) {
    const menu = document.getElementById('menu-' + id);
    
    // Cerrar menú anterior si existe
    if (menuAbierto && menuAbierto !== menu) {
        menuAbierto.style.display = 'none';
    }
    
    // Alternar menú actual
    if (menu.style.display === 'block') {
        menu.style.display = 'none';
        menuAbierto = null;
    } else {
        menu.style.display = 'block';
        menuAbierto = menu;
    }
    
    // Cerrar al hacer clic fuera
    event.stopPropagation();
}

// Cerrar menú al hacer clic en cualquier parte
document.addEventListener('click', function(e) {
    if (menuAbierto && !menuAbierto.contains(e.target) && 
        !e.target.classList.contains('btn-menu')) {
        menuAbierto.style.display = 'none';
        menuAbierto = null;
    }
});
</script>
<?php include 'footer.php'; ?>