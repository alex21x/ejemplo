<?PHP

class Accesos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();        
    }

    public function select($where = FALSE) {
        if ($where === FALSE) {
            $query = $this->db->get('accesos');
            return $query->result_array();
        }
        $query = $this->db->get_where('accesos', array('id' => $where));
        return $query->row_array();        
    }
    
    public function menuGeneral(){        
        switch ($this->session->userdata('tipo_empleado_id')) {
            case 1:
                $this->load->view('templates/header_administrador');
                break;
            case 2:
                $data = array();
                $this->load->model('jefes_model');
                $secretaria_receptora_documentos = 1;                
                $array_jefe = $this->jefes_model->seleccionarJefes('', $this->session->userdata('empleado_id'), '', $secretaria_receptora_documentos);
                if(count($array_jefe) > 0){
                    $data['secretaria_receptora_documentos'] = 1;
                }
                
                $this->load->view('templates/header_secretaria', $data);
                break;
            case 3:
                $this->load->view('templates/header_socio');
                break;
            case 4:
                $this->load->view('templates/header_abogado');
                break;
            case 5:
                $this->load->view('templates/header_practicante');
                break;
            case 6:
                $this->load->view('templates/header_otros_abogado');
                break;
            case 8:
                $this->load->view('templates/header_contabilidad');
                break;
            case 9:
                $this->load->view('templates/header_recursos_humanos');
                break;

            default:
                break;
        }
                        
    }

}