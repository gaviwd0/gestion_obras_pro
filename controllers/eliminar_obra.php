<?php
// Incluir la conexión a la base de datos
require_once '../config/conn.php';

if (isset($_GET['id'])) {
    $obra_id = $_GET['id'];
    $sql = "DELETE FROM obras WHERE obra_id = :obra_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['obra_id' => $obra_id]);

    header("Location: ../views/obras/board_obras.php");
    exit;
} else {
    echo "ID de obra no especificado.";
    exit;
}
?>

