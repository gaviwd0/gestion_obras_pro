<?php
class ObraModel {
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    public function obtenerObra($obra_id) {
        $query = "SELECT * FROM obras WHERE obra_id = :obra_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':obra_id', $obra_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna la obra o false si no existe
    }

    public function obtenerEtapas($obra_id) {
        $query = "SELECT * FROM etapas WHERE obra_id = :obra_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':obra_id', $obra_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerNotas($obra_id) {
        $query = "SELECT * FROM notas WHERE obra_id = :obra_id";
        $stmt = $this->db->prepare($query); // Eliminar el espacio adicional aquí
        $stmt->bindParam(':obra_id', $obra_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function actualizarObra($data) {
        $query = "UPDATE obras SET nombre_obra = :nombre_obra, ubicacion = :ubicacion, contratista = :contratista, presupuesto = :presupuesto, fecha_inicio = :fecha_inicio, fecha_fin = :fecha_fin WHERE obra_id = :obra_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute($data);
    }

    public function agregarEtapa($data) {
        $query = "INSERT INTO etapas (obra_id, nombre_etapa, fecha_inicio, fecha_fin, descripcion) VALUES (:obra_id, :nombre_etapa, :fecha_inicio, :fecha_fin, :descripcion)";
        $stmt = $this->db->prepare($query);
        $stmt->execute($data);
    }

    public function agregarNota($data) {
        $query = "INSERT INTO notas (obra_id, usuario_id, contenido) VALUES (:obra_id, :usuario_id, :contenido)";
        $stmt = $this->db->prepare($query);
        $stmt->execute($data);
    }
}
?>