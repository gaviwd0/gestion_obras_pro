<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Obra</title>
    <!-- Bootstrap CSS desde CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php  include '../components/navbar.php'; ?>
    <div class="container mt-5">
        <h1>Modificar Obra</h1>
        
        <?php if (isset($obra)): ?>
            <form method="POST">
                <input type="hidden" name="obra_id" value="<?php echo $obra['obra_id']; ?>">
                <div class="form-group">
                    <label for="nombre_obra">Nombre de la Obra:</label>
                    <input type="text" class="form-control" id="nombre_obra" name="nombre_obra" value="<?php echo $obra['nombre_obra']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="ubicacion">Ubicación:</label>
                    <input type="text" class="form-control" id="ubicacion" name="ubicacion" value="<?php echo $obra['ubicacion']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="contratista">Contratista:</label>
                    <input type="text" class="form-control" id="contratista" name="contratista" value="<?php echo $obra['contratista']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="presupuesto">Presupuesto:</label>
                    <input type="number" class="form-control" id="presupuesto" name="presupuesto" value="<?php echo $obra['presupuesto']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="fecha_inicio">Fecha de Inicio:</label>
                    <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="<?php echo $obra['fecha_inicio']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="fecha_fin">Fecha de Fin:</label>
                    <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" value="<?php echo $obra['fecha_fin']; ?>" required>
                </div>
                <button type="submit" name="editar_obra" class="btn btn-primary">Guardar Cambios</button>
            </form>
        <?php else: ?>
            <div class="alert alert-danger mt-3" role="alert">
                No se pudo encontrar la obra que deseas modificar.
            </div>
        <?php endif; ?>

        <h2 class="mt-5">Etapas</h2>
        <form method="POST" class="mb-4">
            <div class="form-group">
                <label for="nombre_etapa">Nombre de la Etapa:</label>
                <input type="text" class="form-control" id="nombre_etapa" name="nombre_etapa" required>
            </div>
            <div class="form-group">
                <label for="fecha_inicio_etapa">Fecha de Inicio:</label>
                <input type="date" class="form-control" id="fecha_inicio_etapa" name="fecha_inicio_etapa" required>
            </div>
            <div class="form-group">
                <label for="fecha_fin_etapa">Fecha de Fin:</label>
                <input type="date" class="form-control" id="fecha_fin_etapa" name="fecha_fin_etapa" required>
            </div>
            <div class="form-group">
                <label for="descripcion_etapa">Descripción:</label>
                <textarea class="form-control" id="descripcion_etapa" name="descripcion_etapa" required></textarea>
            </div>
            <button type="submit" name="agregar_etapa" class="btn btn-success">Agregar Etapa</button>
        </form>

        <h2>Notas</h2>
        <form method="POST" class="mb-4">
            <div class="form-group">
                <label for="contenido_nota">Contenido de la Nota:</label>
                <textarea class="form-control" id="contenido_nota" name="contenido_nota" required></textarea>
            </div>
            <input type="hidden ```php
" name="usuario_id" value="<?php echo $_SESSION['usuario_id']; ?>">
            <button type="submit" name="agregar_nota" class="btn btn-info">Agregar Nota</button>
        </form>

        <h3>Lista de Etapas</h3>
        <ul class="list-group">
            <?php if (!empty($etapas)): ?>
                <?php foreach ($etapas as $etapa): ?>
                    <li class="list-group-item">
                        <?php echo $etapa['nombre_etapa']; ?> (Desde: <?php echo $etapa['fecha_inicio']; ?> - Hasta: <?php echo $etapa['fecha_fin']; ?>)
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li class="list-group-item">No hay etapas registradas para esta obra.</li>
            <?php endif; ?>
        </ul>

        <h3>Lista de Notas</h3>
        <ul class="list-group">
            <?php if (!empty($notas)): ?>
                <?php foreach ($notas as $nota): ?>
                    <li class="list-group-item">
                        <?php echo $nota['contenido']; ?> - <small><?php echo $nota['fecha_nota']; ?></small>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li class="list-group-item">No hay notas registradas para esta obra.</li>
            <?php endif; ?>
        </ul>
    </div>

    <!-- Bootstrap JS y dependencias desde CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>