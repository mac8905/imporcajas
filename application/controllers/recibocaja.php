<?php if( ! defined('BASEPATH')) exit('No direct script acces allowed');

class ReciboCaja extends CI_Controller{

	private $numeracion;
	private $relacionId;
	private $metodopago;
	private $fecha;
	private $observacion;
	private $pucId;
	private $impuestoId;
	private $valor;
	private $cantidad;
	private $retencionId;
	private $retencionValor;
	
	function __construct(){
		parent::__construct();
		$this->numeracion = 0;
		$this->relacionId = 0;
		$this->metodopago = 0;
		$this->fecha = "";
		$this->observacion = "";
		$this->pucId = 0;
		$this->impuestoId = 0;
		$this->valor = 0;
		$this->cantidad = 0;
		$this->retencionId = 0;
		$this->retencionValor = 0;
		
		$this->load->library("calendar");
		$this->load->library("pagination");
		$this->load->library("table");
		
		$this->load->model("cliente_model");
		$this->load->model("metodopago_model");
		$this->load->model("puc_model");
		$this->load->model("impuesto_model");
		$this->load->model("retencion_model");
		$this->load->model("recibocaja_model");
	}
	
	public function setNumeracion($numeracion){
		$this->numeracion = $numeracion;
	}
	
	public function getNumeracion(){
		return $this->numeracion;
	}
	
	public function setRelacionId($relacion){
		$this->relacionId = $relacion;
	}
	
	public function getRelacionId(){
		return $this->relacionId;
	}
	
	public function setMetodoPago($metodo){
		$this->metodopago = $metodo;
	}
	
	public function getMetodoPago(){
		return $this->metodopago;
	}
	
	public function setFecha($fecha){
		$this->fecha = $fecha;
	}
	
	public function getFecha(){
		return $this->fecha;
	}
	
	public function setObservacion($observacion){
		$this->observacion = $observacion;
	}
	
	public function getObservacion(){
		return $this->observacion;
	}
	
	public function setPucId($puc){
		$this->pucId = $puc;
	}
	
	public function getPucId(){
		return $this->pucId;
	}
	
	public function setImpuesto($impuesto){
		$this->impuestoId = $impuesto;
	}
	
	public function getImpuesto(){
		return $this->impuestoId;
	}
	
	public function setValor($valor){
		$this->valor = $valor;
	}
	
	public function getValor(){
		return $this->valor;
	}
	
	public function setCantidad($cantidad){
		$this->cantidad = $cantidad;
	}
	
	public function getCantidad(){
		return $this->cantidad;
	}
	
	public function setRetencionId($id){
		$this->retencionId = $id;
	}
	
	public function getRetencionId(){
		return $this->retencionId;
	}
	
	public function setRetencionValor($valor){
		$this->retencionValor = $valor;
	}
	
	public function getRetencionValor(){
		return $this->retencionValor;
	}
	
	public function index($fv_id = ""){
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Iniciar Sesion';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}else{
			$data = array(
				'titulo' => 'Recibo de Caja',
				'contenido' => 'backend/recibocaja_view',
				'recibocaja_id' => $this->recibocaja_model->consultar_id_recibocaja(),
				'consulta_beneficiario' => $this->cliente_model->consultarBeneficiarios(),
				'consulta_metodo' => $this->metodopago_model->consultarMetodoPago(),
				'consulta_puc' => $this->puc_model->consultarPuc(),
				'consulta_impuesto' => $this->impuesto_model->consultarImpuestos(),
				'consulta_retencion' => $this->retencion_model->consultarRetencion(),
				'fv_id' => $fv_id
			);
			$this->load->view("backend/template",$data);
		}		
	}
	
	public function totalCuenta(){
		$this->setCantidad($this->input->post('c'));
		$this->setValor($this->input->post('p'));
		$total_recibocaja = ($this->getValor()*$this->getCantidad());
		$datos = array(
			'total_recibocaja' => $total_recibocaja
		);
		echo json_encode($datos);
	}
	
	public function retornaRetencion(){
		$this->setRetencionValor($this->input->post('v'));
		$total_retencion = ($this->getRetencionValor()*1);
		$datos = array(
			'total_retencion' => $total_retencion
		);
		echo json_encode($datos);
	}
	
	public function guardar(){
		$this->setNumeracion($this->input->post("recibocaja_numero",TRUE));
		$this->setRelacionId($this->input->post("recibocaja_cliente",TRUE));
		$this->setMetodoPago($this->input->post("recibocaja_metodopago",TRUE));
		$this->setFecha($this->input->post("recibocaja_fecha",TRUE));
		$this->setObservacion($this->input->post("recibocaja_descripcion",TRUE));
		$this->setPucId($this->input->post("recibocaja_puc",TRUE));
		$this->setImpuesto($this->input->post("recibocaja_impuesto",TRUE));
		$this->setValor($this->input->post("recibocaja_valor",TRUE));
		$this->setCantidad($this->input->post("recibocaja_cantidad",TRUE));
		$this->setRetencionId($this->input->post("recibocaja_retencion",TRUE));
		$this->setRetencionValor($this->input->post("recibocaja_valorretencion",TRUE));
		
		$data =array(
			'recibocaja_id' => $this->getNumeracion(),
			'relacion_id' => $this->getRelacionId(),
			'metodopago_id' => $this->getMetodoPago(),
			'recibocaja_fecha' => $this->getFecha(),
			'recibocaja_observacion' => $this->getObservacion() 
		);
		
		$detalle = array(
			'puc_id' => $this->getPucId(),
			'impuesto_id' => $this->getImpuesto(),
			'detallerecibo_valor' => $this->getValor(),
			'detallerecibo_cantidad' => $this->getCantidad()
		);
		
		$retencion = array(
			'retencion_id' => $this->getRetencionId(),
			'retencion_valor' => $this->getRetencionValor() 
		);
		
		$this->recibocaja_model->guardar($data,$detalle,$retencion);
		redirect("recibocaja/datagrid");
	}
	
	public function datagrid(){
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Iniciar Sesión';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {
			$config['base_url'] = base_url()."recibocaja/datagrid";
			$config['total_rows'] = $this->recibocaja_model->getRegistros();
			$config['per_page'] = '10';
			$config['num_links'] = '2';
			$config['prev_link'] = 'anterior';
			$config['next-link'] = 'siguiente';
			$config['uri_segment'] = '3';
			$config['first_link'] = '<<';
			$config['last_link'] = '>>';
			
			$this->pagination->initialize($config);
			
			$data = array(
				'titulo' => 'Recibo de Caja',
				'contenido' => 'backend/recibocaja_datagrid_view',
				'consulta_recibocaja_datagrid' => $this->recibocaja_model->getReciboCaja($config['per_page'],$this->uri->segment(3))
			);
			$this->load->view("backend/template",$data);
		}
	}#fin_datagrid

	public function consultar(){
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Iniciar Sesión';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}else{
			$recibocaja_id = $this->uri->segment(3); 
			$obtenerDatos = $this->recibocaja_model->consultar($recibocaja_id);
			$obtenerRetencion = $this->recibocaja_model->consultarRetencion($recibocaja_id);
			$data = array(
				'titulo' => 'Recibo de Caja',
				'contenido' => 'backend/recibocaja_mostrar_view',
				'consulta_recibocaja' => $obtenerDatos,
				'consulta_retencion' => $obtenerRetencion 
			);
			$this->load->view("backend/template",$data);
		}		
	}
	
	public function modificar(){
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Iniciar Sesión';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}else{
			$recibocaja_id = $this->uri->segment(3);
			$obtenerReciboCaja = $this->recibocaja_model->obtenerDatos($recibocaja_id);
			$obtenerRetencion = $this->recibocaja_model->obtenerRetencion($recibocaja_id);
			
			if($obtenerReciboCaja != FALSE){
				$row = $obtenerReciboCaja->row();
				$puc_id = explode(',',$row->puc_id);
				$impuesto_id = explode(',',$row->impuesto_id);
				$detallerecibo_valor = explode(',',$row->detallerecibo_valor);
				$detallerecibo_cantidad = explode(',',$row->detallerecibo_cantidad);
				
				$retencion = $obtenerRetencion->row();
				$retencion_id = explode(',',$retencion->retencion_id);
				$retencion_valor = explode(',',$retencion->retencion_valor);
				
				$data = array(
					'recibocaja_id' => $recibocaja_id,
					'consulta_cliente' => $this->cliente_model->consultarClientes(),
					'relacion_id' => $row->relacion_id,
					'consulta_metodo' => $this->metodopago_model->consultarMetodoPago(),
					'metodopago_id' => $row->metodopago_id,
					'recibocaja_observacion' => $row->recibocaja_observacion,
					'recibocaja_fecha' => $row->recibocaja_fecha,
					'consulta_puc' => $this->puc_model->consultarPuc(),
					'puc_id' => $puc_id,
					'consulta_impuesto' => $this->impuesto_model->consultarImpuestos(),
					'impuesto_id' => $impuesto_id,
					'detallerecibo_valor' => $detallerecibo_valor,
					'detallerecibo_cantidad' => $detallerecibo_cantidad, 
					'retencion_id' => $retencion_id,
					'retencion_valor' => $retencion_valor,
					'consulta_retencion' => $this->retencion_model->consultarRetencion(), 
					'titulo' => 'Recibo de Caja',
					'contenido' => 'backend/recibocaja_modificar_view'
				);
				$this->load->view("backend/template",$data);
			}
		}
	}
	
	public function guardarCambios(){
		$recibocaja_id = $this->uri->segment(3);
		$this->setNumeracion($this->input->post("recibocaja_numero",TRUE));
		$this->setRelacionId($this->input->post("recibocaja_cliente",TRUE));
		$this->setMetodoPago($this->input->post("recibocaja_metodopago",TRUE));
		$this->setFecha($this->input->post("recibocaja_fecha",TRUE));
		$this->setObservacion($this->input->post("recibocaja_descripcion",TRUE));
		
		$detalleReciboId = $this->recibocaja_model->consultarDetalleReciboId($recibocaja_id);
		$this->setPucId($this->input->post("recibocaja_puc",TRUE));
		$this->setImpuesto($this->input->post("recibocaja_impuesto",TRUE));
		$this->setCantidad($this->input->post("recibocaja_cantidad",TRUE));
		$this->setValor($this->input->post("recibocaja_valor",TRUE));
		
		$detalleRetencionId = $this->recibocaja_model->consultarDetalleRetencionId($recibocaja_id);
		$this->setRetencionId($this->input->post("recibocaja_retencion",TRUE));
		$this->setRetencionValor($this->input->post("recibocaja_valorretencion",TRUE));	
		
		$data = array(
			'relacion_id' => $this->getRelacionId(),
			'metodopago_id' => $this->getMetodoPago(),
			'recibocaja_fecha' => $this->getFecha(),
			'recibocaja_observacion' => $this->getObservacion()
		);
		
		$detalle = array(
			'detallerecibo_id' => $detalleReciboId,
			'puc_id' => $this->getPucId(),
			'impuesto_id' => $this->getImpuesto(),
			'detallerecibo_cantidad' => $this->getCantidad(),
			'detallerecibo_valor' => $this->getValor()
		);
		
		$retencion = array(
			'detalleretencion_id' => $detalleRetencionId,
			'retencion_id' => $this->getRetencionId(),
			'retencion_valor' => $this->getRetencionValor()
		);
		
		$this->recibocaja_model->modificarDatos($recibocaja_id,$data,$detalle,$retencion);
		redirect("recibocaja/datagrid");
	}//fin del método guardar cambios
	
	public function eliminarFila() {
		$recibocaja_id = $this->uri->segment(3);
		$fila = $this->input->post('fila', TRUE);
		$this->recibocaja_model->eliminarFila($recibocaja_id, $fila);
	}
	
	public function eliminarFilaRetencion(){
		$recibocaja_id = $this->uri->segment(3);
		$fila = $this->input->post('fila',TRUE);
		$this->recibocaja_model->eliminarFilaRetencion($recibocaja_id,$fila);
	}
	
	public function eliminar(){
		$recibocaja_id = $this->uri->segment(3);
		$this->recibocaja_model->eliminar($recibocaja_id);
		redirect("recibocaja/datagrid");
	}

	public function agregarpago(){
		if(!$this->session->userdata('correo')){
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Iniciar Sesión';
			$this->load->view('frontened/template',$data);
		}else{
			$relacion_id = $this->uri->segment(3);
			$obtenerDatos = $this->recibocaja_model->consultarPagos($relacion_id);
			$data = array(
				'titulo' => 'Recibo de Caja',
				'contenido' =>	'backend/agregarpago_view',
				'mostrar_cliente' => $this->cliente_model->consultarClientes(),
				'mostrar_metodopago' => $this->metodopago_model->consultarMetodoPago(),
				'consulta_retencion' => $this->retencion_model->consultarRetencion(),
			);
			$this->load->view('backend/template',$data);
		}
	}
	
	public function guardar_fv_asoc() {
		$rc = array(
			'recibocaja_id' => $this->input->post('recibocaja_numero', TRUE),
			'relacion_id' => $this->input->post('recibocaja_cliente', TRUE),
			'metodopago_id' => $this->input->post('recibocaja_metodopago', TRUE),
			'recibocaja_fecha' => $this->input->post('recibocaja_fecha', TRUE),
			'recibocaja_observacion' => $this->input->post('recibocaja_descripcion', TRUE),
			'recibocaja_total' => $this->input->post('fv_totales', TRUE)
		);
		
		$fv = array(
			'fv_id' => $this->input->post('fv_numero', TRUE),
			'fv_val_pagar' => $this->input->post('fv_val_pagar', TRUE), /*hace referencia a fc_val_pagado*/
			'fv_x_pagar' => $this->input->post('input_fv_x_pagar', TRUE), /*hace referencia a fc_val_pagado*/
		);

		$this->recibocaja_model->guardar_fv_asoc($rc, $fv);
		redirect('facturaventa/datagrid');
	}
	
}//fin de la clase