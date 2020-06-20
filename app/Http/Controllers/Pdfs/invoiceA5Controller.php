<?php

namespace App\Http\Controllers\Pdfs;

use App\Models\Sede;
use App\Models\Venta;
use App\Models\Empresa;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Codedge\Fpdf\Fpdf\Fpdf as baseFpdf;

class PDFA5 extends baseFpdf 
{        
    public $path = 'http://apiapp.pe/img/';   
    public $borde = 0;
    public $logo;        
    public $serienumero; 
    public $razonsocial;  
    public $ruc;
    public $direccion;
    public $ubigeo;
    public $telefono;   
    public $nombreFile;
    public $comprobante;
    PUBLIC $color = [191,54,12]; //25, 8, 255
    public $pathImg =  'C:\\xampp\\htdocs\\apiapp\\public\\pdf\\';
    // public $pathImg =  '/home/centromedico/public_html/apiosi/public/pdf/';
    // public $pathImg =  '/home/ositest/public_html/apiosi/public/pdf/';

    function Header()
    {        
        $this->Image($this->path . $this->logo, 4, 4, 74, 0);  
        $this->SetFont('Arial', 'B', 12);
        $this->SetTextColor($this->color[0], $this->color[1], $this->color[2]);
        $this->SetFillColor(255, 255, 255); 
        $this->SetDrawColor($this->color[0], $this->color[1], $this->color[2]);  

        $height = 6;
        $size = 13;

        $this->RoundedRect(132, 4, 74, 24, 1.5, '1234', 'DF');

        $this->setX(132);
        $this->SetFont('Arial', 'B', 12);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(74, $height, 'RUC: ' . $this->ruc, $this->borde, 0, 'C'); 
        $this->Ln();  
        $this->setX(132);
        $this->SetFont('Arial', 'B', $size);
        $this->SetTextColor($this->color[0], $this->color[1], $this->color[2]);
        $this->Cell(74, $height, utf8_decode($this->comprobante), $this->borde, 0, 'C'); 
        $this->Ln();  
        $this->setX(132);
        $this->SetFont('Arial', 'B', $size);
        $this->SetTextColor($this->color[0], $this->color[1], $this->color[2]);
        $this->Cell(74, $height, utf8_decode('ELECTRÓNICA'), $this->borde, 0, 'C'); 
        $this->Ln();  
        $this->setX(132);
        $this->SetFont('Arial', 'B', 12);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(74, $height, $this->serienumero, $this->borde, 0, 'C'); 

        $height = 4;
        $this->setXY(4, 24); 
        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor($this->color[0], $this->color[1], $this->color[2]);
        $this->MultiCell(128, 5, utf8_decode($this->razonsocial), $this->borde, 'L', false, 2); 

        $this->SetFont('Arial', '', 8);
        $this->SetTextColor(0, 0, 0);
        $this->MultiCell(128, $height, utf8_decode($this->direccion), $this->borde, 'L', false, 2);   
        $this->Cell(128, $height, utf8_decode($this->ubigeo), $this->borde, 0, 'L');    
        $this->Ln();
        $this->MultiCell(128, $height, utf8_decode($this->telefono), $this->borde, 'L', false, 2);
        $this->Ln(3);
    }

    function Footer() 
    {  
        // Codigo QR 
        $this->SetDrawColor($this->color[0], $this->color[1], $this->color[2]); 
        $this->setY(-26);
        $this->Cell(22, 20, utf8_decode(''), $this->borde, 0, 'L');

        $this->setXY(4, -26);            
        $this->Image('http://apiapp.pe/empresa/31/img/logo_pdf.png', $this->getX() + 1, $this->getY(), 20, 0, 'PNG');

        $this->SetFont('Arial', '', 8.5); 
        $this->setXY(26, -26); 
        $this->Cell(180, 8, utf8_decode(''), $this->borde, 0, 'L');
        $this->Ln();
        $this->setX(26);
        $this->Cell(180, 4, utf8_decode('Representación impresa de la '. $this->comprobante.' ELECTRÓNICA, para ver el documento visita:'), $this->borde, 0, 'L');
        $this->Ln();
        $this->setX(26);
        $this->SetFont('Arial', '', 8.5); 
        $this->SetTextColor($this->color[0], $this->color[1], $this->color[2]);
        $this->Cell(180, 4, utf8_decode('https://www.profactura.pe/comprobantes/' . $this->ruc), $this->borde, 0, 'L');
        $this->Ln();
        $this->setX(26);
        $this->SetFont('Arial', '', 8.5); 
        $this->SetTextColor(0, 0, 0);
        $this->Cell(28, 4, utf8_decode('Emitido mediante un'), $this->borde, 0, 'L');
        $this->SetFont('Arial', 'B', 8.5); 
        $this->Cell(52, 4, utf8_decode('Proveedor Autorizado por la SUNAT'), $this->borde, 0, 'L');
        $this->SetFont('Arial', '', 8.5); 
        $this->Cell(55, 4, utf8_decode('mediante Resolución de Intendencia No.'), $this->borde, 0, 'L');
        $this->SetFont('Arial', 'B', 8.5); 
        $this->Cell(45, 4, utf8_decode('034-005-0005315'), $this->borde, 0, 'L');

        // Posición: a 1,5 cm del final
        $this->SetY(-5); 
        $this->SetFont('Arial','', 8);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(47, 5, utf8_decode(' Software de Facturación Electrónica'), $this->borde, 0, 'L');        
        $this->SetFont('Arial','B', 8.5);
        $this->SetTextColor($this->color[0], $this->color[1], $this->color[2]);
        $this->Cell(108, 5, utf8_decode('www.profactura.pe') , $this->borde, 0, 'C');
        $this->SetFont('Arial','', 8);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(47, 5, utf8_decode('Página ').$this->PageNo().'/{nb}', $this->borde, 0, 'R');

        // Linea
        $this->SetDrawColor(0,0,0);  
        $this->SetLineWidth(.5); 
        $this->Line(4, $this->GetY(), 206, $this->GetY()); 
    } 

    function MultiCell($w, $h, $txt, $border=0, $align='J', $fill=false, $maxline=0)
    {
        //Output text with automatic or explicit line breaks, at most $maxline lines
        $cw=&$this->CurrentFont['cw'];
        if($w==0)
            $w=$this->w-$this->rMargin-$this->x;
        $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
        $s=str_replace("\r",'',$txt);
        $nb=strlen($s);
        if($nb>0 && $s[$nb-1]=="\n")
            $nb--;
        $b=0;
        if($border)
        {
            if($border==1)
            {
                $border='LTRB';
                $b='LRT';
                $b2='LR';
            }
            else
            {
                $b2='';
                if(is_int(strpos($border,'L')))
                    $b2.='L';
                if(is_int(strpos($border,'R')))
                    $b2.='R';
                $b=is_int(strpos($border,'T')) ? $b2.'T' : $b2;
            }
        }
        $sep=-1;
        $i=0;
        $j=0;
        $l=0;
        $ns=0;
        $nl=1;
        while($i<$nb)
        {
            //Get next character
            $c=$s[$i];
            if($c=="\n")
            {
                //Explicit line break
                if($this->ws>0)
                {
                    $this->ws=0;
                    $this->_out('0 Tw');
                }
                $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
                $i++;
                $sep=-1;
                $j=$i;
                $l=0;
                $ns=0;
                $nl++;
                if($border && $nl==2)
                    $b=$b2;
                if($maxline && $nl>$maxline)
                    return substr($s,$i);
                continue;
            }
            if($c==' ')
            {
                $sep=$i;
                $ls=$l;
                $ns++;
            }
            $l+=$cw[$c];
            if($l>$wmax)
            {
                //Automatic line break
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                    if($this->ws>0)
                    {
                        $this->ws=0;
                        $this->_out('0 Tw');
                    }
                    $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
                }
                else
                {
                    if($align=='J')
                    {
                        $this->ws=($ns>1) ? ($wmax-$ls)/1000*$this->FontSize/($ns-1) : 0;
                        $this->_out(sprintf('%.3F Tw',$this->ws*$this->k));
                    }
                    $this->Cell($w,$h,substr($s,$j,$sep-$j),$b,2,$align,$fill);
                    $i=$sep+1;
                }
                $sep=-1;
                $j=$i;
                $l=0;
                $ns=0;
                $nl++;
                if($border && $nl==2)
                    $b=$b2;
                if($maxline && $nl>$maxline)
                {
                    if($this->ws>0)
                    {
                        $this->ws=0;
                        $this->_out('0 Tw');
                    }
                    return substr($s,$i);
                }
            }
            else
                $i++;
        }
        //Last chunk
        if($this->ws>0)
        {
            $this->ws=0;
            $this->_out('0 Tw');
        }
        if($border && is_int(strpos($border,'B')))
            $b.='B';
        $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
        $this->x=$this->lMargin;
        return '';
    }

    function RoundedRect($x, $y, $w, $h, $r, $corners = '1234', $style = '')
    {
        $k = $this->k;
        $hp = $this->h;
        if($style=='F')
            $op='f';
        elseif($style=='FD' || $style=='DF')
            $op='B';
        else
            $op='S';
        $MyArc = 4/3 * (sqrt(2) - 1);
        $this->_out(sprintf('%.2F %.2F m',($x+$r)*$k,($hp-$y)*$k ));

        $xc = $x+$w-$r;
        $yc = $y+$r;
        $this->_out(sprintf('%.2F %.2F l', $xc*$k,($hp-$y)*$k ));
        if (strpos($corners, '2')===false)
            $this->_out(sprintf('%.2F %.2F l', ($x+$w)*$k,($hp-$y)*$k ));
        else
            $this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);

        $xc = $x+$w-$r;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2F %.2F l',($x+$w)*$k,($hp-$yc)*$k));
        if (strpos($corners, '3')===false)
            $this->_out(sprintf('%.2F %.2F l',($x+$w)*$k,($hp-($y+$h))*$k));
        else
            $this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);

        $xc = $x+$r;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2F %.2F l',$xc*$k,($hp-($y+$h))*$k));
        if (strpos($corners, '4')===false)
            $this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-($y+$h))*$k));
        else
            $this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);

        $xc = $x+$r ;
        $yc = $y+$r;
        $this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-$yc)*$k ));
        if (strpos($corners, '1')===false)
        {
            $this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-$y)*$k ));
            $this->_out(sprintf('%.2F %.2F l',($x+$r)*$k,($hp-$y)*$k ));
        }
        else
            $this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
        $this->_out($op);
    }

    function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
    {
        $h = $this->h;
        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c ', $x1*$this->k, ($h-$y1)*$this->k,
            $x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
    }
}

class invoiceA5Controller extends Controller 
{        

    public function reporte($idventa, $return = false)
    { 
        $pdf = new PDFA5();   // [A4:210 x 297] [A5:148 x 210] [TICKET: No existe medida standar]

        $height = 4;        
        $venta = Venta::with([
            'empresa:idempresa,ruc,razonsocial,logopdf', 
            'sede:idsede,pdfcolor,direccion,pdfcabecera,departamento,provincia,distrito', 
            'ventadet:idventa,nombre,descripcion,codigo,cantidad,unidadmedida,valorunit,preciounit,total'
        ])->findOrFail($idventa);

        // Datos decabecera   
        $color = explode(",", $venta->sede->pdfcolor);

        $pdf->logo = $venta->empresa->logopdf;
        $pdf->razonsocial = $venta->empresa->razonsocial;
        $pdf->ruc = $venta->empresa->ruc;
        $pdf->direccion = $venta->sede->direccion;
        $pdf->telefono = $venta->sede->pdfcabecera;        
        $pdf->ubigeo = $venta->sede->departamento . ' - ' . $venta->sede->provincia . ' - ' . $venta->sede->distrito;
        $pdf->serienumero = $venta->serie . '-' . $venta->numero;
        $pdf->color = [$color[0], $color[1], $color[2]];
        // dd($venta->iddocumentofiscal);
        switch ($venta->clientedoc) { 
            case 1: $docIdentif = 'DNI'; break;
            case 2: $docIdentif = 'RUC'; break;
            case 3: $docIdentif = 'C.EXT.'; break;
            case 4: $docIdentif = 'PASAP.'; break;
            case 5: $docIdentif = 'SIN DOC.'; break;
            default: $docIdentif = ''; break;
        }

        switch ($venta->iddocumentofiscal) { 
            case 1: 
                $tipocomprobantesunat = '01'; 
                $pdf->comprobante = 'FACTURA';
                break; 
            case 2: 
                $tipocomprobantesunat = '03'; 
                $pdf->comprobante = 'BOLETA DE VENTA'; 
                break; 
            case 10: 
                $tipocomprobantesunat = '08'; 
                $pdf->comprobante = 'NOTA DE DÉBITO';
                break; 
            case 13: 
                $tipocomprobantesunat = '07'; 
                $pdf->comprobante = 'NOTA DE CRÉDITO';
                break;  
            default: 
                $tipocomprobantesunat = ''; 
                $pdf->comprobante = '';
                break;
        }

        $pdf->nombreFile = $venta->empresa->ruc .'-'. 
                           $tipocomprobantesunat . '-'.
                           $venta->serie . '-'.
                           $venta->numero;
        
        $pdf->SetMargins(4, 4, 4);
        $pdf->SetAutoPageBreak(true, 26); // 26 corresponde al Footer()
        $pdf->AliasNbPages(); 
        $pdf->SetFillColor($pdf->color[0], $pdf->color[1], $pdf->color[2]); // Establece el color de relleno
        $pdf->SetDrawColor($pdf->color[0], $pdf->color[1], $pdf->color[2]); // Establece el color de graficación
        $pdf->SetLineWidth(0.2); // Establece el ancho de la línea
        $pdf->AddPage('L', 'A5');


        // Cliente          
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetTextColor($pdf->color[0], $pdf->color[1], $pdf->color[2]); 
        $pdf->Cell(30, $height, utf8_decode('Señor(es):'), $pdf->borde, 0, 'L');
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetTextColor(0, 0, 0); 
        $pdf->Cell(172, $height, utf8_decode($venta->clientenombre), 'B', 0, 'L');
        $pdf->Ln(); 
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetTextColor($pdf->color[0], $pdf->color[1], $pdf->color[2]); 
        $pdf->Cell(30, $height, utf8_decode('Dirección:'), $pdf->borde, 0, 'L');
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetTextColor(0, 0, 0);  
        $pdf->Cell(172, $height, utf8_decode($venta->clientedireccion), 'B', 0, 'L');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetTextColor($pdf->color[0], $pdf->color[1], $pdf->color[2]); 
        $pdf->Cell(30, $height, utf8_decode($docIdentif) . ':', $pdf->borde, 0, 'L');
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetTextColor(0, 0, 0); 
        $pdf->Cell(64, $height, utf8_decode($venta->clientenumerodoc), 'B', 0, 'L'); 
        $pdf->Cell(5, $height, '', $pdf->borde); 
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetTextColor($pdf->color[0], $pdf->color[1], $pdf->color[2]); 
        $pdf->Cell(30, $height, utf8_decode('Moneda:'), $pdf->borde, 0, 'L');
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetTextColor(0, 0, 0); 

        switch ($venta->moneda) { 
            case 'PEN': 
                $moneda = 'SOLES'; 
                $simbolo = 'S/'; 
                break;
            case 'USD': 
                $moneda = 'DOLARES'; 
                $simbolo = '$'; 
                break;
            case 'EUR': 
                $moneda = 'EURO'; 
                $simbolo = '€'; 
                break;
            default: 
                $moneda = ''; 
                $simbolo = '';
                break;
        }
        // dd($venta->iddocumentofiscal);
        $pdf->Cell(73, $height, utf8_decode($moneda), 'B', 0, 'L');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetTextColor($pdf->color[0], $pdf->color[1], $pdf->color[2]); 
        $pdf->Cell(30, $height, utf8_decode('Fecha emisión:'), $pdf->borde, 0, 'L');
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetTextColor(0, 0, 0);
        $fechaemision = explode('-', $venta->fechaemision);  
        $pdf->Cell(64, $height, $fechaemision[2].'/'.$fechaemision[1].'/'.$fechaemision[0], 'B', 0, 'L'); 
        $pdf->Cell(5, $height, '', $pdf->borde); 

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetTextColor($pdf->color[0], $pdf->color[1], $pdf->color[2]);  
        if ($venta->iddocumentofiscal === 13) {
            $documentonc = '';
            if ($venta->documentonc === 1) {
                $documentonc = 'FACTURA';
            }

            if ($venta->documentonc === 2) {
                $documentonc = 'BOLETA DE VENTA';
            }

            $titulo = 'CPE relacionado:';
            $valor = $documentonc . ' '. $venta->serienc . '-' . $venta->numeronc;
        } else {
            $titulo = 'Fecha vencimiento:';
            $valor = '';
            if (!empty($venta->fechavencimiento)) {
                $fechavence = explode('-', $venta->fechavencimiento);                
                $valor = $fechavence[2].'/'.$fechavence[1].'/'.$fechavence[0];
            }
        } 

        $pdf->Cell(30, $height, utf8_decode($titulo), $pdf->borde, 0, 'L');
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetTextColor(0, 0, 0); 
        $pdf->Cell(73, $height, utf8_decode($valor), 'B', 0, 'L');
        $pdf->Ln(3);

        if ($venta->iddocumentofiscal === 13) { 
            switch ($venta->tiponc) { 
                case 1: $motivo = 'ANULACIÓN DE LA OPERACIÓN'; break; 
                case 2: $motivo = 'ANULACIÓN POR ERROR EN EL RUC'; break; 
                case 3: $motivo = 'CORRECCIÓN POR ERROR EN LA DESCRIPCIÓN'; break; 
                case 4: $motivo = 'DESCUENTO GLOBAL'; break; 
                case 5: $motivo = 'DESCUENTO POR ÍTEM'; break; 
                case 6: $motivo = 'DEVOLUCIÓN TOTAL'; break; 
                case 7: $motivo = 'DEVOLUCIÓN POR ÍTEM'; break; 
                case 8: $motivo = 'BONIFICACIÓN'; break; 
                case 9: $motivo = 'DISMINUCIÓN EN EL VALOR'; break;  
                default: $motivo = ''; break;
            }

            $pdf->SetFont('Arial', 'B', 8);
            $pdf->SetTextColor($pdf->color[0], $pdf->color[1], $pdf->color[2]); 
            $pdf->setX(103);
            $pdf->Cell(30, $height, utf8_decode('Motivo de emisión:'), $pdf->borde, 0, 'L');
            $pdf->SetFont('Arial', '', 8);
            $pdf->SetTextColor(0, 0, 0); 
            $pdf->Cell(73, $height, utf8_decode($motivo), 'B', 0, 'L');
            $pdf->Ln();        
        }
        
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 7.5);
        $pdf->SetTextColor(255, 255, 255); 
        $pdf->RoundedRect($pdf->getX(), $pdf->getY(), 202, 6, 1.5, '1234', 'DF');     
        $pdf->Cell(100, 6, utf8_decode('DESCRIPCIÓN'), $pdf->borde, 0, 'L');
        $pdf->Cell(17, 6, utf8_decode('CÓD.'), $pdf->borde, 0, 'C'); 
        $pdf->Cell(17, 6, utf8_decode('CANT.'), $pdf->borde, 0, 'C');
        $pdf->Cell(17, 6, utf8_decode('UM'), $pdf->borde, 0, 'C');
        $pdf->Cell(17, 6, utf8_decode('V/U'), $pdf->borde, 0, 'C');
        $pdf->Cell(17, 6, utf8_decode('P/U'), $pdf->borde, 0, 'C');         
        $pdf->Cell(17, 6, utf8_decode('IMPORTE'), $pdf->borde, 0, 'C');
        $pdf->Ln(); 


        $pdf->SetFont('Arial', '', 8);
        $pdf->SetTextColor(0, 0, 0);       
        $pdf->SetDrawColor(180, 180, 180); // Establece el color de graficación
        $background = true;
        // dd($venta->ventadet);
        $height = 5;
        foreach ($venta->ventadet as $row) { 
            if ($background) {
                $pdf->SetFillColor(255, 255, 255);
            } else {
                $pdf->SetFillColor(240, 240, 240);
            }

            $descripcion = $row->nombre;
            if (!empty($row->descripcion)) {
                $descripcion .= ' ' . $row->descripcion;
            }
            
            if ($pdf->getY() > 107) { // 107 = 148(HEIGHT) - 26(AUTOPAGEBREAK) - 15(MULTICELL)
                $pdf->AddPage('L', 'A5');                 
            }

            $y1 = $pdf->getY();
            $pdf->MultiCell(100, $height, utf8_decode($descripcion), 'B', 'L', true, 3); 
            $y2temp = $pdf->getY();
            $hcelda = $y2temp - $y1;
            $pdf->setXY(104, $y1);

            $pdf->Cell(17, $hcelda, utf8_decode($row->codigo), 'B', 0, 'C', true);
            $pdf->Cell(17, $hcelda, utf8_decode($row->cantidad), 'B', 0, 'C', true);                  
            $pdf->Cell(17, $hcelda, utf8_decode($row->unidadmedida), 'B', 0, 'C', true); 
            $pdf->Cell(17, $hcelda, number_format((float) $row->valorunit, 3, '.', ','), 'B', 0, 'R', true);
            $pdf->Cell(17, $hcelda, number_format((float) $row->preciounit, 3, '.', ','), 'B', 0, 'R', true);

            // $total = (float) $row->valorventa +  (float) $row->montototalimpuestos; // Equivalente
            $total = (float) $row->total; // Equivalente

            $pdf->Cell(17, $hcelda, number_format($total, 2, '.', ','), 'B', 0, 'R', true);   
            $pdf->Ln();
             
            $background = !$background;
        }

        // $pdf->Ln(2.5); // Ambos son equivalentes
        // $pdf->Cell(0, 2.5, '', $pdf->borde, 1, 'L'); // Ambos son equivalentes

        if ($pdf->getY() > 106) { // 107 = 148(HEIGHT) - 26(AUTOPAGEBREAK) - 16(CELL de TOTALES)
            $pdf->AddPage('L', 'A5');  
        }

        $pdf->SetFont('Arial', '', 8);
        $pdf->SetTextColor(0, 0, 0);

        $height = 4;

        if ((float) $venta->descuentototal > 0) {
            $pdf->Cell(142, $height, '', $pdf->borde);
            $pdf->Cell(30, $height, utf8_decode('DESCUENTO (-)'), $pdf->borde, 0, 'R');
            $pdf->Cell(10, $height, utf8_decode($simbolo), $pdf->borde, 0, 'R');
            $pdf->Cell(20, $height, '-' . number_format((float) $venta->descuentototal, 2, '.', ','), $pdf->borde, 0, 'R');  
            $pdf->Ln();
        }
        
        if ((float) $venta->exonerada > 0) {
            $pdf->Cell(142, $height, '', $pdf->borde);  
            $pdf->Cell(30, $height, utf8_decode('EXONERADA'), $pdf->borde, 0, 'R');
            $pdf->Cell(10, $height, utf8_decode($simbolo), $pdf->borde, 0, 'R');
            $pdf->Cell(20, $height, number_format((float) $venta->exonerada, 2, '.', ','), $pdf->borde, 0, 'R');  
            $pdf->Ln();
        }

        if ((float) $venta->inafecta > 0) {
            $pdf->Cell(142, $height, '', $pdf->borde);  
            $pdf->Cell(30, $height, utf8_decode('INAFECTA'), $pdf->borde, 0, 'R');
            $pdf->Cell(10, $height, utf8_decode($simbolo), $pdf->borde, 0, 'R');
            $pdf->Cell(20, $height, number_format((float) $venta->inafecta, 2, '.', ','), $pdf->borde, 0, 'R');  
            $pdf->Ln();
        }

        if ((float) $venta->cargo > 0) {
            $pdf->Cell(142, $height, '', $pdf->borde);  
            $pdf->Cell(30, $height, utf8_decode('OTROS CARGOS'), $pdf->borde, 0, 'R');
            $pdf->Cell(10, $height, utf8_decode($simbolo), $pdf->borde, 0, 'R');
            $pdf->Cell(20, $height, number_format((float) $venta->cargo, 2, '.', ','), $pdf->borde, 0, 'R');  
            $pdf->Ln();
        }

        if ((float) $venta->gratuita > 0) {
            $pdf->Cell(142, $height, '', $pdf->borde);  
            $pdf->Cell(30, $height, utf8_decode('GRATUITA'), $pdf->borde, 0, 'R');
            $pdf->Cell(10, $height, utf8_decode($simbolo), $pdf->borde, 0, 'R');
            $pdf->Cell(20, $height, number_format((float) $venta->gratuita, 2, '.', ','), $pdf->borde, 0, 'R');  
            $pdf->Ln();
        }

        $pdf->Cell(142, $height, '', $pdf->borde, 0, 0);               
        $pdf->Cell(30, $height, utf8_decode('GRAVADA'), $pdf->borde, 0, 'R');
        $pdf->Cell(10, $height, utf8_decode($simbolo), $pdf->borde, 0, 'R');
        $pdf->Cell(20, $height, number_format((float) $venta->gravada, 2, '.', ','), $pdf->borde, 0, 'R');
        $pdf->Ln();

        if ((float) $venta->totalimpuestobolsa > 0) {
            $pdf->Cell(142, $height, '', $pdf->borde, 0, 0);               
            $pdf->Cell(30, $height, utf8_decode('ICBPER'), $pdf->borde, 0, 'R');
            $pdf->Cell(10, $height, utf8_decode($simbolo), $pdf->borde, 0, 'R');
            $pdf->Cell(20, $height, number_format((float) $venta->totalimpuestobolsa, 2, '.', ','), $pdf->borde, 0, 'R');
            $pdf->Ln();
        }

        $pdf->Cell(142, $height, '', $pdf->borde, 0, 'R'); 
        $pdf->Cell(30, $height, utf8_decode('IGV 18.00 %'), $pdf->borde, 0, 'R'); 
        $pdf->Cell(10, $height, utf8_decode($simbolo), $pdf->borde, 0, 'R');
        $pdf->Cell(20, $height, number_format((float) $venta->valorimpuesto, 2, '.', ','), $pdf->borde, 0, 'R');  
        $pdf->Ln();

        $pdf->Cell(142, $height, '', $pdf->borde, 0, 'R');   
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(30, $height, utf8_decode('TOTAL'), $pdf->borde, 0, 'R');     
        $pdf->Cell(10, $height, utf8_decode($simbolo), $pdf->borde, 0, 'R');     
        $pdf->Cell(20, $height, number_format((float) $venta->total, 2, '.', ','), $pdf->borde, 0, 'R'); 
        $pdf->Ln(); 

        // Total en letras
        $pdf->Ln(2);

        // El "RoundedRect" no hace salto automático
        if ( ($pdf->getY() + $height) > 122) { // 122 = 148(HEIGHT) - 26(AUTOPAGEBREAK)  
            $pdf->AddPage('L', 'A5');  
        }

        $pdf->SetFillColor(255);
        $pdf->SetDrawColor($pdf->color[0], $pdf->color[1], $pdf->color[2]);  
        $pdf->RoundedRect($pdf->getX(), $pdf->getY(), 202, $height, 1.5, '1234', 'DF');        
        $pdf->SetDrawColor(180, 180, 180);  

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(50, $height, utf8_decode('IMPORTE EN LETRAS:'), $pdf->borde, 0, 'R');
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(152, $height, utf8_decode($venta->totalletra), $pdf->borde, 0, 'L');
        $pdf->Ln(); 

        if (!empty($venta->observacion) || !empty($venta->ordencompra) || !empty($venta->guiaremitente) || 
            !empty($venta->guiatransportista) || !empty($venta->placavehiculo) || !empty($venta->condicionpago) || 
            $venta->selvaproducto === '1' || $venta->selvaservicio === '1' || $venta->detraccion === '1')
        { 
            if ($pdf->getY() > 114.5) { // 114.5 = 148(HEIGHT) - 26(AUTOPAGEBREAK) - 7.5(Inf.Adicional + OBS)
                $pdf->AddPage('L', 'A5');  
            }

            $pdf->SetFont('Arial', 'B', 8); 
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->Cell(50, $height, utf8_decode('INFORMACIÓN ADICIONAL'), 'B', 0, 'C'); 
            $pdf->Ln(); 
        }
        
        $height = 3.5;
        if (!empty($venta->observacion)) { 
            $pdf->SetFont('Arial', 'B', 7.5); 
            $pdf->Cell(50, $height, utf8_decode('OBSERVACIONES'), $pdf->borde, 0, 'R');
            $pdf->SetFont('Arial', '', 7.5); 
            $pdf->Cell(152, $height, utf8_decode($venta->observacion), $pdf->borde, 0, 'L');  
            $pdf->Ln();
        }

        if (!empty($venta->ordencompra)) { 
            $pdf->SetFont('Arial', 'B', 7.5); 
            $pdf->Cell(50, $height, utf8_decode('ORDEN DE COMPRA/SERVICIO'), $pdf->borde, 0, 'R');
            $pdf->SetFont('Arial', '', 7.5); 
            $pdf->Cell(152, $height, utf8_decode($venta->ordencompra), $pdf->borde, 0, 'L');  
            $pdf->Ln();
        }

        if (!empty($venta->guiaremitente)) { 
            $pdf->SetFont('Arial', 'B', 7.5); 
            $pdf->Cell(50, $height, utf8_decode('GUÍA DE REMISIÓN REMITENTE'), $pdf->borde, 0, 'R');
            $pdf->SetFont('Arial', '', 7.5); 
            $pdf->Cell(152, $height, utf8_decode($venta->guiaremitente), $pdf->borde, 0, 'L');  
            $pdf->Ln();
        }

        if (!empty($venta->guiatransportista)) { 
            $pdf->SetFont('Arial', 'B', 7.5); 
            $pdf->Cell(50, $height, utf8_decode('GUÍA DE REMISIÓN TRANSPORTISTA'), $pdf->borde, 0, 'R');
            $pdf->SetFont('Arial', '', 7.5); 
            $pdf->Cell(152, $height, utf8_decode($venta->guiatransportista), $pdf->borde, 0, 'L'); 
            $pdf->Ln(); 
        }

        if (!empty($venta->placavehiculo)) { 
            $pdf->SetFont('Arial', 'B', 7.5); 
            $pdf->Cell(50, $height, utf8_decode('PLACA VEHICULO'), $pdf->borde, 0, 'R');
            $pdf->SetFont('Arial', '', 7.5); 
            $pdf->Cell(152, $height, utf8_decode($venta->placavehiculo), $pdf->borde, 0, 'L');  
            $pdf->Ln();
        }

        if (!empty($venta->condicionpago)) { 
            $pdf->SetFont('Arial', 'B', 7.5); 
            $pdf->Cell(50, $height, utf8_decode('CONDICIONES DE PAGO'), $pdf->borde, 0, 'R');
            $pdf->SetFont('Arial', '', 7.5); 
            $pdf->Cell(152, $height, utf8_decode($venta->condicionpago), $pdf->borde, 0, 'L');  
            $pdf->Ln();
        }

        if ($venta->selvaproducto === '1') { 
            $pdf->SetFont('Arial', 'B', 7.5); 
            $pdf->Cell(50, $height, utf8_decode('LEYENDA'), $pdf->borde, 0, 'R');
            $pdf->SetFont('Arial', '', 7.5); 
            $pdf->Cell(152, $height, utf8_decode('BIENES TRANSFERIDOS EN LA AMAZONÍA REGIÓN SELVA PARA SER CONSUMIDOS EN LA MISMA'), $pdf->borde, 0, 'L');  
            $pdf->Ln();
        }

        if ($venta->selvaservicio === '1') { 
            $pdf->SetFont('Arial', 'B', 7.5); 
            $pdf->Cell(50, $height, utf8_decode('LEYENDA'), $pdf->borde, 0, 'R');
            $pdf->SetFont('Arial', '', 7.5); 
            $pdf->Cell(152, $height, utf8_decode('SERVICIOS PRESTADOS EN LA AMAZONÍA REGIÓN SELVA PARA SER CONSUMIDOS EN LA MISMA'), $pdf->borde, 0, 'L');  
            $pdf->Ln();
        }

        if ($venta->detraccion === '1') {   
            $pdf->Cell(50, $height, utf8_decode(''), $pdf->borde, 0, 'R');
            $pdf->SetFont('Arial', 'B', 7.5); 
            $pdf->Cell(86, $height, utf8_decode('Operación sujeta al Sistema de Pago de Obligaciones Tributarias:'), $pdf->borde, 0, 'L');  
            $pdf->SetFont('Arial', '', 7.5); 
            $pdf->Cell(66, $height, utf8_decode('BANCO DE LA NACIÓN ' . $venta->cuentadetraccion), $pdf->borde, 0, 'L');  
            $pdf->Ln();
        }
 
         
        
        /*Salida*/ 
        if ($return) {
            $pdf->Output('F', 'pdf/' . $pdf->nombreFile . '.pdf');    
        
            if (file_exists($pdf->pathImg . $pdf->nombreFile . '.pdf')) 
            {
                $mensaje = array('generado' => 1, 'mensaje' => $pdf->nombreFile);
            } else 
            {
                $mensaje = array('generado' => 0, 'mensaje' => 'PDF no se genero');
            }
            
            return $mensaje;
        } else {
            $pdf->Output();    

            if (!file_exists($pdf->pathImg . $pdf->nombreFile . '.pdf')) {
                \Log::info(print_r('PDF no se genero.', true));   
            }
        }
    } 
}
