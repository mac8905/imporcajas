<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subcuenta extends CI_Controller{
	private $id;
	private $nombre;
	private $descripcion;
	
	function __construct(){
		parent::__construct();
		$this->load->model("subcuenta_model");
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
				'contenido' => 'backend/subcuenta_view',
			);
			$this->load->view("backend/template",$data);
		}
	}
	
	public function guardar(){
		$this->form_validation->set_rules('subcuenta_numero','Número','trim|required|numeric|exact_length[6]|xss_clean');
		$this->form_validation->set_rules('subcuenta_nombre','Nombre','trim|required|xss_clean');
		$this->form_validation->set_rules('subcuenta_descripcion','Descripción','trim|xss_clean');
		
		$this->form_validation->set_message('required','El campo %s es obligatorio');
		$this->form_validation->set_message('numeric','El campo %s solo permite valores numéricos');
		$this->form_validation->set_message('exact_length','El campo %s permite exactamente 6 valores numéricos');
		
		if($this->form_validation->run() == FALSE){
		$this->index();
		}else{
			$this->setId($this->input->post("subcuenta_numero",TRUE));
			$this->setNombre($this->input->post("subcuenta_nombre",TRUE));
			$this->setDescripcion($this->input->post("subcuenta_descripcion",TRUE));
			
			$data = array(
				"puc_id" => $this->getId(),
				"puc_nombre" => $this->getNombre(),
				"puc_descripcion" => $this->getDescripcion()
			);
			
			$this->subcuenta_model->guardar($data);
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
			$subcuenta_id = $this->uri->segment(3);
			$obtenerDatos = $this->subcuenta_model->consultar($subcuenta_id);
			$data = array(
				'titulo' => 'Plan Único de Cuentas',
				'contenido' => 'backend/subcuenta_mostrar_view',
				'consulta_subcuenta' => $obtenerDatos 
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
			$subcuenta_id = $this->uri->segment(3);
			$obtenerDatos = $this->subcuenta_model->modificar($subcuenta_id);
			
			foreach($obtenerDatos->result() as $row){
				$subcuenta_id = $row->puc_id;
				$subcuenta_nombre = $row->puc_nombre;
				$subcuenta_descripcion = $row->puc_descripcion;
			}
			
			$data = array(
				'subcuenta_id' => $subcuenta_id,
				'subcuenta_nombre' => $subcuenta_nombre,
				'subcuenta_descripcion' => $subcuenta_descripcion,
				'titulo' => 'Plan Único de Cuentas',
				'contenido' => 'backend/subcuenta_modificar_view'
			);
			$this->load->view("backend/template",$data);
		}
	}
	
	public function modificarDatos(){
		$this->form_validation->set_rules('subcuenta_numero','Número','trim|required|numeric|exact_length[6]|xss_clean');
		$this->form_validation->set_rules('subcuenta_nombre','Nombre','trim|required|xss_clean');
		$this->form_validation->set_rules('subcuenta_descripcion','Descripción','trim|xss_clean');
		
		$this->form_validation->set_message('required','El campo %s es obligatorio');
		$this->form_validation->set_message('numeric','El campo %s solo permite valores numéricos');
		$this->form_validation->set_message('exact_length','El campo %s permite exactamente 6 valores numéricos');
		
		if($this->form_validation->run() == FALSE){
			$this->modificar();
		}else{
			$subcuenta_id = $this->uri->segment(3);

			$data = array(
				'puc_id' => $this->input->post("subcuenta_numero",TRUE),
				'puc_nombre' => $this->input->post("subcuenta_nombre",TRUE),
				'puc_descripcion' => $this->input->post("subcuenta_descripcion",TRUE)
			);
			$this->subcuenta_model->modificarDatos($subcuenta_id,$data); 
			redirect("puc/index");
		}
	}
	
	public function eliminar(){
		$subcuenta_id = $this->uri->segment(3);
		$this->subcuenta_model->eliminar($subcuenta_id);
		redirect("puc/index");
	}
	
}// fin de la clase