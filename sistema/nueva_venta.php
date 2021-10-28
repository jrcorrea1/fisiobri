<?php include_once "includes/header.php"; ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="card" style="    left: 0px;

right: 40px;
                                    margin-right: 42px;
                                    margin-bottom: 20px">
                                  <div class="card-body">
                                    <div align="center"><h4>Registro de Ventas</h4></div>
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
                                    <div class="card" style="    left: 0px;

    right: 40px;
                                        margin-right: 42px;
                                        margin-bottom: 20px">
                                      <div class="card-body">
                                        <div align="center"><h4>Detalles de Venta</h4></div>
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
                                            <th>Producto</th>
                                            <th>Stock Actual</th>
                                            <th width="100px">Cantidad</th>
                                            <th class="textright">Precio Unit</th>
                                            <th class="textright">Exenta</th>
                                            <th class="textright">Iva 5%</th>
                                            <th class="textright">Iva 10%</th>
                                            <th>Acciones</th>
                                        </tr>
                                        <tr>
                                            <td><input type="number" name="txt_cod_producto" id="txt_cod_producto"></td>
                                            <td id="txt_descripcion">-</td>
                                            <td id="txt_existencia">-</td>
                                            <td><input type="text" name="txt_cant_producto" id="txt_cant_producto"value="0" min="1" disabled></td>
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
                                            <th class="textright">Precio Uni</th>
                                            <th class="textright">Exenta</th>
                                            <th class="textright">Iva 5%</th>
                                            <th class="textright">Iva 10%</th>
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


            <?php include_once "includes/footer.php"; ?>
