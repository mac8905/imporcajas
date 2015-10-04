<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MetodoPago extends CI_Controller{
	
	private $id;
	private $nombre;
	private $descripcion;
	
	public function __construct(){
		parent::__construct();
		$this->load->model('metodopago_model');
		$this->load->library('table');
		
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
				'titulo' => 'Método',
				'contenido' => 'backend/metodopago_view'
			);
			$this->load->view('backend/template',$data);
		}
	}
	
	public function guardar(){
		$this->form_validation->set_rules('metodopago_nombre','Nombre','trim|required|xss_clean');
		$this->form_validation->set_rules('metodopago_descripcion','Descripción','trim|xss_clean');
		
		$this->form_validation->set_message('required','El campo %s es obligatorio');
		if($this->form_validation->run() == FALSE){
			$this->index();
		}else{
			$this->setNombre($this->input->post('metodopago_nombre',TRUE));
			$this->setDescripcion($this->input->post('metodopago_descripcion',TRUE));
			$data = array(
				'metodopago_nombre' => $this->getNombre(),
				'metodopago_descripcion' => $this->getDescripcion()
			);
			$this->metodopago_model->guardar($data);
			redirect('metodopago/datagrid');
		}
	}//fin de la funcion guardar
	
	#Método que muestra los datos de la tabla metodopago en un datagrid
	public function datagrid(){
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Login';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {
			$data = array(
				'titulo' => 'Método',
				'contenido' => 'backend/metodopago_datagrid_view',
				'tabla_metodopago' => $this->metodopago_model->datagrid()
			);
			$this->load->view('backend/template',$data);
		}
	}//Fin del método datagrid
	
	public function eliminar(){
		$obtenerId = $this->uri->segment(3);
		$this->metodopago_model->eliminar($obtenerId);
		redirect('metodopago/datagrid');
	}
	
	public function modificar(){
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Login';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {
			$metodopago_id = $this->uri->segment(3);
			$obtenerDatos = $this->metodopago_model->modificar($metodopago_id);
			
			if($obtenerDatos != false){
				foreach($obtenerDatos->result() as $row){
					$metodopago_nombre = $row->metodopago_nombre;
					$metodopago_descripcion = $row->metodopago_descripcion;
				}
				
				$data = array(
					'titulo' => 'Método',
					'contenido' => 'backend/metodopago_modificar_view',
					'metodopago_id' => $metodopago_id,
					'metodopago_nombre' => $metodopago_nombre,
					'metodopago_descripcion' => $metodopago_descripcion
				);
				$this->load->view('backend/template',$data);
			}else{
				return FALSE;
			}
		}
	}
	
	public function modificarDatos(){
		$this->form_validation->set_rules('metodopago_nombre','Nombre','trim|required|xss_clean');
		$this->form_validation->set_rules('metodopago_descripcion','Descripción','trim|xss_clean');
		
		$this->form_validation->set_message('required','El campo %s es obligatorio');
		if($this->form_validation->run() == FALSE){
			$this->modificar();
		}else{	
			$id = $this->uri->segment(3);
			$this->setNombre($this->input->post('metodopago_nombre',TRUE));
			$this->setDescripcion($this->input->post('metodopago_descripcion',TRUE));
			$data = array(
				'metodopago_nombre' => $this->getNombre(),
				'metodopago_descripcion' => $this->getDescripcion()
			);
			$this->metodopago_model->modificarDatos($id,$data);
			redirect('metodopago/datagrid');
		}
	}
	
}// fin de la clase