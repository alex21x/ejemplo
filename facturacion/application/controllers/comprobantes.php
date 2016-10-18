<?PHP

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Comprobantes extends CI_Controller {

    public function __construct() {
        parent::__construct();        

        date_default_timezone_set('America/Lima');                
        $this->load->model('comprobantes_model');
        $this->load->model('items_model');
        //$this->load->model('igv_model');
        $this->load->model('tipo_igv_model');
        $this->load->model('elemento_adicionales_model');        
        $this->load->model('tipo_documentos_model');
        $this->load->model('tipo_pagos_model');
        $this->load->model('tipo_items_model');
        $this->load->model('tipo_ncreditos_model');
        $this->load->model('tipo_ndebitos_model');
        //$this->load->model('activos_model');
        $this->load->model('accesos_model');
        $this->load->model('clientes_model');
        $this->load->model('monedas_model');
        $this->load->model('empleados_model');        
        $this->load->model('empresas_model');        

        $empleado_id = $this->session->userdata('empleado_id');
        if (empty($empleado_id)) {
            $this->session->set_flashdata('mensaje', 'No existe sesion activa');
            redirect(base_url());
        }
    }

    public function index() {   
                
        $data['tipo_documentos'] = $this->tipo_documentos_model->select();
        
        $data['cliente_select'] = $this->input->post('cliente');
        $data['cliente_select_id'] = $this->input->post('cliente_id');
        $data['serie_select']  = $this->input->post('serie');
        $data['numero_select'] = $this->input->post('numero');
        
        $cliente_id = '';
        if(($this->input->post('cliente_id') != '') && ($this->input->post('cliente') != ''))
            $cliente_id = $this->input->post('cliente_id');
        
        $tipo_documento_id = '';
        if($this->input->post('tipo_documento') != '')
            $tipo_documento_id = $this->input->post('tipo_documento');
        
        $serie = '';
        if($this->input->post('serie') != '')
            $serie = $this->input->post('serie');
        
        $numero = '';
        if($this->input->post('numero') != '')
            $numero = $this->input->post('numero');
        
        $fecha_de_emision = '' ;
        if(!empty($this->input->post('fecha_de_emision'))){
            $date = new DateTime($this->input->post('fecha_de_emision'));
            $fecha_de_emision = "'".$date->format('Y-m-d')."'";
        } 
        
        $fecha_de_vencimiento = '';
        if(!empty($this->input->post('fecha_de_vencimiento'))){
            $date = new DateTime($fecha_de_vencimiento);
            $fecha_de_vencimiento = "'".$date->format('Y-m-d')."'";
        }                             
                
        $data['comprobantes'] = $this->comprobantes_model->select('',$serie, $numero,$fecha_de_emision,$fecha_de_vencimiento,$cliente_id,$tipo_documento_id);
        
        $this->accesos_model->menuGeneral();
        $this->load->view('comprobantes/index',$data);
        $this->load->view('templates/footer');
    }            
    
    public function nuevo() {          
        $data['tipo_documentos'] = $this->tipo_documentos_model->select();
        $data['tipo_pagos'] = $this->tipo_pagos_model->select();
        $data['tipo_item']  = $this->tipo_items_model->select();
        $data['tipo_igv']   = $this->tipo_igv_model->select('','','',0);
        $data['tipo_ncreditos']  = $this->tipo_ncreditos_model->select('','','',0);
        $data['tipo_ndebitos']   = $this->tipo_ndebitos_model->select('','','',0);
        $data['elemento_adicionales'] = $this->elemento_adicionales_model->select();
        $data['monedas']       = $this->monedas_model->select();
        $data['empresas']      = $this->empresas_model->select();        
        $data['comp_adjuntos'] = $this->comprobantes_model->select('','','','','','','','0');
        
        
        //var_dump($data['tipo_item']);
        
        $this->accesos_model->menuGeneral();
        $this->load->view('comprobantes/nuevo',$data);
        $this->load->view('templates/footer');
    }    
   

    public function modificar() {                                        
        $data['comprobante'] = $this->comprobantes_model->select($this->uri->segment(3));        
        $data['items'] = $this->items_model->select('',$this->uri->segment(3));
        
        $data['tipo_documentos'] = $this->tipo_documentos_model->select();
        $data['tipo_pagos']      = $this->tipo_pagos_model->select();                                
        $data['tipo_item']       = $this->tipo_items_model->select();
        $data['tipo_igv']        = $this->tipo_igv_model->select('','','',0);
        $data['tipo_ncreditos']  = $this->tipo_ncreditos_model->select('','','',0);
        $data['tipo_ndebitos']   = $this->tipo_ndebitos_model->select('','','',0);
        $data['elemento_adicionales'] = $this->elemento_adicionales_model->select();
        $data['monedas']       = $this->monedas_model->select();
        $data['empresas']      = $this->empresas_model->select();
        $data['comp_adjuntos'] = $this->comprobantes_model->select('','','','','','','','0');
        
        
        $this->accesos_model->menuGeneral();
        $this->load->view('comprobantes/modificar', $data);
        $this->load->view('templates/footer');
    }   
    
    public function eliminar() {        
        
    }                   
    
    public function detalle() {        
        $this->load->library('numletras');
                
        $comprobante_id = $this->uri->segment(3);        
        
        $data['comprobante'] = $this->comprobantes_model->select($comprobante_id);
        $data['items'] = $this->items_model->select('',$comprobante_id);
                        
        $tipo_documento_id = $data['comprobante']['tipo_documento_id'];
        //var_dump($data['comprobante']['tipo_nota_id']);exit;
        if($tipo_documento_id > 3){            
            if($tipo_documento_id == 7)
                $data['tipo_nota']     = $this->tipo_ncreditos_model->select($data['comprobante']['tipo_nota_id']);
            if($tipo_documento_id == 8)
                $data['tipo_nota']     = $this->tipo_ndebitos_model->select($data['comprobante']['tipo_nota_id']);
                $data['comp_adjunto']  = $this->comprobantes_model->select($data['comprobante']['com_adjunto_id']);
        }
        
        $this->load->view('templates/header_sin_menu');
        $this->load->view('comprobantes/detalle',$data);
        $this->load->view('templates/footer');
    }        
            
    public function pdfGeneraComprobante($comprobante_id = '',$cliente_id = '') {
        
        $comprobante = $this->comprobantes_model->select($comprobante_id);
        $items       = $this->items_model->select('',$comprobante_id);
        $cliente     = $this->clientes_model->select($cliente_id);
        $empresa     = $this->empresas_model->select($comprobante['empresa_id']);
        
        require_once (APPPATH .'libraries/fpdf17/fpdf.php');
        
        $pdf = new FPDF();
        $pdf->AddPage();
        
        
        $pdf->SetFont('Arial','B',10);
        
        //Cabecera 1
        $leftCabecera = 140;        
        $pdf->RoundedRect($leftCabecera, 25, 60, 10, 2, '12', '');
        $pdf->SetXY($leftCabecera,25);$pdf->CellFitSpace(60, 10, "R.U.C: ".$empresa['ruc'],0, 1,'C');          
        $pdf->SetX($leftCabecera);$pdf->Cell(60,10,'COMPROBANTE',1,1,'C');        
        $pdf->RoundedRect($leftCabecera, 45, 60, 10, 3, '34', '');        
        $pdf->SetX($leftCabecera);$pdf->CellFitSpace(60, 10, "| ".$comprobante['serie'].' - ' .$comprobante['numero'],0,1,"C");
        
        //Cabecera 2
                
        $topCabecera = 50;        
        $pdf->SetXY(10, $topCabecera);$pdf->Cell(20,10,'Fecha :',0,0);
        $pdf->Cell(40,10,'Fecha',0,1);
        $pdf->Cell(20,10,  utf8_decode('Señor(es): '),0,0);
        $pdf->Cell(20,10,  utf8_decode($cliente['razon_social']),0,1);
        $pdf->Cell(20,10,'Direccion: ',0,0);
        $pdf->MultiCell(170, 10, utf8_decode($cliente['domicilio1']),0,1);
                
        //Cuerpo
        
        $topCuerpo = 60;       
        $pdf->SetXY(160,$topCuerpo);$pdf->Cell(60,10,'R.U.C :'.$cliente['ruc'],0,1);
        
            // Salto de Linea
        $pdf->Ln(2);
                
        $topCuerpo = 90;                        
        $pdf->SetXY(10, $topCuerpo);$pdf->RoundedRect(10, $topCuerpo ,10, 10, 2,'1','');        
        $pdf->Cell(10, 10, '--', 0, 0,'C');        
        $pdf->Cell(140,10,'DESCRIPCION',1,0,'C');        
        $pdf->RoundedRect(160, $topCuerpo, 40, 10, 2, '2','');
        $pdf->CellFitSpace(40, 10, 'IMPORTE', 0,1,'C');        
        
        
        $topCuerpo = 100;
                        
        foreach ($items as $value) {                    
        $pdf->SetXY(10, $topCuerpo);$pdf->Cell(10, 50, '--', 'LR', 0, 'C');   
        $pdf->MultiCell(140, 50, utf8_decode($value['descripcion']), 0, 'C', false);        
        $pdf->SetXY(160, $topCuerpo);$pdf->Cell(40,50,$value['descripcion'],'LR',1,'C');        
        $topCuerpo += 20;
        }
        
        
        //Pie de Página
        
        $topPie = $topCuerpo+30;
        
        $pdf->SetXY(10, $topPie);$pdf->RoundedRect(10, $topPie, 10, 10, 3, '4');
        $pdf->Cell(10,10, '--',0,0,'C');
        $pdf->Cell(140, 10, 'IMPORTE', 1, 0, 'C');
        $pdf->Cell(40, 10, '',1,1,'C');
                
                                                                                                        
        $pdf->Output();
    }
    
    
    
    
    public function buscador_cliente() {
        $abogado = $this->input->get('term');
        echo json_encode($this->clientes_model->selectAutocomplete($abogado, 'activo'));
    }
    
    public function guardar_comprobante(){                                                
        // Recibir Datos mediante Ajax
        //$comprobante = json_decode(stripslashes($_POST['comprobante']),true);
        //$items = json_decode(stripslashes($_POST['items']));
        //var_dump($comprobante);        
        //var_dump($comprobante);exit;
        
        $fecha_de_emision = new DateTime($_POST['fecha_de_emision']);
        $fecha_de_emision = $fecha_de_emision->format('Y-m-d');
        
        $fecha_de_vencimiento = new DateTime($_POST['fecha_de_vencimiento']);
        $fecha_de_vencimiento = $fecha_de_vencimiento->format('Y-m-d');                
        $operacion_gratuita  = isset($_POST['operacion_gratuita']) ? 1 : 0;
        $operacion_cancelada = isset($_POST['operacion_cancelada']) ? 1 : 0;                                  
                    
        $comprobante = array (          
            'cliente_id'           => $_POST['cliente_id'],
            'tipo_documento_id'    => $_POST['tipo_documento'],
            'serie'                => $_POST['serie'],
            'numero'               => $_POST['numero'],
            'fecha_de_emision'     => $fecha_de_emision,
            'moneda_id'            => $_POST['moneda_id'],
            'tipo_de_cambio'       => $_POST['tipo_de_cambio'],
            'fecha_de_vencimiento' => $fecha_de_vencimiento,
            'operacion_gratuita'   => $operacion_gratuita,
            'operacion_cancelada'  => $operacion_cancelada,            
            'observaciones'        => $_POST['observaciones'],            
            'empresa_id'           => $_POST['empresa'],
            'tipo_pago_id'         => $_POST['tipo_pago'],
                                    
            'descuento_global'   => $_POST['descuento_global'],
            'total_exonerada'    => $_POST['total_exonerada'],
            'total_inafecta'     => $_POST['total_inafecta'],
            'total_gravada'      => $_POST['total_gravada'],
            'total_igv'          => $_POST['total_igv'],
            'total_gratuita'     => $_POST['total_gratuita'],
            'total_otros_cargos' => $_POST['total_otros_cargos'],
            'total_descuentos'   => $_POST['total_descuentos'],
            'total_a_pagar'      => $_POST['total_a_pagar']                                                            
        );                        
        
        if($_POST['tipo_documento']== 1 || $_POST['tipo_documento'] == 3){
            $detraccion = isset($_POST['detraccion']) ? 1 : 0;
                $comprobante = array_merge ($comprobante,array('detraccion' => $detraccion));
            if($this->input->post('tipo_de_detraccion') != '')
                $comprobante = array_merge ($comprobante,array('elemento_adicional_id' => $this->input->post('tipo_de_detraccion')));
            if($this->input->post('porcentaje_de_detraccion') != '')
                $comprobante = array_merge ($comprobante,array('porcentaje_de_detraccion' => $this->input->post('porcentaje_de_detraccion')));
            if($this->input->post('total_detraccion') != '')
                $comprobante = array_merge ($comprobante,array('total_detraccion' => $this->input->post('total_detraccion')));
        }                            
        else{
            if ($_POST['tipo_documento'] == 7 ){                
                if($this->input->post('tipo_ncredito') != '')
                $comprobante = array_merge ($comprobante,array('tipo_nota_id' => $this->input->post('tipo_ncredito')));
            }    
            if ($_POST['tipo_documento'] == 8){
                if($this->input->post('tipo_ndebito') != '')
                $comprobante = array_merge ($comprobante,array('tipo_nota_id' => $this->input->post('tipo_ndebito')));
            }                       
            if($this->input->post('comp_adjunto') != '')
                $comprobante = array_merge ($comprobante,array('com_adjunto_id' => $this->input->post('comp_adjunto')));
        }
       
        //var_dump($comprobante);exit;
                                
        // Insertar datos del documento
        $comprobante_id = $this->comprobantes_model->insertar($comprobante);                                
        // GUARDANDO ITEMS
        
        $tipo_item_id  = $_POST['tipo_venta'];
        $descripcion   = $_POST['descripcion'];
        $cantidad      = $_POST['cantidad'];
        $tipo_igv_id   = $_POST['tipo_igv'];
        $importe       = $_POST['importe'];
        $subtotal      = $_POST['subtotal'];        
        $total         = $_POST['total'];
        $igv           = $_POST['igv'];
        
        
        $i = 0;
        foreach($tipo_item_id as $item) {
            $consulta = "INSERT INTO items (comprobante_id, tipo_item_id, descripcion, cantidad, tipo_igv_id, importe, subtotal, igv, total) VALUES ('".$comprobante_id."', '".$tipo_item_id[$i]."' , '".$descripcion[$i]."' , '".$cantidad[$i]."' , '".$tipo_igv_id[$i]."' , '".$importe[$i]."' , '".$subtotal[$i]."' , '".$igv[$i]."' , '".$total[$i]."')";            
            //echo $consulta;
            $i++; 
            //$resultado = mysql_query($consulta, $conexion);
            $resultado = $this->db->query($consulta);
        }   
        
        redirect(base_url() . "index.php/comprobantes/index");
        
        // Insertar Items        
//        foreach($items as $d){                                         
//            $array = array_merge(get_object_vars ($d), array('comprobante_id' => $comprobante_id));
//            $this->items_model->insertar($array);
//        }
        
        echo json_encode($comprobante_id);                
    }
    
    
    public function modificar_comprobante() {
        
        $fecha_de_emision = new DateTime($_POST['fecha_de_emision']);
        $fecha_de_emision = $fecha_de_emision->format('Y-m-d');
        
        $fecha_de_vencimiento = new DateTime($_POST['fecha_de_vencimiento']);
        $fecha_de_vencimiento = $fecha_de_vencimiento->format('Y-m-d');
        
        
        $operacion_gratuita  = isset($_POST['operacion_gratuita']) ? 1 : 0;
        $operacion_cancelada = isset($_POST['operacion_cancelada']) ? 1 : 0;        
                    
        $comprobante = array (          
            'cliente_id' => $_POST['cliente_id'],
            'tipo_documento_id' => $_POST['tipo_documento'],
            'serie'  => $_POST['serie'],
            'numero' => $_POST['numero'],
            'fecha_de_emision' => $fecha_de_emision,
            'moneda_id'        => $_POST['moneda_id'],
            'tipo_de_cambio'  => $_POST['tipo_de_cambio'],
            'fecha_de_vencimiento' => $fecha_de_vencimiento,
            'operacion_gratuita'   => $operacion_gratuita,
            'operacion_cancelada'  => $operacion_cancelada,            
            'observaciones'    => $_POST['observaciones'],            
            'empresa_id'       => $_POST['empresa'],
            'tipo_pago_id'     => $_POST['tipo_pago'],
            
            'descuento_global'  => $_POST['descuento_global'],
            'total_exonerada'   => $_POST['total_exonerada'],
            'total_inafecta'    => $_POST['total_inafecta'],
            'total_gravada'     => $_POST['total_gravada'],
            'total_igv'         => $_POST['total_igv'],
            'total_gratuita'    => $_POST['total_gratuita'],
            'total_otros_cargos'=> $_POST['total_otros_cargos'],
            'total_descuentos'  => $_POST['total_descuentos'],
            'total_a_pagar'     => $_POST['total_a_pagar']                                                            
        );
        
        
        if($_POST['tipo_documento']== 1 || $_POST['tipo_documento'] == 3){
            $detraccion = isset($_POST['detraccion']) ? 1 : 0;
                $comprobante = array_merge ($comprobante,array('detraccion' => $detraccion));
            if($this->input->post('tipo_de_detraccion') != '')
                $comprobante = array_merge ($comprobante,array('elemento_adicional_id' => $this->input->post('tipo_de_detraccion')));
            if($this->input->post('porcentaje_de_detraccion') != '')
                $comprobante = array_merge ($comprobante,array('porcentaje_de_detraccion' => $this->input->post('porcentaje_de_detraccion')));
            if($this->input->post('total_detraccion') != '')
                $comprobante = array_merge ($comprobante,array('total_detraccion' => $this->input->post('total_detraccion')));
            
            
            $comprobante = array_merge($comprobante, array('tipo_nota_id' => NULL));
            $comprobante = array_merge($comprobante, array('com_adjunto_id'   => NULL));
        }        
        
        else{
            if ($_POST['tipo_documento'] == 7 ){                
                if($this->input->post('tipo_ncredito') != '')
                $comprobante = array_merge ($comprobante,array('tipo_nota_id' => $this->input->post('tipo_ncredito')));
            }    
            if ($_POST['tipo_documento'] == 8){
                if($this->input->post('tipo_ndebito') != '')
                $comprobante = array_merge ($comprobante,array('tipo_nota_id' => $this->input->post('tipo_ndebito')));
            }                       
            if($this->input->post('comp_adjunto') != '')
                $comprobante = array_merge ($comprobante,array('com_adjunto_id' => $this->input->post('comp_adjunto')));
                                            
                $comprobante = array_merge($comprobante, array('detraccion' => NULL));
                $comprobante = array_merge($comprobante, array('elemento_adicional_id'    => NULL));
                $comprobante = array_merge($comprobante, array('porcentaje_de_detraccion' => NULL));
                $comprobante = array_merge($comprobante, array('total_detraccion' => NULL));
        }                           
        
        $comprobante_id = $this->uri->segment(3);  
        $this->comprobantes_model->modificar($comprobante,$comprobante_id);
        
        
        $item_id       = $_POST['item_id'];
        $tipo_item_id  = $_POST['tipo_venta'];
        $descripcion   = $_POST['descripcion'];
        $cantidad      = $_POST['cantidad'];
        $tipo_igv_id   = $_POST['tipo_igv'];
        $importe       = $_POST['importe'];
        $subtotal      = $_POST['subtotal'];
        $total         = $_POST['total'];
        $igv           = $_POST['igv'];
                
        $i = 0;
        foreach($tipo_item_id as $item) {
            if(!isset($item_id[$i])){
                $consulta = "INSERT INTO items (comprobante_id, tipo_item_id, descripcion, cantidad, tipo_igv_id, importe, subtotal, igv, total) VALUES ('".$comprobante_id."', '".$tipo_item_id[$i]."' , '".$descripcion[$i]."' , '".$cantidad[$i]."' , '".$tipo_igv_id[$i]."' , '".$importe[$i]."' , '".$subtotal[$i]."' , '".$igv[$i]."' , '".$total[$i]."')";
                $resultado = $this->db->query($consulta);
            } else {
                $consulta = "UPDATE items SET tipo_item_id ='".$tipo_item_id[$i]."',descripcion ='".$descripcion[$i]."', cantidad ='".$cantidad[$i]."', tipo_igv_id='".$tipo_igv_id[$i]."',importe='".$importe[$i]."', subtotal='".$subtotal[$i]."', igv='".$igv[$i]."', total='".$total[$i]."' WHERE id ='".$item_id[$i]."'";
                $resultado = $this->db->query($consulta);
            }                     
            $i++;
        }                                   
        redirect(base_url() . "index.php/comprobantes/index");
    }
        
    public function txt($comprobante_id = ''){        
        
        $data = $this->clientes_model->select();
        $comprobante = $this->comprobantes_model->select($comprobante_id);
        $items       = $this->items_model->select('',$comprobante_id);
        $detraccion  = $this->elemento_adicionales_model->select();
        
        

        if($comprobante['tipo_documento_id'] < 4){
        
        // FACTURA , BOLETA                
        $f = fopen('D:/data0/facturador/DATA/'.$comprobante['ruc'].'-'.$comprobante['codigo'].'-'.$comprobante['serie'].'-'.$comprobante['numero'].'.CAB','w');
                 $linea = "|".$comprobante['fecha_de_emision'].'||'.$comprobante['tipo_cliente_codigo']."|".$comprobante['ruc']."|".$comprobante['razon_social']."|".$comprobante['abrstandar']."||||".$comprobante['total_gravada']."|".$comprobante['total_inafecta']."|".$comprobante['total_exonerada']."||||".$comprobante['total_a_pagar']."\r\n";
                 fwrite($f, $linea);
                 fclose($f);
                 
        $f = fopen('D:/data0/facturador/DATA/'.$comprobante['ruc'].'-'.$comprobante['codigo'].'-'.$comprobante['serie'].'-'.$comprobante['numero'].'.DET','w');
            foreach ($items as $value) {
                 $linea = "NIU"."|".$value['cantidad']."|||".$value['descripcion']."|".$value['cantidad']."||".$value['igv']."|".$value['tipo_igv_id']."|||".$value['importe']."|".$value['total']."\r\n";
                 fwrite($f, $linea);
            }
                 fclose($f);
        }
        
        else {
        // NOTA DE CREDITO , DEBITO
            $nota = $this->comprobantes_model->select($comprobante['com_adjunto_id']);           
            $f = fopen('D:/data0/facturador/DATA/'.$comprobante['ruc'].'-'.$comprobante['codigo'].'-'.$comprobante['serie'].'-'.$comprobante['numero'].'.NOT','w');
                 $linea = $comprobante['fecha_de_emision']."|".$comprobante['tipo_nota_id']."|descripcion|".$nota['serie']."-".$nota['numero']."|".$comprobante['tipo_cliente_codigo']."|".$comprobante['ruc']."|".$comprobante['razon_social']."|".$comprobante['abrstandar']."||".$comprobante['total_gravada']."|".$comprobante['total_inafecta']."|".$comprobante['total_exonerada']."||||".$comprobante['total_a_pagar']."\r\n";
                 fwrite($f, $linea);
                 fclose($f);
                 
            $f = fopen('D:/data0/facturador/DATA/'.$comprobante['ruc'].'-'.$comprobante['codigo'].'-'.$comprobante['serie'].'-'.$comprobante['numero'].'.DET','w');
            foreach ($items as $value) {
                 $linea = "NIU"."|".$value['cantidad']."|||".$value['descripcion']."|".$value['cantidad']."||".$value['igv']."|".$value['tipo_igv_id']."|||".$value['importe']."|".$value['total']."\r\n";
                 fwrite($f, $linea);
            }                 
                 fclose($f);
        }           
           redirect(base_url() . "index.php/comprobantes/index");
        }
        
        
//        public function selectCombo() {
//        //$eliminado = '0';
//        $comprobantes = $this->comprobantes_model->select('','','','','','','',0);
//        //$comprobantes = $this->comprobantes_model->select('', $this->uri->segment(3), 'activo', '', '', '', $eliminado);
//        //echo '<option value="">Seleccionar Comprobante</option>';
//        foreach ($comprobantes as $value) {
//            echo '<option value="' . $value['comprobante_id'] . '">' . $value['serie'] . ' ' . $value['numero'] . '</option>';
//        }
//    }
        
}
?>
