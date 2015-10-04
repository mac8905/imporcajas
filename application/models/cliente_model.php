<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cliente_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	public function consultarBeneficiarios()
	{
		$query = $this->db->get('relacion');
		if($query->num_rows() > 0) {
			return $query->result();
		}else{
			return FALSE;
		}
	}

	public function consultarCliente($id) {
		if (is_numeric($id)) {
			$this->db->where('relacion_id', $id);
		}
		if (is_array($id)) {
			$this->db->where($id);
		}
		
		$query = $this->db->get('Relacion'); 
		if($query->num_rows() == 1) {
			return $query;
		}else{
			return FALSE;
		}
	}
	
	public function consultarClientes() {
		$query = $this->db->query("
			SELECT
					re.relacion_id,
	                re.relacion_nombre,
					re.relacion_nit,
					re.relacion_ciudad,
					re.relacion_observacion
			FROM	
					Relacion re, tiporelacion ti
			WHERE
					re.relacion_id = ti.relacion_id AND
					(ti.perfilrelacion_id =  '1,0' OR
                     ti.perfilrelacion_id =  '1,2')
		");
		if($query->num_rows() > 0) {
			return $query->result();
		}else{
			return FALSE;
		}
	}

	#Método  que elimina los registros de la tabla Relación
	public function eliminar($id) {
		$this->db->where('relacion_id',$id);
		$this->db->delete('Relacion');
	}

	#Método que devuelve el total de registros contenidos en la tabla relacion
	public function getCantidad () {
		return count($this->consultarClientes());
	}

	public function getContactos($numeroRegistros,$inicio) {
		$this->db->limit($numeroRegistros, $inicio);
		$query = $this->db->query("
			SELECT
					re.relacion_id,
	                re.relacion_nombre,
					re.relacion_nit,
					re.relacion_ciudad,
					re.relacion_observacion
			FROM	
					Relacion re, tiporelacion ti
			WHERE
					re.relacion_id = ti.relacion_id AND
					(ti.perfilrelacion_id =  '1,0' OR
                     ti.perfilrelacion_id =  '1,2')
		");
		if($query->num_rows() > 0) {
			return $query->result();
		}else{
			return FALSE;
		}
	}

	#El metodo guarda los datos en las tablas relacion y telefonorelacion
	public function guardar($data) {
		if ($data != FALSE) {
			$this->db->insert('Relacion', $data);
		}
	}
	
	#El metodo guarda los datos en la tabla TipoRelacion
	public function guardar_perfil($id, $perfiles) {
		if (isset($id) && $perfiles != FALSE) {
			$query = $this->consultarCliente($id);
				#	implode: une elementos de un array en un string.
			$temp = implode(',', $perfiles);
			if ($query != false) {
				if($query->num_rows() > 0) { 
					$row = $query->row(); 
					$tipoRelacion = array(
						"perfilrelacion_id" => $temp,
						"relacion_id" => $row->relacion_id 
					);
					$this->db->insert('TipoRelacion',$tipoRelacion);	
				}
			}
		}
	}#fin del método guardar_perfil

	public function guardarTelefono($telefonos, $id) {
		$query = $this->consultarCliente($id);
		
		if ($telefonos != FALSE) {
			$temp = implode(',', $telefonos);
		} else {
			$temp = 0;
		}
		if ($query != FALSE) {
			if($query->num_rows() > 0) { 
				$row = $query->row();
				$data = array( 
					"telefonor_numero" => $temp, 
					"relacion_id" => $row->relacion_id 
				);
				$this->db->insert('TelefonoRelacion',$data);
			}
		}
		else {
			echo "ERROR guardarTelefono";
		}
	}#fin guardarTelefono

	public function modificarCliente($id, $cliente) {
		if (isset($id) && $cliente != FALSE) {
			$this->db->where('relacion_id', $id);
			$this->db->update('Relacion', $cliente);
		}
	}

	public function modificarPerfil($id, $perfiles) {
		if (isset($id) && $perfiles != FALSE) {
			$temp = implode(',', $perfiles);
			$data = array("perfilrelacion_id" => $temp);
			$this->db->where('relacion_id',$id); 
			$this->db->update('TipoRelacion',$data);
		}
	}

	public function modificarTelefono($telefonos, $id) {
		if ($telefonos != FALSE && isset($id)) {			
			$temp = implode(',', $telefonos);
			$data = array("telefonor_numero" => $temp);
			$this->db->where('relacion_id',$id); 
			$this->db->update('TelefonoRelacion',$data);
		}
	}
	
	/* Método que realiza una consulta para mostrar los datos del contacto*/
	public function mostrar($id) {
		$query= $this->db->query("
			SELECT 
					re.relacion_id,
					re.relacion_nombre,
					re.relacion_nit,
					reg.regimen_nombre,
					re.relacion_ciudad,
					re.relacion_direccion,
					re.relacion_correo,
					GROUP_CONCAT(te.telefonor_numero) AS telefono,
					re.relacion_movil,
					re.relacion_fax,
					re.relacion_observacion 
			FROM 
					relacion AS re, 
					regimen AS reg, 
					telefonorelacion AS te 
			WHERE 
					re.relacion_id= $id AND 
					te.relacion_id= $id AND 
					reg.regimen_id = re.regimen_id
		");
		if($query->num_rows() > 0) {
			return $query->result();
		}else{
			return FALSE;
		}
	}// fin método mostrarCliente
	
	public function mostrarCliente($id) {
		$sql = "
			SELECT *
			FROM
				telefonorelacion
			WHERE
				relacion_id = $id
		";
		$query = $this->db->query($sql);

		if ($query->num_rows() > 0) {
			$sql1 = "
			SELECT
				re.relacion_id,
				re.relacion_nombre,
				reg.regimen_id,
				re.relacion_nit,
				re.relacion_ciudad,
				re.relacion_direccion,
				re.relacion_correo,
				re.relacion_movil,
				re.relacion_fax,
				re.relacion_observacion,
				GROUP_CONCAT(DISTINCT te.telefonor_numero ) AS telefonor_numero,
				tr.perfilrelacion_id AS perfilrelacion_id
			FROM
				relacion AS re,
				regimen AS reg,
				telefonorelacion AS te,
				tiporelacion AS tr
			WHERE
				re.relacion_id = $id AND
				reg.regimen_id = re.regimen_id AND
				tr.relacion_id = re.relacion_id AND
				te.relacion_id = re.relacion_id";
			$query = $this->db->query($sql1);
		}
		else {
			$sql2 = "
			SELECT
				re.relacion_id,
				re.relacion_nombre,
				reg.regimen_id,
				re.relacion_nit,
				re.relacion_ciudad,
				re.relacion_direccion,
				re.relacion_correo,
				re.relacion_movil,
				re.relacion_fax,
				re.relacion_observacion,
				tr.perfilrelacion_id AS perfilrelacion_id
			FROM
				relacion AS re,
				regimen AS reg,
				tiporelacion AS tr
			WHERE
				re.relacion_id = $id AND
				reg.regimen_id = re.regimen_id AND
				tr.relacion_id = re.relacion_id";
		$query = $this->db->query($sql2);
		}
		
		if($query->num_rows() == 1) {
			return $query;
		}else{
			return FALSE;
		}
	}#fin método mostrarCliente
	
	/* Método que realiza una consulta apartir del id que le envian por parametro
	y retorna los registros sí la consulta es éxitosa */
	public function obtenerDatos($id) {
		$query = $this->db->query("
			SELECT * 
			FROM 
				relacion AS re,
				telefonorelacion AS te, 
				tiporelacion AS ti 
			WHERE 
				re.relacion_id = $id AND 
				re.relacion_id = te.relacion_id AND 
				re.relacion_id = ti.relacion_id
		");
		if($query->num_rows() > 0) {
			return $query;
		}
		else{
			return false;
		}
	}//fin método obtenerDatos
}// fin de clase cliente_model