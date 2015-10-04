<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller{

	private $usuario_id;
	private $correo;
	private $password;
	private $perfil;
	
	public function __construct(){
		parent::__construct();
		$this->correo = "";
		$this->password = "";
		$this->perfil = 0;
		$this->load->model('login_model');
		$this->load->library('encrypt');
	}
	
	public function setCorreo($correo){
		$this->correo = $correo;
	}
	
	public function getCorreo(){
		return $this->correo;
	}

	public function setPassword($password){
		$this->password = $password;
	}
	
	public function getPassword(){
		return $this->password;
	}
	
	public function getPerfil(){
		return $this->perfil;
	}
	
	public function setPerfil($perfil){
		$this->perfil = $perfil;
	}

	public function getUsuario_id(){
		return $this->usuario_id;
	}
	
	public function setUsuario_id($usuario_id){
		$this->usuario_id = $usuario_id;
	}
	
	public function index(){
		$this->load->view('frontened/template', $this->data());
	}
	
	public function validar(){
		
		if(!isset($_POST['usuario_correo'])){
			$this->load->view('frontened/template', $this->data());
		}
		else{
			$this->form_validation->set_rules('usuario_correo','Correo','required|trim|valid_email');
			$this->form_validation->set_rules('usuario_password','Contraseña','required|trim|min_length[8]');
			
			$this->form_validation->set_message('required', 'El campo %s  es obligatoio.');
			$this->form_validation->set_message('valid_email', 'El campo %s no es válido.');
			$this->form_validation->set_message('min_length', 'El campo %s debe contener mínimo 8 caracteres.');
			
			if($this->form_validation->run()==FALSE){
				$this->load->view('frontened/template', $this->data());
			}
			else {
				
				$correo = $this->input->post('usuario_correo', TRUE);
				$password = $this->input->post('usuario_password',TRUE);
				
				$hash = sha1($password);
				
				$this->setCorreo($correo);
				$this->setPassword($hash);
				
				$usuario = array( 
					'correo' => $this->getCorreo(), 
					'password' => $this->getPassword(),
				);
				
				$existedatos = $this->login_model->validar_usuario($usuario['correo'],$usuario['password']);
				
				if($existedatos==TRUE){
					// $data = array(
					// 	'consulta' => $existedatos
					// );
					// foreach($data as $row){
					// 	$consultar = $row->perfil_id;
					// 	$nombre = $row->usuario_nombre;
					// }
				
					if($existedatos==TRUE){
						$usuario = array();
						$query = $this->login_model->usuario($this->getCorreo());
						/*ESTABLECER LOS DATOS DE LA SESIÓN*/
						$usuario['usuario'] = $query->usuario_id;
						$usuario['perfil'] = $query->perfil_id;
						$usuario['nombre'] = $query->usuario_nombre;
						$usuario['correo'] = $query->usuario_correo;
						$usuario['estado'] = $query->usuario_estado;
						$this->session->set_userdata($usuario);
						//$correo = $this->session->userdata('correo');
						// if ($usuario['estado'] == 'Activado') {
							redirect('principal/bandeja_entrada');
						// }
						// else {
						// 	redirect("login");
						// }
					}/*else if($existedatos==TRUE && $consultar == 2){
						$this->session->set_userdata($usuario);
						redirect('principal/bandeja_limitada');
					}*/
				}
				else{
					#$error['error'] = "E-mail o password incorrecto, por favor vuelva a intentar";
					$data = array(
						'error' => "E-mail/password incorrecto.",
						'contenido' => 'frontened/login' ,
						'titulo' => 'Iniciar Sesión'
					);
					$this->load->view('frontened/template', $data);
				}
			}
		}
	}//Fin de la funcion validar
	
	public function data() {
		$data['contenido'] = 'frontened/login';
		$data['titulo'] = 'Iniciar Sesión';
		return $data;
	}
	
}//Fin de la clase login
