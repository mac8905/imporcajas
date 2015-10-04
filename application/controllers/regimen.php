<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Regimen extends CI_Controller{
	
	private $id;
	private $nombre;
	private $descripcion;
	
	public function __construct(){
		parent::__construct();
		$this->nombre="";
		$this->descrpcion="";
				
		$this->load->model('regimen_model');
		$this->load->library('table');
	}
	
	public function setNombre($nombre){
		$this->nombre = $nombre;
	}
	
	public function getNombre(){
		return $this->nombre;
	}
	
	public function setDescripcion($descripcion){
		$this->descripcion = $descripcion;
	}
	
	public function getDescripcion(){
		return $this->descripcion;
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
				'titulo' => 'Régimen',
				'contenido' => 'backend/regimen_view'
			);
			$this->load->view('backend/template',$data);
		}
	}
	
	#Método que guarda los datos provenientes del formulario
	public function guardarRegimen(){ 
		
		$this->form_validation->set_rules('regimen_nombre','Nombre','trim|required|xss_clean');
		$this->form_validation->set_rules('regimen_descripcion','Descripción','trim|xss_clean');
		
		$this->form_validation->set_message('required','El campo %s es obligatorio');
		
		if($this->form_validation->run() == FALSE){
			$this->index();
		}else{
			$this->setNombre($this->input->post("regimen_nombre",TRUE));
			$this->setDescripcion($this->input->post("regimen_descripcion",TRUE));
			
			$data = array(
				"regimen_nombre" => $this->getNombre(),
				"regimen_descripcion" => $this->getDescripcion()
			);
			
			$this->regimen_model->guardar_regimen($data);
			redirect('regimen/datagrid');
		}
	}// fin método guardarRegimen
	
	#Método que retorna los datos de la consulta y los envia a la vista del cliente y proveedor
	public function consultarRegimen(){
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Login';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {
			$datos = array(
				'titulo' => 'Régimen',
				'contenido' => 'backend/cliente_view',
				'regimen_nom' => $this->regimen_model->consultar_regimen()
			);
			$this->load->view('backend/template',$datos);
		}
	}//Fin del método consultarRegimen
	
	#Método que muestra los datos de la tabla régimen en un datagrid
	public function datagrid(){
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Login';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {
			$data = array(
				'titulo' => 'Régimen',
				'contenido' => 'backend/regimen_datagrid_view',
				'tabla_regimen' => $this->regimen_model->datagrid()
			);
			$this->load->view('backend/template',$data);
		}
	}//Fin del método datagrid
	
	#Método que elimina los registros de régimen
	public function eliminar(){
		$id = $this->uri->segment(3);
		$this->regimen_model->eliminar($id);
		redirect('regimen/datagrid');
	}//fin del método eliminar
	
	#Método que muestra los registros retornados de la base de datos en el formulario modificar-regimen
	public function modificar(){
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Login';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {
			$regimen_id = $this->uri->segment(3);
			$obtenerEnlace = $this->regimen_model->obtenerDatos($regimen_id); 
			
			if($obtenerEnlace != FALSE){
				foreach($obtenerEnlace->result() as $row){
					$regimen_nombre = $row->regimen_nombre;
					$regimen_descripcion = $row->regimen_descripcion;
				}
				
				$datos = array(
					'titulo' => 'Régimen',
					'contenido' => 'backend/regimen_modificar_view',
					'regimen_id' => $regimen_id,
					'regimen_nombre' => $regimen_nombre,
					'regimen_descripcion' => $regimen_descripcion
				);
				
				$this->load->view('backend/template',$datos);
			}else{
				return FALSE;
			}
		}
	}//fin del método modificar
	
	public function modificarEnlace(){
		$this->form_validation->set_rules('regimen_nombre','Nombre','trim|required|xss_clean');
		$this->form_validation->set_rules('regimen_descripcion','Descripción','trim|xss_clean');
		
		$this->form_validation->set_message('required','El campo %s es obligatorio');
		
		if($this->form_validation->run() == FALSE){
			$this->modificar();
		}else{	
			$id = $this->uri->segment(3);
			$data = array(
				"regimen_nombre" => $this->input->post("regimen_nombre",TRUE),
				"regimen_descripcion" => $this->input->post("regimen_descripcion",TRUE)
			);
			$this->regimen_model->modificarEnlace($id,$data);
			redirect('regimen/datagrid');
		}
	}

}// fin de la clase regimen
