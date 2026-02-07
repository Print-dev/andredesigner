</body>

<script>
        // Carrusel automático de imágenes
        let currentImageIndex = 0;
        const images = document.querySelectorAll('.circle img');
        const totalImages = images.length;

        function changeImage() {
            // Remover clase active de la imagen actual
            images[currentImageIndex].classList.remove('active');
            
            // Calcular siguiente índice
            currentImageIndex = (currentImageIndex + 1) % totalImages;
            
            // Agregar clase active a la nueva imagen
            images[currentImageIndex].classList.add('active');
        }

        // Cambiar imagen cada 2 segundos (2000 milisegundos)
        setInterval(changeImage, 2000);
        
        const mobileOverlay = document.getElementById('mobileOverlay');

        mobileOverlay.addEventListener('click', () => {
            mobileOverlay.classList.remove('active');
        });

        // Mobile dropdown toggle
        /* if (window.innerWidth <= 768) {
            const hasDropdown = document.querySelectorAll('.has-dropdown');
            
            hasDropdown.forEach(item => {
                const link = item.querySelector('.menu-link');
                
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    item.classList.toggle('open');
                });
            });
        } */

        // Re-initialize on window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                mobileOverlay.classList.remove('active');
            }
        });
        /* const navbar = document.querySelector('.navbar');
        const heroSection = document.querySelector('.contenedor-general').parentElement;

        window.addEventListener('scroll', () => {
            const heroHeight = heroSection.offsetHeight;
            const currentScrollY = window.scrollY;
            
            // Mostrar navbar cuando salgas de la primera sección (hero)
            if (currentScrollY > heroHeight - 100) {
                navbar.classList.add('visible');
            } else {
                navbar.classList.remove('visible');
            }
            
            // Agregar sombra extra cuando se hace más scroll
            if (currentScrollY > heroHeight + 200) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Verificar posición al cargar la página
        const heroHeight = heroSection.offsetHeight;
        if (window.scrollY > heroHeight - 100) {
            navbar.classList.add('visible');
        } */
    </script>
</html>