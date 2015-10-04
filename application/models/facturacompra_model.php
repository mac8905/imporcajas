<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class FacturaCompra_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}

	public function facturacompra($id) {
		$query = $this->db->query("
			SELECT
				fc.facturacompra_id,
				re.relacion_nombre,
				fc.facturacompra_fecha,
				fc.facturacompra_fechavencimiento,
				fc.facturacompra_observacion,
				fc.fc_subtotal_sin_desc,
				fc.fc_descuento,
				fc.fc_subtotal,
				fc.fc_iva,
				fc.fc_total,
				fc.fc_val_rete,
				fc.fc_x_pagar,
				fc.fc_val_pagado

			FROM
				facturacompra AS fc
					INNER JOIN
						relacion AS re ON fc.relacion_id = re.relacion_id

			WHERE
				fc.facturacompra_id = $id
		");
		if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return FALSE;
		}
	}

	public function dpro_id($id='')
	{
		$query = $this->db->query("
			SELECT
				dpro.detalleproducto_id

			FROM
				detalleproducto AS dpro

			WHERE
				dpro.facturacompra_id = $id
		");
		if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return FALSE;
		}
	}

	public function dpuc_id($id='')
	{
		$query = $this->db->query("
			SELECT
				dpuc.dpuc_id

			FROM
				detallepuc AS dpuc

			WHERE
				dpuc.fc_id = $id
		");
		if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return FALSE;
		}
	}

	public function detalleproducto($id) {
		$query = $this->db->query("
			SELECT
				dpro.detalleproducto_id,
				pro.producto_id,
				pro.producto_nombre,
				dpro.detalleproducto_cantidad,
				dpro.detalleproducto_precio, 
				dpro.detalleproducto_descuento,
				impu.impuesto_nombre

			FROM
				detalleproducto AS dpro
					INNER JOIN
						producto AS pro ON dpro.producto_id = pro.producto_id
					INNER JOIN
						impuesto AS impu ON dpro.impuesto_id = impu.impuesto_id

			WHERE
				dpro.facturacompra_id = $id
		");
		if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return FALSE;
		}
	}

	public function detallepuc($id) {
		$query = $this->db->query("
			SELECT
				dpuc.dpuc_id,
				dpuc.puc_id,
				puc.puc_nombre,
				dpuc.dpuc_cantidad,
				dpuc.dpuc_precio, 
				dpuc.dpuc_descuento,
				dpuc.dpuc_impuesto,
				impu.impuesto_nombre,
				dpuc.dpuc_total

			FROM
				detallepuc AS dpuc
					INNER JOIN
						puc AS puc ON dpuc.puc_id = puc.puc_id
					INNER JOIN
						impuesto AS impu ON dpuc.dpuc_impuesto = impu.impuesto_id

			WHERE
				dpuc.fc_id = $id

			ORDER BY
				puc.puc_nombre ASC
		");
		if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return FALSE;
		}
	}

	public function detalleretencion($id) {
		$query = $this->db->query("
			SELECT
				dret.detalleretencion_id,
				dret.retencion_id,
				dret.retencion_valor

			FROM
				detalleretencion AS dret

			WHERE
				dret.facturacompra_id = $id

			ORDER BY
				dret.detalleretencion_id ASC
		");
		if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return FALSE;
		}
	}

	public function consultar($id){
		$query = $this->db->query("
		SELECT 
			fc.facturacompra_id,
			re.relacion_nombre,
			fc.facturacompra_fecha,
			fc.facturacompra_fechavencimiento,
			fc.facturacompra_observacion,
			fc.fc_subtotal_sin_desc,
			fc.fc_descuento,
			fc.fc_subtotal,
			fc.fc_iva,
			fc.fc_total,
			fc.fc_val_rete,
			fc.fc_x_pagar,
			fc.fc_val_pagado,
			pro.producto_nombre,
			de.detalleproducto_cantidad,
			de.detalleproducto_precio, 
			de.detalleproducto_descuento,
			im.impuesto_nombre,
			im.impuesto_id
		FROM
			facturacompra AS fc INNER JOIN relacion AS re ON fc.relacion_id = re.relacion_id 
								 INNER JOIN detalleproducto AS de ON fc.facturacompra_id = de.facturacompra_id  
								 INNER JOIN producto AS pro ON de.producto_id = pro.producto_id
								 INNER JOIN impuesto AS im ON de.impuesto_id = im.impuesto_id  
		WHERE 
			fc.facturacompra_id = $id
		");
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
																	facturacompra_id = $id
															");
		
		if($query->num_rows() > 0){
			return $query;
		}else{
			return FALSE;
		}
	}
	/**
	 * Obtiene el número de la última factura de compra realizada 
	 * 
	 * @return el número siguiente para una facuta de compra nueva
	 */
	public function consultar_fc_id() {
		$query = $this->db->query("
			SELECT
				facturacompra_id AS fc_id
			FROM
				facturacompra
			ORDER BY facturacompra_id DESC LIMIT 1
		");
		
		if($query->num_rows() > 0) {
			 $row = $query->row();
			return  ($row->fc_id + 1);
		}else{
			return 1;
		}
	}
	
	public function consulta_fc_x_beneficiario($id_beneficiario)
	{
		$query = $this->db->query('
		                          	SELECT * FROM facturacompra
		                          	WHERE relacion_id = '.$id_beneficiario.' AND
		                          	estado = "abierta" ORDER BY facturacompra_id DESC
		                          ');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}

	public function consulta_id_beneficiario($value='')
	{
		$query = $this->db->query("
		                          	SELECT relacion_id FROM facturacompra
		                          	WHERE facturacompra_id = $value
		                          ");
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}

	public function eliminar($id){
		$tablas = array('facturacompra', 'detalleproducto');
		$this->db->where('facturacompra_id',$id);
		$this->db->delete($tablas);
	}

	public function eliminarFila($facturacompra_id, $fila) {
		$query = $this->consultarDetalleProductoId($facturacompra_id);
		if ($query->num_rows() > 0) {
			foreach($query->result() as $key => $row){
				if(($key+1) == $fila) {
					$this->db->where('detalleproducto_id',$row->detalleproducto_id);
					$this->db->delete('detalleproducto');
				}
			}
		}
	}
	
	public function getFacturaCompra(){
		$this->db->select("
												fc.facturacompra_id,
												re.relacion_nombre,
												fc.facturacompra_fecha,
												fc.facturacompra_fechavencimiento,
												fc.facturacompra_observacion,
												fc.fc_total,
												fc.fc_val_pagado,
												fc.fc_x_pagar
											");
		$this->db->from("facturacompra AS fc, relacion AS re");
		$this->db->where("fc.relacion_id = re.relacion_id");
		$this->db->order_by('fc.facturacompra_fechavencimiento','desc');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}

	public function getRegistros(){
		return $this->db->count_all('facturacompra');
	}

	public function guardar($facturacompra, $detalleretencion) {
		$this->db->insert('facturacompra',$facturacompra);
	 	$query = $this->db->get_where('facturacompra',$facturacompra);
		if($query->num_rows() == 1) {
			$facturacompra_row = $query->row();
			for($i=0; $i<(count($detalleretencion['ce_retencion'])); $i++) {
				$retencion = array(
				'retencion_id' => $detalleretencion['ce_retencion'][$i],
				'retencion_valor' => str_replace(',', '', $detalleretencion['rete_valor'][$i]),
				'facturacompra_id' => $facturacompra_row->facturacompra_id
				);
				$this->db->insert('detalleretencion',$retencion);
			}
		}
	}
/*Guarda el detallepuc y el detalleproducto*/
	public function guardarDetalle($nom_tab, $detalle, $modificar, $id)
	{
		if ($nom_tab == 'detallepuc' && $modificar == FALSE) {
			$this->db->insert($nom_tab,$detalle);
		}
		elseif ($nom_tab == 'detalleproducto' && $modificar == FALSE) {
			$this->db->insert($nom_tab,$detalle);
		}
		elseif ($nom_tab == 'detallepuc' && $modificar == TRUE) {
			$this->db->where('dpuc_id', $id);
			$this->db->update($nom_tab,$detalle);
		}
		elseif ($nom_tab == 'detalleproducto' && $modificar == TRUE) {
			$this->db->where('detalleproducto_id', $id);
			$this->db->update($nom_tab,$detalle);
		}
	}

	public function obtenerFacturaCompra($id) {
		$query = $this->db->query("
			SELECT
				fc.facturacompra_id,
				fc.relacion_id,
				fc.facturacompra_fecha,
				fc.facturacompra_fechavencimiento,
				fc.facturacompra_observacion,

				group_concat(de.producto_id) producto_id,
				group_concat(de.detalleproducto_cantidad) detalleproducto_cantidad,
				group_concat(de.detalleproducto_precio) detalleproducto_precio,
				group_concat(de.detalleproducto_descuento) detalleproducto_descuento,
				group_concat(de.impuesto_id) impuesto_id
				
			FROM
				facturacompra fc, detalleproducto de
			WHERE
				fc.facturacompra_id = $id AND
				fc.facturacompra_id = de.facturacompra_id
		");
		
		if($query->num_rows() > 0){
			return $query;
		}else{
			return FALSE;
		}
	} #fin_obtenerFacturaCompra

	public function pdf($id){
		$this->db->select("
						   fc.facturacompra_id,
						   re.relacion_nombre,
						   re.relacion_direccion,
						   re.relacion_ciudad,
						   re.relacion_nit,
						   fc.facturacompra_fecha,
						   fc.facturacompra_fechavencimiento,
						   pro.producto_nombre, 
						   de.detalleproducto_precio,
						   de.detalleproducto_cantidad,
						   de.detalleproducto_descuento, 
						   de.impuesto_id
						");
		$this->db->from("facturacompra AS fc, detalleproducto AS de, relacion AS re, producto AS pro");
		$this->db->where("fc.facturacompra_id = $id");
		$this->db->where("fc.facturacompra_id = de.facturacompra_id");
		$this->db->where("fc.relacion_id = re.relacion_id");
		$this->db->where("de.producto_id = pro.producto_id");
		$query = $this->db->get();
		$data["facturacompra"]=array();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}#fin pdf

	public function mod_fc($data, $id) {
		$this->db->where('facturacompra_id', $id);
		$this->db->update('facturacompra', $data);
	}
}#fin clase FacturaCompra_model