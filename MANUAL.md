# Iron-Black_Los-Pescados-Rabiosos

## Descripción
Página web para la gestión de stock de productos y kits de la empresa **Iron Black**.  
Permite controlar inventarios, ventas, roles de usuarios y administración de productos de manera sencilla y segura.



## Funcionalidades

### 1. Control de productos
- **Agregar, modificar y eliminar productos**.
- **Ocultar productos**: los productos ocultos no aparecen a la venta.
- **Actualizar stock manualmente**: útil cuando hay nuevos ingresos o devoluciones.

### 2. Gestión de kits
- Crear kits seleccionando varios productos.
- Definir **cuánto stock de cada producto se utiliza** en el kit.
- Los kits actualizan automáticamente el stock de los productos asociados al venderse.

### 3. Roles de usuario e inicio de sesión
- **Administrador (rol = 1)**
  - Puede crear, modificar y eliminar productos y kits.
  - Puede ver la **lista de ventas** completas.
  - Puede ocultar productos y actualizar stock manualmente.
- **Usuario normal (rol = 0)**
  - Solo puede ver productos y kits disponibles.
  - Puede realizar compras, pero no modificar stock ni productos.

### 4. Lista de ventas
- Permite al administrador **visualizar todas las ventas realizadas**, indicando:
  - Producto o kit vendido.
  - Usuario que realizó la compra.
  - Fecha de la venta.
- Esto ayuda a controlar ingresos y analizar tendencias de ventas.



## Administración – Funciones de administrador

### Cambiar rol de usuario
- Abrir la base de datos `ironblack`.
- Entrar en la tabla `usuario`.
- Cambiar el valor de la columna `rol` de `0` a `1` para otorgar privilegios de administrador.

### Ocultar productos
- Los productos ocultos **no aparecen a la venta**.
- Se pueden ocultar desde el panel de administración o modificando el campo `visible` en la tabla `productos`.

### Actualizar stock
- El stock se puede actualizar manualmente para reflejar **nuevos ingresos o devoluciones**.
- Esto asegura que la información de stock en la página siempre esté correcta.



## Historial de desarrollo

1. **Primera entrevista**
   - El cliente solicitó un sistema de control de stock para reemplazar el manejo en papel.
2. **Segunda entrevista**
   - Se presentó un prototipo básico sin diseño.
   - Se agregó la funcionalidad de registrar el stock utilizado por cada producto en kits.
   - Se incluyó el conteo de ventas.
3. **Iteración final**
   - Implementación de roles e inicio de sesión.
   - Aplicación de CSS y mejoras de usabilidad.
   - Cliente aprobó la versión final como **perfecta y funcional**.



## Requerimientos
- **Servidor web**: Apache o similar (XAMPP, WAMP, MAMP, etc.)
- **PHP**: versión 7.4 o superior
- **Base de datos**: MySQL / MariaDB
- **Navegador web**: Google Chrome, Firefox o cualquier navegador moderno



## Uso de la página

### Acceso
1. Abrir la página principal en el navegador.
2. Iniciar sesión con un usuario registrado.

### Funciones principales
- **Productos**: agregar, modificar, ocultar y actualizar stock.
- **Kits**: crear kits con productos y definir stock utilizado por cada producto.
- **Compras**: realizar ventas y actualizar stock automáticamente.
- **Lista de ventas**: ver historial completo de compras y usuarios que compraron.

> Para más detalles, consultar la guía de uso completa en `product/USO.md`.



## Tecnologías utilizadas
- PHP
- MySQL / MariaDB
- HTML y CSS
