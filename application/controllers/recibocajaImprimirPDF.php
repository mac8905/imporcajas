<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class RecibocajaImprimirPDF extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model("recibocaja_model");
		$this->load->model("empresa_model");
		$this->load->model("impuesto_model");
		$this->load->library("pdf");
	}
	
	public function index(){
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
		$this->pdf->Cell(50,7,utf8_decode('Recibo de Caja'),0,0);
		$this->pdf->Cell(90);
	
	
		//Color gris para las lineas
		$this->pdf->SetDrawColor(200, 200, 200);
		$this->pdf->SetLineWidth(.1);		
		
		$recibocaja_id = $this->uri->segment(3);
		$obtenerDatos = $this->recibocaja_model->pdf($recibocaja_id);
		foreach($obtenerDatos as $row){
			$this->pdf->setFillColor(170, 170, 170);
			$oscuro = true;
			$this->pdf->SetFont('Arial','B',8);			
			$this->pdf->Cell(50,6,utf8_decode('RECIBO DE CAJA'),1,0,'C',$oscuro);
			$this->pdf->Ln();
			$this->pdf->Cell(140);
			$this->pdf->setFillColor(220, 220, 220);
			$fill = true;
			$this->pdf->SetFont('Arial','',11);
			$this->pdf->Cell(50,10,utf8_decode($row->recibocaja_id),1,0,'C',$fill);
			break;
		}
		
		//Rellenar de color gris las celdas
		$this->pdf->setFillColor(210, 210, 210);
		$fill = true;
	
		//Color gris para las lineas
		$this->pdf->SetDrawColor(200, 200, 200);
		$this->pdf->SetLineWidth(.1);

		//Inicio de la tabla de datos del contacto	
		$recibocaja_id = $this->uri->segment(3);
		$obtenerDatos = $this->recibocaja_model->pdf($recibocaja_id);
		foreach($obtenerDatos as $row){
			$this->pdf->Ln(15);	  
			$this->pdf->SetFont('Arial','B',10);
			$this->pdf->Cell(35,5,utf8_decode("RECIBIMOS DE"),'LRT',0,'R',$fill);
			$this->pdf->SetFont('Arial','',10);
			$this->pdf->Cell(105,5,utf8_decode($row->relacion_nombre),1);
			$this->pdf->SetFont('Arial','B',8);
			$this->pdf->Cell(50,5,utf8_decode("FECHA (DD/MM/AA)"),1,0,'C',$fill);
			$this->pdf->Ln();
			$this->pdf->SetFont('Arial','B',10);
			$this->pdf->Cell(35,5,utf8_decode("DIRECCIÓN"),'LR',0,'R',$fill);
			$this->pdf->SetFont('Arial','',10);
			$this->pdf->Cell(105,5,utf8_decode($row->relacion_direccion),1);
			$this->pdf->SetFont('Arial','',9);
			$this->pdf->Cell(50,5,'','LR',0,'C');//Fecha de creación
			$this->pdf->Ln();
			$this->pdf->SetFont('Arial','B',10);
			$this->pdf->Cell(35,5,"CIUDAD",'LR',0,'R',$fill);
			$this->pdf->SetFont('Arial','',10);
			$this->pdf->Cell(40,5,utf8_decode($row->relacion_ciudad),1);
			$this->pdf->SetFont('Arial','B',10);
			$this->pdf->Cell(35,5,utf8_decode("MÉTODO DE PAGO"),1,0,'L',$fill);
			$this->pdf->SetFont('Arial','',10);
			$this->pdf->Cell(30,5,utf8_decode($row->metodopago_nombre),1,0,'C');
			$this->pdf->Cell(50,5,utf8_decode($row->recibocaja_fecha),'LR',0,'C');//fecha
			$this->pdf->Ln();
			$this->pdf->SetFont('Arial','B',10);
			$this->pdf->Cell(35,5,utf8_decode("TELÉFONO"),'LRB',0,'R',$fill);
			$this->pdf->SetFont('Arial','',10);
			$this->pdf->Cell(45,5,utf8_decode($row->telefonor_numero),1);
			$this->pdf->SetFont('Arial','B',10);
			$this->pdf->Cell(20,5,"NIT",1,0,'L',$fill);
			$this->pdf->SetFont('Arial','',10);
			$this->pdf->Cell(40,5,utf8_decode($row->relacion_nit),1);
			$this->pdf->SetFont('Arial','',9);
			$this->pdf->Cell(50,5,'','LRB',0,'C');//Fecha de vencimiento
			break;
		}
	   //fin de tabla de datos del contacto	

		//Nombre de las columnas
		$this->pdf->SetFont('Arial','B',10);
		$this->pdf->Ln(10);
		$this->pdf->Cell(100,5,"CONCEPTO",1,0,'C',$fill);
		$this->pdf->Cell(30,5,"IVA",1,0,'C',$fill);
		$this->pdf->Cell(60,5,"VALOR",1,0,'C',$fill);
		$this->pdf->Ln();
		//Cuerpo del recibo de caja
		$this->pdf->Rect(10,94,100,100,'f');//Rectangulo completo
		$this->pdf->Rect(10,94,130,100,'f');
		$this->pdf->Rect(110,94,90,100,'f');
		$w = array(100,30,60);
		$recibocaja_id = $this->uri->segment(3);
		$obtenerDatos = $this->recibocaja_model->pdf($recibocaja_id);
			foreach($obtenerDatos as $row){
				$subtotal = ($row->detallerecibo_valor*$row->detallerecibo_cantidad);
				$subtotalimpuesto = ($subtotal*($row->impuesto_porcentaje/100));
				$total = $subtotal + $subtotalimpuesto;			
			
				$this->pdf->SetFont('Arial','',10);
				$this->pdf->Cell($w[0],8,utf8_decode($row->puc_nombre),'');
				$this->pdf->Cell($w[1],8,utf8_decode($row->impuesto_nombre),'',0,'C');
				$this->pdf->Cell($w[2],8,utf8_decode("$ ".number_format($total,2)),'',0,'C');
				$this->pdf->Ln();
			}

		//Nombre de las columnas
		$this->pdf->SetFont('Arial','B',10);
		$this->pdf->Ln();//Salto de linea para ubicar el cuadro retenciones
		$this->pdf->setXY(10,195);
		$this->pdf->Cell(100,5,"RETENCIONES",1,0,'C',$fill);
		$this->pdf->Cell(30,5,"VALOR",1,0,'C',$fill);
		$this->pdf->Ln();
		//Cuerpo de retenciones
		$this->pdf->Rect(10,195,100,50,'f');//Rectangulo completo
		$this->pdf->Rect(10,195,130,50,'f');
		$w = array(100,30);
		$recibocaja_id = $this->uri->segment(3);
		$obtenerDatos = $this->recibocaja_model->consultarRetencion($recibocaja_id);
			foreach($obtenerDatos as $retencion){
				$this->pdf->SetFont('Arial','',10);
				$this->pdf->Cell($w[0],8,utf8_decode($retencion->retencion_nombre),'');
				$this->pdf->Cell($w[1],8,utf8_decode("$ ".number_format($retencion->retencion_valor,2)),'',0,'C');
				$this->pdf->Ln();
			}	

		//Totales del recibo de caja
			$this->pdf->setXY(90,217);
			$this->pdf->Ln();
			$this->pdf->SetFont('Arial','',6.8);
			$this->pdf->Cell(125,5,'',0,0,'L');
			$this->pdf->SetFont('Arial','',10);
			$this->pdf->Cell(35,5,"IVA :",0,0,'R');
			
			//Mostrar iva
			$recibocaja_id = $this->uri->segment(3);
			$obtenerDatos = $this->recibocaja_model->pdf($recibocaja_id);
			$subIva = 0;
			foreach($obtenerDatos as $row){
				$impuesto = $row->impuesto_id;
				$data = $this->impuesto_model->obtenerDatos($impuesto);
				
				foreach($data as $row1){
					$porcentaje = $row1->impuesto_porcentaje;
				}				
					$sub = ($row->detallerecibo_valor*$row->detallerecibo_cantidad);
					$iva = ($sub*($porcentaje/100));
					$subIva = $subIva + $iva;				
			}	
			$this->pdf->Cell(30,5,utf8_decode("$ ".number_format($subIva,2)),0,0,'R');	
			//fin de mostrar iva	

			//Mostrar subtotal
			$this->pdf->SetFont('Arial','',8.5);		
			$this->pdf->Ln();
			
			$this->pdf->SetFont('Arial','',10);
			$this->pdf->Cell(125,5,'',0,0,'L');
			$this->pdf->Cell(35,5,"Subtotal :",0,0,'R');
			
			$subtotal1 = 0;	
			foreach ($obtenerDatos as $mostrar){
				$sub = ($mostrar->detallerecibo_valor*$mostrar->detallerecibo_cantidad);
				$des = ($sub*($mostrar->impuesto_porcentaje/100));
				$subtotal1 = $subtotal1 + ($sub + $des);	
			}
			
			$this->pdf->Cell(30,5,utf8_decode("$ ".number_format($subtotal1,2)),0,0,'R');
			//Fin mostrar subtotal
			
			$this->pdf->Ln();
			$this->pdf->Cell(125,5,"",0,0,'C');
			
			//Mostrar retenciones
			$this->pdf->Cell(35,5,utf8_decode("Retención :"),0,0,'R');
			
			$totalretencion = 0;
			$recibocaja_id = $this->uri->segment(3);
			$obtenerRetencion = $this->recibocaja_model->consultarRetencion($recibocaja_id);
			foreach($obtenerRetencion as $retencion){
				$totalretencion = $totalretencion + $retencion->retencion_valor;
			}				
			$this->pdf->Cell(30,5,utf8_decode("- $ ".number_format($totalretencion,2)),0,0,'R');
			//fin de mostrar retenciones
			
			$this->pdf->Ln();
			$this->pdf->SetFont('Arial','B',10);
			$this->pdf->Cell(75,5,"",0,0,'C');
			$this->pdf->Cell(30,5,"",0,0,'C');
			$this->pdf->Cell(30,5,"",0,0,'C');
			$this->pdf->Cell(25,5,"TOTAL  :",0,0,'R',$fill);
			$total = 0;
			$total = $subtotal1 - $totalretencion;
			$this->pdf->Cell(30,5,utf8_decode("$ ".number_format($total,2)),0,0,'R',$fill);		
		//fin de totales
		
			$this->pdf->Ln();
			$this->pdf->SetFont('Arial','B',9);
			$this->pdf->Line(15,268,100,268);
			$this->pdf->Cell(10,10,"",0,0,'C');
			$this->pdf->Line(110,268,195,268);
			$this->pdf->setXY(10,265);
			$this->pdf->Cell(95,10,utf8_decode("Firma y Sello"),0,0,'C');
			$this->pdf->Cell(95,10,utf8_decode("LUIS EDUARDO SERRANO ACERO"),0,0,'C');		
		
		//Función para mostrar el pdf en otra pagina del navegador
		$this->pdf->Output("ReciboCaja.pdf", 'I');	
	}
}