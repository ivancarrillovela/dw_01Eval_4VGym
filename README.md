# dw_01Eval_4VGym

Una pequeña aplicación en PHP para gestionar actividades (listar, crear y editar). Proyecto de evaluación/ejercicio que usa una estructura simple basada en archivos PHP, un directorio de persistencia (DAO/conf), utilidades y plantillas.

---

## Contenido
- index.php — Punto de entrada que redirige a la última página visitada o al listado de actividades.
- app/
  - ListarActividades.php — Página principal para listar actividades.
  - CrearActividades.php — Formulario / controlador para crear una nueva actividad.
  - EditarActividades.php — Formulario / controlador para editar una actividad existente.
- persistence/
  - DAO/ — Clases de acceso a datos (DAO).
  - conf/ — Configuración de persistencia (p. ej. fichero de configuración de la BD).
- utils/
  - GestorSesion.php — Helper para iniciar la sesión y gestionar la variable `last_page`.
- templates/ — Plantillas HTML/fragmentos usados por las vistas.
- assets/ — Imágenes, CSS, JS, etc.

---

## Requisitos
- PHP (recomendado 7.4+)
- Servidor web (Apache, Nginx) o el servidor embebido de PHP
- (Opcional) MySQL/MariaDB u otra base de datos según la configuración en `persistence/conf`

---

## Instalación y configuración local (rápida)
1. Clona el repositorio:
   ```bash
   git clone https://github.com/ivancarrillovela/dw_01Eval_4VGym.git
   ```
2. Sitúa la carpeta en el directorio público de tu servidor (por ejemplo `htdocs` en XAMPP) o sirve con PHP:
   ```bash
   cd dw_01Eval_4VGym
   php -S localhost:8000
   ```
3. Ajusta la ruta base si es necesario:
   - En `index.php` hay una variable `$dirHref` que actualmente apunta a `/EjerciciosDWEB/dw_01Eval_4VGym`. Cámbiala para que concuerde con la ruta donde alojes el proyecto.
4. Configura la persistencia:
   - Edita los archivos dentro de `persistence/conf/` para ajustar parámetros de conexión a base de datos (host, usuario, contraseña, nombre BD) si la aplicación usa base de datos.
5. Asegúrate de que la carpeta tiene permisos de lectura/ejecución adecuados para el servidor web.

---

## Uso
- Abre en el navegador la URL donde serviste el proyecto. `index.php` redirige automáticamente:
  - Si existe `$_SESSION['last_page']`, redirige a `app/<last_page>`.
  - Si no existe, redirige a `app/ListarActividades.php`.
- Usa las páginas del directorio `app/` para listar, crear y editar actividades.

---

## Notas de implementación importantes
- La gestión de sesión se centraliza en `utils/GestorSesion.php`. La aplicación guarda la última página visitada en la variable de sesión `last_page`. Esto es usado por `index.php` para redirección.
- La estructura de persistencia está preparada para usar un patrón DAO (clases en `persistence/DAO/`) y una carpeta de configuración en `persistence/conf/`.
- Las plantillas se encuentran en `templates/` para separar vistas y lógica.

---

## Buenas prácticas / recomendaciones
- Mover los parámetros sensibles (credenciales DB) a un fichero fuera del alcance público o usar variables de entorno.
- Añadir validación y saneamiento de entrada (XSS/SQL injection) si no están implementados.
- Añadir manejo de errores y logs para la capa de persistencia.
- Añadir tests (unitarios o funcionales) para las funciones críticas.

---

## Contribuir
Si deseas contribuir:
1. Haz fork del repositorio.
2. Crea una rama con una descripción clara del cambio:
   ```bash
   git checkout -b feat/nueva-funcionalidad
   ```
3. Crea commits pequeños y descriptivos.
4. Abre un Pull Request desde tu fork.

---

## Licencia
Actualmente no hay una licencia explícita en el repositorio. Si quieres, puedo sugerir e incluir una (por ejemplo MIT) y crear el archivo `LICENSE`.

---

## Contacto
Repositorio: https://github.com/ivancarrillovela/dw_01Eval_4VGym  
Autor: ivancarrillovela (ver perfil en GitHub)
