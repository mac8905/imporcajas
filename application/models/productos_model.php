<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Productos_Model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	public function consultarImpuesto(){
		$query = $this->db->get("Impuesto");
		if($query->num_rows() > 0){
			return $query;
		}else{
			return FALSE;
		}
	}
	
	public function guardar($data,$data1){
		$this->db->insert('Dimension', $data1);
		$this->db->where($data1);
		$query = $this->db->get('Dimension');
		if($query->num_rows() == 1) {
			$row = $query->row();
			$data['dimension_id'] = $row->dimension_id;
			$this->db->insert("Producto",$data);
		}
	}
	
	public function datagrid($numeropagina,$inicio){
		$this->db->limit($numeropagina,$inicio);
		$this->db->select('producto_id,producto_nombre,dimension_alto,dimension_ancho,dimension_largo,
							producto_precioventa,producto_descripcion');
		$this->db->from('Producto pro,Dimension dim');
		$this->db->where('pro.dimension_id = dim.dimension_id');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	//consulta cuando el producto no esta asociado a una factura de venta
	public function datagridProducto($numeropagina,$inicio){
		$this->db->limit($numeropagina,$inicio);
		$query = $this->db->query("
			SELECT * 
			FROM producto AS pro
			WHERE NOT EXISTS (
			SELECT * 
			FROM detalleproducto AS de
			WHERE de.producto_id = pro.producto_id
			)
		");
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	/*public function datagridInventario($numeropagina,$inicio){
		$this->db->limit($numeropagina,$inicio);
		$this->db->select("pro.producto_id,pro.producto_nombre,pro.producto_descripcion,pro.producto_costo,
							(SUM(de.detalleproducto_cantidad)) as cantidad_venta,
							pro.producto_cantidadinicial as cantidad_inicial");
		$this->db->from("detalleproducto AS de, facturaventa AS fac, producto AS pro");
		$this->db->where("fac.facturav_id = de.facturav_id");
		$this->db->where("de.producto_id = pro.producto_id");
		$this->db->group_by("pro.producto_id");
		$this->db->order_by("pro.producto_id");
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}*/
	
	/*public function datagridInventarioCompra($numeropagina,$inicio){
		$this->db->limit($numeropagina,$inicio);
		$this->db->select("pro.producto_id,pro.producto_nombre, pro.producto_descripcion, (SUM( de.detalleproducto_cantidad)) AS cantidad_compra, SUM(de.detalleproducto_cantidad*de.detalleproducto_precio) as probar");
		$this->db->from("detalleproducto AS de, facturacompra AS fac, producto AS pro");
		$this->db->where("fac.facturacompra_id = de.facturacompra_id");
		$this->db->where("de.producto_id = pro.producto_id");
		$this->db->group_by("pro.producto_id");
		$this->db->order_by("pro.producto_id");
		/*$this->db->select("pro.producto_nombre,pro.producto_descripcion,  SUM( compra.facturacompra_cantidad ) as compra, SUM(de.detalleproducto_cantidad) as ventas ");
		$this->db->from("producto AS pro, facturaventa AS venta, facturacompra AS compra, detalleproducto as de");
		$this->db->where("compra.producto_id = pro.producto_id");
		$this->db->where("venta.facturav_id = de.facturav_id");
		$this->db->where("de.producto_id = pro.producto_id");
		$this->db->group_by("pro.producto_id");
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}*/
	
	public function getCantidad (){
		return $this->db->count_all('producto');
	}
	
	public function consultar($id){
		$this->db->select("producto_id,producto_nombre,dimension_alto,dimension_ancho,dimension_largo,
						   producto_costo,producto_precioventa,impuesto_porcentaje,
						   producto_cantidadinicial,producto_descripcion");
		$this->db->from("producto pro,dimension dim, impuesto imp");
		$this->db->where("pro.producto_id = $id");
		$this->db->where("pro.dimension_id = dim.dimension_id");
		$this->db->where("pro.impuesto_id = imp.impuesto_id");
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function eliminar($id){
		$this->db->where("producto_id",$id);
		$this->db->delete("producto");
	}

	public function impuesto(){
		$query = $this->db->get("impuesto");
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function modificar($id){
		$this->db->select("*");
		$this->db->from("producto pro,dimension dim, impuesto imp");
		$this->db->where("pro.producto_id = $id");
		$this->db->where("pro.dimension_id = dim.dimension_id");
		$this->db->where("pro.impuesto_id = imp.impuesto_id");
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function modificarEnlace($id,$data,$data1){
		$this->db->where("producto_id",$id);
		$this->db->update("producto",$data);
		$this->db->where("producto_id",$id);
		$query = $this->db->get("producto");
		$row = $query->row();
		$this->db->where("dimension_id",$row->dimension_id);
		$this->db->update("dimension",$data1);
	}
	
	public function consultarProducto() {
		$query = $this->db->get('producto');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
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
	
	public function consultarProductos() {
		$query = $this->db->get('producto');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	//funcion para regresar datos al inventario
	public function consultarInventario($numeropagina,$inicio){
		$this->db->select("pro.producto_id,pro.producto_nombre,pro.producto_descripcion,tot.cantidad_inicial,tot.cantidad_venta,tot.cantidad_compra,(pro.producto_cantidadinicial * pro.producto_costo) AS total_producto, tot.total_compra, tot.total_cajas,(tot.cantidad_inicial+tot.cantidad_compra)AS total_numerocajas");
		$this->db->from("tot_producto AS tot ,producto AS pro");
		$this->db->where("pro.producto_id = tot.id_producto");
		$this->db->limit($numeropagina,$inicio);
		$this->db->order_by("pro.producto_id","ASC");
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function consultarVentas($id){
		$query = $this->db->query("SELECT facv.facturav_id,de.producto_id,pro.producto_nombre,facv.facturav_fecha, de.detalleproducto_cantidad, de.detalleproducto_precio 
		FROM facturaventa facv, detalleproducto de, producto pro 
		WHERE facv.facturav_id = de.facturav_id AND de.producto_id = $id  AND
		de.producto_id = pro.producto_id
		order by facv.facturav_id asc");
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function consultarCompras($id){
		$query = $this->db->query("SELECT fac.facturacompra_id,de.producto_id,pro.producto_nombre,fac.facturacompra_fecha, de.detalleproducto_cantidad, de.detalleproducto_precio 
		FROM facturacompra fac, detalleproducto de, producto pro 
		WHERE fac.facturacompra_id = de.facturacompra_id AND de.producto_id = $id AND
		de.producto_id = pro.producto_id order by fac.facturacompra_id asc");
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function consultarKardex($id){
		$query = $this->db->query("
		SELECT 
		pro.producto_nombre,
		tot.cantidad_inicial,
		tot.costo_inicial,
		kar.fechafacturaventa,
		kar.fechafacturacompra,
		kar.facturav_id,
		kar.facturacompra_id,
		kar.cantidadfacturaventa,
		kar.valorfacturaventa,
		kar.cantidadfacturacompra,
		kar.valorfacturacompra
		from kardex AS kar, tot_producto AS tot, producto AS pro where kar.producto_id = $id AND tot.id_producto = kar.producto_id AND pro.producto_id = kar.producto_id
		");
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}	
	
	public function consultarKardexSolo($id){
		$query = $this->db->query("
			SELECT 
				pro.producto_nombre,
				tot.cantidad_inicial,
				tot.costo_inicial
			from tot_producto AS tot, producto AS pro where pro.producto_id = $id AND pro.producto_id = tot.id_producto
		");
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}
	
}//fin de la clase