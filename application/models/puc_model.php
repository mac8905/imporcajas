<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Puc_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	public function consultarActivoGrupo(){
		$this->db->select("*");
		$this->db->from("puc");
		$this->db->where("CHARACTER_LENGTH( puc_id ) = 2");
		$this->db->like('puc_id','1','after');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function consultarActivoCuenta(){
		$this->db->select("*");
		$this->db->from("puc");
		$this->db->where("CHARACTER_LENGTH( puc_id ) = 4");
		$this->db->like('puc_id','1','after');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function consultarActivoSubcuenta(){
		$this->db->select("*");
		$this->db->from("puc");
		$this->db->where("CHARACTER_LENGTH( puc_id ) = 6");
		$this->db->like('puc_id','1','after');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function consultarPasivoGrupo(){
		$this->db->select("*");
		$this->db->from("puc");
		$this->db->where("CHARACTER_LENGTH( puc_id ) = 2");
		$this->db->like('puc_id','2','after');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function consultarPasivoCuenta(){
		$this->db->select("*");
		$this->db->from("puc");
		$this->db->where("CHARACTER_LENGTH( puc_id ) = 4");
		$this->db->like('puc_id','2','after');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function consultarPasivoSubcuenta(){
		$this->db->select("*");
		$this->db->from("puc");
		$this->db->where("CHARACTER_LENGTH( puc_id ) = 6");
		$this->db->like('puc_id','2','after');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function consultarPatrimonioGrupo(){
		$this->db->select("*");
		$this->db->from("puc");
		$this->db->where("CHARACTER_LENGTH( puc_id ) = 2");
		$this->db->like('puc_id','3','after');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function consultarPatrimonioCuenta(){
		$this->db->select("*");
		$this->db->from("puc");
		$this->db->where("CHARACTER_LENGTH( puc_id ) = 4");
		$this->db->like('puc_id','3','after');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function consultarPatrimonioSubcuenta(){
		$this->db->select("*");
		$this->db->from("puc");
		$this->db->where("CHARACTER_LENGTH( puc_id ) = 6");
		$this->db->like('puc_id','3','after');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	//Consulta de ingresos
	public function consultarIngresosGrupo(){
		$this->db->select("*");
		$this->db->from("puc");
		$this->db->where("CHARACTER_LENGTH( puc_id ) = 2");
		$this->db->like('puc_id','4','after');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function consultarIngresosCuenta(){
		$this->db->select("*");
		$this->db->from("puc");
		$this->db->where("CHARACTER_LENGTH( puc_id ) = 4");
		$this->db->like('puc_id','4','after');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function consultarIngresosSubcuenta(){
		$this->db->select("*");
		$this->db->from("puc");
		$this->db->where("CHARACTER_LENGTH( puc_id ) = 6");
		$this->db->like('puc_id','4','after');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	//Consulta de gastos
	public function consultarGastosGrupo(){
		$this->db->select("*");
		$this->db->from("puc");
		$this->db->where("CHARACTER_LENGTH( puc_id ) = 2");
		$this->db->like('puc_id','5','after');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function consultarGastosCuenta(){
		$this->db->select("*");
		$this->db->from("puc");
		$this->db->where("CHARACTER_LENGTH( puc_id ) = 4");
		$this->db->like('puc_id','5','after');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function consultarGastosSubcuenta(){
		$this->db->select("*");
		$this->db->from("puc");
		$this->db->where("CHARACTER_LENGTH( puc_id ) = 6");
		$this->db->like('puc_id','5','after');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	//Costos de venta
	public function consultarVentaGrupo(){
		$this->db->select("*");
		$this->db->from("puc");
		$this->db->where("CHARACTER_LENGTH( puc_id ) = 2");
		$this->db->like('puc_id','6','after');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function consultarVentaCuenta(){
		$this->db->select("*");
		$this->db->from("puc");
		$this->db->where("CHARACTER_LENGTH( puc_id ) = 4");
		$this->db->like('puc_id','6','after');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function consultarVentaSubcuenta(){
		$this->db->select("*");
		$this->db->from("puc");
		$this->db->where("CHARACTER_LENGTH( puc_id ) = 6");
		$this->db->like('puc_id','6','after');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	//Costos de produccion
	public function consultarProduccionGrupo(){
		$this->db->select("*");
		$this->db->from("puc");
		$this->db->where("CHARACTER_LENGTH( puc_id ) = 2");
		$this->db->like('puc_id','7','after');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function consultarProduccionCuenta(){
		$this->db->select("*");
		$this->db->from("puc");
		$this->db->where("CHARACTER_LENGTH( puc_id ) = 4");
		$this->db->like('puc_id','7','after');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function consultarProduccionSubcuenta(){
		$this->db->select("*");
		$this->db->from("puc");
		$this->db->where("CHARACTER_LENGTH( puc_id ) = 6");
		$this->db->like('puc_id','7','after');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	//Cuentas de orden deudoras
	public function consultarDeudorasGrupo(){
		$this->db->select("*");
		$this->db->from("puc");
		$this->db->where("CHARACTER_LENGTH( puc_id ) = 2");
		$this->db->like('puc_id','8','after');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function consultarDeudorasCuenta(){
		$this->db->select("*");
		$this->db->from("puc");
		$this->db->where("CHARACTER_LENGTH( puc_id ) = 4");
		$this->db->like('puc_id','8','after');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function consultarDeudorasSubcuenta(){
		$this->db->select("*");
		$this->db->from("puc");
		$this->db->where("CHARACTER_LENGTH( puc_id ) = 6");
		$this->db->like('puc_id','8','after');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	//Cuentas de orden acreedoras
	public function consultarAcreedorasGrupo(){
		$this->db->select("*");
		$this->db->from("puc");
		$this->db->where("CHARACTER_LENGTH( puc_id ) = 2");
		$this->db->like('puc_id','9','after');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function consultarAcreedorasCuenta(){
		$this->db->select("*");
		$this->db->from("puc");
		$this->db->where("CHARACTER_LENGTH( puc_id ) = 4");
		$this->db->like('puc_id','9','after');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function consultarAcreedorasSubcuenta(){
		$this->db->select("*");
		$this->db->from("puc");
		$this->db->where("CHARACTER_LENGTH( puc_id ) = 6");
		$this->db->like('puc_id','9','after');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}	
	
	public function consultarPuc(){
		$this->db->select("*");
		$this->db->from("puc");
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}	
	}
	
}// fin de la clase