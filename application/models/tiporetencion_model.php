<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tiporetencion_Model extends CI_Model{

	function __construct(){
		parent::__construct();
	}
	
	public function guardar($data){
		$this->db->insert("tiporetencion",$data);
	}
	
	public function datagrid(){
		$query = $this->db->get("tipoRetencion");
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function eliminar($id){
		$this->db->where("tiporetencion_id",$id);
		$this->db->delete("tiporetencion");
	}
	
	public function modificar($id){
		$query = $this->db->query("SELECT *
								   FROM tiporetencion
								   WHERE tiporetencion_id = $id");
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function modificarEnlace($id,$data){
		$this->db->where("tiporetencion_id",$id);
		$this->db->update("tiporetencion",$data);
	}
	
	public function consultatiporetencion(){
		$query = $this->db->get("tipoRetencion");
		if($query->num_rows() > 0){
			return $query;
		}else{
			return FALSE;
		}
	}
	
}