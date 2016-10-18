<?PHP //var_dump($cliente);exit;?>

<script type="text/javascript">
    $(function() {
        $("#fecha_nacimiento").datepicker();
    });
          
        
    $( document ).ready(function() {
        $("#empleado_descripcion").autocomplete({
            source:'<?PHP echo base_url();?>index.php/clientes/selectAutocompleteEmpleados',
            minLength: 2,
            select: function(event, ui) {
               var integrante = '<input type="hidden" value="' + ui.item.id + '" name = "empleado_id_responsable" id = "empleado_id_responsable" >';
		$('#data').html(integrante);
            }
        });                                       
                       
        $("#tipo_cliente").change(function () {
            var op = $("#tipo_cliente option:selected").val();
            var array = op.split('xx-xx-xx');                                    

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
            <a href="<?PHP echo base_url()?>index.php/clientes/index" class="btn btn-success btn-xs" role="button">&nbsp;&nbsp;Atras&nbsp;&nbsp;</a>
            <div align="center"><h2>Modificar Cliente</h2></div>
            <form class="form-horizontal" role="form" action="<?PHP echo base_url() ?>index.php/clientes/modificar_g" method="POST">                                
                <div class="form-group">
                    <label for="tipo_cliente" class="col-sm-5 control-label">Tipo Cliente</label>                                                  
                                                    
                    <div class="col-xs-4">
                        <select class="form-control" name="tipo_cliente" id="tipo_cliente" required="">
                            <option value="0">Seleccionar</option>
                            <?PHP foreach ($tipo_clientes as $value_tipo_clientes){
                                $selected = ($value_tipo_clientes['id'] == $cliente['tipo_cliente_id']) ? "SELECTED" : '';?>                            
                            <option <?PHP echo $selected ;?> value="<?PHP echo $value_tipo_clientes['id'].'xx-xx-xx'.$value_tipo_clientes['tipo_cliente']?>"><?PHP echo $value_tipo_clientes['tipo_cliente']?></option>                            
                            <?PHP }?>                            
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <?PHP if($cliente['tipo_cliente_id']=='1'){?>
                    <label id="lbl_DNI_RUC" for="ruc" class="col-sm-5 control-label">DNI :</label>
                    <?PHP } else {?>
                    <label id="lbl_DNI_RUC" for="ruc" class="col-sm-5 control-label">RUC :</label>
                    <?PHP }?>
                    
                    <div class="col-xs-7">    
                        <input type="text" class="form-control" name="ruc" id="ruc" value="<?PHP echo $cliente['ruc']?>">
                    </div>
                </div>
                <div class="form-group">
                    <?PHP if($cliente['tipo_cliente_id']=='1'){?>
                    <label id="lbl_RAZ_APE" for="razon_social" class="col-sm-5 control-label">Apellidos: </label>
                    <?PHP } else {?>
                    <label id="lbl_RAZ_APE" for="razon_social" class="col-sm-5 control-label">Razón Social: </label>
                    <?PHP }?>
                    <div class="col-xs-7">
                        <input type="text" class="form-control" name="razon_social" id="razon_social" value="<?PHP echo $cliente['razon_social']?>">
                    </div>
                </div>
                <?PHP if($cliente['tipo_cliente_id']=='1'){?>
                <div id="nombres">                    
                        <div class="form-group">                           
                            <label for="nombres" class="col-sm-5 control-label">Nombres</label>                           
                            <div class="col-xs-7">
                                <input type="text" class="form-control" name="nombres" id="nombres" value="<?PHP echo $cliente['nombres']?>" placeholder="nombres">
                            </div>
                        </div>                    
                </div>                                                                
                
                <?PHP } else { ?>                    
                <div id="nombres" style="display: none">                    
                        <div class="form-group">                           
                            <label for="nombres" class="col-sm-5 control-label">Nombres</label>                           
                            <div class="col-xs-7">
                                <input type="text" class="form-control" name="nombres" id="nombres" value="<?PHP echo $cliente['nombres']?>" placeholder="nombres">
                            </div>
                        </div>                    
                </div>                                                                                                        
               <?PHP }?>
                <div class="form-group">
                    <label for="empleado_descripcion" class="col-sm-5 control-label">Abogado Attache: </label>
                    <div class="col-xs-7">
                            <?PHP 
                            $abogado_attach = (isset($abogado))?$abogado['apellido_paterno'].' '.$abogado['apellido_materno'].', '.$abogado['nombre']:'' ;
                            if(isset($abogado['id'])){?>
                                <div id="data">
                                    <input type="hidden" value="<?PHP echo $abogado['empleados_id']?>" name = "empleado_id_responsable" id = "empleado_id_responsable" >
                                </div>
                            <?PHP
                            }else{?>
                                <div id="data"></div>
                            <?PHP
                            }
                            ?>                                                        
                        <input type="text" class="form-control" name="empleado_descripcion" id="empleado_descripcion" value="<?PHP echo $abogado_attach?>">                        
                    </div>
                </div>
                <div class="form-group">
                    <label for="domicilio1" class="col-sm-5 control-label">Domicilio 1:</label>
                    <div class="col-xs-7">
                        <input type="text" class="form-control" name="domicilio1" id="domicilio1" value="<?PHP echo $cliente['domicilio1']?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="domicilio2" class="col-sm-5 control-label">Domicilio 2:</label>
                    <div class="col-xs-5">
                        <input type="text" class="form-control" name="domicilio2" id="domicilio2" value="<?PHP echo $cliente['domicilio2']?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-5 control-label">Email:</label>
                    <div class="col-xs-5">
                        <input type="text" class="form-control" name="email" id="email" value="<?PHP echo $cliente['email']?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="pagina_web" class="col-sm-5 control-label">Página web:</label>
                    <div class="col-xs-5">
                        <input type="text" class="form-control" name="pagina_web" id="pagina_web" value="<?PHP echo $cliente['pagina_web']?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="telefono_fijo_1" class="col-sm-5 control-label">Telefono fijo 1:</label>
                    <div class="col-xs-7">
                        <input type="text" class="form-control" name="telefono_fijo_1" id="telefono_fijo_1" value="<?PHP echo $cliente['telefono_fijo_1']?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="telefono_fijo_2" class="col-sm-5 control-label">Telefono fijo 2:</label>
                    <div class="col-xs-7">
                        <input type="text" class="form-control" name="telefono_fijo_2" id="telefono_fijo_2" value="<?PHP echo $cliente['telefono_fijo_2']?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="telefono_movil_1" class="col-sm-5 control-label">Telefono movil 1:</label>
                    <div class="col-xs-7">
                        <input type="text" class="form-control" name="telefono_movil_1" id="telefono_movil_1" value="<?PHP echo $cliente['telefono_movil_1']?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="telefono_movil_2" class="col-sm-5 control-label">Telefono movil 2:</label>
                    <div class="col-xs-7">
                        <input type="text" class="form-control" name="telefono_movil_2" id="telefono_movil_2" value="<?PHP echo $cliente['telefono_movil_2']?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="empresa" class="col-sm-5 control-label">Empresa:<?PHP echo $cliente['empresa_id'];?></label>
                    <div class="col-xs-4">
                        <select class="form-control" name="empresa" id="empresa" required="">
                            <option value="">Seleccionar</option>
                            <?PHP foreach ($empresas as $value_empresa) { 
                                $selected = ($cliente['empresa_id'] == $value_empresa['id'])? 'SELECTED' : '';
                                ?>
                                <option <?PHP echo $selected; ?> value="<?PHP echo $value_empresa['id'] ?>"><?PHP echo $value_empresa['empresa']; ?></option>
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
                            <?PHP
                            $selected = '';
                            foreach ($activos as $value_activos) {
                                $selected = ($value_activos['activo'] == $cliente['activo']) ? "SELECTED" : '';?>
                                <option <?PHP echo $selected;?> value="<?PHP echo $value_activos['activo'] ?>"><?PHP echo $value_activos['activo']; ?></option>
                                <?PHP
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="hidden" name="id" id="email" value="<?PHP echo $cliente['id'];?>">
                        <button type="submit" class="btn btn-primary">Modificar</button>
                    </div>
                </div>
            </form>

        </div>
        <div class="col-md-3">
        </div>
    </div>
</div>