<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comprobantes_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        
        $sesion_empleado_id = $this->session->userdata('empleado_id');
        if(empty($sesion_empleado_id)){
            $this->session->set_flashdata('mensaje', 'No existe sessión activa');
            redirect(base_url());
        }
    }
    
    public function select($id = '',$serie = '',$numero = '',$fecha_de_emision = '',$fecha_de_vencimiento = '',$cliente_id = '',$tipo_documento_id = '',$com_adjuntos = ''){
        
        if($id != ''){
            $sql = "SELECT *,DATE_FORMAT(fecha_de_emision, '%d-%m-%Y') AS fecha_de_emision,"
                    . " DATE_FORMAT(fecha_de_vencimiento, '%d-%m-%Y') AS fecha_de_vencimiento,"
                    . " com.id comprobante_id,"
                    . " com.empresa_id empresa_id,"
                    . " tpc.codigo tipo_cliente_codigo,"
                    . " eaa.descripcion elemento_adicional_descripcion"
                    . " FROM comprobantes com"
                    . " JOIN clientes cli"
                    . " ON com.cliente_id = cli.id"
                    . " JOIN tipo_clientes tpc"
                    . " ON tpc.id = cli.tipo_cliente_id"
                    . " JOIN monedas mon"
                    . " ON com.moneda_id = mon.id"
                    . " JOIN tipo_documentos tdc"
                    . " ON com.tipo_documento_id = tdc.id"
                    . " JOIN tipo_pagos tpp"
                    . " ON com.tipo_pago_id = tpp.id"
                    . " JOIN empresas epr"
                    . " ON com.empresa_id = epr.id"                    
                    . " LEFT JOIN elemento_adicionales eaa"
                    . " ON com.elemento_adicional_id = eaa.id"                    
                    . " WHERE com.id = ".$id;
            //echo $sql;
            $query = $this->db->query($sql);  
            //var_dump($query->row_array());exit;
            return $query->row_array();
        }
        
        $where = '';
        if($serie != ''){$where.= ' AND serie = '.$serie;}
        if($numero != ''){$where.= ' AND numero = '.$numero;}
        if($fecha_de_emision != ''){$where.= ' AND fecha_de_emision = '.$fecha_de_emision;}
        if($fecha_de_vencimiento != ''){$where.= ' AND fecha_de_vencimiento = '.$fecha_de_vencimiento;}
        if($cliente_id != ''){$where.= ' AND cliente_id = '.$cliente_id;}
        if($tipo_documento_id != ''){$where.= ' AND tipo_documento_id = '.$tipo_documento_id;}
        if($tipo_documento_id != ''){$where.= ' AND tipo_documento_id = '.$tipo_documento_id;}
        if($com_adjuntos != ''){$where.= ' AND tipo_documento_id IN(1,3)';}
        
        
            $sql = "SELECT *,DATE_FORMAT(fecha_de_emision, '%d-%m-%Y') AS fecha_de_emision,"
                    . " DATE_FORMAT(fecha_de_vencimiento, '%d-%m-%Y') AS fecha_de_vencimiento,"
                    . " com.id comprobante_id,"
                    . " com.empresa_id empresa_id,"
                    . " tpc.codigo tipo_cliente_codigo,"
                    . " eaa.descripcion elemento_adicional_descripcion"
                    . " FROM comprobantes com"
                    . " JOIN clientes cli"
                    . " ON com.cliente_id = cli.id"
                    . " JOIN tipo_clientes tpc"
                    . " ON tpc.id = cli.tipo_cliente_id"
                    . " JOIN monedas mon"
                    . " ON com.moneda_id = mon.id"                    
                    . " JOIN tipo_documentos tdc"
                    . " ON com.tipo_documento_id = tdc.id"
                    . " JOIN tipo_pagos tpp"
                    . " ON com.tipo_pago_id = tpp.id"
                    . " JOIN empresas epr"
                    . " ON com.empresa_id = epr.id"
                    . " LEFT JOIN elemento_adicionales eaa"
                    . " ON com.elemento_adicional_id = eaa.id"                    
                    . " WHERE 1=1 ".$where." ORDER BY comprobante_id DESC";
            
            $query = $this->db->query($sql);
            //echo $sql;
            //var_dump($query->result());exit;
            return $query->result_array();        
    }        

    public function insertar($data) {
        $this->db->insert('comprobantes', $data);        
        $this->session->set_flashdata('mensaje', 'Comprobante: Ingresado exitosamente');
        return $this->db->insert_id();
    }

    public function modificar($data, $where){
        $this->db->where('id',$where);
        $this->db->update('comprobantes', $data);
        $this->session->set_flashdata('mensaje', 'Comprobante modificado exitosamente');
    }

    public function eliminar($id, $apellido_paterno){  
        $sql_eli = "UPDATE comprobantes SET eliminado = 1 WHERE id = " . $id;
        mysql_query($sql_eli);
        $this->session->set_flashdata('mensaje', 'contacto: '. $apellido_paterno .' eliminado exitosamente');
    }
    
    public function selectComprobanteItems($comprobante_id = ''){               
        $where = '';
        if($comprobante_id != ''){$where.= ' AND comprobante_id = '.$comprobante_id;}
        
            $sql = "SELECT *,com.id comprobante_id FROM comprobantes com"
                    . " JOIN items itm"
                    . " ON com.id = itm.comprobante_id"
                    . " WHERE 1=1 ".$where;
            
            $query = $this->db->query($sql);

            //var_dump($query->result());exit;
            return $query->result_array();                                        
    }        
}