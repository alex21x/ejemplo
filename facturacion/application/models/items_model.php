<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Items_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        
        $sesion_empleado_id = $this->session->userdata('empleado_id');
        if(empty($sesion_empleado_id)){
            $this->session->set_flashdata('mensaje', 'No existe sessión activa');
            redirect(base_url());
        }
    }
    
     
    public function select($id = '',$comprobante_id = '') {
        
         if($id != ''){
            $sql = "SELECT * FROM items WHERE id = ".$id;            
            $query = $this->db->query($sql);
            
            return $query->result_array();
        }
        
        $where = '';
        if($comprobante_id != ''){$where.= ' AND comprobante_id = '.$comprobante_id;}                                
        
        
            $sql = "SELECT *,com.id comprobante_id,its.id item_id FROM items its"
                    . " JOIN comprobantes com"
                    . " ON its.comprobante_id = com.id"
                    . " JOIN tipo_items tpi"
                    . " ON its.tipo_item_id = tpi.id"                    
                    . " JOIN tipo_igv tig"
                    . " ON its.tipo_igv_id = tig.id"                    
                    . " WHERE 1=1 ".$where.' AND its.eliminado = 0 ORDER BY its.id ASC';
            
            $query = $this->db->query($sql);

            //var_dump($query->result());exit;
            return $query->result_array();                
    }

    public function insertar($data) {
        $this->db->insert('items', $data);        
        $this->session->set_flashdata('mensaje', 'Contacto: Ingresado exitosamente');
        //return mysql_insert_id();
    }

    public function modificar($data, $where){
        $this->db->where('id',$where);
        $this->db->update('items', $data);
        $this->session->set_flashdata('mensaje', 'contacto modificado exitosamente');
    }

    public function eliminar($id){  
        $sql_eli = "UPDATE items SET eliminado = 1 WHERE id = " . $id;
        $this->db->query($sql_eli);
        $this->session->set_flashdata('mensaje', 'Item eliminado exitosamente');
    }        
}
