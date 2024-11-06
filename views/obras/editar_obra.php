<?php
// editar_obra.php
require_once '../../config/conn.php';

if (isset($_GET['id'])) {
    $obra_id = $_GET['id'];

    // Obtener la obra de la base de datos
    $stmt = $pdo->prepare("SELECT * FROM obras WHERE obra_id = :id");
    $stmt->bindParam(':id', $obra_id, PDO::PARAM_INT);
    $stmt->execute();
    $obra = $stmt->fetch();

    if ($obra) {
        // Mostrar el formulario de edición
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Editar Obra</title>
            <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body>
            <div class="container mt-5">
                <h2>Editar Obra</h2>
                <form action="actualizar_obra.php" method="POST">
                    <input type="hidden" name="obra_id" value="<?php echo $obra['obra_id']; ?>">
                    <div class="form-group">
                        <label for="nombre_obra">Nombre de la Obra</label>
                        <input type="text" class="form-control" id="nombre_obra" name="nombre_obra" value="<?php echo htmlspecialchars($obra['nombre_obra']); ?>" required>
                    </div>
                    <!-- Agrega más campos según sea necesario -->
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </form>
            </div>
        </body>
        </html>
        <?php
    } else {
        echo "Obra no encontrada.";
    }
} else {
    echo "ID de obra no especificado.";
}
?>