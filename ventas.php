<?php
include('header.php');
include('navegador.php');
?>
<link rel="stylesheet" href="css/ventas.css">
<script src="js/scripts.js"></script>
<body>
    <div class="container">
        <h2>Ventas de Lencería</h2>
        <div class="filtros">
            <input type="date" id="fecha_desde">
            <input type="date" id="fecha_hasta">
            <button onclick="filtrarVentas()" class="btn-rosa">Filtrar</button>
        </div>
        
        <table class="tabla-lenceria">
            <thead>
                <tr>
                    <th>N° Venta</th>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Productos</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody id="lista-ventas">
                <!-- Las ventas se cargarán aquí -->
            </tbody>
        </table>
    </div>

    <script>
        let infoPagina = document.getElementById('infoPagina');
        infoPagina.innerHTML = 'Ventas Lencería';
        let infoGeneral = document.getElementById('infoGeneralText');
        infoGeneral.innerHTML = "Historial de ventas de lencería";
        
        function filtrarVentas() {
            // Lógica para filtrar ventas
        }
        
        // Cargar ventas al iniciar
        window.onload = function() {
            // Lógica para cargar ventas
        };
    </script>
</body>