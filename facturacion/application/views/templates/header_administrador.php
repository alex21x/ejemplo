<!DOCTYPE HTML>
<html lang="en">
    <head>
        <title>SISTEMA GENERAL GRUPO TYTL</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">        
        <link rel="stylesheet" href="<?PHP echo base_url();?>assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?PHP echo base_url();?>assets/css/themes-smoothness-jquery-ui.css">         
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>    
        <script src="<?PHP echo base_url(); ?>assets/js/jquery-ui-1.11.0.js"></script> 
        
    </head>
    <body>

        <div class="container">
            <!-- Example row of columns -->
            <div class="row">                
                <div class="col-xs-12">
                    <nav class="navbar navbar-default" role="navigation">
                        <div class="container-fluid">
                            <!-- Brand and toggle get grouped for better mobile display -->
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                                    <span class="sr-only">Sistema de Abogados</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div>
                            <!-- Collect the nav links, forms, and other content for toggling -->
                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                <ul class="nav navbar-nav">
                                    <img src="<?PHP echo base_url() . $this->session->userdata('ruta_foto'); ?>" title="<?PHP echo $this->session->userdata('title');?>" height="60" width="60">
                                </ul>
                                <ul class="nav navbar-nav">       
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Clientes<span class="caret"></span></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="<?PHP echo base_url(); ?>index.php/clientes/index">Clientes</a></li>                                            
                                        </ul>
                                    </li>  
                                    
                                    
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Comprobante de Pago<span class="caret"></span></a>                                                                               
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="<?PHP echo base_url(); ?>index.php/comprobantes/index">Lista de Comprobantes</a></li>
                                            <li><a href="<?PHP echo base_url(); ?>index.php/comprobantes/nuevo">Nuevo</a></li>                                            
                                        </ul>
                                    </li>                                    
                                    <?PHP
                                    if($this->session->userdata('grande')==1){?>
                                    <li><a href="<?PHP echo base_url(); ?>index.php/acceso/menu_principal">Menu</a></li>
                                    <?PHP
                                    }
                                    ?>
                                    <li><a href="<?PHP echo base_url(); ?>index.php/acceso/logout">Cerrar Sesión</a></li>
                                </ul>
                                <ul class="nav navbar-nav navbar-right">                                    
                                    <img src="<?PHP echo base_url().'/images/grupo-TYTL-2-01_4.png'?>">
                                    <?PHP
                                    $nombre = (strpos($this->session->userdata('usuario'), ' ') != '')?substr($this->session->userdata('usuario'), 0,  strpos($this->session->userdata('usuario'), ' ')):$this->session->userdata('usuario');
                                    ?>
                                    <li><strong>Sesión:</strong><?PHP echo " ".$this->session->userdata('tipo_empleado'); ?><?PHP echo "&nbsp;&nbsp;&nbsp;<br>".$nombre.", ".$this->session->userdata('apellido_paterno'); ?>&nbsp;&nbsp;&nbsp;</li>
                                </ul>
                            </div><!-- /.navbar-collapse -->                
                        </div><!-- /.container-fluid -->            
                    </nav>

                </div>                
            </div>
        </div>        