<?php
// Incluir la conexión a la base de datos
require_once '../../config/conn.php';

// Obtener las últimas 4 obras
$sql = "SELECT * FROM obras ORDER BY fecha_inicio DESC LIMIT 4";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$obras = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Obras</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../public/css/style_formObras.css"> <!-- Enlace al archivo CSS -->
</head>

<body>
    <?php  include '../components/navbar.php'; ?>
    <h2 class="text-center">Últimas Obras</h2>
    <div class="container mt-5">
        
        <div class="row">
            <?php if (count($obras) > 0): ?>
                <?php foreach($obras as $obra): ?>
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-center font-weight-bold"><?php echo htmlspecialchars($obra['nombre_obra']); ?></h5>
                                <p class="card-text">Ubicación: <?php echo htmlspecialchars($obra['ubicacion']); ?></p>
                                <p class="card-text">Contratista: <?php echo htmlspecialchars($obra['contratista']); ?></p>
                                <p class="card-text">Responsable: <?php echo htmlspecialchars($obra['responsable_id']); ?></p>
                                <p class="card-text">Fecha de inicio: <?php echo htmlspecialchars($obra['fecha_inicio']); ?></p>
                                <p class="card-text">Presupuesto: $<?php echo number_format($obra['presupuesto'], 2); ?></p>
                                <div class="d-flex justify-content-center ">
                                    <a href="ver_obra.php?id=<?php echo $obra['obra_id']; ?>" class="m-2 btn btn-primary">Ver Detalles</a>
                                    <a href="modificar_obra.php?id=<?php echo $obra['obra_id']; ?>" class="m-2 btn btn-warning">Modificar</a>
                                    <a href="eliminar_obra.php?id=<?php echo $obra['obra_id']; ?>" class="m-2 btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar esta obra?');">Eliminar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">No hay obras registradas.</p>
            <?php endif; ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>