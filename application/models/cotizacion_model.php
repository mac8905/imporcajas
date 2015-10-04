<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cotizacion_model extends CI_Model{

	function __construct(){
		parent::__construct();
	}
	
	public function consultar($id){
		$query = $this->db->query("
			select 
				co.cotizacion_id,
				re.relacion_nombre,
				co.cotizacion_fecha,
				co.cotizacion_fechavencimiento,
				co.cotizacion_observacion,
				co.cotizacion_descripcion,
				pro.producto_nombre,
				de.detalleproducto_tamano,
				de.detalleproducto_cantidad,
				de.detalleproducto_precio,
				de.detalleproducto_descuento,
				im.impuesto_nombre,
				im.impuesto_id
			from 
				cotizacion AS co INNER JOIN relacion AS re ON co.relacion_id = re.relacion_id 
								 INNER JOIN detalleproducto AS de ON co.cotizacion_id = de.cotizacion_id  
								 INNER JOIN producto AS pro ON de.producto_id = pro.producto_id
								 INNER JOIN impuesto AS im ON de.impuesto_id = im.impuesto_id  
			WHERE 
				co.cotizacion_id = $id
		");
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function consultarDetalleProductoId($id){
		$query = $this->db->query("
			SELECT
				detalleproducto_id
			FROM
				detalleproducto
			WHERE
				cotizacion_id = $id");
		
		if($query->num_rows() > 0){
			return $query;
		}else{
			return FALSE;
		}
	}
	
	public function eliminar($id){
		$tablas = array('cotizacion', 'detalleproducto');
		$this->db->where('cotizacion_id',$id);
		$this->db->delete($tablas);
	}
	
	public function eliminarFila($cotizacion_id, $fila) {
		$query = $this->consultarDetalleProductoId($cotizacion_id);
		if ($query->num_rows() > 0) {
			foreach($query->result() as $key => $row){
				if(($key+1) == $fila) {
					$this->db->where('detalleproducto_id',$row->detalleproducto_id);
					$this->db->delete('detalleproducto');
				}
			}
		}
	}
	
	public function getCotizacion($numeroRegistros,$inicio){
		$this->db->limit($numeroRegistros,$inicio);
		$this->db->select("*");
		$this->db->from("cotizacion");
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function getRegistros(){
		return $this->db->count_all("cotizacion");
	}
	
	public function guardar($datos,$detalle){
		$this->db->insert('cotizacion',$datos);
		$query = $this->db->get_where('cotizacion',$datos);
		
		if($query->num_rows() == 1) {
			$cotizacion_row =$query->row();
			for($i=0; $i<(count($detalle['producto_id'])); $i++) {
				$detalle_producto = array(
					'producto_id' => $detalle['producto_id'][$i],
					'cotizacion_id' => $cotizacion_row->cotizacion_id,
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
	
	public function modificarDetalle($id, $data, $detalle) {
		
		$this->db->where('cotizacion_id', $id);
		$this->db->update('cotizacion', $data);
		
		foreach($detalle['detalleproducto_id']->result() as $key => $row){
			$arr[$key] = $row->detalleproducto_id;
			$key++;
		}
		
		for($i=0; $i<(count($detalle['producto_id'])); $i++) {
			if ($i < count($arr)) {
				$this->db->where('detalleproducto_id', $arr[$i]);
				$detalle_producto = array(
					'producto_id' => $detalle['producto_id'][$i],
					'cotizacion_id' => $id,
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
					'cotizacion_id' => $id,
					'detalleproducto_tamano' => $detalle['detalleproducto_tamano'][$i],
					'detalleproducto_precio' => $detalle['detalleproducto_precio'][$i],
					'detalleproducto_descuento' => $detalle['detalleproducto_descuento'][$i],
					'impuesto_id' => $detalle['impuesto_id'][$i],
					'detalleproducto_cantidad' => $detalle['detalleproducto_cantidad'][$i]
				);
				$this->db->insert('detalleproducto',$detalle_producto);
			}
		}
		
	}# fin_modificarDetalle
	
	public function obtenerCotizacion($id) {
		$query = $this->db->query("
			SELECT
				co.cotizacion_id,
				co.relacion_id,
				co.cotizacion_fecha,
				co.cotizacion_fechavencimiento,
				co.cotizacion_observacion,
				co.cotizacion_descripcion,

				group_concat(de.producto_id) producto_id,
				group_concat(de.detalleproducto_cantidad) detalleproducto_cantidad,
				group_concat(de.detalleproducto_precio) detalleproducto_precio,
				group_concat(de.detalleproducto_descuento) detalleproducto_descuento,
				group_concat(de.detalleproducto_tamano) detalleproducto_tamano,
				group_concat(de.impuesto_id) impuesto_id
				
			FROM
				cotizacion co, detalleproducto de
			WHERE
				co.cotizacion_id = $id AND
				co.cotizacion_id = de.cotizacion_id
		");
		
		if($query->num_rows() > 0){
			return $query;
		}else{
			return FALSE;
		}
	} #fin_obtenerCotizacion
	
	public function pdf($id){
		$this->db->select("co.cotizacion_id,re.relacion_nombre,re.relacion_direccion,re.relacion_ciudad,re.relacion_nit,
							co.cotizacion_fecha,co.cotizacion_fechavencimiento,pro.producto_nombre, 
							de.detalleproducto_precio,de.detalleproducto_cantidad,
							de.detalleproducto_descuento, de.impuesto_id, te.telefonor_numero,
							co.cotizacion_observacion");
		$this->db->from("cotizacion AS co, detalleproducto AS de, relacion AS re, producto pro, telefonorelacion AS te");
		$this->db->where("co.cotizacion_id = $id");
		$this->db->where("co.cotizacion_id = de.cotizacion_id");
		$this->db->where("co.relacion_id = re.relacion_id");
		$this->db->where("de.producto_id = pro.producto_id");
		$this->db->where("te.relacion_id = re.relacion_id");
		$query = $this->db->get();
		$data["cotizacion"]=array();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}
	
}//fin de la clase