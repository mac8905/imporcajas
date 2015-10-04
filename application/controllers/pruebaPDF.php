<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
class pruebaPDF extends CI_Controller
{
	public function __construct(){
		parent::__construct();
		$this->load->model("pedido_model");
		$this->load->library('pdf');
	}
//Cabecera de página
   public function index()
   {
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Wilmar Caicedo - Miguel Caro');
		$pdf->SetTitle('Pedido');
		$pdf->SetSubject('Imporcajas');
		$pdf->SetKeywords('TCPDF, PDF, Imporcajas, Pedido');
		// datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config_alt.php de libraries/config
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 001', PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setFooterData($tc = array(0, 64, 0), $lc = array(0, 64, 128));
 
// datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
 
// se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
 
// se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
 
// se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
 
//relación utilizada para ajustar la conversión de los píxeles
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		// add a page
		$pdf->AddPage();
		//Cuerpo del docuemnto
		$pdf->SetFont('Helvetica','',10);

		$pedido_id = $this->uri->segment(3);
		$obtenerDatos = $this->pedido_model->pdf($pedido_id);
		foreach($obtenerDatos as $row){
		$html = '<table>
				<tr>
					<td width="15%" style="border:1px solid #BDBDBD">
					SEÑOR(ES)
					</td>
					<td width="60%" style="border:1px solid #BDBDBD">
					</td>
					<td width="25%" style="border:1px solid #BDBDBD">
					</td>
				</tr>
				<tr>
					<td width="15%" style="border:1px solid #BDBDBD">
					</td>
					<td width="60%" style="border:1px solid #BDBDBD">
					</td>
					<td width="25%" style="border:1px solid #BDBDBD">
					</td>
				</tr>
				<tr>
					<td width="15%" style="border:1px solid #BDBDBD">
					</td>
					<td width="60%" style="border:1px solid #BDBDBD">
					</td>
					<td width="25%" style="border:1px solid #BDBDBD">
					</td>
				</tr>
				<tr>
					<td width="15%" style="border:1px solid #BDBDBD">
					</td>
					<td width="25%" style="border:1px solid #BDBDBD">
					</td>
					<td width="10%" style="border:1px solid #BDBDBD">
					</td>
					<td width="25%" style="border:1px solid #BDBDBD">
					</td>
					<td width="25%" style="border:1px solid #BDBDBD">
					</td>
				</tr>					
				</table>';
		}
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->Output('Pedido', 'I');
   }
}//fin de la clase
