<!-- navbar.php -->
<nav class="navbar navbar-expand-lg" style="background-color: #535353;">
    <a class="navbar-brand" href="#" style="font-weight: bold; color: white;">Gestión de Obras</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon" style="background-color: white;"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav"> <!-- mx-auto para centrar los enlaces -->
            <li class="nav-item">
                <a class="nav-link" href="../obras/board_obras.php">Tablero de Obras</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../obras/crear_obra.php">Crear Obra</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../obras/listado_obras.php">Listado de Obras</a>
            </li>
        </ul>
    </div>
</nav>

<style>
    .navbar {
        margin-bottom: 20px; 
    }
    .nav-link {
        font-size: 1.1rem; /* Aumenta el tamaño de la fuente de los enlaces */
        color: white; /* Color inicial de los enlaces */
        transition: color 0.3s, transform 0.3s; /* Transición suave para el color y la transformación */
    }
    .nav-link:hover {
        color: #ddd; /* Color más claro al pasar el mouse */
        transform: scale(1.1); /* Aumenta el tamaño del enlace al pasar el mouse */
    }
    .navbar-brand {
        font-size: 1.5rem; /* Aumenta el tamaño de la fuente del título */
    }
</style>