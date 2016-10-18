<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Empleados_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function login($usuario) {                
        $this->db->where(array('dni' => $usuario,
                                'acceso' => 'con acceso'))
                ->select('empleados.id, nombre, dni, apellido_paterno, apellido_materno, email, tipo_empleado_id, tipo_empleado, secretaria_recepcion_documentos, categoria_abogado_id, foto')
                ->from('empleados')
                ->join('tipo_empleados', 'empleados.tipo_empleado_id = tipo_empleados.id');
        
        $consulta = $this->db->get();        
        //var_dump($consulta->row());exit();
                
        //echo $this->db->last_query();exit;
        if ($consulta->row()) {
            $consulta_dato = $consulta->row();
            
            $data = array(
                'empleado_id' => $consulta_dato->id,
                'usuario' => $consulta_dato->nombre,
                'dni' => $consulta_dato->dni,
                'apellido_paterno' => $consulta_dato->apellido_paterno,
                'apellido_materno' => $consulta_dato->apellido_materno,
                'email' => $consulta_dato->email,
                'tipo_empleado_id' => $consulta_dato->tipo_empleado_id,
                'tipo_empleado' => $consulta_dato->tipo_empleado,
                'secretaria_recepcion_documentos' => $consulta_dato->secretaria_recepcion_documentos,
                'categoria_abogado_id' => $consulta_dato->categoria_abogado_id,
                'foto' => $consulta_dato->foto
            );            
            $this->session->set_userdata($data);
            $this->session->set_flashdata('mensaje', 'Datos Correctos');
            return $consulta_dato->tipo_empleado_id;
        } else {
            $this->session->set_flashdata('mensaje', 'Datos Incorrectos o personal sin acceso');
            return FALSE;
        }
    }

    public function insertarEmpleado($id = NULL) {
        $post_fecha_nacimiento = $this->input->post('fecha_nacimiento');
        $date = new DateTime($post_fecha_nacimiento);
        $fecha_nacimiento = $date->format('Y-m-d');
        
        $data = array(
            'nombre' => $this->input->post('nombre'),
            'apellido_paterno' => $this->input->post('apellido_paterno'),
            'apellido_materno' => $this->input->post('apellido_materno'),
            'dni' => $this->input->post('dni'),
            'domicilio' => $this->input->post('domicilio'),
            'telefono_fijo' => $this->input->post('telefono_fijo'),
            'telefono_celular_1' => $this->input->post('telefono_celular_1'),
            'telefono_celular_2' => $this->input->post('telefono_celular_2'),
            'email' => $this->input->post('email'),
            'fecha_nacimiento' => $fecha_nacimiento,
            'tipo_empleado_id' => $this->input->post('tipo_empleado_id'),            
            'empresa_id' => $this->input->post('empresa'),
            'categoria_abogado_id' =>$this->input->post('categoria_abogado'),
            'activo' =>$this->input->post('activo'),
            'acceso' =>$this->input->post('acceso')
        );
        $str = $this->db->insert('empleados', $data);

        if($id != NULL){
            return $this->db->insert_id();
        }
        $this->session->set_flashdata('mensaje', 'Abogado: ' . $this->input->post('apellido_paterno') . ' ' . $this->input->post('apellido_materno'). ', '.$this->input->post('nombre').' ingresado exitosamente');
    }
    
    public function insertarEmpleadosRecursos($id = NULL) {
        $post_fecha_nacimiento = $this->input->post('fecha_nacimiento');
        $date = new DateTime($post_fecha_nacimiento);
        $fecha_nacimiento = $date->format('Y-m-d');
        
        $data = array(
            'nombre' => $this->input->post('nombre'),
            'apellido_paterno' => $this->input->post('apellido_paterno'),
            'apellido_materno' => $this->input->post('apellido_materno'),
            'dni' => $this->input->post('dni'),
            'domicilio' => $this->input->post('domicilio'),
            'telefono_fijo' => $this->input->post('telefono_fijo'),
            'telefono_celular_1' => $this->input->post('telefono_celular_1'),
            'telefono_celular_2' => $this->input->post('telefono_celular_2'),
            'email' => $this->input->post('email'),
            'fecha_nacimiento' => $fecha_nacimiento,            
            'empresa_id' => $this->input->post('empresa'),
            'categoria_abogado_id' =>$this->input->post('categoria_abogado'),
            'activo' =>$this->input->post('activo'),
            'acceso' =>$this->input->post('acceso')
        );
                          
        if($this->input->post('tipo_horarios') != '')
            $data = array_merge($data,array('tipo_horario_id' => $this->input->post('tipo_horarios')));        
        if($this->input->post('tipo_cargo') != '')
            $data = array_merge($data,array('tipo_cargo_id' => $this->input->post('tipo_cargo')));
        
        
        $str = $this->db->insert('empleados', $data);

        if($id != NULL){
            return $this->db->insert_id();
        }
        $this->session->set_flashdata('mensaje', 'Abogado: ' . $this->input->post('apellido_paterno') . ' ' . $this->input->post('apellido_materno'). ', '.$this->input->post('nombre').' ingresado exitosamente');
    }
    
    
    
    public function modificar_cookie($empleado_id){     
        $randx = mt_rand(1000000, 9999999);        
        $this->load->helper('cookie');
        
        $rand = mt_rand(1000000, 9999999);
        $sql = "UPDATE empleados SET cookie = " . $rand . " WHERE id = ".$empleado_id;
        //echo "modificar: ".$sql;
        mysql_query($sql);
        
        $expire1 = 8259200;        
        $cookie = array(
            'name'   => 'empleadoid',
            'value'  => $empleado_id,
            'expire' => $expire1,            
        );
        $this->input->set_cookie($cookie);  
        
        $expire2 = 8259200;        
        $cookie2 = array(
            'name'   => 'cookie',
            'value'  => $rand,
            'expire' => $expire2            
        );
        $this->input->set_cookie($cookie2);                  
    }
    
    public function modificar_g($data, $where, $mensaje = ''){
        $this->db->where('id', $where);
        $this->db->update('empleados', $data);
        if ($mensaje == '') {
            $mensaje = 'Empleado modificado exitosamente';
        }        
        $this->session->set_flashdata('mensaje', $mensaje);
    }
    
    public function select($id = '', $tipo_empleado_id = '', $categoria_abogado_id = '', $activo = '', $acceso = '', $dni = ''){
        if ($id != '') {                        
            $sql = "SELECT *, empleados.id AS empleados_id, DATE_FORMAT(fecha_nacimiento, '%d-%m-%Y') AS fecha_nacimiento, 
                    empleados.activo AS empleado_activo, empleados.acceso AS empleado_acceso
                    FROM `empleados`
                    LEFT JOIN `categoria_abogados`
                    ON (`empleados`.`categoria_abogado_id` = `categoria_abogados`.`id`)
                    WHERE empleados.id = " . $id;
                        
            $query = $this->db->query($sql);
            return $query->row_array();
        }
        
        $where = '';
        if ($tipo_empleado_id != '') {$where .= " AND tipo_empleado_id = " . $tipo_empleado_id;}        
        if ($categoria_abogado_id != '') {$where .= " AND categoria_abogado_id " . $categoria_abogado_id;}        
        if ($activo != '') {$where .= " AND empleados.activo = '" . $activo."' ";}
        if ($acceso != '') {$where .= " AND acceso = '" . $acceso."' ";}
        if ($dni != '') {$where .= " AND dni = '" . $dni."' ";}
                                    
        $sql = "SELECT *, empleados.id AS empleados_id, DATE_FORMAT(fecha_nacimiento, '%d-%m-%Y') AS fecha_nacimiento, 
                empleados.activo AS empleado_activo, empleados.acceso AS empleado_acceso
                FROM `empleados` 
                LEFT JOIN `categoria_abogados` 
                ON (`empleados`.`categoria_abogado_id` = `categoria_abogados`.`id`) 
                WHERE 1 = 1 AND `empleados`.eliminado = 0".$where. " ORDER BY empleados.apellido_paterno, empleados.apellido_materno, empleados.nombre";                        
        
        $query = mysql_query($sql);
        $rows = array();
        while ($row = mysql_fetch_assoc($query)){
            $rows[] = $row;
        }
        return $rows;
    }
    
    public function selectEmpleadosRecursos($id = '', $empleado_id = '', $tipo_cargo_id = '',$empresa_id = '' , $activo = '', $limit = FALSE, $start = FALSE ){
        if ($id != '' && $empleado_id = '') {                        
            $sql = "SELECT *, empleados.id AS empleados_id, DATE_FORMAT(fecha_nacimiento, '%d-%m-%Y') AS fecha_nacimiento, 
                    empleados.activo AS empleado_activo, empleados.acceso AS empleado_acceso
                    FROM `empleados`
                    LEFT JOIN `categoria_abogados` 
                    ON (`empleados`.`categoria_abogado_id` = `categoria_abogados`.`id`)
                    LEFT JOIN tipo_horarios
                    ON (`empleados`.`tipo_horario_id` = `tipo_horarios`.`id`)
                    WHERE empleados.id = " . $id;
                        
            //echo $sql;            
            $query = mysql_query($sql);           
            return mysql_fetch_assoc($query);
        }
        
                $this->session->set_userdata('estado_empleado', $activo);
                $this->session->set_userdata('empresa_id', $empresa_id);
                $this->session->set_userdata('tipo_cargo', $tipo_cargo_id);
                $this->session->set_userdata('empleado_selec_id', $empleado_id);
        
        $where = '';
        $limite = '';
        if ($empleado_id != '') {$where .= " AND empleados.id = " . $empleado_id;}         
        if ($tipo_cargo_id != '') {$where .= " AND tipo_cargo_id = " . $tipo_cargo_id;}                
        if ($empresa_id != '') {$where .= " AND empresa_id = " . $empresa_id;}
        if ($activo != '') {$where .= " AND empleados.activo = '" . $activo."' ";}        
        if (($limit !== FALSE) && ($start !== FALSE)){$limite .= " LIMIT ".$start .', '.$limit;}
        
        
                                    
        $sql = "SELECT *, empleados.id AS empleados_id, DATE_FORMAT(fecha_nacimiento, '%d-%m-%Y') AS fecha_nacimiento, 
                empleados.activo AS empleado_activo, empleados.acceso AS empleado_acceso
                FROM `empleados`
                LEFT JOIN `categoria_abogados` 
                ON (`empleados`.`categoria_abogado_id` = `categoria_abogados`.`id`)                
                LEFT JOIN tipo_horarios
                ON (`empleados`.`tipo_horario_id` = `tipo_horarios`.`id`)
                WHERE 1 = 1 ".$where. " ORDER BY empleados.apellido_paterno, empleados.apellido_materno, empleados.nombre " .$limite;                        
        //echo $sql.'<br>';
        $query = mysql_query($sql);
        $rows = array();
        while ($row = mysql_fetch_assoc($query)){
            $rows[] = $row;
        }                
        return $rows;
    }
    
    public function numSelectEmpleadosRecursos($id = '', $empleado_id = '', $tipo_cargo_id = '',$empresa_id = '' , $activo = '') {
        $where = '';
        if ($empleado_id != '') {$where .= " AND empleados.id = " . $empleado_id;}         
        if ($tipo_cargo_id != '') {$where .= " AND tipo_cargo_id = " . $tipo_cargo_id;}                
        if ($empresa_id != '') {$where .= " AND empresa_id = " . $empresa_id;}
        if ($activo != '') {$where .= " AND empleados.activo = '" . $activo."' ";} 
        
        
      $sql = "SELECT *, empleados.id AS empleados_id, DATE_FORMAT(fecha_nacimiento, '%d-%m-%Y') AS fecha_nacimiento, 
                empleados.activo AS empleado_activo, empleados.acceso AS empleado_acceso
                FROM `empleados`
                LEFT JOIN `categoria_abogados` 
                ON (`empleados`.`categoria_abogado_id` = `categoria_abogados`.`id`)                
                WHERE 1 = 1 ".$where. " ORDER BY empleados.apellido_paterno, empleados.apellido_materno, empleados.nombre";
            
            $query = mysql_query($sql);
                 
            return mysql_num_rows($query);        
    }
    
    
    public function selectPerfil($id = '', $tipo_empleado_id = '', $categoria_abogado_id = '', $activo = '', $acceso = '', $dni = ''){
        if ($id != '') {                        
            $sql = "SELECT *, empleados.id AS empleados_id, DATE_FORMAT(fecha_nacimiento, '%d-%m-%Y') AS fecha_nacimiento, 
                    empleados.activo AS empleado_activo, empleados.acceso AS empleado_acceso,
                    empresas.empresa AS empresa , tipo_horarios.ingreso AS ingreso , tipo_horarios.salida AS salida
                    FROM `empleados`
                    LEFT JOIN `categoria_abogados`                     
                    ON (`empleados`.`categoria_abogado_id` = `categoria_abogados`.`id`)
                    INNER JOIN `empresas`
                    ON (`empleados`.`empresa_id` = `empresas`.`id`)
                    LEFT JOIN `tipo_horarios`
                    ON (`empleados`.`tipo_horario_id` = `tipo_horarios`.`id`)
                    WHERE empleados.id = " . $id;
                        
            $query = mysql_query($sql);
            return mysql_fetch_assoc($query);
        }
        
        $where = '';
        if ($tipo_empleado_id != '') {$where .= " AND tipo_empleado_id = " . $tipo_empleado_id;}        
        if ($categoria_abogado_id != '') {$where .= " AND categoria_abogado_id " . $categoria_abogado_id;}        
        if ($activo != '') {$where .= " AND empleados.activo = '" . $activo."' ";}
        if ($acceso != '') {$where .= " AND acceso = '" . $acceso."' ";}
        if ($dni != '') {$where .= " AND dni = '" . $dni."' ";}
                                    
        $sql = "SELECT *, empleados.id AS empleados_id, DATE_FORMAT(fecha_nacimiento, '%d-%m-%Y') AS fecha_nacimiento, 
                empleados.activo AS empleado_activo, empleados.acceso AS empleado_acceso,
                empresas.empresa AS empresa , tipo_horarios.ingreso AS ingreso , tipo_horarios.salida AS salida
                FROM `empleados`
                LEFT JOIN `categoria_abogados` 
                ON (`empleados`.`categoria_abogado_id` = `categoria_abogados`.`id`)      
                INNER JOIN `empresas`
                ON (`empleados`.`empresa_id` = `empresas`.`id`)
                LEFT JOIN `tipo_horarios`
                ON (`empleados`.`tipo_horario_id` = `tipo_horarios`.`id`)
                WHERE 1 = 1 ".$where. " ORDER BY empleados.apellido_paterno, empleados.apellido_materno, empleados.nombre";                        
        
        $query = mysql_query($sql);
        $rows = array();
        while ($row = mysql_fetch_assoc($query)){
            $rows[] = $row;
        }
        return $rows;
    }
    
    
    
    public function select_tipos($administrador = '', $secretaria = '', $socio = '', $abogado = '', $practicante = '', $activo = '', $acceso = ''){
        
        $where = '';
        if ($administrador != '') {$where .= " 1," ;}
        if ($secretaria != '') {$where .= " 2," ;}
        if ($socio != '') {$where .= " 3," ;}
        if ($abogado != '') {$where .= " 4," ;}
        if ($practicante != '') {$where .= " 5," ;}

        if($where != ''){
            $where = substr($where, 0, -1);
            $where  = " AND tipo_empleado_id IN ( " . $where . " )";
        }

        if ($activo != FALSE) {
            $where .= " AND empleados.activo = 'activo'";
        }

        if ($acceso != FALSE) {
            $where .= " AND acceso = 'con acceso'";
        }

        $sql = "SELECT *, empleados.id AS empleados_id, DATE_FORMAT(fecha_nacimiento, '%d-%m-%Y') AS fecha_nacimiento, 
                empleados.activo AS empleado_activo, empleados.acceso AS empleado_acceso
                FROM `empleados`
                INNER JOIN `categoria_abogados` 
                ON (`empleados`.`categoria_abogado_id` = `categoria_abogados`.`id`)
                WHERE 1 = 1 ".$where. "ORDER BY apellido_paterno, apellido_materno, nombre";

        $query = mysql_query($sql);
        $rows = array();
        while ($row = mysql_fetch_assoc($query)){
            $rows[] = $row;
        }
        return $rows;
    }
    
    
    public function select_tipos_recursos($administrador = '', $secretaria = '', $socio = '', $abogado = '', $practicante = '',$contabilidad = '', $sistemas = '',$marketing = '',$otros = '', $activo = '', $acceso = ''){                
        
        $where = '';
        if ($administrador != '') {$where .= " 1," ;}
        if ($secretaria != '') {$where .= " 2," ;}
        if ($socio != '') {$where .= " 3," ;}
        if ($abogado != '') {$where .= " 4," ;}
        if ($practicante != '') {$where .= " 5," ;}
        if ($contabilidad != '') {$where .= " 7," ;}
        if ($sistemas != '') {$where .= " 9," ;}
        if ($marketing != '') {$where .= " 10," ;}
        if ($otros != '') {$where .= " 11," ;}
        
        if($where != ''){
            $where = substr($where, 0, -1);
            $where  = " AND tipo_cargo_id IN ( " . $where . " )";
        }
        if ($activo != FALSE) {
            $where .= " AND empleados.activo = 'activo'";
        }

        if ($acceso != FALSE) {
            $where .= " AND acceso = 'con acceso'";
        }

        $sql = "SELECT *, empleados.id AS empleados_id, DATE_FORMAT(fecha_nacimiento, '%d-%m-%Y') AS fecha_nacimiento, 
                empleados.activo AS empleado_activo, empleados.acceso AS empleado_acceso
                FROM `empleados`
                INNER JOIN `categoria_abogados` 
                ON (`empleados`.`categoria_abogado_id` = `categoria_abogados`.`id`)
                WHERE 1 = 1 ".$where. "ORDER BY apellido_paterno, apellido_materno, nombre";

        $query = mysql_query($sql);
        $rows = array();
        while ($row = mysql_fetch_assoc($query)){
            $rows[] = $row;
        }
        return $rows;
    }
    
    public function verificar_cookie($empleado_id, $cookie){
        $sql = "SELECT *FROM empleados WHERE id = " . $empleado_id . " AND cookie = " . $cookie;
        $query = $this->db->query($sql);
        $row   = $query->row_array(); 
        if(isset($row)){
            return $row['dni'];
        }        
    }

    public function selectAutocomplete($buscar, $tipo_empleado_id = '', $categoria_abogado_id = '', $activo = '', $acceso = '', $where_cutomizado = ''){
        $where = '';
        if ($tipo_empleado_id != '') {$where .= " AND tipo_empleado_id = " . $tipo_empleado_id;}
        if ($categoria_abogado_id != '') {$where .= " AND categoria_abogado_id " . $categoria_abogado_id;}
        if ($activo != '') {$where .= " AND empleados.activo = " . $activo;}
        if ($acceso != '') {$where .= " AND acceso = '" . $acceso."' ";}
        if ($where_cutomizado != '') {$where .= " AND " . $where_cutomizado;}
                
        $sql = "SELECT
                id,
                apellido_paterno,
                apellido_materno,
                nombre
                FROM empleados
                WHERE 1 = 1 AND (
                apellido_paterno LIKE '%$buscar%'
                OR apellido_materno LIKE '%$buscar%'
                OR nombre LIKE '%$buscar%') " . $where . "
                ORDER BY apellido_paterno, apellido_materno, nombre";
        $query = mysql_query($sql);

        $data = array();
        if (mysql_num_rows($query) > 0) {
            while ($tsArray = mysql_fetch_assoc($query)){
                $data[] = array(
                    "value" => $tsArray['apellido_paterno'] . ' ' . $tsArray['apellido_materno'] . ', ' . $tsArray['nombre'],
                    "apellido_paterno" => $tsArray['apellido_paterno'],
                    "apellido_materno" => $tsArray['apellido_materno'],
                    "nombre" => $tsArray['nombre'],
                    "id" => $tsArray['id']
                );
            }
        }
        return $data;
    }
    
    public function selectAutocompleteRemitente($buscar){
        $sql = "SELECT
                DISTINCT(remitente)
                FROM documentos
                WHERE 1 = 1 AND
                remitente LIKE '%$buscar%'                                
                ORDER BY remitente";
        $query = mysql_query($sql);

        $data = array();
        if (mysql_num_rows($query) > 0) {
            while ($tsArray = mysql_fetch_assoc($query)){
                $data[] = array(
                    "value" => $tsArray['remitente']
                );
            }
        }
        return $data;
    }
    
    public function eliminar($empleado_id){
        $sql = "SELECT *FROM actividades WHERE empleado_id = " . $empleado_id;
        $query = mysql_query($sql);
        if(mysql_num_rows($query)>0){
            $this->session->set_flashdata('mensaje', 'No se pudo eliminar el empleado: ' . $this->input->post('apellido_paterno') . ' ' . $this->input->post('apellido_materno'). ', '.$this->input->post('nombre').' porque tiene actividades ingresadas.');    
        }else{
            $sql_eli = "UPDATE empleados SET eliminado = 1 WHERE id = " . $empleado_id;
            mysql_query($sql_eli);
            $this->session->set_flashdata('mensaje', 'Empleado eliminado exitosamente');
        }
    }
    
}