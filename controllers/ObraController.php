<?php
require_once 'models/ObraModel.php';

class ObraController {
    private $obraModel;

    public function __construct($pdo) {
        $this->obraModel = new ObraModel($pdo);
    }

    public function modificarObra($obra_id) {
        // Verificar si la obra existe
        $obra = $this->obraModel->obtenerObra($obra_id);
        
        // Inicializar las variables de etapas y notas
        $etapas = [];
        $notas = [];
    
        if (!$obra) {
            // Si la obra no se encuentra, aún puedes definir las variables vacías
            // para evitar errores en la vista
            $etapas = $this->obraModel->obtenerEtapas($obra_id);
            $notas = $this->obraModel->obtenerNotas($obra_id);
            include 'views/modificar_obra.php';
            return; // Termina la ejecución si la obra no se encuentra
        }
    
        // Manejo de la solicitud POST para editar la obra
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar_obra'])) {
            $data = [
                'nombre_obra' => $_POST['nombre_obra'],
                'ubicacion' => $_POST['ubicacion'],
                'contratista' => $_POST['contratista'],
                'presupuesto' => $_POST['presupuesto'],
                'fecha_inicio' => $_POST['fecha_inicio'],
                'fecha_fin' => $_POST['fecha_fin'],
                'obra_id' => $obra_id
            ];
            $this->obraModel->actualizarObra($data);
            header("Location: board_obras.php");
            exit;
        }
    
        // Manejo de la solicitud POST para agregar etapa
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar_etapa'])) {
            $data = [
                'obra_id' => $obra_id,
                'nombre_etapa' => $_POST['nombre_etapa'],
                'fecha_inicio' => $_POST['fecha_inicio_etapa'],
                'fecha_fin' => $_POST['fecha_fin_etapa'],
                'descripcion' => $_POST['descripcion_etapa']
            ];
            $this->obraModel->agregarEtapa($data);
            header("Location: modificar_obra.php?id=" . $obra_id);
            exit;
        }
    
        // Manejo de la solicitud POST para agregar nota
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar_nota'])) {
            $data = [
                'obra_id' => $obra_id,
                'usuario_id' => $_POST['usuario_id'],
                'contenido' => $_POST['contenido_nota']
            ];
            $this->obraModel->agregarNota($data);
            header("Location: modificar_obra.php?id=" . $obra_id);
            exit;
        }
    
        // Obtener etapas y notas
        $etapas = $this->obraModel->obtenerEtapas($obra_id);
        $notas = $this->obraModel->obtenerNotas($obra_id);
    
        // Incluir la vista
        include 'views/modificar_obra.php';
    }
}
?>