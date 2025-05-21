<?php
require_once 'conexion.php';

$conn = (new Conexion())->getConexion();

if (isset($_GET['id'])) {
    $id_cliente = $_GET['id'];

    $sql = "SELECT * FROM Clientes WHERE id_cliente = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id_cliente]);
    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$cliente) {
        echo json_encode(["error" => "Cliente no encontrado."]);
        exit;
    }

    echo json_encode($cliente);
} else {
    echo json_encode(["error" => "No se proporcionó un ID válido."]);
    exit;
}
?>
