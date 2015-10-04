<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MetodoPago_model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}
	
	public function guardar($data){
		$this->db->insert('metodopago',$data);
	}
	
	public function datagrid(){
		$query = $this->db->get('metodopago');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function eliminar($id){
		$this->db->where('metodopago_id',$id);
		$this->db->delete('metodopago');
	}
	
	public function modificar($id){
		$this->db->where('metodopago_id',$id);
		$query = $this->db->get('metodopago');
		if($query->num_rows() > 0){
			return $query;
		}else{
			return false;
		}
	}
	
	public function modificarDatos($id,$data){
		$this->db->where('metodopago_id',$id);
		$this->db->update('metodopago',$data);
	}
	
	public function consultarMetodoPago(){
		$query = $this->db->get('metodopago');
		if($query->num_rows() > 0){
			return $query;
		}else{
			return FALSE;
		}		
	}
	
}//fin de la clase