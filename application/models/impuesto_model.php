<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Impuesto_Model extends CI_Model{

	function __construct(){
		parent::__construct();
	}
	
	public function guardar($data){
		$this->db->insert('Impuesto',$data);
	}
	
	#Método para retornar los registros de la tabla impuesto
	public function datagrid(){
		$query = $this->db->get("Impuesto");
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}//Fin metodo datagrid
	
	#Método para eliminar los registros de la tabla impuesto
	public function eliminar($id){
		$this->db->where("impuesto_id",$id);
		$this->db->delete("Impuesto");
	}//Fin del método eliminar
	
	#Método que retorna los registros al formulario de modificar
	public function obtenerDatos($id){
		$query = $this->db->query("SELECT *
								   FROM Impuesto
								   WHERE impuesto_id=$id");
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}//Fin del método obtenerDatos
	
	public function modificarEnlace($id,$data){
		$this->db->where('impuesto_id',$id);
		$this->db->update('impuesto',$data);
	}
	
	public function consultarImpuesto() {
		$query = $this->db->get("Impuesto");
		if($query->num_rows() > 0){
			return $query;
		}else{
			return FALSE;
		}
	}
	
	public function consultarImpuestos() {
		$query = $this->db->get("Impuesto");
		if($query->num_rows() > 0){
			return $query;
		}else{
			return FALSE;
		}
	}	

}//Fin de la clase impuesto_model