<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model{
	/*la clase Login_model hereda los métodos y atributos de la clase padre CI_Model*/
	function __construct(){
		parent::__construct();
	}
	/* esta funcion recibe 2 parámetros, el primero recibe el correo y el segundo la contraseña, ambos del controlador Login*/
	public function validar_usuario($correo,$contraseña){
		
		$this->db->where('usuario_correo',$correo); /*el método db del padre CI_Model permite conectar con la base de datos y hacer las consultas o peticiones a la Base de Datos bd_imporcajas*/
		$this->db->where('usuario_password',$contraseña); /*where ejecuta la consulta: "select usuario_password"*/
		$query = $this->db->get('Usuario'); /*get ejectua la consulta "from Usuario"*/
		return $query->row(); /* se retorna la consulta realizada a la base de datos*/
	}

	public function usuario($correo)
	{
		$this->db->where('usuario_correo',$correo);
		$query = $this->db->get('Usuario');
		return $query->row();
	}
	
}

?>