<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Productos extends CI_Controller{

	private $nombre;
	private $costo;
	private $precioVenta;
	private $cantidadInicial;
	private $cantidadActual;
	private $descripcion;
	private $alto;
	private $ancho;
	private $largo;
	private $impuesto;
	
	public function __construct(){
		parent::__construct();
		$this->load->model("productos_model");
		$this->load->library("Table");
		$this->load->library("pagination");
		
		$this->nombre = "";
		$this->costo = 0;
		$this->precioVenta = 0;
		$this->cantidadInicial = 0;
		$this->cantidadActual = 0;
		$this->descripcion = "";
		$this->alto = 0;
		$this->ancho = 0;
		$this->largo = 0;
		$this->impuesto =0;
	}
	
	public function setNombre($nombre){
		$this->nombre = $nombre;
	}
	
	public function getNombre(){
		return $this->nombre;
	}
	
	public function setCosto($costo){
		$this->costo = $costo;
	}
	
	public function getCosto(){
		return $this->costo;
	}
	
	public function setPrecioVenta($precioventa){
		$this->precioVenta = $precioventa;
	}
	
	public function getPrecioVenta(){
		return $this->precioVenta;
	}
	
	public function setCantidadInicial($cantidadinicial){
		$this->cantidadInicial = $cantidadinicial;
	}
	
	public function getCantidadInicial(){
		return $this->cantidadInicial;
	}
	
	public function setCantidadActual($cantidadactual){
		$this->cantidadActual = $cantidadactual;
	}
	
	public function getCantidadActual(){
		return $this->cantidadActual;
	}
	
	public function setDescripcion($descripcion){
		$this->descripcion = $descripcion;
	}
	
	public function getDescripcion(){
		return $this->descripcion;
	}
	
	public function setAlto($alto){
		$this->alto = $alto;
	}
	
	public function getAlto(){
		return $this->alto;
	}
	
	public function setAncho($ancho){
		$this->ancho = $ancho;
	}
	
	public function getAncho(){
		return $this->ancho;
	}
	
	public function setLargo($largo){
		$this->largo = $largo;
	}
	
	public function getLargo(){
		return $this->largo;
	}
	
	public function setImpuesto($impuesto){
		$this->impuesto = $impuesto;
	}
	
	public function getImpuesto(){
		return $this->impuesto;
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
				'titulo' => 'Inventario',
				'contenido' => 'backend/productos_view',
				'consulta_impuesto' => $this->productos_model->consultarImpuesto()
			);
			$this->load->view("backend/template",$data);
		}
	}
	
	public function guardar(){
		$this->form_validation->set_rules('producto_nombre','Nombre','trim|required|xss_clean');
		$this->form_validation->set_rules('producto_descripcion','Descripción','trim|xss_clean');
		$this->form_validation->set_rules('producto_precioventa','Precio de Venta','trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('producto_impuesto','Impuesto','trim|required|xss_clean');
		$this->form_validation->set_rules('producto_alto','Alto','trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('producto_ancho','Ancho','trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('producto_largo','Largo','trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('producto_cantidadinicial','Cantidad Inicial','trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('producto_costo','Costo','trim|required|numeric|xss_clean');
		
		$this->form_validation->set_message('required','El campo %s es obligatorio');
		$this->form_validation->set_message('numeric','El campo %s permite valores numéricos');
		
		if($this->form_validation->run() == FALSE){
			$this->index();
		}else{
			$this->setNombre($this->input->post("producto_nombre",TRUE));
			$this->setDescripcion($this->input->post("producto_descripcion",TRUE));
			$this->setPrecioVenta($this->input->post("producto_precioventa",TRUE));
			$this->setImpuesto($this->input->post("producto_impuesto",TRUE));
			$this->setAlto($this->input->post("producto_alto",TRUE));
			$this->setAncho($this->input->post("producto_ancho",TRUE));
			$this->setLargo($this->input->post("producto_largo",TRUE));
			$this->setCantidadInicial($this->input->post("producto_cantidadinicial",TRUE));
			$this->setCosto($this->input->post("producto_costo",TRUE));
			
			$data = array(
				"producto_nombre" => $this->getNombre(),
				"producto_descripcion" => $this->getDescripcion(),
				"producto_precioventa" => $this->getPrecioVenta(),
				"impuesto_id" => $this->getImpuesto(),
				"producto_cantidadinicial" => $this->getCantidadInicial(),
				"producto_costo" => $this->getCosto()
			);
			
			$data1 = array(
				"dimension_alto" => $this->getAlto(),
				"dimension_ancho" => $this->getAncho(),
				"dimension_largo" => $this->getLargo()
			);
			
			$this->productos_model->guardar($data,$data1);
			redirect("productos/datagrid");
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
			$config['base_url'] = base_url()."productos/datagrid/";
			$config['total_rows'] = $this->productos_model->getCantidad();//obtenemos la cantidad de registros
			$config['per_page'] = '8';  //cantidad de registros por página
			$config['num_links'] = '1'; //nro. de enlaces antes y después de la pagina actual
			$config['prev_link'] = 'anterior'; //texto del enlace que nos lleva a la pagina ant.
			$config['next_link'] = 'siguiente'; //texto del enlace que nos lleva a la sig. página
			$config['uri_segment'] = '3';  //segmentos que va a tener nuestra URL
			$config['first_link'] = '<<';  //texto del enlace que nos lleva a la primer página
			$config['last_link'] = '>>';   //texto del enlace que nos lleva a la última página
			
			$this->pagination->initialize($config); 
			
			$data = array(
				'titulo' => 'Inventario',
				'contenido' => "backend/productos_datagrid_view",
				'tabla_productos' => $this->productos_model->datagrid($config['per_page'],$this->uri->segment(3))
			);
			
			$this->load->view("backend/template",$data);
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
			$producto_id = $this->uri->segment(3);
			$obtenerId = $this->productos_model->consultar($producto_id);
			$data = array(
				'titulo' => 'Inventario',
				'contenido' => "backend/productos_consulta_view",
				'consulta_productos' => $obtenerId
			);
			$this->load->view("backend/template",$data);
		}
	}
	
	public function eliminar(){
		$id = $this->uri->segment(3);
		$this->productos_model->eliminar($id);
		redirect("productos/datagrid");
	}
	
	public function modificar(){
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Login';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {
			$producto_id = $this->uri->segment(3);
			$obtenerDatos = $this->productos_model->modificar($producto_id);
			
			if($obtenerDatos != FALSE){
				foreach($obtenerDatos as $row){
					$producto_nombre = $row->producto_nombre;
					$producto_descripcion = $row->producto_descripcion;
					$producto_precioventa = $row->producto_precioventa;
					$impuesto_id = $row->impuesto_id;
					$producto_alto = $row->dimension_alto;
					$producto_ancho = $row->dimension_ancho;
					$producto_largo = $row->dimension_largo;
					$producto_cantidadinicial = $row->producto_cantidadinicial;
					$producto_costo = $row->producto_costo;
				}
				
				$data = array(
					'producto_id' => $producto_id,
					'producto_nombre' => $producto_nombre,
					'producto_descripcion' => $producto_descripcion,
					'producto_precioventa' => $producto_precioventa,
					'impuesto_id' => $impuesto_id,
					'producto_alto' => $producto_alto,
					'producto_ancho' => $producto_ancho,
					'producto_largo' => $producto_largo,
					'producto_cantidadinicial' => $producto_cantidadinicial,
					'producto_costo' => $producto_costo,
					'consulta_impuesto' => $this->productos_model->impuesto(),
					'titulo' => 'Inventario',
					'contenido' => "backend/productos_modificar_view",
				);
				
				$this->load->view("backend/template",$data);
				
			}else{
				return FALSE;
			}
		}
	}
	
	public function modificarEnlace(){
		$id = $this->uri->segment(3);
		$data = array(
			'producto_nombre' => $this->input->post("producto_nombre",TRUE),
			'producto_descripcion' => $this->input->post("producto_descripcion",TRUE),
			'producto_precioventa' => $this->input->post("producto_precioventa",TRUE),
			'impuesto_id' => $this->input->post("producto_impuesto",TRUE),
			'producto_cantidadinicial' => $this->input->post("producto_cantidadinicial",TRUE),
			'producto_costo' => $this->input->post("producto_costo",TRUE),
		);
		$data1 = array(
			'dimension_alto' => $this->input->post("producto_alto",TRUE),
			'dimension_ancho' => $this->input->post("producto_ancho",TRUE),
			'dimension_largo' => $this->input->post("producto_largo",TRUE),
		);
		$this->productos_model->modificarEnlace($id,$data,$data1);
		redirect("productos/datagrid");
	}
	
	public function datagridInventario(){
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Login';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {
			$config['base_url'] = base_url()."productos/datagridInventario/";
			$config['total_rows'] = $this->productos_model->getCantidad();//obtenemos la cantidad de registros
			$config['per_page'] = '15';  //cantidad de registros por página
			$config['num_links'] = '2'; //nro. de enlaces antes y después de la pagina actual
			$config['prev_link'] = 'anterior'; //texto del enlace que nos lleva a la pagina ant.
			$config['next_link'] = 'siguiente'; //texto del enlace que nos lleva a la sig. página
			$config['uri_segment'] = '3';  //segmentos que va a tener nuestra URL
			$config['first_link'] = '<<';  //texto del enlace que nos lleva a la primer página
			$config['last_link'] = '>>';   //texto del enlace que nos lleva a la última página
			
			$this->pagination->initialize($config); 
			
			$data = array(
				'titulo' => 'Inventario',
				'contenido' => "backend/inventario_datagrid_view",
				'inventario' => $this->productos_model->consultarInventario($config['per_page'],$this->uri->segment(3))
			);
			$this->load->view("backend/template",$data);
		}
	}
	
	public function consultarFacturas(){
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Login';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {
			$productoId = $this->uri->segment(3);
			$obtenerId = $this->productos_model->consultarVentas($productoId);
			$obtenerCompras = $this->productos_model->consultarCompras($productoId);
			$data = array(
				'titulo' => 'Inventario',
				'contenido' => "backend/inventario_detalle_view",
				'consulta_detalle_venta' => $obtenerId,
				'consulta_detalle_compra' => $obtenerCompras
			);
			$this->load->view("backend/template",$data);
		}
	}
	
	public function kardex(){
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Login';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {
			$productoId = $this->uri->segment(3);
			$obtenerDatos = $this->productos_model->consultarKardex($productoId);
			$obtenerKardex = $this->productos_model->consultarKardexSolo($productoId);
			$data = array(
				'titulo' => 'Inventario',
				'contenido' => "backend/kardex_view",
				'consulta_detalle_kardex' => $obtenerDatos,
				'consulta_detalle_solo_kardex' => $obtenerKardex
			);
			$this->load->view("backend/template",$data);
		}
	}
	
}//fin de la clase