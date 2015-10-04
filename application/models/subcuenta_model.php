<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subcuenta_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	public function guardar($data){
		$this->db->insert("puc",$data);
	}
	
	public function consultar($subcuenta_id){
		$this->db->select("*");
		$this->db->from("puc");
		$this->db->where("puc_id = $subcuenta_id");
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}	
	}
	
	public function modificar($subcuenta_id){
		$this->db->select("*");
		$this->db->from("puc");
		$this->db->where("puc_id = $subcuenta_id");
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query;
		}else{
			return FALSE;
		}	
	}
	
	public function modificarDatos($subcuenta_id,$data){
		$this->db->where("puc_id",$subcuenta_id);
		$this->db->update("puc",$data);
	}
	
	public function eliminar($subcuenta_id){
		$this->db->where("puc_id",$subcuenta_id);
		$this->db->delete("puc");
	}
	
}// fin de la clase