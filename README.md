# Portal de Acceso para Clientes — Prueba Técnica Novaq

Este proyecto consiste en un sistema de acceso exclusivo para clientes de una empresa. Fue desarrollado con Laravel 12, PHP 8.2, MySQL y Blade.

## Contexto del proyecto

El requerimiento consiste en construir un ingreso seguro para un portal privado, donde solo los clientes registrados de la empresa pueden acceder. El sistema incluye validación de credenciales y un flujo completo de recuperación de contraseña para los casos en que el cliente no recuerde sus datos de acceso.

Como que se trata de un portal exclusivo y no de un registro público, los usuarios son gestionados internamente mediante seeders, lo que simula el proceso real donde un administrador da de alta a los clientes.

## Requisitos

- PHP 8.2 o superior
- Composer 2.x
- MySQL 5.7 o superior
- XAMPP o cualquier servidor local con MySQL activo

## Instalación

### 1. Clonar o descomprimir el proyecto

Si lo prefieres como archivo comprimido, extráelo en la carpeta de tu servidor local. Si lo prefieres por Git:

git clone 
cd PruebaTecnicaNovaq

### 2. Instalar dependencias

composer install

### 3. Crear el archivo de configuración

cp .env.example .env

En Windows puedes copiar y renombrar el archivo `.env.example` manualmente si el comando no funciona.

### 4. Generar la clave de la aplicación

php artisan key:generate

### 5. Configurar la base de datos

Abre el archivo `.env` y edita las siguientes líneas con tus datos de MySQL:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=prueba_tecnica_novaq
DB_USERNAME=root
DB_PASSWORD=tu_password_aqui

### 6. Crear la base de datos

Crea una base de datos con el nombre `prueba_tecnica_novaq`.

### 7. Ejecutar migraciones y seeders

php artisan migrate --seed

Esto crea todas las tablas necesarias e inserta los usuarios de prueba automáticamente.

### 8. Levantar el servidor

php artisan serve

## Credenciales de prueba

 Nombre       | Email                | Contraseña 
--------------|----------------------|------------
 Cliente Uno  | cliente1@novaq.com   | password123
 Cliente Dos  | cliente2@novaq.com   | password123

## Flujos disponibles

**Inicio de sesión**
Accede con las credenciales de la tabla anterior, si los campos están vacíos o las credenciales son incorrectas, el sistema mostrará mensajes de error descriptivos junto a cada campo.

**Recuperación de contraseña**
Desde la pantalla de login, el cliente puede hacer clic en "¿Olvidaste tu contraseña?" e ingresar su correo. Como el proyecto está en entorno de pruebas, el enlace de recuperación se muestra directamente en pantalla en lugar de enviarse por correo, lo que permite que cualquier evaluador pueda probar el flujo completo sin necesidad de acceder a una bandeja de correo externa.

**Area privada**
Una vez autenticado, el cliente accede al dashboard donde se muestra su nombre y correo. Las rutas privadas están protegidas con middleware, por lo que no es posible acceder al dashboard sin haber iniciado sesión previamente.

**Cierre de sesión**
Desde el dashboard, el cliente puede cerrar sesión con el botón correspondiente.

## Pruebas automatizadas

El proyecto incluye pruebas con PHPUnit que cubre validaciones, autenticación, protección de rutas, sesiones y recuperación de contraseña.

Para ejecutarlas:

php artisan test

## Decisiones de diseño

- No se implementó registro público de usuarios porque el sistema es un portal exclusivo. Los clientes son dados de alta por el administrador, lo cual se simula con seeders.
- La recuperación de contraseña muestra el enlace en pantalla únicamente en entorno de pruebas. En producción, este enlace se enviaría por correo electrónico.
- Las contraseñas se almacenan encriptadas con bcrypt. Nunca se guardan en texto plano.
- Todos los formularios incluyen protección CSRF integrada de Laravel.
