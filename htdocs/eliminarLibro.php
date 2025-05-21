<?php
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isbn = $_POST['isbn'] ?? '';
    if ($isbn) {
        $sql = "DELETE FROM Libros WHERE ISBN = :isbn";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':isbn', $isbn, PDO::PARAM_STR);
        if ($stmt->execute()) {
            header('Location: libros.php');
            exit;
        } else {
            echo "Error al eliminar el libro.";
        }
    }
}
