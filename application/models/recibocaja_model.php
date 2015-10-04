<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recibocaja_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	public function guardar($data,$detalle,$retencion){
		$this->db->insert('recibocaja',$data);
		$query = $this->db->get_where('recibocaja',$data);
		if($query->num_rows() >= 1){
			$facturaventa_row =$query->row();
			for($i=0; $i<(count($detalle['puc_id'])); $i++) {
				$detalle_recibo = array(
					'puc_id' => $detalle['puc_id'][$i],
					'impuesto_id' => $detalle['impuesto_id'][$i],
					'recibocaja_id' => $facturaventa_row->recibocaja_id,
					'detallerecibo_valor' => $detalle['detallerecibo_valor'][$i],
					'detallerecibo_cantidad' => $detalle['detallerecibo_cantidad'][$i]
				);
				$this->db->insert('detallerecibo',$detalle_recibo);
			}

			for($j=0; $j<(count($retencion['retencion_id'])); $j++) {
				$detalle_retencion = array(
					'retencion_id' => $retencion['retencion_id'][$j],
					'retencion_valor' => $retencion['retencion_valor'][$j],
					'recibocaja_id' => $facturaventa_row->recibocaja_id
				);
				$this->db->insert('detalleretencion',$detalle_retencion);
			}			
		}//Fin de la estructura if
	}
	
	public function getReciboCaja($numeroRegistros,$inicio){
		$this->db->limit($numeroRegistros,$inicio);
		$this->db->select("	rec.recibocaja_id,
		                  	re.relacion_nombre,
												rec.recibocaja_fecha,
										   	me.metodopago_nombre,
										   	rec.recibocaja_observacion");
		$this->db->from("recibocaja AS rec, relacion AS re, metodopago AS me");
		$this->db->where("rec.relacion_id = re.relacion_id");
		$this->db->where("rec.metodopago_id = me.metodopago_id");
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function getRegistros(){
		return $this->db->count_all('recibocaja');
	}
	
	public function consultar($id){
		$query = $this->db->query("
			select	re.recibocaja_id,
					rel.relacion_nombre,
					me.metodopago_nombre,
					re.recibocaja_fecha,
					re.recibocaja_observacion,
					pu.puc_nombre,
					im.impuesto_nombre,
					im.impuesto_porcentaje,
					de.detallerecibo_valor,
					de.detallerecibo_cantidad
			from 	recibocaja AS re 	INNER JOIN relacion AS rel ON re.relacion_id = rel.relacion_id
										INNER JOIN metodopago AS me ON me.metodopago_id = re.metodopago_id 
										INNER JOIN detallerecibo AS de ON de.recibocaja_id = re.recibocaja_id
										INNER JOIN impuesto AS im ON im.impuesto_id = de.impuesto_id
										INNER JOIN puc AS pu ON pu.puc_id = de.puc_id
			where  	re.recibocaja_id = $id
			order by re.recibocaja_id DESC");
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return "No hay datos";
			}
	}
	
	public function consultarRetencion($id){
		$query = $this->db->query("
			SELECT der.retencion_id, der.retencion_valor, ret.retencion_nombre
			FROM recibocaja AS re
			INNER JOIN detalleretencion AS der ON der.recibocaja_id = re.recibocaja_id
			INNER JOIN retencion AS ret ON ret.retencion_id = der.retencion_id
			WHERE re.recibocaja_id = $id
		");
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return "No hay datos";
			}		
	}
	
	public function obtenerDatos($id){
		$query = $this->db->query("
			SELECT
				rb.recibocaja_id,
				rb.relacion_id,
				rb.metodopago_id,
				rb.recibocaja_fecha,
				rb.recibocaja_observacion,
				GROUP_CONCAT(de.puc_id) puc_id,
				GROUP_CONCAT(de.impuesto_id) impuesto_id,
				GROUP_CONCAT(de.detallerecibo_valor) detallerecibo_valor,
				GROUP_CONCAT(de.detallerecibo_cantidad) detallerecibo_cantidad
			FROM recibocaja AS rb, detallerecibo AS de 
			WHERE rb.recibocaja_id = $id 
			AND rb.recibocaja_id = de.recibocaja_id
		");
		if($query->num_rows() > 0){
			return $query;
		}else{
			return FALSE;
		}
	}
	
	public function obtenerRetencion($id){
		$query = $this->db->query("
			SELECT 	GROUP_CONCAT(dr.retencion_id) retencion_id,
					GROUP_CONCAT(dr.retencion_valor) retencion_valor
			FROM 	recibocaja AS rb, detalleretencion AS dr  
			WHERE 	rb.recibocaja_id = $id 
			AND 	rb.recibocaja_id = dr.recibocaja_id
		");
		if($query->num_rows > 0){
			return $query;
		}else{
			return FALSE;
		}
	}
	
	public function consultarDetalleReciboId($id){
		$query = $this->db->query("
			SELECT
				detallerecibo_id
			FROM
				detallerecibo
			WHERE
				recibocaja_id = $id");
		
		if($query->num_rows() > 0){
			return $query;
		}else{
			return FALSE;
		}
	}
	
	public function consultarDetalleRetencionId($id){
		$query = $this->db->query("
			SELECT
				detalleretencion_id
			FROM
				detalleretencion
			WHERE
				recibocaja_id = $id");
		
		if($query->num_rows() > 0){
			return $query;
		}else{
			return FALSE;
		}
	}

	public function modificarDatos($id,$data,$detalle,$retencion){
		$this->db->where('recibocaja_id',$id);
		$this->db->update('recibocaja',$data);
		
		foreach($detalle['detallerecibo_id']->result() as $key => $row){
			$arr[$key] = $row->detallerecibo_id;
			$key++;
		}
		#Modificar datos de las cuentas del recibo de caja
		for($i=0; $i<(count($detalle['puc_id'])); $i++) {
			if ($i < count($arr)) {
				$this->db->where('detallerecibo_id', $arr[$i]);
				$detalle_recibo = array(
					'puc_id' => $detalle['puc_id'][$i],
					'recibocaja_id' => $id,
					'detallerecibo_cantidad' => $detalle['detallerecibo_cantidad'][$i],
					'detallerecibo_valor' => $detalle['detallerecibo_valor'][$i],
					'impuesto_id' => $detalle['impuesto_id'][$i]
				);
				$this->db->update('detallerecibo',$detalle_recibo);
			}
			else {
				$detalle_recibo = array(
					'puc_id' => $detalle['puc_id'][$i],
					'recibocaja_id' => $id,
					'detallerecibo_cantidad' => $detalle['detallerecibo_cantidad'][$i],
					'detallerecibo_valor' => $detalle['detallerecibo_valor'][$i],
					'impuesto_id' => $detalle['impuesto_id'][$i]
				);
				$this->db->insert('detallerecibo',$detalle_recibo);
			}
		}
		#Modificar retenciones dentro del recibo de caja
		foreach($retencion['detalleretencion_id']->result() as $key => $row){
			$retenciones[$key] = $row->detalleretencion_id;
			$key++;
		}		
		
		for($i=0; $i<(count($retencion['retencion_id'])); $i++) {
			if ($i < count($retenciones)) {
				$this->db->where('detalleretencion_id', $retenciones[$i]);
				$detalle_retencion = array(
					'retencion_id' => $retencion['retencion_id'][$i],
					'recibocaja_id' => $id,
					'retencion_valor' => $retencion['retencion_valor'][$i]
				);
				$this->db->update('detalleretencion',$detalle_retencion);
			}
			else {
				$detalle_retencion = array(
					'retencion_id' => $retencion['retencion_id'][$i],
					'recibocaja_id' => $id,
					'retencion_valor' => $retencion['retencion_valor'][$i]
				);
				$this->db->insert('detalleretencion',$detalle_retencion);
			}
		}			
	}//fin de modificar datos
	
	public function eliminarFila($recibocaja_id, $fila) {
		$query = $this->consultarDetalleReciboId($recibocaja_id);
		if ($query->num_rows() > 0) {
			foreach($query->result() as $key => $row){
				if(($key+1) == $fila) {
					$this->db->where('detallerecibo_id',$row->detallerecibo_id);
					$this->db->delete('detallerecibo');
				}
			}
		}else{
			return FALSE;
		}
	}//fin de eliminar fila de la tabla detallerecibo	
	
	public function eliminarFilaRetencion($recibocaja_id, $fila) {
		$query = $this->consultarDetalleRetencionId($recibocaja_id);
		if ($query->num_rows() > 0) {
			foreach($query->result() as $key => $row){
				if(($key+1) == $fila) {
					$this->db->where('detalleretencion_id',$row->detalleretencion_id);
					$this->db->delete('detalleretencion');
				}
			}
		}else{
			return FALSE;
		}
	}//fin de eliminar fila de la tabla detalleretencion

	public function eliminar($id){
		$tablas = array('recibocaja', 'detallerecibo', 'detalleretencion');
		$this->db->where('recibocaja_id',$id);
		$this->db->delete($tablas);
	}

	public function pdf($id){
		$query = $this->db->query("
			select	re.recibocaja_id,
					rel.relacion_nombre,
					rel.relacion_direccion,
					rel.relacion_ciudad,
					rel.relacion_nit,
					me.metodopago_nombre,
					re.recibocaja_fecha,
					re.recibocaja_observacion,
					pu.puc_nombre,
					im.impuesto_id,
					im.impuesto_nombre,
					im.impuesto_porcentaje,
					de.detallerecibo_valor,
					de.detallerecibo_cantidad,
					te.telefonor_numero
			from 	recibocaja AS re 	INNER JOIN relacion AS rel ON re.relacion_id = rel.relacion_id
										INNER JOIN metodopago AS me ON me.metodopago_id = re.metodopago_id 
										INNER JOIN detallerecibo AS de ON de.recibocaja_id = re.recibocaja_id
										INNER JOIN impuesto AS im ON im.impuesto_id = de.impuesto_id
										INNER JOIN puc AS pu ON pu.puc_id = de.puc_id
										INNER JOIN telefonorelacion AS te ON te.relacion_id = rel.relacion_id
			where  	re.recibocaja_id = $id");
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return "No hay datos";
			}
	}

	public function consultarPagos($relacion_id){
		$query = $this->db->query("select 
									rel.relacion_nombre, 
									pago.facturav_id, 
									pago.facturav_total, 
									pago.recibocaja_id,
									pago.recibocaja_pagado, 
									pago.recibocaja_porpagar 
								from agregarpago pago, relacion rel 
								where rel.relacion_id = $relacion_id 
								AND rel.relacion_id = pago.relacion_id");
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}	
	}
	
	public function consultar_id_recibocaja() {
		$query = $this->db->query("
			SELECT
				recibocaja_id
			FROM
				recibocaja
			ORDER BY recibocaja_id DESC LIMIT 1
		");
		
		if($query->num_rows() > 0) {
			 $row = $query->row();
			return  ($row->recibocaja_id + 1);
		}else{
			return 1;
		}
	}
	
	//-----------------------------------------------
	//	Método para factura de venta asociada
	//-----------------------------------------------
	
	public function guardar_fv_asoc($rc, $fv) {
		$this->db->insert('recibocaja',$rc);
		for ($i=0; $i < count($fv['fv_id']); $i++) {
			$tmp_fc_val_pagar = str_replace(',', '', $fv['fv_val_pagar'][$i]);
			if (!isset($tmp_fc_val_pagar)) {
				$tmp_fc_val_pagar = 0;
			}
			$tmp_fc_dif_x_pagar = str_replace(',', '', $fv['fv_x_pagar'][$i]) - $tmp_fc_val_pagar;
			$arr_fc = array(
				'rc_id' => $rc['recibocaja_id'],
				'fv_id' => $fv['fv_id'][$i],
				'fv_val_pagar' => $tmp_fc_val_pagar,
				'fv_dif_x_pagar' => $tmp_fc_dif_x_pagar
			);
			/*echo "<pre>";
			print_r($rc);
			echo "</pre>";*/
			$this->db->insert('recibocajaasociado',$arr_fc);
		}
	}
	
}//fin de la clase