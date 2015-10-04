<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Regimen_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}
	#Método que guarda la información en la tabla regimen de la base de datos
	public function guardar_regimen($data){
		$this->db->insert('Regimen',$data);
	}
	
	#Método que realiza una consulta de los datos de la tabla regimen
	public function consultar_regimen(){
		$consulta = $this->db->query('select regimen_nombre,regimen_id from regimen');	
		if ($consulta->num_rows() > 0) {
			return $consulta;
		}
		else {
			return FALSE;
		}
	}//fin consultar_regimen
	
	#Método que retorna los datos de la tabla regimen
	public function datagrid(){
		$query = $this->db->get('Regimen');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}//Fin del método datagrid
	
	#Método que elimina los registros de la tabla régimen
	public function eliminar($id){
		$this->db->where('regimen_id',$id);
		$this->db->delete('Regimen');
	}//fin del método eliminar
	
	#Método que retorna los datos guardados en la base de datos
	public function obtenerDatos($id){
		$query = $this->db->query("SELECT * 
								   FROM regimen
								   WHERE regimen_id = $id");
		if($query->num_rows() > 0){
			return $query;
		}
		else{
			return false;
		}
	}//fin del método obtenerEnlace
	
	public function modificarEnlace($id,$data){
		$this->db->where('regimen_id',$id);
		$this->db->update('Regimen',$data);
	}
	
}//fin de la clase regimen_model