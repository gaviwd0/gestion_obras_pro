<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Obra - Paso a Paso</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../public/css/style_formObras.css"> <!-- Enlace al archivo CSS -->
</head>

<body>
    <!-- barra de navegacion -->
    <?php  include '../components/navbar.php'; ?>
    <div id="alertContainer" class="alert alert-danger d-none" role="alert" style="opacity: 0.9;">
        <button type="button" class="close" aria-label="Close" onclick="closeAlert()">
            <span aria-hidden="true">&times;</span>
        </button>
        <span id="alertMessage"></span>
    </div>
    <div class="container mt-5">
        <!-- Paso 1: Información General de la Obra -->
        <div id="step-1" class="step">
            <h4 class="text-center mb-5">Información General de la Obra</h4>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nombre_obra" class="form-label">Nombre de la obra</label>
                    <input type="text" class="form-control" id="nombre_obra" placeholder="Ejemplo: Construcción de puente" required="">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="ubicacion" class="form-label">Ubicación</label>
                    <input type="text" class="form-control" id="ubicacion" placeholder="Ejemplo: Calle Principal, Ciudad" required="">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="contratista" class="form-label">Contratista</label>
                    <input type="text" class="form-control" id="contratista" placeholder="Ejemplo: Constructora XYZ" required="">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="responsable" class="form-label">Responsable</label>
                    <input type="text" class="form-control" id="responsable" placeholder="Ejemplo: Juan Pérez" required="">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="fecha_inicio" class="form-label">Fecha de inicio</label>
                    <input type="date" class="form-control" id="fecha_inicio" required="">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="fecha_estimada_fin" class="form-label">Fecha estimada de fin</label>
                    <input type="date" class="form-control" id="fecha_estimada_fin" required="">
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <div class="md-6 mb-3 text-center">
                    <label for="presupuesto" class="form-label">Presupuesto asignado</label>
                    <input type="number" class="form-control" id="presupuesto" placeholder="Ejemplo: 50000" required="">
                </div>
            </div>
        </div>

        <!-- Paso 2: Etapas de la Obra -->
        <div id="step-2" class="step hidden">
            <h4 class="text-center mb-5">Etapas de la Obra</h4>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nombre_etapa" class="form-label">Nombre de la etapa</label>
                    <input type="text" class="form-control" id="nombre_etapa" placeholder="Ejemplo: Fundaciones" required="">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="descripcion_etapa" class="form-label">Descripción de la etapa</label>
                    <textarea class="form-control" id="descripcion_etapa" placeholder="Descripción detallada de la etapa" required=""></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="fecha_inicio_etapa" class="form-label">Fecha de inicio de la etapa</label>
                    <input type="date" class="form-control" id="fecha_inicio_etapa" required="">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="fecha_fin_etapa" class="form-label">Fecha de fin de la etapa</label>
                    <input type="date" class="form-control" id="fecha_fin_etapa" required="">
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <div class="md-b mb-3 text-center">
                    <label for="estado_etapa" class="form-label">Estado de la etapa</label>
                    <select class="form-control" id="estado_etapa" required="">
                        <option value="">Seleccione un estado</option>
                        <option value="en_progreso">En progreso </option>
                        <option value="completada">Completada</option>
                        <option value="pendiente">Pendiente</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Paso 3: Notas y Documentos -->
        <div id="step-3" class="step hidden">
            <h4 class="text-center mb-5">Notas y Documentos</h4>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="notas" class="form-label">Notas adicionales</label>
                    <textarea class="form-control" id="notas" placeholder="Notas adicionales sobre la obra"></textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="documentos" class="form-label">Documentos adicionales</label>
                    <input type="file" class="form-control" id="documentos" multiple="">
                </div>
            </div>
        </div>

        <!-- Botones de navegación -->
        <div class="navigation-buttons d-flex justify-content-center">
            <button id="prevBtn" class="m-5 btn btn-secondary" onclick="prevStep()" style="display: none;">Anterior</button>
            <button id="nextBtn" class="m-5 btn btn-primary" onclick="nextStep()" style="display: inline;">Siguiente</button>
            <button id="submitBtn" class="m-5 btn btn-success" onclick="submitForm()" style="display: none;">Enviar</button>
        </div>

    </div>

    <script src="../../public/js/validacionFromCrear_obra.js"></script> <!-- Enlace al archivo JavaScript -->
</body>

</html>