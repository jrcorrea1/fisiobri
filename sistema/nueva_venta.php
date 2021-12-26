<?php include_once "includes/header.php"; ?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <div class="card" style="left: 0px;right: 40px;margin-right: 42px;margin-bottom: 20px">
                    <div class="card-body">
                        <div align="center">
                            <h4>Registro de Ventas</h4>
                        </div>
                    </div>
                </div>
                <a href="#" class="btn btn-primary btn_new_cliente"><i class="fas fa-user-plus"></i> Nuevo Cliente</a>
            </div>
            <div class="card">
                <div class="card-body">
                    <form method="post" name="form_new_cliente_venta" id="form_new_cliente_venta">
                        <input type="hidden" name="action" value="addCliente">
                        <input type="hidden" id="idcliente" value="1" name="idcliente" required>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>N° de Cedula</label>
                                    <input type="number" name="dni_cliente" id="dni_cliente" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input type="text" name="nom_cliente" id="nom_cliente" class="form-control" disabled required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Teléfono</label>
                                    <input type="number" name="tel_cliente" id="tel_cliente" class="form-control" disabled required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Dirreción</label>
                                    <input type="text" name="dir_cliente" id="dir_cliente" class="form-control" disabled required>
                                </div>
                            </div>
                            <div id="div_registro_cliente" style="display: none; padding-top: 30px; padding-left:15px;">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div></br>
            <div class="col-lg-12">
                <div class="form-group">
                    <div class="card" style="left: 0px;right: 40px;margin-right: 42px;margin-bottom: 20px">
                        <div class="card-body">
                            <div align="center">
                                <h4>Detalles de Venta</h4>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label><i class="fas fa-user"></i> USUARIO ACTIVO</label>
                                <p style="font-size: 16px; text-transform: uppercase; color: blue;"><?php echo $_SESSION['nombre']; ?></p>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <label>Acciones</label>
                            <div id="acciones_venta" class="form-group">
                                <a href="#" class="btn btn-danger" id="btn_anular_venta">Anular</a>
                                <a href="#" class="btn btn-primary" id="btn_facturar_venta"><i class="fas fa-save"></i> Generar Venta</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th width="90px">Código del Producto</th>
                                    <th>Nombre de Producto</th>
                                    <th>Stock Actual</th>
                                    <th width="100px">Cantidad</th>
                                    <th class="textright">Precio Unit</th>
                                    <th class="textright">Exenta</th>
                                    <th class="textright">Iva 5%</th>
                                    <th class="textright">Iva 10%</th>
                                    <th>Acciones</th>
                                </tr>
                                <tr>
                                    <td><input type="number" name="txt_cod_producto" id="txt_cod_producto">
                                        <button id="search" type="button" data-toggle="modal" data-target="#myModal1" class="btn btn-primary btn-flat">Comprobar</button>

                    </td>
                    <td id="txt_descripcion">-</td>
                    <td id="txt_existencia">-</td>
                    <td><input type="text" name="txt_cant_producto" id="txt_cant_producto" value="0" min="1" disabled></td>
                    <td id="txt_precio" class="textright">0</td>
                    <td id="" class="textright">0</td>
                    <td id="" class="textright">0</td>
                    <td id="txt_precio_total" class="txtright">0</td>
                    <td><a href="#" id="add_product_venta" class="btn btn-dark" style="display: none;">Agregar</a></td>
                    </tr>
                    <tr>
                        <th>Código</th>
                        <th colspan="2">Producto</th>
                        <th>Cantidad</th>
                        <th class="textright">Precio Unit</th>
                        <th class="textright">Importe total</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody id="detalle_venta">
                        <!-- Contenido ajax -->

                    </tbody>

                    <tfoot id="detalle_totales">
                        <!-- Contenido ajax -->
                    </tfoot>
                    </table>

                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<div class="modal fade bs-example-modal-lg" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <form id="form" class="user">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Buscar productos</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row mb-3">
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="des" name="des" placeholder="Buscar productos">
                        </div>
                        <div class="col-sm-4">
                            <button id="filtrar" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                        <div id="loading" class="col-sm-12 text-center hide" style="display: none;">
                            <i class="fa fa-spinner fa-spin"></i> Procesando consulta
                        </div>

                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="listaproducto" class="table table-bordered" width="100%" cellspacing="0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th style=" white-space: nowrap;">Nombre</th>
                                        <th>Stock Actual</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                        <th>Accion</th>
                                    </tr>
                                </thead>

                            </table>
                        </div>
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>


            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<?php include_once "includes/footer.php"; ?>
<script type="text/javascript">
    $(document).ready(function() {




        function handleAjaxError(xhr, textStatus, error) {
            if (textStatus === 'timeout') {
                Swal.fire({
                    title: 'Advertencia',
                    text: "Ocurrio un error intentado resolver la solicitud. Por favor contacte con el administrador dela red",
                    icon: 'warning',
                    confirmButtonText: 'Ok'
                });
                document.getElementById('listado_processing').style.display = 'none';
            } else {
                Swal.fire({
                    title: 'Advertencia',
                    text: "Ocurrio un error intentado resolver la solicitud. Por favor contacte con el administrador del sistema",
                    icon: 'warning',
                    confirmButtonText: 'Ok'
                });
                document.getElementById('listado_processing').style.display = 'none';
            }
        }



        var table = $('#listaproducto').DataTable({
            "processing": true,
            "serverSide": true,
            "ordering": false,
            "searching": false,

            "ajax": {
                "url": "./backend/listados/producto.php",
                timeout: 15000,
                error: handleAjaxError,
                "data": function(data) {
                    data.des = $('#des').val()
                }
            },
            "columns": [{
                    "data": "codproducto"
                },
                {
                    "data": "descripcion"
                },
                {
                    "data": "existencia"
                },
                {
                    "data": "codproducto"
                },
                {
                    "data": "precio"
                }

                // last column of table
            ],
            "columnDefs": [{
                    "render": function(number_row, type, row) {
                        return "<input id='cantidad_" + row.codproducto + "' type='number'/>";
                    },
                    "orderable": false,
                    "targets": 3 // columna HORARIO - INICIO
                },
                {
                    "render": function(number_row, type, row) {
                        return '<button class="btn btn-success" ' +
                            'onclick="insertadetalle(' + row.codproducto + ');"><i class="fa fa-plus"></i></button>';
                    },
                    "orderable": false,
                    "targets": 5 // columna modificar usuario
                }
            ],
            "language": {
                "decimal": "",
                "emptyTable": "No hay registros en la tabla",
                "info": "Se muestran _START_ a _END_ de _TOTAL_ registros",
                "infoEmpty": "Se muestran 0 a 0 de 0 registros",
                "infoFiltered": "(filtrado de _MAX_ registros totales)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ registros",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Filtar por (Número | Fecha | Cédula | Depto | Distrito):",
                "zeroRecords": "No se encontraron registros que coincidan",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
                "aria": {
                    "sortAscending": ": activar para ordenar la columna ascendente",
                    "sortDescending": ": activar para ordenar la columna descendente"
                }
            }
        });
        $('#filtrar').click(function(e) {
            e.preventDefault();
            $('#filtrar').attr("disabled", "disabled");
            $("#loading").show();
            table.ajax.reload();
        });

        table.on('draw', function() {
            $('#filtrar').removeAttr("disabled");
            $("#loading").hide();
        });
    });
</script>