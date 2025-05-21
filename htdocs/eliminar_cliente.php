<?php
require_once 'conexion.php';

if (isset($_GET['id'])) {
    $id_cliente = $_GET['id'];

    $sql = "DELETE FROM Clientes WHERE id_cliente = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id_cliente]);

    header("Location: clientes.php");
}
?>
