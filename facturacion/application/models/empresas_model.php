<?PHP

class Empresas_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function select($id = '', $activo = ''){
        if ($id != '') {
            $sql = "SELECT *FROM empresas
                    WHERE id = " . $id;
            $query = $this->db->query($sql);
            return $query->row_array();
        }

        $where = '';
        $where = ($activo != '') ? " AND activo = ".$activo : '';

        $sql = "SELECT *FROM empresas WHERE 1 = 1 ".$where;
        $query = $this->db->query($sql);
       
        //var_dump($rows);exit;        
        return $query->result_array();
    }

}