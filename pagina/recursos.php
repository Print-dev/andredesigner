<?php include 'head.php';  ?> 
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interfaz de Búsqueda - Filtros</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
            padding: 20px;
            min-height: 100vh;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 25px;
        }
        
        header {
            background-color: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        
        .search-container {
            position: relative;
            margin-bottom: 5px;
        }
        
        .search-container h1 {
            color: #2c3e50;
            font-size: 28px;
            margin-bottom: 15px;
        }
        
        .search-bar {
            display: flex;
            align-items: center;
            background-color: #f8f9fa;
            border-radius: 50px;
            padding: 15px 25px;
            border: 1px solid #e0e0e0;
            transition: all 0.3s ease;
        }
        
        .search-bar:focus-within {
            border-color: #4a6cf7;
            box-shadow: 0 0 0 3px rgba(74, 108, 247, 0.1);
        }
        
        .search-bar i {
            color: #6c757d;
            font-size: 18px;
            margin-right: 15px;
        }
        
        .search-bar input {
            border: none;
            background: transparent;
            width: 100%;
            font-size: 16px;
            color: #333;
            outline: none;
        }
        
        .search-bar input::placeholder {
            color: #999;
        }
        
        .main-content {
            display: flex;
            gap: 25px;
        }
        
        .filters-section {
            flex: 0 0 280px;
        }
        
        .filters-panel {
            background-color: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
        }
        
        .filters-panel h2 {
            color: #2c3e50;
            font-size: 20px;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        
        .filter-group {
            margin-bottom: 25px;
        }
        
        .filter-group h3 {
            color: #495057;
            font-size: 16px;
            margin-bottom: 15px;
            font-weight: 600;
        }
        
        .filter-option {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
            cursor: pointer;
            padding: 5px 0;
            transition: color 0.2s;
        }
        
        .filter-option:hover {
            color: #4a6cf7;
        }
        
        .checkbox {
            width: 18px;
            height: 18px;
            border: 2px solid #ddd;
            border-radius: 4px;
            margin-right: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }
        
        .filter-option:hover .checkbox {
            border-color: #4a6cf7;
        }
        
        .filter-option.active .checkbox {
            background-color: #4a6cf7;
            border-color: #4a6cf7;
        }
        
        .filter-option.active .checkbox::after {
            content: '✓';
            color: white;
            font-size: 12px;
        }
        
        .results-section {
            flex: 1;
        }
        
        .categories-panel, .resources-panel {
            background-color: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
        }
        
        .category-list, .resource-list {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }
        
        .category-item, .resource-item {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 12px 20px;
            color: #495057;
            font-size: 15px;
            transition: all 0.3s;
            cursor: pointer;
            border: 1px solid transparent;
        }
        
        .category-item:hover, .resource-item:hover {
            background-color: #edf2ff;
            color: #4a6cf7;
            border-color: #4a6cf7;
        }
        
        .category-item.active, .resource-item.active {
            background-color: #4a6cf7;
            color: white;
        }
        
        .category-item.duplicate {
            opacity: 0.7;
        }
        
        @media (max-width: 768px) {
            .main-content {
                flex-direction: column;
            }
            
            .filters-section {
                flex: 1;
            }
        }
        
        footer {
            text-align: center;
            padding: 20px;
            color: #6c757d;
            font-size: 14px;
            margin-top: 20px;
        }
        
        footer a {
            color: #4a6cf7;
            text-decoration: none;
        }

        .contenedor-recursos {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }

        .recurso-card {
            background: #111;
            border-radius: 10px;
            overflow: hidden;
            text-align: center;
        }

        .recurso-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            display: block;
        }

        .recurso-card p {
            padding: 10px;
            font-size: 14px;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container" style="margin-top: 30px;">
        <!-- <header>
            <div class="search-container">
                <h1>Quiero buscar...</h1>
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="¿Qué estás buscando hoy?">
                </div>
            </div>
        </header> -->        
        <div class="main-content">
            <script>
                function buscaritem(item){
                    console.log("buscando...");
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
                            document.querySelector("#contenido-vendible").innerHTML = resultado;
                        }).catch(error => {
                            console.error('Error:', error);
                            alert('Error al cargar los datos');
                        });
                    }                    
            </script>
            <aside class="filters-section">
                <div class="filters-panel">
                    <h2>Buscar</h2>
                    <div class="search-bar">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="¿Qué estás buscando hoy?" onkeyup="buscaritem(this.value)">
                    </div>
                </div>
                <div class="filters-panel">
                    <h2>Filtros</h2>
                    
                    <div class="filter-group">
                        <h3>Precio</h3>
                        <div class="filter-option active">
                            <div class="checkbox"></div>
                            <span>Menos costoso</span>
                        </div>
                    </div>
                    
                    <div class="filter-group">
                        <h3>Ofertas</h3>
                        <div class="filter-option active">
                            <div class="checkbox"></div>
                            <span>En ofertas</span>
                        </div>
                    </div>
                </div>
                
                <div class="categories-panel">
                    <h2>Categorías</h2>
                    <div class="category-list">
                        <div class="category-item">Eventos</div>
                        <div class="category-item active">Imprenta</div>
                        <div class="category-item">ETC</div>
                        <div class="category-item duplicate">Imprenta</div>
                    </div>
                </div>
                
                <div class="resources-panel">
                    <h2>Recursos</h2>
                    <div class="resource-list">
                        <div class="resource-item active">Diseños</div>
                        <div class="resource-item">Packs</div>
                    </div>
                </div>
            </aside>
            
            <section class="results-section">
                <div class="filters-panel">

                    <div class="contenedor-recursos" id="contenido-vendible">
                        <div class="recurso-card">
                            <img src="img1.jpg" alt="">
                            <p>Diseño 1</p>
                        </div>

                        <div class="recurso-card">
                            <img src="img2.jpg" alt="">
                            <p>Diseño 2</p>
                        </div>
                        <div class="recurso-card">
                            <img src="img2.jpg" alt="">
                            <p>Diseño 2</p>
                        </div>
                        <div class="recurso-card">
                            <img src="img2.jpg" alt="">
                            <p>Diseño 2</p>
                        </div>
                        <div class="recurso-card">
                            <img src="img2.jpg" alt="">
                            <p>Diseño 2</p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        
        <footer>
            <p>Interfaz recreada con HTML y CSS | <a href="#">Volver al inicio</a></p>
        </footer>
    </div>
</body>
</html>
