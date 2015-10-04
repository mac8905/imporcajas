<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Empresa extends CI_Controller{
	private $nombre;
	private $nit;
	private $direccion;
	private $ciudad;
	private $telefono;
	private $correo;
	private $pagina;
	private $movil;
	private $regimenId;
	
	function __construct(){
		parent::__construct();
		$this->load->model("empresa_model");
		
		$this->nombre = "";
		$this->nit = "";
		$this->direccion = "";
		$this->ciudad = "";
		$this->telefono = 0;
		$this->correo = "";
		$this->pagina = "";
		$this->regimenId = 0;
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
	
	public function setDireccion($direccion){
		$this->direccion =$direccion;
	}
	
	public function getDireccion(){
		return $this->direccion;
	}
	
	public function setCiudad($ciudad){
		$this->ciudad = $ciudad;
	}
	
	public function getCiudad(){
		return $this->ciudad;
	}
	
	public function setTelefono($telefono){
		$this->telefono = $telefono;
	}
	
	public function getTelefono(){
		return $this->telefono;
	}
	
	public function setCorreo($correo){
		$this->correo = $correo;
	}
	
	public function getCorreo(){
		return $this->correo;
	}
	
	public function setPagina($pagina){
		$this->pagina = $pagina;
	}
	
	public function getPagina(){
		return $this->pagina;
	}
	
	public function setRegimenId($regimen){
		$this->regimenId = $regimen;
	}
	
	public function getRegimenId(){
		return $this->regimenId;
	}
	
	public function setMovil($movil){
		$this->movil = $movil;
	}
	
	public function getMovil(){
		return $this->movil;
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
				'titulo' => 'Empresa',
				'contenido' => 'backend/empresa_modificar_view'
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
			$obtenerDatos = $this->empresa_model->obtenerDatos();
			
			if($obtenerDatos != FALSE  ){
				foreach($obtenerDatos as $row){
					$empresa_nombre = $row->empresa_nombre;
					$empresa_nit = $row->empresa_nit;
					$empresa_direccion = $row->empresa_direccion;
					$empresa_ciudad = $row->empresa_ciudad;
					$empresa_telefono = $row->empresa_telefono;
					$empresa_correo = $row->empresa_correo;
					$empresa_pagina = $row->empresa_pagina;
					$empresa_regimenid = $row->empresa_regimenid;
					$empresa_movil = $row->empresa_movil;
					$empresa_actividad = $row->empresa_actividad;
					$empresa_resolucion = $row->empresa_resolucion;
					$empresa_inicio = $row->empresa_inicio;
					$empresa_final = $row->empresa_final;
				}
				
				$data = array(
					'empresa_nombre' => $empresa_nombre,
					'empresa_nit' => $empresa_nit,
					'empresa_direccion' => $empresa_direccion,
					'empresa_ciudad' => $empresa_ciudad,
					'empresa_telefono' => $empresa_telefono,
					'empresa_correo' => $empresa_correo,
					'empresa_pagina' => $empresa_pagina,
					'regimen_nombre' => $empresa_regimenid,
					'empresa_movil' => $empresa_movil,
					'empresa_actividad' => $empresa_actividad,
					'empresa_resolucion' => $empresa_resolucion,
					'consulta_regimen' => $this->empresa_model->consultarRegimen(),
					'empresa_inicio' => $empresa_inicio,
					'empresa_final' => $empresa_final,
					'titulo' => 'Empresa',
					'contenido' => 'backend/empresa_modificar_view'
				);
				
				$this->load->view('backend/template',$data);
			}else{
				return FALSE;
			}
		}
	}
	
	public function modificarEnlace(){
		$this->form_validation->set_rules('empresa_nombre','Nombre','trim|required|xss_clean');
		$this->form_validation->set_rules('empresa_nit','Nit','trim|xss_clean');
		$this->form_validation->set_rules('empresa_direccion','Dirección','trim|xss_clean');
		$this->form_validation->set_rules('empresa_ciudad','Ciudad','trim|xss_clean');
		$this->form_validation->set_rules('empresa_telefono','Teléfono','trim|numeric|xss_clean');
		$this->form_validation->set_rules('empresa_correo','Correo','trim|xss_clean');
		$this->form_validation->set_rules('empresa_pagina','Página','trim|xss_clean');
		$this->form_validation->set_rules('empresa_regimen','Régimen','trim|xss_clean');
		$this->form_validation->set_rules('empresa_movil','Móvil','trim|xss_clean');
		$this->form_validation->set_rules('empresa_actividad','Actividad','trim|xss_clean');
		$this->form_validation->set_rules('empresa_inicio','Autorización Inicial','trim|xss_clean');
		$this->form_validation->set_rules('empresa_resolucion','Resolución de la DIAN','trim|xss_clean');
		$this->form_validation->set_rules('empresa_final','Autorización Final','trim|xss_clean');
		
		$this->form_validation->set_message('required','El campo %s es obligatorio');
		$this->form_validation->set_message('numeric','El campo %s permite valores numéricos');
		
		if($this->form_validation->run() == FALSE){
			$this->modificar();
		}else{	
			$data = array(
				"empresa_regimenid" => $this->input->post("empresa_regimen",TRUE),
				"empresa_nombre" => $this->input->post("empresa_nombre",TRUE),
				"empresa_nit" => $this->input->post("empresa_nit",TRUE),
				"empresa_direccion" => $this->input->post("empresa_direccion",TRUE),
				"empresa_ciudad" => $this->input->post("empresa_ciudad",TRUE),
				"empresa_telefono" => $this->input->post("empresa_telefono",TRUE),
				"empresa_correo" => $this->input->post("empresa_correo",TRUE),
				"empresa_pagina" => $this->input->post("empresa_pagina",TRUE),
				"empresa_movil" => $this->input->post("empresa_movil",TRUE),
				"empresa_actividad" => $this->input->post("empresa_actividad",TRUE),
				"empresa_resolucion" => $this->input->post("empresa_resolucion",TRUE),
				"empresa_inicio" => $this->input->post("empresa_inicio",TRUE),
				"empresa_final" => $this->input->post("empresa_final",TRUE)
			);
			$this->empresa_model->modificarDatos($data);
			redirect("principal/bandeja_entrada");
		}
	}	
	
}