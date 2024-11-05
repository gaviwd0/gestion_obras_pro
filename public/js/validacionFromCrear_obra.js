let currentStep = 0; // Declarar la variable para controlar el paso actual
let obraData = {}; // Objeto para almacenar datos de la obra
let etapasData = []; // Array para almacenar datos de las etapas

function nextStep() {
    if (!validateRequiredFields(currentStep)) {
        return; // Si la validación falla, no avanzar al siguiente paso
    }

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
        // Guardar datos de la etapa
        const nombreEtapa = document.getElementById('nombre_etapa').value;
        const descripcionEtapa = document.getElementById('descripcion_etapa').value;
        const fechaInicioEtapa = document.getElementById('fecha_inicio_etapa').value;
        const fechaFinEtapa = document.getElementById('fecha_fin_etapa').value;
        const estadoEtapa = document.getElementById('estado_etapa').value;

        etapasData.push({
            nombre_etapa: nombreEtapa,
            descripcion_etapa: descripcionEtapa,
            fecha_inicio_etapa: fechaInicioEtapa,
            fecha_fin_etapa: fechaFinEtapa,
            estado_etapa: estadoEtapa
        });

        // Limpiar campos de la etapa
        document.getElementById('nombre_etapa').value = '';
        document.getElementById('descripcion_etapa').value = '';
        document.getElementById('fecha_inicio_etapa').value = '';
        document.getElementById('fecha_fin_etapa').value = '';
        document.getElementById('estado_etapa').value = '';
    }

    // Avanzar al siguiente paso
    currentStep++;
    showStep(currentStep);
}

function showStep(step) {
    const steps = document.querySelectorAll('.step');
    steps.forEach((s, index) => {
        s.classList.toggle('hidden', index !== step);
    });

    // Actualizar botones de navegación
    document.getElementById('prevBtn').style.display = step === 0 ? 'none' : 'inline';
    document.getElementById('nextBtn').style.display = step === steps.length - 1 ? 'none' : 'inline';
    document.getElementById('submitBtn').style.display = step === steps.length - 1 ? 'inline' : 'none';
}

function validateRequiredFields(step) {
    let isValid = true;
    let errorMessage = '';
    const alertContainer = document.getElementById('alertContainer');
    alertContainer.classList.add('d-none');
    alertContainer.innerHTML = '';

    if (step === 0) {
        const nombreObra = document.getElementById('nombre_obra').value;
        const ubicacion = document.getElementById('ubicacion').value;
        if (!nombreObra) {
            errorMessage += 'Tienes que llenar el campo "Nombre de la obra".<br>';
            isValid = false;
        }
        if (!ubicacion) {
            errorMessage += 'Tienes que llenar el campo "Ubicación".<br>';
            isValid = false;
        }
    } else if (step === 1) {
        const nombreEtapa = document.getElementById('nombre_etapa').value;
        const estadoEtapa = document.getElementById('estado_etapa').value;
        if (!nombreEtapa) {
            errorMessage += 'Tienes que llenar el campo "Nombre de la etapa".<br>';
            isValid = false;
        }
        if (!estadoEtapa) {
            errorMessage += 'Tienes que seleccionar un estado para la etapa.<br>';
            isValid = false;
        }
    }

    if (!isValid) {
        alertContainer.innerHTML = errorMessage;
        alertContainer.classList.remove('d-none');
    }

}