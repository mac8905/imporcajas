<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pedido_Model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	public function consultar($id){
		$query = $this->db->query("select pe.pedido_id,re.relacion_nombre,pe.pedido_fecha,pe.pedido_fechavencimiento,
						           pe.pedido_observacion,pe.pedido_descripcion, pro.producto_nombre, de.detalleproducto_tamano,
								   de.detalleproducto_cantidad, de.detalleproducto_precio, de.detalleproducto_descuento,
								   im.impuesto_nombre,im.impuesto_id
						           from pedido AS pe INNER JOIN relacion AS re ON pe.relacion_id = re.relacion_id 
								   INNER JOIN detalleproducto AS de ON pe.pedido_id = de.pedido_id  
								   INNER JOIN producto AS pro ON de.producto_id = pro.producto_id
								   INNER JOIN impuesto AS im ON de.impuesto_id = im.impuesto_id  
							       WHERE pe.pedido_id = $id");
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
				pedido_id = $id");
		
		if($query->num_rows() > 0){
			return $query;
		}else{
			return FALSE;
		}
	}
	
	public function consultarPrecio($id){
		$this->db->select("producto_precioventa");
		$this->db->where("producto_id = $id");
		$query = $this->db->get("producto");
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function eliminar($id){
		$tablas = array('pedido', 'detalleproducto');
		$this->db->where('pedido_id',$id);
		$this->db->delete($tablas);
	}
	
	public function eliminarFila($id_pedido, $fila) {
		$query = $this->consultarDetalleProductoId($id_pedido);
		if ($query->num_rows() > 0) {
			foreach($query->result() as $key => $row){
				if(($key+1) == $fila) {
					$this->db->where('detalleproducto_id',$row->detalleproducto_id);
					$this->db->delete('detalleproducto');
				}
			}
		}
	}
	
	public function getPedidos($numeroRegistros,$inicio){
		$this->db->limit($numeroRegistros,$inicio);
		$this->db->select("*");
		$this->db->from("pedido");
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function getRegistros(){
		return $this->db->count_all('pedido');
	}
	
	public function guardar($datos,$detalle){
		$this->db->insert('pedido',$datos);
		$query = $this->db->get_where('pedido',$datos);
		
		if($query->num_rows() == 1) {
			$pedido_row =$query->row();
			for($i=0; $i<(count($detalle['producto_id'])); $i++) {
				$detalle_producto = array(
					'producto_id' => $detalle['producto_id'][$i],
					'pedido_id' => $pedido_row->pedido_id,
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
		
		$this->db->where('pedido_id', $id);
		$this->db->update('pedido', $data);
		
		foreach($detalle['detalleproducto_id']->result() as $key => $row){
			$arr[$key] = $row->detalleproducto_id;
			$key++;
		}
		
		for($i=0; $i<(count($detalle['producto_id'])); $i++) {
			if ($i < count($arr)) {
				$this->db->where('detalleproducto_id', $arr[$i]);
				$detalle_producto = array(
					'producto_id' => $detalle['producto_id'][$i],
					'pedido_id' => $id,
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
					'pedido_id' => $id,
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
	
	public function obtenerPedido($id) {
		$query = $this->db->query("
			SELECT 
					pe.pedido_id, pe.relacion_id, pe.pedido_fecha, pe.pedido_fechavencimiento, pe.pedido_observacion, pe.pedido_descripcion, 

					group_concat(de.producto_id) producto_id, group_concat(de.detalleproducto_cantidad) detalleproducto_cantidad, group_concat(de.detalleproducto_precio) detalleproducto_precio, group_concat(de.detalleproducto_descuento) detalleproducto_descuento, group_concat(de.detalleproducto_tamano) detalleproducto_tamano, group_concat(de.impuesto_id) impuesto_id
			FROM
					pedido pe, detalleproducto de
			WHERE
					pe.pedido_id = $id AND
					pe.pedido_id = de.pedido_id
		");
		
		if($query->num_rows() > 0){
			return $query;
		}else{
			return FALSE;
		}
	}#fin_obtenerPedido
	
	public function obtenerProducto($id){
		$query = $this->db->query("
			SELECT
				p.producto_precioventa, 
				concat_ws('-',d.dimension_alto, d.dimension_ancho, d.dimension_largo) producto_tamano,
				i.impuesto_id
			FROM
				producto p, dimension d, impuesto i
			WHERE	
				p.producto_id = $id AND
				p.dimension_id = d.dimension_id AND
				p.impuesto_id = i.impuesto_id
		");
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	//Enviar datos al pdf de los pedidos
	public function pdf($id){
		$this->db->select("pe.pedido_id,re.relacion_nombre,re.relacion_direccion,re.relacion_ciudad,re.relacion_nit,
							pe.pedido_fecha,pe.pedido_fechavencimiento,pro.producto_nombre, 
							de.detalleproducto_precio,de.detalleproducto_cantidad,
							de.detalleproducto_descuento,de.impuesto_id, te.telefonor_numero,
							pe.pedido_observacion");
		$this->db->from("pedido AS pe, detalleproducto AS de, relacion AS re, producto pro, telefonorelacion AS te");
		$this->db->where("pe.pedido_id = $id");
		$this->db->where("pe.pedido_id = de.pedido_id");
		$this->db->where("pe.relacion_id = re.relacion_id");
		$this->db->where("de.producto_id = pro.producto_id");
		$this->db->where("te.relacion_id = re.relacion_id");
		$query = $this->db->get();
		$data["pedidos"]=array();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}
	
}// fin de la clase