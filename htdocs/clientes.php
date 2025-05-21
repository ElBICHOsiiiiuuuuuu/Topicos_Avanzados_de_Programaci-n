<?php
require_once 'conexion.php';
require_once 'BasePage.php';

// Instancia de la clase BasePage
$page = new BasePage();

// Consulta a la base de datos con PDO
try {
    $stmt = $conn->query("SELECT * FROM Clientes");
    $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al consultar los clientes: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <?php $page->mostrarHeader(); ?> <!-- Mostrar el menú de navegación -->

    <div class="container mt-5">
        <h2 class="mb-4">Clientes</h2>
        
        <!-- Botón para agregar un nuevo cliente -->
        <a href="agregar_cliente.php" class="btn btn-primary mb-3">Agregar Cliente</a>
        
        <?php if (!empty($clientes)): ?>
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID Cliente</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clientes as $cliente): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($cliente['id_cliente']); ?></td>
                            <td><?php echo htmlspecialchars($cliente['Nombre']); ?></td>
                            <td><?php echo htmlspecialchars($cliente['Apellido']); ?></td>
                            <td><?php echo htmlspecialchars($cliente['Email']); ?></td>
                            <td><?php echo htmlspecialchars($cliente['Telefono']); ?></td>
                            <td>
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detalleClienteModal" onclick="cargarDetallesCliente(<?php echo $cliente['id_cliente']; ?>)">Ver Detalles</button>
                                
                                <!-- Botón para eliminar cliente -->
                                <a class="btn btn-danger btn-sm" href="eliminar_cliente.php?id=<?php echo $cliente['id_cliente']; ?>" onclick="return confirm('¿Estás seguro de eliminar este cliente?');">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-warning" role="alert">
                No hay clientes registrados en la base de datos.
            </div>
        <?php endif; ?>
    </div>

    <!-- Modal para ver detalles del cliente -->
    <div class="modal fade" id="detalleClienteModal" tabindex="-1" aria-labelledby="detalleClienteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detalleClienteModalLabel">Detalles del Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Nombre:</strong> <span id="clienteNombre"></span></p>
                    <p><strong>Apellido:</strong> <span id="clienteApellido"></span></p>
                    <p><strong>Dirección:</strong> <span id="clienteDireccion"></span></p>
                    <p><strong>Email:</strong> <span id="clienteEmail"></span></p>
                    <p><strong>Fecha de Nacimiento:</strong> <span id="clienteFechaNacimiento"></span></p>
                    <p><strong>Teléfono:</strong> <span id="clienteTelefono"></span></p>
                    <p><strong>Preferencias de Género:</strong> <span id="clientePreferenciasGenero"></span></p>
                    <p><strong>Historial de Compras:</strong> <span id="clienteHistorialCompras"></span></p>
                    <p><strong>Lista de Deseos:</strong> <span id="clienteListaDeseos"></span></p>
                    <p><strong>Boletín de Noticias:</strong> <span id="clienteBoletinNoticias"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <?php $page->mostrarFooter(); ?> <!-- Mostrar el pie de página -->

    <script>
        function cargarDetallesCliente(idCliente) {
            $.ajax({
                url: 'detallesdelcliente.php',
                type: 'GET',
                data: { id: idCliente },
                success: function(data) {
                    var cliente = JSON.parse(data);
                    if (cliente.error) {
                        alert(cliente.error);
                    } else {
                        $('#clienteNombre').text(cliente.Nombre);
                        $('#clienteApellido').text(cliente.Apellido);
                        $('#clienteDireccion').text(cliente.Direccion);
                        $('#clienteEmail').text(cliente.Email);
                        $('#clienteFechaNacimiento').text(cliente.Fecha_de_nacimiento);
                        $('#clienteTelefono').text(cliente.Telefono);
                        $('#clientePreferenciasGenero').text(cliente.Preferencias_de_genero);
                        $('#clienteHistorialCompras').text(cliente.Historial_de_compras);
                        $('#clienteListaDeseos').text(cliente.Lista_de_deseos);
                        $('#clienteBoletinNoticias').text(cliente.Boletin_de_noticias ? 'Sí' : 'No');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error en la solicitud AJAX:", error);
                }
            });
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
