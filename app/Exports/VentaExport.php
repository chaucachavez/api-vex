<?php

namespace App\Exports;
 
use App\Models\Venta; 
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class VentaExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings, WithColumnFormatting
{
	use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    */ 

    public function collection()
    {
    	// \DB::enableQueryLog();  
        $valores = Venta::with([
        	'sede:idsede,nombre', 
        	'docnegocio:iddocumentofiscal,nombre', 
        	'cliente:identidad,entidad,iddocumento,numerodoc',
        	'cliente.documento:iddocumento,nombre,abreviatura',
        	'afiliado:identidad,acronimo',
        	'creacion:identidad,entidad'
        ])->whereBetween('fechaemision', $this->betweenDate)->get();
        // dd(\DB::getQueryLog());
        // dd($valores);        
        return $valores;
    }

    public function __construct(array $betweenDate)
    {
        $this->betweenDate = $betweenDate;
    } 

    public function map($model): array
    {
    	
    	$estadopago = '';
    	switch ($model->idestadodocumento) {
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

        return [
            $model->sede->nombre,
            $model->docnegocio->nombre,
            $model->afiliado->acronimo,
            $model->serie,
            $model->numero,
            $model->fechaemision,
            // Date::dateTimeToExcel($model->fechaemision),
            $model->cliente->entidad,
            $model->cliente->documento->abreviatura,
            $model->cliente->numerodoc,
            $estadopago,
            $model->idmediopago, 
            $model->total, 
            $model->creacion->entidad,
        ];
    }

    public function headings(): array
    {

        return [
            'SEDE',
            'COMPROBANTE',
            'AFILIADO',
            'SERIE',
            'NUMERO',
            'F.EMISIÓN', 
            'CLIENTE',
            'CLIENTE DOCUMENTO',
            'IDENTIFICACION',
            'ESTADO',
            'M.PAGO', 
            'TOTAL',
            'CREACIÓN'
        ];
    }

    /**
     * @return array
     */
    public function columnFormats(): array
    {
        return [
            // 'F.EMISIÓN' => NumberFormat::FORMAT_DATE_DDMMYYYY 
        ];
    }
}
