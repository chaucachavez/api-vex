<?php

namespace App\Http\Controllers\Categoria;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ApiController;

class CategoriaTratamientoController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Categoria $categoria)
    {
        DB::enableQueryLog(); 
        $tratamientos = $categoria->productos()
            ->whereHas('tratamientos')
            //->with('tratamientos.personal', 'tratamientos.producto')
            ->with('tratamientos')
            ->get()
            ->pluck('tratamientos')
            ->collapse();

        //dd(\DB::getQueryLog());
        return $this->showAll($tratamientos);
    }

}
