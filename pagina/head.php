<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../blite.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>                                                         
<style>
    body{
        background-color: black;
        font-family: 'Montserrat', sans-serif;
    }
    .contenedor-general{
         min-height: 100vh;
            background: #000;
            color: white;
            position: relative;
            display: flex;
            align-items: center;
            overflow: hidden;
    }
    .buttons-container {
        display: flex;
        gap: 1.5rem;
        margin: 3rem 0;
    }
    .heading {
            font-size: 2rem;
            font-weight: 400;
            line-height: 1.2;
            margin-bottom: 1rem;
            color: white;
        }

        .highlight {
            color: #00ff88;
            font-weight: 700;
            display: block;
        }

    .btn {
        padding: 16px 40px;
        font-size: 1rem;
        border: 2px solid white;
        background: transparent;
        color: white;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }
    .btn:hover {
        /* background: #ffffff27;
        color: white; */
        background: #ffffffff;
        color: black;
        transform: translateY(-2px);
    }
    .btn-white {
            padding: 15px 23px;
    font-size: 1rem;
    border: 2px solid black;
    background: transparent;
    color: black;
    border-radius: 30px;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
    }
    .btn-white:hover {
        /* background: #ffffff27;
        color: white; */
        background: #000000ff;
        color: white;
        transform: translateY(-2px);
    }
        .social-icons {
            display: flex;
            gap: 1.5rem;
            margin-top: 4rem;
        }
        .social-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .social-icon:hover {
            background: white;
            color: #000;
            transform: translateY(-3px);
        }
        /* .right-content {
            flex: 1;
            position: relative;
            height: 50vh;
            display: flex;
            align-items: center;
            justify-content: flex-end;
        } */
        .circle {
            width: 800px;
            height: 800px;
            background: linear-gradient(to bottom, #110227, #2f60d4);
            /* 2f89d4 */
            border-radius: 50%;
            position: absolute;
            /* right: 200px; */
            animation: float 6s ease-in-out infinite;
            overflow: hidden;
            transform: translateY(-174px);
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(-150px);
            }
            50% {
                transform: translateY(-174px);
            }
        }
        .circle img {
            /* width: 100%;
            height: 100%; */
                width: 500px;
            margin-left: 130px;
            margin-top: 100px;
            object-fit: cover;
            position: absolute;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }

        .circle img.active {
            opacity: 1;
        }

        /*  ************************************** SECCION 2 (MUESTRA) ************************************* */
        .galeria-muestra {
            display: flex;
            gap: 2rem;
            justify-content: center;
            flex-wrap: wrap;
            padding: 2rem 0;
        }

        .muestra-item {
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.4s ease;
        }

        .muestra-item img {
            width: 270px;
            /* height: 270px; */
            object-fit: cover;
            display: block;
            transition: transform 0.4s ease;
        }

        .muestra-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 255, 136, 0.3);
        }

        .muestra-item:hover img {
            transform: scale(1.1);
        }

        /* Overlay en hover */
        .muestra-item::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(0, 255, 136, 0.3), rgba(0, 0, 0, 0.3));
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .muestra-item:hover::after {
            opacity: 1;
        }
    
    /* *********************************** ENCABZADO **************************** */
    .navbar {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    background: rgba(0, 0, 0, 0.95);
    backdrop-filter: blur(10px);
    padding: 0 50px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    height: 80px;
    z-index: 1000;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    
    /* Efectos de aparición */
    /* opacity: 0;
    transform: translateY(-100%);
    transition: opacity 0.5s ease, transform 0.5s ease;
    pointer-events: none; */
}

/* .navbar.visible {
    opacity: 1;
    transform: translateY(0);
    pointer-events: all;
}

.navbar.scrolled {
    box-shadow: 0 2px 20px rgba(0, 0, 0, 0.5);
} */

/* Responsive Hero Section */
@media (max-width: 992px) {
    .contenedor-general {
        min-height: auto;
        padding: 100px 0 50px;
    }

    .contenedor-general .container {
        padding: 0 20px;
    }

    .contenedor-general .row {
        flex-direction: column-reverse;
    }

    .contenedor-general .col-md-6 {
        width: 100%;
    }

    /* Círculo responsive */
    .circle {
        width: 350px;
        height: 350px;
        position: relative;
        margin: 0 auto 40px;
        transform: translateY(0);
    }

    .circle img {
        width: 200px;
        margin-left: 70px;
        margin-top: 70px;
    }

    @keyframes float {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-20px);
        }
    }

    /* Texto hero responsive */
    .heading {
        font-size: 1.8rem;
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .heading .highlight {
        font-size: 2rem;
    }

    /* Logo responsive */
    .contenedor-general img[alt="Logo"] {
        display: block;
        margin: 0 auto 20px;
    }

    /* Botones responsive */
    .buttons-container {
        flex-direction: column;
        gap: 1rem;
        margin: 2rem 0;
    }

    .btn {
        width: 100%;
        text-align: center;
        padding: 14px 30px;
        font-size: 0.95rem;
    }

    /* Social icons responsive */
    .social-icons {
        justify-content: center;
        margin-top: 2rem;
        gap: 1rem;
    }

    .social-icon {
        width: 45px;
        height: 45px;
        font-size: 1.3rem;
    }
}

@media (max-width: 576px) {
    .contenedor-general {
        padding: 80px 0 30px;
    }

    .circle {
        width: 280px;
        height: 280px;
    }

    .circle img {
        width: 160px;
        margin-left: 55px;
        margin-top: 55px;
    }

    .heading {
        font-size: 1.5rem;
    }

    .heading .highlight {
        font-size: 1.8rem;
    }

    .btn {
        padding: 12px 25px;
        font-size: 0.9rem;
    }

    .social-icon {
        width: 40px;
        height: 40px;
        font-size: 1.2rem;
    }
}
    .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: #000;
            padding: 0 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 80px;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .logo img {
            height: 40px;
        }

        #menu-toggle {
            display: none;
        }

        .menu-icon {
            display: none;
            flex-direction: column;
            cursor: pointer;
            gap: 5px;
        }

        .bar {
            width: 25px;
            height: 3px;
            background: #fff;
            transition: 0.3s;
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 2rem;
            align-items: center;
        }

        .nav-links > li {
            position: relative;
        }

        .nav-links > li > a {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: color 0.3s;
            padding: 0.5rem 0;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .nav-links > li > a:hover {
            color: #00ff88;
        }

        /* Dropdown */
        .dropdown-label {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: color 0.3s;
            padding: 0.5rem 0;
            display: flex;
            align-items: center;
            gap: 0.3rem;
            cursor: pointer;
        }

        .dropdown-label:hover {
            color: #00ff88;
        }

        .has-dropdown .dropdown-label::after {
            content: '▼';
            font-size: 0.7rem;
            margin-left: 0.3rem;
            transition: transform 0.3s;
        }

        .has-dropdown:hover .dropdown-label::after {
            transform: rotate(180deg);
        }

        .has-dropdown input[type="checkbox"] {
            display: none;
        }

        .dropdown {
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: #1a1a1a;
            min-width: 220px;
            border-radius: 8px;
            padding: 0.5rem 0;
            opacity: 0;
            visibility: hidden;
            margin-top: 0.5rem;
            transition: all 0.3s;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
        }

        .has-dropdown:hover .dropdown {
            opacity: 1;
            visibility: visible;
        }

        .dropdown li {
            list-style: none;
        }

        .dropdown a {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.8rem 1.2rem;
            color: #fff;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s;
        }

        .dropdown a:hover {
            background: #2d2d2d;
            color: #00ff88;
            padding-left: 1.5rem;
        }

        .dropdown i {
            font-size: 1rem;
            width: 18px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .navbar {
                padding: 0 20px;
                height: 70px;
            }

            .logo img {
                height: 30px;
            }

            .menu-icon {
                display: flex;
            }

            #menu-toggle:checked ~ .menu-icon .bar:nth-child(1) {
                transform: rotate(-45deg) translate(-5px, 6px);
            }

            #menu-toggle:checked ~ .menu-icon .bar:nth-child(2) {
                opacity: 0;
            }

            #menu-toggle:checked ~ .menu-icon .bar:nth-child(3) {
                transform: rotate(45deg) translate(-5px, -6px);
            }

            .nav-links {
                position: fixed;
                top: 54px;
                left: -100%;
                width: 280px;
                height: calc(100vh - 70px);
                background: #000;
                flex-direction: column;
                align-items: flex-start;
                gap: 0;
                padding: 0;
                transition: left 0.3s;
                overflow-y: auto;
                border-right: 1px solid #333;
            }

            #menu-toggle:checked ~ .nav-links {
                left: 0;
            }

            .nav-links > li {
                width: 100%;
                border-bottom: 1px solid #222;
            }

            .nav-links > li > a {
                width: 100%;
                padding: 1.2rem 1.5rem;
                justify-content: space-between;
            }

            .dropdown-label {
                width: 100%;
                padding: 1.2rem 1.5rem;
                justify-content: space-between;
            }

            .has-dropdown .dropdown-label::after {
                content: '\f285';
            }

            /* Dropdown Mobile */
            .dropdown {
                position: static;
                opacity: 1;
                visibility: visible;
                transform: none;
                background: #0a0a0a;
                border-radius: 0;
                margin: 0;
                padding: 0;
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.4s;
                box-shadow: none;
            }

            .has-dropdown input:checked ~ .dropdown {
                max-height: 500px;
            }

            .has-dropdown input:checked ~ .dropdown-label::after {
                transform: rotate(180deg);
            }

            .dropdown a {
                padding: 1rem 1.5rem 1rem 3rem;
                font-size: 0.9rem;
            }

            .dropdown a:hover {
                padding-left: 3.5rem;
                background: #1a1a1a;
            }

            /* Scrollbar */
            .nav-links::-webkit-scrollbar {
                width: 6px;
            }

            .nav-links::-webkit-scrollbar-track {
                background: #000;
            }

            .nav-links::-webkit-scrollbar-thumb {
                background: #333;
                border-radius: 3px;
            }
        }

        /* Demo content */
        .content {
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .content h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        /* ******************************** SEPARADOR: PROCESOS ************************** */
         .proceso-card {
            background: rgba(26, 26, 26, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 2.5rem 2rem;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
            transition: all 0.4s ease;
            backdrop-filter: blur(10px);
            animation: fadeInUp 0.6s ease both;
        }

        .proceso-card:nth-child(1) { animation-delay: 0.1s; }
        .proceso-card:nth-child(2) { animation-delay: 0.2s; }
        .proceso-card:nth-child(3) { animation-delay: 0.3s; }
        .proceso-card:nth-child(4) { animation-delay: 0.4s; }
        .proceso-card:nth-child(5) { animation-delay: 0.5s; }
        .proceso-card:nth-child(6) { animation-delay: 0.6s; }

        .proceso-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 0;
            background: linear-gradient(180deg, #00ff88 0%, #00cc6e 100%);
            transition: height 0.4s ease;
        }

        .proceso-card:hover {
            transform: translateY(-10px);
            border-color: rgba(0, 255, 136, 0.3);
            background: rgba(26, 26, 26, 0.9);
            box-shadow: 0 10px 40px rgba(0, 255, 136, 0.2);
        }

        .proceso-card:hover::before {
            height: 100%;
        }

        .card-number {
            font-size: 4rem;
            font-weight: 800;
            background: linear-gradient(135deg, #00ff88 0%, #00cc6e 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1;
            margin-bottom: 1rem;
            transition: all 0.4s ease;
        }

        .proceso-card:hover .card-number {
            transform: scale(1.1);
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.8rem;
            color: #fff;
            transition: color 0.3s ease;
        }

        .proceso-card:hover .card-title {
            color: #00ff88;
        }

        .card-description {
            font-size: 1rem;
            color: #b0b0b0;
            line-height: 1.6;
        }
        .wave-divider {
            position: relative;
            height: 100px;
            background: #000;
        }

        .wave-divider svg {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100px;
        }
        .wave-divider-black {
            position: relative;
            height: 100px;
            background: #ffffffff;
        }

        .wave-divider-black svg {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100px;
        }

</style>
<body>
    <header class="header">
        <nav class="navbar">
            <a href="inicio.php" class="logo">
                <img src="../andre4kp.png" alt="Logo">
            </a>        
            
            <input type="checkbox" id="menu-toggle">        
            
            <label for="menu-toggle" class="menu-icon">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </label>
            
            <ul class="nav-links">
                <li class="has-dropdown">
                    <input type="checkbox" id="categorias-toggle">
                    <label for="categorias-toggle" class="dropdown-label">Categorías</label>
                    <ul class="dropdown">
                        <li>
                            <a href="#grabaciones">
                                <i class="bi bi-camera-video-fill"></i>
                                Grabaciones
                            </a>
                        </li>
                        <li>
                            <a href="#paginas-web">
                                <i class="bi bi-globe2"></i>
                                Páginas Web
                            </a>
                        </li>
                        <li>
                            <a href="recursos.php">
                                <i class="bi bi-palette-fill"></i>
                                Diseño Gráfico
                            </a>
                        </li>
                        <li>
                            <a href="#fotografia">
                                <i class="bi bi-camera-fill"></i>
                                Fotografía
                            </a>
                        </li>
                        <li>
                            <a href="#edicion">
                                <i class="bi bi-film"></i>
                                Edición de Video
                            </a>
                        </li>
                    </ul>
                </li>
                <li><a href="#grupo">Grupo</a></li>
                <li><a href="#contacto">Contáctame</a></li>
            </ul>
        </nav>      
    </header>
    <div class="mobile-overlay" id="mobileOverlay"></div>
    
    <!-- <section style="background-color: white;">
        <div class="container" style="color: white; " >
            <br>
            <span style="font-size: 2rem;font-weight: 600;color: #000;">Hazte Notar</span>
            <p style="color: #959595;">Nuestros servicios amplificarán tu alcance, ​construyen tu marca y conectan con tu audiencia. ​</p>        
        </div>
        <div class="container" style="color: white;">
            <div class="galeria-muestra">
                <div class="muestra-item">
                    <img src="muestra/m1.jpg" width="270" alt="">
                </div>
                <div class="muestra-item">
                    <img src="muestra/m2.jpg" width="270" alt="">
                </div>
                <div class="muestra-item">
                    <img src="muestra/m3.jpg" width="270" alt="">
                </div>                                
            </div>
        </div>
    </section> -->

