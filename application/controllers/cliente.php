<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cliente extends CI_Controller{
	
	private $id;
	private $nombre;
	private $nit;
	private $ciudad;
	private $direccion;
	private $correo;
	private $movil;
	private $fax;
	private $observacion;
	private $telefono;
	private $regimen;
	private $perfilCliente;
	private $perfilProveedor;
	
	public function __construct(){
		parent::__construct();
		$this->id=0;
		$this->nombre="";
		$this->nit=0;
		$this->ciudad="";
		$this->direccion="";
		$this->correo="";
		$this->movil=0;
		$this->fax=0;
		$this->observacion="";
		$this->telefono= array();
		$this->regimen="";
		$this->perfil="";
		
		$this->load->model('cliente_model');
		$this->load->model('regimen_model');
		$this->load->library('table');
		$this->load->library('pagination');
	}
	
	public function setId($id){
		$this->id = $id;
	}

	public function getId(){
		return $this->id;
	}	
	
	public function setNombre($nombre){
		$this->nombre = $nombre;
	}
	
	public function getNombre(){
		return $this->nombre;
	}
	
	public function setNit($nit){
		$this->nit = $nit;
	}
	
	public function getNit(){
		return $this->nit;
	}
	
	public function setCiudad($ciudad){
		$this->ciudad = $ciudad;
	}
	
	public function getCiudad(){
		return $this->ciudad;
	}
	
	public function setDireccion($direccion){
		$this->direccion=$direccion;
	}
	
	public function getDireccion(){
		return $this->direccion;
	}
	
	public function setCorreo($correo){
		$this->correo = $correo;
	}
	
	public function getCorreo(){
		return $this->correo;
	}
	
	public function setMovil($movil){
		$this->movil = $movil;
	}
	
	public function getMovil(){
		return $this->movil;
	}
	
	public function setFax($fax){
		$this->fax = $fax;
	}
	
	public function getFax(){
		return $this->fax;
	}
	
	public function setObservacion($observacion){
		$this->observacion = $observacion;
	}
	
	public function getObservacion(){
		return $this->observacion;
	}
	
	public function setTelefono($telefono){
		$this->telefono = $telefono;
	}
	
	public function getTelefono(){
		return $this->telefono;
	}
	
	public function setRegimen($regimen){
		$this->regimen = $regimen;
	}
	
	public function getRegimen(){
		return $this->regimen;
	}
	
	public function setPerfilCliente($perfil){
		$this->perfil = $perfil;
	}
	
	public function getPerfilCliente(){
		return $this->perfil;
	}
	
	public function setPerfilProveedor($perfilProveedor){
		$this->perfilProveedor = $perfilProveedor;
	}
	
	public function getPerfilProveedor(){
		return $this->perfilProveedor;
	}
	
	//Método que retorna los datos de los contactos a la vista 
	public function consultar(){
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Iniciar Sesión';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {
			$relacion_id = $this->uri->segment(3);
			$obtenerId = $this->cliente_model->mostrar($relacion_id);
			$data = array(
				'titulo' => 'Clientes',
				'contenido' => 'backend/mostrar_cliente_view',
				'consulta_cliente' => $obtenerId
			);
			$this->load->view('backend/template',$data);
		}
	}//Fin del método consultar
	
	public function datagrid(){
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Iniciar Sesión';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {
		#########################################################################
		#				CONFIGURACIONES DE LA TABLA CLIENTE						#
		#########################################################################
			$config['base_url'] = base_url()."cliente/datagrid/";				#
			$config['total_rows'] = $this->cliente_model->getCantidad();		#
			$config['per_page'] = '10'; 										#
			$config['num_links'] = '1';											#
			$config['prev_link'] = 'anterior';									#
			$config['next_link'] = 'siguiente';									#
			$config['uri_segment'] = '3';										#
			$config['first_link'] = '<<';										#
			$config['last_link'] = '>>';										#
			$this->pagination->initialize($config); 							#
		#########################################################################
			$data1 = array(
				'titulo' => 'Clientes',
				'contenido' => 'backend/cliente_datagrid_view',
				'consulta_cliente_datagrid' => $this->cliente_model->getContactos($config['per_page'],$this->uri->segment(3))
			);
			$this->load->view('backend/template',$data1);
		}
	}//Fin del método datagrid

	#Método que elimina los registros de la tabla relacion
	public function eliminar(){
		$id = $this->uri->segment(3);
		$this->cliente_model->eliminar($id);
		redirect('cliente/datagrid');
	}//Fin del método eliminar
	
	#Método que guarda los datos provenientes del formulario Relacion 
	public function guardar() {
		$this->form_validation->set_rules('relacion_nombre','Nombre','trim|required|xss_clean');
		$this->form_validation->set_rules('relacion_nit','Nit','trim|xss_clean');
		$this->form_validation->set_rules('relacion_ciudad','Ciudad','trim|xss_clean');
		$this->form_validation->set_rules('relacion_direccion','Dirección','trim|xss_clean');
		$this->form_validation->set_rules('relacion_correo','Correo','trim|xss_clean');
		$this->form_validation->set_rules('relacion_movil','Móvil','trim|numeric|xss_clean');
		$this->form_validation->set_rules('relacion_fax','Fax','trim|numeric|xss_clean');
		$this->form_validation->set_rules('relacion_observacion','Observación','trim|xss_clean');
		$this->form_validation->set_rules('relacion_telefono[]','Teléfono','trim|numeric|xss_clean');
		$this->form_validation->set_rules('regimen_id','Régimen','trim|xss_clean');
		$this->form_validation->set_rules('relacion_perfil_cliente','perfil_cliente','trim|xss_clean');
		$this->form_validation->set_rules('relacion_perfil_proveedor','perfil_proveedor','trim|xss_clean');
		
		$this->form_validation->set_message('required', 'El campo %s es obligatorio');
		$this->form_validation->set_message('numeric','El campo %s solo admite caracteres numéricos');
		
		if($this->form_validation->run() == FALSE){
			$this->index();
		}else{
			$nombre = $this->input->post("relacion_nombre",TRUE);
			$nit = $this->input->post("relacion_nit",TRUE);
			$ciudad = $this->input->post("relacion_ciudad",TRUE);
			$direccion = $this->input->post("relacion_direccion",TRUE);
			$correo = $this->input->post("relacion_correo",TRUE);
			$movil = $this->input->post("relacion_movil",TRUE);
			$fax = $this->input->post("relacion_fax",TRUE);
			$observacion = $this->input->post("relacion_observacion",TRUE);
			$telefonos = $this->input->post('relacion_telefono',TRUE);
			$regimen = $this->input->post("regimen_id",TRUE);

			if ($this->input->post("relacion_perfil_cliente",TRUE)) {
				$perfilCliente = $this->input->post("relacion_perfil_cliente",TRUE);
			}
			else {
				$perfilCliente = 0;	
			}
			if ($this->input->post("relacion_perfil_proveedor",TRUE)) {
				$perfilProveedor = $this->input->post("relacion_perfil_proveedor",TRUE);
			} else {
				$perfilProveedor = 0;
			}
			
			$this->setNombre($nombre);
			$this->setNit($nit);
			$this->setCiudad($ciudad);
			$this->setDireccion($direccion);
			$this->setCorreo($correo);
			$this->setMovil($movil);
			$this->setFax($fax);
			$this->setObservacion($observacion);
			$this->setTelefono($telefonos);
			$this->setRegimen($regimen);
			$this->setPerfilCliente($perfilCliente);
			$this->setPerfilProveedor($perfilProveedor);
			
			$cliente = array(
				"relacion_nombre" => $this->getNombre(),
				"relacion_nit" => $this->getNit(),
				"relacion_ciudad" => $this->getCiudad(),
				"relacion_direccion" =>$this->getDireccion(),
				"relacion_correo" => $this->getCorreo(),
				"relacion_movil" => $this->getMovil(),
				"relacion_fax" => $this->getFax(),
				"relacion_observacion" => $this->getObservacion(),
				"regimen_id" => $this->getRegimen()
			);
			
			$perfil = array(
				"relacion_perfil_cliente" => $this->getPerfilCliente(),
				"relacion_perfil_proveedor" => $this->getPerfilProveedor() 
			);
			
			$this->cliente_model->guardar($cliente);
			$this->cliente_model->guardarTelefono($this->getTelefono(), $cliente);
			$this->cliente_model->guardar_perfil($cliente, $perfil);
			redirect('cliente/datagrid');
		}
	} //Fin del método guardar

	public function index(){
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Iniciar Sesión';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {
			$data = array(
				'titulo' => 'Clientes',
				'contenido' => 'backend/cliente_view',
				'regimen_nom' => $this->regimen_model->consultar_regimen()
			);
			$this->load->view('backend/template',$data);
		}
	}
	
	#Retorna un registro de la tabla relacion para ser modificado
	public function modificar(){
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Iniciar Sesión';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {
			$relacion_id = $this->uri->segment(3);
			$obtenerCliente = $this->cliente_model->mostrarCliente($relacion_id);
				
			if($obtenerCliente != FALSE){
				foreach($obtenerCliente->result() as $row) {
					if ($obtenerCliente->num_fields()==12) {
						$telefonor_numero = $row->telefonor_numero;
					} else {
						$telefonor_numero = 0;
					}
					$relacion_id = $row->relacion_id;
					$relacion_nombre = $row->relacion_nombre;
					$regimen_id = $row->regimen_id;
					$relacion_nit = $row->relacion_nit;
					$relacion_ciudad = $row->relacion_ciudad;
					$relacion_direccion = $row->relacion_direccion;
					$relacion_correo = $row->relacion_correo;
					$relacion_movil = $row->relacion_movil;
					$relacion_fax = $row->relacion_fax;
					$relacion_observacion = $row->relacion_observacion;
					$perfil_relacion = $row->perfilrelacion_id;
				}
				
				$telefonos = explode(",", $telefonor_numero);
				$perfil = explode(",", $perfil_relacion);

				$data3 = array(
					'relacion_id'=> $relacion_id,
					'relacion_nombre'=> $relacion_nombre,
					'relacion_ciudad'=> $relacion_ciudad,
					'relacion_nit'=> $relacion_nit,
					'relacion_direccion'=> $relacion_direccion,
					'relacion_correo' => $relacion_correo,
					'relacion_movil' => $relacion_movil,
					'relacion_fax' => $relacion_fax,
					'relacion_observacion' => $relacion_observacion,
					'relacion_regimen' => $regimen_id,
					'telefonor_numero' => $telefonos,
					'perfil' => $perfil,
					'consulta_regimen' => $this->regimen_model->consultar_regimen(),
					'titulo' => 'Clientes',
					'contenido' => 'backend/modificar_cliente_view',
				);

				$this->load->view('backend/template',$data3);
			}
			else{
				return FALSE;
			}
		}
	}//Fin del método modificar
	
	#Modifica o actualiza los datos de la tabla relación
	public function modificarEnlace() {
		$id = $this->uri->segment(3);
		$telefonos = $this->input->post('relacion_telefono',TRUE);
		$cliente = array(
			"relacion_nombre" => $this->input->post("relacion_nombre", TRUE),
			"relacion_nit" => $this->input->post("relacion_nit", TRUE),
			"relacion_ciudad" => $this->input->post("relacion_ciudad", TRUE),
			"relacion_direccion" => $this->input->post("relacion_direccion", TRUE),
			"relacion_correo" => $this->input->post("relacion_correo", TRUE),
			"relacion_fax" => $this->input->post("relacion_fax",TRUE),
			"relacion_observacion" => $this->input->post("relacion_observacion",TRUE),
			"regimen_id" => $this->input->post("regimen_id",TRUE)
		);
		
		if ($this->input->post("relacion_perfil_cliente",TRUE)) {
			$perfilCliente = $this->input->post("relacion_perfil_cliente",TRUE);
		}
		else {
			$perfilCliente = 0;	
		}
		if ($this->input->post("relacion_perfil_proveedor",TRUE)) {
			$perfilProveedor = $this->input->post("relacion_perfil_proveedor",TRUE);
		} else {
			$perfilProveedor = 0;
		}

		$perfiles = array(
			"relacion_perfil_cliente" => $perfilCliente,
			"relacion_perfil_proveedor" => $perfilProveedor
		);
		
		$this->cliente_model->modificarCliente($id, $cliente);
		$this->cliente_model->modificarPerfil($id, $perfiles);
		$this->cliente_model->modificarTelefono($telefonos, $id);
		redirect('cliente/datagrid');
	}//fin de modificarEnlace	
}// Fin de la clase