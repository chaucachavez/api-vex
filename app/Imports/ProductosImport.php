<?php

namespace App\Imports;

use App\Models\Producto;
use App\Models\Categoria;
use Maatwebsite\Excel\Row;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Validators\ValidationException;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;

class ProductosImport implements OnEachRow,  WithHeadingRow, WithMultipleSheets, WithEvents
{   
    use Importable, RegistersEventListeners;
    
    // https://github.com/Maatwebsite/Laravel-Excel/issues/1889 By"abbylovesdon" and "patrickbrouwers"
    public static function beforeImport(BeforeImport $event)
    {    
        $worksheet = $event->reader->getActiveSheet();
        $highestRow = $worksheet->getHighestRow(); // Fila mas alta 
        if ($highestRow < 3) { 
            $error = \Illuminate\Validation\ValidationException::withMessages([]);
            $failure = new Failure(1, 'rows', [0 => 'No hay información para fila "'. 3 .'" en archivo.']);
            $failures = [0 => $failure];
            throw new ValidationException($error, $failures);
        }
    }

    public function onRow(Row $row)
    {   

        $index = $row->getIndex();
        $row = $row->toArray();     

        Validator::make($row, [
             'codigo_deproductoobligatorio' => 'required',
             'nombre_de_productoobligatorio' => 'required'
         ])->validate();

        $idcategoria = null;

        if ($row['nombre_de_categoria']) {
            $categoria = Categoria::firstOrCreate([
                'nombre' => $row['nombre_de_categoria'],
            ], [ 
                'idempresa' => auth()->user()->idempresa,
                'id_created_at' => auth()->user()->id
            ]); 

            $idcategoria = $categoria->id;
        }  

        Producto::create([ 
            'idempresa' => auth()->user()->idempresa,
            'codigo' => $row['codigo_deproductoobligatorio'],  
            'nombre' => $row['nombre_de_productoobligatorio'], 
            'unidadmedida' => $row['unidad_de_medidaobligatorio'],                        
            'moneda' => $row['monedaobligatorio'],
            'valorcompra' => $row['precio_compra_con_igv'],
            'valorventa' => $row['precio_venta_con_igvobligatorio'],
            'idimpuesto' => $row['impuesto_obligatorio'] === 'IGV' ? 8 : 1,
            'codigosunat' => $row['codigo_de_producto_sunat'],
            'destacado' => ($row['destacado'] === 'SI' or $row['destacado'] === 'si') ? '1' : '0',
            'idcategoria' => $idcategoria
        ]); 
    }
   
    public function headingRow(): int
    {
        return 2;
    } 

    public function sheets(): array
    {
        return [ 
            0 => new ProductosImport(), // Select by sheet index
        ];
    }
}
