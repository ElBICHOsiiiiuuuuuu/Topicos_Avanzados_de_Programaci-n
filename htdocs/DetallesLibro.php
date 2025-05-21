<?php
require_once 'conexion.php';

$conn = (new Conexion())->getConexion();

if (isset($_GET['id'])) {
    $isbn = $_GET['id'];

    $sql = "SELECT * FROM Libros WHERE ISBN = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$isbn]);
    $libro = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$libro) {
        echo "Libro no encontrado.";
        exit;
    }
} else {
    echo "No se proporcionó un ID válido.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($libro['Título']) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container my-5">
    <h1 class="mb-4"><?= htmlspecialchars($libro['Título']) ?></h1>
    <img src="<?= htmlspecialchars($libro['Imagen']) ?>" alt="<?= htmlspecialchars($libro['Título']) ?>" class="img-fluid mb-4">
    <p><strong>Autor:</strong> <?= htmlspecialchars($libro['Autor']) ?></p>
    <p><strong>Editorial:</strong> <?= htmlspecialchars($libro['Editorial']) ?></p>
    <p><strong>Sinopsis:</strong> <?= htmlspecialchars($libro['Sinopsis']) ?></p>
    <p><strong>Precio:</strong> $<?= htmlspecialchars($libro['Precio']) ?></p>
    <p><strong>Stock:</strong> <?= htmlspecialchars($libro['Stock']) ?></p>
    <p><strong>Páginas:</strong> <?= htmlspecialchars($libro['No_de_páginas']) ?></p>
    <p><strong>Género:</strong> <?= htmlspecialchars($libro['Género']) ?></p>
    <a href="libros.php" class="btn btn-secondary">Volver</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
