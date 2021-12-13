<?php include_once "includes/header.php";
include('core/config.php');
$dbconn = getConnection();
//generamos la fecha y hora actual
$fechaingreso = date('Y-m-d H:i:s');
$fecha = date("d/m/Y", strtotime($fechaingreso));
// llamamos al ultimo id de la tabla compra
$stmt = $dbconn->query('SELECT IFNULL(MAX(id), 0)+1 AS numero FROM compra');
$compra = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <div class="card">
                    <div class="card-body">
                        <div align="center">
                            <h4>Registro de Compras</h4>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card">
                <div class="card-body">
                    <form method="post" name="form_new_cliente_venta" id="form_new_cliente_venta">
                        <div class="row">
                            <input type="hidden" name="id_compra" id="id_compra" value="<?= $compra['numero']; ?>">
                            <div class="col-lg-4 col-xs-12">
                                <label>Pedido</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control rounded-0" name="pedido_id" id="pedido_id" placeholder="">
                                    <span class="input-group-append" id="search">
                                        <button id="buscarpedido" type="button" class="btn btn-primary btn-flat" data-toggle="modal" data-target="#myModal"><i class="fas fa-search"></i> Buscar</button>
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-4 col-xs-12">
                                <label>Usuario</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control rounded-0" name="usuario" id="usuario" value="<?= $_SESSION['nombre']; ?>" placeholder="" readonly>
                                </div>
                            </div>
                            <div class="col-lg-4 col-xs-12">
                                <label>Fecha</label>
                                <div class="input-group date datepicker">
                                    <input type="text" class="form-control" value="<?= $fecha; ?>" required name="vped_fecha" disabled="" />
                                    <span class="input-group-addon btn btn-primary">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-xs-12">
                                <label>Proveedor</label>
                                <div class="input-group mb-3">
                                    <input type="hidden" class="form-control rounded-0" name="proveedor_id" id="proveedor_id" value="" placeholder="" readonly>
                                    <input type="text" class="form-control rounded-0" name="proveedor" id="proveedor" value="" placeholder="" readonly>
                                </div>
                            </div>
                            <div class="col-lg-4 col-xs-12">
                                <label>Sucursal</label>
                                <div class="input-group mb-3">
                                    <input type="hidden" class="form-control rounded-0" name="sucursal_id" id="sucursal_id" value="" placeholder="" readonly>
                                    <input type="text" class="form-control rounded-0" name="sucursal" id="sucursal" value="" placeholder="" readonly>
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
                    <div class="card">
                        <div class="card-body">
                            <div align="center">
                                <h4>Detalles de la Compra</h4>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover" id=litadodetalle>
                            <thead class="thead-dark">
                                <tr>
                                    <th width="90px">Código</th>
                                    <th>Producto</th>
                                    <th>Stock Actual</th>
                                    <th width="100px">Cantidad</th>
                                    <th class="textright">Precio Unit</th>
                                    <th>Precio Total</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>


                            <tfoot class="thead-dark">
                                <td class="bg-grays-active color-palette"><b>Total </b></td>
                                <td class="bg-teals-active color-palette text-center">
                                    <strong id="abiertoEnTiempo"></strong>
                                </td>
                                <td class="bg-teals-active color-palette text-center">
                                    <strong></strong>
                                </td>
                                <td class="bg-teals-active color-palette text-center">
                                    <strong></strong>
                                </td>
                                <td class="bg-teals-active color-palette text-center">
                                    <strong></strong>
                                </td>
                                <td class="bg-teals-active color-palette text-center">
                                    <strong id="monto">0</strong>
                                </td>
                            </tfoot>
                        </table>

                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
    <div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <form id="form" class="user">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Buscar Pedido</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!--<div class="form-group row mb-3">
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="des" name="des" placeholder="Buscar productos">
                            </div>
                            <div class="col-sm-4">
                                <button id="filtrar" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                            <div id="loading" class="col-sm-12 text-center hide" style="display: none;">
                                <i class="fa fa-spinner fa-spin"></i> Procesando consulta
                            </div>

                        </div>-->

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="listapedido" class="table table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
                                    <thead class="thead-dark">

                                        <tr>
                                            <th>Codigo</th>
                                            <th>Fecha</th>
                                            <th>Proveedor</th>
                                            <th>Sucursal</th>
                                            <th>Usuario</th>
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
            jQuery.fn.dataTable.Api.register('sum()', function() {
                return this.flatten().reduce(function(a, b) {
                    if (typeof a === 'string') {
                        a = a.replace(/[^\d.-]/g, '') * 1;
                    }
                    if (typeof b === 'string') {
                        b = b.replace(/[^\d.-]/g, '') * 1;
                    }
                    return a + b;
                }, 0);
            });

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

            insertacompra = function(id, proveedor_id, proveedor, sucursa_id, sucursal) {
                event.preventDefault();
                $("#pedido_id").val(id);
                $("#proveedor_id").val(proveedor_id);
                $("#proveedor").val(proveedor);
                $("#sucursal_id").val(sucursa_id);
                $("#sucursal").val(sucursal);
                $('#myModal').modal('hide');

                datos = {
                    "accion": "comprasdetalles",
                    "pedido": id,
                    "proveedor": proveedor_id,
                    "sucursal": sucursa_id
                };

                $.ajax({
                    url: './backend/compra.php',
                    method: 'POST',
                    data: datos,
                    success: function(data) {
                        try {
                            response = JSON.parse(data);

                            if (response.status == "success") {
                                alert("Compra realizada con exito");

                                table1.ajax.reload();

                            } else {
                                Swal.fire({
                                    title: 'Advertencia',
                                    text: "Ocurrio un error intentado resolver la solicitud. Por favor contacte con el administrador del sistema",
                                    icon: 'warning',
                                    confirmButtonText: 'Ok'
                                });
                            }
                        } catch (error) {
                            Swal.fire({
                                title: 'Advertencia',
                                text: "Ocurrio un error intentado resolver la solicitud. Por favor contacte con el administrador del sistema",
                                icon: 'warning',
                                confirmButtonText: 'Ok'
                            });
                        }
                    },
                    error: function(data) {
                        Swal.fire({
                            title: 'Advertencia',
                            text: "Ocurrio un error intentado resolver la solicitud. Por favor contacte con el administrador dela red",
                            icon: 'warning',
                            confirmButtonText: 'Ok'
                        });
                    }
                });


            };



            var table = $('#listapedido').DataTable({
                "processing": true,
                "serverSide": true,
                "ordering": false,
                "searching": false,

                "ajax": {
                    "url": "./backend/listados/buscarpedido.php",
                    timeout: 15000,
                    error: handleAjaxError,
                },
                "columns": [{
                        "data": "id"
                    }, // first column of table
                    {
                        "data": "fechapedido"
                    },
                    {
                        "data": "proveedor"
                    },
                    {
                        "data": "sucursal"
                    },
                    {
                        "data": "usuario"
                    },
                ],
                "columnDefs": [{
                    "render": function(number_row, type, row) {
                        return '<button class="btn btn-success btn-user" ' +
                            'onclick="insertacompra(' + row.id + ',' + row.proveedor_id + ',\'' + row.proveedor + '\',' + row.sucursa_id + ',\'' + row.sucursal + '\');"><i class="fa fa-shopping-cart"></i></button>';
                    },
                    "orderable": false,
                    "targets": 5 // columna modificar usuario
                }],
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


            var table1 = $('#litadodetalle').DataTable({
                "processing": true,
                "serverSide": true,
                "ordering": false,
                "searching": false,
                "ajax": {
                    "url": "./backend/listados/detallecompra.php",
                    timeout: 15000,
                    error: handleAjaxError,
                    "data": function(data) {
                        data.compra = $('#id_compra').val()
                    }
                },
                "columns": [{
                        "data": "codigo"
                    }, // first column of table
                    {
                        "data": "descripcion"
                    },
                    {
                        "data": "existencia"
                    },
                    {
                        "data": "cantidad"
                    },
                    {
                        "data": "precio"
                    },
                    {
                        "data": "total"
                    },
                    {
                        "data": "id"
                    } // last column of table
                ],
                "columnDefs": [{
                    "render": function(number_row, type, row) {
                        return '<button class="btn btn-warning btn-user btn-block" ' +
                            'onclick="eliminar(' + row.id_pedido + ',' + row.codigo + ');">Quitar</button>';
                    },
                    "orderable": false,
                    "targets": 6 // columna modificar usuario
                }],
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
                    "search": "Filtar por (Nombre | Email | Rol):",
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
                },
                drawCallback: function() {
                    var api = this.api();
                    var total = api.column(5, {
                        "filter": "applied"
                    }).data().sum();
                    $('#monto').html(total);
                }
            });

        });
    </script>