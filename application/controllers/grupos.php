<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Grupos extends CI_Controller{
	private $id;
	private $nombre;
	private $descripcion;
	
	function __construct(){
		parent::__construct();
		$this->load->model("grupos_model");
		$this->load->library("table");
		
		$this->id = 0;
		$this->nombre = "";
		$this->descripcion = "";
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
				'titulo' => 'Plan Único de Cuentas',
				'contenido' => 'backend/grupos_view',
			);
			$this->load->view("backend/template",$data);
		}
	}
	
	public function guardar(){
		$this->form_validation->set_rules('grupo_numero','Número','trim|required|numeric|exact_length[2]|xss_clean');
		$this->form_validation->set_rules('grupo_nombre','Nombre','trim|required|xss_clean');
		$this->form_validation->set_rules('grupo_descripcion','Descripción','trim|xss_clean');
		
		$this->form_validation->set_message('required','El campo %s es obligatorio');
		$this->form_validation->set_message('numeric','El campo %s solo permite valores numéricos');
		$this->form_validation->set_message('exact_length','El campo %s permite exactamente 2 valores numéricos');
		
		if($this->form_validation->run() == FALSE){
		$this->index();
		}else{
			$this->setId($this->input->post("grupo_numero",TRUE));
			$this->setNombre($this->input->post("grupo_nombre",TRUE));
			$this->setDescripcion($this->input->post("grupo_descripcion",TRUE));
			
			$data = array(
				"puc_id" => $this->getId(),
				"puc_nombre" => $this->getNombre(),
				"puc_descripcion" => $this->getDescripcion()
			);
			
			$this->grupos_model->guardar($data);
			redirect('puc/index');
		}
	}// fin de la función guardar
	
	public function consultar(){
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Login';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {
			$grupo_id = $this->uri->segment(3);
			$obtenerDatos = $this->grupos_model->consultar($grupo_id);
			$data = array(
				'titulo' => 'Plan Único de Cuentas',
				'contenido' => 'backend/grupo_mostrar_view',
				'consulta_grupo' => $obtenerDatos 
			);
			$this->load->view("backend/template",$data);
		}
	}
	
	public function modificar(){
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Login';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {
			$grupo_id = $this->uri->segment(3);
			$obtenerDatos = $this->grupos_model->modificar($grupo_id);
			
			foreach($obtenerDatos->result() as $row){
				$grupo_id = $row->puc_id;
				$grupo_nombre = $row->puc_nombre;
				$grupo_descripcion = $row->puc_descripcion;
			}
			
			$data = array(
				'puc_id' => $grupo_id,
				'puc_nombre' => $grupo_nombre,
				'puc_descripcion' => $grupo_descripcion,
				'titulo' => 'Plan Único de Cuentas',
				'contenido' => 'backend/grupo_modificar_view'
			);
			$this->load->view("backend/template",$data);
		}
	}
	
	public function modificarDatos(){
		$this->form_validation->set_rules('grupo_numero','Número','trim|required|numeric|exact_length[2]|xss_clean');
		$this->form_validation->set_rules('grupo_nombre','Nombre','trim|required|xss_clean');
		$this->form_validation->set_rules('grupo_descripcion','Descripción','trim|xss_clean');
		
		$this->form_validation->set_message('required','El campo %s es obligatorio');
		$this->form_validation->set_message('numeric','El campo %s solo permite valores numéricos');
		$this->form_validation->set_message('exact_length','El campo %s permite exactamente 2 valores numéricos');
		
		if($this->form_validation->run() == FALSE){
		$this->modificar();
		}else{
			$grupo_id = $this->uri->segment(3);

			$data = array(
				'puc_id' => $this->input->post("grupo_numero",TRUE),
				'puc_nombre' => $this->input->post("grupo_nombre",TRUE),
				'puc_descripcion' => $this->input->post("grupo_descripcion",TRUE)
			);
			$this->grupos_model->modificarDatos($grupo_id,$data); 
			redirect("puc/index");
		}
	}
	
	public function eliminar(){
		$grupo_id = $this->uri->segment(3);
		$this->grupos_model->eliminar($grupo_id);
		redirect("puc/index");
	}
	
}// fin de la clase