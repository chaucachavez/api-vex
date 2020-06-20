<?php

namespace App\Imports;

use App\Models\Producto;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductosImport implements ToModel, WithHeadingRow
{   
    use Importable;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */ 

    public function model(array $row)
    {   
        // dd($row);
        $codigo = null; 
        $idempresa = null;

        if ($row['nombre_de_productoobligatorio']) {
            $idempresa = auth()->user()->idempresa; // 1;
        } 

        // if (!isset($row[0])) {
        //     return null;
        // }

        
        return new Producto([
            'idempresa' => $idempresa,
            'codigo' => $row['codigo_deproductoobligatorio'], //substr(Str::random(), 0, 7), //
            'unidadmedida' => $row['unidad_de_medidaobligatorio'],            
            'nombre' => $row['nombre_de_productoobligatorio'], 
            'moneda' => $row['monedaobligatorio'],
            'valorcompra' => $row['precio_compra_con_igv'],
            'valorventa' => $row['precio_venta_con_igvobligatorio'],
            'idimpuesto' => $row['impuesto_obligatorio'],
            'codigosunat' => $row['codigo_de_producto_sunat'],
            'destacado' => ($row['destacado'] === 'SI' or $row['destacado'] === 'si') ? '1' : '0'
            // 'unidadmedida' => $row[2],            
            // 'nombre' => $row[1], 
            // 'moneda' => $row[3],
            // 'valorcompra' => $row[4],
            // 'valorventa' => $row[5],
            // 'idimpuesto' => $row[7],
            // 'codigosunat' => $row[10],
            // 'destacado' => $row[6]
        ]); 
    }

    public function headingRow(): int
    {
        return 2;
    }
}
