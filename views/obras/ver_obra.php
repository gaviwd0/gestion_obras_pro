<?php
// Incluir la conexión a la base de datos
require_once '../../config/conn.php';

if (isset($_GET['id'])) {
    $obra_id = $_GET['id'];
    $sql = "SELECT * FROM obras WHERE obra_id = :obra_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['obra_id' => $obra_id]);
    $obra = $stmt->fetch();

    if (!$obra) {
        echo "Obra no encontrada.";
        exit;
    }
} else {
    echo "ID de obra no especificado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la Obra</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <?php  include '../components/navbar.php'; ?>
    <div class="container mt-5">
        <h2 class="text-center"><?php echo htmlspecialchars($obra['nombre_obra']); ?></h2>
        <p><strong>Ubicación:</strong> <?php echo htmlspecialchars($obra['ubicacion']); ?></p>
        <p><strong>Contratista:</strong> <?php echo htmlspecialchars($obra['contratista']); ?></p>
        <p><strong>Presupuesto:</strong> $<?php echo number_format($obra['presupuesto'], 2); ?></p>
        <p><strong>Fecha de inicio:</strong> <?php echo htmlspecialchars($obra['fecha_inicio']); ?></p>
        <p><strong>Fecha de fin:</strong> <?php echo htmlspecialchars($obra['fecha_fin']); ?></p>
        <a href="editar_obra.php?id=<?php echo $obra['obra_id']; ?>" class="btn btn-warning">Editar</a>
        <a href="eliminar_obra.php?id=<?php echo $obra['obra_id']; ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar esta obra?');">Eliminar</a>
        <a href="board_obras.php" class="btn btn-secondary">Volver al listado</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>