<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario extends CI_Controller{

	private $nombre;
	private $password;
	private $ciudad;
	private $direccion;
	private $correo;
	private $movil;
	private $telefono;
	private $perfil;
	private $estado;
	
	public function __construct(){
		parent::__construct();
		$this->nombre = "";
		$this->password = "";
		$this->ciudad = "";
		$this->direccion = "";
		$this->correo = "";
		$this->movil = "";
		$this->telefono = "";
		$this->perfil = 0;
		$this->estado = "";
			
		$this->load->model('usuario_model');
		$this->load->library('table');
		$this->load->library('pagination');
		$this->load->library('encrypt');
	}
	
	public function setNombre($nombre){
		$this->nombre = $nombre;
	}
	
	public function getNombre(){
		return $this->nombre;
	}
	
	public function setPassword($password){
		$this->password = $password;
	}
	
	public function getPassword(){
		return $this->password;
	}
	
	public function setCiudad($ciudad){
		$this->ciudad = $ciudad;
	}
	
	public function getCiudad(){
		return $this->ciudad;
	}
	
	public function setDireccion($direccion){
		$this->direccion = $direccion;
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
	
	public function setTelefono($telefono){
		$this->telefono = $telefono;
	}
	
	public function getTelefono(){
		return $this->telefono;
	}
	
	public function setPerfil($perfil){
		$this->perfil = $perfil;
	}
	
	public function getPerfil(){
		return $this->perfil;
	}
	
	public function setEstado($estado){
		$this->estado = $estado;
	}
	
	public function getEstado(){
		return $this->estado;
	}

	public function index(){
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Login';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {
			$data = array(
				'titulo' => 'Usuarios',
				'contenido' => "backend/usuario_view",
				'consulta_perfil' => $this->usuario_model->consultarPerfil() 
			);
			$this->load->view("backend/template",$data);
		}
	}
	
	public function datagrid(){
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Login';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {
			$config['base_url'] = base_url()."usuario/datagrid/";
			$config['total_rows'] = $this->usuario_model->totalRegistros();//obtenemos la cantidad de registros
			$config['per_page'] = '10';  //cantidad de registros por página
			$config['num_links'] = '2'; //nro. de enlaces antes y después de la pagina actual
			$config['prev_link'] = 'anterior'; //texto del enlace que nos lleva a la pagina ant.
			$config['next_link'] = 'siguiente'; //texto del enlace que nos lleva a la sig. página
			$config['uri_segment'] = '3';  //segmentos que va a tener nuestra URL
			$config['first_link'] = '<<';  //texto del enlace que nos lleva a la primer página
			$config['last_link'] = '>>';   //texto del enlace que nos lleva a la última página
			
			$this->pagination->initialize($config); 
			
			$data1 = array(
				'titulo' => 'Usuarios',
				'contenido' => 'backend/usuario_datagrid_view',
				'consulta_usuario_datagrid' => $this->usuario_model->datagrid($config['per_page'],$this->uri->segment(3))
			);
			$this->load->view('backend/template',$data1);
		}
	}//Fin del método datagrid
	
	#Guardar los datos del usuario
	public function guardar(){
	
		$this->form_validation->set_rules('usuario_nombre','Nombre','trim|required|xss_clean');
		$this->form_validation->set_rules('usuario_password','Contraseña','trim|required|min_length[8]|xss_clean');
		$this->form_validation->set_rules('usuario_ciudad','Ciudad','trim|xss_clean');
		$this->form_validation->set_rules('usuario_direccion','Dirección','trim|xss_clean');
		$this->form_validation->set_rules('usuario_correo','Correo','trim|xss_clean');
		$this->form_validation->set_rules('usuario_movil','Móvil','trim|numeric|xss_clean');
		$this->form_validation->set_rules('usuario_telefono','Teléfono','trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('perfil_id','Perfil','trim|xss_clean');
		$this->form_validation->set_rules('usuario_estado','Estado','trim|xss_clean');
		
		$this->form_validation->set_message('required','El campo %s es obligatorio');
		$this->form_validation->set_message('numeric','El campo %s solo admite caracteres numéricos');
		$this->form_validation->set_message('min_length','El campo %s debe contener mínimo 8 caracteres');
		
		if($this->form_validation->run() == FALSE){
			$this->index();
		}else{
			$password = $this->input->post("usuario_password",TRUE);
			$hash = sha1($password);
			
			$this->setNombre($this->input->post("usuario_nombre",TRUE));
			$this->setPassword($hash);
			$this->setCiudad($this->input->post("usuario_ciudad",TRUE));
			$this->setDireccion($this->input->post("usuario_direccion",TRUE));
			$this->setCorreo($this->input->post("usuario_correo",TRUE));
			$this->setMovil($this->input->post("usuario_movil",TRUE));
			$this->setTelefono($this->input->post("usuario_telefono",TRUE));
			$this->setPerfil($this->input->post("perfil_id",TRUE));
			$this->setEstado($this->input->post("usuario_estado",TRUE));
			
			$data = array(
				'usuario_nombre' => $this->getNombre(),
				'usuario_password' => $this->getPassword(),
				'usuario_ciudad' => $this->getCiudad(),
				'usuario_direccion' => $this->getDireccion(),
				'usuario_correo' => $this->getCorreo(),
				'usuario_movil' => $this->getMovil(),
				'perfil_id' => $this->getPerfil(),
				'usuario_estado' => $this->getEstado()
			);
			
			$this->usuario_model->guardar($data,$this->getTelefono());
			redirect("usuario/datagrid");
		}
	}
	
	public function eliminar(){
		$usuario_id = $this->uri->segment(3);
		$this->usuario_model->eliminar($usuario_id);
		redirect('usuario/datagrid');
	}
	
	public function modificar(){
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Login';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {
			$usuario_id = $this->uri->segment(3);
			$obtenerDatos = $this->usuario_model->modificar($usuario_id);
			
			foreach($obtenerDatos->result() as $row){
				$usuario_nombre = $row->usuario_nombre;
				//$usuario_password = $row->usuario_password;
				$usuario_perfil = $row->perfil_id;
				$usuario_ciudad = $row->usuario_ciudad;
				$usuario_direccion = $row->usuario_direccion;
				$usuario_correo = $row->usuario_correo;
				$usuario_movil = $row->usuario_movil;
				$usuario_telefono = $row->telefono_numero;
			}
			
			$data = array(
				'usuario_id' => $usuario_id,
				'usuario_nombre' => $usuario_nombre,
				//'usuario_password' => $usuario_password,
				'perfil_nombre' => $usuario_perfil,
				'usuario_ciudad' => $usuario_ciudad,
				'usuario_direccion' => $usuario_direccion,
				'usuario_correo' => $usuario_correo,
				'usuario_movil' => $usuario_movil,
				'usuario_telefono' => $usuario_telefono,
				'consulta_perfil' => $this->usuario_model->consultarPerfil(),
				'titulo' => 'Usuarios',
				'contenido' => 'backend/usuario_modificar_view'
			);
			$this->load->view("backend/template",$data);
		}
	}
	
	public function modificarDatos(){
		$this->form_validation->set_rules('usuario_nombre','Nombre','trim|required|xss_clean');
		$this->form_validation->set_rules('usuario_ciudad','Ciudad','trim|xss_clean');
		$this->form_validation->set_rules('usuario_direccion','Dirección','trim|xss_clean');
		$this->form_validation->set_rules('usuario_correo','Correo','trim|xss_clean');
		$this->form_validation->set_rules('usuario_movil','Móvil','trim|numeric|xss_clean');
		$this->form_validation->set_rules('usuario_telefono','Teléfono','trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('perfil_id','Perfil','trim|xss_clean');
		$this->form_validation->set_rules('usuario_estado','Estado','trim|xss_clean');
		
		$this->form_validation->set_message('required','El campo %s es obligatorio');
		$this->form_validation->set_message('numeric','El campo %s solo admite caracteres numéricos');
		$this->form_validation->set_message('min_length','El campo %s debe contener mínimo 8 caracteres');
		
		if($this->form_validation->run() == FALSE){
			$this->modificar();
		}else{
			$usuario_id = $this->uri->segment(3);
			//$password = $this->input->post("usuario_password",TRUE);
			//$hash = sha1($password);
			$data = array(
				'usuario_nombre' => $this->input->post("usuario_nombre",TRUE),
				//'usuario_password' => $hash,
				'perfil_id' => $this->input->post("perfil_id",TRUE),
				'usuario_ciudad' => $this->input->post("usuario_ciudad",TRUE),
				'usuario_direccion' => $this->input->post("usuario_direccion",TRUE),
				'usuario_correo' => $this->input->post("usuario_correo",TRUE),
				'usuario_movil' => $this->input->post("usuario_movil",TRUE)
			);
			
			$data1 = array(
				'telefono_numero' => $this->input->post("usuario_telefono",TRUE)
			);
			$this->usuario_model->modificarDatos($usuario_id,$data,$data1); 
			redirect("usuario/datagrid");
		}
	}
	
	public function modificarContrasena(){
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Login';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {
			$usuario_id = $this->uri->segment(3);
			//$password = $this->input->post("usuario_password",TRUE);
			//$hash = sha1($password);
			$data = array(
				//'usuario_password' => $hash,
				'usuario_id' => $usuario_id,
				'titulo' => 'Usuarios',
				'contenido' => 'backend/usuario_modificarcontrasena_view'
			);
			$this->load->view("backend/template",$data);
		}
	}
	
	public function modificarDatosContrasena(){
		$this->form_validation->set_rules('usuario_password','Contraseña','trim|required|min_length[8]|xss_clean');
		
		$this->form_validation->set_message('required','El campo %s es obligatorio');
		$this->form_validation->set_message('min_length','El campo %s debe contener mínimo 8 caracteres');
		
		if($this->form_validation->run() == FALSE){
			$this->modificarContrasena();
		}else{	
			$usuario_id = $this->uri->segment(3);
			$password = $this->input->post("usuario_password",TRUE);
			$hash = sha1($password);
			$data =array(
				'usuario_password' => $hash
			);
			$this->usuario_model->modificarContrasena($usuario_id,$data);
			redirect("usuario/datagrid");
		}
	}
	
	public function consultar(){
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Login';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {
			$usuario_id = $this->uri->segment(3);
			$obtenerId= $this->usuario_model->consultar($usuario_id);
			$data = array(
				'titulo' => 'Usuarios',
				'contenido' => 'backend/usuario_mostrar_view',
				'consulta_usuario' => $obtenerId
			);
			$this->load->view("backend/template",$data);
		}
	}

}// fin de la clase usuario