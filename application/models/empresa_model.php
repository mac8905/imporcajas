<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Empresa_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	public function obtenerDatos(){
		$this->db->select("*");
		$this->db->from("empresa AS em, regimen AS re");
		$this->db->where("em.empresa_regimenid = re.regimen_id");
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function consultarRegimen(){
		$this->db->select("*");
		$this->db->from("regimen");
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALsE;
		}
	}
	
	public function modificarDatos($data){
		$this->db->update("empresa",$data);
	}
	
}