<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class FacturaventaDescargarPdf extends CI_Controller
{
	public function __construct(){
		parent::__construct();
		$this->load->model("facturaventa_model");
		$this->load->model("impuesto_model");
		$this->load->model("empresa_model");
		$this->load->library("pdf");
	}
//Cabecera de página
   public function index()
   {
	 //$pdf=new PDF();
	//Primera página
	$this->pdf->AddPage();
	$this->pdf->AliasNbPages();
 
	//Logo
	$this->pdf->Image("images/Logo.png" , 12 ,12, 35 , 33 , "PNG" ,"");
	//Arial bold 15
	$this->pdf->SetFont('Arial','B',12);
	//Movernos a la derecha
	$this->pdf->Cell(65);

	//Título
	$empresaDatos = $this->empresa_model->obtenerDatos();
	foreach($empresaDatos as $datos){
		$this->pdf->Cell(60,8,utf8_decode($datos->empresa_nombre),0,0,'C');
		$this->pdf->Ln();
		$this->pdf->SetFont('Arial','',10);
		$this->pdf->Cell(65);
		$this->pdf->Cell(60,5,utf8_decode("Nit : ".($datos->empresa_nit)),0,0,'C');
		$this->pdf->Cell(65,5,utf8_decode($datos->empresa_direccion),0,0,'R');
		$this->pdf->Ln();
		$this->pdf->Cell(65);
		$this->pdf->Cell(60,5,utf8_decode("Actividad Económica ".($datos->empresa_actividad)),0,0,'C');
		$this->pdf->Cell(65,5,utf8_decode("Tel : ".($datos->empresa_telefono)),0,0,'R');
		$this->pdf->Ln();
		$this->pdf->Cell(65);
		$this->pdf->Cell(60,5,utf8_decode("Resolución DIAN Nº ".($datos->empresa_resolucion)),0,0,'C');
		$this->pdf->Cell(65,5,utf8_decode("Cel : ".($datos->empresa_movil)),0,0,'R');
		$this->pdf->Ln();
		$this->pdf->Cell(65);
		$this->pdf->Cell(60,5,utf8_decode("Autoriza del ".($datos->empresa_inicio)." al ".($datos->empresa_final)),0,0,'C');
		$this->pdf->Cell(65,5,utf8_decode($datos->empresa_ciudad),0,0,'R');	
		$this->pdf->Ln();
		$this->pdf->Cell(65);
		$this->pdf->Cell(60,5,utf8_decode($datos->regimen_nombre),0,0,'C');
		$this->pdf->Cell(65,5,utf8_decode($datos->empresa_correo),0,0,'R');
	}
	//Salto de línea
	$this->pdf->SetFont('Arial','',11);
	$this->pdf->Ln(10);
	$this->pdf->Cell(50,7,utf8_decode('Factura de Venta'),0,0);
	$this->pdf->Cell(60);
	
	$facturaventa_id = $this->uri->segment(3);
	$obtenerDatos = $this->facturaventa_model->pdf($facturaventa_id);
	foreach($obtenerDatos as $row){
		$this->pdf->Cell(75,7,utf8_decode('Factura de Venta Nº'),0,0,'R');
		$this->pdf->Ln();
		$this->pdf->Cell(150);
		$this->pdf->Cell(35,7,utf8_decode($row->facturav_id),0,0,'C');
	break;
	}
	//Rellenar de color gris las celdas
	$this->pdf->setFillColor(210, 210, 210);
	$fill = true;
	//Color gris para las lineas
	$this->pdf->SetDrawColor(200, 200, 200);
	$this->pdf->SetLineWidth(.1);
	
	$facturaventa_id = $this->uri->segment(3);
	$obtenerDatos = $this->facturaventa_model->pdf($facturaventa_id);
	foreach($obtenerDatos as $row){
		$this->pdf->Ln(10);	  
		$this->pdf->SetFont('Arial','B',10);
		$this->pdf->Cell(35,5,utf8_decode("SEÑOR(ES)"),1,0,'L',$fill);
		$this->pdf->SetFont('Arial','',10);
		$this->pdf->Cell(105,5,utf8_decode($row->relacion_nombre),1);
		$this->pdf->SetFont('Arial','B',10);
		$this->pdf->Cell(50,5,utf8_decode("FECHA DE EXPEDICIÓN"),1,0,'C',$fill);
		$this->pdf->Ln();
		$this->pdf->SetFont('Arial','B',10);
		$this->pdf->Cell(35,5,utf8_decode("DIRECCIÓN"),1,0,'L',$fill);
		$this->pdf->SetFont('Arial','',10);
		$this->pdf->Cell(105,5,utf8_decode($row->relacion_direccion),1);
		$this->pdf->SetFont('Arial','',9);
		$myDateTime = DateTime::createFromFormat('Y-m-d', $row->facturav_fecha);
		$fecha = $myDateTime->format('d-m-Y');
		$this->pdf->Cell(50,5,utf8_decode($fecha),1,0,'C');//Fecha de creación
		$this->pdf->Ln();
		$this->pdf->SetFont('Arial','B',10);
		$this->pdf->Cell(35,5,"CIUDAD",1,0,'L',$fill);
		$this->pdf->SetFont('Arial','',10);
		$this->pdf->Cell(105,5,utf8_decode($row->relacion_ciudad),1);
		$this->pdf->SetFont('Arial','B',10);
		$this->pdf->Cell(50,5,"FECHA DE VENCIMIENTO",1,0,'C',$fill);
		$this->pdf->Ln();
		$this->pdf->SetFont('Arial','B',10);
		$this->pdf->Cell(35,5,utf8_decode("TELÉFONO"),1,0,'L',$fill);
		$this->pdf->SetFont('Arial','',10);
		$this->pdf->Cell(45,5,utf8_decode($row->telefonor_numero),1);
		$this->pdf->SetFont('Arial','B',10);
		$this->pdf->Cell(20,5,"NIT",1,0,'L',$fill);
		$this->pdf->SetFont('Arial','',10);
		$this->pdf->Cell(40,5,utf8_decode($row->relacion_nit),1);
		$this->pdf->SetFont('Arial','',9);
		$myDateTime = DateTime::createFromFormat('Y-m-d',$row->facturav_fechavencimiento);
		$fechavencimiento = $myDateTime->format('d-m-Y');
		$this->pdf->Cell(50,5,utf8_decode($fechavencimiento),1,0,'C');//Fecha de vencimiento
		break;
    }
   //Tabla simple

		$this->pdf->setFillColor(210, 210, 210);
		$fill = true;
		$this->pdf->SetDrawColor(200, 200, 200);
		$this->pdf->SetLineWidth(.1);
		//Nombre de las columnas
		$this->pdf->SetFont('Arial','B',10);
		$this->pdf->Ln(10);
		$this->pdf->Cell(75,5,"Productos",1,0,'C',$fill);
		$this->pdf->Cell(30,5,"Precio",1,0,'C',$fill);
		$this->pdf->Cell(30,5,"Cantidad",1,0,'C',$fill);
		$this->pdf->Cell(25,5,"Descuento",1,0,'C',$fill);
		$this->pdf->Cell(30,5,"Total",1,0,'C',$fill);
		$this->pdf->Ln();
		//Cuerpo de la factura de venta
		$this->pdf->Rect(10,90,190,120,'f');//Rectangulo completo
		$this->pdf->Rect(10,90,75,120,'f');
		$this->pdf->Rect(85,90,30,120,'f');
		$this->pdf->Rect(115,90,30,120,'f');
		$this->pdf->Rect(145,90,25,120,'f');
		$this->pdf->Rect(170,90,30,120,'f');
		$w = array(75,30,30,25,30);
		$facturaventa_id = $this->uri->segment(3);
		$obtenerDatos = $this->facturaventa_model->pdf($facturaventa_id);
			foreach($obtenerDatos as $row){
				$this->pdf->SetFont('Arial','',10);
				$this->pdf->Cell($w[0],8,utf8_decode($row->producto_nombre),'');
				$this->pdf->Cell($w[1],8,utf8_decode("$ ".number_format($row->detalleproducto_precio,2)),'',0,'C');
				$this->pdf->Cell($w[2],8,utf8_decode($row->detalleproducto_cantidad),'',0,'C');
				$this->pdf->Cell($w[3],8,utf8_decode($row->detalleproducto_descuento."%"),'',0,'C');
				$subtotal = $row->detalleproducto_precio*$row->detalleproducto_cantidad;
				$descuento = $subtotal*($row->detalleproducto_descuento/100);
				$this->pdf->Cell($w[4],8,utf8_decode("$ ".number_format($subtotal-$descuento,2)),'',0,'C');
				$this->pdf->Ln();
			}
		//$this->pdf->Cell(array_sum($w),0,'','T');
		
		//insertando retenciones
		
		$this->pdf->setXY(10,180);
		$w = array(75,30);
		$facturaventa_id = $this->uri->segment(3);
		$obtenerDatos = $this->facturaventa_model->consultarRetencion($facturaventa_id);
			foreach($obtenerDatos as $retencion){
				$this->pdf->SetFont('Arial','',10);
				$this->pdf->Cell($w[0],8,utf8_decode($retencion->retencion_nombre),'');
				$this->pdf->Cell($w[1],8,utf8_decode("-$ ".number_format($retencion->retencion_valor,2)),'',0,'C');
				$this->pdf->Ln();
			}
		
		//Pie del total
			
			$this->pdf->setXY(90,205);
			$this->pdf->Ln();
			$this->pdf->SetFont('Arial','',6.8);
			$this->pdf->Cell(125,5,utf8_decode("La presente Factura de Venta se asimila en todos sus efectos a una Letra de Cambio (Art. 774 del código de comercio)"),0,0,'L');
			$this->pdf->SetFont('Arial','',10);
			
			
			$facturaventa_id = $this->uri->segment(3);
			$obtenerTotal = $this->facturaventa_model->consultarTotalesImprimir($facturaventa_id);

		foreach($obtenerTotal as $row){
			$this->pdf->Cell(35,5,"Subtotal :",0,0,'R');
			$this->pdf->Cell(30,5,utf8_decode("$ ".number_format($row->fv_subtotal_sin_desc,2)),0,0,'R');//SUBTOTAL SIN DESCUENTO
					
			$this->pdf->SetFont('Arial','',8.5);		
			$this->pdf->Ln();
			
			$this->pdf->Cell(125,5,utf8_decode("Observaciones: ".($row->facturav_observacion)),0,0,'L');
			
			$this->pdf->SetFont('Arial','',10);
			$this->pdf->Cell(35,5,"Descuento :",0,0,'R');
	
			$this->pdf->Cell(30,5,utf8_decode("- $ ".number_format($row->fv_descuento,2)),0,0,'R');//DESCUENTO
			
			$this->pdf->Ln();
			$this->pdf->Cell(125,5,"",0,0,'C');
			$this->pdf->Cell(35,5,"Subtotal :",0,0,'R');
			$this->pdf->Cell(30,5,utf8_decode("$ ".number_format($row->fv_subtotal,2)),0,0,'R');//SUBTOTAL
			
			/*$this->pdf->Ln();
			$this->pdf->Cell(75,5,"",0,0,'C');
			$this->pdf->Cell(30,5,"",0,0,'C');
			$this->pdf->Cell(25,5,"",0,0,'C');
			$this->pdf->Cell(30,5,"Subtotal :",0,0,'C');
			$this->pdf->Cell(30,5,"",0,0,'C');*/
			$this->pdf->Ln();
			$this->pdf->Cell(125,5,"",0,0,'C');
			$this->pdf->Cell(35,5,"IVA :",0,0,'R');
			$this->pdf->Cell(30,5,utf8_decode("$ ".number_format($row->fv_iva,2)),0,0,'R');//IVA
			
			$this->pdf->Ln();
			$this->pdf->Cell(125,5,"",0,0,'C');
			$this->pdf->Cell(35,5,"Retenciones :",0,0,'R');
			$this->pdf->Cell(30,5,utf8_decode("- $ ".number_format($row->fv_val_ret,2)),0,0,'R');//RETENCIÓN
			$this->pdf->Ln();
			$this->pdf->SetFont('Arial','B',10);
			$this->pdf->Cell(75,5,"",0,0,'C');
			$this->pdf->Cell(30,5,"",0,0,'C');
			$this->pdf->Cell(25,5,"",0,0,'C');
			$this->pdf->Cell(30,5,"TOTAL  :",0,0,'R',$fill);
			
			$this->pdf->Cell(30,5,utf8_decode("$ ".number_format($row->fv_total,2)),0,0,'R',$fill);//TOTAL
		}
			$this->pdf->Ln();
			$this->pdf->SetFont('Arial','B',9);
			$this->pdf->Line(15,268,100,268);
			$this->pdf->Cell(10,10,"",0,0,'C');
			$this->pdf->Line(110,268,195,268);
			$this->pdf->setXY(10,265);
			$this->pdf->Cell(95,10,utf8_decode("Firma y Sello"),0,0,'C');
			$this->pdf->Cell(95,10,utf8_decode("LUIS EDUARDO SERRANO ACERO"),0,0,'C');
			//$this->pdf->write(5,"ELABORADA POR");

		$id_facturaventa = $this->uri->segment(3);
		$this->pdf->Output("FacturadeVenta Nº ".$id_facturaventa.".pdf", 'D');

	}

}//fin de la clase
