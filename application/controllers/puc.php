<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Puc extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model("puc_model");
		$this->load->library("table");
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
				'titulo' => 'Plan Único de Cuentas',
				'contenido' => 'backend/puc_view'
			);
			$this->load->view("backend/template",$data);
		}
	}

	public function datagridActivos(){
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Login';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {
			$data = array(
				'titulo' => 'Activo',
				'contenido' => 'backend/activo_datagrid_view',
				'datagrid_activos' => $this->puc_model->consultarActivoGrupo(),
				'datagrid_cuenta' => $this->puc_model->consultarActivoCuenta(),
				'datagrid_subcuenta' => $this->puc_model->consultarActivoSubcuenta() 
			);
			$this->load->view("backend/template",$data);
		}
	}
	
	public function datagridPasivo(){
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Login';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {
			$data = array(
				'titulo' => 'Pasivo',
				'contenido' => 'backend/pasivo_datagrid_view',
				'datagrid_pasivos' => $this->puc_model->consultarPasivoGrupo(),
				'datagrid_cuenta' => $this->puc_model->consultarPasivoCuenta(),
				'datagrid_subcuenta' => $this->puc_model->consultarPasivoSubcuenta() 
			);
			$this->load->view("backend/template",$data);
		}
	}
	
	public function datagridPatrimonio(){
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Login';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {
			$data = array(
				'titulo' => 'Patrimonio',
				'contenido' => 'backend/patrimonio_datagrid_view',
				'datagrid_patrimonio' => $this->puc_model->consultarPatrimonioGrupo(),
				'datagrid_cuenta' => $this->puc_model->consultarPatrimonioCuenta(),
				'datagrid_subcuenta' => $this->puc_model->consultarPatrimonioSubcuenta() 
			);
			$this->load->view("backend/template",$data);
		}
	}
	
	public function datagridIngresos(){
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Login';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {
			$data = array(
				'titulo' => 'Ingresos',
				'contenido' => 'backend/ingresos_datagrid_view',
				'datagrid_ingresos' => $this->puc_model->consultarIngresosGrupo(),
				'datagrid_cuenta' => $this->puc_model->consultarIngresosCuenta(),
				'datagrid_subcuenta' => $this->puc_model->consultarIngresosSubcuenta()
			);
			$this->load->view("backend/template",$data);
		}
	}
	
	public function datagridGastos(){
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Login';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {
			$data = array(
				'titulo' => 'Gastos',
				'contenido' => 'backend/gastos_datagrid_view',
				'datagrid_gastos' => $this->puc_model->consultarGastosGrupo(),
				'datagrid_cuenta' => $this->puc_model->consultarGastosCuenta(),
				'datagrid_subcuenta' => $this->puc_model->consultarGastosSubcuenta()
			);
			$this->load->view("backend/template",$data);
		}
	}
	
	public function datagridVenta(){
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Login';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {
			$data = array(
				'titulo' => 'Costos de Venta',
				'contenido' => 'backend/venta_datagrid_view',
				'datagrid_venta' => $this->puc_model->consultarVentaGrupo(),
				'datagrid_cuenta' => $this->puc_model->consultarVentaCuenta(),
				'datagrid_subcuenta' => $this->puc_model->consultarVentaSubcuenta()
			);
			$this->load->view("backend/template",$data);
		}
	}

	public function datagridProduccion(){
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Login';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {
			$data = array(
				'titulo' => 'Costos de Producción',
				'contenido' => 'backend/produccion_datagrid_view',
				'datagrid_produccion' => $this->puc_model->consultarProduccionGrupo(),
				'datagrid_cuenta' => $this->puc_model->consultarProduccionCuenta(),
				'datagrid_subcuenta' => $this->puc_model->consultarProduccionSubcuenta()
			);
			$this->load->view("backend/template",$data);
		}
	}	

	public function datagridDeudoras(){
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Login';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {
			$data = array(
				'titulo' => 'Cuentas de orden deudoras',
				'contenido' => 'backend/deudoras_datagrid_view',
				'datagrid_deudoras' => $this->puc_model->consultarDeudorasGrupo(),
				'datagrid_cuenta' => $this->puc_model->consultarDeudorasCuenta(),
				'datagrid_subcuenta' => $this->puc_model->consultarDeudorasSubcuenta()
			);
			$this->load->view("backend/template",$data);
		}
	}

	public function datagridAcreedoras(){
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Login';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {
			$data = array(
				'titulo' => 'Cuentas de orden acreedoras',
				'contenido' => 'backend/acreedoras_datagrid_view',
				'datagrid_acreedoras' => $this->puc_model->consultarAcreedorasGrupo(),
				'datagrid_cuenta' => $this->puc_model->consultarAcreedorasCuenta(),
				'datagrid_subcuenta' => $this->puc_model->consultarAcreedorasSubcuenta()
			);
			$this->load->view("backend/template",$data);
		}
	}		
	
}// fin de la clase 