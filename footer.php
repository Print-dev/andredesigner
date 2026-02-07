</main>

    <script>
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const collapseBtn = document.getElementById('collapseBtn');
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const overlay = document.getElementById('overlay');
        const userBtn = document.getElementById('userBtn');
        const userDropdown = document.getElementById('userDropdown');

        // Toggle sidebar collapse
        collapseBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
            
            // Cerrar todos los submenús abiertos cuando se minimiza
            document.querySelectorAll('.submenu').forEach(menu => {
                menu.classList.remove('open');
            });
        });

        // Mobile menu toggle
        mobileMenuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('open');
            overlay.classList.toggle('active');
        });

        // Close sidebar when clicking on overlay
        overlay.addEventListener('click', () => {
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
        });

        // User dropdown toggle
        userBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            userDropdown.classList.toggle('active');
        });

        // Close user dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.user-menu')) {
                userDropdown.classList.remove('active');
            }
        });

        // Submenu toggle
        function toggleSubmenu(e) {
            const parent = e.currentTarget.parentElement;
            const submenu = parent.querySelector('.submenu');

            // Close other submenus
            document.querySelectorAll('.submenu').forEach(menu => {
                if (menu !== submenu) {
                    menu.classList.remove('open');
                }
            });

            submenu.classList.toggle('open');
        }

        // Logout function
        function logout() {
            alert('Sesión cerrada');
        }

        // Make menu links active
        document.querySelectorAll('.menu-link').forEach(link => {
            link.addEventListener('click', (e) => {
                if (!link.querySelector('.dropdown-arrow')) {
                    document.querySelectorAll('.menu-link').forEach(l => l.classList.remove('active'));
                    link.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>