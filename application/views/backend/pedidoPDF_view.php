<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class pedidoPDF extends CI_Controller
{
	public function __construct(){
		parent::__construct();
		$this->load->model("pedido_model");
		$this->load->library('pdf');
	}
//Cabecera de página
   public function index()
   {
	 //$pdf=new PDF();
	//Primera página
	$this->pdf->AddPage();
	$this->pdf->AliasNbPages();
 
	//Logo
	//$this->Image("leon.jpg" , 10 ,8, 35 , 38 , "JPG" ,"http://www.mipagina.com");
	//Arial bold 15
	$this->pdf->SetFont('Arial','B',12);
	//Movernos a la derecha
	$this->pdf->Cell(65);

	//Título
	$this->pdf->Cell(60,8,'Imporcajas',0,0,'C');
	$this->pdf->Ln();
	$this->pdf->Cell(65);
	$this->pdf->Cell(60,8,'Nit',0,0,'C');
	//Salto de línea
	$this->pdf->Ln(15);
	$this->pdf->Cell(50,7,utf8_decode('Pedido'),0,0);
	$this->pdf->Cell(90);
	$this->pdf->Cell(50,7,utf8_decode('Pedido Nº'),0,0);
	//Rellenar de color gris las celdas
	$this->pdf->setFillColor(210, 210, 210);
	$fill = true;
	//Color gris para las lineas
	$this->pdf->SetDrawColor(200, 200, 200);
	$this->pdf->SetLineWidth(.1);
	$pedido_id = $this->uri->segment(3);
	$obtenerDatos = $this->pedido_model->pdf($pedido_id);
	foreach($obtenerDatos as $row){
		$this->pdf->Ln(20);	  
		$this->pdf->SetFont('Arial','B',10);
		$this->pdf->Cell(35,5,utf8_decode("SEÑOR(ES)"),1,0,'L',$fill);
		$this->pdf->Cell(105,5,utf8_decode($row->relacion_nombre),1);
		$this->pdf->Cell(50,5,utf8_decode("FECHA DE EXPEDICIÓN"),1,0,'C',$fill);
		$this->pdf->Ln();
		$this->pdf->Cell(35,5,utf8_decode("DIRECCIÓN"),1,0,'L',$fill);
		$this->pdf->Cell(105,5,utf8_decode($row->relacion_direccion),1);
		$this->pdf->Cell(50,5,utf8_decode($row->pedido_fecha),1);//Fecha de creación
		$this->pdf->Ln();
		$this->pdf->Cell(35,5,"CIUDAD",1,0,'L',$fill);
		$this->pdf->Cell(105,5,utf8_decode($row->relacion_ciudad),1);
		$this->pdf->Cell(50,5,"FECHA DE VENCIMIENTO",1,0,'C',$fill);
		$this->pdf->Ln();
		$this->pdf->Cell(35,5,utf8_decode("TELÉFONO"),1,0,'L',$fill);
		$this->pdf->Cell(45,5,"Hola 2",1);
		$this->pdf->Cell(20,5,"NIT",1,0,'L',$fill);
		$this->pdf->Cell(40,5,utf8_decode($row->relacion_nit),1);
		$this->pdf->Cell(50,5,utf8_decode($row->pedido_fechavencimiento),1);//Fecha de vencimiento
		break;
    }
   //Tabla simple

		$this->pdf->setFillColor(210, 210, 210);
		$fill = true;
		$this->pdf->SetDrawColor(200, 200, 200);
		$this->pdf->SetLineWidth(.1);
		//Nombre de las columnas
		$this->pdf->Ln(10);
		$this->pdf->Cell(75,5,"Productos",1,0,'C',$fill);
		$this->pdf->Cell(30,5,"Precio",1,0,'C',$fill);
		$this->pdf->Cell(30,5,"Cantidad",1,0,'C',$fill);
		$this->pdf->Cell(25,5,"Descuento",1,0,'C',$fill);
		$this->pdf->Cell(30,5,"Total",1,0,'C',$fill);
		$this->pdf->Ln();
		//Cuerpo de la cotización
		
		$w = array(75,30,30,25,30);
		$pedido_id = $this->uri->segment(3);
		$obtenerDatos = $this->pedido_model->pdf($pedido_id);
			foreach($obtenerDatos as $row){
				$this->pdf->Cell($w[0],8,utf8_decode($row->producto_nombre),'LR');
				$this->pdf->Cell($w[1],8,utf8_decode($row->detalleproducto_precio),'LR',0,'C');
				$this->pdf->Cell($w[2],8,utf8_decode($row->detalleproducto_cantidad),'LR',0,'C');
				$this->pdf->Cell($w[3],8,utf8_decode($row->detalleproducto_descuento),'LR',0,'C');
				$this->pdf->Cell($w[4],8,utf8_decode($row->detalleproducto_precio),'LR',0,'C');
				$this->pdf->Ln();
			}

		$this->pdf->Cell(array_sum($w),0,'','T');
		
		//Pie del total
		$this->pdf->Ln(10);
		$this->pdf->Cell(125,20,utf8_decode("Descripción"),0,0,'L',$fill);
		$this->pdf->Cell(5,5,"",0,0,'C');
		$this->pdf->Cell(30,5,"Subtotal :",0,0,'C');
		$this->pdf->Cell(30,5,"",0,0,'C');	
		$this->pdf->Ln();
		$this->pdf->Cell(75,5,"",0,0,'C');
		$this->pdf->Cell(30,5,"",0,0,'C');
		$this->pdf->Cell(25,5,"",0,0,'C');
		$this->pdf->Cell(30,5,"Descuento :",0,0,'C');
		$this->pdf->Cell(30,5,"",0,0,'C');
		$this->pdf->Ln();
		$this->pdf->Cell(75,5,"",0,0,'C');
		$this->pdf->Cell(30,5,"",0,0,'C');
		$this->pdf->Cell(25,5,"",0,0,'C');
		$this->pdf->Cell(30,5,"Subtotal :",0,0,'C');
		$this->pdf->Cell(30,5,"",0,0,'C');
		$this->pdf->Ln();
		$this->pdf->Cell(75,5,"",0,0,'C');
		$this->pdf->Cell(30,5,"",0,0,'C');
		$this->pdf->Cell(25,5,"",0,0,'C');
		$this->pdf->Cell(30,5,"IVA(16%) :",0,0,'C');
		$this->pdf->Cell(30,5,"",0,0,'C');
		$this->pdf->Ln(7);
		$this->pdf->Cell(75,5,"",0,0,'C');
		$this->pdf->Cell(30,5,"",0,0,'C');
		$this->pdf->Cell(25,5,"",0,0,'C');
		$this->pdf->Cell(30,5,"TOTAL :",0,0,'C',$fill);
		$this->pdf->Cell(30,5,"",0,0,'C',$fill);

	$this->pdf->Output("pedido.pdf", 'I');

	}
}//fin de la clase
