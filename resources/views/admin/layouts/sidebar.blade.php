<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="#"><img src="{{ asset('uploads/logo3.png') }}" alt="{{ $settings->site_name }}" class="m-3" style="width: 80%; object-fit: cover; float: left;"></a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="#" id="collapseButton"><i class="fas fa-chevron-left"></i></a>
        </div>
        <ul class="sidebar-menu">
            @if($modulos['ecommerce']->enabled)
            <!-- Header: E-COMMERCE -->
            <li class="menu-header">E-COMMERCE</li>

            <!-- Dashboard -->
            <li class="{{ setActive(['admin.dashboard'])}}">
                <a href="{{ route('admin.dashboard') }}" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>

            <!-- Pedidos -->
            <li class="dropdown {{ setActive([
                'admin.order.*', 
                'admin.pending-orders', 
                'admin.processed-orders', 
                'admin.dropped-off-orders', 
                'admin.shipped-orders', 
                'admin.out-for-delivery-orders', 
                'admin.delivered-orders', 
                'admin.canceled-orders']) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-cart-plus"></i><span>Pedidos</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ setActive(['admin.order.*']) }}"><a class="nav-link" href="{{ route('admin.order.index') }}">Todos los pedidos</a></li>
                    <li class="{{ setActive(['admin.pending-orders']) }}"><a class="nav-link" href="{{ route('admin.pending-orders') }}">Pedidos pendientes</a></li>
                    <li class="{{ setActive(['admin.processed-orders']) }}"><a class="nav-link" href="{{ route('admin.processed-orders') }}">Pedidos procesados</a></li>
                    <li class="{{ setActive(['admin.shipped-orders']) }}"><a class="nav-link" href="{{ route('admin.shipped-orders') }}">Pedidos enviados</a></li>
                    <li class="{{ setActive(['admin.delivered-orders']) }}"><a class="nav-link" href="{{ route('admin.delivered-orders') }}">Todos entregados</a></li>
                    <li class="{{ setActive(['admin.canceled-orders']) }}"><a class="nav-link" href="{{ route('admin.canceled-orders') }}">Pedidos cancelados</a></li>
                </ul>
            </li>

            <!-- Categorías -->
            <li class="dropdown {{ setActive(['admin.category.*', 'admin.sub-category.*', 'admin.child-category.*']) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-list"></i><span>Categorías</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ setActive(['admin.category.*']) }}"><a class="nav-link" href="{{ route('admin.category.index') }}">Categoría</a></li>
                    <li class="{{ setActive(['admin.sub-category.*']) }}"><a class="nav-link" href="{{ route('admin.sub-category.index') }}">Sub Categoria</a></li>
                    <li class="{{ setActive(['admin.child-category.*']) }}"><a class="nav-link" href="{{ route('admin.child-category.index') }}">Categoria Hijo</a></li>
                </ul>
            </li>

            <!-- Productos -->
            <li class="dropdown {{ setActive([
                'admin.brand.*', 
                'admin.products.*', 
                'admin.products-image-gallery.*', 
                'admin.products-variant.*', 
                'admin.products-variant-item.*', 
                'admin.seller-products.*', 
                'admin.seller-pending-products.*']) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-box"></i><span>Productos</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ setActive(['admin.brand.*']) }}"><a class="nav-link" href="{{ route('admin.brand.index') }}">Marcas</a></li>
                    <li class="{{ setActive([
                        'admin.products.*', 
                        'admin.products-image-gallery.*', 
                        'admin.products-variant.*', 
                        'admin.products-variant-item.*', 
                        'admin.reviews.*']) }}">
                        <a class="nav-link" href="{{ route('admin.products.index') }}">Productos</a></li>
                    <li class="{{ setActive(['admin.product.quickLoadForm']) }}">
                        <a class="nav-link" href="{{ route('admin.product.quickLoadForm') }}">Carga Rápida</a>
                    </li> 
                    <li class="{{ setActive(['admin.seller-products.*']) }}"><a class="nav-link" href="{{ route('admin.seller-products.index') }}">Productos de vendedores</a></li>
                    <li class="{{ setActive(['admin.seller-pending-products.*']) }}"><a class="nav-link" href="{{ route('admin.seller-pending-products.index') }}">Productos pendientes</a></li>
                    <li class="{{ setActive(['admin.reviews.*']) }}"><a class="nav-link" href="{{ route('admin.reviews.index') }}">Reviews</a></li>
                </ul>
            </li>

            <!-- E-Commerce -->
            <li class="dropdown {{ setActive([
                'admin.vendor-profile.*', 
                'admin.coupons.*', 
                'admin.shipping-rule.*', 
                'admin.payment-settings.*']) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i><span>E-Commerce</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ setActive(['admin.vendor-profile.*']) }}"><a class="nav-link" href="{{ route('admin.flash-sale.index') }}">Ofertas</a></li>
                    <li class="{{ setActive(['admin.coupons.*']) }}"><a class="nav-link" href="{{ route('admin.coupons.index') }}">Cupones</a></li>
                    <li class="{{ setActive(['admin.shipping-rule.*']) }}"><a class="nav-link" href="{{ route('admin.shipping-rule.index') }}">Reglas de envío</a></li>
                    <li class="{{ setActive(['admin.vendor-profile.*']) }}"><a class="nav-link" href="{{ route('admin.vendor-profile.index') }}">Perfil del local</a></li>
                    <li class="{{ setActive(['admin.payment-settings.*']) }}"><a class="nav-link" href="{{ route('admin.payment-settings.index') }}">Configuración de pagos</a></li>
                </ul>
            </li>

            <!-- Manejar sitio -->
            <li class="dropdown {{ setActive([
                'admin.slider.*', 
                'admin.vendor-condition.index', 
                'admin.about.index', 
                'admin.terms-and-conditions.index']) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-cog"></i><span>Manejar sitio</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ setActive(['admin.slider.*']) }}"><a class="nav-link" href="{{ route('admin.slider.index') }}">Slider</a></li>
                    <li class="{{ setActive(['admin.slider.*']) }}"><a class="nav-link" href="{{ route('admin.home-page-setting') }}">Ajustes Homepage</a></li>
                    <li class="{{ setActive(['admin.vendor-condition.index']) }}"><a class="nav-link" href="{{ route('admin.vendor-condition.index') }}">Condición de locales</a></li>
                </ul>
            </li>

            <!-- Footer -->
            <li class="dropdown {{ setActive([
                'admin.footer-info.index', 
                'admin.footer-socials.*', 
                'admin.footer-grid-two.*', 
                'admin.footer-grid-three.*']) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-th-large"></i><span>Footer</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ setActive(['admin.footer-info.index']) }}"><a class="nav-link" href="{{ route('admin.footer-info.index') }}">Información del footer</a></li>
                    <li class="{{ setActive(['admin.footer-socials.*']) }}"><a class="nav-link" href="{{ route('admin.footer-socials.index') }}">Redes del footer</a></li>
                    <li class="{{ setActive(['admin.footer-grid-two.*']) }}"><a class="nav-link" href="{{ route('admin.footer-grid-two.index') }}">Columna dos</a></li>
                    <li class="{{ setActive(['admin.footer-grid-three.*']) }}"><a class="nav-link" href="{{ route('admin.footer-grid-three.index') }}">Columna tres</a></li>
                </ul>
            </li>

            <!-- Usuarios -->
            <li class="dropdown {{ setActive([
                'admin.vendor-requests.index', 
                'admin.customer.index', 
                'admin.vendor-list.index', 
                'admin.manage-user.index', 
                'admin-list.index']) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-users"></i><span>Usuarios</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ setActive(['admin.customer.index']) }}"><a class="nav-link" href="{{ route('admin.customer.index') }}">Lista de clientes</a></li>
                    <li class="{{ setActive(['admin.vendor-list.index']) }}"><a class="nav-link" href="{{ route('admin.vendor-list.index') }}">Lista de locales</a></li>
                    <li class="{{ setActive(['admin.vendor-requests.index']) }}"><a class="nav-link" href="{{ route('admin.vendor-requests.index') }}">Locales pendientes</a></li>
                    <li class="{{ setActive(['admin.admin-list.index']) }}"><a class="nav-link" href="{{ route('admin.admin-list.index') }}">Lista de administradores</a></li>
                    <li class="{{ setActive(['admin.manage-user.index']) }}"><a class="nav-link" href="{{ route('admin.manage-user.index') }}">Administrar usuario</a></li>
                </ul>
            </li>

            <!-- Suscriptores -->
            <li><a class="nav-link {{ setActive(['admin.subscribers.*']) }}" href="{{ route('admin.subscribers.index') }}"><i class="fas fa-user"></i><span>Suscriptores</span></a></li>

            <!-- Configuración -->
            <li><a class="nav-link" href="{{ route('admin.settings.index') }}"><i class="fas fa-wrench"></i><span>Configuración</span></a></li>
            @endif

            

            

            @if($modulos['contabilidad']->enabled)
            <!-- Header: Contabilidad -->
            <li class="menu-header">Contabilidad</li>


            <!-- Dashboard -->
            <li><a class="nav-link {{ setActive(['admin.contabilidad.*']) }}" href="{{ route('admin.contabilidad.index') }}"><i class="fas fa-chart-line"></i><span>Dashboard</span></a></li>

            <!-- Ordenes -->
            <li class="dropdown {{ setActiveExcept(['admin.contabilidad.users', 'admin.contabilidad.agregar-usuario', 'admin.contabilidad.index', 'admin.contabilidad.transactions', 'admin.contabilidad.incomes', 'admin.contabilidad.expenses'], 'admin.contabilidad.*') }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-file-invoice-dollar"></i><span>Facturas</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ setActive(['admin.contabilidad.ordenes-dashboard']) }}"><a class="nav-link" href="{{ route('admin.contabilidad.ordenes-dashboard') }}">Todas las facturas</a></li>
                    <li class="{{ setActive(['admin.contabilidad.ordenes-cobro']) }}"><a class="nav-link" href="{{ route('admin.contabilidad.ordenes-cobro') }}">Facturas a cobrar</a></li>
                    <li class="{{ setActive(['admin.contabilidad.ordenes-pago']) }}"><a class="nav-link" href="{{ route('admin.contabilidad.ordenes-pago') }}">Facturas a pagar</a></li>
                    <li class="{{setActive(['admin.contabilidad.crear-orden']) }}"><a href="{{ route('admin.contabilidad.crear-orden') }}" class="nav-link">Crear factura</a></li>
                </ul>
            </li>

            <!-- Movimientos -->
            <li class="dropdown {{ setActiveExcept(['admin.contabilidad.users', 'admin.contabilidad.agregar-usuario', 'admin.contabilidad.ordenes-dashboard', 'admin.contabilidad.ordenes-cobro', 'admin.contabilidad.ordenes-pago', 'admin.contabilidad.index'], 'admin.contabilidad.*') }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-arrows-spin"></i><span>Movimientos</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ setActive(['admin.contabilidad.transactions']) }}"><a class="nav-link" href="{{ route('admin.contabilidad.transactions') }}">Todos los movimientos</a></li>
                    <li class="{{ setActive(['admin.contabilidad.incomes']) }}"><a class="nav-link" href="{{ route('admin.contabilidad.incomes') }}">Cobros</a></li>
                    <li class="{{ setActive(['admin.contabilidad.expenses']) }}"><a class="nav-link" href="{{ route('admin.contabilidad.expenses') }}">Pagos</a></li>
                </ul>
            </li>

            <!-- Usuarios de contabilidad -->
            <li class="dropdown {{ setActive(['admin.contabilidad.users', 'admin.contabilidad.agregar-usuario']) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-users"></i><span>Proveedores</span></a>
                <ul class="dropdown-menu"> 
                    <li class="{{ setActive(['admin.contabilidad.users']) }}"><a class="nav-link" href="{{ route('admin.contabilidad.users') }}">Todos los proveedores</a></li>
                    <li class="{{ setActive(['admin.contabilidad.agregar-usuario']) }}"><a class="nav-link" href="{{ route('admin.contabilidad.agregar-usuario') }}">Agregar proveedor</a></li>
                </ul>
            </li>
            @endif

            @if($modulos['pos']->enabled)
            <!-- Header: Punto de venta -->
            <li class="menu-header">Punto de venta</li>

            <!-- POS -->
            <li class="dropdown {{ setActive(['admin.pos.*']) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-cash-register"></i><span>POS</span></a>
                <ul class="dropdown-menu"> 
                    <li class="{{ setActive(['admin.pos.dashboard']) }}"><a class="nav-link" href="{{ route('admin.pos.dashboard') }}">Dashboard</a></li>
                    <li class="{{ setActive(['admin.pos.caja']) }}"><a class="nav-link" href="{{ route('admin.pos.caja') }}">Point of Sale</a></li>
                </ul>
            </li>
            @endif

            @if($modulos['stock']->enabled)
            <!-- Header: Stock -->
            <li class="menu-header">Stock</li>

            <!-- Stock -->
            <li class="dropdown {{ setActive(['admin.stock.*']) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-arrow-trend-up"></i><span>Stock</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ setActive(['admin.stock.index']) }}"><a class="nav-link" href="{{ route('admin.stock.index') }}">Dashboard</a></li>
                </ul>
            </li>
            @endif

            @if($modulos['marketing']->enabled)
            <!-- Header: Marketing -->
            <li class="menu-header">Marketing</li>

            <!-- Puntos -->
            <li class="{{ setActive(['admin.loyalty-program.*']) }}">
                <a href="{{ route('admin.loyalty-program.loyalty') }}" class="nav-link"><i class="fas fa-leaf"></i><span>Puntos</span></a>
            </li>
            @endif

            @if($modulos['recursos-humanos']->enabled)
            <!-- Header: Recursos Humanos -->
            <li class="menu-header">Recursos Humanos</li>
            <!-- RECURSOS HUMANOS-->
            <li class="dropdown {{ setActive(['admin.recursos-humanos.*']) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-user-group"></i><span>Recursos Humanos</span></a>
                <ul class="dropdown-menu"> 
                    <li class=" {{ setActive(['admin.recursos-humanos.dashboard']) }} "><a class="nav-link" href="{{ route('admin.recursos-humanos.dashboard') }}">Dashboard</a></li>
                    <li class=" {{ setActive(['admin.recursos-humanos.gestion']) }} "><a class="nav-link" href="{{ route('admin.recursos-humanos.gestion') }}">Gestión de personal</a></li>
                    <li class=" {{ setActive(['admin.recursos-humanos.salarios']) }} "><a class="nav-link" href="{{ route('admin.recursos-humanos.salarios') }}">Salarios</a></li>
                    <li class=" {{ setActive(['admin.recursos-humanos.horarios']) }} "><a class="nav-link" href="{{ route('admin.recursos-humanos.horarios') }}">Horarios</a></li>
                    <li class=" {{ setActive(['admin.recursos-humanos.vacaciones']) }} "><a class="nav-link" href="{{ route('admin.recursos-humanos.vacaciones') }}">Vacaciones</a></li>
                    <li class=" {{ setActive(['admin.recursos-humanos.faltas']) }} "><a class="nav-link" href="{{ route('admin.recursos-humanos.faltas') }}">Faltas</a></li>
                </ul>
            </li>
            @endif

            <!-- Header: Módulos -->
            <li class="menu-header">Módulos</li>

            <!-- Módulos -->
            <li class="{{ setActive(['admin.modulos.*']) }}">
                <a href="{{ route('admin.modulos.index') }}" class="nav-link"><i class="fas fa-server"></i><span>Módulos</span></a>
            </li>
        </ul>
    </aside>
</div>
