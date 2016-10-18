<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Monedas_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }    
    
    public function select($id = FALSE) {
        if ($id != FALSE) {
            $sql = "SELECT *FROM monedas
                    WHERE id = " . $id;
            $query = mysql_query($sql);
            return mysql_fetch_assoc($query);
        }

        $sql = "SELECT *FROM monedas WHERE 1 = 1 ";
        $query = $this->db->query($sql);
        $rows = array();
        foreach($query->result_array() as $row){
            $rows[] = $row;
        }

        return $rows;
    }

}