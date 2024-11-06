<?php
// eliminar_obra.php
require_once '../../config/conn.php';

if (isset($_GET['id'])) {
    $obra_id = $_GET['id'];

    // Eliminar la obra de la base de datos
    $stmt = $pdo->prepare("DELETE FROM obras WHERE obra_id = :id");
    $stmt->bindParam(':id', $obra_id, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        echo "Obra eliminada con éxito.";
    } else {
        echo "Error al eliminar la obra.";
    }
} else {
    echo "ID de obra no especificado.";
}
?>