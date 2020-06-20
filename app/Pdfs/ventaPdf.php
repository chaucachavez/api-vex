<?php

namespace App\Pdfs;
   
use App\Models\Venta;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Storage;

class PDF extends Fpdf
{		
	public $header = [];
	public $title = '';
	public $logo = '';

    // Cabecera de página
    function Header()
    {
        // Logo 
        $this->Image($this->logo, 2, 2, 33, 0);
        
        // Colores, ancho de línea y fuente en negrita 
	    $this->SetDrawColor(0,0,0); 

	    // Título
        $this->SetFont('Arial', 'B', 15);          
        $this->Cell(0, 12, $this->title, 0, 0,'C');

        // Salto de línea
        $this->SetLineWidth(.5);
        $this->Ln(18); 
        $this->Line(2, $this->GetY(), 296, $this->GetY()); 
        $this->Line(2, $this->GetY() + 12, 296, $this->GetY() + 12);

        // Colores, ancho de línea y fuente en negrita 
	    $this->SetTextColor(0); 
	    $this->SetFillColor(235,235,235);

	    // Criterios  
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(14, 12, 'DESDE: ', 0);
        $this->SetFont('Arial'); 
        $this->Cell(23, 12, '11/01/2019', 0); 
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(14, 12, 'HASTA: ', 0);
        $this->SetFont('Arial'); 
        $this->Cell(23, 12, '09/02/2019', 0); 
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(17, 12, 'ESTADO: ', 0);
        $this->SetFont('Arial'); 
        $this->Cell(0, 12, 'Pagado', 0);
        
        // Salto de línea
        $this->Ln(18); 

        // Colores, ancho de línea y fuente en negrita
	    $this->SetFillColor(3,155,229);
	    $this->SetTextColor(255);
	    $this->SetDrawColor(3,155,229);
	    $this->SetLineWidth(.3);
	    $this->SetFont('Arial','B', 7);

	    // Cabecera
	    $w = array(6, 10, 14, 22, 20, 20, 50, 13, 23, 14, 15, 15, 50, 22);
	    $h = 6.5;
	    $b = '';
	    for($i = 0; $i < count($this->header); $i++) {
	        $this->Cell($w[$i], $h,utf8_decode($this->header[$i]),$b,0,'C',true);
	    }
	    $this->Ln(); 
    }

    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-5); 

        // Arial italic 8
        $this->SetFont('Arial','I',8);

        // Número de página
        $this->Cell(100, 5, utf8_decode('Power by http://wwww.clinicadigital.pe'), 0, 0, 'L');
        $this->Cell(100, 5, utf8_decode('Impresión Chauca Chávez, Julio César') . ' - ' . date('d/m/Y H:i'), 0, 0, 'L');
        $this->Cell(0, 5, utf8_decode('Página ').$this->PageNo().'/{nb}', 0, 0, 'R');

        // Linea
        $this->SetDrawColor(0,0,0);  
        $this->SetLineWidth(.5); 
        $this->Line(2, $this->GetY(), 296, $this->GetY()); 
    }

    // Tabla coloreada
	public function fancyTable($data)
	{   
	    // Restauración de colores y fuentes
	    $this->SetFillColor(235,235,235);
	    $this->SetTextColor(0);
	    $this->SetFont('Arial','', 8);
 
	    // Datos
	    $w = array(6, 10, 14, 22, 20, 20, 50, 13, 23, 14, 15, 15, 50, 22);
	    $h = 5;
	    $b = '';
	    $fill = false;
	    $totalPagado = 0;
	    $totalAnulado = 0;
	    $totalPendiente = 0;
	    foreach($data as $i => $row)
	    {	 
 
	    	switch ($row->idestadodocumento) {
	    		case 26:
	    			$totalPendiente += (float) $row->total;
	    			break;
	    		case 27:
	    			$totalPagado += (float) $row->total;
	    			break;
	    		case 28:
	    			$totalAnulado += (float) $row->total;
	    			break;
	    	}

	    	$estadopago = '';
	    	switch ($row->idestadodocumento) {
	    		case 26:
	    			$estadopago = 'Pendiente';
	    			break; 
	    		case 27:
	    			$estadopago = 'Pagado';
	    			break; 
	    		case 28:
	    			$estadopago = 'Anulado';
	    			break; 
	    	}

	    	$horacierre = ''; 
	    	if ($row->apertura && $row->apertura->horacierre) {
	    		$horacierre = $this->convertAmPm($row->apertura->horacierre);
	    	}

	    	$cliente = ucwords(strtolower(utf8_decode($row->cliente->entidad)));
	    	if (strlen($cliente) > 35) {
	    		$cliente = substr($cliente, 0, 35);
	    	}

	    	$personal = ucwords(strtolower(utf8_decode($row->creacion->entidad)));
	    	if (strlen($personal) > 35) {
	    		$personal = substr($personal, 0, 35);
	    	} 

	    	$this->Cell($w[0], $h, ++$i, $b, 0,'C', $fill);
	        $this->Cell($w[1], $h, $row->sede->sedeabrev, $b, 0,'C', $fill);
	        $this->Cell($w[2], $h, $row->afiliado->acronimo, $b, 0,'C', $fill);
	        $this->Cell($w[3], $h, utf8_decode($row->docnegocio->nombre), $b, 0,'L', $fill);	        
	        $this->Cell($w[4], $h, $row->serie . ' - ' . $row->numero, $b, 0,'L', $fill); 
	        $this->Cell($w[5], $h, $row->fechaemision, $b, 0,'C', $fill);
	        $this->Cell($w[6], $h, $cliente, $b, 0,'L', $fill);
	        $this->Cell($w[7], $h, $row->cliente->documento->abreviatura, $b, 0,'C', $fill);
	        $this->Cell($w[8], $h, $row->cliente->numerodoc, $b, 0,'L', $fill);
	        $this->Cell($w[9], $h, $estadopago, $b, 0,'R', $fill);
	        $this->Cell($w[10], $h, $row->idmediopago, $b, 0,'R', $fill);
	        $this->Cell($w[11], $h, $row->total, $b, 0,'R', $fill);
	        $this->Cell($w[12], $h, $personal, $b, 0,'L', $fill); 
	        $this->Cell($w[13], $h, $row->idapertura . ' ' . $horacierre, $b, 0, 'L', $fill); 
	        $this->Ln();
	        $fill = !$fill;
	    }

	    if (count($data) === 0) {
	    	$this->Cell(0, $h, 'No hay registros.', $b, 0, 'C', $fill); 
	        $this->Ln();
	    }

	    // Línea de cierre
	    $h = 8;
	    $this->SetFont('Arial','B', 8);	    
	    $this->Cell(207, $h, 'Ventas anulados PEN','T', 0, 'R');
	    $this->Cell(15,  $h, number_format($totalAnulado, 2, '.', ','),'T', 0 , 'R');
	    $this->Cell(0,  $h, '', 'T');
	    $this->Ln();
	    $this->Cell(207, $h, 'Ventas pagados PEN','T', 0, 'R');
	    $this->Cell(15,  $h, number_format($totalPagado, 2, '.', ','),'T', 0 , 'R');
	    $this->Cell(0,  $h, '', 'T');
	    $this->Ln();
	    $this->Cell(207, $h, 'Ventas pendientes PEN','TB', 0, 'R');
	    $this->Cell(15,  $h, number_format($totalPendiente, 2, '.', ','),'T,B', 0, 'R');
	    $this->Cell(0,  $h, '', 'T,B');
	}

	public function convertAmPm($hour) {   
        $newDateTime = null;
        if(isset($hour) && !empty($hour)){
            $currentDateTime = date('Y-m-d').' '.$hour;
            $newDateTime = date('h:i A', strtotime($currentDateTime));
        }
        return $newDateTime;
    }
}

class VentaPdf
{
	public function __construct(Request $request)
    {
        $this->betweenDate = ['2019-02-01', '2019-03-05'];

        $this->valores = Venta::with([
        	'sede:idsede,sedeabrev', 
        	'docnegocio:iddocumentofiscal,nombre', 
        	'cliente:identidad,entidad,iddocumento,numerodoc',
        	'cliente.documento:iddocumento,nombre,abreviatura',
        	'afiliado:identidad,acronimo',
        	'creacion:identidad,entidad',
        	'apertura:idapertura,horacierre'
        ])
        ->whereBetween('fechaemision', $this->betweenDate) 
        ->orderBy('fechaemision', 'asc') 
        ->orderBy('idafiliado', 'asc') 
        ->orderBy('numero', 'asc') 
        ->get();  
    } 

    public function download(string $filename = 'file.pdf', $save = false) { 

    	$pdf = new PDF();

    	$pdf->title = 'VENTAS';
    	$pdf->logo = storage_path('app/osi/logologin.png');

    	// Títulos de las columnas 
    	$pdf->header = ['#', 'SEDE', 'AFIL.', 'COMPROBANTE', 'NÚMERO', 'F.EMISIÓN', 'CLIENTE', 'DOC.', 'IDENTIF.', 'ESTADO', 'M.PAGO', 'TOTAL', 'CREACIÓN', 'CAJA'];
       
        $pdf->SetMargins(2,2,2);
        $pdf->SetAutoPageBreak(true, 4);
        $pdf->AliasNbPages();      
        $pdf->SetFont('Arial','B',16);
        $pdf->AddPage('L', 'A4');
        // $pdf->Cell(40,10, $this->betweenDate[0]);
 		// $pdf->ln(); 		
		
		// Carga de datos  
		$pdf->fancyTable($this->valores);
 		
 		// Salida
	 	/* I: envía el fichero al navegador de forma que se usa la extensión (plug in) si está disponible.
		   D: envía el fichero al navegador y fuerza la descarga del fichero con el nombre especificado por name.
		   F: guarda el fichero en un fichero local de nombre name.
		   S: devuelve el documento como una cadena. 
		*/
        if ($save) {
        	Storage::disk('local')->put($filename, $pdf->Output('S'));  
        } else {
        	$pdf->Output();
        }     
    }
}
