<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Impuesto extends CI_Controller{
	private $nombre;
	private $porcentaje;
	private $tipo;
	private $descripcion;
	
	public function __construct(){
		parent::__construct();
		$this->load->model("impuesto_model");
		$this->load->library("table");
		
		$this->nombre="";
		$this->porcentaje=0;
		$this->tipo="";
		$this->descripcion="";
	}
	
	public function setNombre($nombre){
		$this->nombre = $nombre;
	}
	
	public function getNombre(){
		return $this->nombre;
	}
	
	public function setPorcentaje($porcentaje){
		$this->porcentaje = $porcentaje;
	}
	
	public function getPorcentaje(){
		return $this->porcentaje;                                                                   
	}
	
	public function setTipo($tipo){
		$this->tipo = $tipo;
	}
	
	public function getTipo(){
		return $this->tipo;
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
				'titulo' => 'Impuestos',
				'contenido' => 'backend/impuesto_view'
			);
			$this->load->view("backend/template",$data);
		}
	}
	
	public function guardar(){
		$this->form_validation->set_rules('impuesto_nombre','Nombre','trim|required|xss_clean');
		$this->form_validation->set_rules('impuesto_porcentaje','Porcentaje','trim|required|xss_clean');
		$this->form_validation->set_rules('impuesto_tipo','Tipo','trim|xss_clean');
		$this->form_validation->set_rules('impuesto_descripcion','Descripción','trim|xss_clean');
		
		$this->form_validation->set_message('required','El campo %s es obligatorio');
		
		if($this->form_validation->run() == FALSE){
			$this->index();
		}else{
			$this->setNombre($this->input->post("impuesto_nombre",TRUE));
			$this->setPorcentaje($this->input->post("impuesto_porcentaje",TRUE));
			$this->setTipo($this->input->post("impuesto_tipo",TRUE));
			$this->setDescripcion($this->input->post("impuesto_descripcion",TRUE));
			
			$data = array(
				"impuesto_nombre" => $this->getNombre(),
				"impuesto_porcentaje" => $this->getPorcentaje(),
				"impuesto_tipo" => $this->getTipo(),
				"impuesto_descripcion" => $this->getDescripcion()
			);
			
			$this->impuesto_model->guardar($data);
			redirect("impuesto/datagrid");
		}
	}
	
	#Método para mostrar los registros en un datagrid
	public function datagrid(){
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Login';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {
			$data = array(
				'titulo' => 'Impuestos',
				'contenido' => 'backend/impuesto_datagrid_view',
				'tabla_impuesto' => $this->impuesto_model->datagrid()
			);
			$this->load->view('backend/template',$data);
		}
	}//Fin método datagrid
	
	#Método que elimina un registro de la tabla de impuestos
	public function eliminar(){
		$id = $this->uri->segment(3);
		$this->impuesto_model->eliminar($id);
		redirect("impuesto/datagrid");
	}//Fin método eliminar
	
	#Metodo que retorna los registros al formualrio impuesto_modificar_view
	public function modificar(){
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Login';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {
			$impuesto_id = $this->uri->segment(3);
			$obtenerDatos = $this->impuesto_model->obtenerDatos($impuesto_id);
			
			if($obtenerDatos != FALSE){
				foreach($obtenerDatos as $row){
					$impuesto_nombre = $row->impuesto_nombre;
					$impuesto_porcentaje = $row->impuesto_porcentaje;
					$impuesto_tipo = $row->impuesto_tipo;
					$impuesto_descripcion = $row->impuesto_descripcion;
				}
				
				$data = array(
					'impuesto_id' => $impuesto_id,
					'impuesto_nombre' => $impuesto_nombre,
					'impuesto_porcentaje' => $impuesto_porcentaje,
					'impuesto_tipo' => $impuesto_tipo,
					'impuesto_descripcion' => $impuesto_descripcion,
					'titulo' => 'Impuestos',
					'contenido' => 'backend/impuesto_modificar_view'
				);
				
				$this->load->view('backend/template',$data);
			}else{
				return FALSE;
			}
		}
	}//Fin del método modificar
	
	public function modificarEnlace(){
		$this->form_validation->set_rules('impuesto_nombre','Nombre','trim|required|xss_clean');
		$this->form_validation->set_rules('impuesto_porcentaje','Porcentaje','trim|required|xss_clean');
		$this->form_validation->set_rules('impuesto_tipo','Tipo','trim|xss_clean');
		$this->form_validation->set_rules('impuesto_descripcion','Descripción','trim|xss_clean');
		
		$this->form_validation->set_message('required','El campo %s es obligatorio');
		
		if($this->form_validation->run() == FALSE){
			$this->modificar();
		}else{	
			$id = $this->uri->segment(3);
			$data = array(
				"impuesto_nombre" => $this->input->post("impuesto_nombre",TRUE),
				"impuesto_porcentaje" => $this->input->post("impuesto_porcentaje",TRUE),
				"impuesto_tipo" => $this->input->post("impuesto_tipo",TRUE),
				"impuesto_descripcion" => $this->input->post("impuesto_descripcion",TRUE)
			);
			$this->impuesto_model->modificarEnlace($id,$data);
			redirect("impuesto/datagrid");
		}
	}
	
	public function consultarImpuesto() {
		$id = $this->input->post('id', TRUE);
		$data = $this->impuesto_model->obtenerDatos($id);
		foreach($data as $row){
			echo $row->impuesto_porcentaje/100;
		}
	}
	
}//fin de la clase impuesto