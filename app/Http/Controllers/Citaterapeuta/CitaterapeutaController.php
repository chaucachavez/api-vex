<?php

namespace App\Http\Controllers\Citaterapeuta;

use App\Models\Sede;
use App\Models\Empresa;
use App\Models\Horario;
use App\Models\Diabloqueo;
use App\Models\Diaferiado;
use App\Models\Sedehorario;
use App\Models\Turnoterapia;
use Illuminate\Http\Request;
use App\Models\Citaterapeuta;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\ApiController;

class CitaterapeutaController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->fooAll($resource, $where, $orderName, $orderSort, $pageSize, new Citaterapeuta());
              
        $betweenDate = []; 
        if (request()->filled(['fechaFrom', 'fechaTo'])) {
            $betweenDate = array(request()->input('fechaFrom'), request()->input('fechaTo')); 
        } 

        //\DB::enableQueryLog();
        $query = Citaterapeuta::with($resource)
            ->where($where)
            ->orderBy($orderName, $orderSort);            

            if ($betweenDate) 
                $query->whereBetween('fecha', $betweenDate);

            if ($pageSize)
                $data =  $query->paginate($pageSize);
            else
                $data = $query->get();

        //dd(\DB::getQueryLog());
        //dd($data);
        return $this->showPaginateAll($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Citaterapeuta  $citaterapeuta
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->fooShow($resource, new Citaterapeuta());

        $Citaterapeuta = Citaterapeuta::with($resource)
            ->findOrFail($id);
 
        return $this->showOne($Citaterapeuta);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Citaterapeuta  $citaterapeuta
     * @return \Illuminate\Http\Response
     */
    public function edit(Citaterapeuta $citaterapeuta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Citaterapeuta  $citaterapeuta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Citaterapeuta $citaterapeuta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Citaterapeuta  $citaterapeuta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Citaterapeuta $citaterapeuta)
    {
        //
    }

    public function disponibilidad(Request $request, Sede $sede) 
    {   
        $idempresa = Config::get('constants.empresas.osi');  
        $idsuperperfil = 4;

        $Empresa = Citaterapeuta::findOrFail($idempresa);
        $Sedehorario = Sedehorario::where('idsede', $sede->idsede)->firstOrFail(); 

        $where = array(
            'idsede' => $sede->idsede, 
            'dia' => date('N', $this->fechaSegundos($request->fecha, '00:00:00'))
        );

        $turnos = Turnoterapia::where($where)->get();

        foreach ($turnos as $row) { 
            $row->start_s = $this->fechaSegundos($request->fecha, $row->inicio);
            $row->end_s = $this->fechaSegundos($request->fecha, $row->fin);
        }  

        $medicos = Horario::medicosPorHorario(array(
            'horariomedico.idsede' =>$sede->idsede,
            'horariomedico.fecha' => $request->fecha,
            'perfil.idsuperperfil' => $idsuperperfil
        )); 

        $nroagenda = null;

        if ($request->filled('idaseguradora')) { 
            $nroagenda = $this->nroAgendamiento($request->idaseguradora);
        }

        $datacita = Citaterapeuta::select('*')
                ->where(array(
                    'idsede' => $sede->idsede, 
                    'fecha' => $request->fecha 
                ))
                ->whereIn('idestado', [32, 33, 34])
                ->get(); 

        $cuposTurno = [];

        foreach ($datacita as $row) {  

            $row->start_s = $this->fechaSegundos($row->fecha, $row->inicio);
            $row->end_s = $this->fechaSegundos($row->fecha, $row->fin);

            if($nroagenda && $row->idaseguradora === $nroagenda->idaseguradora) {

                if(!isset($cuposTurno[$row->start_s . '-' .$row->end_s]['cantidad'])) {
                    $cuposTurno[$row->start_s . '-' .$row->end_s]['cantidad'] = 0;    
                }

                $cuposTurno[$row->start_s . '-' .$row->end_s]['idaseguradora'] = $row->idaseguradora;
                $cuposTurno[$row->start_s . '-' .$row->end_s]['turno'] = array($row->fecha, $row->inicio, $row->fin);
                $cuposTurno[$row->start_s . '-' .$row->end_s]['cantidad'] += 1;
            }
        }
 
        if ($nroagenda && $request->filled('idaseguradora')) { 
            foreach ($cuposTurno as $index => $row) {
                $cuposTurno[$index]['disponible'] = true;
                //$nroagenda->nroagenda: NULL ilimitado
                if ( isset($nroagenda->nroagenda) && $row['cantidad'] >= $nroagenda->nroagenda ) {
                    $cuposTurno[$index]['disponible'] = false;
                }
            } 
        }

        $dataBloqueo = Diabloqueo::where(array('idsede' => $sede->idsede))->get();
        foreach ($dataBloqueo as $row) { 
            $row->start_s = $this->fechaSegundos($row->fecha, $row->inicio); 
            $row->end_s = $this->fechaSegundos($row->fecha, $row->fin);
        }

        $dataFeriado = Diaferiado::where(array('idempresa' => $idempresa))->get();
        foreach ($dataFeriado as $row) { 
            $row->start_s = $this->fechaSegundos($row->fecha, $Empresa->laborinicio); 
            $row->end_s = $this->fechaSegundos($row->fecha, $Empresa->laborfin);
        }
        
        $disponibilidad = array();

        foreach ($medicos as $medico) {      

            $datahorario = Horario::select('horariomedico.*')
                ->join('entidad', 'horariomedico.idmedico', '=', 'entidad.identidad')
                ->join('entidadperfil', 'entidad.identidad', '=', 'entidadperfil.identidad')
                ->join('perfil', 'entidadperfil.idperfil', '=', 'perfil.idperfil')
                ->where(array( 
                    'horariomedico.idsede' => $sede->idsede,
                    'horariomedico.idmedico' => $medico->idmedico,
                    'horariomedico.fecha' => $request->fecha,
                    'perfil.idsuperperfil' => $idsuperperfil,
                )) 
                ->get();  

            foreach ($datahorario as $row) { 
                $row->start_s = $this->fechaSegundos($row->fecha, $row->inicio);
                $row->end_s = $this->fechaSegundos($row->fecha, $row->fin);
            } 
            
            $obviar = NULL;
            if ($request->filled('inicio') && $request->filled('fin')) {
                $obviar = array(
                    'inicio_s' => $this->fechaSegundos($request->fecha, $request->inicio),
                    'fin_s' => $this->fechaSegundos($request->fecha, $request->fin)
                );
            }
            
            $maxcamilla = array(
                'identidad' => $medico->idmedico,                
                'maxcamilla' => $medico->maxcamilla,
                'cantidadcamilla' => $Sedehorario->cantidadcamilla
            );

            // dd($datahorario, $this->horaaSegundos($Sedehorario->intervaloterapia), $datacita, $obviar, $turnos, $maxcamilla);

            $horas = $this->horasdisponibles($datahorario, $this->horaaSegundos($Sedehorario->intervaloterapia), $datacita, $obviar, $turnos, $maxcamilla);  

            $horasdisp = [];
          
            foreach ($horas as $row) { 
                if (
                    $this->existeCupo($row['inicio'], $row['fin'], $cuposTurno) &&
                    !$this->estaBloqueado($row['start_s'], $row['end_s'], $dataBloqueo) && 
                    !$this->validarFeriado($dataFeriado, $row['start_s'], $row['end_s']) 
                ) { 
                    $horasdisp[] = array(
                        'idmedico' => $medico->idmedico,
                        'nombre' => $medico->entidad,
                        'inicio' => $row['inicio'],
                        'fin' => $row['fin'],
                    );
                }                
            }
             
            $disponibilidad[] = array(
                'idmedico' => $medico->idmedico, 
                'nombre' => $medico->entidad, 
                'horas' => $horasdisp
            );
        }
 
        $filtrar = [];
        foreach ($disponibilidad as $value) {
            if ($value['horas']) {
                $filtrar[] = $value;
            }
        } 

        return $this->showPaginateAll($filtrar); 
    }

    private function nroAgendamiento($idaseguradora) {
 
        $idempresa = Config::get('constants.empresas.osi');  

        $seguros =  Seguro::where('idempresa', $idempresa)->get();  

        $nroagenda = null;

        foreach ($seguros as $row) { 
            if($idaseguradora === $row->idaseguradora) {
                $nroagenda = $row;
                break;
            }
        }

        return $nroagenda;
    }

    private function existeCupo($inicio, $fin, $cuposTurno) {

        $disponible = true;
        foreach($cuposTurno as $row) {
            if ($inicio === $row['turno'][1] && $fin === $row['turno'][2]) {
                $disponible = $row['disponible'];
                break;
            }
        }
 
        return $disponible;
    }

    private function estaBloqueado($inicio, $fin, $horasbloqueo) {
        $bloqueado = false;
        foreach($horasbloqueo as $row) { 
            if (($row->start_s >= $inicio && $row->start_s <= $fin) || ($row->end_s >= $inicio && $row->end_s <= $fin) || ($row->start_s < $inicio && $row->end_s > $fin)) {
                $bloqueado = true;
                break;
            }
        }
 
        return $bloqueado;
    }

    private function horasdisponibles($datahorario, $tiempoconsultamedica, $datacitas, $obviar = '', $turnos = [], $maxcamilla = []) {

        $horas = [];
         
        if(empty($turnos)){
            foreach ($datahorario as $row) {
                $start_s = $row->start_s;
                $end_s = $row->end_s;

                while ($start_s < $end_s) {
                    $horas[] = array(
                        'inicio' => date('H:i:s', $start_s),
                        'fin' => date('H:i:s', $start_s + $tiempoconsultamedica), //14 minutos
                        'start_s' => $start_s,
                        'end_s' => $start_s + $tiempoconsultamedica, //14 minutos
                        'numCitas' => 0
                    );

                    $start_s = $start_s + ($tiempoconsultamedica + 60); // 14min. + 1min. = 15 min.                                    
                }
            }
        }else{ 
            foreach ($turnos as $row) {                
                $valido = false; 
                foreach ($datahorario as $horario) {
                    if($row->start_s >= $horario->start_s && $row->end_s <= $horario->end_s){
                        $valido = true;
                        break;
                    }
                }
                if($valido){
                    unset($row->idsede);
                    unset($row->dia);
                    $row->numCitas = 0; 
                    $horas[] = $row->toArray(); 
                }
            }
        }
        
        if (!empty($datacitas)) {
            
            foreach ($horas as $indice => $row) {
                
                if (!empty($obviar) && $obviar['inicio_s'] === $row['start_s'] && $obviar['fin_s'] === $row['end_s']) {
                    //Como se trata de un rango de hora a obviar no aplica que deba ser suprimido
                } else { 
                    $cantcitas = 0;
                    $cantcitasTerapista = 0;
                    foreach ($datacitas as $cita) {
                        
                        if ($cita->start_s === $row['start_s'] && $cita->end_s === $row['end_s'])                            
                            $cantcitas = $cantcitas + 1;        
                        
                        if ($cita->start_s === $row['start_s'] && $cita->end_s === $row['end_s'] && $cita->idterapista === (int)$maxcamilla['identidad'])                             
                            $cantcitasTerapista = $cantcitasTerapista + 1;                        
                    }
                    
                    if((int)$maxcamilla['cantidadcamilla'] <= $cantcitas || (int)$maxcamilla['maxcamilla'] <= $cantcitasTerapista){  
                       unset($horas[$indice]);
                    }                    
                }
            }
        }
        
        return $horas;
    }


}
