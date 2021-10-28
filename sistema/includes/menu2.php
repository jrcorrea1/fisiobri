<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

	<!-- Sidebar - Brand -->
	<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
		<div class="sidebar-brand-icon rotate-n-15">
			<img src="img/logo.png" class="img-thumbnail">
		</div>
		<div class="sidebar-brand-text mx-3">FisioBri</div>
	</a>

	<!-- Divider -->
	<hr class="sidebar-divider my-0">

	<!-- Divider -->
	<hr class="sidebar-divider">

	<!-- Heading -->
	<div class="sidebar-heading">
		Interface
	</div>

	<!-- Nav Item - Pages Collapse Menu -->
	<li class="nav-item">
		<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
			<i class="fas fa-fw fa-cog"></i>
			<span>Mantenimientos</span>
		</a>
		<div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionSidebar">
			<div class="bg-white py-2 collapse-inner rounded">
				<a class="collapse-item" href="lista_pais.php"><i class="fas fa-angle-double-right"></i> Pais</a>
				<a class="collapse-item" href="lista_departamento.php"><i class="fas fa-angle-double-right"></i> Departamento</a>
				<a class="collapse-item" href="lista_ciudad.php"><i class="fas fa-angle-double-right"></i> Ciudad</a>
				<a class="collapse-item" href="lista_barrio.php"><i class="fas fa-angle-double-right"></i> Barrio</a>
				<a class="collapse-item" href="lista_usuarios.php"><i class="far fa-id-badge"></i> Usuarios</a>
<a class="collapse-item" href="menuempresa.php"><i class="far fa-address-card"></i> Rol</a>
<a class="collapse-item" href="lista_personal.php"><i class="fas fa-id-card"></i> Personal</a>
				<a class="collapse-item" href="lista_cargo.php"><i class="fas fa-user-tie"></i> Cargo</a>
				<a class="collapse-item" href="lista_especialidad.php"><i class="fas fa-user-graduate"></i> Especialidad</a>
				<a class="collapse-item" href="lista_cliente.php"><i class="fas fa-user-plus"></i> Cliente</a>
				<a class="collapse-item" href="lista_categoria.php"><i class="fas fa-dolly"></i> Categoria</a>
				<a class="collapse-item" href="lista_marca.php"><i class="fas fa-dolly"></i> Marcas</a>
				<a class="collapse-item" href="lista_productos.php"><i class="fas fa-box-open"></i> Productos</a>
				<a class="collapse-item" href="lista_proveedor.php"><i class="fas fa-truck"></i> Proveedores</a>
				<a class="collapse-item" href="lista_empresa.php"><i class="fas fa-warehouse"></i> Empresa</a>
				<a class="collapse-item" href="lista_sucursal.php"><i class="fas fa-warehouse"></i> Sucursal</a>



			</div>
		</div>
	</li>
	<li class="nav-item">
		<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
			<i class="fas fa-hand-holding-usd"></i>
			<span>Ventas</span>
		</a>
		<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
			<div class="bg-white py-2 collapse-inner rounded">
				<a class="collapse-item" href="ventas.php"><i class="fas fa-hand-holding-usd"></i>Ventas</a>
			</div>
		</div>
	</li>

	<!-- Nav Item - Productos Collapse Menu -->
	<li class="nav-item">
		<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
			<i class="fas fa-box-open"></i>
			<span>Productos</span>
		</a>
		<div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
			<div class="bg-white py-2 collapse-inner rounded">
				<a class="collapse-item" href="registro_producto.php"><i class="fas fa-plus-circle"></i>Nuevo Producto</a>
				<a class="collapse-item" href="lista_productos.php"><i class="fas fa-box-open"></i>Productos</a>
			</div>
		</div>
	</li>

	<!-- Nav Item - Clientes Collapse Menu -->
	<li class="nav-item">
		<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseClientes" aria-expanded="true" aria-controls="collapseUtilities">
			<i class="fas fa-users"></i>
			<span>Clientes</span>
		</a>
		<div id="collapseClientes" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
			<div class="bg-white py-2 collapse-inner rounded">
				<a class="collapse-item" href="registro_cliente.php"><i class="fas fa-plus-circle"></i>Nuevo Clientes</a>
				<a class="collapse-item" href="lista_cliente.php"><i class="fas fa-user-friends"></i>Clientes</a>
			</div>
		</div>
	</li>
	<!-- Nav Item - Utilities Collapse Menu -->
	<li class="nav-item">
		<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProveedor" aria-expanded="true" aria-controls="collapseUtilities">
			<i class="fas fa-truck"></i></i>
			<span>Proveedores</span>
		</a>
		<div id="collapseProveedor" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
			<div class="bg-white py-2 collapse-inner rounded">
				<a class="collapse-item" href="registro_proveedor.php"><i class="fas fa-plus-circle"></i>Nuevo Proveedor</a>
				<a class="collapse-item" href="lista_proveedor.php"><i class="fas fa-truck"></i>Proveedores</a>
			</div>
		</div>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="menuempresa.php">
			<i class="fas fa-building"></i>
			<span>Empresa</span>
		</a>
		<div id="collapseEmpleados" class="collapse" aria-labelledby="headingEmpleados" data-parent="#accordionSidebar">
			</div>
	</li>
	<?php if ($_SESSION['rol'] == 1) { ?>
		<!-- Nav Item - Usuarios Collapse Menu -->
		<li class="nav-item">
			<a class="nav-link" href="sec.php">
				<i class="fas fa-user"></i>
				<span>Seguridad</span>
			</a>
			<div id="collapseUsuarios" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
			</div>
		</li>
	<?php } ?>

</ul>
