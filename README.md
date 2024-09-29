# Ruleta de Apuestas - Proyecto PHP

Este es un sistema de apuestas de ruleta, desarrollado en PHP con funcionalidades CRUD para gestionar jugadores, realizar apuestas, y una lógica de probabilidades para la ruleta. El proyecto simula rondas de juego con apuestas en tiempo real y muestra ganancias o pérdidas dependiendo del resultado de cada giro.

## Funcionalidades Principales

1. **CRUD de Jugadores**: 
   - Crear, actualizar, eliminar y visualizar información de jugadores.
   - Los jugadores comienzan con un saldo inicial de $10,000.

2. **Apuestas Automáticas**:
   - Los jugadores apuestan un porcentaje entre el 8% y 15% de su saldo por ronda.

3. **Simulación de la Ruleta**:
   - Colores disponibles para apostar: Verde, Rojo y Negro.
   - Probabilidades de ganar:
     - Verde: 2% de probabilidad.
     - Rojo: 49% de probabilidad.
     - Negro: 49% de probabilidad.
   - Si el jugador gana apostando al Verde, obtiene 15 veces el valor de su apuesta.
   - Si el jugador gana apostando al Rojo o Negro, obtiene el doble del valor de su apuesta.

4. **Gestión de Saldo**:
   - El sistema verifica que el jugador no apueste si su saldo es de $1,000 o menor.
   - Si el saldo es mayor a $1,000, el jugador puede seguir apostando automáticamente.
   - Cada ronda se actualiza el saldo y se muestra si el jugador ha ganado o perdido.

## Requisitos de Instalación

### 1. Prerrequisitos:
   - Servidor local con PHP (por ejemplo, XAMPP, WAMP, MAMP).
   - MySQL para la base de datos.
   - Navegador web para interactuar con la aplicación.

### 2. Instalación:
   1. **Clonar el Proyecto** (sin usar Git):
      - Descarga el proyecto desde un archivo comprimido (.zip).
      - Extrae el contenido en el directorio raíz de tu servidor web (ej: `htdocs` en XAMPP).

   2. **Configurar la Base de Datos**:
      - Crea una base de datos llamada `casino` en MySQL.
      - Importa el archivo SQL proporcionado (`db.sql`) para crear las tablas necesarias.

   3. **Configuración del Archivo de Conexión a la Base de Datos**:
      - Abre el archivo `includes/db.php`.
      - Asegúrate de configurar los parámetros de conexión a tu base de datos, incluyendo:
        ```php
        $host = 'localhost';
        $dbname = 'apuesta_db';
        $user = 'tu_usuario';
        $pass = 'tu_contraseña';
        ```

   4. **Iniciar el Servidor**:
      - Si usas XAMPP, inicia el módulo de Apache y MySQL.
      - Accede al proyecto en tu navegador en `http://localhost/ruta/index.php`.

### 3. Estructura del Proyecto:
   - **`index.php`**: Página principal con la lista de jugadores.
   - **`views/roulette.php`**: Lógica y vista de la ruleta donde los jugadores apuestan.
   - **`includes/functions.php`**: Funciones auxiliares (CRUD y lógica de apuestas).
   - **`css/style.css`**: Estilos de la interfaz del sistema.

### 4. Uso de la Aplicación:
   1. Accede a la página principal (`index.php`) para visualizar o crear jugadores.
   2. Selecciona un jugador para ingresar a la vista de la ruleta.
   3. Apuesta a uno de los colores (Verde, Rojo o Negro) y observa los resultados de la ruleta.
   4. Revisa el saldo del jugador después de cada giro y ve las ganancias o pérdidas.
   
## Funciones Clave

### 1. `spinRoulette($bet, $color)`
   - Genera el resultado de la ruleta con un número aleatorio entre 1 y 100.
   - Retorna el color ganador:
     - Verde (2% de probabilidad)
     - Rojo (49% de probabilidad)
     - Negro (49% de probabilidad)

### 2. Manejo del Formulario de Apuestas
   - Calcula un porcentaje aleatorio (entre 8% y 15%) del saldo disponible del jugador para apostar.
   - Si el jugador acierta el color:
     - Si es Verde, multiplica la apuesta por 15.
     - Si es Rojo o Negro, multiplica la apuesta por 2.
   - Si el jugador pierde, resta la apuesta del saldo.
   - Actualiza el saldo del jugador y lo guarda en la base de datos.

### 3. Redirección Automática
   - Si el saldo del jugador es menor o igual a $1,000, es redirigido a la página principal.

## Consideraciones
   - El proyecto está diseñado para simular una experiencia de apuestas en un entorno controlado.
   - Asegúrate de revisar la lógica de apuestas y personalizarla si deseas ajustar las probabilidades o premios.

