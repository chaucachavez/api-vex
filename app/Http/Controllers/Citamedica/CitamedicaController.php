<?php

namespace App\Http\Controllers\Citamedica;

use App\Models\Sede; 
use App\Models\Horario;
use App\Models\Terapia;
use App\Models\Citamedica;
use App\Models\Sedehorario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\ApiController;

class CitamedicaController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $idempresa = Config::get('constants.empresas.osi');  

        $this->fooAll($resource, $where, $orderName, $orderSort, $pageSize, new Citamedica());
              
        $betweenDate = []; 
        if (request()->filled(['fechaFrom', 'fechaTo'])) {
            $betweenDate = array(request()->input('fechaFrom'), request()->input('fechaTo')); 
        } 

        $inPaciente = request()->filled(['inPaciente']) ? request()->input('inPaciente') : NULL; 
        $inEstadoCita = request()->filled(['inEstadoCita']) ? request()->input('inEstadoCita') : NULL; 
        $inEstadoPago = request()->filled(['inEstadoPago']) ? request()->input('inEstadoPago') : NULL;
        $where['idempresa'] = $idempresa;  
        // if ($inPaciente)
        // dd( explode(',', $inPaciente) );
        // \DB::enableQueryLog();
        $query = Citamedica::with($resource)
            ->where($where)
            ->orderBy($orderName, $orderSort);            

            if ($inPaciente) 
                $query->whereIn('idpaciente', explode(',', $inPaciente));

            if ($inEstadoCita) 
                $query->whereIn('idestado', explode(',', $inEstadoCita));

            if ($inEstadoPago) 
                $query->whereIn('idestadopago', explode(',', $inEstadoPago));

            if ($betweenDate) 
                $query->whereBetween('fecha', $betweenDate);

            if ($pageSize)
                $data =  $query->paginate($pageSize);
            else
                $data = $query->get();

        // dd(\DB::getQueryLog());
        //dd($data);
        return $this->showPaginateAll($data);
    }
 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $idempresa = Config::get('constants.empresas.osi');      
        $idAuth = Config::get('constants.usuarios.andres'); 
        
        // Validaciones con BD
        // 1.- Cita con fecha vencida
        if ($request->filled('fecha') && 
            $request->filled('inicio') &&  
            $request->input('validation.fechavencida') === '0') 
        { 
            $fechahoraActual = strtotime(date('Y-m-d H:i:s'));
            $fechahoraCita = strtotime($request->fecha.' '.$request->inicio);  

            if ($fechahoraCita < $fechahoraActual) {
                return $this->errorResponse('Fecha y hora de cita vencida.', 422); 
            }
        }

        // 2.- Paciente no tenga citas pendientes y confirmadas por asistir
        if ($request->filled('idsede') && 
            $request->filled('idpaciente') &&  
            $request->input('validation.ncitaspendientes') === '0') 
        {
            $where = array(
                'idsede' => $request->idsede,
                'idpaciente' => $request->idpaciente,
            ); 

            $cita = Citamedica::where($where)
                            ->whereIn('idestado', [4, 5])
                            ->whereRaw("CONCAT(fecha,' ',inicio) > '".date('Y-m-d H:i:s')."'")
                            ->first();                             
            if ($cita) {
                return $this->errorResponse('Paciente ya tiene cita, Fecha: '.$cita->fecha.' Hora: '.$this->convertAmPm($cita->inicio), 422); 
            }
        }

        // Validaciones con Request
        $reglas = [
            'idsede' => 'required',          
            'fecha' => 'required',
            'inicio' => 'required',
            'idpaciente' => 'required',
            'idmedico' => 'required',
            'idestado' => 'required',
            'idreferencia' => 'required',
            'idatencion' =>  'required',
            'costocero' =>  'required',
            'idproductoref' =>  'required'
        ];

        $this->validate($request, $reglas);


        $campos = $request->all();

        $citamedica = new Citamedica;

        $citamedica->fill($campos);   
        
        $citamedica->idempresa = $idempresa;
        $citamedica->id_created_at = $idAuth;
        $citamedica->idtipo = $this->definirTipopaciente($citamedica->idpaciente, $citamedica->idsede);

        DB::beginTransaction(); 
        try {

            $citamedica->save();  
            $citamedica->saveLog($citamedica->idcitamedica, $idAuth);
 
        } catch (QueryException $e) {
            DB::rollback();
        }        
        DB::commit();  

        return $this->showOne($citamedica); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Citamedica  $citamedica
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $this->fooShow($resource, new Citamedica());

        $Citamedica = Citamedica::with($resource)
            ->findOrFail($id);
 
        return $this->showOne($Citamedica);
    }
 

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Citamedica  $citamedica
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Citamedica $citamedica)
    {
        
        $idempresa = Config::get('constants.empresas.osi');  
        $idAuth = Config::get('constants.usuarios.andres');          
        
        $reglas = [
            // 'idsede' => 'required',          
            // 'fecha' => 'required',
            // 'inicio' => 'required', 
            // 'idmedico' => 'required',
            // 'idestado' => 'required',
            // 'idreferencia' => 'required',
            // 'idatencion' =>  'required',
            // 'costocero' =>  'required'
        ];      

        $this->validate($request, $reglas); 

        $campos = $request->all();
        $citamedica->fill($campos);

        if (!$citamedica->isDirty())
             return $this->errorResponse('Debe especificar al menos un valor diferente para actualizar', 422);    

        DB::beginTransaction(); 
        try { 

            $citamedica->id_updated_at = $idAuth;
            $citamedica->save(); 
            $citamedica->saveLog($citamedica->idcitamedica, $idAuth);

        } catch (QueryException $e) {
            DB::rollback();
        }        
 
        DB::commit();

        return $this->showOne($citamedica); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Citamedica  $citamedica
     * @return \Illuminate\Http\Response
     */
    public function destroy(Citamedica $citamedica)
    {
        $citamedica->delete();         
        return $this->showOne($citamedica);
    }

    public function disponibilidad(Request $request, Sede $sede) 
    {             
        $idsuperperfil = 3; //Médico

        $sedehorario = Sedehorario::where('idsede', $sede->idsede)->firstOrFail(); 

        $medicos = Horario::medicosPorHorario(array(
            'horariomedico.idsede' =>$sede->idsede,
            'horariomedico.fecha' => $request->fecha,
            'perfil.idsuperperfil' => $idsuperperfil
        )); 

        $disponibilidad = array();

        foreach ($medicos as $medico) {

            $datacita = Citamedica::select(['fecha', 'inicio', 'fin', 'idpaciente'])
                ->where(array(
                    'idsede' => $sede->idsede,
                    'idmedico' => $medico->idmedico,
                    'fecha' => $request->fecha 
                ))
                ->whereIn('idestado', [4, 5, 6])
                ->get(); 
 
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

            foreach ($datacita as $row) {  
                $row->start_s = $this->fechaSegundos($row->fecha, $row->inicio);
                $row->end_s = $this->fechaSegundos($row->fecha, $row->fin);
            } 

            foreach ($datahorario as $row) {
                $row->start_s = $this->fechaSegundos($row->fecha, $row->inicio);
                $row->end_s = $this->fechaSegundos($row->fecha, $row->fin);
            } 
            
            $interconsultas = $this->configurarInterconsultas(
                $datahorario, 
                $this->horaaSegundos($sedehorario->tiempoconsultamedica), 
                $this->horaaSegundos($sedehorario->tiempointerconsulta), 
                $datacita
            );            

            $horas = $this->horasdisponibles(
                $datahorario, 
                $this->horaaSegundos($sedehorario->tiempoconsultamedica), 
                $datacita, 
                $interconsultas
            ); 

            $horasdisp = [];
            foreach ($horas as $row) { 
                $horasdisp[] = array(
                    'idmedico' => $medico->idmedico,
                    'nombre' => $medico->entidad,
                    'fecha' => $row['fecha'],
                    'inicio' => $row['inicio'],
                    'fin' => $row['fin'],

                );
            }

            $disponibilidad[] = array('idmedico' => $medico->idmedico, 'nombre' => $medico->entidad, 'horas' => $horasdisp);
        }

        return $this->showPaginateAll($disponibilidad); 
    }

    private function horasdisponibles($datahorario, $tiempoconsultamedica, $datacitas, $datainterconsultas = [], $obviar = '') {

        $horas = [];

        foreach ($datahorario as $row) { 
            $start_s = $row->start_s;
            $end_s = $row->end_s;

            while ($start_s < $end_s) {
                $horas[] = array(
                    'fecha' => $row->fecha,
                    'inicio' => date('H:i:s', $start_s),
                    'fin' => date('H:i:s', $start_s + $tiempoconsultamedica), //14 minutos
                    'start_s' => $start_s,
                    'end_s' => $start_s + $tiempoconsultamedica, //14 minutos
                    'numCitas' => 0
                );

                $start_s = $start_s + ($tiempoconsultamedica + 60); // 14min. + 1min. = 15 min.                                    
            }
        }

        if (!empty($datacitas)) {
            //dd($obviar);
            foreach ($horas as $indice => $row) {
                if (!empty($obviar) && $obviar['inicio_s'] === $row['start_s'] && $obviar['fin_s'] === $row['end_s']) {
                    //Como se trata de un rango de hora a obviar no aplica que deba ser suprimido
                } else {
                    foreach ($datacitas as $cita) {
                        if ($cita->start_s === $row['start_s'] && $cita->end_s === $row['end_s']) {
                            $borrar = true;
                            foreach ($datainterconsultas as $inter) {
                                if ($inter['start_s'] === $row['start_s'] && $inter['end_s'] === $row['end_s']) {
                                    if ($inter['numCitas'] < 2)
                                        $borrar = false;
                                    break;
                                }
                            }
                            if ($borrar)
                                unset($horas[$indice]);

                            break;
                        }
                    }
                }
            }
        }
        //dd($horas);
        return $horas;
    }

    private function definirTipopaciente($idpaciente, $idsede) {   
        //42:Continuador 43:Nuevo 44:Reingresante 

        //43 Nuevo: No tiene citas atendidas y no tiene terapias realizadas
        $where = array(
                'citamedica.idsede' => $idsede,
                'citamedica.idpaciente' => $idpaciente,
                'citamedica.idestado' => 6  //atendido
        ); 
        $datacitamedica = Citamedica::where($where)->first();

        $where = array( 
                'terapia.idsede' => $idsede,
                'terapia.idpaciente' => $idpaciente,
                'terapia.idestado' => 38 //atendido
        ); 
        $datacitaterapia = Terapia::where($where)->first();

        if(empty($datacitamedica) && empty($datacitaterapia)) {
            return 43;
        }

        //42 Continuador: Ultima terapia en los 60 días ultimos
        $where = array(
                'terapia.idsede' => $idsede,
                'terapia.idpaciente' => $idpaciente,
                'terapia.idestado' => 38 //atendido
        ); 

        $day60 = date('Y-m-d', strtotime('-60 day', strtotime(date('Y-m-j'))));

        $datacitaterapia60 = Terapia::where($where)->where('fecha', '>=' , $day60)->first();

        if(!empty($datacitaterapia60)) {
            return 42;
        }

        //44 Reingresante: Todos los demas casos
        return 44;
    }
}
