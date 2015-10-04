<?php if( ! defined('BASEPATH')) exit('No direct script acces allowed');
 
class Cotizacion extends CI_Controller{
	private $relacionId;
	private $fecha;
	private $fechavencimiento;
	private $observacion;
	private $descripcion;
	
	private $productoId;
	private $tamano;
	private $precio;
	private $descuento;
	private $impuestoId;
	private $cantidad;
	
	function __construct(){
		parent::__construct();
		$this->relacionId = 0;
		$this->fecha = "";
		$this->fechavencimiento = "";
		$this->observacion = "";
		$this->descripcion = "";
		
		$this->productoId = array();
		$this->tamano = array();
		$this->precio = array();
		$this->descuento = array();
		$this->impuestoId = array();
		$this->cantidad = array();
		
		$this->load->library("calendar");
		$this->load->library("table");
		$this->load->library("pagination");
		
		$this->load->model("cotizacion_model");
		$this->load->model("cliente_model");
		$this->load->model("impuesto_model");
		$this->load->model("productos_model");
	}
	
	public function setRelacionId($relacionId){
		$this->relacionId = $relacionId;
	}
	
	public function getRelacionId(){
		return $this->relacionId;
	}
	
	public function setFecha($fecha){
		$this->fecha = $fecha;
	}
	
	public function getFecha(){
		return $this->fecha;
	}
	
	public function setFechaVencimiento($fechavencimiento){
		$this->fechavencimiento = $fechavencimiento;
	}
	
	public function getFechaVencimiento(){
		return $this->fechavencimiento;
	}
	
	public function setObservacion($observacion){
		$this->observacion = $observacion;
	}
	
	public function getObservacion(){
		return $this->observacion;
	}
	
	public function setDescripcion($descripcion){
		$this->descripcion = $descripcion;
	}
	
	public function getDescripcion(){
		return $this->descripcion;
	}
	
	public function setProductoId($productoId){
		$this->productoId = $productoId;
	}
	
	public function getProductoId(){
		return $this->productoId;
	}
	
	public function setTamano($tamano){
		$this->tamano =  $tamano;
	}
	
	public function getTamano(){
		return $this->tamano;
	}
	
	public function setPrecio($precio){
		$this->precio = $precio; 
	}
	
	public function getPrecio(){
		return $this->precio;
	}
	
	public function setDescuento($descuento){
		return $this->descuento = $descuento;
	}
	
	public function getDescuento(){
		return $this->descuento;
	}
	
	public function setImpuestoId($impuestoId){
		$this->impuestoId = $impuestoId;
	}
	
	public function getImpuestoId(){
		return $this->impuestoId;
	}
	
	public function setCantidad($cantidad){
		$this->cantidad = $cantidad;
	}
	
	public function getCantidad(){
		return $this->cantidad;
	}
	
	public function consultar(){
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Iniciar Sesión';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {
			$cotizacion_id = $this->uri->segment(3);
			$obtenerDatos = $this->cotizacion_model->consultar($cotizacion_id);
			$data = array(
				'titulo' => 'Cotización',
				'contenido' => 'backend/cotizacion_mostrar_view',
				'consulta_cotizacion' => $obtenerDatos
			);
			$this->load->view('backend/template',$data);
		}
	}
	
	public function consultarPrecio(){
		$producto_id = $this->input->post('q');
		$obtenerProducto = $this->productos_model->obtenerProducto($producto_id);
		foreach($obtenerProducto as $row){
			$data = array(
				'tamano' => $row->producto_tamano,
				'precio' => $row->producto_precioventa,
				'impuesto' => $row->impuesto_id
			);
		}
		
		echo json_encode($data);
	}
	
	public function datagrid(){
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Iniciar Sesión';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {
			$config['base_url'] = base_url()."cotizacion/datagrid";
			$config['total_rows'] = $this->cotizacion_model->getRegistros();
			$config['per_page'] = '10';
			$config['num_links'] = '3';
			$config['prev_link'] = 'anterior';
			$config['next-link'] = 'siguiente';
			$config['uri_segment'] = '3';
			$config['first_link'] = '<<';
			$config['last_link'] = '>>';
			
			$this->pagination->initialize($config);
			
			$data = array(
				'titulo' => 'Cotización',
				'contenido' => 'backend/cotizacion_datagrid_view',
				'consulta_cotizacion_datagrid' => $this->cotizacion_model->getCotizacion($config['per_page'],$this->uri->segment(3))
			);
			$this->load->view("backend/template",$data);
		}
	} #fin_datagrid
	
	public function eliminar(){
		$cotizacion_id = $this->uri->segment(3);
		$this->cotizacion_model->eliminar($cotizacion_id);
		redirect("cotizacion/datagrid");
	}
	
	public function eliminarFila() {
		$cotizacion_id = $this->uri->segment(3);
		$fila = $this->input->post('fila', TRUE);
		$this->cotizacion_model->eliminarFila($cotizacion_id, $fila);
	}
	
	public function guardar(){
		$this->setRelacionId($this->input->post("cotizacion_cliente",TRUE));
		$this->setFecha($this->input->post("fecha",TRUE));
		$this->setFechaVencimiento($this->input->post("fechavencimiento",TRUE));
		$this->setObservacion($this->input->post("cotizacion_observacion",TRUE));
		$this->setDescripcion($this->input->post("cotizacion_descripcion",TRUE));
		
		$this->setProductoId($this->input->post("cotizacion_producto",TRUE));
		$this->setTamano($this->input->post("cotizacion_tamano",TRUE));
		$this->setPrecio($this->input->post("cotizacion_precio",TRUE));
		$this->setDescuento($this->input->post("cotizacion_descuento",TRUE));
		$this->setImpuestoId($this->input->post("cotizacion_impuesto",TRUE));
		$this->setCantidad($this->input->post("cotizacion_cantidad",TRUE));
		
		$data = array(
			'relacion_id' => $this->getRelacionId(),
			'cotizacion_fecha' => $this->getFecha(),
			'cotizacion_fechavencimiento' => $this->getFechaVencimiento(),
			'cotizacion_observacion' => $this->getObservacion(),
			'cotizacion_descripcion' => $this->getDescripcion(),
		);
		
		$detalle = array(
			'producto_id' => $this->getProductoId(),
			'detalleproducto_tamano' => $this->getTamano(),
			'detalleproducto_precio' => $this->getPrecio(),
			'detalleproducto_descuento' => $this->getDescuento(),
			'impuesto_id' => $this->getImpuestoId(),
			'detalleproducto_cantidad' => $this->getCantidad()
		);
		
		$this->cotizacion_model->guardar($data,$detalle);
		redirect("cotizacion/datagrid");
	} # fin_guardar
	
	public function guardarCambios() {
		$id = $this->uri->segment(3);
		$this->setRelacionId($this->input->post("cotizacion_cliente",TRUE));
		$this->setFecha($this->input->post("cotizacion_fecha",TRUE));
		$this->setFechaVencimiento($this->input->post("cotizacion_fechavencimiento",TRUE));
		$this->setObservacion($this->input->post("cotizacion_observacion",TRUE));
		$this->setDescripcion($this->input->post("cotizacion_descripcion",TRUE));
		
		$detalleProductoId = $this->cotizacion_model->consultarDetalleProductoId($id);
		$this->setProductoId($this->input->post("cotizacion_producto",TRUE));
		$this->setTamano($this->input->post("cotizacion_tamano",TRUE));
		$this->setPrecio($this->input->post("cotizacion_precio",TRUE));
		$this->setDescuento($this->input->post("cotizacion_descuento",TRUE));
		$this->setImpuestoId($this->input->post("cotizacion_impuesto",TRUE));
		$this->setCantidad($this->input->post("cotizacion_cantidad",TRUE));
		
		$data = array(
			'relacion_id' => $this->getRelacionId(),
			'cotizacion_fecha' => $this->getFecha(),
			'cotizacion_fechavencimiento' => $this->getFechaVencimiento(),
			'cotizacion_observacion' => $this->getObservacion(),
			'cotizacion_descripcion' => $this->getDescripcion(),
		);
		
		$detalle = array(
			'detalleproducto_id' => $detalleProductoId,
			'producto_id' => $this->getProductoId(),
			'detalleproducto_tamano' => $this->getTamano(),
			'detalleproducto_precio' => $this->getPrecio(),
			'detalleproducto_descuento' => $this->getDescuento(),
			'impuesto_id' => $this->getImpuestoId(),
			'detalleproducto_cantidad' => $this->getCantidad()
		);
		$this->cotizacion_model->modificarDetalle($id, $data, $detalle);
		redirect("cotizacion/datagrid");
	}#fin_guardarCambios
	
	public function index(){
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Iniciar Sesion';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {
			$data = array(
				'titulo' => 'Cotización',
				'contenido' => 'backend/cotizacion_view',
				'consulta_cliente' => $this->cliente_model->consultarClientes(),
				'consulta_producto' => $this->productos_model->consultarProductos(),
				'consulta_impuesto' => $this->impuesto_model->consultarImpuestos()
			);
			$this->load->view("backend/template",$data);
		}
	}
	
	public function modificar() {
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Iniciar Sesión';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {
			$id = $this->uri->segment(3);
			$cotizacion = $this->cotizacion_model->obtenerCotizacion($id);
			
			if ($cotizacion != FALSE){
				$row = $cotizacion->row();
				$producto_id = explode(',', $row->producto_id);
				$detalleproducto_tamano = explode(',', $row->detalleproducto_tamano);
				$detalleproducto_precio = explode(',', $row->detalleproducto_precio);
				$detalleproducto_descuento = explode(',', $row->detalleproducto_descuento);
				$impuesto_id = explode(',', $row->impuesto_id);
				$detalleproducto_cantidad = explode(',', $row->detalleproducto_cantidad);
				
				$data = array(
					'id' => $id,
					'consulta_cliente' => $this->cliente_model->consultarClientes(),
					'relacion_id' => $row->relacion_id,
					'cotizacion_observacion' => $row->cotizacion_observacion,
					'cotizacion_fecha' => $row->cotizacion_fecha,
					'cotizacion_fechavencimiento' => $row->cotizacion_fechavencimiento,
					'cotizacion_descripcion' => $row->cotizacion_descripcion,
					'consulta_producto' => $this->productos_model->consultarProductos(),
					'producto_id' => $producto_id,
					'detalleproducto_tamano' => $detalleproducto_tamano,
					'detalleproducto_precio' => $detalleproducto_precio,
					'detalleproducto_descuento' => $detalleproducto_descuento,
					'consulta_impuesto' => $this->impuesto_model->consultarImpuestos(),
					'impuesto_id' => $impuesto_id,
					'detalleproducto_cantidad' => $detalleproducto_cantidad,
					'titulo' => 'Factura Venta',
					'contenido' => 'backend/cotizacion_modificar_view'
				);
				$this->load->view("backend/template", $data);
			}
		}
	} #fin_modificar
	
	public function totalProducto(){
		$this->setCantidad($this->input->post('c'));
		$this->setPrecio($this->input->post('p'));
		$this->setDescuento($this->input->post('d'));
		$sub = ($this->getPrecio()*$this->getCantidad());
		$des = ($sub*($this->getDescuento()/100));
		$total_cotizacion = $sub - $des;
		$datos = array(
			'total_cotizacion' => $total_cotizacion,
			'des' => $des
		);
		echo json_encode($datos);
	}
		
}//fin de la clase