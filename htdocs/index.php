<?php
// Incluye el archivo de conexión
require_once 'conexion.php';

// Iniciar la sesión si es necesario
session_start();

// Asegúrate de que la conexión se realizó correctamente
if (!$conn) {
    die("Error de conexión a la base de datos.");
}

// Consulta para obtener los 5 libros más vendidos
$sql = "SELECT L.Titulo, L.Autor, L.Imagen, L.Valoraciones, SUM(DP.Cantidad) AS Total_Vendido 
        FROM Libros L
        JOIN Detalles_pedido DP ON L.ISBN = DP.libro_isbn
        GROUP BY L.Titulo
        ORDER BY Total_Vendido DESC
        LIMIT 5";

// Usar la conexión PDO para ejecutar la consulta
$stmt = $conn->prepare($sql);
$stmt->execute();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Shop</title>
    <!-- Asegúrate de que los archivos CSS y JS de Bootstrap están incluidos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        /* Ajuste de tamaño uniforme para las imágenes */
        .carousel-item img {
            width: 350px; /* Tamaño más grande */
            height: auto;
            margin: 0 auto; /* Centrar las imágenes */
        }

        /* Ajustar el estilo del título */
        .carousel-title {
            text-align: center;
            margin: 30px 0;
            font-size: 2rem;
            font-weight: bold;
            color: #333;
        }

        /* Estilo para el texto debajo de las imágenes */
        .book-info {
            text-align: center;
            padding: 15px;
        }

        .book-info h5 {
            font-size: 1.2rem;
            color: #333;
        }

        .book-info p {
            color: #555;
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <!-- Menú de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Library Shop</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="libros.php">Libros</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="clientes.php">Clientes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pedidos.php">Pedidos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="estadisticas.php">Estadísticas</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Título de los libros más vendidos -->
    <div class="carousel-title">
        <h2>Libros Más Vendidos</h2>
    </div>

    <!-- Carrusel de los 5 libros más vendidos -->
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <?php
            // Si la consulta devuelve resultados
            if ($stmt->rowCount() > 0) {
                $isFirst = true;
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $activeClass = $isFirst ? 'active' : '';
                    $isFirst = false;
                    $valoracion = round($row['Valoraciones']); // Redondeamos la valoración
                    echo '
                    <div class="carousel-item ' . $activeClass . '">
                        <img src="' . $row['Imagen'] . '" alt="' . $row['Titulo'] . '" class="d-block mx-auto">
                        <div class="book-info">
                            <h5>' . $row['Titulo'] . '</h5>
                            <p>Autor: ' . $row['Autor'] . '</p>
                            <p>Valoración: ⭐' . $valoracion . '</p>
                            <p>Total Vendido: ' . $row['Total_Vendido'] . '</p>
                        </div>
                    </div>';
                }
            } else {
                echo '<p>No hay libros más vendidos.</p>';
            }
            ?>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</body>
</html>
