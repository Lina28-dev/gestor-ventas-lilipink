<?php
include('header.php');
include('navegador.php');
include('global/conexion.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verificar conexión
if ($con->connect_error) {
    die("Error de conexión: " . $con->connect_error);
}

// Insertar cliente de prueba (solo para demostración)
$sql = "INSERT INTO fs_clientes(nombre_completo, direccion, ciudad, localidad, codigo_postal, email, telefono, cc, descuento, revendedora) 
        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $con->prepare($sql);

// Verificar si la preparación fue exitosa
if ($stmt === false) {
    die("Error al preparar la consulta: " . $con->error);
}

$nombre = "Lina Marcela Oviedo Mozo";
$direccion = "Cl 12 # 34 56";
$ciudad = "Bogotá";
$localidad = "Kennedy";
$codigo_postal = "110111";
$email = "loviedo1428@gmail.com";
$telefono = "3222346162";
$cc = "1022428711";
$descuento = 0;
$revendedora = 0;

// Vincular parámetros
$stmt->bind_param(
    "ssssssssii",
    $nombre, 
    $direccion, 
    $ciudad, 
    $localidad, 
    $codigo_postal, 
    $email, 
    $telefono, 
    $cc, 
    $descuento, 
    $revendedora
);


$stmt = $con->prepare($sql);
$stmt->bind_param("ssssssssii", $nombre, $direccion, $ciudad, $localidad, $codigo_postal, $email, $telefono, $cc, $descuento, $revendedora);

if ($stmt->execute()) {
    echo ($stmt->affected_rows > 0) 
        ? "Cliente actualizado correctamente." 
        : "Cliente registrado correctamente.";
} else {
    echo "Error: " . $stmt->error;
}
// NO cerrar la conexión aquí, se necesita más adelante
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes - Lili Pink</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Playfair+Display:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/clientes.css">
    <style>
        :root {
            --color-primario: #e83e8c;
            --color-secundario: #ff85a2;
            --color-fondo: #fff5f7;
            --color-texto: #333;
            --color-borde: #ffcce0;
        }
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--color-fondo);
            color: var(--color-texto);
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .btn-lilipink {
            background-color: var(--color-primario);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 500;
        }
        .btn-lilipink:hover {
            background-color: var(--color-secundario);
            transform: translateY(-2px);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 2px 10px rgba(232, 62, 140, 0.1);
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid var(--color-borde);
        }
        th {
            background-color: var(--color-primario);
            color: white;
            font-weight: 600;
        }
        tr:hover {
            background-color: rgba(255, 133, 162, 0.1);
        }
        .error-conexion {
            background-color: #ffebee;
            color: #d32f2f;
            padding: 15px;
            border-radius: 5px;
            margin: 20px;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sección de búsqueda de clientes -->
        <section class="buscar_cliente">
            <div class="panel-busqueda">
                <h2><i class="fas fa-search"></i> Buscar clientes</h2>
                <div class="controles-busqueda">
                    <input type="text" id="busqueda-cliente" placeholder="Nombre, teléfono o email..." class="campo-busqueda">
                    <div class="botones-busqueda">
                        <button class="btn-lilipink" onclick="buscarClientes('nombre')">Por Nombre</button>
                        <button class="btn-lilipink" onclick="buscarClientes('localidad')">Por Localidad</button>
                        <button class="btn-lilipink" onclick="buscarClientes('ciudad')">Por Ciudad</button>
                        <button class="btn-lilipink" onclick="buscarClientes('todos')">Todos</button>
                    </div>
                </div>
                
                <div class="resultados-busqueda">
                    <table id="tabla-clientes">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Contacto</th>
                                <th>Ubicación</th>
                                <th>Tipo</th>
                                <th>Descuento</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM fs_clientes ORDER BY nombre_completo LIMIT 50";
                            $result = $con->query($sql);
                            
                            if ($result->num_rows > 0) {
                                while($cliente = $result->fetch_assoc()) {
                                    echo '<tr>
                                            <td>'.htmlspecialchars($cliente['nombre_completo']).'</td>
                                            <td>
                                                <div>'.htmlspecialchars($cliente['telefono']).'</div>
                                                <div class="texto-pequeno">'.htmlspecialchars($cliente['email']).'</div>
                                            </td>
                                            <td>
                                                <div>'.htmlspecialchars($cliente['ciudad']).'</div>
                                                <div class="texto-pequeno">'.htmlspecialchars($cliente['localidad']).'</div>
                                            </td>
                                            <td>'.($cliente['revendedora'] == 1 ? '<span class="badge-revendedor">Revendedora</span>' : '<span class="badge-cliente">Cliente</span>').'</td>
                                            <td>'.htmlspecialchars($cliente['descuento']).'%</td>
                                            <td>
                                                <button class="btn-accion btn-editar" onclick="editarCliente('.$cliente['id'].')"><i class="fas fa-edit"></i></button>
                                                <button class="btn-accion btn-historial" onclick="verHistorial('.$cliente['id'].')"><i class="fas fa-history"></i></button>
                                            </td>
                                          </tr>';
                                }
                            } else {
                                echo '<tr><td colspan="6">No se encontraron clientes</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="contador-resultados">
                        Mostrando <?php echo $result->num_rows; ?> clientes
                    </div>
                </div>
            </div>
        </section>

       <!-- ////////// SECCION CLIENTE NUEVO REGISTRO ////////// -->
<section id="ingresar_cliente" style="display: none;">
    <div class="boton">
        <button id="boton_cliente">Cancelar</button>
    </div>
    
    <div id="form_cliente">
        <form action="scripts/guardar_cliente.php" method="POST" id="formulario-cliente" onsubmit="return validarFormularioCliente()">
            <!-- Grupo 1: Información Básica -->
            <div class="grupo-formulario">
                <label for="nombre_completo"><i class="fas fa-user"></i> Nombre y Apellido *</label>        
                <input type="text" id="nombre_completo" name="nombre_completo" maxlength="80" required
                       pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]{5,}" 
                       title="Mínimo 5 caracteres alfabéticos">
                <span class="pista">Mínimo 5 caracteres. Obligatorio.</span>

                <label for="tipo_identificacion"><i class="fas fa-id-card"></i> Tipo de Identificación *</label>
                <select id="tipo_identificacion" name="tipo_identificacion" required>
                    <option value="">Seleccione...</option>
                    <option value="CC" selected>Cédula de Ciudadanía (CC)</option>
                    <option value="CE">Cédula de Extranjería (CE)</option>
                    <option value="TI">Tarjeta de Identidad (TI)</option>
                    <option value="PA">Pasaporte (PA)</option>
                    <option value="NIT">NIT</option>
                </select>

                <label for="numero_identificacion"><i class="fas fa-id-card"></i> Número de Identificación *</label>
                <input type="text" id="numero_identificacion" name="numero_identificacion" required
                       pattern="[0-9]{6,12}" title="Entre 6 y 12 dígitos numéricos">
                <span class="pista">Sin puntos ni espacios. Ej: 1022428711</span>
            </div>

            <!-- Grupo 2: Contacto -->
            <div class="grupo-formulario">
                <label for="telefono"><i class="fas fa-phone"></i> Teléfono *</label>
                <input type="tel" id="telefono" name="telefono" required
                       pattern="[0-9]{7,15}" title="Número telefónico válido">
                <span class="pista">Ej: 3222346162. Obligatorio.</span>

                <label for="email"><i class="fas fa-envelope"></i> Email</label>
                <input type="email" id="email" name="email" maxlength="150">
                <span class="pista">Ej: cliente@ejemplo.com</span>
            </div>

            <!-- Grupo 3: Ubicación -->
<div class="grupo-formulario">
    <label for="direccion"><i class="fas fa-map-marked-alt"></i> Dirección</label>
    <input type="text" id="direccion" name="direccion" maxlength="200">
    <span class="pista">Máximo 200 caracteres</span>

    <label for="provincia"><i class="fas fa-globe-americas"></i> Provincia/Departamento *</label>        
    <select id="provincia" name="provincia" required onchange="actualizarCiudades()">
        <option value="">Seleccione Provincia/Departamento</option>
        <option value="Bogotá D.C." selected>Bogotá D.C.</option>
        <option value="Cundinamarca">Cundinamarca</option>
    </select>

    <label for="localidad"><i class="fas fa-city"></i> Localidad *</label>
    <select id="localidad" name="localidad" required>
        <option value="">Seleccione localidad</option>
        <option value="Usaquén">Usaquén</option>
        <option value="Chapinero">Chapinero</option>
        <option value="Santa Fe">Santa Fe</option>
        <option value="San Cristóbal">San Cristóbal</option>
        <option value="Usme">Usme</option>
        <option value="Tunjuelito">Tunjuelito</option>
        <option value="Bosa">Bosa</option>
        <option value="Kennedy">Kennedy</option>
        <option value="Fontibón">Fontibón</option>
        <option value="Engativá">Engativá</option>
        <option value="Suba">Suba</option>
        <option value="Barrios Unidos">Barrios Unidos</option>
        <option value="Teusaquillo">Teusaquillo</option>
        <option value="Los Mártires">Los Mártires</option>
        <option value="Antonio Nariño">Antonio Nariño</option>
        <option value="Puente Aranda">Puente Aranda</option>
        <option value="La Candelaria">La Candelaria</option>
        <option value="Rafael Uribe Uribe">Rafael Uribe Uribe</option>
        <option value="Ciudad Bolívar">Ciudad Bolívar</option>
        <option value="Sumapaz">Sumapaz</option>
    </select>
</div>

            <!-- Grupo 4: Código Postal -->
            <div class="grupo-formulario">
                <label for="cod_postal"><i class="fas fa-mail-bulk"></i> Código Postal</label>
                <input type="text" id="cod_postal" name="cod_postal" maxlength="8" 
                       pattern="[0-9]{4,8}">
                <span class="pista">Ej: 110111</span>
            </div>

            <!-- Grupo 5: Tipo de Cliente -->
            <div class="grupo-formulario">
                <label><i class="fas fa-tag"></i> Tipo de Cliente</label>
                <div class="opciones-radio">
                    <label>
                        <input type="radio" name="revendedora" value="0" checked> <i class="fas fa-user"></i> Cliente Normal
                    </label>
                    <label>
                        <input type="radio" name="revendedora" value="1"> <i class="fas fa-store"></i> Revendedor/a
                    </label>
                </div>
                <span class="pista">Seleccione el tipo de cliente</span>

                <div id="campo-descuento" style="display: none;">
                    <label for="descuento"><i class="fas fa-percentage"></i> Descuento (%)</label>
                    <input type="number" id="descuento" name="descuento" min="0" max="50" value="0">
                    <span class="pista">Solo para revendedores (0-50%)</span>
                </div>
            </div>

            <!-- Botón de Envío -->
            <div class="grupo-formulario">
                <button type="submit" class="btn-guardar">
                    <i class="fas fa-save"></i> Guardar Cliente
                </button>
            </div>
        </form>
    </div>
</section>

<script>
// Validación del formulario
function validarFormularioCliente() {
    // Validar número de identificación
    const numeroIdentificacion = document.getElementById('numero_identificacion').value;
    if (!/^\d{6,12}$/.test(numeroIdentificacion)) {
        alert('El número de identificación debe contener entre 6 y 12 dígitos numéricos');
        return false;
    }

    // Validar tipo de identificación
    const tipoIdentificacion = document.getElementById('tipo_identificacion').value;
    if (!tipoIdentificacion) {
        alert('Por favor seleccione un tipo de identificación');
        return false;
    }

    // Validaciones específicas por tipo de identificación
    switch(tipoIdentificacion) {
        case 'CC': // Cédula de Ciudadanía
            if (numeroIdentificacion.length !== 8 && numeroIdentificacion.length !== 10) {
                alert('La cédula de ciudadanía debe tener 8 o 10 dígitos');
                return false;
            }
            break;
        case 'CE': // Cédula de Extranjería
            if (numeroIdentificacion.length < 6) {
                alert('La cédula de extranjería debe tener mínimo 6 dígitos');
                return false;
            }
            break;
        case 'TI': // Tarjeta de Identidad
            if (numeroIdentificacion.length < 6 || numeroIdentificacion.length > 12) {
                alert('La tarjeta de identidad debe tener entre 6 y 12 dígitos');
                return false;
            }
            break;
        case 'PA': // Pasaporte
            if (numeroIdentificacion.length < 6) {
                alert('El pasaporte debe tener mínimo 6 caracteres');
                return false;
            }
            break;
        case 'NIT': // NIT
            if (numeroIdentificacion.length < 9 || numeroIdentificacion.length > 15) {
                alert('El NIT debe tener entre 9 y 15 dígitos');
                return false;
            }
            break;
    }

    // Resto de validaciones (teléfono, email, etc.)
    const telefono = document.getElementById('telefono').value;
    if (!/^\d{7,15}$/.test(telefono)) {
        alert('El teléfono debe contener entre 7 y 15 dígitos');
        return false;
    }

    const email = document.getElementById('email').value;
    if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        alert('Por favor ingrese un email válido');
        return false;
    }

    const ciudad = document.getElementById('ciudad').value;
    if (!ciudad) {
        alert('Por favor seleccione una ciudad/localidad');
        return false;
    }

    if (document.querySelector('input[name="revendedora"]:checked').value === '1') {
        const descuento = parseInt(document.getElementById('descuento').value);
        if (isNaN(descuento) || descuento < 0 || descuento > 50) {
            alert('El descuento para revendedores debe ser entre 0% y 50%');
            return false;
        }
    }

    return true;
}
</script>