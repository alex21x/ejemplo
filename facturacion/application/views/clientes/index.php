

<script type="text/javascript">
    $(document).ready(function() {
        $("#cliente").autocomplete( {
            source: '<?PHP echo base_url(); ?>index.php/comprobantes/buscador_cliente',
            minLength: 2,
            select: function(event, ui) {
                var data_cli ='<input type="hidden" value="' + ui.item.id + '" name = "cliente_id" id = "cliente_id" >';
                $('#data_cli').html(data_cli);
            }
        });
    })
    ;</script>

<style type="text/css">
.clase_tahoma{
        font-family: Tahoma, Verdana, Segoe, sans-serif;
    }            
</style>

<div align="center">
    <h3>Clientes</h3>
</div>
<p class="bg-info">
    <?PHP echo $this->session->flashdata('mensaje_cliente_index'); ?>
</p>
<form  role="form" method="post" action="<?PHP echo base_url()?>index.php/clientes/index" name="form1" id="form1">    
    <div class="container">
        <div class="row">            
            <table class="table table-striped">
                <tr><td>                   
                <div class="col-sm-1" align="right">                     
                <label for="cliente">Cliente:</label>
                </div>   
                    </td>                    
                    <td>                                                
                <div class="col-lg-12">
                    <input type="text" value="<?PHP if(isset($cliente_select)){ echo $cliente_select;}?>" class="form-control input-sm" id="cliente" name="cliente" placeholder="Cliente">
                </div>     
                <?PHP                
                $cliente_select = (isset($cliente_select_id))? '<input id="cliente_id" type="hidden" name="cliente_id" value="'. $cliente_select_id . '">' : '';
                ?>
                <div id="data_cli"><?PHP echo $cliente_select?></div>
                
                    </td>
                    
                    <td>
                <div class="col-lg-10">
                    <select name="estado_cliente" id="estado_cliente" class="form-control input-sm">
                        <option value="todos">Todos</option>
                        <?PHP   
                        $selected = '';
                        $tipo_activo = (isset($tipo_activo_select)) ? $tipo_activo_select : '';
                        
                        foreach ($activos as $value_activos) {
                            $selected = (($tipo_activo == $value_activos['id']) && ($tipo_activo != '')) ? 'SELECTED' : '';
                            ?>
                            <option <?PHP echo $selected; ?> value="<?PHP echo $value_activos['id']; ?>"><?PHP echo $value_activos['activo']; ?></option>
                        <?PHP                         
                        }
                        ?>
                    </select>
                </div>                                                
                </td> 
                    
                    
                    <td><div class="col-lg-10" align="right">
                        <label for="tipo_cliente">T. Cliente:</label>
                        </div>
                    </td>                                        
                    
                    
                    <td>
                <div class="col-lg-10">
                    <select name="tipo_cliente" id="tipo_cliente" class="form-control input-sm">
                        <option value="todos">Todos</option>
                        <?PHP   
                        
                        $tipo_cliente = (isset($tipo_clientes_select)) ? $tipo_clientes_select : '';
                        
                        foreach ($tipo_clientes as $value_tipo_clientes) {
                            $selected = (($tipo_cliente == $value_tipo_clientes['id']) && ($tipo_cliente != '')) ? 'SELECTED' : '';
                            ?>
                            <option <?PHP echo $selected; ?> value="<?PHP echo $value_tipo_clientes['id']; ?>"><?PHP echo $value_tipo_clientes['tipo_cliente']; ?></option>
                        <?PHP                         
                        }
                        ?>
                    </select>
                </div>
                    </td>
                
                                           
                <tr><td>
                    <div class="col-sm-1" align="right">                     
                            <label for="tipo_contratos">Contrato:</label>
                    </div>
                    </td>
                        <td>
                    <div class="col-lg-12">
                    <select name="tipo_contratos" class="form-control input-sm" id="tipo_contratos">
                        <?PHP
                        $tipo_select = (isset($tipo_contratos_select)) ? $tipo_contratos_select : '';
                        ?>
                        <option value="0">Todos</option>
                        <?PHP
                        foreach ($tipo_contratos as $value_tipoContratos) {
                            $selected = ($tipo_select == $value_tipoContratos['id']) ? 'SELECTED' : '';
                            ?>
                            <option <?PHP echo $selected; ?> value="<?PHP echo $value_tipoContratos['id']; ?>"><?PHP echo $value_tipoContratos['tipo_contrato']; ?></option>
                        <?PHP                            
                        }
                        ?>
                    </select>                    
                    </div>
                        </td>
                        <td>
                    <div class="col-lg-10 ">
                    <select name="estado_contrato" id="estado_contrato" class="form-control input-sm">
                        <?PHP
                        $tipo_activo_contrato = (isset($tipo_activo_contrato_select)) ? $tipo_activo_contrato_select : '';
                        //var_dump($tipo_activo_contrato);exit;                                                
                        ?>
                        
                        <option value="todos">Todos</option>
                        <?PHP
                        foreach ($activos as $value_activos) {
                            $selected = (($tipo_activo_contrato == $value_activos['id']) && ($tipo_activo_contrato != '')) ? 'SELECTED' : '';                            
                            ?>
                            <option <?PHP echo $selected; ?> value="<?PHP echo $value_activos['id']; ?>"><?PHP echo $value_activos['activo']; ?></option>
                            <?PHP }
                        ?>
                    </select>                        
                </div>
            </td>
                </tr>
                <tr><td colspan="5" align="center">
                <div class="col-lg-10">
                    <input type="submit" class="btn btn-primary input-sm" id="boton1" value="Buscar" />
                </div>
                </td></tr>
            </table>
            
            
                </div>                        
        </div>
        
    </div>
</form>
<hr>
<div class="container-fluid">
    <!-- Example row of columns -->
    <div class="row">        
        <div class="col-xs-6" style="padding-left: 10%">            
        </div>
        <?PHP if (($this->session->userdata('tipo_empleado_id') == 1)) { ?>
            <div class="col-xs-6" style="padding-left: 30%">
                <a href="<?PHP echo base_url() ?>index.php/clientes/nuevo" class="btn btn-success btn-xs" role="button">Agregar</a>
            </div>
        <?PHP } ?>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped">
                <tr>
                    <th>N.</th>
                    <th>T.Cliente</th>
                    <th>Ruc/Dni</th>
                    <th>Razón Social/Apellidos y Nombres</th>
                    <th>Empresa</th>
                    <th>Contactos</th>
                    <th>Contratos</th>
                    <?PHP if (($this->session->userdata('tipo_empleado_id') == 1)) { ?>
                        <th><span class="glyphicon glyphicon-pencil"></span></th>
                        <th><span class="glyphicon glyphicon-trash"></span></th>
                    <?PHP } ?>
                </tr>
                <?PHP
                $i = 0;
                foreach ($clientes as $value) {
                    $i++
                    ?>
                    <tr>
                        <td><?PHP echo $i ?></td>
                        <td><?PHP echo $value['tipo_cliente'] ?></td>
                        <td><a onclick="javascript:window.open('<?PHP echo base_url() ?>index.php/clientes/perfil/<?PHP echo $value['cliente_id']; ?>', '', 'width=750,height=600,scrollbars=yes,resizable=yes')" href="#"><?PHP echo $value['ruc'] ?></a></td>
                        <?PHP if($value['tipo_cliente_id']=='1') {?>
                        <td><?PHP echo $value['razon_social']." ".$value['nombres']; ?></td>                        
                        <?PHP } else { ?>
                        <td><?PHP echo $value['razon_social']; ?></td>
                        <?PHP } ?>
                        <td><?PHP echo $value['empresa'] ?></td>                    
                        <td><a onclick="javascript:window.open('<?PHP echo base_url() ?>index.php/contactos/index/<?PHP echo $value['cliente_id']; ?>', '', 'width=1050,height=600,scrollbars=yes,resizable=yes')" href="#">Contactos</a></td>
                        <td><a onclick="javascript:window.open('<?PHP echo base_url() ?>index.php/contratos/index/<?PHP echo $value['cliente_id']; ?>', '', 'width=1050,height=600,scrollbars=yes,resizable=yes')" href="#">Contratos</a></td>
                        <?PHP if (($this->session->userdata('tipo_empleado_id') == 1)) { ?>
                        <td><a title="Modificar" href="<?PHP echo base_url() ?>index.php/clientes/modificar/<?PHP echo $value['cliente_id']; ?>"><button class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-pencil"></span></button></a></td>
                        <td><a title="Eliminar" href="<?PHP echo base_url() ?>index.php/clientes/eliminar/<?PHP echo $value['cliente_id']; ?>/<?PHP echo $value['razon_social']; ?>"><button class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></button></a></td>
                        <?PHP } ?>
                    </tr>
                    <?PHP }
                ?>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center">
            <?PHP echo $pagination;?>
        </div>
        
    </div>
</div>