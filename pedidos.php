<?php
include('header.php');
include('navegador.php');
?>
<link rel="stylesheet" href="css/pedidos.css">
<script src="js/scripts.js"></script>
<body>
    <div class="container">
        <button onclick="toggle(nuevo_pedido)" class="btn-rosa">Nuevo Pedido de Lencería</button>
        <div id="nuevo_pedido">
            <div id="select_cliente">
                <label for="">Seleccionar Cliente</label>
                <input type="text" id="entrada" placeholder="Buscar cliente...">
                <table class="tabla-lenceria">
                    <tr>
                        <td width="10%">Nro</td>
                        <td width="50%">Nombre</td>
                        <td width="15%">Descuento</td>
                        <td width="25%">Acción</td>
                    </tr>
                </table>
                <div id="respuesta"></div>
            </div>
            
            <div id="select_productos">
                <label for="">Seleccionar Lencería</label>
                <input type="text" id="entrada_producto" placeholder="Buscar por modelo, color o talle...">

                <table id="resultados" class="tabla-lenceria">
                    <tr id="fila">
                        <td id="dato" width="4%">Cód</td>
                        <td id="dato" width="20%">Modelo</td>
                        <td id="dato" width="10%">Color</td>
                        <td id="dato" width="14%">Material</td>
                        <td id="dato" width="5%">Talle</td>
                        <td id="dato" width="5%">Stock</td>
                        <td id="dato" width="10%">Variante</td>
                        <td id="dato" width="9%">Detalles</td>
                        <td id="dato" width="7%">Precio</td>
                        <td id="dato" width="15%">Acción</td>
                    </tr>
                    <table id="respuesta_producto"></table>
                </table>
            </div>
            
            <div class="info_general2"></div>
            <label for="">Cliente:</label>
            <div id="pedido">
                <div>
                    <label for="" id="cliente_seleccionado_nombre"></label>
                </div>
                <table id="articulos_seleccionados" class="tabla-lenceria">
                    <!-- Lencería seleccionada aparecerá aquí -->
                </table>
                <table class="tabla-total">
                    <tr><td>Subtotal</td><td id="subtotal"></td></tr>
                    <tr><td>Descuento</td><td id="descuento">0%</td></tr>
                    <tr><td>Total</td><td id="total"></td></tr>
                </table>
            </div>
            <div id="guardar_pe">
                <button id="guardar_pedido" class="btn-rosa">
                    Guardar Pedido de Lencería
                </button>
            </div>
        </div>
    </div>

    <script>
        // Configuración inicial
        let infoPagina = document.getElementById('infoPagina');
        infoPagina.innerHTML = 'Pedidos Lencería';
        let infoGeneral = document.getElementById('infoGeneralText');
        infoGeneral.innerHTML = "Gestión de pedidos de lencería";
        
        // Resto del JavaScript adaptado para lencería
        // ...
    </script>
</body>