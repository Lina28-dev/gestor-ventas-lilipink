<?php
include('header.php');
include('global/conexion.php');
include('navegador.php');

// Verificar conexión a la base de datos
if ($con->connect_error) {
    die("<div class='error'>Error de conexión: " . $con->connect_error . "</div>");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Lencería - Lili Pink</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/consulta.css">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #fff5f7;
        }
        #entrada {
            font-family: 'Montserrat', sans-serif;
            font-weight: 500;
            padding: 10px;
            border: 1px solid #ff85a2;
            border-radius: 20px;
        }
        #resultados {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(255, 133, 162, 0.2);
        }
        #dato {
            font-weight: 500;
            color: #d23369;
        }
        .container {
            padding: 20px;
        }
        .error {
            color: #d32f2f;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <input type="text" id="entrada" placeholder="Buscar lencería por modelo, color o talla..." autocomplete="off">
        
        <table id="resultados">
            <thead>
                <tr id="fila">
                    <th id="dato" width="5%">Código</th>
                    <th id="dato" width="20%">Modelo</th>
                    <th id="dato" width="10%">Color</th>
                    <th id="dato" width="15%">Material</th>
                    <th id="dato" width="5%">Talle</th>
                    <th id="dato" width="5%">Stock</th>
                    <th id="dato" width="10%">Variante</th>
                    <th id="dato" width="8%">Detalles</th>
                    <th id="dato" width="6%">Precio</th>
                </tr>
            </thead>
            <tbody id="respuesta"></tbody>
        </table>
    </div>

    <script src="js/scripts.js"></script>
    <script>
        let infoPagina = document.getElementById('infoPagina');
        infoPagina.innerHTML = 'Consulta Lencería';
        let infoGeneral = document.getElementById('infoGeneralText');
        infoGeneral.innerHTML = "Busque productos por modelo, color o talla";
        
        const div_respuesta = document.getElementById('respuesta');
        const entrada = document.getElementById('entrada');
        
        entrada.addEventListener("keyup", function() {
            if (this.value.length >= 2) {
                consultarDb('GET', 'scripts/consulta_articulo.php?cadena=' + encodeURIComponent(this.value), div_respuesta);
            } else if (this.value.length === 0) {
                div_respuesta.innerHTML = '';
                infoGeneral.innerHTML = "Busque productos por modelo, color o talla";
            }
        });
        
        window.onload = function() {
            entrada.focus();
        };
        
        function consultarDb(method, url, elemento) {
            const xhr = new XMLHttpRequest();
            xhr.open(method, url, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        elemento.innerHTML = xhr.responseText;
                        infoGeneral.innerHTML = "Mostrando lencería: " + entrada.value;
                    } else {
                        elemento.innerHTML = '<tr><td colspan="9" class="error">Error al cargar los datos</td></tr>';
                        infoGeneral.innerHTML = "Error en la consulta";
                    }
                }
            };
            xhr.send();
        }
    </script>
</body>
</html>