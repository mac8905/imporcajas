<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ComprobanteEgreso_model extends CI_Model{
	
	function __construct() {
		parent::__construct();
	}
	
	public function consultar($id) {
		$query = $this->db->query("
		SELECT 
			ce.fc_id,
			re.relacion_nombre,
			ce.facturav_fecha,
			ce.facturav_fechavencimiento,
			ce.facturav_observacion,
			ce.facturav_descripcion,
			pro.producto_nombre,
			de.detalleproducto_tamano,
			de.detalleproducto_cantidad,
			de.detalleproducto_precio,
			de.detalleproducto_descuento,
			im.impuesto_nombre,
			im.impuesto_id
		FROM 
			facturaventa AS ce INNER JOIN relacion AS re ON ce.relacion_id = re.relacion_id 
								INNER JOIN detalleproducto AS de ON ce.fc_id = de.fc_id  
								INNER JOIN producto AS pro ON de.producto_id = pro.producto_id
								INNER JOIN impuesto AS im ON de.impuesto_id = im.impuesto_id  
		WHERE 
			cs.fc_id = $id
		");
		if($query->num_rows() > 0) {
			return $query->result();
		}else{
			return FALSE;
		}
	}#fin_consultar

	public function consultar_ce_asoc($fc_id)
	{
		$query = $this->db->query("
			SELECT
				ce.ce_id,
				ce.ce_fecha,
				dce.fc_val_pagar,
				ce.ce_observacion
			FROM
				comprobanteegreso AS ce, detallecomprobante AS dce
			WHERE
				ce.ce_id = dce.ce_id AND
				dce.fc_id = $fc_id
		");
		if($query->num_rows() > 0) {
			return $query->result();
		}else{
			return FALSE;
		}
	}

	public function consultar_ce_id() {
		$query = $this->db->query("
			SELECT
				ce_id
			FROM
				comprobanteegreso
			ORDER BY ce_id DESC LIMIT 1
		");
		
		if($query->num_rows() > 0) {
			 $row = $query->row();
			return  ($row->ce_id + 1);
		}else{
			return 1;
		}
	}
	
	public function consultarDetalleProductoId($id) {
		$query = $this->db->query("
			SELECT
				detalleproducto_id
			FROM
				detalleproducto
			WHERE
				facturav_id = $id");
		
		if($query->num_rows() > 0) {
			return $query;
		}else{
			return FALSE;
		}
	}
	
	public function eliminar($id) {
		$tablas = array('facturaventa', 'detalleproducto');
		$this->db->where('facturav_id',$id);
		$this->db->delete($tablas);
	}
	
	public function eliminarFila($facturav_id, $fila) {
		$query = $this->consultarDetalleProductoId($facturav_id);
		if ($query->num_rows() > 0) {
			foreach($query->result() as $key => $row) {
				if(($key+1) == $fila) {
					$this->db->where('detalleproducto_id',$row->detalleproducto_id);
					$this->db->delete('detalleproducto');
				}
			}
		}
	}
	
	public function getComprobanteEgreso($numeroRegistros,$inicio) {
		$this->db->limit($numeroRegistros,$inicio);
		$this->db->select("
							ce.ce_id,
							re.relacion_nombre as ce_beneficiario,
							ce.ce_fecha,
							ce.ce_observacion,
							me.metodopago_nombre as ce_metodo
						");
		$this->db->from("comprobanteegreso AS ce, relacion AS re, metodopago AS me, detallecomprobante AS dce");
		$this->db->where("ce.ce_beneficiario = re.relacion_id");
		$this->db->where("ce.ce_metodopago = me.metodopago_id");
		$this->db->where("dce.ce_id = ce.ce_id");
		$this->db->where("dce.fc_id is null");
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function getRegistros() {
		return $this->db->count_all('comprobanteegreso');
	}
	
	public function guardar($datos,$detalle) {
		$this->db->insert('facturaventa',$datos);
		$query = $this->db->get_where('facturaventa',$datos);
		
		if($query->num_rows() == 1) {
			$facturaventa_row =$query->row();
			for($i=0; $i<(count($detalle['producto_id'])); $i++) {
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
		}
	}

	public function guardar_fc_asoc($ce, $fc) {
		$this->db->insert('comprobanteegreso',$ce);
		for ($i=0; $i < count($fc['fc_id']); $i++) {
			$tmp_fc_val_pagar = str_replace(',', '', $fc['fc_val_pagar'][$i]);
			if (!isset($tmp_fc_val_pagar)) {
				$tmp_fc_val_pagar = 0;
			}
			$tmp_fc_dif_x_pagar = str_replace(',', '', $fc['fc_x_pagar'][$i]) - $tmp_fc_val_pagar;
			$arr_fc = array(
				'ce_id' => $ce['ce_id'],
				'fc_id' => $fc['fc_id'][$i],
				'fc_val_pagar' => $tmp_fc_val_pagar,
				'fc_dif_x_pagar' => $tmp_fc_dif_x_pagar
			);
			echo "<pre>";
			print_r($arr_fc);
			echo "</pre>";
			$this->db->insert('detallecomprobante',$arr_fc);
		}
	}
	
	public function modificarDetalle($id, $data, $detalle) {
		
		$this->db->where('facturav_id', $id);
		$this->db->update('facturaventa', $data);
		
		foreach($detalle['detalleproducto_id']->result() as $key => $row) {
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
		
		if($query->num_rows() > 0) {
			return $query;
		}else{
			return FALSE;
		}
	} #fin_obtenerFacturaVenta
	
	public function pdf($id) {
		$this->db->select("fac.facturav_id,re.relacion_nombre,re.relacion_direccion,re.relacion_ciudad,re.relacion_nit,
						   fac.facturav_fecha,fac.facturav_fechavencimiento,pro.producto_nombre, 
						   de.detalleproducto_precio,de.detalleproducto_cantidad,
						   de.detalleproducto_descuento, de.impuesto_id");
		$this->db->from("facturaventa AS fac, detalleproducto AS de, relacion AS re, producto AS pro");
		$this->db->where("fac.facturav_id = $id");
		$this->db->where("fac.facturav_id = de.facturav_id");
		$this->db->where("fac.relacion_id = re.relacion_id");
		$this->db->where("de.producto_id = pro.producto_id");
		$query = $this->db->get();
		$data["facturaventa"]=array();
		if($query->num_rows() > 0) {
			return $query->result();
		}else{
			return false;
		}
	}
	
}#fin clase facturaventa_model