<?PHP

class Acceso extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Empleados_model');
        $this->load->model('accesos_model');
        $this->load->helper('cookie');        
    }

    function index() {     
        //echo 'hoa '.$this->session->userdata('session_url');exit;
        $data = '';
        $cokie_empleado_id = $this->input->cookie('empleadoid', TRUE);
        $cokie_cokie = $this->input->cookie('cookie', TRUE);
        if(!empty($cokie_empleado_id) && !empty($cokie_cokie)){
            $uno = $this->Empleados_model->verificar_cookie($cokie_empleado_id, $cokie_cokie);
            $dos = $this->Empleados_model->verificar_cookie($cokie_empleado_id, $cokie_cokie);
            if(!empty($uno) && $dos > 0){
                $data['dni'] = $this->Empleados_model->verificar_cookie($cokie_empleado_id, $cokie_cokie);
            }
        }
        
        $usuario_empleado_id = $this->session->userdata('empleado_id');
        if(!empty($usuario_empleado_id)){
            redirect(base_url() . "index.php/acceso/login");
        }

        $this->load->view('templates/header_sin_menu');
        $this->load->view('acceso/login', $data);
        $this->load->view('templates/footer');
    }

    function inicio_administrador() {        
        $this->accesos_model->menuGeneral();
        $this->load->view('acceso/inicio');
        $this->load->view('templates/footer');
    }

    function inicio_secretaria() {                
        $this->accesos_model->menuGeneral();
        $this->load->view('acceso/inicio');
        $this->load->view('templates/footer');
    }

    function inicio_socio() {        
        $this->accesos_model->menuGeneral();
        $this->load->view('acceso/inicio');
        $this->load->view('templates/footer');
    }

    function inicio_abogado() {        
        $this->accesos_model->menuGeneral();
        $this->load->view('acceso/inicio');
        $this->load->view('templates/footer');
    }

    function inicio_practicante() {        
        $this->accesos_model->menuGeneral();
        $this->load->view('acceso/inicio');
        $this->load->view('templates/footer');
    }
    
    function inicio_contabilidad() {        
        $this->accesos_model->menuGeneral();
        $this->load->view('acceso/inicio');
        $this->load->view('templates/footer');
    }
    
    function inicio_recursos_humanos() {        
        $this->accesos_model->menuGeneral();
        $this->load->view('acceso/inicio');
        $this->load->view('templates/footer');
    }

    function inicio_otros_abogados() {
        $this->load->view('templates/header_otros_abogados');        
        $this->load->view('acceso/inicio');
        $this->load->view('templates/footer');
    }

    function login() {              
        $usuario = $this->input->post('usuario');
        $usario_dni = $this->session->userdata('dni');
        
        if($this->input->post('usuario') == '' && !empty($usario_dni)){
            $usuario = $this->session->userdata('dni');
        }
        
        if ($this->Empleados_model->login($usuario)) {
            if($this->input->post('recordar') == TRUE){//ACTUALIZO COKIE       
                $this->Empleados_model->modificar_cookie($this->session->userdata('empleado_id'));
            }else{//DESTRUYO COKIE                
                if(isset($_COOKIE['empleado_id'])){
                    unset($_COOKIE['empleado_id']);
                }
                if(isset($_COOKIE['cookie'])){
                    unset($_COOKIE['cookie']);
                }
            }
            
            //para las imagenes.
            $user_foto = $this->session->userdata('foto');
            $filename = './files/foto/' . $user_foto;
            if(file_exists($filename) && !empty($user_foto)){
                $data = array(
                    'ruta_foto' => './files/foto/'.$this->session->userdata('foto'),
                    'title' => $this->session->userdata('usuario') . " " . $this->session->userdata('apellido_paterno')
                );                
            }else{
                $data = array(
                    'ruta_foto' => "./files/foto/sin_foto.jpg",
                    'title'=>"sin foto"
                );                
            }
            $this->session->set_userdata($data);
            
            //echo "c";exit;
            
            //echo "d";exit;
            session_start();
            //echo $_SESSION["parametro"];exit;
            if(isset($_SESSION["parametro"]))
                redirect($_SESSION["parametro"]);
                //echo $_SESSION["parametro"];exit;
                
                        
            if ($this->Empleados_model->login($usuario) == 1) {//administrador
                redirect(base_url() . "index.php/acceso/inicio_administrador");
            }
            if ($this->Empleados_model->login($usuario) == 2) {//secretaria
                redirect(base_url() . "index.php/acceso/inicio_secretaria");
            }
            if ($this->Empleados_model->login($usuario) == 3) {//socio
                redirect(base_url() . "index.php/acceso/inicio_socio");
            }
            if ($this->Empleados_model->login($usuario) == 4) {//abogado
                redirect(base_url() . "index.php/acceso/inicio_abogado");
            }
            if ($this->Empleados_model->login($usuario) == 5) {//practicante
                redirect(base_url() . "index.php/acceso/inicio_practicante");
            }
            if ($this->Empleados_model->login($usuario) == 6) {//otros_abogados
                redirect(base_url() . "index.php/acceso/inicio_otros_abogados");
            }
            if ($this->Empleados_model->login($usuario) == 7) {//TYTL-Asesor_Andina                
                $this->session->set_flashdata('mensaje', 'Empleado TYTL-Asesor_Andina, sin acceso al sistema');
                $this->session->unset_userdata('empleado_id');
                redirect(base_url());
            }            
            if ($this->Empleados_model->login($usuario) == 8) {//otros_abogados
                redirect(base_url() . "index.php/acceso/inicio_contabilidad");
            }
            if ($this->Empleados_model->login($usuario) == 9) {//otros_abogados
                redirect(base_url() . "index.php/acceso/inicio_recursos_humanos");
            }                                    
        } else {
            redirect(base_url());
        }
    }

    function login_general() {
        $post_usuario = $this->input->post('usuario');
        if (!empty($post_usuario)) { 
            if ($this->Empleados_model->login($post_usuario)) {
                $data = array('grande'=>1);
                $this->session->set_userdata($data);
                $this->load->view('acceso/acceso');
            } else {
                redirect('http://tytl.pe/sistemas/index.php?res=Datos_Incorrectos');
            }
        } else {            
            redirect('http://tytl.pe/sistemas/');
            
//            $this->load->view('templates/header_sin_menu');
//            $this->load->view('acceso/login_general');
//            $this->load->view('templates/footer');           
        }
    }

    function logout() {        
        if($this->session->userdata('grande')==1){
            $this->session->sess_destroy();
            redirect('http://tytl.pe/sistemas/');
        }else{
            $this->session->sess_destroy();
            redirect(base_url());
        }
    }

    function documentos_institucionales() {
        if( $this->session->userdata('empleado_id') == 247){
            redirect(base_url() . "documentacion/ABOGADOS.htm");
        }
        
        switch ($this->session->userdata('tipo_empleado_id')) {
            case 1:
                redirect(base_url() . "documentacion/document.htm");
                break;

            case 2:
                redirect(base_url() . "documentacion/PERSONAL.htm");
                break;

            case 3:
                redirect(base_url() . "documentacion/SOCIOS.htm");
                break;

            case 4:
                redirect(base_url() . "documentacion/ABOGADOS.htm");
                break;

            case 5:
                redirect(base_url() . "documentacion/PRACTICANTES.htm");
                break;

            case 7:
                redirect(base_url() . "documentacion/PERSONAL.htm");
                break;                                    

            default:
                echo "Sin acceso<br>";
                echo "<a href='" . base_url() . 'index.php/acceso/menu_principal' . "'>Atras</a>";
                break;
        }
    }

    function biblioteca() {
        $this->load->view('acceso/biblioteca');
    }

    function acceso_datos() {
        $this->load->view('templates/header_sin_menu');
        $this->load->view('acceso/acceso_datos');
        $this->load->view('templates/footer');
    }

    function acceso_datos_descargar() {
        if ($this->input->post('password') == $this->session->userdata('dni')) {
            $this->load->view('templates/header_sin_menu');
            $this->load->view('acceso/acceso_datos_descargar');
            $this->load->view('templates/footer');
        } else {
            echo "Clave Incorrecta";
            echo "<br>";
            echo "<a href='" . base_url() . "index.php/acceso/menu_principal'>Menu</a>";
        }
    }

    public function menu_principal() {
        $this->load->view('acceso/acceso');
    }

    function dirigir() {
        switch ($this->session->userdata('tipo_empleado_id')) {
            case 1:
                $this->load->view('templates/header_administrador');
                break;

            case 2:
                $this->load->view('templates/header_secretaria');
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
                $this->load->view('templates/header_otros_abogados');
                break;

            default:
                break;
        }
        $this->load->view('acceso/inicio_sistema');
        $this->load->view('templates/footer');
    }
        
    function redirecciona() {        
        session_start();
        $_SESSION["parametro"] = $_GET['parametro'];        
        redirect($_GET['parametro']);
    }

}
