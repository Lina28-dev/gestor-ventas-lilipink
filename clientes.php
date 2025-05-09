<?php
include('header.php');
include('navegador.php');
include('global/conexion.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verificar conexión
if ($con->connect_error) {
    die("<div class='error-conexion'>Error de conexión: " . $con->connect_error . "</div>");
}

// Variable para mensajes de estado
$mensaje = "";

// Procesar el formulario si se ha enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'guardar_cliente') {
    // Recoger datos del formulario
    $nombre = $_POST['nombre_completo'] ?? '';
    $tipo_id = $_POST['tipo_identificacion'] ?? '';
    $numero_id = $_POST['numero_identificacion'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $email = $_POST['email'] ?? '';
    $direccion = $_POST['direccion'] ?? '';
    $provincia = $_POST['provincia'] ?? '';
    $localidad = $_POST['localidad'] ?? '';
    $codigo_postal = $_POST['cod_postal'] ?? '';
    $revendedora = $_POST['revendedora'] ?? 0;
    $descuento = ($revendedora == 1) ? ($_POST['descuento'] ?? 0) : 0;
    
    // Validación básica del lado del servidor
    if (empty($nombre) || empty($numero_id) || empty($telefono) || empty($localidad)) {
        $mensaje = "<div class='mensaje-error'>Por favor complete todos los campos obligatorios.</div>";
    } else {
        // Verificar si el cliente ya existe (por número de identificación)
        $verificar = $con->prepare("SELECT id FROM fs_clientes WHERE numero_identificacion = ?");
        $verificar->bind_param("s", $numero_id);
        $verificar->execute();
        $resultado = $verificar->get_result();
        
        if ($resultado->num_rows > 0) {
            // El cliente ya existe, actualizamos sus datos
            $cliente = $resultado->fetch_assoc();
            $id_cliente = $cliente['id'];
            
            $sql = "UPDATE fs_clientes SET 
                    nombre_completo = ?, 
                    direccion = ?, 
                    ciudad = ?, 
                    localidad = ?, 
                    codigo_postal = ?, 
                    email = ?, 
                    telefono = ?, 
                    descuento = ?, 
                    revendedora = ? 
                    WHERE id = ?";
                    
            $stmt = $con->prepare($sql);
            $stmt->bind_param(
                "sssssssiis",
                $nombre, 
                $direccion, 
                $provincia, 
                $localidad, 
                $codigo_postal, 
                $email, 
                $telefono, 
                $descuento, 
                $revendedora,
                $id_cliente
            );
            
            if ($stmt->execute()) {
                $mensaje = "<div class='mensaje-exito'>Cliente actualizado correctamente.</div>";
            } else {
                $mensaje = "<div class='mensaje-error'>Error al actualizar cliente: " . $stmt->error . "</div>";
            }
            
        } else {
            // Es un nuevo cliente, lo insertamos
            $sql = "INSERT INTO fs_clientes(nombre_completo, direccion, ciudad, localidad, codigo_postal, email, telefono, numero_identificacion, descuento, revendedora) 
                    VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    
            $stmt = $con->prepare($sql);
            
            if ($stmt === false) {
                $mensaje = "<div class='mensaje-error'>Error al preparar la consulta: " . $con->error . "</div>";
            } else {
                $stmt->bind_param(
                    "ssssssssii",
                    $nombre, 
                    $direccion, 
                    $provincia, 
                    $localidad, 
                    $codigo_postal, 
                    $email, 
                    $telefono, 
                    $numero_id, 
                    $descuento, 
                    $revendedora
                );
                
                if ($stmt->execute()) {
                    $mensaje = "<div class='mensaje-exito'>Cliente registrado correctamente.</div>";
                } else {
                    $mensaje = "<div class='mensaje-error'>Error al registrar cliente: " . $stmt->error . "</div>";
                }
            }
        }
    }
}

// Función para buscar clientes
if (isset($_GET['buscar']) && isset($_GET['termino']) && isset($_GET['tipo'])) {
    $termino = "%{$_GET['termino']}%";
    $tipo = $_GET['tipo'];
    
    switch ($tipo) {
        case 'nombre':
            $sql = "SELECT * FROM fs_clientes WHERE nombre_completo LIKE ? ORDER BY nombre_completo LIMIT 50";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("s", $termino);
            break;
        case 'localidad':
            $sql = "SELECT * FROM fs_clientes WHERE localidad LIKE ? ORDER BY nombre_completo LIMIT 50";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("s", $termino);
            break;
        case 'ciudad':
            $sql = "SELECT * FROM fs_clientes WHERE ciudad LIKE ? ORDER BY nombre_completo LIMIT 50";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("s", $termino);
            break;
        default:
            $sql = "SELECT * FROM fs_clientes ORDER BY nombre_completo LIMIT 50";
            $stmt = $con->prepare($sql);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Consulta predeterminada
    $sql = "SELECT * FROM fs_clientes ORDER BY nombre_completo LIMIT 50";
    $result = $con->query($sql);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes - Lili Pink</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Playfair+Display:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/clientes.css">
    <style>
        :root {
            --color-primario: #e83e8c;
            --color-secundario: #ff85a2;
            --color-fondo: #fff5f7;
            --color-texto: #333;
            --color-borde: #ffcce0;
            --color-exito: #28a745;
            --color-error: #dc3545;
        }
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--color-fondo);
            color: var(--color-texto);
            margin: 0;
            padding: 0;
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
            background-color: white;
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
        .error-conexion, .mensaje-error {
            background-color: #ffebee;
            color: #d32f2f;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: 500;
        }
        .mensaje-exito {
            background-color: #e8f5e9;
            color: #2e7d32;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: 500;
        }
        .panel-busqueda {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(232, 62, 140, 0.1);
            margin-bottom: 30px;
        }
        .panel-busqueda h2 {
            color: var(--color-primario);
            margin-top: 0;
        }
        .controles-busqueda {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }
        .campo-busqueda {
            flex: 1;
            padding: 10px 15px;
            border: 1px solid var(--color-borde);
            border-radius: 20px;
            font-family: 'Montserrat', sans-serif;
        }
        .botones-busqueda {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .badge-revendedor {
            background-color: var(--color-primario);
            color: white;
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 0.8em;
        }
        .badge-cliente {
            background-color: var(--color-secundario);
            color: white;
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 0.8em;
        }
        .texto-pequeno {
            font-size: 0.8em;
            color: #777;
        }
        .btn-accion {
            background-color: transparent;
            border: none;
            cursor: pointer;
            margin-right: 5px;
            color: var(--color-primario);
            transition: all 0.2s;
        }
        .btn-accion:hover {
            color: var(--color-secundario);
            transform: scale(1.2);
        }
        .contador-resultados {
            text-align: right;
            font-size: 0.9em;
            color: #777;
            margin-top: 10px;
        }
        
        /* Estilos para el formulario de cliente */
        #ingresar_cliente {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(232, 62, 140, 0.1);
            margin-bottom: 30px;
        }
        .boton {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }
        #boton_cliente {
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s;
        }
        #boton_cliente:hover {
            background-color: #5a6268;
        }
        #form_cliente {
            background-color: #fff;
            border-radius: 8px;
        }
        .grupo-formulario {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 8px;
        }
        .grupo-formulario label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: var(--color-primario);
        }
        .grupo-formulario input, 
        .grupo-formulario select {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--color-borde);
            border-radius: 5px;
            font-family: 'Montserrat', sans-serif;
            margin-bottom: 5px;
        }
        .pista {
            display: block;
            font-size: 0.8em;
            color: #777;
            margin-bottom: 10px;
        }
        .opciones-radio {
            display: flex;
            gap: 20px;
            margin: 10px 0;
        }
        .opciones-radio label {
            display: flex;
            align-items: center;
            cursor: pointer;
        }
        .opciones-radio input {
            width: auto;
            margin-right: 5px;
        }
        .btn-guardar {
            background-color: var(--color-primario);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 600;
            width: 100%;
        }
        .btn-guardar:hover {
            background-color: var(--color-secundario);
            transform: translateY(-2px);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .controles-busqueda {
                flex-direction: column;
            }
            .botones-busqueda {
                justify-content: space-between;
            }
            .grupo-formulario {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <?php 
        // Mostrar mensaje de estado si existe
        if (!empty($mensaje)) {
            echo $mensaje;
        }
        ?>
        
        <!-- Panel de control -->
        <div class="panel-control">
            <button id="btn-mostrar-busqueda" class="btn-lilipink">
                <i class="fas fa-search"></i> Buscar Clientes
            </button>
            <button id="btn-mostrar-registro" class="btn-lilipink">
                <i class="fas fa-user-plus"></i> Nuevo Cliente
            </button>
        </div>
        
        <!-- Sección de búsqueda de clientes -->
        <section id="buscar_cliente" class="seccion-panel">
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
                                <th>Identificación</th>
                                <th>Contacto</th>
                                <th>Ubicación</th>
                                <th>Tipo</th>
                                <th>Descuento</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result && $result->num_rows > 0) {
                                while($cliente = $result->fetch_assoc()) {
                                    echo '<tr>
                                            <td>'.htmlspecialchars($cliente['nombre_completo']).'</td>
                                            <td>'.htmlspecialchars($cliente['cc']).'</td>
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
                                                <button class="btn-accion btn-seleccionar" onclick="seleccionarCliente('.$cliente['id'].',\''.htmlspecialchars($cliente['nombre_completo'], ENT_QUOTES).'\',\''.htmlspecialchars($cliente['cc'], ENT_QUOTES).'\')"><i class="fas fa-check-circle"></i></button>
                                            </td>
                                          </tr>';
                                }
                            } else {
                                echo '<tr><td colspan="7">No se encontraron clientes</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="contador-resultados">
                        Mostrando <?php echo $result ? $result->num_rows : 0; ?> clientes
                    </div>
                </div>
            </div>
        </section>

        <!-- Sección para formulario de nuevo cliente -->
        <section id="ingresar_cliente" style="display: none;">
            <div class="boton">
                <button id="boton_cliente" class="btn-cancelar">
                    <i class="fas fa-times"></i> Cancelar
                </button>
            </div>
            
            <div id="form_cliente">
                <h2><i class="fas fa-user-plus"></i> Registrar nuevo cliente</h2>
                
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" id="formulario-cliente" onsubmit="return validarFormularioCliente()">
                    <input type="hidden" name="accion" value="guardar_cliente">
                    
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
                            <option value="Antioquia">Antioquia</option>
                            <option value="Valle del Cauca">Valle del Cauca</option>
                            <option value="Atlántico">Atlántico</option>
                            <option value="Santander">Santander</option>
                            <option value="Bolívar">Bolívar</option>
                        </select>

                        <label for="localidad"><i class="fas fa-city"></i> Localidad/Ciudad *</label>
                        <select id="localidad" name="localidad" required>
                            <option value="">Seleccione localidad</option>
                            <option value="Usaquén">Usaquén</option>
                            <option value="Chapinero">Chapinero</option>
                            <option value="Santa Fe">Santa Fe</option>
                            <option value="San Cristóbal">San Cristóbal</option>
                            <option value="Usme">Usme</option>
                            <option value="Tunjuelito">Tunjuelito</option>
                            <option value="Bosa">Bosa</option>
                            <option value="Kennedy" selected>Kennedy</option>
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
                               pattern="[0-9]{4,8}" value="110111">
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
    </div>

<script>
// Manejo de pestañas
document.addEventListener('DOMContentLoaded', function() {
    const btnMostrarBusqueda = document.getElementById('btn-mostrar-busqueda');
    const btnMostrarRegistro = document.getElementById('btn-mostrar-registro');
    const seccionBuscar = document.getElementById('buscar_cliente');
    const seccionIngresar = document.getElementById('ingresar_cliente');
    const botonCancelar = document.getElementById('boton_cliente');
    
    btnMostrarBusqueda.addEventListener('click', function() {
        seccionBuscar.style.display = 'block';
        seccionIngresar.style.display = 'none';
    });
    
    btnMostrarRegistro.addEventListener('click', function() {
        seccionBuscar.style.display = 'none';
        seccionIngresar.style.display = 'block';
    });
    
    botonCancelar.addEventListener('click', function() {
        seccionIngresar.style.display = 'none';
        seccionBuscar.style.display = 'block';
    });
    
    // Mostrar/ocultar campo de descuento según el tipo de cliente
    const tipoClienteRadios = document.querySelectorAll('input[name="revendedora"]');
    const campoDescuento = document.getElementById('campo-descuento');
    
    tipoClienteRadios.forEach(function(radio) {
        radio.addEventListener('change', function() {
            if (this.value === '1') {
                campoDescuento.style.display = 'block';
            } else {
                campoDescuento.style.display = 'none';
                document.getElementById('descuento').value = '0';
            }
        });
    });
});

// Funciones de búsqueda
function buscarClientes(tipo) {
    const termino = document.getElementById('busqueda-cliente').value;
    window.location.href = `clientes.php?buscar=1&termino=${encodeURIComponent(termino)}&tipo=${tipo}`;
}

// Actualizar ciudades según provincia/departamento
function actualizarCiudades() {
    const provincia = document.getElementById('provincia').value;
    const localidad = document.getElementById('localidad');
    
    // Limpiar opciones actuales
    localidad.innerHTML = '<option value="">Seleccione localidad</option>';
    
    if (provincia === 'Bogotá D.C.') {
        const localidadesBogota = [
            "Usaquén", "Chapinero", "Santa Fe", "San Cristóbal", "Usme",