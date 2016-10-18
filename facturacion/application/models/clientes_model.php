<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clientes_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function insertar($data, $mensaje = '') {  
        
        //var_dump($data);EXIT;
        $this->db->insert('clientes', $data);
        if($mensaje != ''){
            $this->session->set_flashdata('mensaje_cliente_index', $mensaje);
        }
    }

    public function modificar($id, $data, $mensaje = ''){
        $this->db->where('id', $id);
        $this->db->update('clientes', $data);
        //echo $this->db->last_query();
        if($mensaje != ''){
            $this->session->set_flashdata('mensaje_cliente_index', $mensaje);
        }
    }

    public function select($id = '', $activo = '', $id_listado = '', $empresa = '',$tipo_cliente='', $tipo_contrato = '', $activo_contrato = '',$limit = FALSE, $start = FALSE){
        $where  = '';
        $limite = '';
        
        $where .= ($activo != '') ? " AND cli.activo = '".$activo."'" : '';        
        $where .= ($id_listado != '') ? " AND cli.id = ".$id_listado : '';
        $where .= ($empresa != '') ? " AND cli.empresa_id = ".$empresa : '';
        $where .= ($tipo_cliente != '')  ? " AND cli.`tipo_cliente_id` = " . $tipo_cliente : '';        
        if (($limit !== FALSE) && ($start !== FALSE))
            $limite .= " LIMIT ".$start .', '.$limit;
        
        if ($id != '' && $id_listado == '') {
            $sql = "SELECT *FROM clientes WHERE id = " . $id;
            $query = $this->db->query($sql);
            return $query->row_array();
        }
                                              
        
        if (($tipo_contrato != '') || ($activo_contrato != '')){
            $where .= ($activo_contrato != '') ? " AND con.activo = '".$activo_contrato."'" : '';
            $where .= ($tipo_contrato != '')   ? " AND con.`tipo_contrato_id` = " . $tipo_contrato : '';
            
            $sql = "SELECT
                DISTINCT(cli.id) cliente_id, 
                cli.tipo_cliente_id,
                cli.tipo_cliente,
                cli.ruc,
                cli.nombres,
                cli.`razon_social`,
                cli.`email`,
                cli.domicilio1,
                cli.telefono_fijo_1,
                cli.telefono_fijo_2,    
                epr.`empresa` empresa
                FROM clientes cli
                JOIN `contratos` con ON cli.id = con.cliente_id
                JOIN `empresas` epr ON cli.`empresa_id` = epr.`id`                 
                WHERE 1 = 1 " . $where . " 
                ORDER BY cli.razon_social".$limite;                            
        }else{
            $sql = "SELECT
                cli.id cliente_id,
                cli.tipo_cliente_id,
                cli.tipo_cliente,
                cli.ruc,
                cli.nombres,
                cli.`razon_social`,
                cli.`email`,
                cli.domicilio1,
                cli.telefono_fijo_1,
                cli.telefono_fijo_2,    
                epr.`empresa` empresa
                FROM clientes cli
                JOIN empresas epr
                ON cli.empresa_id = epr.id
                WHERE 1 = 1 ".$where." ORDER BY razon_social".$limite;            
        }                
        //echo $sql;
        $rows = $this->db->query($sql);        
        return $rows->result_array();
    }

    public function clientePorTipoContratos($tipo_contrato, $activo = ''){
        $where = ($activo != '') ? " AND con.activo = '".$activo."'" : '';
        $sql = "SELECT 
        DISTINCT(cli.id) id, 
        cli.ruc,
        cli.`razon_social`,
        cli.domicilio1,
        cli.telefono_fijo_1,
        cli.telefono_fijo_2,    
        epr.`empresa` empresa
        FROM clientes cli
        JOIN `contratos` con ON cli.id = con.cliente_id
        JOIN `empresas` epr ON cli.`empresa_id` = epr.`id` 
        WHERE con.`tipo_contrato_id` = " . $tipo_contrato . $where . " 
        ORDER BY cli.razon_social
        ";
        $query = mysql_query($sql);
        $rows = array();
        while ($row = mysql_fetch_assoc($query)){
            $rows[] = $row;
        }
        return $rows;
    }

    public function selectAutocomplete($buscar, $activo = ''){
        $where = '';
        if($activo != ''){$where = " AND activo = '".$activo."' ";}
        $sql = "SELECT
                id,
                ruc,
                razon_social,
                domicilio1
                FROM clientes
                WHERE
                (ruc LIKE '%$buscar%'
                OR razon_social LIKE '%$buscar%') " . $where . "
                ORDER BY razon_social, ruc";
        $query = $this->db->query($sql);

        $data = array();
        if ($query->row()) {
            foreach ($query->result_array() as $tsArray){
                $data[] = array(
                    "value" => $tsArray['razon_social'],
                    "ruc" => $tsArray['ruc'],
                    "domicilio1" => $tsArray['domicilio1'],
                    "id" => $tsArray['id']
                );
            }
        }

        return $data;
    }

    public function eliminar(){
        $sql_eli = "DELETE FROM clientes WHERE id = " . $this->uri->segment(3);
        mysql_query($sql_eli);
        $this->session->set_flashdata('mensaje_cliente_index', 'Cliente: eliminado exitosamente');
    }    
    
    public function clientesDeInteres($abogado_interesado, $activo_cliente = '', $activo_contrato = ''){
        $where = '';
        if($activo_cliente != ''){$where = " AND cli.activo = '".$activo_cliente."' ";}
        if($activo_contrato != ''){$where = " AND con.activo = '".$activo_contrato."' ";}
        
        $sql = "SELECT DISTINCT(con.`cliente_id`) cliente_id FROM `empleado_interesados` ei
        JOIN `contratos` con
        ON ei.`contrato_id` = con.`id`
        JOIN clientes cli
        ON cli.id = con.cliente_id
        WHERE ei.`empleado_id` = " .$abogado_interesado . $where;
        $query = mysql_query($sql);
        $rows = array();
        while ($row = mysql_fetch_assoc($query)){
            $rows[] = $row['cliente_id'];
        }
        return $rows;        
    }

}