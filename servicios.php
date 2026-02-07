<?php session_start(); ini_set('display_errors', 0);
$_SESSION['current_page'] = 'servicios'; include "head.php";?>
<link rel="stylesheet" href="blite.css">
<link rel="stylesheet" href="tablas.css">
<style>
    .contenedor-general{box-shadow: 2px 6px 15px 0px rgba(69, 65, 78, 0.1);background-color: white; padding: 20px; border-radius: 8px; margin-top: 20px;}
    .main-content{margin-top: 72px;}.row div{margin-bottom: 15px;}
    @media (max-width: 768px) {body{background-color: #ffffffff;} .contenedor-general{box-shadow: none !important;padding:0px;border-radius: 0px;} .row div{margin-bottom: 0px;}}
    @media (max-width: 768px) {.valor-tabla{font-size: x-small;}} .table thead th{ background-color: transparent; }
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
        <div class="row" style="margin: 0;">        
            <script>
                    function buscaritem(item){
                        const formdata = new FormData();                        
                        formdata.append('item', item); 
                        fetch("utils/buscaritem.php", {
                                method: "POST",
                                body: formdata
                            })
                            .then(response => {				
                                return response.text();
                            })
                            .then(resultado => {					
                                document.querySelector("#tbodyitems").innerHTML = resultado;
                            }).catch(error => {
                                console.error('Error:', error);
                                alert('Error al cargar los datos');
                            });
                        }
                    
                </script>
            <div style="display: flex; justify-content: space-between;padding-bottom: 15px;">
                <h5 style="margin-bottom: 20px;position: relative;top: 10px;">Servicios</h5>
                <div>
                    <a  href="nuevo_servicio.php" class="btn btn-primary">Nuevo</a>
                    <button type="button" class="btn btn-primary" onclick="window.location.href='utils/exportar_inventario.php'">Excel</button>

                </div>
            </div>
            <div style="padding-bottom: 15px;">                
                <div class="row" style="margin: 0;">
                    <div class="col-md-12">
                        <strong>Buscar por nombre</strong>
                        <input type="text" name="descripcion" onkeyup="buscaritem(this.value)" placeholder="Escritorio negro...">                        
                    </div>                    
                </div> 
            </div>
        </div>
        <div class="row" style="margin: 0;">
            <div class="table-responsive">                
                <table class="table" id="tbdoytipousuarios">
                    <thead >
                        <tr style="background-color: transparent;">                            
                            <th>Nombre</th>                            
                            <th>Tipo</th>
                            <th>Precio</th>
                            <th>Mostrar en Pag</th>
                            <th>Estado</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="tbodyitems">
                        <?php 
                        $query = "SELECT * FROM a_servicios order by id desc";
                        $result = mysqli_query($connection, $query);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['titulo'] . "</td>";
                                echo "<td>" . $row['tipo'] . "</td>";
                                echo "<td>" . $row['precio'] . " (" . $row['moneda'] . ")". "</td>";
                                echo '<td><select name="mostrarweb" id="mostrarweb">
                                <option value="si" '.($row['obs1'] == "si" ? "selected" : "").'>Si</option>
                                <option value="no" '.($row['obs1'] == "si" ? "selected" : "").'>No</option>
                                </select></td>';
                                echo '<td><select name="estado" id="estado">
                                <option value="activado" '.($row['estado'] == "activado" ? "selected" : "").'>Activo</option>
                                <option value="desactivado" '.($row['estado'] == "desactivado" ? "selected" : "").'>Desactivado</option>
                                </select></td>';
                                echo "<td class='acciones-columna' >
                                        <div class='menu-acciones'>
                                            <button class='btn-menu' onclick='toggleMenu({$row['id']})'>&#8942;</button>
                                            <div class='menu-opciones' id='menu-{$row['id']}'>                            
                                                <form action=''><a class='btneditar-acc'  href='servicio_editar.php?id=" . $row['id'] . "'>Editar</a></form>
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

                        mysqli_close($connection);
                        ?>
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