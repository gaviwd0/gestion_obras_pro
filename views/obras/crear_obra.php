<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Obra</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="/public/css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Registro de Obra</h2>
        <form id="obra-form" action="/gestion_obras2/controllers/ControladorObra.php" method="POST" enctype="multipart/form-data">

            <!-- Información General de la Obra -->
            <h4 class="text-center">Información General de la Obra</h4>
            <div class="text-center mb-3">
                <label for="nombre_obra" class="form-label">Nombre de la obra</label>
                <input type="text" class="form-control input-max-width" id="nombre_obra" name="nombre_obra" required>
            </div>
            <div class="text-center mb-3">
                <label for="ubicacion" class="form-label">Ubicación</label>
                <input type="text" class="form-control input-max-width" id="ubicacion" name="ubicacion">
            </div>
            <div class="text-center mb-3">
                <label for="presupuesto" class="form-label">Presupuesto asignado</label>
                <input type="number" class="form-control input-max-width" id="presupuesto" name="presupuesto" required>
            </div>
            <div class="text-center mb-3">
                <label for="fecha_inicio" class="form-label">Fecha de inicio</label>
                <input type="date" class="form-control input-max-width" id="fecha_inicio" name="fecha_inicio" required>
            </div>
            <div class="text-center mb-3">
                <label for="fecha_estimada_fin" class="form-label">Fecha estimada de finalización</label>
                <input type="date" class="form-control input-max-width" id="fecha_estimada_fin" name="fecha_estimada_fin" required>
            </div>

            <!-- Notas de Campo -->
            <h4 class="text-center">Notas de Campo (opcional)</h4>
            <div class="text-center mb-3">
                <label for="notas" class="form-label">Registro de notas</label>
                <textarea class="form-control input-max-width" id="notas" name="notas" rows="4"></textarea>
            </div>
            <div class="text-center mb-3">
                <label for="documentos" class="form-label">Subir documentos</label>
                <input type="file" class="form-control input-max-width" id="documentos" name="documentos[]" multiple>
            </div>

            <!-- Botones de acción -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn -primary">Crear Obra</button>
                <button type="reset" class="btn btn-secondary">Limpiar</button>
            </div>
        </form>
    </div>
</body>

</html>