<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Retencion extends CI_Controller{
	
	private $tipo;
	private $nombre;
	private $base_uvt;
	private $base_pesos;
	private $porcentaje;
	private $descripcion;
	
	public function __construct(){
		parent::__construct();
		
		$this->tipo = 0;
		$this->nombre = "";
		$this->base_uvt = 0;
		$this->base_pesos = 0;
		$this->porcentaje = 0.0;
		$this->descripcion = "";
		
		$this->load->model("retencion_model");
		$this->load->model("tiporetencion_model");
		$this->load->library("Table");
	}
	
	public function setTipo($tipo){
		$this->tipo=$tipo;
	}
	
	public function getTipo(){
		return $this->tipo;
	}

	public function setNombre($nombre){
		$this->nombre = $nombre;
	}
	
	public function getNombre(){
		return $this->nombre;
	}

	public function setBase_uvt($base_uvt){
		$this->base_uvt = $base_uvt;
	}
	
	public function getBase_uvt(){
		return $this->base_uvt;
	}
	
	public function setBase_pesos($base_pesos){
		$this->base_pesos = $base_pesos;
	}
	
	public function getBase_pesos(){
		return $this->base_pesos;
	}
	
	public function setPorcentaje($porcentaje){
		$this->porcentaje = $porcentaje;
	}
	
	public function getPorcentaje(){
		return $this->porcentaje;
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
				'titulo' => 'Retención',
				'contenido' => 'backend/retencion_view',
				'consulta_tiporetencion' => $this->tiporetencion_model-> consultatiporetencion()
			);
			$this->load->view('backend/template',$data);
		}
	}
	
	public function guardar(){
		
		
		$this->form_validation->set_rules('retencion_tipo','Tipo','trim|xss_clean');
		$this->form_validation->set_rules('retencion_nombre','Nombre','trim|xss_clean');
		$this->form_validation->set_rules('retencion_base_uvt','base_uvt','trim|xss_clean');
		$this->form_validation->set_rules('retencion_base_pesos','base_pesos','trim|xss_clean');
		$this->form_validation->set_rules('retencion_porcentaje','Porcentaje','trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('retencion_descripcion','Descripción','trim|xss_clean');
		
		$this->form_validation->set_message('required','El campo %s es obligatorio');
		$this->form_validation->set_message('numeric','El campo %s permite valores numéricos');
		
		if($this->form_validation->run() == FALSE){
			$this->index();
		}else{
			$this->setTipo($this->input->post('retencion_tipo',TRUE));
			$this->setNombre($this->input->post('retencion_nombre',TRUE));
			$this->setBase_uvt($this->input->post('retencion_base_uvt',TRUE));
			$this->setBase_pesos($this->input->post('retencion_base_pesos',TRUE));
			$this->setPorcentaje($this->input->post('retencion_porcentaje',TRUE));
			$this->setDescripcion($this->input->post('retencion_descripcion',TRUE));
			
			$data = array(
				"tiporetencion_id" => $this->getTipo(),
				"retencion_nombre" => $this->getNombre(),
				"retencion_base_uvt" => $this->getBase_uvt(),
				"retencion_base_pesos" => $this->getBase_pesos(),
				"retencion_porcentaje" => $this->getPorcentaje(),
				"retencion_descripcion" => $this->getDescripcion()
			);
			
			$this->retencion_model->guardar($data);
			redirect("retencion/datagrid");
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
				'titulo' => 'Retención',
				'contenido' => 'backend/retencion_datagrid_view',
				"tabla_retencion" => $this->retencion_model->datagrid()
			);
			$this->load->view('backend/template',$data);
		}
	}
	
	public function eliminar(){
		$id = $this->uri->segment(3);
		$this->retencion_model->eliminar($id);
		redirect("retencion/datagrid");
	}
	
	public function modificar(){
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Login';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {
			$retencion_id = $this->uri->segment(3);
			$obtenerDatos = $this->retencion_model->obtenerDatos($retencion_id);
			
			if($obtenerDatos != FALSE){
				foreach($obtenerDatos as $row){
					$data = array(
					'retencion_id' => $retencion_id,
					'tiporetencion_nombre' => $row->tiporetencion_id,
					'retencion_nombre' =>  $row->retencion_nombre,
					'retencion_base_uvt' => $row->retencion_base_uvt,
					'retencion_base_pesos' => $row->retencion_base_pesos,
					'retencion_porcentaje' => $row->retencion_porcentaje,
					'retencion_descripcion' => $row->retencion_descripcion,
					'consulta_tiporetencion' => $this->tiporetencion_model->consultatiporetencion(),
					'titulo' => 'Retención',
					'contenido' => 'backend/retencion_modificar_view'
					);
				}
				
				$this->load->view('backend/template',$data);
			}else{
				return FALSE;
			}
		}
	}
	
	public function modificarEnlace(){
		$this->form_validation->set_rules('retencion_tipo','Tipo','trim|xss_clean');
		$this->form_validation->set_rules('retencion_nombre','Nombre','trim|xss_clean');
		$this->form_validation->set_rules('retencion_base_uvt','Nombre','trim|xss_clean');
		$this->form_validation->set_rules('retencion_base_pesos','Nombre','trim|xss_clean');
		$this->form_validation->set_rules('retencion_porcentaje','Porcentaje','trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('retencion_descripcion','Descripción','trim|xss_clean');
		
		$this->form_validation->set_message('required','El campo %s es obligatorio');
		$this->form_validation->set_message('numeric','El campo %s permite valores numéricos');
		
		if($this->form_validation->run() == FALSE){
			$this->modificar();
		}else{	
			$id = $this->uri->segment(3);
			$data = array(
				"tiporetencion_id" => $this->input->post("retencion_tipo",TRUE),
				"retencion_nombre" => $this->input->post("retencion_nombre",TRUE),
				"retencion_base_uvt" => $this->input->post("retencion_base_uvt",TRUE),
				"retencion_base_pesos" => $this->input->post("retencion_base_pesos",TRUE),
				"retencion_porcentaje" => $this->input->post("retencion_porcentaje",TRUE),
				"retencion_descripcion" => $this->input->post("retencion_descripcion",TRUE)
			);
			$this->retencion_model->modificarEnlace($id,$data);
			redirect("retencion/datagrid");
		}
	}
	
	public function consultarRetencion()
	{
		$id = $this->input->post('id', TRUE);
		$porcentaje = $this->retencion_model->obtenerDatos($id);
		foreach($porcentaje as $row){
			echo $row->retencion_porcentaje/100;
		}
	}
}//fin de la clase
