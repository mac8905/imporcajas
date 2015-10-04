<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tiporetencion extends CI_Controller{
	
	private $nombre;
	private $descripcion;
	
	function __construct(){
		parent::__construct();
		$this->load->model("tiporetencion_model");
		$this->load->library("table");
		
		$this->nombre = "";
		$this->descripcion = "";
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
				'titulo' => 'Tipo',
				'contenido' => 'backend/tiporetencion_view'
			);
			$this->load->view('backend/template',$data);
		}
	}
	
	public function guardar(){
		
		$this->form_validation->set_rules('tiporetencion_nombre','Nombre','trim|required|xss_clean');
		$this->form_validation->set_rules('tiporetencion_descripcion','Descripción','trim|xss_clean');
		
		$this->form_validation->set_message('required','El campo %s es obligatorio');
		
		if($this->form_validation->run() == FALSE){
			$this->index();
		}else{
			$this->setNombre($this->input->post("tiporetencion_nombre",TRUE));
			$this->setDescripcion($this->input->post("tiporetencion_descripcion",TRUE));
			
			$data = array(
				"tiporetencion_nombre" => $this->getNombre(),
				"tiporetencion_descripcion" => $this->getDescripcion()
			);
			
			$this->tiporetencion_model->guardar($data);
			redirect("tiporetencion/datagrid");
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
			$data = array(
				'titulo' => 'Tipo',
				'contenido' => 'backend/tiporetencion_datagrid_view',
				'tabla_tiporetencion' => $this->tiporetencion_model->datagrid()
			);
			$this->load->view("backend/template",$data);
		}
	}
	
	public function eliminar(){
		$id = $this->uri->segment(3);
		$this->tiporetencion_model->eliminar($id);
		redirect("tiporetencion/datagrid");
	}
	
	public function modificar(){
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Login';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {
			$tiporetencion_id = $this->uri->segment(3);
			$obtenerDatos = $this->tiporetencion_model->modificar($tiporetencion_id);
			
			if($obtenerDatos != FALSE){
				foreach($obtenerDatos as $row){
					$tiporetencion_nombre = $row->tiporetencion_nombre;
					$tiporetencion_descripcion = $row->tiporetencion_descripcion;
				}
				
				$data = array(
					'tiporetencion_id' => $tiporetencion_id,
					'tiporetencion_nombre' => $tiporetencion_nombre,
					'tiporetencion_descripcion' => $tiporetencion_descripcion,
					'titulo' => 'Tipo',
					'contenido' => 'backend/tiporetencion_modificar_view',
				);
				
				$this->load->view("backend/template",$data);
			}else{
				return FALSE;
			}
		}
	}
	
	public function modificarEnlace(){
		$this->form_validation->set_rules('tiporetencion_nombre','Nombre','trim|required|xss_clean');
		$this->form_validation->set_rules('tiporetencion_descripcion','Descripción','trim|xss_clean');
		
		$this->form_validation->set_message('required','El campo %s es obligatorio');
		
		if($this->form_validation->run() == FALSE){
			$this->modificar();
		}else{	
			$id = $this->uri->segment(3);
			
			$data = array(
				"tiporetencion_nombre" => $this->input->post("tiporetencion_nombre",TRUE),
				"tiporetencion_descripcion" => $this->input->post("tiporetencion_descripcion",TRUE)
			);
		
			$this->tiporetencion_model->modificarEnlace($id,$data);
			redirect("tiporetencion/datagrid");
		}
	}
	
}//Fin de la calse