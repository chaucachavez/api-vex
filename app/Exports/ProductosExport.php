<?php

namespace App\Exports;

use App\Models\Producto;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class ProductosExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStrictNullComparison  
{	
	use Exportable;  

    protected $productos;

    public function __construct($products = null)
    {
        $this->productos = $products;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return Producto::all();
        return $this->productos ?: Producto::all();
    }

    public function headings(): array
    {

        return [ 
        	'CODIGO',
        	'NOMBRE', 
            'UNIDAD DE MEDIDA',
            'MONEDA',
            'PRECIO COMPRA (CON IGV)', 
            'PRECIO VENTA (CON IGV)',
            'DESTACADO',
            'TIPO DE AFECTACIÓN (IGV)',             
            'NOMBRE DE CATEGORIA',     
            'CODIGO SUNAT', 
            'STOCK ACTUAL'
        ];
    }

    public function map($model): array
    { 
        // dd($model);
    	$impuesto = '';
    	switch ($model->idimpuesto) {
			case 1: $impuesto = 'Gravado - Operación Onerosa'; break;
	        case 2: $impuesto = '[Gratuita] Gravado – Retiro por premio'; break;
	        case 3: $impuesto = '[Gratuita] Gravado – Retiro por donación'; break;
	        case 4: $impuesto = '[Gratuita] Gravado – Retiro'; break;
	        case 5: $impuesto = '[Gratuita] Gravado – Retiro por publicidad'; break;
	        case 6: $impuesto = '[Gratuita] Gravado – Bonificaciones'; break;
	        case 7: $impuesto = '[Gratuita] Gravado – Retiro por entrega a trabajadores'; break;
	        case 8: $impuesto = 'Exonerado - Operación Onerosa'; break;
	        case 9: $impuesto = 'Inafecto - Operación Onerosa'; break;
	        case 10: $impuesto = '[Gratuita] Inafecto – Retiro por Bonificación'; break;
	        case 11: $impuesto = '[Gratuita] Inafecto – Retiro'; break;
	        case 12: $impuesto = '[Gratuita] Inafecto – Retiro por Muestras Médicas'; break;
	        case 13: $impuesto = '[Gratuita] Inafecto - Retiro por Convenio Colectivo'; break;
	        case 14: $impuesto = '[Gratuita] Inafecto – Retiro por premio'; break;
	        case 15: $impuesto = '[Gratuita] Inafecto - Retiro por publicidad'; break;
	        case 16: $impuesto = 'Exportación'; break;
    	} 

        return [
            // Date::dateTimeToExcel($model->fechaemision), 
            $model->codigo,
	    	$model->nombre,
	    	$model->unidadmedida,
	    	$model->moneda,
	    	$model->valorcompra,
	    	$model->valorventa,
	    	$model->destacado === '1' ? 'SI' : 'NO',
	    	$impuesto,
	    	$model->categoria ? $model->categoria->nombre : '', 
	    	$model->codigosunat,
	    	$model->stock	    	
        ];
    }
}
