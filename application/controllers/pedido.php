<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pedido extends CI_Controller{
	private $fecha;
	private $fechavencimiento;
	private $observacion;
	private $descripcion;
	private $relacionId;
	
	private $productoId;
	private $tamano;
	private $precio;
	private $descuento;
	private $impuestoId;
	private $cantidad;
	
	function __construct(){
		parent::__construct();
		$this->fecha = "";
		$this->fechavencimiento = "";
		$this->observacion = "";
		$this->descripcion = "";
		$this->relacionId = 0;
		
		$this->productoId = array();
		$this->tamano = array();
		$this->precio = array();
		$this->descuento = array();
		$this->impuestoId = array();
		$this->cantidad = array();
		
		// $this->subtotal = array();
		
		$this->load->library("calendar");
		$this->load->library("table");
		$this->load->library("pagination");
		$this->load->library("email");
		
		$this->load->model("pedido_model");
		$this->load->model("cliente_model");
		$this->load->model("impuesto_model");
		$this->load->model("productos_model");
	}#fin_constructor

	
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
	
	public function setRelacionId($relacionId){
		$this->relacionId = $relacionId;
	}
	
	public function getRelacionId(){
		return $this->relacionId;
	}
	
	public function setProductoId($productoId){
		$this->productoId = $productoId;
	}
	
	public function getProductoId(){
		return $this->productoId;
	}
	
	public function setTamano($tamano){
		$this->tamano = $tamano;
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
		$this->descuento = $descuento;
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
			$data['titulo'] = 'Login';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {
			$pedido_id = $this->uri->segment(3);
			$obtenerDatos = $this->pedido_model->consultar($pedido_id);
			$data = array(
				'titulo' => 'Pedido',
				'contenido' => 'backend/pedido_mostrar_view',
				'consulta_pedido' => $obtenerDatos
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
			$data['titulo'] = 'Login';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {
			$config['base_url'] = base_url()."pedido/datagrid";
			$config['total_rows'] = $this->pedido_model->getRegistros();
			$config['per_page'] = '10';
			$config['num_links'] = '3';
			$config['prev_link'] = 'anterior';
			$config['next-link'] = 'siguiente';
			$config['uri_segment'] = '3';
			$config['first_link'] = '<<';
			$config['last_link'] = '>>';
			
			$this->pagination->initialize($config);
			
			$data = array(
				'titulo' => 'Pedidos',
				'contenido' => 'backend/pedido_datagrid_view',
				'consulta_pedido_datagrid' => $this->pedido_model->getPedidos($config['per_page'],$this->uri->segment(3))
			);
			$this->load->view("backend/template",$data);
		}
	}#fin_datagrid
	
	public function eliminar(){
		$pedido_id = $this->uri->segment(3);
		$this->pedido_model->eliminar($pedido_id);
		redirect("pedido/datagrid");
	}
	
	public function eliminarFila() {
		$id_pedido = $this->uri->segment(3);
		$fila = $this->input->post('fila', TRUE);
		$this->pedido_model->eliminarFila($id_pedido, $fila);
	}
	
	public function enviarEmail(){
		$this->email->from("wicaicedos25@gmail.com","Wilmar Caicedo");
		$this->email->subject("Correo de prueba");
		$this->email->message("Probando la clase email");
		
		$this->email->send();
		
		echo $this->email->print_debugger();
	}
	
	public function guardar(){
		/* Guarda en la tabla Pedido */
		$this->setRelacionId($this->input->post("pedido_cliente",TRUE));
		$this->setFecha($this->input->post("fecha",TRUE));
		$this->setFechaVencimiento($this->input->post("fechavencimiento",TRUE));
		$this->setObservacion($this->input->post("pedido_observacion",TRUE));
		$this->setDescripcion($this->input->post("pedido_descripcion",TRUE));
		
		/* Guarda en la tabla DetalleProducto */
		$this->setProductoId($this->input->post("pedido_producto",TRUE));
		$this->setTamano($this->input->post("pedido_tamano",TRUE));
		$this->setPrecio($this->input->post("pedido_precio",TRUE));
		$this->setDescuento($this->input->post("pedido_descuento",TRUE));
		$this->setImpuestoId($this->input->post("pedido_impuesto",TRUE));
		$this->setCantidad($this->input->post("pedido_cantidad",TRUE));
		
		$data = array(
			'relacion_id' => $this->getRelacionId(),
			'pedido_fecha' => $this->getFecha(),
			'pedido_fechavencimiento' => $this->getFechaVencimiento(),
			'pedido_observacion' => $this->getObservacion(),
			'pedido_descripcion' => $this->getDescripcion(),
		);
		
		$detalle = array(
			'producto_id' => $this->getProductoId(),
			'detalleproducto_tamano' => $this->getTamano(),
			'detalleproducto_precio' => $this->getPrecio(),
			'detalleproducto_descuento' => $this->getDescuento(),
			'impuesto_id' => $this->getImpuestoId(),
			'detalleproducto_cantidad' => $this->getCantidad()
		);
		
		$this->pedido_model->guardar($data,$detalle);
		redirect("pedido/datagrid");
	}#fin_guardar
	
	public function guardarCambios() {
		$id = $this->uri->segment(3);
		$this->setRelacionId($this->input->post("pedido_cliente",TRUE));
		$this->setFecha($this->input->post("fecha",TRUE));
		$this->setFechaVencimiento($this->input->post("fechavencimiento",TRUE));
		$this->setObservacion($this->input->post("pedido_observacion",TRUE));
		$this->setDescripcion($this->input->post("pedido_descripcion",TRUE));
		
		$detalleProductoId = $this->pedido_model->consultarDetalleProductoId($id);
		$this->setProductoId($this->input->post("pedido_producto",TRUE));
		$this->setTamano($this->input->post("pedido_tamano",TRUE));
		$this->setPrecio($this->input->post("pedido_precio",TRUE));
		$this->setDescuento($this->input->post("pedido_descuento",TRUE));
		$this->setImpuestoId($this->input->post("pedido_impuesto",TRUE));
		$this->setCantidad($this->input->post("pedido_cantidad",TRUE));
		
		$data = array(
			'relacion_id' => $this->getRelacionId(),
			'pedido_fecha' => $this->getFecha(),
			'pedido_fechavencimiento' => $this->getFechaVencimiento(),
			'pedido_observacion' => $this->getObservacion(),
			'pedido_descripcion' => $this->getDescripcion(),
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
		$this->pedido_model->modificarDetalle($id, $data, $detalle);
		redirect("pedido/datagrid");
	}#fin_guardarCambios
	
	public function index(){
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Iniciar Sesión';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {
			$data = array(
				'titulo' => 'Pedidos',
				'contenido' => 'backend/pedido_view',
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
			$pedido = $this->pedido_model->obtenerPedido($id);
			
			if ($pedido != FALSE){
				$row = $pedido->row();
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
					'pedido_observacion' => $row->pedido_observacion,
					'pedido_fecha' => $row->pedido_fecha,
					'pedido_fechavencimiento' => $row->pedido_fechavencimiento,
					'pedido_descripcion' => $row->pedido_descripcion,
					'consulta_producto' => $this->productos_model->consultarProductos(),
					'producto_id' => $producto_id,
					'detalleproducto_tamano' => $detalleproducto_tamano,
					'detalleproducto_precio' => $detalleproducto_precio,
					'detalleproducto_descuento' => $detalleproducto_descuento,
					'consulta_impuesto' => $this->impuesto_model->consultarImpuestos(),
					'impuesto_id' => $impuesto_id,
					'detalleproducto_cantidad' => $detalleproducto_cantidad,
					'titulo' => 'Pedido',
					'contenido' => 'backend/pedido_modificar_view'
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
		$total_pedido = $sub - $des;
		$datos = array(
			'total_pedido' => $total_pedido,
			'des' => $des
		);
		echo json_encode($datos);
	}
}#fin clase pedido