<?php 
date_default_timezone_set('America/Lima');
if(!$_SESSION['nomcli']){
    header('location:intranet.php');
}
include 'cn.php'; 

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <title>Admin - Vega Producciones</title>
    <link rel="shortcut icon" href="assets/logo.png" type="image/x-icon">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
            ::selection {
            background: hsl(47.9, 97.2%, 53.6%); /* Color de fondo cuando seleccionas */
            color: #000;         /* Color del texto seleccionado */
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: #333;
        }
        input[type="text"],
        input[type="email"],
        input[type="number"],
        input[type="date"],
        input[type="password"],
        input[type="tel"],
        input[type="time"],
        input[type="url"],
        select,
        textarea {
            height: 40px;
            padding: 10px;
            border: 1px solid #dbdbdb;
            border-radius: 5px;
            width: 100%;
            background: #fff;
            transition: all 0.3s ease;            
        }
        
        /* ESTADO FOCUS */
        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="number"]:focus,
        input[type="date"]:focus,
        input[type="password"]:focus,
        input[type="tel"]:focus,
        input[type="url"]:focus,
        input[type="time"]:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #4299e1;
            border: 1px solid #707070;
            box-shadow: 0 0 0 1px rgba(66, 153, 225, 0.2);
        }
        .header {
            background: #ffffffff;
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 60px;
            z-index: 9999999999999999;
            box-shadow: 2px 6px 2px 0px rgb(69 65 78 / 5%);
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .menu-toggle {
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            display: none;
        }

        .logo {
            font-weight: bold;
            font-size: 1.2rem;
        }

        .user-menu {
            position: relative;
        }

        .user-btn {
            /* background: #ffdf00; */
            border: none;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1.2rem;
            transition: background 0.2s;
        }

        .user-btn:hover {
            background: #2c3e50;
        }

        .dropdown-menu {
            position: absolute;
            top: 50px;
            right: 0;
            background: white;
            border: 1px solid #ddd;
            border-radius: 4px;
            min-width: 180px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            display: none;
            z-index: 200;
        }

        .dropdown-menu.active {
            display: block;
        }

        .dropdown-menu a {
            display: block;
            padding: 0.75rem 1rem;
            color: #333;
            text-decoration: none;
            border-bottom: 1px solid #eee;
            cursor: pointer;
            transition: background 0.2s;
        }

        .dropdown-menu a:last-child {
            border-bottom: none;
        }

        .dropdown-menu a:hover {
            background: #f5f5f5;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 60px;            
            bottom: 0;
            width: 250px;
            background: #ffffffff;
            color: gray;
            overflow-y: auto;
            transition: width 0.3s ease;
            /*z-index: 99;*/
            z-index: 999999999;
            border-left: 1px solid #ebebeb;
            box-shadow: 6px 0 10px -3px rgba(69, 65, 78, 0.1);
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar.collapsed:hover {
            width: 250px;
        }

        .sidebar-header {
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-header h3 {
            font-size: 0.9rem;
            font-weight: 600;
        }

        .sidebar.collapsed .sidebar-header h3 {
            display: none;
        }

        .sidebar.collapsed:hover .sidebar-header h3 {
            display: block;
        }

        .collapse-btn {
            background: none;
            border: none;
            color: black;
            font-size: 1.2rem;
            cursor: pointer;
            padding: 0.25rem 0.5rem;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0.5rem 0;
        }

        .menu-item {
            position: relative;
        }

        .menu-link {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.75rem 1rem;
            color: rgb(0 0 0 / 80%);
            text-decoration: none;
            transition: all 0.2s;
            cursor: pointer;
            font-size: 0.9rem;
        }
        .menu-link:hover{
            background-color: #0000000d;
            border-radius: 10px;
        }
        .menu-link span:hover {
            font-weight: 600;
        }

        .menu-link.active {
            /* background: rgba(199, 199, 199, 0.2); */
            background: #000000;
            color: white;
            border-left: 0px solid #fdda17;
            border-radius: 5px;
            font-weight: 700;
        }

        .menu-icon {
            min-width: 24px;
            text-align: center;
            font-size: 1.1rem;
        }

        .menu-text {
            flex: 1;
            white-space: nowrap;
            color: #333; /* Color normal (gris oscuro) */
            transition: color 0.2s;
        }

        .menu-link.active .menu-text {
            color: white !important; /* Blanco cuando está activo */
        }

        .menu-icon {
            min-width: 24px;
            text-align: center;
            font-size: 1.1rem;
            color: #333; /* Color normal para el ícono */
        }

        .menu-link.active .menu-icon {
            color: white !important; /* Blanco cuando está activo */
        }

        .sidebar.collapsed .menu-text {
            display: none;
        }

        .sidebar.collapsed:hover .menu-text {
            display: inline;
        }

        .dropdown-arrow {
            font-size: 0.75rem;
            transition: transform 0.2s;
        }

        .submenu {
            list-style: none;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s;
        }

        .submenu.open {
            max-height: 500px;
        }

        .submenu-item a {
            display: block;
            padding: 0.5rem 1rem 0.5rem 2.5rem;
            color: rgba(59, 59, 59, 0.7);
            text-decoration: none;
            font-size: 0.85rem;
            transition: all 0.2s;
        }
        .submenu-item a:hover {
            color: black;
            font-weight: 600;
        }

        .sidebar.collapsed .submenu {
            max-height: 0;
            overflow: hidden;
            display: none;
        }

        .sidebar.collapsed:hover .submenu.open {
            max-height: 500px;
            overflow: visible;
            display: block;
        }

        .main-content {
            margin-left: 250px;
            margin-top: 60px;
            transition: margin-left 0.3s;
        }

        .main-content.expanded {
            margin-left: 80px;
        }

        .card {
            background: white;
            border-radius: 4px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .card h2 {
            font-size: 1.1rem;
            margin-bottom: 1rem;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            display: none;
            z-index: 98;
        }

        .overlay.active {
            display: block;
        }

        @media (max-width: 768px) {
            .menu-toggle {
                display: block;
                color: black;
            }

            .sidebar {
                transform: translateX(-100%);
                width: 250px;
                transition: transform 0.3s ease;
            }

            .sidebar.collapsed {
                width: 250px;
                transform: translateX(-100%);
            }

            .sidebar.collapsed:hover {
                width: 250px;
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .sidebar.collapsed.open {
                transform: translateX(0);
                width: 85px;
            }

            .sidebar.collapsed.open:hover {
                transform: translateX(0);
                width: 250px;
            }

            .main-content {
                margin-left: 0;
            }

            .main-content.expanded {
                margin-left: 0;
            }

            .overlay {
                display: none !important;
            }
            .collapse-btn{display:none;}
            input[type="text"],
            input[type="email"],
            input[type="number"],
            input[type="date"],
            input[type="password"],
            input[type="tel"],
            input[type="time"],
            input[type="url"],
            select,
            textarea {
                font-size: x-small;          
            }
        }
        .sidebar.collapsed .collapse-btn {
            display: none;
        }

        .sidebar.collapsed:hover .collapse-btn {
            display: block;
        }
        .collapse-btn::before {
            content: "<";
        }

        .sidebar.collapsed .collapse-btn::before {
            content: ">";
        }
    </style>
    
</head>
<body>
    <header class="header">
        <div class="header-left">
            <button class="menu-toggle" id="mobileMenuToggle">☰</button>            
        </div>
        <div class="user-menu">
            <button class="user-btn" style="background-color:<?php echo $_SESSION['color'] ?? null; ?>;" id="userBtn"><?php echo substr($_SESSION['nomcli'], 0, 1); ?></button>
            <div class="dropdown-menu" id="userDropdown">
                <a><i class="bi bi-gear-fill"></i> Configuración</a>
                <a href="logout.php">🚪 Cerrar Sesión</a>
            </div>
        </div>
    </header>

    <div class="overlay" id="overlay"></div>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <!-- <h3>Menú</h3> -->
             <img src="andre4kp.png" width="48px">
            <button class="collapse-btn" id="collapseBtn"></button>
        </div>
        <ul class="sidebar-menu" style="margin-left: 10px;margin-right: 10px;">
            <li class="menu-item">
                <a class="menu-link <?php echo ($_SESSION['current_page'] ?? '') == 'dashboard' ? 'active' : ''; ?>" href="dashboard.php" data-page="dashboard">
                    <span class="menu-icon"><i class="bi bi-pie-chart-fill"></i></span>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>
            <li class="menu-item">
                <a class="menu-link <?php echo ($_SESSION['current_page'] ?? '') == 'inicio' ? 'active' : ''; ?>" href="inicio.php" data-page="inicio">
                    <span class="menu-icon"><i class="bi bi-box-seam-fill"></i></span>
                    <span class="menu-text">Inicio</span>
                </a>
            </li>
            <li class="menu-item">
                <a class="menu-link <?php echo ($_SESSION['current_page'] ?? '') == 'servicios' ? 'active' : ''; ?>" href="servicios.php" data-page="servicios">
                    <span class="menu-icon"><i class="bi bi-box-seam-fill"></i></span>
                    <span class="menu-text">Servicios</span>
                </a>
            </li>
            <li class="menu-item">
                <a class="menu-link <?php echo ($_SESSION['current_page'] ?? '') == 'agenda' ? 'active' : ''; ?>" href="agenda.php" data-page="agenda">
                    <span class="menu-icon"><i class="bi bi-calendar2-event-fill"></i></span>
                    <span class="menu-text">Agenda</span>
                </a>
            </li>
            <li class="menu-item">
                <a class="menu-link <?php echo ($_SESSION['current_page'] ?? '') == 'cupones' ? 'active' : ''; ?>" href="cupones.php" data-page="cupones">
                    <span class="menu-icon"><i class="bi bi-ticket-fill"></i></span>
                    <span class="menu-text">Cupones</span>
                </a>
            </li>
            <li class="menu-item">
                <a class="menu-link <?php echo ($_SESSION['current_page'] ?? '') == 'egresos' ? 'active' : ''; ?>" onclick="toggleSubmenu(event)"  data-page="egresos">
                    <span class="menu-icon"><i class="bi bi-cash-coin"></i></span>
                    <span class="menu-text">Movimiento</span>
                    <span class="dropdown-arrow">▼</span>
                </a>
                <ul class="submenu" id="configSubmenu">
                    <li class="submenu-item"><a href="gastos.php">Gastos</a></li>                    
                    <li class="submenu-item"><a href="ingresos.php">Ingresos</a></li>                    
                </ul>
            </li>            
            <!-- <li class="menu-item">
                <a class="menu-link <?php echo ($_SESSION['current_page'] ?? '') == 'ventas' ? 'active' : ''; ?>" onclick="toggleSubmenu(event)"  data-page="ventas">
                    <span class="menu-icon"><i class="bi bi-pie-chart-fill"></i></span>
                    <span class="menu-text">Ventas</span>
                    <span class="dropdown-arrow">▼</span>
                </a>
                <ul class="submenu" id="configSubmenu">
                    <li class="submenu-item"><a href="cotizaciones.php">Cotizaciones</a></li>
                    <li class="submenu-item"><a href="tarifario.php">Tarifario</a></li>
                </ul>
            </li> -->
            
        </ul>
    </aside>

    <main class="main-content" id="mainContent">
        