<?php
require_once 'BasePage.php'; // Clase base para encabezado y pie de página
require_once 'conexion.php'; // Archivo para la conexión a la base de datos

$page = new BasePage();
$page->mostrarHeader();

$buscar = $_GET['buscar'] ?? '';

// Consultar libros con filtro si se realiza una búsqueda
$sql = "SELECT * FROM Libros";
if (!empty($buscar)) {
    $sql .= " WHERE Titulo LIKE :buscar OR Autor LIKE :buscar OR ISBN LIKE :buscar";
}
$stmt = $conn->prepare($sql);
if (!empty($buscar)) {
    $stmt->bindValue(':buscar', '%' . $buscar . '%');
}
$stmt->execute();
$libros = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Incluir Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4">
    <h2>Libros</h2>
    <form method="GET" class="d-flex mb-4">
        <input class="form-control me-2" type="search" name="buscar" placeholder="Buscar libros" value="<?= htmlspecialchars($buscar) ?>">
        <button class="btn btn-outline-primary" type="submit">Buscar</button>
    </form>

    <!-- Botón para agregar un libro -->
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#agregarLibroModal">Agregar un nuevo libro</button>

    <div class="row">
        <?php if ($libros): ?>
            <?php foreach ($libros as $libro): ?>
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <img src="<?= htmlspecialchars($libro['Imagen']) ?>" class="card-img-top" alt="<?= htmlspecialchars($libro['Titulo']) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($libro['Titulo']) ?></h5>
                            <p class="card-text">Autor: <?= htmlspecialchars($libro['Autor']) ?></p>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detallesLibroModal<?= $libro['id'] ?>">Ver detalles</button>
                        </div>
                    </div>
                </div>

                <!-- Modal de detalles -->
                <div class="modal fade" id="detallesLibroModal<?= $libro['id'] ?>" tabindex="-1" aria-labelledby="detallesLibroLabel<?= $libro['id'] ?>" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="detallesLibroLabel<?= $libro['id'] ?>"><?= htmlspecialchars($libro['Titulo']) ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <img src="<?= htmlspecialchars($libro['Imagen']) ?>" class="img-fluid mb-3" alt="<?= htmlspecialchars($libro['Titulo']) ?>">
                                <p><strong>ISBN:</strong> <?= htmlspecialchars($libro['ISBN']) ?></p>
                                <p><strong>ISBN13:</strong> <?= htmlspecialchars($libro['ISBN13']) ?></p>
                                <p><strong>Autor:</strong> <?= htmlspecialchars($libro['Autor']) ?></p>
                                <p><strong>Editorial:</strong> <?= htmlspecialchars($libro['Editorial']) ?></p>
                                <p><strong>Sinopsis:</strong> <?= htmlspecialchars($libro['Sinopsis']) ?></p>
                                <p><strong>Año de publicación:</strong> <?= htmlspecialchars($libro['Ano_de_publicacion']) ?></p>
                                <p><strong>Fecha de publicación:</strong> <?= htmlspecialchars($libro['Fecha_de_publicacion']) ?></p>
                                <p><strong>Género:</strong> <?= htmlspecialchars($libro['Genero']) ?></p>
                                <p><strong>Categoría:</strong> <?= htmlspecialchars($libro['Categoria']) ?></p>
                                <p><strong>Etiquetas:</strong> <?= htmlspecialchars($libro['Etiquetas']) ?></p>
                                <p><strong>Precio:</strong> $<?= htmlspecialchars($libro['Precio']) ?></p>
                                <p><strong>Stock:</strong> <?= htmlspecialchars($libro['Stock']) ?></p>
                                <p><strong>Número de páginas:</strong> <?= htmlspecialchars($libro['No_de_paginas']) ?></p>
                                <p><strong>Dimensiones:</strong> <?= htmlspecialchars($libro['Dimensiones']) ?> cm</p>
                                <p><strong>Valoraciones:</strong> <?= htmlspecialchars($libro['Valoraciones']) ?> estrellas</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No se encontraron libros.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Modal para agregar un libro -->
<div class="modal fade" id="agregarLibroModal" tabindex="-1" aria-labelledby="agregarLibroLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregarLibroLabel">Agregar un nuevo libro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="procesarLibro.php">
                    <div class="mb-3">
                        <label for="isbn" class="form-label">ISBN</label>
                        <input type="text" class="form-control" id="isbn" name="ISBN" required>
                    </div>
                    <div class="mb-3">
                        <label for="isbn13" class="form-label">ISBN13</label>
                        <input type="text" class="form-control" id="isbn13" name="ISBN13" required>
                    </div>
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" id="titulo" name="Titulo" required>
                    </div>
                    <div class="mb-3">
                        <label for="autor" class="form-label">Autor</label>
                        <input type="text" class="form-control" id="autor" name="Autor" required>
                    </div>
                    <div class="mb-3">
                        <label for="editorial" class="form-label">Editorial</label>
                        <input type="text" class="form-control" id="editorial" name="Editorial" required>
                    </div>
                    <div class="mb-3">
                        <label for="sinopsis" class="form-label">Sinopsis</label>
                        <textarea class="form-control" id="sinopsis" name="Sinopsis" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="ano_de_publicacion" class="form-label">Año de publicación</label>
                        <input type="date" class="form-control" id="ano_de_publicacion" name="Ano_de_publicacion" required>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_de_publicacion" class="form-label">Fecha de publicación</label>
                        <input type="date" class="form-control" id="fecha_de_publicacion" name="Fecha_de_publicacion">
                    </div>
                    <div class="mb-3">
                        <label for="genero" class="form-label">Género</label>
                        <input type="text" class="form-control" id="genero" name="Genero" required>
                    </div>
                    <div class="mb-3">
                        <label for="categoria" class="form-label">Categoría</label>
                        <input type="text" class="form-control" id="categoria" name="Categoria" required>
                    </div>
                    <div class="mb-3">
                        <label for="etiquetas" class="form-label">Etiquetas</label>
                        <input type="text" class="form-control" id="etiquetas" name="Etiquetas">
                    </div>
                    <div class="mb-3">
                        <label for="precio" class="form-label">Precio</label>
                        <input type="number" class="form-control" id="precio" name="Precio" required>
                    </div>
                    <div class="mb-3">
                        <label for="stock" class="form-label">Stock</label>
                        <input type="number" class="form-control" id="stock" name="Stock" required>
                    </div>
                    <div class="mb-3">
                        <label for="no_de_paginas" class="form-label">Número de páginas</label>
                        <input type="number" class="form-control" id="no_de_paginas" name="No_de_paginas" required>
                    </div>
                    <div class="mb-3">                   
                        <label for="dimensiones" class="form-label">Dimensiones (cm)</label>
                        <input type="number" step="0.01" class="form-control" id="dimensiones" name="Dimensiones">
                    </div>
                    <div class="mb-3">
                        <label for="valoraciones" class="form-label">Valoraciones (1-5)</label>
                        <input type="number" step="0.1" min="1" max="5" class="form-control" id="valoraciones" name="Valoraciones">
                    </div>
                    <div class="mb-3">
                        <label for="imagen" class="form-label">Imagen URL</label>
                        <input type="text" class="form-control" id="imagen" name="Imagen">
                    </div>
                    <button type="submit" class="btn btn-primary">Agregar libro</button>
                </form>
            </div>
        </div>
    </div>
</div>

</div>

<!-- Incluir JavaScript de Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?php
$page->mostrarFooter();
?>
