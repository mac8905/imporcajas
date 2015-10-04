<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class FacturaVenta extends CI_Controller{
	
	private $numeracion;
	private $fecha;
	private $fechavencimiento;
	private $observacion;
	private $descripcion;
	private $relacionId;
	private $total;
	
	private $productoId;
	private $tamano;
	private $precio;
	private $descuento;
	private $impuestoId;
	private $cantidad;
	
	private $subtotal;
	private $iva;
	
	function __construct(){
		parent::__construct();
		$this->load->library("calendar");
		$this->load->library("table");
		$this->load->library("pagination");
		
		$this->load->model("facturaventa_model");
		$this->load->model("cliente_model");
		$this->load->model("impuesto_model");
		$this->load->model("productos_model");
		$this->load->model('retencion_model');
		
		$this->numeracion = 0;
		$this->fecha = "";
		$this->fechavencimiento = "";
		$this->observacion = "";
		$this->descripcion = "";
		$this->relacionId = 0;
		$this->productoId = 0;
		$this->tamano = "";
		$this->precio = 0;
		$this->descuento = 0;
		$this->impuestoId = 0;
		$this->cantidad = 0;
		$this->total = 0;
		$this->subtotal = 0;
		$this->iva = 0;
	}
	
	public function setNumeracion($numeracion){
		$this->numeracion = $numeracion;
	}
	
	public function getNumeracion(){
		return $this->numeracion;
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
	
	public function setTotal($total){
		$this->total = $total;
	}
	
	public function getTotal(){
		return $this->total;
	}
	
	public function setSubtotal($subtotal){
		$this->subtotal = $subtotal;
	}
	
	public function getSubtotal(){
		return $this->subtotal;
	}
	
	public function setIva($iva){
		$this->iva = $iva;
	}
	
	public function getIva(){
		return $this->iva;
	}
	
	public function consultar(){
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Iniciar Sesion';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {
			$facturaventa_id = $this->uri->segment(3);
			$obtenerDatos = $this->facturaventa_model->consultar($facturaventa_id);
			$obtenerRecibo = $this->facturaventa_model->consultar_rc_asoc($facturaventa_id);
			$data = array(
				'titulo' => 'Factura de Venta',
				'contenido' => 'backend/facturaventa_mostrar_view',
				'consulta_facturaventa' => $obtenerDatos,
				'consulta_recibo' => $obtenerRecibo
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
			$data['titulo'] = 'Iniciar Sesion';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {
			/*$config['base_url'] = base_url()."facturaventa/datagrid";
			$config['total_rows'] = $this->facturaventa_model->getRegistros();
			$config['per_page'] = '10';
			$config['num_links'] = '2';
			$config['prev_link'] = 'anterior';
			$config['next-link'] = 'siguiente';
			$config['uri_segment'] = '3';
			$config['first_link'] = '<<';
			$config['last_link'] = '>>';
			
			$this->pagination->initialize($config);*/
			
			$data = array(
				'titulo' => 'Factura de Venta',
				'contenido' => 'backend/facturaventa_datagrid_view',
				'consulta_facturaventa_datagrid' => $this->facturaventa_model->getFacturaVenta()
			);
			$this->load->view("backend/template",$data);
		}
	}#fin_datagrid
	
	public function eliminar(){
		$facturav_id = $this->uri->segment(3);
		$this->facturaventa_model->eliminar($facturav_id);
		redirect("facturaventa/datagrid");
	}
	
	public function eliminarFila() {
		$facturav_id = $this->uri->segment(3);
		$fila = $this->input->post('fila', TRUE);
		$this->facturaventa_model->eliminarFila($facturav_id, $fila);
	}
	//Función que permite guardar una factura de venta
	public function guardar(){
	
		$this->form_validation->set_rules('facturaventa_numero','Número','trim|is_unique[facturaventa.facturav_id]|required|numeric|xss_clean');
		$this->form_validation->set_rules('facturaventa_cliente','Cliente','trim|required|xss_clean');
		$this->form_validation->set_rules('facturaventa_precio[]','Precio','trim|numeric|xss_clean');
		$this->form_validation->set_rules('facturaventa_descuento[]','Descuento','trim|numeric|xss_clean');
		$this->form_validation->set_rules('facturaventa_cantidad[]','Cantidad','trim|numeric|xss_clean');
		$this->form_validation->set_rules('facturaventa_producto[]','Producto','trim|required|xss_clean');
		
		$this->form_validation->set_message('required', 'El campo %s es obligatorio');
		$this->form_validation->set_message('numeric','El campo %s solo admite caracteres numéricos');
		$this->form_validation->set_message('alpha','El campo %s solo admite caracteres alfabéticos');
		$this->form_validation->set_message('is_unique','El número de factura ya existe');
		
		if($this->form_validation->run() == FALSE){
			$this->index();
		}else{
		
			$this->setNumeracion($this->input->post("facturaventa_numero",TRUE));
			$this->setRelacionId($this->input->post("facturaventa_cliente",TRUE));
			$this->setFecha($this->input->post("fecha",TRUE));
			$this->setFechaVencimiento($this->input->post("fechavencimiento",TRUE));
			$this->setObservacion($this->input->post("facturaventa_observacion",TRUE));
			$this->setDescripcion($this->input->post("facturaventa_descripcion",TRUE));
			
			/* Datos a guardar en la tabla DetalleProducto */
			$this->setProductoId($this->input->post("facturaventa_producto",TRUE));
			$this->setTamano($this->input->post("facturaventa_tamano",TRUE));
			$this->setPrecio($this->input->post("facturaventa_precio",TRUE));
			$this->setDescuento($this->input->post("facturaventa_descuento",TRUE));
			$this->setImpuestoId($this->input->post("facturaventa_impuesto",TRUE));
			$this->setCantidad($this->input->post("facturaventa_cantidad",TRUE));
			
			$data = array(
				'facturav_id' => $this->getNumeracion(),
				'relacion_id' => $this->getRelacionId(),
				'facturav_fecha' => $this->getFecha(),
				'facturav_fechavencimiento' => $this->getFechaVencimiento(),
				'facturav_observacion' => $this->getObservacion(),
				'facturav_descripcion' => $this->getDescripcion(),
				'fv_subtotal_sin_desc' => $this->input->post('fv_subtotal_sin_des', TRUE),
				'fv_descuento' => $this->input->post('fv_descuento', TRUE),
				'fv_subtotal' => $this->input->post('fv_subtotal', TRUE),
				'fv_iva' => $this->input->post('fv_iva', TRUE),
				'fv_val_ret' => $this->input->post('fv_retencion', TRUE),
				'fv_total' => $this->input->post('fv_total', TRUE),
				'fv_x_pagar' => $this->input->post('fv_total', TRUE)
			);
			
			$detalle = array(
				'producto_id' => $this->getProductoId(),
				'detalleproducto_tamano' => $this->getTamano(),
				'detalleproducto_precio' => $this->getPrecio(),
				'detalleproducto_descuento' => $this->getDescuento(),
				'impuesto_id' => $this->getImpuestoId(),
				'detalleproducto_cantidad' => $this->getCantidad()
			);
			
			$detalle_retencion = array(
				'ce_retencion' => $this->input->post('ce_retencion', TRUE),
				'rete_valor' => $this->input->post('rete_valor', TRUE),
			);
			
			$this->facturaventa_model->guardar($data,$detalle,$detalle_retencion);
			redirect("facturaventa/datagrid");	
		}
	}# fin_guardar
	
	public function guardarCambios() {
		$id = $this->uri->segment(3);
		$this->setRelacionId($this->input->post("facturav_cliente",TRUE));
		$this->setFecha($this->input->post("fecha",TRUE));
		$this->setFechaVencimiento($this->input->post("fechavencimiento",TRUE));
		$this->setObservacion($this->input->post("facturav_observacion",TRUE));
		$this->setDescripcion($this->input->post("facturav_descripcion",TRUE));
		
		$detalleProductoId = $this->facturaventa_model->consultarDetalleProductoId($id);
		$this->setProductoId($this->input->post("facturaventa_producto",TRUE));
		$this->setTamano($this->input->post("facturaventa_tamano",TRUE));
		$this->setPrecio($this->input->post("facturaventa_precio",TRUE));
		$this->setDescuento($this->input->post("facturaventa_descuento",TRUE));
		$this->setImpuestoId($this->input->post("facturaventa_impuesto",TRUE));
		$this->setCantidad($this->input->post("facturaventa_cantidad",TRUE));
		
		$detalleRetencionId = $this->facturaventa_model->consultarDetalleRetencionId($id);
		
		$data = array(
			'relacion_id' => $this->getRelacionId(),
			'facturav_fecha' => $this->getFecha(),
			'facturav_fechavencimiento' => $this->getFechaVencimiento(),
			'facturav_observacion' => $this->getObservacion(),
			'facturav_descripcion' => $this->getDescripcion(),
			'fv_subtotal_sin_desc' => $this->input->post("fv_subtotal_sin_des",TRUE),
			'fv_descuento' => $this->input->post("fv_descuento",TRUE),
			'fv_subtotal' => $this->input->post("fv_subtotal",TRUE),
			'fv_iva' => $this->input->post("fv_iva",TRUE),
			'fv_val_ret' => $this->input->post("fv_retencion",TRUE),
			'fv_total' => $this->input->post("fv_total",TRUE),
			'fv_x_pagar' => $this->input->post("fv_total",TRUE)
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
		
		$retencion = array(
			'detalleretencion_id' => $detalleRetencionId,
			'retencion_id' => $this->input->post("ce_retencion",TRUE),
			'retencion_valor' => $this->input->post("rete_valor",TRUE)
		);
		
		$this->facturaventa_model->modificarDetalle($id, $data, $detalle, $retencion);
		redirect("facturaventa/datagrid");
	} # fin_guardarCambios
	
	public function index(){
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Iniciar Sesion';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {
			$data = array(
				'titulo' => 'Factura de Venta',
				'contenido' => 'backend/facturaventa_view',
				'fv_id' => $this->facturaventa_model->consultar_fv_id(),
				'consulta_cliente' => $this->cliente_model->consultarClientes(),
				'consulta_producto' => $this->productos_model->consultarProductos(),
				'consulta_impuesto' => $this->impuesto_model->consultarImpuestos(),
				'consulta_retencion' => $this->retencion_model->consultarRetencion()
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
			$facturaventa_id = $this->uri->segment(3);
			$facturav = $this->facturaventa_model->obtenerFacturaVenta($facturaventa_id);
			$obtenerRetencion = $this->facturaventa_model->obtenerRetencion($facturaventa_id);
			
			if ($facturav != FALSE){
				$row = $facturav->row();
				$producto_id = explode(',', $row->producto_id);
				$detalleproducto_tamano = explode(',', $row->detalleproducto_tamano);
				$detalleproducto_precio = explode(',', $row->detalleproducto_precio);
				$detalleproducto_descuento = explode(',', $row->detalleproducto_descuento);
				$impuesto_id = explode(',', $row->impuesto_id);
				$detalleproducto_cantidad = explode(',', $row->detalleproducto_cantidad);
				
				$retencion = $obtenerRetencion->row();
				$retencion_id = explode(',',$retencion->retencion_id);
				$retencion_valor = explode(',',$retencion->retencion_valor);
				
				$data = array(
					'id' => $facturaventa_id,
					'consulta_cliente' => $this->cliente_model->consultarClientes(),
					'relacion_id' => $row->relacion_id,
					'facturav_observacion' => $row->facturav_observacion,
					'facturav_fecha' => $row->facturav_fecha,
					'facturav_fechavencimiento' => $row->facturav_fechavencimiento,
					'facturav_descripcion' => $row->facturav_descripcion,
					'consulta_producto' => $this->productos_model->consultarProductos(),
					'producto_id' => $producto_id,
					'detalleproducto_tamano' => $detalleproducto_tamano,
					'detalleproducto_precio' => $detalleproducto_precio,
					'detalleproducto_descuento' => $detalleproducto_descuento,
					'consulta_impuesto' => $this->impuesto_model->consultarImpuestos(),
					'impuesto_id' => $impuesto_id,
					'detalleproducto_cantidad' => $detalleproducto_cantidad,
					'retencion_id' => $retencion_id,
					'retencion_valor' => $retencion_valor,
					'consulta_retencion' => $this->retencion_model->consultarRetencion(), 
					'titulo' => 'Factura de Venta',
					'contenido' => 'backend/facturaventa_modificar_view'
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
		$total_facturaventa = $sub - $des;
		$datos = array(
			'total_facturaventa' => $total_facturaventa,
			'des' => $des,
			'sub' => $sub
		);
		echo json_encode($datos);
	}
	
	public function total(){
		$facturaventa_total = 0;
		$this->setSubtotal($this->input->post('subtotal1'));
		$this->setIva($this->input->post('iva1'));
		$facturaventa_total = $this->getSubtotal() + $this->getIva();
		$datos = array(
			'facturaventa_total' => $facturaventa_total
		);
		echo json_encode($datos);
	}
	
	//------------------------------------------------------------------------
	//	Métodos para el recibo de caja asociado
	//------------------------------------------------------------------------
	
	public function consultar_id_beneficiario()
	{
		$value = $this->input->post('id');
		$resultado = $this->facturaventa_model->consulta_id_beneficiario($value);
		foreach ($resultado as $value) {
			echo $value->relacion_id;
		}
	}
	
	public function consultarFV()
	{
		$id_beneficiario = $this->input->post('id');
		$fv = $this->facturaventa_model->consulta_fv_x_beneficiario($id_beneficiario);
		foreach ($fv as $key => $value) {
			$data1[$key] = array(
			'facturav_id' => $value->facturav_id, /*numero de la factura de compra*/
			'fv_total' => number_format($value->fv_total,2), /*total*/
			'fv_val_rete' => number_format($value->fv_val_ret,2), /*total*/
			'fv_x_pagar' => number_format($value->fv_x_pagar,2), /*por pagar*/
			'fv_val_pagado' => number_format($value->fv_val_pagado,2) /*valor pagado*/
			
			);
		}
		echo json_encode($data1);
	}
		
}//Fin de la clase