<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    // Obtener los valores del formulario
    $isbn = $_POST['ISBN']; 
    $isbn13 = $_POST['ISBN13']; 
    $titulo = $_POST['Titulo']; 
    $autor = $_POST['Autor']; 
    $editorial = $_POST['Editorial']; 
    $sinopsis = isset($_POST['Sinopsis']) ? $_POST['Sinopsis'] : null; 
    $ano_de_publicacion = $_POST['Ano_de_publicacion']; 
    $genero = $_POST['Genero']; 
    $categoria = $_POST['Categoria']; 
    $precio = $_POST['Precio']; 
    $stock = $_POST['Stock']; 
    $no_de_paginas = $_POST['No_de_paginas']; 
    $dimensiones = isset($_POST['Dimensiones']) ? $_POST['Dimensiones'] : null; 
    $valoraciones = isset($_POST['Valoraciones']) ? $_POST['Valoraciones'] : null; 
    $imagen = $_POST['Imagen']; 
    
    // Validación de que no haya campos obligatorios vacíos
    if (empty($isbn) || empty($isbn13) || empty($titulo) || empty($autor) || empty($editorial) || empty($precio) || empty($stock) || empty($no_de_paginas) || empty($genero) || empty($categoria)) {
        die("Todos los campos obligatorios deben ser llenados.");
    }

    // Si 'Etiquetas' es un campo de texto, se captura así:
    $etiquetas = isset($_POST['Etiquetas']) ? $_POST['Etiquetas'] : null;

    // Si 'Etiquetas' es un campo tipo checkbox o select múltiple, puedes hacer esto:
    // Asegúrate de que el campo sea un array, si es así lo conviertes en una cadena separada por comas
    if (isset($_POST['Etiquetas']) && is_array($_POST['Etiquetas'])) {
        $etiquetas = implode(', ', $_POST['Etiquetas']); // Combina las etiquetas seleccionadas en una cadena
    }

    try {
        // Conexión a la base de datos en InfinityFree
        $conn = new PDO("mysql:host=sql203.infinityfree.com;dbname=if0_37699759_db_libraryshop", "if0_37699759", "qDb9E9PhwgV");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Consulta de inserción
        $sql = "INSERT INTO Libros (ISBN, ISBN13, Titulo, Autor, Editorial, Sinopsis, Ano_de_publicacion, Fecha_de_publicacion, Genero, Categoria, Etiquetas, Precio, Stock, No_de_paginas, Dimensiones, Valoraciones, Imagen) 
                VALUES (:ISBN, :ISBN13, :Titulo, :Autor, :Editorial, :Sinopsis, :Ano_de_publicacion, NOW(), :Genero, :Categoria, :Etiquetas, :Precio, :Stock, :No_de_paginas, :Dimensiones, :Valoraciones, :Imagen)";

        $stmt = $conn->prepare($sql);

        // Vinculación de parámetros
        $stmt->bindParam(':ISBN', $isbn);
        $stmt->bindParam(':ISBN13', $isbn13);
        $stmt->bindParam(':Titulo', $titulo);
        $stmt->bindParam(':Autor', $autor);
        $stmt->bindParam(':Editorial', $editorial);
        $stmt->bindParam(':Sinopsis', $sinopsis);
        $stmt->bindParam(':Ano_de_publicacion', $ano_de_publicacion);
        $stmt->bindParam(':Genero', $genero);
        $stmt->bindParam(':Categoria', $categoria);
        $stmt->bindParam(':Etiquetas', $etiquetas);
        $stmt->bindParam(':Precio', $precio);
        $stmt->bindParam(':Stock', $stock);
        $stmt->bindParam(':No_de_paginas', $no_de_paginas);
        $stmt->bindParam(':Dimensiones', $dimensiones);
        $stmt->bindParam(':Valoraciones', $valoraciones);
        $stmt->bindParam(':Imagen', $imagen);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "Libro insertado correctamente.";
        } else {
            echo "Error al insertar el libro: " . implode(", ", $stmt->errorInfo());
        }
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }
}
?>
