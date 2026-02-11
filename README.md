# Sistema de Control de Inventario - Comedor Universitario

Sistema fullstack de gestión de inventario para comedores universitarios, desarrollado con arquitectura MVC (Backend PHP) y MVVM (Frontend JavaScript).

## 🎯 Características Principales

- **Gestión de Productos**: CRUD completo con categorías y vinculación a proveedores
- **Gestión de Proveedores**: Módulo dedicado para administración de empresas suministradoras (Admin Only)
- **Control de Lotes**: Sistema FIFO (First In, First Out) para productos perecederos
- **Planificación de Menús**: Creación de menús semanales con consumo automático de inventario
- **Alertas Inteligentes**: Notificaciones de stock crítico y productos próximos a vencer
- **Dashboard Analítico**: Visualización de métricas clave en tiempo real con actualización AJAX
- **Autenticación por Roles**: Admin, Cocina, Inventario
- **Generador de Reportes PDF**: Reportes de inventario y consumo listos para imprimir
- **Historial de Movimientos**: Trazabilidad completa de entradas/salidas
- **Arquitectura MVVM**: Frontend reactivo con ViewModels y API REST

## 🛠️ Stack Tecnológico

- **Backend**: PHP 8.1+ (MVC puro)
- **Base de Datos**: MySQL 8.0
- **Frontend**: HTML5, CSS3 (sin frameworks), JavaScript (MVVM)
- **Servidor**: Apache (XAMPP/WAMP)

## 📋 Requisitos Previos

- XAMPP/WAMP con PHP 8.1+
- MySQL 8.0+
- Navegador web moderno

## 🚀 Instalación

1. **Clonar el repositorio**
   ```bash
   cd C:\xampp\htdocs
   git clone [URL_REPOSITORIO] Comedor_Universitario
   ```

2. **Configurar la base de datos**
   - Abrir phpMyAdmin (http://localhost/phpmyadmin)
   - Importar el archivo `database.sql`
   - Verificar que la base de datos `comedor_universitario` se creó correctamente

3. **Configurar credenciales** (opcional)
   - Editar `config/config.php` si tus credenciales de MySQL son diferentes

4. **Iniciar el servidor**
   - Iniciar Apache y MySQL desde el panel de XAMPP
   - Acceder a: http://localhost/Comedor_Universitario

## 👤 Usuarios de Prueba

| Email | Contraseña | Rol |
|-------|-----------|-----|
| admin@comedor.edu | admin123 | Administrador |
| chef@comedor.edu | admin123 | Cocina |
| inventario@comedor.edu | admin123 | Inventario |

## 📁 Estructura del Proyecto

```
Comedor_Universitario/
├── app/
│   ├── controllers/    # Controladores MVC
│   ├── models/         # Modelos de datos
│   ├── views/          # Vistas HTML
│   └── core/           # Núcleo (Router, Auth, Database)
├── public/
│   ├── index.php       # Punto de entrada
│   └── assets/         # CSS, JS, imágenes
├── config/             # Configuración
└── database.sql        # Script de inicialización
```

## 🔑 Funcionalidades por Rol

### Administrador
- Acceso completo a todos los módulos
- Generación de reportes PDF
- Gestión de usuarios y proveedores

### Cocina
- Visualización de menús
- Consulta de inventario disponible
- Registro de consumos

### Inventario
- Gestión de productos y lotes
- Control de entradas/salidas
- Alertas de stock

## 📊 Módulos Principales

### Dashboard
- Tarjetas de estadísticas (Total productos, Stock crítico, Lotes por vencer)
- Alertas visuales en tiempo real

### Productos
- Listado con stock actual calculado dinámicamente
- Filtros por categoría y proveedor
- Indicadores visuales de stock crítico

### Lotes
- Gestión de fechas de caducidad
- Sistema FIFO automático para consumos
- Alertas de vencimiento (7 días)

### Menús
- Planificación semanal
- Cálculo automático de ingredientes necesarios
- Consumo automático con FIFO al ejecutar menú
- Validación de disponibilidad de stock

### Proveedores (Solo Administradores)
- Administración centralizada de proveedores vinculados al inventario
- Información de contacto: Teléfono, Email, Dirección y Persona de contacto
- Sistema de deshabilitación y reactivación (Soft Delete)

### Reportes (Solo Administradores)
- Reporte de Inventario: Estado completo con alertas
- Reporte de Consumo: Movimientos en rango de fechas
- Formato HTML optimizado para impresión/PDF

## 🧪 Lógica de Negocio: FIFO

El sistema implementa consumo inteligente de lotes:

```php
// Ejemplo: Al consumir 50kg de pollo
// 1. Se buscan lotes disponibles ordenados por fecha de caducidad
// 2. Se consume primero del lote más próximo a vencer
// 3. Se registra el movimiento en el historial
// 4. Se actualiza el estado del lote (disponible/consumido)
```

## 🎨 Diseño

- CSS personalizado con variables CSS
- Layout responsivo (Grid/Flexbox)
- Paleta de colores profesional
- Sin dependencias de frameworks CSS

## � Actualizaciones Recientes (Febrero 2026)

### 📦 Gestión Avanzada de Stock
- **Sistema de Papelera (Soft Delete)**: Implementado en Productos, Lotes, Categorías y **Proveedores**. Los elementos ahora pueden deshabilitarse y reactivarse desde una lista de inactivos, preservando la trazabilidad.
- **Módulo de Proveedores**: Implementación de CRUD completo para administración de proveedores, con acceso restringido a administradores y vistas duales (Activos/Inactivos).
- **Categorías Dinámicas**: CRUD completo de categorías con soporte para productos perecederos y estados activos/inactivos.

### 🎨 Mejoras de UI/UX
- **Botones de Acción Optimizados**: Rediseño vertical de la columna de acciones con código de colores intuitivo:
  - **Amarillo (Warning)**: Para la edición rápida de registros.
  - **Rojo (Danger)**: Para deshabilitar elementos de forma segura.
- **Vistas dedicated de Inactivos**: Módulos específicos para la recuperación selectiva de datos en Categorías, Productos y Lotes.
- **Alertas Preventivas**: Indicadores visuales mejorados para lotes próximos a vencer (ventana de 7 días).

### ⚙️ Estabilidad y Seguridad
- **Robustez del Modelo**: Mejorado el manejo de IDs de inserción y acceso a base de datos en los controladores de Menús y Lotes.
- **Validaciones de Consumo**: Mejora en la lógica de descuento FIFO para evitar inconsistencias de stock.

## 📝 Próximas Mejoras

- [ ] API REST para integración con aplicación móvil
- [ ] Gráficos estadísticos de consumo histórico (Chart.js)
- [ ] Sistema de notificaciones push para stock mínimo
- [ ] Exportación de reportes a formato Excel

## 👥 Equipo de Desarrollo

- **Desarrollado con ❤️ y la potencia de [Google Antigravity](https://deepmind.google/technologies/gemini/)** 🚀
- Proyecto académico desarrollado siguiendo metodología ágil.

## 📄 Licencia

Proyecto educativo - Universidad [U.N.E.F.A]

---

**Desarrollado con el apoyo de Google Antigravity para la gestión eficiente de comedores universitarios**
