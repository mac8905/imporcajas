<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class pedidoPDF extends CI_Controller
{
	public function __construct(){
		parent::__construct();
		$this->load->model("pedido_model");
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
		$this->pdf->Cell(60,5,utf8_decode("Actividad Económica 1702"),0,0,'C');
		$this->pdf->Cell(65,5,utf8_decode("Tel : ".($datos->empresa_telefono)),0,0,'R');
		$this->pdf->Ln();
		$this->pdf->Cell(65);
		$this->pdf->Cell(60,5,utf8_decode("Resolución DIAN Nº 320001012500"),0,0,'C');
		$this->pdf->Cell(65,5,utf8_decode("Cel : ".($datos->empresa_movil)),0,0,'R');
		$this->pdf->Ln();
		$this->pdf->Cell(65);
		$this->pdf->Cell(60,5,utf8_decode("Autoriza del 1001 al 1500"),0,0,'C');
		$this->pdf->Cell(65,5,utf8_decode($datos->empresa_ciudad),0,0,'R');	
		$this->pdf->Ln();
		$this->pdf->Cell(65);
		$this->pdf->Cell(60,5,utf8_decode($datos->regimen_nombre),0,0,'C');
		$this->pdf->Cell(65,5,utf8_decode($datos->empresa_correo),0,0,'R');
	}
	//Salto de línea
	$this->pdf->SetFont('Arial','',11);
	$this->pdf->Ln(10);
	$this->pdf->Cell(50,7,"",0,0);
	$this->pdf->Cell(60);
	
	$pedido_id = $this->uri->segment(3);
	$obtenerDatos = $this->pedido_model->pdf($pedido_id);
	foreach($obtenerDatos as $row){
		$this->pdf->Cell(75,7,utf8_decode('Pedido Nº'),0,0,'R');
		$this->pdf->Ln();
		$this->pdf->Cell(160);
		$this->pdf->Cell(25,7,utf8_decode($row->pedido_id),0,0,'R');
		break;
	}
	//Rellenar de color gris las celdas
	$this->pdf->setFillColor(210, 210, 210);
	$fill = true;
	//Color gris para las lineas
	$this->pdf->SetDrawColor(200, 200, 200);
	$this->pdf->SetLineWidth(.1);
	$pedido_id = $this->uri->segment(3);
	$obtenerDatos = $this->pedido_model->pdf($pedido_id);
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
		$this->pdf->Cell(50,5,utf8_decode($row->pedido_fecha),1,0,'C');//Fecha de creación
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
		$this->pdf->SetFont('Arial','',10);
		$this->pdf->Cell(20,5,"NIT",1,0,'L',$fill);
		$this->pdf->SetFont('Arial','',10);
		$this->pdf->Cell(40,5,utf8_decode($row->relacion_nit),1);
		$this->pdf->SetFont('Arial','',9);
		$this->pdf->Cell(50,5,utf8_decode($row->pedido_fechavencimiento),1,0,'C');//Fecha de vencimiento
		break;
    }
   //Tabla simple

		$this->pdf->setFillColor(210, 210, 210);
		$fill = true;
		$this->pdf->SetDrawColor(200, 200, 200);
		$this->pdf->SetLineWidth(.1);
		//Nombre de las columnas
		$this->pdf->SetFont('Arial','B',11);
		$this->pdf->Ln(10);
		$this->pdf->Cell(75,5,"Productos",1,0,'C',$fill);
		$this->pdf->Cell(30,5,"Precio",1,0,'C',$fill);
		$this->pdf->Cell(30,5,"Cantidad",1,0,'C',$fill);
		$this->pdf->Cell(25,5,"Descuento",1,0,'C',$fill);
		$this->pdf->Cell(30,5,"Total",1,0,'C',$fill);
		$this->pdf->Ln();
		//Cuerpo de la cotización
		$this->pdf->Rect(10,90,190,80,'f');//Rectangulo completo
		$this->pdf->Rect(10,90,75,80,'f');
		$this->pdf->Rect(85,90,30,80,'f');
		$this->pdf->Rect(115,90,30,80,'f');
		$this->pdf->Rect(145,90,25,80,'f');
		$this->pdf->Rect(170,90,30,80,'f');
		$w = array(75,30,30,25,30);
		$pedido_id = $this->uri->segment(3);
		$obtenerDatos = $this->pedido_model->pdf($pedido_id);
			foreach($obtenerDatos as $row){
				$this->pdf->SetFont('Arial','',10);
				$this->pdf->Cell($w[0],8,utf8_decode($row->producto_nombre),'');
				$this->pdf->Cell($w[1],8,utf8_decode("$ ".number_format($row->detalleproducto_precio,2)),'',0,'C');
				$this->pdf->Cell($w[2],8,utf8_decode($row->detalleproducto_cantidad),'',0,'C');
				$this->pdf->Cell($w[3],8,utf8_decode($row->detalleproducto_descuento),'',0,'C');
				$subtotal = $row->detalleproducto_precio*$row->detalleproducto_cantidad;
				$descuento = $subtotal*($row->detalleproducto_descuento/100);
				$this->pdf->Cell($w[4],8,utf8_decode("$ ".number_format($subtotal-$descuento,2)),'',0,'C');
				$this->pdf->Ln();
			}
		//$this->pdf->Cell(array_sum($w),0,'','T');
		
		//Pie del total
		$this->pdf->setXY(80,170);
		$this->pdf->Ln();
		$this->pdf->Cell(75,5,"",0,0,'C');
		$this->pdf->Cell(30,20,"",0,0,'L');
		$this->pdf->Cell(25,5,"",0,0,'C');
		$this->pdf->Cell(30,5,"Subtotal :",0,0,'R');
		$subtotal = 0;
		foreach($obtenerDatos as $row){
			$sub = ($row->detalleproducto_precio*$row->detalleproducto_cantidad);
			$des = ($sub*($row->detalleproducto_descuento/100));
			$subtotal = $subtotal+ ($sub - $des);
		}			
		$this->pdf->Cell(30,5,utf8_decode("$ ".number_format($subtotal,2)),0,0,'R');
		$this->pdf->SetFont('Arial','',8.5);			
		$this->pdf->Ln();
		foreach($obtenerDatos as $row){
			$this->pdf->Cell(130,5,utf8_decode("Observaciones: ".($row->pedido_observacion)),0,0,'L');
			break;
		}
		$this->pdf->SetFont('Arial','',10);	
		$this->pdf->Cell(30,5,"Descuento :",0,0,'R');
		$descuento = 0;
		foreach($obtenerDatos as $row){
			$sub = ($row->detalleproducto_precio*$row->detalleproducto_cantidad);
			$descuento = $descuento +($sub*($row->detalleproducto_descuento/100));
		}		
		$this->pdf->Cell(30,5,utf8_decode("- $ ".number_format($descuento,2)),0,0,'R');
		/*$this->pdf->Ln(7);
		$this->pdf->Cell(75,5,"",0,0,'C');
		$this->pdf->Cell(30,5,"",0,0,'C');
		$this->pdf->Cell(25,5,"",0,0,'C');
		$this->pdf->Cell(30,5,"Subtotal :",0,0,'R');
		$this->pdf->Cell(30,5,"",0,0,'R');*/
		$this->pdf->Ln();
		$this->pdf->Cell(75,5,"",0,0,'C');
		$this->pdf->Cell(30,5,"",0,0,'C');
		$this->pdf->Cell(25,5,"",0,0,'C');
		$this->pdf->Cell(30,5,"IVA :",0,0,'R');
		
		$subIva = 0;
		foreach($obtenerDatos as $row){
			$impuesto = $row->impuesto_id;
			$data = $this->impuesto_model->obtenerDatos($impuesto);
			
			foreach($data as $row1){
				$porcentaje = $row1->impuesto_porcentaje;
			}				
				$sub = ($row->detalleproducto_precio*$row->detalleproducto_cantidad);
				$des = ($sub*($row->detalleproducto_descuento/100));
				$subdes = $sub - $des;
				$iva = ($subdes*($porcentaje/100));
				$subIva = $subIva + $iva;				
		}
		
		$this->pdf->Cell(30,5,utf8_decode("$ ".number_format($subIva,2)),0,0,'R');
		$this->pdf->Ln();
		$this->pdf->SetFont('Arial','B',10);
		$this->pdf->Cell(75,5,"",0,0,'C');
		$this->pdf->Cell(30,5,"",0,0,'C');
		$this->pdf->Cell(25,5,"",0,0,'C');
		$this->pdf->Cell(30,5,"TOTAL  :",0,0,'R',$fill);
		$total = 0;
		foreach($obtenerDatos as $row){
			$sub = ($row->detalleproducto_precio*$row->detalleproducto_cantidad);
			$des = ($sub*($row->detalleproducto_descuento/100));
			$subdes = $sub - $des;
			//$subIva = $subIva + $iva;
			$total = $total + $subdes;
		}
		$total1 = $total + $subIva;
		$this->pdf->Cell(30,5,utf8_decode("$ ".number_format($total1,2)),0,0,'R',$fill);
		$this->pdf->Ln(30);
		$this->pdf->Line(20,230,100,230);
		//$this->pdf->Cell(33,8,"",0,0,'C');
		$this->pdf->setXY(43,230);
		$this->pdf->Cell(30,8,"ELABORADA POR",0,0,'C');
		//$this->pdf->write(5,"ELABORADA POR");
		
		$this->pdf->Output("pedido.pdf", 'I');

	}
}//fin de la clase
