<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Retencion_Model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}
	
	public function guardar($data){
		$this->db->insert('Retencion',$data);
	}
	
	public function datagrid(){
		$query = $this->db->query("SELECT re.retencion_id,re.retencion_nombre,ti.tiporetencion_nombre,re.retencion_base_uvt,re.retencion_base_pesos,re.retencion_porcentaje,re.retencion_descripcion  
								   FROM retencion re, tiporetencion ti 
								   WHERE re.tiporetencion_id = ti.tiporetencion_id");
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function eliminar($id){
		$this->db->where("retencion_id",$id);
		$this->db->delete("Retencion");
	}
	
	public function obtenerDatos($id){
		$query = $this->db->query("SELECT *
								   FROM retencion re, tiporetencion ti 
								   WHERE re.retencion_id = $id and re.tiporetencion_id = ti.tiporetencion_id");
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function modificarEnlace($id,$data){
		$this->db->where("retencion_id",$id);
		$this->db->update("retencion",$data);
	}
	
	public function consultarRetencion(){
		$this->db->select("*");
		$this->db->from("retencion");
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query;
		}else{
			return FALSE;
		}		
	}
	
}