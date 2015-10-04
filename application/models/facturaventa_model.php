<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Facturaventa_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}
	
	public function consultar($id){
		$query = $this->db->query("
		select 
			fac.facturav_id,
			re.relacion_nombre,
			fac.facturav_fecha,
			fac.facturav_fechavencimiento,
			fac.facturav_observacion,
			fac.facturav_descripcion,
			fac.fv_subtotal_sin_desc,
			fac.fv_descuento,
			fac.fv_subtotal,
			fac.fv_iva,
			fac.fv_total,
			fac.fv_val_ret,
			fac.fv_x_pagar,
			fac.fv_val_pagado,			
			pro.producto_nombre,
			de.detalleproducto_tamano,
			de.detalleproducto_cantidad,
			de.detalleproducto_precio,
			de.detalleproducto_descuento,
			im.impuesto_nombre,
			im.impuesto_id
		from 
			facturaventa AS fac INNER JOIN relacion AS re ON fac.relacion_id = re.relacion_id 
								INNER JOIN detalleproducto AS de ON fac.facturav_id = de.facturav_id  
								INNER JOIN producto AS pro ON de.producto_id = pro.producto_id
								INNER JOIN impuesto AS im ON de.impuesto_id = im.impuesto_id  
		WHERE 
			fac.facturav_id = $id");
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}#fin_consultar
	
	public function consultarDetalleProductoId($id){
		$query = $this->db->query("
			SELECT
				detalleproducto_id
			FROM
				detalleproducto
			WHERE
				facturav_id = $id");
		
		if($query->num_rows() > 0){
			return $query;
		}else{
			return FALSE;
		}
	}
	
	public function eliminar($id){
		$tablas = array('facturaventa', 'detalleproducto');
		$this->db->where('facturav_id',$id);
		$this->db->delete($tablas);
	}
	
	public function eliminarFila($facturav_id, $fila) {
		$query = $this->consultarDetalleProductoId($facturav_id);
		if ($query->num_rows() > 0) {
			foreach($query->result() as $key => $row){
				if(($key+1) == $fila) {
					$this->db->where('detalleproducto_id',$row->detalleproducto_id);
					$this->db->delete('detalleproducto');
				}
			}
		}
	}
	
	public function getFacturaVenta(){
		//$this->db->limit($numeroRegistros,$inicio);
		$this->db->select("	fac.facturav_id,
							re.relacion_id,
							re.relacion_nombre,		
							fac.facturav_fecha,
							fac.facturav_fechavencimiento,
							fac.facturav_observacion,
							fac.facturav_descripcion,
							fac.fv_total,
							fac.fv_val_pagado,
							fac.fv_x_pagar");
		$this->db->from("facturaventa AS fac, relacion AS re");
		$this->db->where("fac.relacion_id = re.relacion_id");
		$this->db->order_by('fac.facturav_id','desc');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function getRegistros(){
		return $this->db->count_all('facturaventa');
	}
	
	public function guardar($datos,$detalle,$detalle_retencion){
		$this->db->insert('facturaventa',$datos);
		$query = $this->db->get_where('facturaventa',$datos);
		
		if($query->num_rows() == 1) {
			$facturaventa_row =$query->row();
			for($i=0; $i<(count($detalle['producto_id'])); $i++){
				$detalle_producto = array(
					'producto_id' => $detalle['producto_id'][$i],
					'facturav_id' => $facturaventa_row->facturav_id,
					'detalleproducto_tamano' => $detalle['detalleproducto_tamano'][$i],
					'detalleproducto_precio' => $detalle['detalleproducto_precio'][$i],
					'detalleproducto_descuento' => $detalle['detalleproducto_descuento'][$i],
					'impuesto_id' => $detalle['impuesto_id'][$i],
					'detalleproducto_cantidad' => $detalle['detalleproducto_cantidad'][$i]
				);
				$this->db->insert('detalleproducto',$detalle_producto);
			}

			for($i=0; $i<(count($detalle_retencion['ce_retencion'])); $i++) {
				$retencion = array(
				'retencion_id' => $detalle_retencion['ce_retencion'][$i],
				'retencion_valor' => str_replace(',', '', $detalle_retencion['rete_valor'][$i]),
				'facturaventa_id' => $facturaventa_row->facturav_id
				);
				$this->db->insert('detalleretencion',$retencion);
			}
			/*echo "<pre>";
			print_r($retencion);
			echo "</pre>";*/
				
		}
	}
	
	public function modificarDetalle($id, $data, $detalle, $retencion) {
		$this->db->where('facturav_id', $id);
		$this->db->update('facturaventa', $data);
		
		foreach($detalle['detalleproducto_id']->result() as $key => $row){
			$arr[$key] = $row->detalleproducto_id;
			$key++;
		}
		
		for($i=0; $i<(count($detalle['producto_id'])); $i++) {
			if ($i < count($arr)) {
				$this->db->where('detalleproducto_id', $arr[$i]);
				$detalle_producto = array(
					'producto_id' => $detalle['producto_id'][$i],
					'facturav_id' => $id,
					'detalleproducto_tamano' => $detalle['detalleproducto_tamano'][$i],
					'detalleproducto_precio' => $detalle['detalleproducto_precio'][$i],
					'detalleproducto_descuento' => $detalle['detalleproducto_descuento'][$i],
					'impuesto_id' => $detalle['impuesto_id'][$i],
					'detalleproducto_cantidad' => $detalle['detalleproducto_cantidad'][$i]
				);
				$this->db->update('detalleproducto',$detalle_producto);
			}
			else {
				$detalle_producto = array(
					'producto_id' => $detalle['producto_id'][$i],
					'facturav_id' => $id,
					'detalleproducto_tamano' => $detalle['detalleproducto_tamano'][$i],
					'detalleproducto_precio' => $detalle['detalleproducto_precio'][$i],
					'detalleproducto_descuento' => $detalle['detalleproducto_descuento'][$i],
					'impuesto_id' => $detalle['impuesto_id'][$i],
					'detalleproducto_cantidad' => $detalle['detalleproducto_cantidad'][$i]
				);
				$this->db->insert('detalleproducto',$detalle_producto);
			}
		}
		
		foreach($retencion['detalleretencion_id']->result() as $key => $row){
			$retenciones[$key] = $row->detalleretencion_id;
			$key++;
		}		
		
		for($i=0; $i<(count($retencion['retencion_id'])); $i++) {
			if ($i < count($retenciones)) {
				$this->db->where('detalleretencion_id', $retenciones[$i]);
				$detalle_retencion = array(
					'retencion_id' => $retencion['retencion_id'][$i],
					'facturaventa_id' => $id,
					'retencion_valor' => $retencion['retencion_valor'][$i]
				);
				$this->db->update('detalleretencion',$detalle_retencion);
			}
			else {
				$detalle_retencion = array(
					'retencion_id' => $retencion['retencion_id'][$i],
					'facturaventa_id' => $id,
					'retencion_valor' => $retencion['retencion_valor'][$i]
				);
				$this->db->insert('detalleretencion',$detalle_retencion);
			}
		}		
		
	}#fin_modificarDetalle
	
	public function obtenerFacturaVenta($id) {
		$query = $this->db->query("
			SELECT
				fv.facturav_id,
				fv.relacion_id,
				fv.facturav_fecha,
				fv.facturav_fechavencimiento,
				fv.facturav_observacion,
				fv.facturav_descripcion,

				group_concat(de.producto_id) producto_id,
				group_concat(de.detalleproducto_cantidad) detalleproducto_cantidad,
				group_concat(de.detalleproducto_precio) detalleproducto_precio,
				group_concat(de.detalleproducto_descuento) detalleproducto_descuento,
				group_concat(de.detalleproducto_tamano) detalleproducto_tamano,
				group_concat(de.impuesto_id) impuesto_id
				
			FROM
				facturaventa fv, detalleproducto de
			WHERE
				fv.facturav_id = $id AND
				fv.facturav_id = de.facturav_id
		");
		
		if($query->num_rows() > 0){
			return $query;
		}else{
			return FALSE;
		}
	} #fin_obtenerFacturaVenta	
	
	public function pdf($id){
		$this->db->select("fac.facturav_id,re.relacion_nombre,re.relacion_direccion,re.relacion_ciudad,re.relacion_nit,
						   fac.facturav_fecha,fac.facturav_observacion,fac.facturav_fechavencimiento,pro.producto_nombre, 
						   de.detalleproducto_precio,de.detalleproducto_cantidad,
						   de.detalleproducto_descuento, de.impuesto_id, te.telefonor_numero");
		$this->db->from("facturaventa AS fac, detalleproducto AS de, relacion AS re, producto AS pro, telefonorelacion AS te");
		$this->db->where("fac.facturav_id = $id");
		$this->db->where("fac.facturav_id = de.facturav_id");
		$this->db->where("fac.relacion_id = re.relacion_id");
		$this->db->where("de.producto_id = pro.producto_id");
		$this->db->where("te.relacion_id = re.relacion_id");
		$query = $this->db->get();
		$data["facturaventa"]=array();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function consultar_fv_id() {
		$query = $this->db->query("
			SELECT
				facturav_id AS fc_id
			FROM
				facturaventa
			ORDER BY facturav_id DESC LIMIT 1
		");
		
		if($query->num_rows() > 0) {
			 $row = $query->row();
			return  ($row->fc_id + 1);
		}else{
			return 1;
		}
	}
	
	public function obtenerRetencion($id){
		$query = $this->db->query("
			SELECT 	GROUP_CONCAT(dr.retencion_id) retencion_id,
					GROUP_CONCAT(dr.retencion_valor) retencion_valor
			FROM 	facturaventa AS fv, detalleretencion AS dr  
			WHERE 	fv.facturav_id = $id
			AND 	fv.facturav_id = dr.facturaventa_id
		");
		if($query->num_rows > 0){
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
				facturaventa_id = $id");
		if($query->num_rows() > 0){
			return $query;
		}else{
			return FALSE;
		}
	}

	public function consultarTotalesImprimir($id){
		$query = $this->db->query("
			SELECT * 
			FROM facturaventa
			WHERE facturav_id = $id");
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function consultarRetencion($id){
		$query = $this->db->query("
			SELECT der.retencion_id, der.retencion_valor, ret.retencion_nombre
			FROM facturaventa AS fv
			INNER JOIN detalleretencion AS der ON der.facturaventa_id = fv.facturav_id
			INNER JOIN retencion AS ret ON ret.retencion_id = der.retencion_id
			WHERE fv.facturav_id = $id
		");
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return "No hay datos";
			}		
	}
	
	//Métodos para el recibo de caja asociado
	
	public function consulta_id_beneficiario($value='')
	{
		$query = $this->db->query("
		                          	SELECT relacion_id FROM facturaventa
		                          	WHERE facturav_id = $value
		                          ");
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function consulta_fv_x_beneficiario($id_beneficiario)
	{
		$query = $this->db->query('
		                          	SELECT * FROM facturaventa
		                          	WHERE relacion_id = '.$id_beneficiario.' AND
		                          	estado = "abierta" ORDER BY facturav_id DESC
		                          ');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	//Método que retorna datos a la vista facturaventa_datagrid_view
	
	public function consultar_rc_asoc($fc_id)
	{
		$query = $this->db->query("
			SELECT
				rc.recibocaja_id,
				rc.recibocaja_fecha,
				rca.fv_val_pagar,
				rc.recibocaja_observacion
			FROM
				recibocaja AS rc, recibocajaasociado AS rca
			WHERE
				rc.recibocaja_id = rca.rc_id AND
				rca.fv_id = $fc_id
		");
		if($query->num_rows() > 0) {
			return $query->result();
		}else{
			return FALSE;
		}
	}

}#fin clase facturaventa_model