<?php

namespace App\Http\Controllers\Pdfs;

use App\Models\Sede;
use App\Models\Venta;
use App\Models\Empresa;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Codedge\Fpdf\Fpdf\Fpdf as baseFpdf;

class PDF extends baseFpdf 
{        
    public $path = 'http://apiapp.pe/img/';   
    public $borde = 0;
    public $logo;        
    public $serienumero; 
    public $razonsocial;  
    public $nombre;
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

    //variables of html parser
    protected $B;
    protected $I;
    protected $U;
    protected $HREF;
    protected $fontList;
    protected $issetfont;
    protected $issetcolor;
    // Constructor of html parser
    function __construct($orientation='P', $unit='mm', $format='A4')
    {
        //Call parent constructor
        parent::__construct($orientation,$unit,$format);
        //Initialization
        $this->B=0;
        $this->I=0;
        $this->U=0;
        $this->HREF='';
        $this->fontlist=array('arial', 'times', 'courier', 'helvetica', 'symbol');
        $this->issetfont=false;
        $this->issetcolor=false;
    }

    function WriteHTML($html)
    {
        //HTML parser
        $html=strip_tags($html,"<b><u><i><a><img><p><br><strong><em><font><tr><blockquote>"); //supprime tous les tags sauf ceux reconnus
        $html=str_replace("\n",' ',$html); //remplace retour à la ligne par un espace
        $a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE); //éclate la chaîne avec les balises
        foreach($a as $i=>$e)
        {
            if($i%2==0)
            {
                //Text
                if($this->HREF)
                    $this->PutLink($this->HREF,$e);
                else
                    $this->Write(2.5,stripslashes(txtentities($e)));
            }
            else
            {
                //Tag
                if($e[0]=='/')
                    $this->CloseTag(strtoupper(substr($e,1)));
                else
                {
                    //Extract attributes
                    $a2=explode(' ',$e);
                    $tag=strtoupper(array_shift($a2));
                    $attr=array();
                    foreach($a2 as $v)
                    {
                        if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                            $attr[strtoupper($a3[1])]=$a3[2];
                    }
                    $this->OpenTag($tag,$attr);
                }
            }
        }
    }

    function OpenTag($tag, $attr)
    {
        //Opening tag
        switch($tag){
            case 'STRONG':
                $this->SetStyle('B',true);
                break;
            case 'EM':
                $this->SetStyle('I',true);
                break;
            case 'B':
            case 'I':
            case 'U':
                $this->SetStyle($tag,true);
                break;
            case 'A':
                $this->HREF=$attr['HREF'];
                break;
            case 'IMG':
                if(isset($attr['SRC']) && (isset($attr['WIDTH']) || isset($attr['HEIGHT']))) {
                    if(!isset($attr['WIDTH']))
                        $attr['WIDTH'] = 0;
                    if(!isset($attr['HEIGHT']))
                        $attr['HEIGHT'] = 0;
                    $this->Image($attr['SRC'], $this->GetX(), $this->GetY(), px2mm($attr['WIDTH']), px2mm($attr['HEIGHT']));
                }
                break;
            case 'TR':
            case 'BLOCKQUOTE':
            case 'BR':
                $this->Ln(5);
                break;
            case 'P':
                $this->Ln(10);
                break;
            case 'FONT':
                if (isset($attr['COLOR']) && $attr['COLOR']!='') {
                    $coul=hex2dec($attr['COLOR']);
                    $this->SetTextColor($coul['R'],$coul['V'],$coul['B']);
                    $this->issetcolor=true;
                }
                if (isset($attr['FACE']) && in_array(strtolower($attr['FACE']), $this->fontlist)) {
                    $this->SetFont(strtolower($attr['FACE']));
                    $this->issetfont=true;
                }
                break;
        }
    }

    function CloseTag($tag)
    {
        //Closing tag
        if($tag=='STRONG')
            $tag='B';
        if($tag=='EM')
            $tag='I';
        if($tag=='B' || $tag=='I' || $tag=='U')
            $this->SetStyle($tag,false);
        if($tag=='A')
            $this->HREF='';
        if($tag=='FONT'){
            if ($this->issetcolor==true) {
                $this->SetTextColor(0);
            }
            if ($this->issetfont) {
                $this->SetFont('arial');
                $this->issetfont=false;
            }
        }
    }

    function SetStyle($tag, $enable)
    {
        //Modify style and select corresponding font
        $this->$tag+=($enable ? 1 : -1);
        $style='';
        foreach(array('B','I','U') as $s)
        {
            if($this->$s>0)
                $style.=$s;
        }
        $this->SetFont('',$style);
    }

    function PutLink($URL, $txt)
    {
        //Put a hyperlink
        $this->SetTextColor(0,0,255);
        $this->SetStyle('U',true);
        $this->Write(2.5,$txt,$URL);
        $this->SetStyle('U',false);
        $this->SetTextColor(0);
    }

    function Header()
    {        
        // $this->Image($this->path . $this->logo, 4, 4, 74, 0);  

        $this->SetFont('Arial', '', 8);
        $this->SetTextColor($this->color[0], $this->color[1], $this->color[2]);
        $this->SetFillColor(255, 255, 255); 
        $this->SetDrawColor($this->color[0], $this->color[1], $this->color[2]);  
        // $this->Cell(54, 5, 'Hola mundo' . $this->ruc, $this->borde, 0, 'C'); 

        $height = 7;
        $size = 13;

        // $this->RoundedRect(132, 4, 74, 28, 1.5, '1234', 'DF');

        $this->setX(132);
        $this->SetFont('Arial', 'B', 8);
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
        $this->SetFont('Arial', 'B', 8);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(74, $height, $this->serienumero, $this->borde, 0, 'C'); 


        $this->setXY(2, 2); 
        $this->SetFont('Arial', 'B', 11);
        $this->SetTextColor($this->color[0], $this->color[1], $this->color[2]);

        $this->MultiCell(54, 5, utf8_decode($this->nombre), $this->borde, 'C', false, 3); 

        $this->SetFont('Arial', 'B', 6.5);
        $this->SetTextColor($this->color[0], $this->color[1], $this->color[2]);
        $this->MultiCell(54, 2.7, utf8_decode($this->razonsocial), $this->borde, 'C', false, 3); 

        $this->SetFont('Arial', '', 5.7);
        $this->SetTextColor(0, 0, 0);

        $this->MultiCell(54, 2.7, utf8_decode($this->direccion), $this->borde, 'C', false, 3);   
        $this->MultiCell(54, 2.7, utf8_decode($this->ubigeo), $this->borde, 'C', false, 2);      
        $this->SetFont('Arial', 'B');
        $this->Cell(54, 2.7, 'RUC: ' . $this->ruc, $this->borde, 0, 'C'); 
        $this->Ln();     
        $this->SetFont('Arial', '');
        $this->MultiCell(54, 2.7, utf8_decode($this->telefono), $this->borde, 'C', false, 2);
        $this->SetFont('Arial', 'B');
        $this->Cell(54, 2.7, utf8_decode($this->comprobante) .' '. utf8_decode('ELECTRÓNICA'), $this->borde, 0, 'C'); 
        $this->Ln();     
        $this->Cell(54, 2.7, $this->serienumero, $this->borde, 0, 'C'); 
        $this->Ln();   
    }

    function Footer() 
    {   
        $height = 2.5;

        $this->Ln(1); 
        $this->SetDrawColor($this->color[0], $this->color[1], $this->color[2]);  
        $this->SetLineWidth(.2); 
        $this->Line(2, $this->GetY(), 56, $this->GetY()); 
        $this->Ln(1); 

        $this->SetFont('Arial', '', 5.7);   
        $this->MultiCell(54, $height, utf8_decode('Representación impresa de la '. $this->comprobante.' ELECTRÓNICA, para ver el documento visita:'), $this->borde, 'L', false, 3);         
        
        $this->SetFont('Arial'); 
        $this->SetTextColor($this->color[0], $this->color[1], $this->color[2]);
        $this->Cell(54, $height, utf8_decode('www.profactura.pe/comprobantes/' . $this->ruc), $this->borde, 0, 'C'); 
        $this->Ln(); 
        $this->SetFont('Arial'); 
        $this->SetTextColor(0, 0, 0); 
        $this->WriteHTML(utf8_decode('Emitido mediante un <b>Proveedor Autorizado por la SUNAT</b> mediante Resolución de Intendencia No. <b>034-005-0005315</b>'));
        $this->Ln();

        $this->setX(17);
        $this->Cell(22, 20, utf8_decode(''), $this->borde, 0, 'L'); 

        $this->setX(17);            
        $this->Image(Config::get('constants.url_qr') . $this->nombreFile . '.png', $this->getX() + 1, $this->getY(), 20, 0, 'PNG'); 
        $this->Ln(); 

        $this->SetFont('Arial', 'B'); 
        $this->SetTextColor($this->color[0], $this->color[1], $this->color[2]);        
        $this->Cell(19, $height, utf8_decode('www.profactura.pe'), $this->borde, 0, 'L'); 
        $this->SetFont('Arial');
        $this->SetTextColor(0, 0, 0);
        $this->Cell(35, $height, utf8_decode('Software de Facturación Electrónica '), $this->borde, 0, 'L');         
        $this->Ln();   
        
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

//function hex2dec
//returns an associative array (keys: R,G,B) from
//a hex html code (e.g. #3FE5AA)
function hex2dec($couleur = "#000000"){
    $R = substr($couleur, 1, 2);
    $rouge = hexdec($R);
    $V = substr($couleur, 3, 2);
    $vert = hexdec($V);
    $B = substr($couleur, 5, 2);
    $bleu = hexdec($B);
    $tbl_couleur = array();
    $tbl_couleur['R']=$rouge;
    $tbl_couleur['V']=$vert;
    $tbl_couleur['B']=$bleu;
    return $tbl_couleur;
}

//conversion pixel -> millimeter at 72 dpi
function px2mm($px){
    return $px*25.4/72;
}

function txtentities($html){
    $trans = get_html_translation_table(HTML_ENTITIES);
    $trans = array_flip($trans);
    return strtr($html, $trans);
}
////////////////////////////////////

class invoiceTICKETController extends Controller 
{        

    public function reporte($idventa, $return = false)
    { 
        $pdf = new PDF();   // [A4:210 x 297] [A5:148 x 210] [TICKET: No existe medida standar]

        $height = 2.5;
        $venta = Venta::with([
            'empresa:idempresa,ruc,razonsocial,nombre,logopdf', 
            'sede:idsede,pdfcolor,direccion,pdfcabecera,pdfnombre,departamento,provincia,distrito', 
            'ventadet:idventa,nombre,descripcion,codigo,cantidad,unidadmedida,valorunit,preciounit,total'
        ])->findOrFail($idventa);
        
        // Datos decabecera   
        $color = explode(",", $venta->sede->pdfcolor);

        $pdf->logo = $venta->empresa->logopdf;
        $pdf->razonsocial = $venta->empresa->razonsocial;

        $pdf->nombre = empty($venta->sede->imgcpe) ? $venta->sede->pdfnombre : $venta->empresa->nombre;
        // Aqui ira imagen

        $pdf->ruc = $venta->empresa->ruc;
        $pdf->direccion = $venta->sede->direccion;
        $pdf->telefono = $venta->sede->pdfcabecera;        
        $pdf->ubigeo = $venta->sede->distrito . ' - ' . $venta->sede->provincia . ' - ' . $venta->sede->departamento;
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
        
        $pdf->SetMargins(2, 2, 2);
        $pdf->SetAutoPageBreak(true, 28); // 28 corresponde al Footer()
        $pdf->AliasNbPages(); 
        $pdf->SetFillColor($pdf->color[0], $pdf->color[1], $pdf->color[2]); // Establece el color de relleno
        $pdf->SetDrawColor($pdf->color[0], $pdf->color[1], $pdf->color[2]); // Establece el color de graficación
        $pdf->SetLineWidth(0.2); // Establece el ancho de la línea
        $pdf->AddPage('P', array(58, 205)); 

        // Cliente
        $pdf->SetFont('Arial', 'B', 5.7);  
        $pdf->SetTextColor($pdf->color[0], $pdf->color[1], $pdf->color[2]);
        $pdf->Cell(54, $height, utf8_decode('CLIENTE'), $pdf->borde, 0, 'L');
        $pdf->Ln();
        $pdf->SetFont('Arial');
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(54, $height, utf8_decode($docIdentif) . ': ' .utf8_decode($venta->clientenumerodoc), $pdf->borde, 0, 'L');
        $pdf->Ln();
        $pdf->Cell(54, $height, utf8_decode($venta->clientenombre), $pdf->borde, 0, 'L');
        $pdf->Ln();
        $pdf->MultiCell(54, $height, utf8_decode($venta->clientedireccion), $pdf->borde, 'L', false, 3);

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
 
        $pdf->SetFont('Arial', 'B');
        $pdf->SetTextColor($pdf->color[0], $pdf->color[1], $pdf->color[2]); 
        $pdf->Cell(18, $height, utf8_decode('FECHA EMISIÓN:'), $pdf->borde, 0, 'L');
        $pdf->SetFont('Arial');
        $pdf->SetTextColor(0, 0, 0);
        $fechaemision = explode('-', $venta->fechaemision);  
        $pdf->Cell(36, $height, $fechaemision[2].'/'.$fechaemision[1].'/'.$fechaemision[0], $pdf->borde, 0, 'L'); 
        $pdf->Ln();

        if (!empty($venta->fechavencimiento)) {
            $pdf->SetFont('Arial', 'B');
            $pdf->SetTextColor($pdf->color[0], $pdf->color[1], $pdf->color[2]); 
            $pdf->Cell(19, $height, utf8_decode('FECHA  DE VENC:'), $pdf->borde, 0, 'L');
            $pdf->SetFont('Arial');
            $pdf->SetTextColor(0, 0, 0);
            $fechavencimiento = explode('-', $venta->fechavencimiento);  
            $pdf->Cell(35, $height, $fechavencimiento[2].'/'.$fechavencimiento[1].'/'.$fechavencimiento[0], $pdf->borde, 0, 'L'); 
            $pdf->Ln();
        }

        $pdf->SetFont('Arial', 'B');
        $pdf->SetTextColor($pdf->color[0], $pdf->color[1], $pdf->color[2]); 
        $pdf->Cell(11, $height, utf8_decode('MONEDA:'), $pdf->borde, 0, 'L');
        $pdf->SetFont('Arial');
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(43, $height, $moneda, $pdf->borde, 0, 'L');         
        $pdf->Ln();

        $pdf->SetFont('Arial', 'B');
        $pdf->SetTextColor($pdf->color[0], $pdf->color[1], $pdf->color[2]); 
        $pdf->Cell(6, $height, utf8_decode('IGV:'), $pdf->borde, 0, 'L');
        $pdf->SetFont('Arial');
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(48, $height, '18.00 %', $pdf->borde, 0, 'L');         
        $pdf->Ln();

        $pdf->SetFont('Arial', 'B', 5.7);
        $pdf->SetTextColor($pdf->color[0], $pdf->color[1], $pdf->color[2]);  
        if ($venta->iddocumentofiscal === 13) {
            $documentonc = '';

            if ($venta->documentonc === 1) {
                $documentonc = 'FACTURA';
            }

            if ($venta->documentonc === 2) {
                $documentonc = 'BOLETA DE VENTA';
            }

            $titulo = 'DOC. RELACIONADO:';
            $valor = $documentonc . ' '. $venta->serienc . '-' . $venta->numeronc;

            $pdf->SetFont('Arial', 'B');
            $pdf->SetTextColor($pdf->color[0], $pdf->color[1], $pdf->color[2]); 
            $pdf->Cell(23, $height, utf8_decode($titulo), $pdf->borde, 0, 'L');
            $pdf->SetFont('Arial');
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(31, $height, utf8_decode($valor), $pdf->borde, 0, 'L');         
            $pdf->Ln();

            $venta->tiponc = 3;
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

            $pdf->SetFont('Arial', 'B');
            $pdf->SetTextColor($pdf->color[0], $pdf->color[1], $pdf->color[2]); 
            $pdf->Cell(19, $height, utf8_decode('MOTIVO EMISIÓN:'), $pdf->borde, 0, 'L');
            $pdf->SetFont('Arial', '', 4);
            $pdf->SetTextColor(0, 0, 0); 
            $pdf->Cell(35, $height, utf8_decode($motivo), $pdf->borde, 0, 'L');
            $pdf->Ln();
        }  
        
        
        // Linea horizontal
        $pdf->Ln(1); 
        $pdf->SetDrawColor($pdf->color[0], $pdf->color[1], $pdf->color[2]);  
        $pdf->SetLineWidth(.2); 
        $pdf->Line(2, $pdf->GetY(), 56, $pdf->GetY()); 
        $pdf->Ln(1); 

        $pdf->SetFont('Arial', 'B', 5.7);
        $pdf->SetTextColor($pdf->color[0], $pdf->color[1], $pdf->color[2]);  
        $pdf->Cell(34, $height, utf8_decode('[ CANT. ]  DESCRIPCIÓN'), $pdf->borde, 0, 'L');        
        $pdf->Cell(10, $height, utf8_decode('P/U'), $pdf->borde, 0, 'R');         
        $pdf->Cell(10, $height, utf8_decode('TOTAL'), $pdf->borde, 0, 'R');
        $pdf->Ln();

        $pdf->SetFont('Arial');
        $pdf->SetTextColor(0, 0, 0);        
        $background = true;
        // dd($venta->ventadet);
        foreach ($venta->ventadet as $row) {  

            $descripcion = $row->nombre;
            if (!empty($row->descripcion)) {
                $descripcion .= ' ' . $row->descripcion;
            }

            $y1 = $pdf->getY();
            $pdf->MultiCell(34, $height, utf8_decode(
                '[ '.$row->cantidad.' ] ' .
                $row->unidadmedida . ' ' .
                $row->codigo . ' ' .
                $descripcion
            ), $pdf->borde, 'L', FALSE, 3); 
            $y2temp = $pdf->getY();
            $hcelda = $y2temp - $y1;
            $pdf->setXY(36, $y1);

            // $pdf->Cell(17, $hcelda, utf8_decode($row->codigo), 'B', 0, 'C');
            // $pdf->Cell(17, $hcelda, utf8_decode($row->cantidad), 'B', 0, 'C');                  
            // $pdf->Cell(17, $hcelda, utf8_decode($row->unidadmedida), 'B', 0, 'C'); 
            // $pdf->Cell(17, $hcelda, number_format((float) $row->valorunit, 2, '.', ','), 'B', 0, 'R');

            $pdf->Cell(10, $hcelda, number_format((float) $row->preciounit, 3, '.', ','), $pdf->borde, 0, 'R'); 
            // $total = (float) $row->valorventa +  (float) $row->montototalimpuestos; // Equivalente
            $total = (float) $row->total; // Equivalente            
            $pdf->Cell(10, $hcelda, number_format($total, 2, '.', ','), $pdf->borde, 0, 'R');   
            $pdf->Ln(); 
        } 

        // Linea horizontal
        $pdf->Ln(1); 
        $pdf->SetDrawColor($pdf->color[0], $pdf->color[1], $pdf->color[2]);  
        $pdf->SetLineWidth(.2); 
        $pdf->Line(2, $pdf->GetY(), 56, $pdf->GetY()); 
        $pdf->Ln(1); 

        $pdf->SetFont('Arial', 'B'); 
        $pdf->Cell(34, $height, utf8_decode('DESCTO. GLOBAL'), $pdf->borde, 0, 'R');
        $pdf->Cell(10, $height, utf8_decode($simbolo), $pdf->borde, 0, 'L');
        $pdf->Cell(10, $height, number_format((float) $venta->descuentoglobal, 2, '.', ','), $pdf->borde, 0, 'R');  
        $pdf->Ln();

        $pdf->Cell(34, $height, utf8_decode('GRAVADA'), $pdf->borde, 0, 'R');
        $pdf->Cell(10, $height, utf8_decode($simbolo), $pdf->borde, 0, 'L');
        $pdf->Cell(10, $height, number_format((float) $venta->gravada, 2, '.', ','), $pdf->borde, 0, 'R');
        $pdf->Ln();

        if ((float) $venta->totalimpuestobolsa > 0) {
            $pdf->Cell(34, $height, utf8_decode('ICBPER'), $pdf->borde, 0, 'R');
            $pdf->Cell(10, $height, utf8_decode($simbolo), $pdf->borde, 0, 'L');
            $pdf->Cell(10, $height, number_format((float) $venta->totalimpuestobolsa, 2, '.', ','), $pdf->borde, 0, 'R');
            $pdf->Ln();            
        }

        $pdf->Cell(34, $height, utf8_decode('IGV 18.00 %'), $pdf->borde, 0, 'R');
        $pdf->Cell(10, $height, utf8_decode($simbolo), $pdf->borde, 0, 'L');
        $pdf->Cell(10, $height, number_format((float) $venta->valorimpuesto, 2, '.', ','), $pdf->borde, 0, 'R');  
        $pdf->Ln();

        $pdf->Cell(34, $height, utf8_decode('TOTAL'), $pdf->borde, 0, 'R');
        $pdf->Cell(10, $height, utf8_decode($simbolo), $pdf->borde, 0, 'L');
        $pdf->Cell(10, $height, number_format((float) $venta->total, 2, '.', ','), $pdf->borde, 0, 'R');  
        $pdf->Ln();


        // Linea horizontal
        $pdf->Ln(1); 
        $pdf->SetDrawColor($pdf->color[0], $pdf->color[1], $pdf->color[2]);  
        $pdf->SetLineWidth(.2); 
        $pdf->Line(2, $pdf->GetY(), 56, $pdf->GetY()); 
        $pdf->Ln(1); 

        $pdf->SetFont('Arial', 'B'); 
        $pdf->Cell(6, $height, utf8_decode('SON:'), $pdf->borde, 0, 'L');
        $pdf->SetFont('Arial'); 
        $pdf->MultiCell(48, $height, utf8_decode($venta->totalletra), $pdf->borde, 'L', false); 
        $pdf->Ln(1);
         
        if (!empty($venta->observacion)) { 
            $pdf->SetFont('Arial', '');  
            $pdf->WriteHTML(utf8_decode('<b>OBSERVACIONES:</b> ' . $venta->observacion));
            $pdf->Ln();
        }

        if (!empty($venta->ordencompra)) { 
            $pdf->SetFont('Arial', '');
            $pdf->WriteHTML(utf8_decode('<b>ORDEN DE COMPRA/SERVICIO:</b> ' . $venta->ordencompra));
            $pdf->Ln();
        }

        if (!empty($venta->guiaremitente)) { 
            $pdf->SetFont('Arial', '');
            $pdf->WriteHTML(utf8_decode('<b>GUÍA DE REMISIÓN REMITENTE:</b> ' . $venta->guiaremitente));
            $pdf->Ln();
        }

        if (!empty($venta->guiatransportista)) { 
            $pdf->SetFont('Arial', '');
            $pdf->WriteHTML(utf8_decode('<b>GUÍA DE REMISIÓN TRANSPORTISTA:</b> ' . $venta->guiatransportista));
            $pdf->Ln();
        }

        if (!empty($venta->placavehiculo)) {
            $pdf->SetFont('Arial', '');
            $pdf->WriteHTML(utf8_decode('<b>PLACA VEHICULO:</b> ' . $venta->placavehiculo));
            $pdf->Ln();
        }

        if (!empty($venta->condicionpago)) { 
            $pdf->SetFont('Arial', '');
            $pdf->WriteHTML(utf8_decode('<b>CONDICIONES DE PAGO:</b> ' . $venta->condicionpago));
            $pdf->Ln();
        }

        if ($venta->selvaproducto === '1') {   
            $pdf->SetFont('Arial', '');
            $pdf->WriteHTML(utf8_decode('<b>LEYENDA:</b> BIENES TRANSFERIDOS EN LA AMAZONÍA REGIÓN SELVA PARA SER CONSUMIDOS EN LA MISMA'));
            $pdf->Ln();
        }

        if ($venta->selvaservicio === '1') { 
            $pdf->SetFont('Arial', '');
            $pdf->WriteHTML(utf8_decode('<b>LEYENDA:</b> SERVICIOS PRESTADOS EN LA AMAZONÍA REGIÓN SELVA PARA SER CONSUMIDOS EN LA MISMA'));
            $pdf->Ln();
        }

        if ($venta->detraccion === '1') {   
            $pdf->SetFont('Arial', '');
            $pdf->WriteHTML(utf8_decode('Operación sujeta al Sistema de Pago de Obligaciones Tributarias: <b>BANCO DE LA NACIÓN ' . $venta->cuentadetraccion . '</b>'));
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
