<script type="text/javascript">
    $(document).ready(function () {
        $("#empleado_descripcion").autocomplete({
            source: '<?PHP echo base_url(); ?>index.php/clientes/selectAutocompleteEmpleados',
            minLength: 2,
            select: function (event, ui) {
                var integrante = '<input type="hidden" value="' + ui.item.id + '" name = "empleado_id_responsable" id = "empleado_id_responsable" >';
                $('#data').html(integrante);
            }
        });

        $("#datos").hide();
        $("#limitado_detalle").hide();

        $("#tipo_cliente").change(function () {
            var op = $("#tipo_cliente option:selected").val();
            var array = op.split('xx-xx-xx');
            $("#datos").show();

            if (array[0] == 1) {
                $("#lbl_DNI_RUC").text('DNI');
                $("#ruc").attr("placeholder","DNI");
                
                $("#lbl_RAZ_APE").text('Apellidos');
                $("#razon_social").attr("placeholder","Apellidos");
                $("#nombres").show();
            }

            if (array[0] == 2) {
                $("#lbl_DNI_RUC").text('RUC');
                $("#ruc").attr("placeholder","RUC");
                
                $("#lbl_RAZ_APE").text('Razon Social');
                $("#razon_social").attr("placeholder","razon_social");
                $("#nombres").hide();
            }

        });


    });
</script>
<br>
<div class="container">
    <!-- Example row of columns -->
    <div class="row">                
        <div class="col-md-3">
        </div>
        <div class="col-md-6">
            <a href="<?PHP echo base_url() ?>index.php/clientes/index" class="btn btn-success btn-xs" role="button">&nbsp;&nbsp;Atras&nbsp;&nbsp;</a>
            <div align="center"><h2>Ingresar Cliente</h2></div>
            <form class="form-horizontal" role="form" action="<?PHP echo base_url() ?>index.php/clientes/grabar" method="POST">
                <div class="form-group">
                    <label for="tipo_cliente" class="col-sm-5 control-label">Tipo Cliente:</label>
                    <div class="col-xs-4">
                        <select class="form-control" name="tipo_cliente" id="tipo_cliente" required="">
                            <option>Seleccionar</option>
                            <?PHP foreach ($tipo_clientes as $value_tipo_clientes) { ?>
                                <option value="<?PHP echo $value_tipo_clientes['id'].'xx-xx-xx'.$value_tipo_clientes['tipo_cliente']; ?>"><?PHP echo $value_tipo_clientes['tipo_cliente']; ?></option>
                                <?PHP
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div id="datos">    
                    <div class="form-group">
                        <label id="lbl_DNI_RUC" for="ruc" class="col-sm-5 control-label">Ruc:</label>

                        <div class="col-xs-7">
                            <input type="text" class="form-control" name="ruc" id="ruc" placeholder="RUC">
                        </div>
                    </div>
                    <div class="form-group">
                        <label id="lbl_RAZ_APE" for="razon_social" class="col-sm-5 control-label">Razón Social</label>
                        <div class="col-xs-7">
                            <input type="text" class="form-control" name="razon_social" id="razon_social" placeholder="razon_social" required="">
                        </div>
                    </div>
                    <div id="nombres">
                        <div class="form-group">
                            <label for="nombres" class="col-sm-5 control-label">Nombres</label>
                            <div class="col-xs-7">
                                <input type="text" class="form-control" name="nombres" id="nombres" placeholder="nombres">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="empleado_descripcion" class="col-sm-5 control-label">Abogado Attache</label>
                        <div class="col-xs-7">                        
                            <input type="text" class="form-control input-sm" id="empleado_descripcion" name="empleado_descripcion" placeholder="Buscar">
                            <div id="data"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="domicilio1" class="col-sm-5 control-label">Domicilio 1:</label>
                        <div class="col-xs-7">
                            <input type="text" class="form-control" name="domicilio1" id="domicilio1" placeholder="domicilio1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="domicilio2" class="col-sm-5 control-label">Domicilio 2:</label>
                        <div class="col-xs-5">
                            <input type="text" class="form-control" name="domicilio2" id="domicilio2" placeholder="domicilio2">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-5 control-label">Email:</label>
                        <div class="col-xs-5">
                            <input type="text" class="form-control" name="email" id="email" placeholder="email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pagina_web" class="col-sm-5 control-label">Página web:</label>
                        <div class="col-xs-5">
                            <input type="text" class="form-control" name="pagina_web" id="pagina_web" placeholder="pagina_web">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="telefono_fijo_1" class="col-sm-5 control-label">Telefono fijo 1:</label>
                        <div class="col-xs-7">
                            <input type="text" class="form-control" name="telefono_fijo_1" id="telefono_fijo_1" placeholder="telefono_fijo_1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="telefono_fijo_2" class="col-sm-5 control-label">Telefono fijo 2:</label>
                        <div class="col-xs-7">
                            <input type="text" class="form-control" name="telefono_fijo_2" id="telefono_fijo_2" placeholder="telefono_fijo_2">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="telefono_movil_1" class="col-sm-5 control-label">Telefono movil 1:</label>
                        <div class="col-xs-7">
                            <input type="text" class="form-control" name="telefono_movil_1" id="telefono_movil_1" placeholder="telefono_movil_1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="telefono_movil_2" class="col-sm-5 control-label">Telefono movil 2:</label>
                        <div class="col-xs-7">
                            <input type="text" class="form-control" name="telefono_movil_2" id="telefono_movil_2" placeholder="telefono_movil_2">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="empresa" class="col-sm-5 control-label">Empresa:</label>
                        <div class="col-xs-4">
                            <select class="form-control" name="empresa" id="empresa" required="">
                                <?PHP foreach ($empresas as $value_empresa) { ?>
                                    <option value="<?PHP echo $value_empresa['id'] ?>"><?PHP echo $value_empresa['empresa']; ?></option>
                                    <?PHP
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="activo" class="col-sm-5 control-label">Activo:</label>
                        <div class="col-xs-4">
                            <select class="form-control" name="activo" id="activo">
                                <?PHP foreach ($activos as $value_activos) { ?>
                                    <option value="<?PHP echo $value_activos['activo'] ?>"><?PHP echo $value_activos['activo']; ?></option>
                                    <?PHP
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
        <div class="col-md-3">
        </div>
    </div>
</div>