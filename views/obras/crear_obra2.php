<html lang="es"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Obra - Paso a Paso</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hidden {
            display: none;
        }

        .custom-max-width {
            max-width: 1100px;
            /* Ancho máximo personalizado */
        }

        .step {
            margin-bottom: 20px;
        }

        .navigation-buttons {
            display: flex;
            justify-content: space-between;
        }

        .navbar-custom {
            background-color: #555555;
            /* Color gris */
            color: white;
            /* Color del texto */
            padding: 15px;
            /* Espaciado */
            text-align: center;
            /* Centrar el texto */
            font-weight: bold;
            /* Negrita */
            margin-bottom: 20px;
            /* Espaciado inferior */
        }

        footer {
            background-color: #343a40;
            /* Color de fondo del footer */
            color: white;
            /* Color del texto */
            text-align: center;
            /* Centrar el texto */
            padding: 10px 0;
            /* Espaciado */
            position: relative;
            /* Para que el footer no se superponga */
            bottom: 0;
            width: 100%;
        }
    </style>
    <script>
        let obraData = {};
        let etapasData = [];
        let currentStep = 0;

        function showStep(step) {
            const steps = document.querySelectorAll('.step');
            steps.forEach(s => s.classList.add('hidden'));
            steps[step].classList.remove('hidden');

            // Actualizar botones de navegación
            document.getElementById('prevBtn').style.display = step === 0 ? 'none' : 'inline';
            document.getElementById('nextBtn').style.display = step === steps.length - 1 ? 'none' : 'inline';
            document.getElementById('submitBtn').style.display = step === steps.length - 1 ? 'inline' : 'none';
        }

        function nextStep() {
            if (currentStep === 0) {
                // Guardar datos de la obra
                obraData = {
                    nombre_obra: document.getElementById('nombre_obra').value,
                    ubicacion: document.getElementById('ubicacion').value,
                    contratista: document.getElementById('contratista').value,
                    responsable: document.getElementById('responsable').value,
                    presupuesto: document.getElementById('presupuesto').value,
                    fecha_inicio: document.getElementById('fecha_inicio').value,
                    fecha_fin: document.getElementById('fecha_estimada_fin').value
                };
            } else if (currentStep === 1) {
                // Guardar datos de las etapas
                const nombreEtapa = document.getElementById('nombre_etapa').value;
                const descripcionEtapa = document.getElementById('descripcion_etapa').value;
                const fechaInicioEtapa = document.getElementById('fecha_inicio_etapa').value;
                const fechaFinEtapa = document.getElementById('fecha_fin_etapa').value;
                const estadoEtapa = document.getElementById('estado_etapa').value;

                if (nombreEtapa && descripcionEtapa) {
                    etapasData.push({
                        nombre: nombreEtapa,
                        descripcion: descripcionEtapa,
                        fecha_inicio: fechaInicioEtapa,
                        fecha_fin: fechaFinEtapa,
                        estado: estadoEtapa
                    });

                    // Limpiar campos de la etapa
                    document.getElementById('nombre_etapa').value = '';
                    document.getElementById('descripcion_etapa').value = '';
                    document.getElementById('fecha_inicio_etapa').value = '';
                    document.getElementById('fecha_fin_etapa').value = '';
                    document.getElementById('estado_etapa').value = '';
                }
            }

            currentStep++;
            showStep(currentStep);
        }

        function prevStep() {
            currentStep--;
            showStep(currentStep);
        }

        function submitForm() {
            const notas = document.getElementById('notas').value;
            const documentos = document.getElementById('documentos').files;

            const formData = new FormData();
            formData.append('obraData', JSON.stringify(obraData));
            formData.append('etapasData', JSON.stringify(etapasData));
            formData.append('notas', notas);
            for (let i = 0; i < documentos.length; i++) {
                formData.append('documentos[]', documentos[i]);
            }

            // Enviar los datos al servidor
            fetch('/gestion_obras2/controllers/ControladorRegistroObra.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    return response.text(); // Cambia a text() para ver la respuesta cruda
                })
                .then(data => {
                    console.log(data); // Muestra la respuesta en la consola
                    // Intenta analizar como JSON solo si es válido
                    try {
                        const jsonData = JSON.parse(data);
                        // Manejo de la respuesta exitosa
                        window.location.href = '/gestion_obras2/views/obras/listado_obras.php';
                    } catch (error) {
                        throw new Error('Error al analizar JSON: ' + error.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert(error.message); // Muestra el mensaje de error
                });

            document.addEventListener('DOMContentLoaded', () => {
                showStep(currentStep); // Mostrar el primer paso al cargar
            });
        }
    </script>
</head>

<body>
    <!-- barra de navegacion -->
    <div class="navbar-custom mb-4"> <!-- Bloque gris -->
        Barra de Navegación
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
    <script src="../../public/js/validacionFromCrear_obra.js"></script> <!-- Conectar el archivo JS -->


</body></html>