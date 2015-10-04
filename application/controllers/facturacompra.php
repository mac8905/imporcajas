<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class FacturaCompra extends CI_Controller {
	
	function __construct() {
		parent::__construct();

		$this->load->model('comprobanteegreso_model');
		$this->load->model('facturacompra_model');
		$this->load->model('impuesto_model');
		$this->load->model('productos_model');
		$this->load->model('proveedor_model');
		$this->load->model('puc_model');
		$this->load->model('retencion_model');
		
		$this->load->library("pagination");
		$this->load->library("table");
	}
/********************************************************************************************/
	public function consultar() {
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Iniciar Sesión';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {
			$facturacompra_id = $this->uri->segment(3);
			$obtenerDatos = $this->facturacompra_model->consultar($facturacompra_id);
			$obtenerComprobante = $this->comprobanteegreso_model->consultar_ce_asoc($facturacompra_id);
			$data = array(
				'titulo' => 'Factura de Venta',
				'contenido' => 'backend/facturacompra_mostrar_view',
				'consulta_facturacompra' => $obtenerDatos,
				'consulta_comprobante' => $obtenerComprobante,
				'detallepuc' => $this->facturacompra_model->detallepuc($facturacompra_id)
			);
			$this->load->view('backend/template',$data);
		}
	}
/********************************************************************************************/
	public function consultarFC() {
		$id_beneficiario = $this->input->post('id');
		$fc = $this->facturacompra_model->consulta_fc_x_beneficiario($id_beneficiario);
		foreach ($fc as $key => $value) {
			$data1[$key] = array(
			'facturacompra_id' => $value->facturacompra_id, /*numero de la factura de compra*/
			'fc_total' => number_format($value->fc_total,2), /*total*/
			'fc_val_rete' => number_format($value->fc_val_rete,2), /*total*/
			'fc_x_pagar' => number_format($value->fc_x_pagar,2), /*por pagar*/
			'fc_val_pagado' => number_format($value->fc_val_pagado,2) /*valor pagado*/
			
			);
		}
		echo json_encode($data1);
	}
/********************************************************************************************/
	public function consultar_id_beneficiario() {
		$value = $this->input->post('id');
		$resultado = $this->facturacompra_model->consulta_id_beneficiario($value);
		foreach ($resultado as $value) {
			echo $value->relacion_id;
		}
		
	}
/********************************************************************************************/
	public function consultarPrecio() {
		$producto_id = $this->input->post('q');
		$obtenerProducto = $this->productos_model->obtenerProducto($producto_id);
		foreach($obtenerProducto as $row){
			$data = array(
				'precio' => $row->producto_precioventa,
				'impuesto' => $row->impuesto_id
			);
		}
		echo json_encode($data);
	}
/********************************************************************************************/
	public function datagrid() {
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Iniciar Sesión';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {			
			$data = array(
				'titulo' => 'Factura de Compra',
				'contenido' => 'backend/facturacompra_datagrid_view',
				'consulta_facturacompra_datagrid' => $this->facturacompra_model->getFacturaCompra()
			);
			$this->load->view("backend/template",$data);
		}
	}#fin_datagrid
/********************************************************************************************/
	public function eliminar() {
		$facturacompra_id = $this->uri->segment(3);
		$this->facturacompra_model->eliminar($facturacompra_id);
		redirect("facturacompra/datagrid");
	}
/********************************************************************************************/
	public function eliminarFila() {
		$facturacompra_id = $this->uri->segment(3);
		$fila = $this->input->post('fila', TRUE);
		$this->facturacompra_model->eliminarFila($facturacompra_id, $fila);
	}
/********************************************************************************************/
	public function guardar()	{
		$facturacompra = array(
			'facturacompra_id' => $this->input->post('facturacompra_numero', TRUE),
			'relacion_id' => $this->input->post('facturacompra_proveedor', TRUE),
			'usuario_id' => $this->session->userdata('usuario'),
			'facturacompra_fecha' => $this->input->post('fecha', TRUE),
			'facturacompra_fechavencimiento' => $this->input->post('fechavencimiento', TRUE),
			'facturacompra_observacion' => $this->input->post('facturacompra_observacion', TRUE),
			'fc_subtotal_sin_desc' => $this->input->post('fc_subtotal_sin_desc', TRUE),
			'fc_descuento' => $this->input->post('fc_descuento', TRUE),
			'fc_subtotal' => $this->input->post('fc_subtotal', TRUE),
			'fc_iva' => $this->input->post('fc_iva', TRUE),
			'fc_total' => $this->input->post('fc_total', TRUE)
		);
		
		/*llega el producto y el puc revueltos*/
		$detalle_prod_puc = array(
			'producto_id' => $this->input->post('facturacompra_producto', TRUE),
			'facturacompra_id' => $this->input->post('facturacompra_numero', TRUE),
			'detalleproducto_precio' => str_replace(',', '', $this->input->post('facturacompra_precio', TRUE)),
			'detalleproducto_descuento' => $this->input->post('facturacompra_descuento', TRUE),
			'impuesto_id' => $this->input->post('facturacompra_impuesto', TRUE),
			'detalleproducto_cantidad' => $this->input->post('facturacompra_cantidad', TRUE)
		);

		$this->guardar_detalle($detalle_prod_puc, FALSE, 0);

		$detalleretencion = array(
    	'ce_retencion' => $this->input->post('ce_retencion', TRUE),
    	'rete_valor' => $this->input->post('rete_valor', TRUE)
		);
		
		$this->facturacompra_model->guardar($facturacompra, $detalleretencion);
		redirect('facturacompra/datagrid');
	}# fin_guardar
/********************************************************************************************/
	public function guardar_detalle($data, $modificar, $id=0) {
		$j=0;
		for ($i=0; $i < count($data['producto_id']); $i++) {
			if ($this->like('E-%' ,$data['producto_id'][$i])) {
				$detallepuc = array(
					'fc_id' => $data['facturacompra_id'],
				 	'puc_id' => str_replace('E-', '', $data['producto_id'][$i]),
					'dpuc_precio' => $data['detalleproducto_precio'][$i],
					'dpuc_descuento' => $data['detalleproducto_descuento'][$i],
					'dpuc_impuesto' => $data['impuesto_id'][$i],
					'dpuc_cantidad' => $data['detalleproducto_cantidad'][$i],
					'dpuc_total' => ($data['detalleproducto_precio'][$i] * $data['detalleproducto_cantidad'][$i])
				);
				if ($modificar == TRUE) {
					$dpuc = $this->facturacompra_model->dpuc_id($id);
					$detallepuc['dpuc_id'] = $dpuc[$j]['dpuc_id'];
					$j++;
					$this->facturacompra_model->guardarDetalle('detallepuc', $detallepuc, TRUE, $detallepuc['dpuc_id']);
				}
				else{
					$this->facturacompra_model->guardarDetalle('detallepuc', $detallepuc, FALSE, -1);	
				}
			}
			else {
				$detalleproducto = array(
				 	'producto_id' => $data['producto_id'][$i],
					'facturacompra_id' => $data['facturacompra_id'],
					'detalleproducto_precio' => $data['detalleproducto_precio'][$i],
					'detalleproducto_descuento' => $data['detalleproducto_descuento'][$i],
					'impuesto_id' => $data['impuesto_id'][$i],
					'detalleproducto_cantidad' => $data['detalleproducto_cantidad'][$i]
				);
				if ($modificar == TRUE) {
					$detalleproducto['detalleproducto_id'] = $data['detalleproducto_id'][$i]['detalleproducto_id'];
					$this->facturacompra_model->guardarDetalle('detalleproducto', $detalleproducto, TRUE, $detalleproducto['detalleproducto_id']);
				}
				else{
					$this->facturacompra_model->guardarDetalle('detalleproducto', $detalleproducto, FALSE, -1);
				}
			}
		}
	}
/********************************************************************************************/
	public function guardarCambios() {
		$id = $this->uri->segment(3);
		
		$facturacompra = array(
			'facturacompra_id' => $this->input->post('facturacompra_numero', TRUE),
			'relacion_id' => $this->input->post('facturacompra_proveedor', TRUE),
			'usuario_id' => $this->session->userdata('usuario'),
			'facturacompra_fecha' => $this->input->post('fecha', TRUE),
			'facturacompra_fechavencimiento' => $this->input->post('fechavencimiento', TRUE),
			'facturacompra_observacion' => $this->input->post('facturacompra_observacion', TRUE),
			'fc_subtotal_sin_desc' => $this->input->post('fc_subtotal_sin_desc', TRUE),
			'fc_descuento' => $this->input->post('fc_descuento', TRUE),
			'fc_subtotal' => $this->input->post('fc_subtotal', TRUE),
			'fc_iva' => $this->input->post('fc_iva', TRUE),
			'fc_total' => $this->input->post('fc_total', TRUE)
		);
		// $this->facturacompra_model->mod_fc($facturacompra, $id);
		
		$detalleproducto = array(
			'detalleproducto_id' => $this->facturacompra_model->dpro_id($id),
			'facturacompra_id' => $this->input->post('facturacompra_numero', TRUE),
			'producto_id' => $this->input->post("facturacompra_producto",TRUE),
			'detalleproducto_precio' => $this->input->post("facturacompra_precio",TRUE),
			'detalleproducto_descuento' => $this->input->post("facturacompra_descuento",TRUE),
			'impuesto_id' => $this->input->post("facturacompra_impuesto",TRUE),
			'detalleproducto_cantidad' => $this->input->post("facturacompra_cantidad",TRUE)
		);
		$this->guardar_detalle($detalleproducto, TRUE, $id);
		redirect("facturacompra/datagrid");
	} # fin_guardarCambios
/********************************************************************************************/
	public function index() {
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Iniciar Sesión';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {
			$data = array(
				'titulo' => 'Factura de Compra',
				'contenido' => 'backend/facturacompra_view',
				'fc_id' => $this->facturacompra_model->consultar_fc_id(),
				'consulta_impuesto' => $this->impuesto_model->consultarImpuestos(),
				'consulta_categoria' => $this->unir_categoria($this->productos_model->consultarProductos()),
				'consulta_proveedor' => $this->proveedor_model->consultarProveedores(),
				'consulta_retencion' => $this->retencion_model->consultarRetencion()
			);
			// echo "<pre>";
			// var_dump($this->unir_categoria($this->productos_model->consultarProductos()));
			// echo "</pre>";
			$this->load->view("backend/template",$data);
		}
	}
/********************************************************************************************/
	public function modificar()	{
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Iniciar Sesión';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {
			$id = $this->uri->segment(3);
			$facturacompra = $this->facturacompra_model->obtenerFacturaCompra($id);

			if ($facturacompra != FALSE) {

				$detalle = array_merge($this->facturacompra_model->detalleproducto($id), $this->facturacompra_model->detallepuc($id));

				$categoria = $this->unir_categoria($this->productos_model->consultarProductos());
				$detalleretencion = $this->facturacompra_model->detalleretencion($id);
				$row = $facturacompra->row();
				
				$data = array(
					'id' => $id,
					'consulta_proveedor' => $this->proveedor_model->consultarProveedores(),
					'relacion_id' => $row->relacion_id,
					'facturacompra_observacion' => $row->facturacompra_observacion,
					'facturacompra_fecha' => $row->facturacompra_fecha,
					'facturacompra_fechavencimiento' => $row->facturacompra_fechavencimiento,
					'consulta_categoria' => $categoria,
					'consulta_impuesto' => $this->impuesto_model->consultarImpuestos(),
					'detalle' => $detalle,
					'consulta_retencion' => $this->retencion_model->consultarRetencion(),
					'detalleretencion' => $detalleretencion,
					'titulo' => 'Factura Compra',
					'contenido' => 'backend/facturacompra_modificar_view'
				);
			$this->load->view("backend/template", $data);
			}
		}
	} #fin_modificar
/********************************************************************************************/
	/**
	 * SQL Like operator in PHP.
	 * Returns TRUE if match else FALSE.
	 * @param string $pattern
	 * @param string $subject
	 * @return bool
	 */
	function like($pattern, $subject)	{
		$pattern = str_replace('%', '.*', preg_quote($pattern));
		return (bool) preg_match("/^{$pattern}$/i", $subject);
	}
	/*
		like('%uc%','Lucy'); //TRUE
		like('%cy', 'Lucy'); //TRUE
		like('lu%', 'Lucy'); //TRUE
		like('%lu', 'Lucy'); //FALSE
		like('cy%', 'Lucy'); //FALSE
	*/
/********************************************************************************************/
	public function totalProducto() {
		$cantidad = $this->input->post('c');
		$precio = $this->input->post('p');
		$descuento = $this->input->post('d');
		$sub = ($precio * $cantidad);
		$des = ($sub * ($descuento/100));
		$total_facturacompra = $sub - $des;
		$data = array(
			'total_facturacompra' => $total_facturacompra, /*subtotal*/
			'des' => $des, /*descuento*/
			'sub' => $sub /*subtoral_sin_desc*/
		);
		echo json_encode($data);
	}
/********************************************************************************************/
	/**
	 * Une los productos con el puc para formar la categoría.
	 * Retorna la lista de la categoría.
	 * @param $query->result() $productos
	 * @return array $categoria
	 */
	public function unir_categoria($productos) {
		$categoria = array();
		
		$cuenta = $this->puc_model->consultarGastosCuenta();
		$subcuenta = $this->puc_model->consultarGastosSubcuenta();
		
		$producto_id = array();
		$producto_nombre = array();
		$puc_id = array();
		$puc_nombre = array();
		$i = 0;
		
		foreach($productos as $pro) {
			$producto_id[$i] = $pro->producto_id;
			$producto_nombre[$i] = $pro->producto_nombre;
			$i++;
		}
		
		$categoria['item'] = array(
			'categoria_id' => $producto_id,
			'categoria_nombre' => $producto_nombre
		);
		
		foreach ($cuenta as $cta) {
			$puc_id[$i] = "E-".$cta->puc_id;
			$puc_nombre[$i] = $cta->puc_nombre;
			foreach ($subcuenta as $sub) {
				if($this->like($cta->puc_id."%", $sub->puc_id)) {
					$i++;
					$puc_id[$i] = "E-".$sub->puc_id;
					$puc_nombre[$i] = "&nbsp;&nbsp;&nbsp;&nbsp;".$sub->puc_nombre;
				}
			}
			$i++;
		}
		
		$categoria['puc'] = array(
			'categoria_id' => $puc_id,
			'categoria_nombre' => $puc_nombre
		);

		return $categoria;
	}
/********************************************************************************************/
}