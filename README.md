# 📘 Documentación del Sistema de Gestión para Zapatería

Este proyecto consiste en el desarrollo de una aplicación web basada en el patrón de arquitectura **MVC (Modelo-Vista-Controlador)**. Utiliza tecnologías como:

- **PHP** como lenguaje de programación principal
- **MySQL** (integrado en XAMPP) como sistema de gestión de base de datos
- **HTML**, **CSS**, **JavaScript** y la librería **Bootstrap** para la interfaz de usuario

El sistema está diseñado para ser intuitivo y amigable, permitiendo:

- Registro y actualización de productos y clientes
- Automatización del proceso de búsqueda, selección y facturación
- Generación de reportes y control de productos vendidos

Este enfoque busca mejorar la eficiencia operativa y contribuir al crecimiento de las ventas del negocio.

---

## 🔁 Enrutamiento del Sistema (MVC)

El archivo `App.php` gestiona el enrutamiento de la aplicación. A continuación se muestra su estructura:

```php
require_once 'controllers/errores.php';

class App {
    function __construct() {
        $url = isset($_GET['url']) ? $_GET['url'] : null;
        $url = rtrim($url, '/');
        $url = explode('/', $url);

        if (empty($url[0])) {
            $archivoController = 'controllers/main.php';
            require_once $archivoController;
            $controller = new Main();
            return false;
        }

        $archivoController = 'controllers/' . $url[0] . '.php';

        if (file_exists($archivoController)) {
            require_once $archivoController;
            $controller = new $url[0];

            if (isset($url[1])) {
                $controller->{$url[1]}();
            }
        } else {
            $controller = new Errores();
        }
    }
}

