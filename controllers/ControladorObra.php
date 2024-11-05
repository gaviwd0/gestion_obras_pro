<?php
// Incluir el archivo de conexión a la base de datos
require_once __DIR__ . '/../config/conn.php'; // Asegúrate de que la ruta sea correcta

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger datos del formulario
    $datos = [
        'nombre_obra' => $_POST['nombre_obra'],
        'ubicacion' => $_POST['ubicacion'],
        'contratista' => isset($_POST['contratista']) && !empty($_POST['contratista']) ? $_POST['contratista'] : 'No especificado',
        'presupuesto' => $_POST['presupuesto'],
        'fecha_inicio' => $_POST['fecha_inicio'],
        'fecha_fin' => $_POST['fecha_estimada_fin'],
        'notas' => isset($_POST['notas']) ? $_POST['notas'] : '',
        'etapas' => isset($_POST['nombre_etapa']) ? $_POST['nombre_etapa'] : [] // Suponiendo que se envían múltiples etapas
    ];

    try {
        // Preparar la consulta SQL para insertar la obra
        $sql = "INSERT INTO obras (nombre_obra, ubicacion, contratista, presupuesto, fecha_inicio, fecha_fin) 
                VALUES (?, ?, ?, ?, ?, ?)";

        // Usar una declaración preparada para evitar inyecciones SQL
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $datos['nombre_obra'],
            $datos['ubicacion'],
            $datos['contratista'],
            $datos['presupuesto'],
            $datos['fecha_inicio'],
            $datos['fecha_fin']
        ]);

        // Obtener el ID de la obra recién insertada
        $obra_id = $pdo->lastInsertId();

        // Si hay notas, insertarlas en la tabla notas_obra
        if (!empty($datos['notas'])) {
            $sqlNotas = "INSERT INTO notas_obra (obra_id, usuario_id, contenido) VALUES (?, ?, ?)";
            $stmtNotas = $pdo->prepare($sqlNotas);
            $stmtNotas->execute([
                $obra_id,
                1, // Asume que el usuario_id es 1, deberías cambiar esto según tu lógica
                $datos['notas']
            ]);
        }

        // Si hay etapas, insertarlas en la tabla etapas_obra
        if (!empty($datos['etapas'])) {
            foreach ($datos['etapas'] as $etapa) {
                $sqlEtapas = "INSERT INTO etapas_obra (obra_id, nombre_etapa, descripcion) VALUES (?, ?, ?)";
                $stmtEtapas = $pdo->prepare($sqlEtapas);
                $stmtEtapas->execute([
                    $obra_id,
                    $etapa['nombre'], // Asegúrate de que estos campos existan en tu formulario
                    $etapa['descripcion']
                ]);
            }
        }

        // Redirigir a una página de éxito o a la lista de obras
        header("Location: /gestion_obras2/views/obras/listado_obras.php");
        exit();
    } catch (PDOException $e) {
        // Manejo de errores
        echo "Error al registrar la obra: " . $e->getMessage();
    }
} else {
    // Si no es una solicitud POST, redirigir o mostrar un mensaje de error
    header("Location: /gestion_obras2/controllers/registro_obra.php");
    exit();
}
?>