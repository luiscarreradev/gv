
# Prueba Técnica: Réplica del Home de Guatemala Visible

Este proyecto es una réplica parcial de la página de inicio del sitio web [GuatemalaVisible.net](https://guatemalavisible.net/v2025/), desarrollada como parte de una prueba técnica para demostrar habilidades en maquetación y uso de herramientas visuales en WordPress.

El objetivo principal fue replicar la **estructura visual y el diseño** de las secciones clave del sitio original, con un enfoque en la fidelidad visual y la responsividad móvil.

## 🚀 Tecnologías Utilizadas

* **CMS**: WordPress
* **Servidor Local**: XAMPP
* **Tema**: Hello Elementor
* **Maquetador Visual**: Elementor

## 📋 Prerrequisitos

Antes de comenzar, asegúrate de tener instalado y en funcionamiento **XAMPP** en tu computadora. Puedes descargarlo desde [apachefriends.org](https://www.apachefriends.org/index.html).

* Verifica que los servicios de **Apache** y **MySQL** estén activos en el panel de control de XAMPP.

## ⚙️ Guía de Instalación Local

Sigue estos pasos detalladamente para instalar y ejecutar el proyecto en tu máquina.

#### 1. Clonar o Descargar el Repositorio
Obtén los archivos del proyecto. Si usas Git, clona el repositorio. De lo contrario, descarga el archivo ZIP y descomprímelo.

#### 2. Colocar los Archivos del Proyecto
Copia la carpeta completa del proyecto dentro del directorio `htdocs` de tu instalación de XAMPP. Renombra la carpeta a `gv`. La ruta final debe ser: C:\xampp\htdocs\gv

*(La ruta puede variar según tu sistema operativo)*. 

#### 3. Crear la Base de Datos 

Abre tu navegador y ve a `http://localhost/phpmyadmin/`. - Crea una nueva base de datos. El nombre debe coincidir con el definido en el archivo `wp-config.php` (ej. `guatemala_visible_db`). - Selecciona la base de datos recién creada. #### 4. Importar la Base de Datos - Dentro de phpMyAdmin, ve a la pestaña **Importar**. - Haz clic en "Seleccionar archivo" y busca el archivo `.sql` de la base de datos que se encuentra dentro de la carpeta del proyecto (ej. `C:\xampp\htdocs\gv\database.sql`). - Haz clic en **Importar** en la parte inferior de la página y espera a que finalice el proceso. #### 5. Verificar `wp-config.php` Abre el archivo `wp-config.php` ubicado en la raíz del proyecto (`C:\xampp\htdocs\gv`) y asegúrate de que las credenciales de la base de datos sean correctas para un entorno XAMPP estándar: 

```php define( 'DB_NAME', 'gb' ); define( 'DB_USER', 'root' ); define( 'DB_PASSWORD', '' ); define( 'DB_HOST', 'localhost' );```

#### 6. (Paso Crucial) Actualizar Permalinks
Una vez importada la base de datos, es fundamental regenerar las reglas de reescritura de WordPress para que los enlaces y la URL de acceso personalizada funcionen correctamente.
-   Accede al panel de administración (las credenciales están en `auth.txt`).
-   Ve a **Ajustes → Enlaces permanentes**.
-   No necesitas cambiar nada. Simplemente haz clic en el botón **Guardar cambios**. Esto regenerará el archivo `.htaccess` y corregirá cualquier error de "Página no encontrada".

¡Listo! El sitio ya debería estar funcionando correctamente en tu entorno local.

## 🔑 Acceso al Sitio

* **URL del Sitio**: `http://localhost/gv/`
* **URL de Acceso Personalizada**: `http://localhost/gv/acceso`
* **Usuario y Contraseña**: Los datos de acceso al panel de administración se encuentran en el archivo `auth.txt`.

## 📝 Notas Adicionales

* El proyecto cumple con los requisitos de replicar las secciones de **Header (con mega menú), Hero Banner, Buscador, Acerca de, Formulario de Contacto y Footer**. 
* El enfoque fue puramente visual.Las funcionalidades avanzadas como la lógica de búsqueda del buscador no fueron implementadas, según las especificaciones de la prueba. 