<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes - Lili Pink</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --color-primario: #e83e8c;
            --color-secundario: #ff85a2;
            --color-fondo: #fff5f7;
            --color-texto: #333;
            --color-borde: #ffcce0;
            --color-exito: #28a745;
            --color-error: #dc3545;
            --sombra-suave: 0 4px 20px rgba(232, 62, 140, 0.1);
            --border-radius: 12px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            color: var(--color-texto);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        /* Fondo animado con degradados y formas geométricas */
        .background-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: 
                radial-gradient(ellipse at top left, rgba(255, 105, 180, 0.15) 0%, transparent 50%),
                radial-gradient(ellipse at top right, rgba(255, 20, 147, 0.1) 0%, transparent 50%),
                radial-gradient(ellipse at bottom left, rgba(255, 182, 193, 0.2) 0%, transparent 50%),
                radial-gradient(ellipse at bottom right, rgba(255, 105, 180, 0.12) 0%, transparent 50%),
                linear-gradient(135deg, #fff5f7 0%, #ffe4e9 25%, #ffffff 50%, #fff0f3 75%, #fff5f7 100%);
        }

        /* Elementos decorativos flotantes */
        .floating-elements {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }

        .floating-element {
            position: absolute;
            border-radius: 50%;
            animation: float 20s infinite linear;
            opacity: 0.1;
        }

        .floating-element:nth-child(1) {
            width: 80px;
            height: 80px;
            background: linear-gradient(45deg, #e83e8c, #ff85a2);
            top: 20%;
            left: 10%;
            animation-duration: 25s;
        }

        .floating-element:nth-child(2) {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #ff69b4, #ff1493);
            top: 60%;
            right: 15%;
            animation-duration: 30s;
            animation-direction: reverse;
        }

        .floating-element:nth-child(3) {
            width: 60px;
            height: 60px;
            background: linear-gradient(225deg, #ffb6c1, #ffc0cb);
            top: 80%;
            left: 20%;
            animation-duration: 35s;
        }

        .floating-element:nth-child(4) {
            width: 100px;
            height: 100px;
            background: linear-gradient(315deg, #ff85a2, #e83e8c);
            top: 10%;
            right: 30%;
            animation-duration: 28s;
            animation-direction: reverse;
        }

        .floating-element:nth-child(5) {
            width: 140px;
            height: 140px;
            background: linear-gradient(45deg, #ffc0cb, #ff69b4);
            top: 45%;
            left: 5%;
            animation-duration: 40s;
        }

        .floating-element:nth-child(6) {
            width: 90px;
            height: 90px;
            background: linear-gradient(180deg, #ff1493, #e83e8c);
            top: 25%;
            right: 5%;
            animation-duration: 22s;
            animation-direction: reverse;
        }

        /* Formas geométricas decorativas */
        .geometric-shapes::before,
        .geometric-shapes::after {
            content: '';
            position: fixed;
            pointer-events: none;
            z-index: -1;
        }

        .geometric-shapes::before {
            width: 200px;
            height: 200px;
            background: linear-gradient(45deg, rgba(255, 105, 180, 0.08), rgba(255, 20, 147, 0.05));
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            top: 15%;
            right: 10%;
            animation: morph 15s infinite;
        }

        .geometric-shapes::after {
            width: 150px;
            height: 150px;
            background: linear-gradient(135deg, rgba(255, 182, 193, 0.1), rgba(255, 105, 180, 0.06));
            border-radius: 63% 37% 54% 46% / 55% 48% 52% 45%;
            bottom: 20%;
            left: 8%;
            animation: morph 20s infinite reverse;
        }

        /* Animaciones */
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            25% { transform: translateY(-20px) rotate(90deg); }
            50% { transform: translateY(-10px) rotate(180deg); }
            75% { transform: translateY(-30px) rotate(270deg); }
        }

        @keyframes morph {
            0%, 100% { 
                border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
                transform: translate(0, 0) rotate(0deg);
            }
            25% { 
                border-radius: 58% 42% 75% 25% / 76% 46% 54% 24%;
                transform: translate(10px, -10px) rotate(90deg);
            }
            50% { 
                border-radius: 50% 50% 33% 67% / 55% 27% 73% 45%;
                transform: translate(-10px, 10px) rotate(180deg);
            }
            75% { 
                border-radius: 33% 67% 58% 42% / 63% 68% 32% 37%;
                transform: translate(-5px, -15px) rotate(270deg);
            }
        }

        /* Contenido principal */
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
            position: relative;
            z-index: 1;
        }

        .panel-control {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .btn-lilipink {
            background: linear-gradient(135deg, var(--color-primario), var(--color-secundario));
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: var(--sombra-suave);
        }

        .btn-lilipink:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(232, 62, 140, 0.4);
        }

        .seccion-panel {
            background: rgba(255,255,255,0.95);
            padding: 30px;
            border-radius: var(--border-radius);
            box-shadow: var(--sombra-suave);
            margin-bottom: 30px;
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .seccion-panel::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--color-primario), var(--color-secundario), var(--color-primario));
            background-size: 200% 100%;
            animation: gradient-shift 3s ease infinite;
        }

        @keyframes gradient-shift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        .seccion-panel h2 {
            color: var(--color-primario);
            margin-bottom: 25px;
            font-size: 1.8em;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .controles-busqueda {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 20px;
            margin-bottom: 25px;
            align-items: start;
        }

        .campo-busqueda {
            padding: 15px 20px;
            border: 2px solid var(--color-borde);
            border-radius: 25px;
            font-family: 'Montserrat', sans-serif;
            transition: all 0.3s ease;
            font-size: 1em;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }

        .campo-busqueda:focus {
            outline: none;
            border-color: var(--color-primario);
            box-shadow: 0 0 15px rgba(232, 62, 140, 0.2);
            background: rgba(255, 255, 255, 1);
        }

        .botones-busqueda {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .btn-busqueda {
            background: linear-gradient(135deg, #6c757d, #495057);
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.9em;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .btn-busqueda:hover, .btn-busqueda.activo {
            background: linear-gradient(135deg, var(--color-primario), var(--color-secundario));
            transform: translateY(-1px);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: var(--sombra-suave);
            background: rgba(255, 255, 255, 0.95);
            border-radius: var(--border-radius);
            overflow: hidden;
            backdrop-filter: blur(10px);
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid rgba(240, 240, 240, 0.8);
        }

        th {
            background: linear-gradient(135deg, var(--color-primario), var(--color-secundario));
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85em;
            letter-spacing: 0.5px;
        }

        tbody tr {
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.7);
        }

        tbody tr:nth-child(even) {
            background: rgba(248, 249, 250, 0.8);
        }

        tbody tr:hover {
            background: rgba(232, 62, 140, 0.1);
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(232, 62, 140, 0.1);
        }

        .badge-revendedor {
            background: linear-gradient(135deg, var(--color-primario), var(--color-secundario));
            color: white;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 0.8em;
            font-weight: 500;
        }

        .badge-cliente {
            background: linear-gradient(135deg, #17a2b8, #20c997);
            color: white;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 0.8em;
            font-weight: 500;
        }

        .mensaje-exito, .mensaje-error {
            padding: 15px 20px;
            border-radius: var(--border-radius);
            margin: 20px 0;
            font-weight: 500;
            border-left: 4px solid;
            animation: slideIn 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .mensaje-exito {
            background: rgba(212, 237, 218, 0.9);
            color: #155724;
            border-color: #28a745;
        }

        .mensaje-error {
            background: rgba(248, 215, 218, 0.9);
            color: #721c24;
            border-color: #dc3545;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container { padding: 15px; }
            .controles-busqueda { 
                grid-template-columns: 1fr;
                gap: 15px;
            }
            .botones-busqueda { justify-content: center; }
            
            .floating-element {
                display: none;
            }
            
            .geometric-shapes::before,
            .geometric-shapes::after {
                display: none;
            }
        }

        /* Efectos adicionales para mejorar la experiencia visual */
        .container::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 80%, rgba(255, 105, 180, 0.03) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 20, 147, 0.03) 0%, transparent 50%);
            pointer-events: none;
            z-index: -1;
            animation: pulse 10s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 0.5; }
            50% { opacity: 0.8; }
        }
    </style>
</head>
<body>
    <!-- Fondo animado -->
    <div class="background-container"></div>
    <div class="floating-elements">
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
    </div>
    <div class="geometric-shapes"></div>

    <div class="container">
        <!-- Panel de control -->
        <div class="panel-control">
            <button class="btn-lilipink" onclick="toggleFormulario()">
                <i class="fas fa-user-plus"></i> Nuevo Cliente
            </button>
            <a href="#" class="btn-lilipink">
                <i class="fas fa-file-excel"></i> Exportar Excel
            </a>
            <a href="#" class="btn-lilipink">
                <i class="fas fa-print"></i> Imprimir Lista
            </a>
        </div>

        <!-- Mensaje de respuesta -->
        <div id="mensaje-respuesta"></div>

        <!-- Sección de búsqueda -->
        <div class="seccion-panel">
            <h2><i class="fas fa-search"></i> Buscar Clientes</h2>
            <div class="controles-busqueda">
                <input type="text" class="campo-busqueda" placeholder="Ingrese su búsqueda..." id="campo-busqueda">
                <div class="botones-busqueda">
                    <button class="btn-busqueda activo" data-tipo="todos">
                        <i class="fas fa-list"></i> Todos
                    </button>
                    <button class="btn-busqueda" data-tipo="nombre">
                        <i class="fas fa-user"></i> Nombre
                    </button>
                    <button class="btn-busqueda" data-tipo="localidad">
                        <i class="fas fa-map-marker-alt"></i> Localidad
                    </button>
                    <button class="btn-busqueda" data-tipo="identificacion">
                        <i class="fas fa-id-card"></i> ID
                    </button>
                </div>
            </div>
        </div>

        <!-- Formulario para ingresar cliente -->
        <div class="seccion-panel" id="formulario-cliente" style="display: none;">
            <button class="btn-cancelar" onclick="toggleFormulario()">
                <i class="fas fa-times"></i> Cancelar
            </button>
            <h2><i class="fas fa-user-plus"></i> Ingresar Cliente</h2>
            <form id="ingresar_cliente" method="POST" action="" autocomplete="off">
                <input type="hidden" name="csrf_token" value="token123">
                <input type="hidden" name="accion" value="guardar_cliente">
                
                <div class="grupo-formulario">
                    <label for="nombre_completo">
                        <i class="fas fa-user"></i> Nombre completo
                    </label>
                    <input type="text" name="nombre_completo" required minlength="5" pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+">
                    <span class="pista">Mínimo 5 caracteres, solo letras</span>
                </div>

                <div class="grupo-formulario">
                    <label for="tipo_identificacion">
                        <i class="fas fa-id-card"></i> Tipo de identificación
                    </label>
                    <select name="tipo_identificacion" required>
                        <option value="">Seleccione...</option>
                        <option value="CC">Cédula</option>
                        <option value="TI">Tarjeta de Identidad</option>
                        <option value="NIT">NIT</option>
                    </select>
                </div>

                <div class="grupo-formulario">
                    <label for="numero_identificacion">
                        <i class="fas fa-hashtag"></i> Número de identificación
                    </label>
                    <input type="text" name="numero_identificacion" required pattern="[0-9]{6,12}">
                    <span class="pista">Entre 6 y 12 dígitos</span>
                </div>

                <div class="grupo-formulario">
                    <label for="telefono">
                        <i class="fas fa-phone"></i> Teléfono
                    </label>
                    <input type="text" name="telefono" required pattern="[0-9]{7,15}">
                    <span class="pista">Entre 7 y 15 dígitos</span>
                </div>

                <div class="grupo-formulario">
                    <label for="email">
                        <i class="fas fa-envelope"></i> Email
                    </label>
                    <input type="email" name="email" maxlength="150">
                </div>

                <div class="grupo-formulario">
                    <label for="direccion">
                        <i class="fas fa-home"></i> Dirección
                    </label>
                    <input type="text" name="direccion">
                </div>

                <div class="grupo-formulario">
                    <label for="provincia">
                        <i class="fas fa-map"></i> Provincia
                    </label>
                    <input type="text" name="provincia">
                </div>

                <div class="grupo-formulario">
                    <label for="localidad">
                        <i class="fas fa-map-marker-alt"></i> Localidad
                    </label>
                    <input type="text" name="localidad" required>
                </div>

                <div class="grupo-formulario">
                    <label for="cod_postal">
                        <i class="fas fa-mail-bulk"></i> Código Postal
                    </label>
                    <input type="text" name="cod_postal">
                </div>

                <div class="grupo-formulario">
                    <label><i class="fas fa-store"></i> ¿Es revendedora?</label>
                    <div class="opciones-radio">
                        <label><input type="radio" name="revendedora" value="1"> Sí</label>
                        <label><input type="radio" name="revendedora" value="0" checked> No</label>
                    </div>
                </div>

                <div class="grupo-formulario">
                    <label for="descuento">
                        <i class="fas fa-percent"></i> Descuento (%)
                    </label>
                    <input type="number" name="descuento" min="0" max="100" value="0">
                </div>

                <button type="submit" class="btn-guardar">
                    <i class="fas fa-save"></i> Guardar Cliente
                </button>
            </form>
        </div>

        <!-- Lista de clientes -->
        <div class="seccion-panel">
            <h2><i class="fas fa-users"></i> Lista de Clientes</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Identificación</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Localidad</th>
                        <th>Tipo</th>
                        <th>Descuento</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>María García López</td>
                        <td>CC 12345678</td>
                        <td>3001234567</td>
                        <td>maria@email.com</td>
                        <td>Bogotá</td>
                        <td><span class="badge-revendedor"><i class="fas fa-store"></i> Revendedora</span></td>
                        <td>15%</td>
                        <td>
                            <button class="btn-accion" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-accion" title="Ver detalles">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>Ana Rodríguez</td>
                        <td>CC 87654321</td>
                        <td>3009876543</td>
                        <td>ana@email.com</td>
                        <td>Medellín</td>
                        <td><span class="badge-cliente"><i class="fas fa-user"></i> Cliente</span></td>
                        <td>0%</td>
                        <td>
                            <button class="btn-accion" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-accion" title="Ver detalles">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>Carmen Pérez</td>
                        <td>CC 11223344</td>
                        <td>3005678901</td>
                        <td>carmen@email.com</td>
                        <td>Cali</td>
                        <td><span class="badge-revendedor"><i class="fas fa-store"></i> Revendedora</span></td>
                        <td>20%</td>
                        <td>
                            <button class="btn-accion" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-accion" title="Ver detalles">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="contador-resultados">
                Mostrando 3 de 3 clientes encontrados
            </div>
        </div>
    </div>

    <script>
        // Función para mostrar/ocultar formulario
        function toggleFormulario() {
            const formulario = document.getElementById('formulario-cliente');
            const busqueda = document.querySelector('.seccion-panel');
            
            if (formulario.style.display === 'none') {
                formulario.style.display = 'block';
                formulario.scrollIntoView({ behavior: 'smooth' });
            } else {
                formulario.style.display = 'none';
            }
        }

        // Manejo de botones de búsqueda
        document.querySelectorAll('.btn-busqueda').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.btn-busqueda').forEach(b => b.classList.remove('activo'));
                this.classList.add('activo');
            });
        });

        // Validación del formulario
        document.getElementById('ingresar_cliente').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Simulación de envío exitoso
            const mensaje = document.createElement('div');
            mensaje.className = 'mensaje-exito';
            mensaje.innerHTML = '<i class="fas fa-check-circle"></i> Cliente guardado correctamente';
            
            const container = document.querySelector('.container');
            container.insertBefore(mensaje, container.firstChild);
            
            // Ocultar formulario
            document.getElementById('formulario-cliente').style.display = 'none';
            
            // Limpiar formulario
            this.reset();
            
            // Remover mensaje después de 5 segundos
            setTimeout(() => {
                mensaje.remove();
            }, 5000);
        });

        // Animaciones de entrada para los elementos
        window.addEventListener('load', function() {
            const panels = document.querySelectorAll('.seccion-panel');
            panels.forEach((panel, index) => {
                setTimeout(() => {
                    panel.style.animation = 'slideIn 0.5s ease forwards';
                }, index * 100);
            });
        });
    </script>
</body>
</html>