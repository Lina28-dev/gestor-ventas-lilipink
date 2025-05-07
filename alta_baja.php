<?php
include('header.php');
include('navegador.php');
?>
<link rel="stylesheet" href="css/alta_baja.css">
<link rel="stylesheet" href="css/consulta.css">
<script src="js/scripts.js"></script>
<body>
    <div class="container">
        <div class="separador">
            <p>Presiona Cargar artículo nuevo para ingresar un producto de lencería</p>
        </div>
        <button id="cargar_nuevo_div">Cargar Lencería Nueva</button>
        <hr>
        <div id="art_nuevo">
            <form action="scripts/guardar_modelo_nuevo.php" method="POST">

            <label for="">Modelo</label>
            <select class="campos" name="modelo" required>
                <option value="">Seleccione modelo</option>
                <option value="Conjunto">Conjunto</option>
                <option value="Bombacha">Bombacha</option>
                <option value="Corpiño">Corpiño</option>
                <option value="Pijama">Pijama</option>
                <option value="Bata">Bata</option>
                <option value="Medias">Medias</option>
            </select>
            <span class="pista">Seleccione el tipo de lencería. Obligatorio.</span><br>

            <label for="">Color</label>
            <input type="text" class="campos" name="color" maxlength="30" required>
            <span class="pista">Hasta 30 caracteres. Obligatorio</span><br>

            <label for="">Material</label>
            <select class="campos" name="material" required>
                <option value="">Seleccione material</option>
                <option value="Algodón">Algodón</option>
                <option value="Seda">Seda</option>
                <option value="Encaje">Encaje</option>
                <option value="Microfibra">Microfibra</option>
                <option value="Satén">Satén</option>
            </select>
            <span class="pista">Material principal. Obligatorio.</span><br>

            <label for="">Talle</label>
            <select class="campos" name="talle" required>
                <option value="">Seleccione talle</option>
                <option value="XS">XS</option>
                <option value="S">S</option>
                <option value="M">M</option>
                <option value="L">L</option>
                <option value="XL">XL</option>
                <option value="XXL">XXL</option>
                <option value="Único">Único</option>
            </select>
            <span class="pista">Talle según tabla. Obligatorio.</span><br>

            <label for="">Stock</label>
            <input type="number" class="campos" name="cantidad" value="0" min="0" required>
            <span class="pista">Cantidad en stock. Número positivo.</span><br>

            <label for="">Variante</label>
            <input type="text" class="campos" name="variante" maxlength="50">
            <span class="pista">Ej: Sin aro, Push-up, etc. Opcional.</span><br>

            <label for="">Detalles</label>
            <input type="text" class="campos" name="detalles" maxlength="100">
            <span class="pista">Detalles especiales. Opcional.</span><br>

            <label for="">Precio</label>
            <input type="number" class="campos" name="precio" min="0" step="0.01" required>
            <span class="pista">Precio con centavos.</span><br>
            
            <br>
            <button id="guardar_nuevo_modelo" type="submit">Guardar Lencería</button>
            </form>
        </div>
        
        <!-- Resto del código para modificar stock -->
        <!-- ... -->
    </div>

    <script>
        let infoPagina = document.getElementById('infoPagina');
        infoPagina.innerHTML = 'Gestión de Lencería';
        let infoGeneral = document.getElementById('infoGeneralText');
        infoGeneral.innerHTML = "Administre el stock de lencería";
        
        // Resto del JavaScript
        // ...
    </script>
</body>