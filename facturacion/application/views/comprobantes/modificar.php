<script src="<?PHP echo base_url(); ?>assets/jquery.validation/jquery.validate.js"></script>
<script src="<?PHP echo base_url(); ?>assets/jquery.validation/jquery.validate.min.js"></script>
<script src="<?PHP echo base_url(); ?>assets/js/comprobante.js"></script>
<script src="<?PHP echo base_url(); ?>assets/js/funciones.js"></script>
<script type="text/javascript">
    
    // Funciones Fechas --
    $(function(){
        $("#fecha_de_emision").datepicker();                                    
        $("#fecha_de_vencimiento").datepicker();                            
    });         
    // Cargar Cliente - AL Seleccionar cargar Contrato --
    $(document).ready(function(){
       $('#cliente').autocomplete({
            source : '<?PHP echo base_url();?>index.php/comprobantes/buscador_cliente',
            minLength : 2,
            select : function (event,ui){
                $('#contrato').load('<?PHP echo base_url()?>index.php/actividades/cargarContratos/'+ ui.item.id);                                
                var data_cli = '<input type="hidden" value="'+ ui.item.id + '" name = "cliente_id" id = "cliente_id" >';
                $('#data_cli').html(data_cli);                 
            },                    
            change : function(event,ui){
                if(!ui.item){
                    this.value = '';
                    $('#cliente_id').val(''); 
                }                   
            }                
    });         
              
    // CAPTURANDO EVENTOS                        
     $('#guardar').on('click',function(e){       
      //Campos Vacios                                 
        var cam = '';
        var cab = 0;
        var item = 0;
     
        if($('#cliente_id').val() == ''){ cam += '\n- cliente'; cab++ }
        if($('#serie').val() == '')     { cam += '\n- serie '; cab++;}
        if($('#numero').val() == '')    { cam += '\n- numero '; cab++;}
                                
        // ARRAY DE CAMPOS
        //if(isset[$array])                
        var descripcion = $('.descripcion');        
        
        $.each(descripcion,function(indice,value){        
            console.log($(this).val());
                      if($(this).val() === '') {
                          cam += '\n- descripcion'+'|'+indice;  
                          item++;
                      }
        });        
        
        var importe = $('.importe');                                       
        $.each(importe,function(indice,value){        
            console.log($(this).val());
                      if($(this).val() === '') {
                          cam += '\n- importe'+'|'+indice;  
                          item++;
                      }
        });
        
        var cantidad = $('.cantidad');        
        
        $.each(cantidad,function(indice,value){        
            console.log($(this).val());
                      if($(this).val() === '') {
                          cam += '\n- cantidad'+'|'+indice;  
                          item++;
                      }                                            
        });
                        
        if($('#operacion_gratuita').is(':checked')){                                                                                   
            //var total = 0;
            var tabla = $('tbody tr');                

            $.each(tabla , function(indice,value){
                //total += parseFloat($(this).find('#total').val());
                var tipoIgv = $(this).find('#tipo_igv').val();
                if(tipoIgv < 8){
                   cam += '\n- tipo_igv'+'|'+indice;                   
                   item++;
               }
            });
        }                        
        
        if(cab > 0){
        var foco = cam.split('- ');                
        $('#'+foco[1]).focus();
        } 
            else if(item > 0){                   
            var foco = cam.split('- ');  
            console.log(foco[1]);
            var foc  = foco[1].split('|');    
            
            //alert(foc[0]+foc[1])
            $('tbody tr:eq('+foc[1]+')'+' .'+foc[0]).focus();   
        }
      
        //alert(cam);
        if(cam !== ''){
            alert('Campos Requeridos '+cam);
            return false;
        }  
        
        if ($('#tabla >tbody >tr').length === 0){
            alert( "Debe Ingresar por los menos un Item!" );
            return false;
        }                
    });
  });                          
            
             
    // FUNCIONES            
    function calcular(){        
        var total_igv = 0;
        var total_a_pagar = 0;        
        var total_gravada = 0;
        var total_exonerada = 0;
        var total_inafecta  = 0;        
        
        var tabla = $('#tabla > tbody > tr');
        
        $.each(tabla,function(indice,value){            
                        
            var tipoIgv = $(this).find('#tipo_igv').val();
            
                if(tipoIgv < 8){
                    total_gravada   += parseFloat($(this).find('#subtotal').val());
                    total_igv += parseFloat($(this).find('#igv').val())
                }
                else if(tipoIgv < 9){
                    total_exonerada += parseFloat($(this).find('#subtotal').val());
                    total_igv += parseFloat($(this).find('#igv').val());
                }
                    else{
                    total_inafecta  += parseFloat($(this).find('#subtotal').val());
                    total_igv += parseFloat($(this).find('#igv').val());
                }
            
                        console.log($(this).find('#tipo_igv').val());
                        
                        //total_igv += parseFloat($(this).find('#igv').val());
                        total_a_pagar  +=  parseFloat($(this).find('#total').val());                        
            });                                    
            
            $('#total_igv').val(total_igv.toFixed(2));
            $('#total_a_pagar').val(total_a_pagar.toFixed(2));
            $('#total_gravada').val(total_gravada.toFixed(2));
            $('#total_inafecta').val(total_inafecta.toFixed(2));
            $('#total_exonerada').val(total_exonerada.toFixed(2));                                                             
            
            
            if($('#operacion_gratuita').is(':checked')) {
            operacion_gratuita();
            total_a_pagar = 0;                   
        }                
            cmp.detraccion(total_a_pagar);
            return total_a_pagar;
    }     
    
    function operacion_gratuita(){        
        if($('#operacion_gratuita').is(':checked')){
            var total = $('#total_a_pagar').val();
            $('.input-group input:text').each(function(){ $($(this)).val(''); });            
            $('#total_gratuita').val(total); 
            cmp.detraccion(0);
        } else {
          $('#total_gratuita').val('');
            cmp.calcular();          
        }                        
    }
    
    function tipoVenta(parent){                                    
       var tipoVenta = $(parent).find('#tipo_venta option:selected').val();
       
       //alert(tipoVenta);                     
            if(tipoVenta == 2){
               //$('#panelDetraccion :input').prop('disabled',true);
               $(parent).find('#cantidad').prop('readonly',false);               
            }
            else{
               //$('#panelDetraccion :input').prop('disabled',true);
               $(parent).find('#cantidad').val('1');
               $(parent).find('#cantidad').prop('readonly',true);
               cmp.calcular(parent);
           }                   
    }        
           
    // Calculos SubTotales ,Totales        
    function comprobante(){            
        this.subtotal = 0;
        this.total = 0;
        this.igv = 0;                                                    
    }
    
    comprobante.prototype.calcular = function(parent){
            var importe  = $(parent).children().children('#importe').val();
            var cantidad = $(parent).children().children('#cantidad').val();
            var tipoIgv  = $(parent).children().children('#tipo_igv').val();
            
            if(tipoIgv < 8){
                this.subtotal = parseFloat(importe*cantidad).toFixed(2);
                this.total = parseFloat(this.subtotal*1.18).toFixed(2);
                this.igv = parseFloat(this.subtotal*0.18).toFixed(2);               
           }               
               else if(tipoIgv < 9){
                this.subtotal = parseFloat(importe*cantidad).toFixed(2);
                this.total = this.subtotal;
                this.igv = '0.00';                                  
               }                   
                   else if (tipoIgv < 40){
                this.subtotal = parseFloat(importe*cantidad).toFixed(2);
                this.total = this.subtotal;
                this.igv = '0.00';                                 
                       
                   }                       
                       else{
                this.subtotal = parseFloat(importe*cantidad).toFixed(2);
                this.total = this.subtotal;
                this.igv = '0.00';                                                             
                       }                                                          
                        
            $(parent).children().children('#subtotal').val(this.subtotal);
            $(parent).children().children('#total').val(this.total);
            $(parent).children().children('#igv').val(this.igv);        
            calcular();
        };
        
    comprobante.prototype.detraccion = function(total_a_pagar){                                    
        if(total_a_pagar > 700){
            $('#detraccion').prop('checked',true);
            $('#tipo_de_detraccion').prop('disabled',false);
            $('#porcentaje_de_detraccion').val(10);
            $('#total_detraccion').val(((total_a_pagar)/10).toFixed(2));
        } else {
            $('#detraccion').prop('checked',false);            
            $('#tipo_de_detraccion').prop('disabled',true);
            $('#porcentaje_de_detraccion').val('');                                                            
            $('#total_detraccion').val('');                
        }                                                                       
        };
        
    //Instanciando Objeto
    cmp = new comprobante();    

    //Capturando Eventos
    $(document).on('ready',function(){
        
        var fila = '<tr>\n\
                        <td>\n\
                            <select class="form-control" id="tipo_venta" name="tipo_venta[]">\n\
                            <?PHP foreach ($tipo_item as $value) { ?>\n\
                                <option value="<?PHP echo $value['id']?>"><?PHP echo $value['tipo_item']?></option>\n\
                            <?PHP }?>\n\
                            </select>\n\
                        </td>\n\
                        <td class="col-sm-3"><textarea class="form-control descripcion" rows="1" id="descripcion" name="descripcion[]" required=""></textarea></td>\n\
                        <td><input type="text" id="cantidad" name="cantidad[]"  class="form-control cantidad" value="1" readonly="" onkeydown="return validNumericos(event)";></td>\n\
                        <td class="col-sm-2">\n\
                            <select class="form-control tipo_igv" id="tipo_igv" name="tipo_igv[]">\n\
                            <?PHP foreach ($tipo_igv as $value) { ?>'+                          
                                '<option value = "<?PHP echo $value['id'];?>"><?PHP echo $value['tipo_igv']?></option>\n\
                            <?PHP }?>\n\
                            </select>\n\
                        </td>\n\
                        <td><input type="text"  id="importe" name="importe[]"  class="form-control importe" required="" onkeydown="return validDecimals(event,this);"></td>\n\
                        <td><input type="text" id="subtotal" name="subtotal[]" class="form-control" value="0.00" readonly=""></td>\n\
                        <td><input type="text" id="igv" name="igv[]" class="form-control" value="0.00" readonly=""></td>\n\
                        <td><input type="text" id="total" name="total[]" class="form-control" value ="0.00" readonly=""></td>\n\
                        <td class="eliminar"><span class="glyphicon glyphicon-remove-circle"></span></td>\n\
                    </tr>';           
        
        //var fila = $("#tabla tbody tr:eq(0)").clone().removeClass('fila-base');
        $("#agrega").on('click', function(){                                    
            //$("#tabla tbody tr:eq()").clone().append('<td class="eliminar"><input class="a" type="button" value="-"/></td>').appendTo("#tabla");   
            //$("#tabla tbody tr:eq(0)").clone().removeClass('fila-base').appendTo("#tabla tbody");                                    
            $("#tabla tbody").append(fila);
                                                
            calcular();                                                                                                                                                   
     });        
        
         $(document).on("click",".eliminar",function(){
		var parent = $(this).parents().get(0);
		$(parent).remove();
                calcular();
	});
                     
    $('#tipo_de_detraccion').prop('disabled',true);
        
    // OPERACION GRATUITA
    $('#operacion_gratuita').on('change',function(){        
        operacion_gratuita();        
    });                                    
    //SERIE , NUMERO , CANTIDAD NUMERICOS
    $('#cantidad,#serie,#numero').on('keydown',function(e){
           validNumericos(e);
    });               
               
    // EVENTOS CALCULO - ITEMS                  
    $(document).on('keyup',"#importe,#cantidad",function(e){        
        var parent = $(this).parents().parents().get(0);        
        console.log(parent);    
        cmp.calcular(parent);
    });       
    $(document).on('change',"#tipo_igv",function(){
        var parent = $(this).parents().parents().get(0);
        cmp.calcular(parent);
    });
    
    $(document).on('change',"#tipo_venta",function(){
        var parent = $(this).parents().parents().get(0);
        tipoVenta(parent);
    });    
    
     // EVENTO NOTA DE CREDITO , DEBITO    
     
    var tipo_documento_id = '<?PHP echo $comprobante['tipo_documento_id'];?>';    
    comprobanteUpdate(tipo_documento_id);
    $('#tipo_documento').on('change',function(){        
        var selec = $('#tipo_documento option:selected').val();         
        comprobanteUpdate(selec);
    });    
     
    function comprobanteUpdate(param){        
            if(param > 3){                
                $('#mostrarDetraccion').css('display','none');
                $('#mostrarCompNota').css('display','block');                                
                if(param == 7){
                    $('#tipo_ncredito').prop('disabled',false);
                    $('#tipo_ndebito').prop('disabled',true);                 
                } else {
                    $('#tipo_ncredito').prop('disabled',true);
                    $('#tipo_ndebito').prop('disabled',false);                    
                }
            } else {                                   
                $('#mostrarDetraccion').css('display','block');
                $('#mostrarCompNota').css('display','none');
                calcular();
            }
    }    
    $('#comp_adjunto').combobox();        
});
</script>

<style type="text/css">
   .material-switch > input[type="checkbox"] {        
    display: none;  
    height: 0;
}
    .material-switch > label {
    cursor: pointer;
    height: 0px;
    position: relative; 
    width: 50px;  
}
    .material-switch > label::before {
    background: rgb(0, 0, 0);
    box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5);
    border-radius: 8px;
    content: '';
    height: 16px;
    margin-top: 25px;
    position:absolute;
    opacity: 0.3;
    transition: all 0.4s ease-in-out;
    width: 50px;
}
    .material-switch > label::after {
    background: rgb(255, 255, 255);
    border-radius: 16px;
    box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
    content: '';
    height: 24px;
    left: -4px;
    margin-top: 25px;
    position: absolute;
    top: -4px;
    transition: all 0.3s ease-in-out;
    width: 24px;
}
    .material-switch > input[type="checkbox"]:checked + label::before {
    background: inherit;
    opacity: 0.5;
}
    .material-switch > input[type="checkbox"]:checked + label::after {
    background: inherit;
    left: 30px;
}

    /* Agregando Inputs */
    .input-group {width: 100%;}
    .input-group-addon { min-width: 180px;text-align: right;}    
    
    /* Estilos Comprobante*/
    .clase_tahoma{
        /*font-family: Helvetica, Verdana, Segoe, sans-serif;
        //font-family: italic normal 400 16px/22px Arial, Verdana, Sans-serif;*/
        font-size: 13px;
    }    
    .panel-title{
        font-size: 13px;
        font-weight: bold;
    }    
    
    
    /* AGREGADO VALIDA */    
    .fila-base{
        display: none;        
    }    
    
        .ui-combobox {
            position: relative;
            display: inline-block;
          }
        .ui-combobox-toggle {
          position: absolute;
          top: 0;
          bottom: 0;
          margin-left: -1px;
          padding: 0;
          /* support: IE7 */
          *height: 1.7em;
          *top: 0.1em;
        }
        .ui-combobox-input {
          margin: 0;
          padding: 0.3em;
        }	                  
</style>
<div id="mensaje"></div>
<div class="container-fluid">
<form id="formComprobante" class="form-horizontal" role="form" action="<?PHP echo base_url()?>/index.php/comprobantes/modificar_comprobante/<?PHP echo $comprobante['comprobante_id'];?>" method="post">
    <div class="row">        
        <div class="col-md-12">
            <div style="text-align: center"><h3>COMPROBANTE DE PAGO</h3></div>
            <div style="text-align: left" id="mensaje"></div>            
            
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">COMPLETE DATOS DEL COMPROBANTE</div>                        
                </div>
                <div class="panel-body">                     
        <div class="form-group" style="padding-top:20px;">
            
            
        <div class="col-xs-4 col-md-4 col-lg-4">
            <label class="control-label">Cliente:</label>
            <input type="text" class="form-control" name="cliente" id="cliente" value="<?PHP echo $comprobante['razon_social'];?>">
            <div id="data_cli"><input type="hidden" name="cliente_id" id="cliente_id" value="<?PHP echo $comprobante['cliente_id']?>"></div>
        </div>
        
        <div class="col-xs-2 col-md-2 col-lg-2">
            <label class="control-label">Tipo Documento:</label>        
            <select class="form-control" name="tipo_documento" id="tipo_documento">
            <?PHP foreach ($tipo_documentos as $value) { 
                $selected = ($value['id'] == $comprobante['tipo_documento_id']) ? "SELECTED" : '';?>
                <option <?PHP echo $selected;?> value = "<?PHP echo $value['id'];?>"><?PHP echo $value['tipo_documento']?></option>
            <?PHP }?>    
            </select>    
        </div>    
        
        <div class="col-xs-1 col-md-1 col-lg-1">            
            <label class="control-label">Serie:</label>
            <input type="text" class="form-control" name="serie" id="serie" value="<?PHP echo $comprobante['serie'];?>" required="">            
        </div>
        
        <div class="col-xs-2 col-md-2 col-lg-2">
            <label class=" control-label">Numero:</label>
            <input type="text" class="form-control" name="numero" id="numero" value="<?PHP echo $comprobante['numero'];?>" required="">
        </div>
            
        <div class="col-xs-2 col-md-2 col-lg-2">
        <label class=" control-label">Fecha emision:</label>
        <input type="text" class="form-control" name="fecha_de_emision" id="fecha_de_emision" value="<?PHP echo $comprobante['fecha_de_emision'];?>" placeholder="Fecha Emision">
        </div>    
        
        <div class="col-xs-2 col-md-2 col-lg-2">
        <label class="control-label">Tipo de Moneda:</label>        
             <select class="form-control" name="moneda_id" id="moneda_id">
            <?PHP foreach ($monedas as $value) { 
                $selected = ($value['id'] == $comprobante['moneda_id']) ? "SELECTED" : '';?>
                <option <?PHP echo $selected;?> value="<?PHP echo $value['id'];?>"><?PHP echo $value['moneda']?></option>
            <?PHP }?>    
            </select>
        </div>       
        
        <div class="col-xs-2 col-md-2 col-lg-2">
        <label class="control-label">Tipo de Cambio:</label>        
            <input type="text" class="form-control" name="tipo_de_cambio" id="tipo_de_cambio" value="<?PHP echo $comprobante['tipo_de_cambio']?>">
        </div>
            
        <div class="col-xs-2 col-md-2 col-lg-2">
        <label class=" control-label">Fecha de Venc:</label>
        <input type="text" class="form-control" name="fecha_de_vencimiento" id="fecha_de_vencimiento" value="<?PHP echo $comprobante['fecha_de_vencimiento'];?>" placeholder="Fecha de Vencimiento">
        </div>
            
        <div class="col-xs-2 col-md-2 col-lg-2">
            <label class="control-label" style="margin-left:-50px">Venta Gratuita:</label>
            <div class="material-switch pull-left">
                 <?PHP $checked1 = ($comprobante['operacion_gratuita']==1) ? 'checked' : ''; ?>                                       
                <input <?PHP echo $checked1;?> id="operacion_gratuita" name="operacion_gratuita" type="checkbox" value="1">
                <label for="operacion_gratuita" class="label-primary"></label>
            </div>   
        </div>    
            
        <div class="col-xs-2 col-md-2 col-lg-2">
            <label class=" control-label" style="margin-left:-50px">Venta Cancelada:</label>
            <div class="material-switch pull-left">
                <?PHP $checked2 = ($comprobante['operacion_cancelada']==1) ? 'checked' : ''; ?>
                <input <?PHP echo $checked2;?> id="operacion_cancelada" name="operacion_cancelada" type="checkbox" value="1"/>
                <label for="operacion_cancelada" class="label-primary"></label>
            </div>
        </div>                           
    </div>  
            </div>        
            </div>
            
    <div class="row" style="padding-top:20px;">                
            <div class="col-lg-12">
                <div class="panel panel-info" >  
                    <div class="panel-heading">
                        <div class="panel-title">CONCEPTOS DEL COMPROBANTE</div>
                    </div>
                    <div class="panel-body">
                        
            <div class="form-group" id="valida">
                <div class="col-lg-12">                                                    
                <table id="tabla" class="table table-striped">
                    <thead>
                        <tr>
                            <th>T.Servicio</th>
                            <th>Descripcion</th>
                            <th>Cant.</th>
                            <th>Tipo Igv</th>
                            <th>Importe</th>
                            <th>SubTotal</th>
                            <th>Igv</th>
                            <th>Total</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    
                    <tbody>                                                      
                        <?PHP foreach ($items as $val) { ?>
                        <tr>
                            <input type="hidden" id="item_id" name="item_id[]" value="<?PHP echo $val['item_id'];?>"/>
                            <td><select class="form-control" id="tipo_venta" name="tipo_venta[]">
                                    <?PHP foreach ($tipo_item as $value) {
                                            $selected = ($value['id'] == $val['tipo_item_id']) ? "SELECTED" : '';?>
                                            <option <?PHP echo $selected;?> value="<?PHP echo $value['id'];?>"><?PHP echo $value['tipo_item'];?></option>
                                    <?PHP }?>                                    
                                </select></td>
                            <td class="col-sm-3"><textarea class="form-control descripcion" rows="1" id="descripcion" name="descripcion[]"><?PHP echo $val['descripcion'];?></textarea></td>
                            <td><input type="text" class="form-control cantidad" id="cantidad" name="cantidad[]" value="<?PHP echo $val['cantidad'];?>"/></td>
                            <td class="col-sm-2"><select class="form-control tipo_igv" id="tipo_igv" name="tipo_igv[]">
                                    <?PHP foreach ($tipo_igv as $value) {
                                            $selected = ($value['id'] == $val['tipo_igv_id']) ? "SELECTED" : '';?>
                                            <option <?PHP echo $selected;?> value="<?PHP echo $value['id'];?>"><?PHP echo $value['tipo_igv'];?></option>
                                    <?PHP }?>
                                </select></td>
                            <td><input type="text" class="form-control importe" id="importe" name="importe[]" value="<?PHP echo $val['importe']?>" onkeydown="return validDecimals(event,this);"/></td>
                            <td><input type="text" class="form-control" id="subtotal" name="subtotal[]" value="<?PHP echo $val['subtotal']?>" readonly=""/></td>
                            <td><input type="text" class="form-control" id="igv" name="igv[]" value="<?PHP echo $val['igv']?>" readonly=""/></td>
                            <td><input type="text" class="form-control" id="total" name="total[]" value="<?PHP echo $val['total']?>" readonly=""/></td>
                            
                            <!--<a class="azul" style="float:left; padding-left: 6px;" title="Eliminar" href="#" onclick="eliminar('<?PHP echo base_url() ?>','facturas','eliminar','<?PHP echo $value_factura['factura_id'] ?>','<?PHP echo $contrato['contrato_id'] ?>','<?PHP echo $cliente['id'] ?>','<?PHP echo $regreso ?>')"><img src="<?PHP echo base_url() . "images/mantenimiento/delete_factura.png" ?>"/></a>-->
                            <td><a title="eliminar" onclick ="eliminar('<?PHP echo base_url()?>','items','eliminar','<?PHP echo $val['item_id'];?>','<?PHP echo $comprobante['comprobante_id'];?>')"><span class="glyphicon glyphicon-remove-circle"></span></a></td>
                            <!--<td><a title="Modificar" href="<?PHP echo base_url()?>index.php/contratos/modificar/<?PHP echo $value['contrato_id'].'/'.$value['cliente_id'];?>"><img src="<?PHP echo base_url()."images/mantenimiento/update_25x25.png"?>"/></a></td>-->
                            
                        </tr>                                                 
                               <?PHP }?>
                    </tbody>
                </table>
                    <button type="button" id="agrega" class="btn btn-primary btn-sm">Agregar Item</button>
                </div>
            </div> 
                        
        <div id="mostrar"></div>
        <div id="uu"></div>
            </div></div>
            </div></div>
    </div>
    </div>
        <div class="row" style="padding-top:20px;">               
        <div class="col-xs-8 col-md-8 col-lg-8">
            <!-- MUESTRA DETRACCION , FACTURA O BOLETA -->
            <div id="mostrarDetraccion" style="display: block;">
                    <div class="panel panel-info" id="panelDetraccion">
                        <div class="panel-heading">
                        <div class="panel-title">DETRACCION</div>
                    </div>
                        <div class="panel-body">
                        <div class="form-group">
                <div class="col-xs-2 col-md-2 col-lg-2">
                <label class=" control-label" style="margin-left:-50px">Detraccion:</label>
                    <div class="material-switch pull-left">
                        <?PHP $checked3 = ($comprobante['detraccion']==1) ? 'checked' : ''; ?>
                        <input <?PHP echo $checked3;?> id="detraccion" name="detraccion" type="checkbox" value="1" onclick="javascript: return false;"/>
                <label for="detraccion" class="label-primary"></label>
                    </div>
                </div> 
                
                <div class="col-xs-3 col-md-3 col-lg-3">
            <label class="control-label">Tipo Detraccion:</label>        
            <select class="form-control" name="tipo_de_detraccion" id="tipo_de_detraccion">
            <?PHP foreach ($elemento_adicionales as $value) { 
                $selected = ($value['id'] == $comprobante['elemento_adicional_id']) ? "SELECTED" : '';?>
                <option <?PHP echo $selected;?> value = "<?PHP echo $value['id'];?>"><?PHP echo $value['descripcion']?></option>
            <?PHP }?>    
            </select>    
                </div>
                
                <div class="col-xs-2 col-md-2 col-lg-2 col-xs-offset-1">
                    <label class="control-label">% de Detraccion:</label>        
                    <input type="text" class="form-control" name="porcentaje_de_detraccion" id="porcentaje_de_detraccion" value="<?PHP echo $comprobante['porcentaje_de_detraccion'];?>" readonly>
                </div>
                
                <div class="col-xs-2 col-md-2 col-lg-2 col-xs-offset-1">
                    <label class="control-label">Total de Detraccion:</label>        
                    <input type="text" class="form-control" name="total_detraccion" id="total_detraccion" value="<?PHP echo $comprobante['total_detraccion'];?>" readonly>
                </div>
                                
            </div>
                    </div></div></div>            
             <!-- MOSTRAR NOTA DE CREDITO, NOTA DE DEBITO --> 
                      <div id="mostrarCompNota" style="display:none">
                          <div class="panel panel-info" id="panelDetraccion">
                          <div class="panel-heading">
                              <div class="panel-title">ADJUNTA A COMPROBANTE</div>
                          </div>
                          
                          <div class="panel-body" >
                              <div class="form-group">                                  
                                  
                                  <div class="col-xs-4 col-md-4 col-lg-4">
                                      <label class="control-label">Ducumento a Modificar</label>
                                      <select id ="comp_adjunto" name="comp_adjunto" style="width:300px">
                                          <?PHP foreach ($comp_adjuntos as $value) { 
                                                $selected = ($value['comprobante_id'] == $comprobante['com_adjunto_id']) ? 'SELECTED' : '';   ?>
                                          <option <?PHP echo $selected;?> value="<?PHP echo $value['comprobante_id']?>"><?PHP echo $value['abr'].'/ '.$value['serie'].'-'.$value['numero'];?></option>
                                          <?PHP }?>                                      
                                      </select>                                      
                                  </div>
                                  
                                  <div class="col-xs-4 col-md-4 col-lg-4">
                                      <label class="control-label">Tipo Nota de Crédito</label>
                                      <select class="form-control" id ="tipo_ncredito" name="tipo_ncredito">
                                          <?PHP foreach ($tipo_ncreditos as $value) { 
                                                $selected = ($value['id'] == $comprobante['tipo_nota_id']) ? 'SELECTED' : '';?>
                                                <option <?PHP echo $selected;?> value="<?PHP echo $value['id']?>"><?PHP echo $value['tipo_ncredito']?></option>
                                          <?PHP }?>
                                      </select>                                      
                                  </div>
                                   
                                   <div class="col-xs-4 col-md-4 col-lg-4">
                                      <label class="control-label">Tipo Nota de Débito</label>
                                      <select class="form-control" id ="tipo_ndebito" name="tipo_ndebito">                                          
                                          <?PHP foreach ($tipo_ndebitos as $value) { 
                                                $selected = ($value['id'] == $comprobante['tipo_nota_id']) ? 'SELECTED' : '';?>
                                                <option <?PHP echo $selected;?> value="<?PHP echo $value['id']?>"><?PHP echo $value['tipo_ndebito']?></option>
                                          <?PHP }?>
                                      </select>                                      
                                  </div>        
                              </div>                              
                               
                              
                          </div>                          
                      </div>                                                
                    </div>
            
            
            <div class="panel panel-info" >  
                    <div class="panel-heading">
                        <div class="panel-title">OBSERVACIONES</div>
                    </div>
                    <div class="panel-body">
                            <div class="form-group">
                        <div class="col-lg-12">
                    <label class="control-label">Observaciones:</label>
                    <textarea name="observaciones" id="observaciones" class="form-control" rows="1"><?PHP echo $comprobante['observaciones'];?></textarea>
                        </div>                        
                            </div>
                    </div>
            </div>
                            
                <div class="panel panel-info">                    
                    <div class="panel-heading">
                        <div class="panel-title">METODO DE PAGO</div>
                    </div>
                    <div class="panel-body">
                    <div class="form-group">
                        <div class="col-xs-2 col-md-2 col-lg-2 col-xs-offset-6">
                        <label class="control-label">Empresa:</label>                    
                        <select class="form-control" name="empresa" id="empresa">
                        <?PHP foreach ($empresas as $value) { 
                            $selected = ($value['id'] == $comprobante['empresa_id']) ? 'SELECTED': '';?>                          
                            <option <?PHP echo $selected;?> value="<?PHP echo $value['id'];?>"><?PHP echo $value['empresa']?></option>
                        <?PHP }?>    
                        </select>    
                        </div>
                        
                        <div class="col-xs-2 col-md-2 col-lg-2 col-xs-offset-1">
                        <label class="control-label">Tipo de Pago:</label>                    
                        <select class="form-control" name="tipo_pago" id="tipo_pago">
                        <?PHP foreach ($tipo_pagos as $value) {                          
                            $selected = ($value['id'] == $comprobante['tipo_pago_id']) ? 'SELECTED': '';?>                          
                            <option <?PHP echo $selected;?> value="<?PHP echo $value['id'];?>"><?PHP echo $value['tipo_pago']?></option>
                        <?PHP }?>    
                        </select>    
                        </div>     
                    </div>    
            </div> 
            
            </div>
        </div>        
        <div class="col-xs-4 col-md-4 col-lg-4">
    <div class="panel panel-default">
        <div class="panel panel-body">

            <div class="input-group">        
                <span class="input-group-addon">% Descuento Global:</span>                
                <input type="text" id="descuento_global" name="descuento_global" class="form-control">
            </div>

            <div class="input-group">        
                <span class="input-group-addon">Exonerada:</span>                
                <input type="text" id="total_exonerada" name="total_exonerada" class="form-control" value="<?PHP echo $comprobante['total_exonerada']?>" readonly="">
            </div>
    
            <div class="input-group">        
                <span class="input-group-addon">Inafecta:</span>                
                <input type="text" id="total_inafecta" name="total_inafecta" class="form-control" value="<?PHP echo $comprobante['total_inafecta']?>" readonly="">
            </div>
  
            <div class="input-group">        
                <span class="input-group-addon">Gravada:</span>                
                <input type="text" id="total_gravada" name="total_gravada" class="form-control" value="<?PHP echo $comprobante['total_gravada']?>" readonly="">
            </div>
            
            <div class="input-group">        
                <span class="input-group-addon">IGV:</span>                
                <input type="text" id="total_igv" name="total_igv" class="form-control" value="<?PHP echo $comprobante['total_igv']?>" readonly="">
            </div>
    
            <div class="input-group">        
                <span class="input-group-addon">Gratuita:</span>                
                <input type="text" id="total_gratuita" name="total_gratuita" class="form-control" value="<?PHP echo $comprobante['total_gratuita']?>" readonly="">
            </div>
   
            <div class="input-group">        
                <span class="input-group-addon">Otros Cargos:</span>                
                <input type="text" id="total_otros_cargos" name="total_otros_cargos" class="form-control">
            </div>
            
    
            <div class="input-group">        
                <span class="input-group-addon">Descuento Total:</span>                
                <input type="text" id="total_descuentos" name="total_descuentos" class="form-control" readonly="">
            </div>    
            <div class="input-group">                
                <span class="input-group-addon">Total:</span>                
                <input type="text" id="total_a_pagar" name="total_a_pagar" class="form-control" value="<?PHP echo $comprobante['total_a_pagar']?>" readonly="">
            </div>    
    
                </div></div>
                </div>                              
                
    <div class="input-group">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <input id="guardar" type="submit" class="btn btn-primary btn-lg btn-block" value="Actualizar Comprobante de Pago"/>
        </div>
    </div>        
            </form>
</div> 
</div>
       


