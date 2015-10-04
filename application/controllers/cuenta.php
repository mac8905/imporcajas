<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cuenta extends CI_Controller{
	private $id;
	private $nombre;
	private $descripcion;
	
	function __construct(){
		parent::__construct();
		$this->load->model("cuenta_model");
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
				'contenido' => 'backend/cuenta_view'
			);
			$this->load->view("backend/template",$data);
		}
	}
	
	public function guardar(){
		$this->form_validation->set_rules('cuenta_numero','Número','trim|required|numeric|exact_length[4]|xss_clean');
		$this->form_validation->set_rules('cuenta_nombre','Nombre','trim|required|xss_clean');
		$this->form_validation->set_rules('cuenta_descripcion','Descripción','trim|xss_clean');
		
		$this->form_validation->set_message('required','El campo %s es obligatorio');
		$this->form_validation->set_message('numeric','El campo %s solo permite valores numéricos');
		$this->form_validation->set_message('exact_length','El campo %s permite exactamente 4 valores numéricos');
		
		if($this->form_validation->run() == FALSE){
			$this->index();
		}else{
			$this->setId($this->input->post("cuenta_numero",TRUE));
			$this->setNombre($this->input->post("cuenta_nombre",TRUE));
			$this->setDescripcion($this->input->post("cuenta_descripcion",TRUE));
			
			$data = array(
				"puc_id" => $this->getId(),
				"puc_nombre" => $this->getNombre(),
				"puc_descripcion" => $this->getDescripcion()
			);
			
			$this->cuenta_model->guardar($data);
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
			$cuenta_id = $this->uri->segment(3);
			$obtenerDatos = $this->cuenta_model->consultar($cuenta_id);
			$data = array(
				'titulo' => 'Plan Único de Cuentas',
				'contenido' => 'backend/cuenta_mostrar_view',
				'consulta_cuenta' => $obtenerDatos 
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
			$cuenta_id = $this->uri->segment(3);
			$obtenerDatos = $this->cuenta_model->modificar($cuenta_id);
			
			foreach($obtenerDatos->result() as $row){
				$cuenta_id = $row->puc_id;
				$cuenta_nombre = $row->puc_nombre;
				$cuenta_descripcion = $row->puc_descripcion;
			}
			
			$data = array(
				'cuenta_id' => $cuenta_id,
				'cuenta_nombre' => $cuenta_nombre,
				'cuenta_descripcion' => $cuenta_descripcion,
				'titulo' => 'Plan Único de Cuentas',
				'contenido' => 'backend/cuenta_modificar_view'
			);
			$this->load->view("backend/template",$data);
		}
	}
	
	public function modificarDatos(){
		$this->form_validation->set_rules('cuenta_numero','Número','trim|required|numeric|exact_length[4]|xss_clean');
		$this->form_validation->set_rules('cuenta_nombre','Nombre','trim|required|xss_clean');
		$this->form_validation->set_rules('cuenta_descripcion','Descripción','trim|xss_clean');
		
		$this->form_validation->set_message('required','El campo %s es obligatorio');
		$this->form_validation->set_message('numeric','El campo %s solo permite valores numéricos');
		$this->form_validation->set_message('exact_length','El campo %s permite exactamente 4 valores numéricos');
		
		if($this->form_validation->run() == FALSE){
			$this->modificar();
		}else{
			$cuenta_id = $this->uri->segment(3);
			$data = array(
				'puc_id' => $this->input->post("cuenta_numero",TRUE),
				'puc_nombre' => $this->input->post("cuenta_nombre",TRUE),
				'puc_descripcion' => $this->input->post("cuenta_descripcion",TRUE)
			);
			$this->cuenta_model->modificarDatos($cuenta_id,$data); 
			redirect("puc/index");
		}
	}
	
	public function eliminar(){
		$cuenta_id = $this->uri->segment(3);
		$this->cuenta_model->eliminar($cuenta_id);
		redirect("puc/index");
	}
	
}