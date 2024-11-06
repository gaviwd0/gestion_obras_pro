<?php
// Incluir la conexión a la base de datos
require_once '../../config/conn.php';

// Establecer el número de obras por página
$limit = 4;

// Obtener el número de la página actual
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Obtener el término de búsqueda
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Construir la consulta SQL con filtro de búsqueda
$sql = "SELECT * FROM obras WHERE nombre_obra LIKE :search ORDER BY fecha_inicio DESC LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($sql);
$searchParam = "%" . $search . "%"; // Agregar comodines para la búsqueda
$stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$obras = $stmt->fetchAll();

// Obtener el total de obras para calcular el número de páginas
$total_sql = "SELECT COUNT(*) FROM obras WHERE nombre_obra LIKE :search";
$total_stmt = $pdo->prepare($total_sql);
$total_stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
$total_stmt->execute();
$total_obras = $total_stmt->fetchColumn();
$total_pages = ceil($total_obras / $limit);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Obras</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../public/css/style_formObras.css"> <!-- Enlace al archivo CSS -->
    <style>
    .custom-search {
        width: 400px; /* Ajusta el ancho según tus necesidades */
        font-size: 1rem; /* Aumenta el tamaño de la fuente */
    }
</style>
</head>


<body>
    <?php  include '../components/navbar.php'; ?>
    <div class="container mt-2">
        <!-- Formulario de búsqueda -->
        <div class="container mt-12 mb-2">
            <form action="" method="GET" class="d-flex justify-content-center">
                <input type="text" name="search" class="form-control custom-search " placeholder="Buscar por nombre de obra" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            </form>
        </div>

        <div class="row">
            <?php if (count($obras) > 0): ?>
                <?php foreach($obras as $obra): ?>
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($obra['nombre_obra']); ?></h5>
                                <p class="card-text">Ubicación: <?php echo htmlspecialchars($obra['ubicacion']); ?></p>
                                <p class="card-text">Contratista: <?php echo htmlspecialchars($obra['contratista']); ?></p>
                                <p class="card-text">Responsable: <?php echo htmlspecialchars($obra['responsable_id']); ?></p>
                                <p class="card-text">Fecha de inicio: <?php echo htmlspecialchars($obra['fecha_inicio']); ?></p>
                                <p class="card-text">Presupuesto: $<?php echo number_format($obra['presupuesto'], 2); ?></p>
                                <a href="ver_obra.php?id=<?php echo $obra['obra_id']; ?>" class="btn btn-primary">Ver Detalles</a>
                                <a href="editar_obra.php?id=<?php echo $obra['obra_id']; ?>" class="btn btn-warning">Editar</a>
                                <a href="eliminar_obra.php?id=<?php echo $obra['obra_id']; ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar esta obra?');">Eliminar</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">No hay obras registradas.</p>
            <?php endif; ?>
        </div>

        <!-- Paginación -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center mt-4">
                <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $page - 1; ?>&search=<?php echo htmlspecialchars($search); ?>">Anterior</a>
                </li>
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo htmlspecialchars($search); ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?php echo $page >= $total_pages ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $page + 1; ?>&search=<?php echo htmlspecialchars($search); ?>">Siguiente</a>
                </li>
            </ul>
        </nav>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>