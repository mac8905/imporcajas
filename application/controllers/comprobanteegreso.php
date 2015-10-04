<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ComprobanteEgreso extends CI_Controller{
	function __construct(){

		parent::__construct();

		$this->load->model("cliente_model");
		$this->load->model("comprobanteegreso_model");
		$this->load->model("impuesto_model");
		$this->load->model("metodopago_model");
		$this->load->model("puc_model");
		$this->load->model("retencion_model");

		$this->load->library("pagination");
		$this->load->library("table");

	}
	
	public function datagrid() {

		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Iniciar Sesión';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {
			$config['base_url'] = base_url()."comprobanteegreso/datagrid";
			$config['total_rows'] = $this->comprobanteegreso_model->getRegistros();
			$config['per_page'] = '10';
			$config['num_links'] = '2';
			$config['prev_link'] = 'anterior';
			$config['next-link'] = 'siguiente';
			$config['uri_segment'] = '3';
			$config['first_link'] = '<<';
			$config['last_link'] = '>>';
			$this->pagination->initialize($config);

			$data = array(
				'titulo' => 'Comprobante de Egreso',
				'contenido' => 'backend/comprobanteegreso_datagrid_view',
				'consulta_comprobanteegreso_datagrid' => $this->comprobanteegreso_model->getComprobanteEgreso($config['per_page'],$this->uri->segment(3))
			);
			$this->load->view("backend/template",$data);
		}
	}

	public function index($fc_id = "") {
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Iniciar Sesión';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {
				$data = array(
					'titulo' => 'Comprobante de Egreso',
					'contenido' => 'backend/comprobanteegreso_view',
					'ce_id' => $this->comprobanteegreso_model->consultar_ce_id(),
					'consulta_beneficiario' => $this->cliente_model->consultarBeneficiarios(),
					'consulta_metodo' => $this->metodopago_model->consultarMetodoPago(),
					'consulta_puc' => $this->puc_model->consultarPuc(),
					'consulta_impuesto' => $this->impuesto_model->consultarImpuestos(),
					'consulta_retencion' => $this->retencion_model->consultarRetencion(),
					'fc_id' => $fc_id
				);
			$this->load->view("backend/template",$data);
		}
	}
/*Método para guardar un Comprobante de Egreso sin Asociar*/
	public function guardar() {
		$ce = array(
      'ce_id' => $this->input->post('ce_id', TRUE),
			'ce_beneficiario' => $this->input->post('ce_beneficiario', TRUE),
			'ce_metodopago' => $this->input->post('ce_metodopago', TRUE),
			'ce_fecha' => $this->input->post('ce_fecha', TRUE),
			'ce_observacion' => $this->input->post('ce_observacion', TRUE)
		);
		$dce = array(
    	'dce_categoria' => $this->input->post('dce_categoria', TRUE),
    	'dce_valor' => $this->input->post('dce_valor', TRUE),
    	'dce_impuesto' => $this->input->post('dce_impuesto', TRUE),
    	'dce_cantidad' => $this->input->post('dce_cantidad', TRUE),
    	'dce_total' => $this->input->post('dce_total', TRUE),
    	'ce_id' => $this->input->post('ce_id', TRUE),
    	'fc_id' => $this->input->post('fc_id', TRUE)
    );
    $detalle_retencion = array(
    	'ce_retencion' => $this->input->post('ce_retencion', TRUE),
    	'rete_valor' => $this->input->post('rete_valor', TRUE),
		);

		// NOTA: al rete_valor hay que quitarle el formato de numero para guardarlo.
    echo "<pre>";
    print_r($ce);
    echo "</pre>";
    echo "<br><pre>";
    print_r($dce);
    echo "</pre>";
    echo "<br><pre>";
    print_r($detalle_retencion);
    echo "</pre>";
	}
/*Método para guardar un Comprobante de Egreso Asociado a una Factura de Compra*/
	public function guardar_fc_asoc() {
		$ce = array(
      'ce_id' => $this->input->post('ce_id', TRUE),
			'ce_beneficiario' => $this->input->post('ce_beneficiario', TRUE),
			'ce_metodopago' => $this->input->post('ce_metodopago', TRUE),
			'ce_fecha' => $this->input->post('ce_fecha', TRUE),
			'ce_observacion' => $this->input->post('ce_observacion', TRUE),
			'ce_total' => $this->input->post('fc_totales', TRUE)
		);
		
		$fc = array(
			'fc_id' => $this->input->post('fc_numero', TRUE),
			'fc_val_pagar' => $this->input->post('fc_val_pagar', TRUE), /*hace referencia a fc_val_pagado*/
			'fc_x_pagar' => $this->input->post('input_fc_x_pagar', TRUE), /*hace referencia a fc_val_pagado*/
		);

    $this->comprobanteegreso_model->guardar_fc_asoc($ce, $fc);
		redirect('facturacompra/datagrid');
	}

	public function totalCategoria()
	{
		$cantidad = $this->input->post('c');
		$valor = $this->input->post('p');
		$dce_total = ($valor * $cantidad);
		$data = array(
			'dce_total' => $dce_total /*subtotal*/
		);
		echo json_encode($data);
	}
}