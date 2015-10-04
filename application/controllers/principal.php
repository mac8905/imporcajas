<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); /*no permite que un script ingrese directamente por la URL*/
class Principal extends CI_Controller{
/*La clase principal hereda de la clase padre CI_Controller todos los métodos y atributos*/
	function __construct(){	
		parent::__construct();
	}
/*Index es el método principal de la clase, pues es éste el que primero muestra la visualización de la página*/
	public function index(){
		$data['contenido'] = 'frontened/welcome';	/*almacena en el índice contenido el archivo welcome.php que se encuentra dentro de la carpeta frontened*/
		$data['titulo'] = 'Bienvenido'; /*título de la página, será mostrado en el la barra de navegación superior*/
		$this->load->view('frontened/template', $data); /*el método load es heredado del padre CI_Controller y tiene la tarea de enrutar las URL y enviar datos a ellas. El método recibe 2 parámetros; el primero para cargar la plantilla (encabezado y pie de página, archivos css, bootstrap, jquery, ajax, etc..) y un 2 parámetro que se encarga de recibir un arreglo*/
	}
	/*Éste método muestra la bandeja de entrada de la aplicación*/
	public function bandeja_entrada() {
		/*Se valida si el usuario ha iniciado correctamente sesión mediante el correo*/
		/*Si los datos son erróneos se reenvía a la página de iniciar sesión*/
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Iniciar Sesión';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		/* Si por el contrario los datos son correctos se carga la vista de la bandeja de entrada */
		else {
			$data['contenido'] = 'backend/bandeja_entrada';
			$data['titulo'] = 'Principal';
			$data['correo'] = $this->session->userdata('correo');
			$this->load->view('backend/template', $data);
		}
	}
	
	public function bandeja_limitada() {
		if (!$this->session->userdata('correo')) {
			$data['contenido'] = 'frontened/login';
			$data['titulo'] = 'Iniciar Sesión';
			$this->load->view('frontened/template', $data);
			redirect("login");
		}
		else {
			$data['contenido'] = 'backend/bandeja_limitada';
			$data['titulo'] = 'Principal';
			$data['correo'] = $this->session->userdata('correo');
			$this->load->view('backend/template', $data);
		}
	}
	/*el método se llama para llevar al usuario a la página de inicio de sesión*/
	public function login() {
		$data['contenido'] = 'frontened/login';
		$data['titulo'] = 'Iniciar Sesión';
		$this->load->view('frontened/template', $data);
	}
	/*el método se utiliza para destruir la sesión*/
	public function logout() {
		$this->session->sess_destroy();
		redirect('login');
	}

	public function acercade() {
		$data['contenido'] = 'frontened/acercade';
		$data['titulo'] = 'Acerca de';
		$this->load->view('frontened/template', $data);
	}
}