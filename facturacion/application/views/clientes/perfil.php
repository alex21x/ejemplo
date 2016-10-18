<style>
    .titulo_27{
        font-size: 27px;
    }    
    
    .titulo_23{
        font-size: 23px;
    }

    .titulo_21{
        font-size: 23px;
    }
</style>
<div align="center"><span class="titulo_27">Cliente:&nbsp;<?PHP echo $cliente['razon_social'];?></span></div>

<div class="container">
    <div class="titulo_21">Perfil</div>
    <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-md-8">
            <table class="table table-striped">
                
                <?PHP if($cliente['tipo_cliente_id']== '1'){ ?>
                <tr><td>Dni:</td><?PHP } else {?>
                <tr><td>Ruc:</td>    
                <?PHP } ?>    
                <td><?PHP echo $cliente['ruc'];?></td></tr>                
                <?PHP if($cliente['tipo_cliente_id']== '1'){ ?>
                <tr><td>Apellidos:</td><?PHP } else {?>
                <tr><td>Razon Social:</td>    
                <?PHP } ?>                    
                <td><?PHP echo $cliente['razon_social'];?></td></tr>
                                                                
                <?PHP if($cliente['tipo_cliente_id']== '1'){ ?>
                <tr><td>Nombres:</td><td><?PHP echo $cliente['nombres'];?></td></tr>                    
                <?PHP } ?>                                                    
                
                <tr><td>Abogado Attache:</td><td><?PHP if(isset($abogado)){ echo $abogado['apellido_paterno'].' '.$abogado['apellido_materno'].', '.$abogado['nombre']; }?></td></tr>
                <tr><td>Domicilio 1:</td><td><?PHP echo $cliente['domicilio1'];?></td></tr>
                <tr><td>Domicilio 2:</td><td><?PHP echo $cliente['domicilio2'];?></td></tr>
                <tr><td>Email:</td><td><?PHP echo $cliente['email'];?></td></tr>
                <tr><td>Página Web:</td><td><?PHP echo $cliente['pagina_web'];?></td></tr>
                <tr><td>Teléfono Fijo 1:</td><td><?PHP echo $cliente['telefono_fijo_1'];?></td></tr>
                <tr><td>Teléfono Fijo 2:</td><td><?PHP echo $cliente['telefono_fijo_2'];?></td></tr>
                <tr><td>Teléfono Movil 1:</td><td><?PHP echo $cliente['telefono_movil_1'];?></td></tr>
                <tr><td>Teléfono Movil 2:</td><td><?PHP echo $cliente['telefono_movil_2'];?></td></tr>
                <tr><td>Empresa:</td><td><?PHP if(isset($empresa['empresa'])){ echo $empresa['empresa'];}?></td></tr>
                <tr><td>Estado:</td><td><?PHP echo $cliente['activo'] ?></td></tr>
            </table>
        </div>
        <div class="col-md-2">
        </div>
    </div>
</div>