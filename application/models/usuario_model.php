<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario_model extends CI_Model{

	function __construct(){
		parent::__construct();
	}
	
	public function guardar($data, $numero){
		$this->db->insert('usuario', $data); 
		$this->db->where($data);
		$query = $this->db->get('usuario'); 
		if($query->num_rows() > 0){ 
			$row = $query->row(); 
			$telefono = array( 
				"telefono_numero" => $numero, 
				"usuario_id" => $row->usuario_id 
			);
			$this->db->insert('TelefonoUsuario',$telefono);
		}else{
			return FALSE;
		}
	}
	
	public function consultarPerfil(){
		$query = $this->db->get("perfilusuario");
		if($query->num_rows() > 0){
			return $query;
		}else{
			return FALSE;
		}
	}
	
	public function datagrid($numeropaginas,$inicio){
		$this->db->limit($numeropaginas,$inicio);
		$this->db->select("usuario_id,usuario_nombre,usuario_correo,perfil_nombre,usuario_estado");
		$this->db->from("usuario AS usu ,perfilusuario AS per");
		$this->db->where("usu.perfil_id = per.perfil_id");
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function totalRegistros(){
		return $this->db->count_all("Usuario");
	}
	
	public function eliminar($usuario_id){
		$this->db->where("usuario_id",$usuario_id);
		$this->db->delete("Usuario");
	}
	
	public function modificar($usuario_id){
		$this->db->select("*");
		$this->db->from("usuario AS usu,perfilusuario AS per,telefonousuario AS tel");
		$this->db->where("usu.usuario_id = $usuario_id");
		$this->db->where("usu.perfil_id = per.perfil_id");
		$this->db->where("usu.usuario_id = tel.usuario_id");
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query;
		}else{
			return FALSE;
		}
	}
	
	public function modificarDatos($usuario_id,$data,$telefono){
		
		$this->db->where("usuario_id",$usuario_id);
		$this->db->update("usuario as usu ",$data);
		$this->db->where("usuario_id",$usuario_id);
		$this->db->update("telefonousuario as tel",$telefono);
	}
	
	public function modificarContrasena($usuario_id,$data){
		$this->db->where("usuario_id",$usuario_id);
		$this->db->update("usuario",$data);
	}
	
	public function consultar($usuario_id){
		$this->db->select("*");
		$this->db->from("usuario AS usu,perfilusuario AS per,telefonousuario AS tel");
		$this->db->where("usu.usuario_id = $usuario_id");
		$this->db->where("usu.perfil_id = per.perfil_id");
		$this->db->where("usu.usuario_id = tel.usuario_id");
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query;
		}else{
			return FALSE;
		}
	}
	
}//fin de la clase usuario_model