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
    const errores = [];
    const alertContainer = document.getElementById('alertContainer');
    const alertMessage = document.getElementById('alertMessage');
    alertContainer.classList.add('d-none'); // Ocultar el contenedor inicialmente
    alertMessage.innerHTML = ''; // Limpiar contenido anterior

    // Validar paso 1
    if (!document.getElementById('nombre_obra').value) {
        errores.push('Nombre de la obra');
    }
    if (!document.getElementById('ubicacion').value) {
        errores.push('Ubicación');
    }
    if (!document.getElementById('contratista').value) {
        errores.push('Contratista');
    }
    if (!document.getElementById('responsable').value) {
        errores.push('Responsable');
    }
    if (!document.getElementById('fecha_inicio').value) {
        errores.push('Fecha de inicio');
    }
    if (!document.getElementById('fecha_estimada_fin').value) {
        errores.push('Fecha estimada de fin');
    }
    if (!document.getElementById('presupuesto').value) {
        errores.push('Presupuesto asignado');
    }

    // Validar paso 2
    if (etapasData.length === 0) {
        errores.push('Debes agregar al menos una etapa de obra.');
    } else {
        for (let i = 0; i < etapasData.length; i++) {
            const etapa = etapasData[i];
            if (!etapa.nombre || !etapa.descripcion) {
                errores.push(`Etapa ${i + 1}: Nombre y descripción son requeridos.`);
            }
        }
    }

    // Mostrar errores si los hay
    if (errores.length > 0) {
        alertMessage.innerHTML = 'Faltan los siguientes campos:<br>- ' + errores.join('<br>- ');
        alertContainer.classList.remove('d-none'); // Mostrar el contenedor

        // Ocultar el contenedor después de 5 segundos
        setTimeout(() => {
            alertContainer.classList.add('d-none');
        }, 5000); // Cambia 5000 a la cantidad de milisegundos que desees

        return; // No enviar el formulario
    }

    // Si todo está bien, proceder a enviar el formulario
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
            console .log(data); // Muestra la respuesta en la consola
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
}

function closeAlert() {
    const alertContainer = document.getElementById('alertContainer');
    alertContainer.classList.add('d-none');
}

document.addEventListener('DOMContentLoaded', () => {
    showStep(currentStep); // Mostrar el primer paso al cargar
});