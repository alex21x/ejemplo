
<script type="text/javascript">
$(function(){
        $("#fecha_de_emision").datepicker();        
});       
</script>
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
    });

</script>

<p class="bg-info">
    <?PHP echo $this->session->flashdata('mensaje'); ?>
</p>
<form method="post" action="<?PHP echo base_url()?>index.php/comprobantes/index" name="form1" id="form1">
<div class="container">
    <h2>Lista de Comprobantes</h2>
    
    <div class="row">
        <div class="col-md-1">
            <label></label>
        </div>        
        <table class="table table-striped">
            <tr>
                <td>
                    <div class="col-md-4">
                        <label>Cliente</label>
                    </div>
                </td>    
                <td>
                    <div class="col-md-12">
                    <input type="text" class="form-control" id="cliente" name="cliente" placeholder="Cliente">
                    </div>
                    <div id="data_cli"></div>
                </td>
                <td>
                    <div class="col-md-4">
                        <label>Tip.Doc</label>
                    </div>
                </td>
                <td>
                    <div class="col-md-8">
                        <select class="form-control" name="tipo_documento" id="tipo_documento">
                            <?PHP foreach ($tipo_documentos as $value) { ?>                                                                                        
                            <option value="<?PHP echo $value['id']?>"><?PHP echo $value['tipo_documento']?></option>                            
                            <?PHP }?>
                        </select>
                    </div>                    
                </td>
                <td>
                    <label>Fec.Emision</label>
                </td>
                <td>
                    <div class="col-md-8">
                        <input class="form-control" type="text" name="fecha_de_emision" id="fecha_de_emision">
                    </div>
                </td>
                
            </tr>
            <tr>
                <td>
                    <div class="col-md-4">
                        <label>Serie</label>
                    </div>
                </td>    
                <td>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="serie" name="serie" placeholder="serie">
                    </div>
                </td>                
                <td>
                    <div class="col-md-4">
                        <label>Numero</label>
                    </div>
                </td>    
                <td>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="numero" name="numero" placeholder="numero">
                    </div>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="6" style="text-align:center"><input type="submit" class="btn btn-primary" value="Buscar"></td>
            </tr>
        </table>                
    </div>
</div>
    </form>

<div class="container-fluid">            
    <div class="row">
    <table class="table table-striped text-center">    
        <tr style="font-weight: bold;">
            <td>N°</td>
            <td>Cliente</td>
            <td>T.Documento</td>
            <td>Serie</td>
            <td>Numero</td>
            <td>F.Emisión</td>
            <td>F.Vencimiento</td>                        
            <td>Igv</td>
            <td>Total</td>
            <td>Cancelado</td>
            <td>Estado Sunat</td>
            <td>PDF</td>
            <td>XML</td>
            <td>CDR</td>
            <td>Accion</td>
        </tr>        
        <?PHP foreach ($comprobantes as $value) {?>                                    
        <tr>            
            <td class="col-sm-1"><a onclick="javascript:window.open('<?PHP echo base_url() ?>index.php/comprobantes/detalle/<?PHP echo $value['comprobante_id']?>','','width = 750, height = 600,scrollbars = yes,resizable = yes')" href="#"><?PHP echo $value['comprobante_id']?></a></td>
            <td class="col-sm-4 text-left"><?PHP echo $value['razon_social']?></td>
            <td class="col-sm-1"><?PHP echo $value['tipo_documento']?></td>
            <td class="col-sm-1 text-center"><?PHP echo $value['serie']?></td>
            <td class="text-left"><?PHP echo $value['numero']?></td>
            <td class="col-xs-1"><?PHP echo $value['fecha_de_emision']?></td>
            <td><?PHP echo $value['fecha_de_vencimiento']?></td>                        
            <td class="col-xs-1 text-center"><?PHP echo $value['total_igv']?></td>
            <td class="text-right"><?PHP echo $value['total_a_pagar']?></td>
            <?PHP if($value['operacion_cancelada'] == 1){?>
            <td><button class="btn btn-success btn-xs"><span class="glyphicon glyphicon glyphicon-ok"></span></button></td>
            <?PHP } else {?>
            <td class="col-xs-1"><span class="glyphicon glyphicon glyphicon-remove"></span></td>
            <?PHP }?>            
            <td class="col-xs-1"><span class="glyphicon glyphicon-remove"></span></td>
            <td class="col-xs-1"><a onclick="javascript:window.open('<?PHP echo base_url('index.php/comprobantes/pdfGeneraComprobante/'.$value['comprobante_id'].'/'.$value['cliente_id']);?>','','width=750,height=600,scrollbars=yes')" href='#'><img src="<?PHP echo base_url()?>images/pdf.png"/></a></td>
            <td class="col-xs-1"><span class="glyphicon glyphicon-remove"></span></td>
            <td class="col-xs-1"><span class="glyphicon glyphicon-remove"></span></td>
            <td><div class="dropup">
                  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Accion
                    <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                    <li><a href="<?PHP echo base_url();?>index.php/comprobantes/modificar/<?PHP echo $value['comprobante_id']?>">Editar</a></li>                    
                    <li><a href="#">Eliminar</a></li>
                    <li><a href="#">Generar NOTA DE CREDITO</a></li>
                    <li><a href="#">Generar NOTA DE DEBITO</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="<?PHP echo base_url();?>index.php/comprobantes/txt/<?PHP echo $value['comprobante_id']?>">Enviar Sunat</a></li>
                    <li><a href="#">Anular Comunicar de Baja</a></li>
                  </ul>
                </div>      
            </td>
        </tr>
        <?PHP }?>
    </table>    
</div>
    </div>
