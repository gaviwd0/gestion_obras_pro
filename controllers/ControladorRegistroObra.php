<?php
require_once __DIR__ . '/../config/conn.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $obraData = json_decode($_POST['obraData'], true);
    $etapasData = json_decode($_POST['etapasData'], true);
    $notas = $_POST['notas'];

    // Verifica si el campo documentos está definido
    $documentos = isset($_FILES['documentos']) ? $_FILES['documentos'] : [];

    // Validaciones
    $errors = [];

    // Validar datos de la obra
    if (empty($obraData['nombre_obra'])) {
        $errors[] = 'El nombre de la obra es requerido.';
    }

    if (empty($obraData['ubicacion'])) {
        $errors[] = 'La ubicación es requerida.';
    }

    if (empty($obraData['contratista'])) {
        $errors[] = 'El contratista es requerido.';
    }

    if (!is_numeric($obraData['presupuesto']) || $obraData['presupuesto'] <= 0) {
        $errors[] = 'El presupuesto debe ser un número positivo.';
    }

    if (empty($obraData['fecha_inicio']) || empty($obraData['fecha_fin'])) {
        $errors[] = 'Las fechas de inicio y fin son requeridas.';
    }

    // Validar responsable_id
    $responsable_id = $obraData['responsable'];
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE usuario_id = ?");
    $stmt->execute([$responsable_id]);
    $exists = $stmt->fetchColumn();

    if (!$exists) {
        $errors[] = 'El ID del responsable no existe.';
    }

    // Validar etapas
    foreach ($etapasData as $etapa) {
        if (empty($etapa['nombre'])) {
            $errors[] = 'El nombre de la etapa es requerido.';
        }
        if (empty($etapa['fecha_inicio']) || empty($etapa['fecha_fin'])) {
            $errors[] = 'Las fechas de inicio y fin de la etapa son requeridas.';
        }
    }

    // Si hay errores, devolverlos
    if (!empty($errors)) {
        echo json_encode(['status' => 'error', 'messages' => $errors]);
        exit();
    }

    // Intentar insertar en la base de datos
    try {
        // Insertar obra
        $sql = "INSERT INTO obras (nombre_obra, ubicacion, contratista, presupuesto, fecha_inicio, fecha_fin, responsable_id) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $obraData['nombre_obra'],
            $obraData['ubicacion'],
            $obraData['contratista'],
            $obraData['presupuesto'],
            $obraData['fecha_inicio'],
            $obraData['fecha_fin'],
            $responsable_id
        ]);

        $obra_id = $pdo->lastInsertId();

        // Insertar etapas
        foreach ($etapasData as $etapa) {
            $sqlEtapas = "INSERT INTO etapas_obra (obra_id, nombre_etapa, descripcion, fecha_inicio, fecha_fin, estado) 
                          VALUES (?, ?, ?, ?, ?, ?)";
            $stmtEtapas = $pdo->prepare($sqlEtapas);
            $stmtEtapas->execute([
                $obra_id,
                $etapa['nombre'],
                $etapa['descripcion'],
                $etapa['fecha_inicio'],
                $etapa['fecha_fin'],
                $etapa['estado']
            ]);
        }

        // Insertar notas
        if (!empty($notas)) {
            $sqlNotas = "INSERT INTO notas_obra (obra_id, usuario_id, contenido) VALUES (?, ?, ?)";
            $stmtNotas = $pdo->prepare($sqlNotas);
            $stmtNotas->execute([
                $obra_id,
                1, // Cambiar según la lógica de tu aplicación
                $notas
            ]);
        }

        // Manejar documentos
        if (!empty($documentos['name'][0])) {
            foreach ($documentos['name'] as $key => $value) {
                $tmp_name = $documentos['tmp_name'][$key];
                $name = $documentos['name'][$key];
                $size = $documentos['size'][$key];
                $type = $documentos['type'][$key];

                // Verificar si el archivo es válido
                if ($size > 0 && $type === 'application/pdf') {
                    $sqlDocumentos = "INSERT INTO documentos_obra (obra_id, nombre_documento, ruta_documento) VALUES (?, ?, ?)";
                    $stmtDocumentos = $pdo->prepare($sqlDocumentos);
                    $stmtDocumentos->execute([
                        $obra_id,
                        $name,
                        'ruta/al/archivo/' . $name // Debes reemplazar con la ruta real
                    ]);

                    // Mover el archivo a la carpeta de destino
                    move_uploaded_file($tmp_name, 'ruta/al/archivo/' . $name);
                } else {
                    $errors[] = 'El archivo ' . $name . ' no es un PDF válido o está vacío.';
                }
            }
        }

        // Respuesta exitosa
        echo json_encode(['status' => 'success', 'message' => 'Obra registrada correctamente.']);
        exit();
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        exit();
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        exit();
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido.']);
    exit();
}
?>