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
    <script>
        let tipoSeleccionado = localStorage.getItem('tipoSeleccionado') || 'detalles';

        function tipoform(tipo) {
            tipoSeleccionado = tipo;
            // Guardar en localStorage
            localStorage.setItem('tipoSeleccionado', tipo);
            
            const formdata = new FormData();                        
            formdata.append('tipo', tipo); 
            formdata.append('id', "<?php echo $idage ?? null; ?>") 
            fetch("utils/tipo_form_servicio.php", {
                method: "POST",
                body: formdata
            })
            .then(response => {				
                return response.text();
            })
            .then(resultado => {					
                document.querySelector(".contenedor-general").innerHTML = resultado;
                marcarRadioSeleccionado();
            }).catch(error => {
                console.error('Error:', error);
                alert('Error al cargar los datos');
            });
        }

        function marcarRadioSeleccionado() {
            // Marcar el radio button correspondiente
            const radios = document.querySelectorAll('input[type="radio"]');
            radios.forEach(radio => {
                radio.checked = (radio.value === tipoSeleccionado);
            });
        }

        // Ejecutar al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            marcarRadioSeleccionado();
            // Cargar el contenido inicial
            if (tipoSeleccionado) {
                tipoform(tipoSeleccionado);
            }
        });
                /* function selecttipopart(tipo) {
                    console.log("clickcc");
                    const formdata = new FormData();                        
                    formdata.append('tipo', tipo);
                    fetch("utils/selecttipopart.php", {
                        method: "POST",
                        body: formdata
                    })
                    .then(response => {				
                        return response.text();
                    })
                    .then(resultado => {					
                        document.querySelector("#content-tipo-art").innerHTML = resultado;
                    }).catch(error => {
                        console.error('Error:', error);
                        alert('Error al cargar los datos');
                    });
                } */
    </script>
    <!-- <script>                   
                            function cargarDepartamento(value) {
                                console.log("val: ", value);
                                const formdata = new FormData();                        
                                formdata.append('idpadre', value); 
                                fetch("utils/checkout_ubigeo_agenda.php", {
                                        method: "POST",
                                        body: formdata
                                    })
                                    .then(response => {				
                                        return response.text();
                                    })
                                    .then(resultado => {					
                                        document.querySelector("#dpto").innerHTML = resultado;
                                    }).catch(error => {
                                        console.error('Error:', error);
                                        alert('Error al cargar los datos');
                                    });                                            
                            }
                            function cargarProvincia(value) {
                                const formdata = new FormData();                        
                                formdata.append('idpadre', value); 
                                fetch("utils/checkout_ubigeo_agenda.php", {
                                        method: "POST",
                                        body: formdata
                                    })
                                    .then(response => {				
                                        return response.text();
                                    })
                                    .then(resultado => {					
                                        document.querySelector("#provincia").innerHTML = resultado;
                                    }).catch(error => {
                                        console.error('Error:', error);
                                        alert('Error al cargar los datos');
                                    });                                            
                            }
                            function cargarDistrito(value) {
                                const formdata = new FormData();                        
                                formdata.append('idpadre', value); 
                                fetch("utils/checkout_ubigeo_agenda.php", {
                                        method: "POST",
                                        body: formdata
                                    })
                                    .then(response => {				
                                        return response.text();
                                    })
                                    .then(resultado => {					
                                        document.querySelector("#distrito").innerHTML = resultado;
                                    }).catch(error => {
                                        console.error('Error:', error);
                                        alert('Error al cargar los datos');
                                    });                                            
                            }
                        </script>  -->
                     
    <div class="radio-group">
        <label class="radio-option">
            <input type="radio" onchange="tipoform(this.value)" name="detalles" value="detalles">
            Detalles
        </label>
        <label class="radio-option">
            <input type="radio" onchange="tipoform(this.value)" name="archivo" value="archivo">
            Archivo
        </label>        
        <label class="radio-option">
            <input type="radio" onchange="tipoform(this.value)" name="recaudado" value="recaudado">
            Recaudado
        </label>        
        <label class="radio-option">
            <input type="radio" onchange="tipoform(this.value)" name="oferta" value="oferta">
            Oferta
        </label>        
    </div>
    <div class="contenedor-general" >
        
    </div>    
    
</div>
<script>
async function subirArchivoChunks() {
    const fileInput = document.getElementById('archivosubir');
    const nomInput = document.getElementById('nombrearchivo');

    const progressContainer = document.getElementById('progressContainer');
    const progressBar = document.getElementById('progressBar');
    const progressText = document.getElementById('progressText');

    const file = fileInput.files[0];

    if (!file) {
        alert("Selecciona un archivo");
        return;
    }

    if (!nomInput.value.trim()) {
        alert("Ingresa un nombre para el archivo");
        return;
    }

    const productId = "<?php echo $idage; ?>";
    const chunkSize = 5 * 1024 * 1024;
    const totalChunks = Math.ceil(file.size / chunkSize);
    const fileId = Date.now() + "_" + Math.random().toString(36).substring(2);

    const originalName = file.name;
    const extension = originalName.substring(originalName.lastIndexOf('.') + 1);
    const finalName = nomInput.value.trim().replace(/\s+/g, "_") + "." + extension;

    // Mostrar barra
    progressContainer.style.display = "block";
    progressBar.style.width = "0%";
    progressBar.innerText = "0%";
    progressText.innerText = "Iniciando subida...";

    for (let i = 0; i < totalChunks; i++) {

        const start = i * chunkSize;
        const end = Math.min(start + chunkSize, file.size);
        const chunk = file.slice(start, end);

        const formData = new FormData();
        formData.append("chunk", chunk);
        formData.append("chunk_index", i);
        formData.append("total_chunks", totalChunks);
        formData.append("file_id", fileId);
        formData.append("filename", finalName);
        formData.append("product_id", productId);

        const response = await fetch("utils/upload_chunk.php", {
            method: "POST",
            body: formData
        });

        const data = await response.json();

        if (!data.success) {
            alert("Error al subir archivo");
            progressContainer.style.display = "none";
            return;
        }

        const percent = Math.round(((i + 1) / totalChunks) * 100);
        progressBar.style.width = percent + "%";
        progressBar.innerText = percent + "%";
        progressText.innerText = `Subiendo archivo... (${i + 1}/${totalChunks})`;
    }

    progressText.innerText = "✅ Subida completada";

    // Ocultar después de 1.5 segundos
    setTimeout(() => {
        progressContainer.style.display = "none";
    }, 1500);

    alert("Archivo subido correctamente");
    location.reload();
}
</script>



<?php include 'footer.php'; ?>