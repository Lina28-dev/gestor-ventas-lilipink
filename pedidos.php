<?php
session_start();
if (!isset($_SESSION['usuario_nombre'])) {
    header("Location: index.php");
    exit();
}
include('header.php');
include('navegador.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Orden de Pedido</title>
    <link rel="stylesheet" href="css/contenido.css">
</head>
<body>
    <div class="content-container">
        <h2>Orden de Pedido</h2>
        
        <div class="tabs">
            <button class="tab-link active" onclick="openTab(event, 'nuevo')">Nuevo Pedido</button>
            <button class="tab-link" onclick="openTab(event, 'historial')">Historial de Pedidos</button>
            <button class="tab-link" onclick="openTab(event, 'pendientes')">Pedidos Pendientes</button>
        </div>
        
        <!-- Nuevo Pedido -->
        <div id="nuevo" class="tab-content" style="display: block;">
            <h3>Crear Nuevo Pedido</h3>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="proveedor">Proveedor:</label>
                    <select id="proveedor" name="proveedor" required>
                        <option value="">Seleccionar proveedor</option>
                        <option value="1">Proveedor 1</option>
                        <option value="2">Proveedor 2</option>
                        <option value="3">Proveedor 3</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="fecha_entrega">Fecha Estimada de Entrega:</label>
                    <input type="date" id="fecha_entrega" name="fecha_entrega" required>
                </div>
                
                <h4>Productos</h4>
                <div id="productos-container">
                    <div class="producto-row">
                        <div class="form-group">
                            <label for="producto_1">Producto:</label>
                            <select id="producto_1" name="productos[]" required>
                                <option value="">Seleccionar producto</option>
                                <option value="1">Producto 1</option>
                                <option value="2">Producto 2</option>
                                <option value="3">Producto 3</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="cantidad_1">Cantidad:</label>
                            <input type="number" id="cantidad_1" name="cantidades[]" min="1" required>
                        </div>
                    </div>
                </div>
                
                <button type="button" onclick="agregarProducto()">+ Agregar Producto</button>
                <button type="submit" name="crear_pedido" style="margin-left: 10px;">Generar Pedido</button>
            </form>
        </div>
        
        <!-- Historial de Pedidos -->
        <div id="historial" class="tab-content" style="display: none;">
            <h3>Historial de Pedidos</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID Pedido</th>
                        <th>Proveedor</th>
                        <th>Fecha Solicitud</th>
                        <th>Fecha Entrega</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Aquí irían los datos de pedidos desde la base de datos -->
                    <tr>
                        <td>P001</td>
                        <td>Proveedor 1</td>
                        <td>01/05/2025</td>
                        <td>10/05/2025</td>
                        <td>Entregado</td>
                        <td><a href="#" class="btn btn-small">Ver Detalles</a></td>
                    </tr>
                    <tr>
                        <td>P002</td>
                        <td>Proveedor 2</td>
                        <td>15/04/2025</td>
                        <td>25/04/2025</td>
                        <td>Entregado</td>
                        <td><a href="#" class="btn btn-small">Ver Detalles</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Pedidos Pendientes -->
        <div id="pendientes" class="tab-content" style="display: none;">
            <h3>Pedidos Pendientes de Recepción</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID Pedido</th>
                        <th>Proveedor</th>
                        <th>Fecha Solicitud</th>
                        <th>Fecha Entrega Estimada</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Aquí irían los datos de pedidos pendientes desde la base de datos -->
                    <tr>
                        <td>P003</td>
                        <td>Proveedor 1</td>
                        <td>01/05/2025</td>
                        <td>15/05/2025</td>
                        <td>En camino</td>
                        <td>
                            <a href="#" class="btn btn-small">Ver Detalles</a>
                            <a href="#" class="btn btn-small">Recibir</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        let infoPagina = document.getElementById('infoPagina');
        infoPagina.innerHTML = 'Orden de Pedido';
        let infoGeneral = document.getElementById('infoGeneralText');
        infoGeneral.innerHTML = "Gestiona tus pedidos a proveedores";
        
        // Función para cambiar entre pestañas
        function openTab(evt, tabName) {
            let i, tabContent, tabLinks;
            
            // Ocultar todas las pestañas
            tabContent = document.getElementsByClassName("tab-content");
            for (i = 0; i < tabContent.length; i++) {
                tabContent[i].style.display = "none";
            }
            
            // Desactivar todos los botones
            tabLinks = document.getElementsByClassName("tab-link");
            for (i = 0; i < tabLinks.length; i++) {
                tabLinks[i].className = tabLinks[i].className.replace(" active", "");
            }
            
            // Mostrar la pestaña actual y activar el botón
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }
        
        // Contador para los nuevos productos
        let contadorProductos = 1;
        
        // Función para agregar más filas de productos al pedido
        function agregarProducto() {
            contadorProductos++;
            const container = document.getElementById('productos-container');
            const nuevaFila = document.createElement('div');
            nuevaFila.className = 'producto-row';
            nuevaFila.innerHTML = `
                <div class="form-group">
                    <label for="producto_${contadorProductos}">Producto:</label>
                    <select id="producto_${contadorProductos}" name="productos[]" required>
                        <option value="">Seleccionar producto</option>
                        <option value="1">Producto 1</option>
                        <option value="2">Producto 2</option>
                        <option value="3">Producto 3</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="cantidad_${contadorProductos}">Cantidad:</label>
                    <input type="number" id="cantidad_${contadorProductos}" name="cantidades[]" min="1" required>
                </div>
                <button type="button" class="btn-remove" onclick="eliminarProducto(this)">Eliminar</button>
            `;
            container.appendChild(nuevaFila);
        }
        
        // Función para eliminar una fila de producto
        function eliminarProducto(btn) {
            const fila = btn.parentNode;
            fila.parentNode.removeChild(fila);
        }
    </script>
    
    <style>
        /* Estilos para las pestañas */
        .tabs {
            overflow: hidden;
            border: 1px solid #ccc;
            background-color: #f1f1f1;
            border-radius: 5px 5px 0 0;
        }
        
        .tab-link {
            background-color: inherit;
            float: left;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            transition: 0.3s;
            font-size: 16px;
        }
        
        .tab-link:hover {
            background-color: #ddd;
        }
        
        .tab-link.active {
            background-color: #E91E63;
            color: white;
        }
        
        .tab-content {
            padding: 20px;
            border: 1px solid #ccc;
            border-top: none;
            border-radius: 0 0 5px 5px;
        }
        
        /* Estilos para las filas de productos */
        .producto-row {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-end;
            gap: 15px;
            padding: 10px;
            border: 1px solid #eee;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        
        .btn-remove {
            background-color: #ff5252;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 15px;
        }
        
        .btn-remove:hover {
            background-color: #ff1744;
        }
        
        .btn-small {
            padding: 5px 10px;
            font-size: 14px;
            margin-right: 5px;
        }
    </style>
</body>
</html>