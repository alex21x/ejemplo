<?PHP

    if(!defined('BASEPATH'))
        exit ('No direct script access allowed');
    
    
    class Tipo_pagos_model extends CI_Model {
     
        public function __construct() {
            parent::__construct();
            $this->load->database();
        }
        
        
        public function select($id = '' , $tipo_pago = '') {
            
            if($id != ''){
                $sql = "SELECT *FROM tipo_pago
                        WHERE id = ". $id;                
                $query = mysql_query($sql);
                return mysql_fetch_assoc($query);
            }
            
            $where = '';
            $where = ($tipo_pago != '') ? " AND tipo_pago LIKE  '%".$tipo_pago."%'" : '';
            
            $sql = "SELECT *FROM tipo_pagos WHERE 1=1 ".$where;
            
            $query = $this->db->query($sql);
            $rows  = array(); 
            
            //var_dump($query->result());
            foreach($query->result() as $row){
                //var_dump($row);
                    $rows[] = $row;
            }     
            
            
            
            $rows = $query->result_array();
            //var_dump($rows);
            return $rows;
        }
    }    