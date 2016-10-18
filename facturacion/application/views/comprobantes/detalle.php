
<div class="container-fluid">
    <br>   
    <div class="row">
            <div class="col-xs-6 col-lg-2">
        <?PHP if($comprobante['empresa_id'] == 1){?>
        <img src ="<?PHP echo base_url().'images/TYTL optimo12.png'?>"/>
        <?PHP } ?>
        <?PHP if($comprobante['empresa_id'] == 2){?>
        <img src ="<?PHP echo base_url().'images/asesorandina.png'?>"/>
        <?PHP } ?>
            </div>
        
        <div class="col-xs-6 col-lg-2">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <label class="control-label"><?PHP echo 'RUC: '.$comprobante['ruc']?></label>
                </div>
                <div class="panel-body text-center">
                    <div class="control-label">COMPROBANTE ELECTRONICO</div><br>
                    <div class="control-label"><?PHP echo 'S|  '.$comprobante['serie'].' - N|  '.$comprobante['numero']?></div>                                        
                </div>
            </div>
                    
            </div>                    
    </div>
    <div class="row">        
        <div class="col-lg-12">
        <table class="table table-striped">
            <tr><td class="col-xs-2">Fecha Emisión:</td>
                <td><?PHP echo $comprobante['fecha_de_emision']?></td>
                <td class="col-xs-2">Tipo Documento:</td>
                <td><?PHP echo $comprobante['tipo_documento']?></td>
            </tr>
            <tr><td class="col-xs-2">Razon Social:</td>
                <td class="col-xs-6 text-center"><?PHP echo $comprobante['razon_social']?></td>
                
            </tr>            
            <tr><td class="col-xs-2">Direccion:</td>
                <td class="text-center" colspan="3"><?PHP echo $comprobante['domicilio1']?></td>
            </tr>            
        </table>    
            </div>        
    </div>
    
    
    <div class="row">
        <div class="col-lg-12">
    <table class="table table-striped">
        <tr>
            <td>Descripcion</td>
            <td>Cantidad</td>
            <td>Importe</td>
            <td>Subtotal</td>
            <td>Igv</td>
            <td>Total</td>            
        </tr>
        
        <?PHP foreach ($items as $value) { ?>                    
        <tr>
            <td><?PHP echo $value['descripcion']?></td>
            <td><?PHP echo $value['cantidad']?></td>
            <td><?PHP echo $value['importe']?></td>
            <td><?PHP echo $value['subtotal']?></td>
            <td><?PHP echo $value['igv']?></td>
            <td><?PHP echo $value['total']?></td>
        </tr>                
        <?PHP }?>
    </table>
    </div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-12">
        <table class="table table-striped">
            <tbody>
            <tr>                
                <td class="col-xs-4 col-xs-offset-4 text-right">Total IGV:</td>                
                <td class="col-xs-1 text-center"><?PHP echo $comprobante['total_igv']?></td>                
            </tr>
            <tr>
                <td class="text-right">Total a Pagar:</td>
                <td class="text-center"><?PHP echo $comprobante['total_a_pagar']?></td>                
            </tr>
            
            </tbody>
        </table>                
    </div>
    </div>    
    
    
    <div class="row">
       <div class="col-xs-12 col-lg-2">
        <?PHP if($comprobante['detraccion'] == 1){?>
           <table class="table table-striped">               
               <tr>
                   <td class="text-center" colspan="6">Comprobante Sujeto a Detraccion </td>
               </tr>
               <tr>
                   <td>Tipo</td>
                   <td><?PHP echo $comprobante['elemento_adicional_descripcion']?></td>
                   <td>%</td>
                   <td><?PHP echo $comprobante['porcentaje_de_detraccion'];?></td>
                   <td>Total Detraccion:</td>
                   <td><?PHP echo $comprobante['total_detraccion'];?></td>
               </tr>
               
           </table>
        <?PHP } ?>        
    </div>
    
</div>
    
    <div class="row">
       <div class="col-xs-12 col-lg-2">
        <?PHP if($comprobante['tipo_documento_id'] > 3){?>
           <table class="table table-striped text-center">               
               <tr>
                   <td class="text-center" colspan="6">Comprobante Adjunto</td>
               </tr>
               <tr>
                   <td>Tipo N.</td>
        <?PHP if($comprobante['tipo_documento_id'] == 7){?>
                   <td><?PHP echo $tipo_nota['tipo_ncredito'];?></td>
        <?PHP }?>
        <?PHP if($comprobante['tipo_documento_id'] == 8){?>
                   <td><?PHP echo $tipo_nota['tipo_ndebito'];?></td>                   
        <?PHP }?>
                   <td><?PHP echo $comp_adjunto['abr'].' / '.$comp_adjunto['serie'].' - '.$comp_adjunto['numero'];?></td>
                   <td>&nbsp;</td>
                   <td>&nbsp;</td>
               </tr>               
           </table>
        <?PHP } ?>        
    </div>
    
</div>



