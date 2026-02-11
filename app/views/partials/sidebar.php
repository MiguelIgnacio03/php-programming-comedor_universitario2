<aside class="sidebar">
    <ul class="nav-menu">
        <li><a href="<?php echo URLROOT; ?>/dashboard">📊 Dashboard</a></li>
        <li><a href="<?php echo URLROOT; ?>/productos">📦 Productos</a></li>
        <?php if (isset($_SESSION['usuario_rol']) && $_SESSION['usuario_rol'] === 'administrador'): ?>
        <li><a href="<?php echo URLROOT; ?>/categorias">🏷️ Categorías</a></li>
        <li><a href="<?php echo URLROOT; ?>/proveedores">🏢 Proveedores</a></li>
        <?php endif; ?>
        <li><a href="<?php echo URLROOT; ?>/lotes">🏷️ Lotes</a></li>
        <?php if (isset($_SESSION['usuario_rol']) && $_SESSION['usuario_rol'] !== 'inventario'): ?>
        <li><a href="<?php echo URLROOT; ?>/menus">🍽️ Menús</a></li>
        <?php endif; ?>
        <?php if (isset($_SESSION['usuario_rol']) && ($_SESSION['usuario_rol'] === 'administrador' || $_SESSION['usuario_rol'] === 'inventario')): ?>
        <li><a href="<?php echo URLROOT; ?>/reportes">📄 Reportes</a></li>
        <?php endif; ?>
    </ul>
</aside>
