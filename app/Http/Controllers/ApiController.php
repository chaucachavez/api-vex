<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ApiController extends Controller
{
    use ApiResponser;

    public function __construct()
    {
    	//Enviamos el Guard "api" que vamos a utilizar
    	//$this->middleware('auth:api');
    }

    public function fooAll(&$resource, &$where, &$orderName, &$orderSort, &$pageSize, $model) 
    {
        
        $resource = [];
        if (request()->filled('conRecurso') && method_exists($model, 'recursos')) { 
            $recursos = $model::recursos();
 
            foreach(explode(',', request()->input('conRecurso')) as $val) {
                $val = trim($val); 

                if($val && !in_array($val, $recursos)) { 
                    throw new HttpException(422, "El recurso {$val} especificado en la petición no es válido");
                }
                
                if($val) {
                    $resource[] = $val;
                }
            }
        }   

        //$fillable = $model->getFillable();
        $fillable = $model->filterWhere;
        $rules = [
            'conRecurso' => 'string',            
            'pageSize' => 'integer|min:2|max:50',
            'orderName' => 'in:' . implode(',', $fillable), 
            'orderSort' => 'in:asc,desc',            
        ];  
        
        if (method_exists($model, 'whereRango')) { 
            foreach($model::whereRango() as $val) {
                $rules[$val] = 'date';
            } 
        } 
      
        Validator::validate(request()->all(), $rules);
          
        $where = request()->only($fillable);  
        $pageSize = request()->input('pageSize');    
        
        $orderName = request()->input('orderName', $model->getKeyName());    
        $orderSort = request()->input('orderSort', 'desc');     
    }

    public function fooShow(&$resource, $model) 
    {  
        $resource = [];  
        if (request()->filled('conRecurso')) { 
            $recursos = $model::recursos();

            foreach(explode(',', request()->input('conRecurso')) as $val) {
                $val = trim($val); 

                if($val && !in_array($val, $recursos)) { 
                    throw new HttpException(422, "El recurso {$val} especificado en la peticición no es válido");        
                }

                if($val) {
                    $resource[] = $val;
                }
            }
        }   

        $rules = [
            'conRecurso' => 'string'         
        ];   

        Validator::validate(request()->all(), $rules); 
    }

    function fechaInicioFin($fecha, $horainicio, $horafin) {
        //2018-07-04
        //17:25:00
        // dd($fecha, $horainicio, $horafin);
        $d = substr($fecha, 8, 2);
        $m = substr($fecha, 5, 2);
        $y = substr($fecha, 0, 4);

        $Hi = substr($horainicio, 0, 2);
        $Mi = substr($horainicio, 3, 2);

        $Hf = substr($horafin, 0, 2);
        $Mf = substr($horafin, 3, 2);

        return [
            'd' => $d, 'm' => $m, 'y' => $y,
            'Hi' => $Hi, 'Mi' => $Mi,
            'Hf' => $Hf, 'Mf' => $Mf
        ];
    }

    function fechaSegundos($fecha, $hora) {
        //2018-07-04
        //17:25:00  
        $d = (int) substr($fecha, 8, 2);
        $m = (int) substr($fecha, 5, 2);
        $y = (int) substr($fecha, 0, 4);

        $Hi = (int) substr($hora, 0, 2);
        $Mi = (int) substr($hora, 3, 2);  
        return mktime($Hi, $Mi, 0, $m, $d, $y);
    }

    public function configurarInterconsultas($datahorario, $tiempoconsultamedica, $tiempointerconsulta, $datacitas = [], $idpaciente = '') {
        /* 1800 recomiendo quitar hace que la primera consulta comienze despues de 1/2 'en duro' y para las demas entrecitas 1 hora que es configurado 'en sede'.
         * 
         */
        $interconsultas = [];

        foreach ($datahorario as $row) {
            //$start_s = $row->start_s + 1800; // 30 minutos
            $start_s = $row->start_s;
            $end_s = $row->end_s;

            $turnosvalidos = [0,1,0,0,0,1,0,0,0,1,0,0,0,1,0,0,1,0,0,1,0,0,1,0,0,1,0,0,1,0,0,1,0,0]; //AMAC 13.06.2018;
            $i = 0;
            while ($start_s < $end_s) {

                if ($turnosvalidos[$i] === 1) {
                    $interconsultas[] = array(
                        //inicio y fin; no se usa.
                        'inicio' => date('d/m/Y H:i:s', $start_s),
                        'fin' => date('d/m/Y H:i:s', $start_s + $tiempoconsultamedica), //14 minutos
                        'start_s' => $start_s,
                        'end_s' => $start_s + $tiempoconsultamedica, //14 minutos
                        'numCitas' => 0,
                        'idsede' => $row->idsede, //23.09.2016
                        'idhorariomedico' => $row->idhorariomedico, //23.09.2016
                        'zindextemp' => $i
                    );
                }

                $i++; 
                $start_s = $start_s + $tiempointerconsulta; // 1hora                                    
            }
        }

        if (!empty($datacitas)) {
            foreach ($interconsultas as $indice => $row) {
                $numCitas = 0;
                foreach ($datacitas as $cita) {
                    if ($cita->start_s === $row['start_s'] && $cita->end_s === $row['end_s']) {
                        if (!empty($idpaciente)) {
                            if ($idpaciente !== $cita->idpaciente) {
                                $numCitas = $numCitas + 1;
                            }
                        } else {
                            $numCitas = $numCitas + 1;
                        }
                    }
                }
                $interconsultas[$indice]['numCitas'] = $numCitas;
            }
        }

        return $interconsultas;
    }

    public function horaaSegundos($hora) {
        //$hora = "09:24:38";
        list($horas, $minutos, $segundos) = explode(':', $hora);
        $hora_en_segundos = ($horas * 3600 ) + ($minutos * 60 ) + $segundos;
        return $hora_en_segundos;
    }
    
    public function validarFeriado($data, $inicio, $fin, $idpaciente = '') {
        //start_s: Tiempo en segundos
        //end_s: Tiempo en segundos       
        $inValid = false;

        foreach ($data as $row) {

            $row = is_object($row) ? $row->toArray() : $row;

            //if(($row->start_s >= $inicio && $row->start_s <= $fin) || ($row->end_s >= $inicio && $row->end_s <= $fin) || ($row->start_s < $inicio && $row->end_s > $fin)){
            if (($row['start_s'] >= $inicio && $row['start_s'] <= $fin) || ($row['end_s'] >= $inicio && $row['end_s'] <= $fin) || ($row['start_s'] < $inicio && $row['end_s'] > $fin)) {
                if (!empty($idpaciente)) {
                    //if( $idpaciente !== $row->idpaciente ){
                    if ($idpaciente !== $row['idpaciente']) {
                        $inValid = true;
                        break;
                    }
                } else {
                    $inValid = true;
                    break;
                }
            }
        }

        return $inValid;
    }

    public function convertAmPm($hour) {   
        $newDateTime = null;
        if(isset($hour) && !empty($hour)){
            $currentDateTime = date('Y-m-d').' '.$hour;
            $newDateTime = date('h:i A', strtotime($currentDateTime));
        }
        return $newDateTime;
    }
    
    public function num2letras($num, $fem = false, $dec = true) { //$num = 43.52;
        $matuni[2]  = "dos"; 
        $matuni[3]  = "tres"; 
        $matuni[4]  = "cuatro"; 
        $matuni[5]  = "cinco"; 
        $matuni[6]  = "seis"; 
        $matuni[7]  = "siete"; 
        $matuni[8]  = "ocho"; 
        $matuni[9]  = "nueve"; 
        $matuni[10] = "diez"; 
        $matuni[11] = "once"; 
        $matuni[12] = "doce"; 
        $matuni[13] = "trece"; 
        $matuni[14] = "catorce"; 
        $matuni[15] = "quince"; 
        $matuni[16] = "dieciseis"; 
        $matuni[17] = "diecisiete"; 
        $matuni[18] = "dieciocho"; 
        $matuni[19] = "diecinueve"; 
        $matuni[20] = "veinte"; 
        $matunisub[2] = "dos"; 
        $matunisub[3] = "tres"; 
        $matunisub[4] = "cuatro"; 
        $matunisub[5] = "quin"; 
        $matunisub[6] = "seis"; 
        $matunisub[7] = "sete"; 
        $matunisub[8] = "ocho"; 
        $matunisub[9] = "nove"; 

        $matdec[2] = "veint"; 
        $matdec[3] = "treinta"; 
        $matdec[4] = "cuarenta"; 
        $matdec[5] = "cincuenta"; 
        $matdec[6] = "sesenta"; 
        $matdec[7] = "setenta"; 
        $matdec[8] = "ochenta"; 
        $matdec[9] = "noventa"; 
        $matsub[3]  = 'mill'; 
        $matsub[5]  = 'bill'; 
        $matsub[7]  = 'mill'; 
        $matsub[9]  = 'trill'; 
        $matsub[11] = 'mill'; 
        $matsub[13] = 'bill'; 
        $matsub[15] = 'mill'; 
        $matmil[4]  = 'millones'; 
        $matmil[6]  = 'billones'; 
        $matmil[7]  = 'de billones'; 
        $matmil[8]  = 'millones de billones'; 
        $matmil[10] = 'trillones'; 
        $matmil[11] = 'de trillones'; 
        $matmil[12] = 'millones de trillones'; 
        $matmil[13] = 'de trillones'; 
        $matmil[14] = 'billones de trillones'; 
        $matmil[15] = 'de billones de trillones'; 
        $matmil[16] = 'millones de billones de trillones'; 
        // \Log::info(print_r($num, true));
        // \Log::info(print_r(gettype($num), true));
        //Zi hack 
        $float=explode('.',$num);
        $num = $float[0];

        $num = trim((string)@$num); 
        if ($num[0] == '-') { 
            $neg = 'menos '; 
            $num = substr($num, 1); 
        }else 
            $neg = ''; 

        // while ($num[0] == '0') { 
        //     \Log::info(print_r('=>'. $num, true));
        //     $num = substr($num, 1); 
        //     \Log::info(print_r('->'. $num, true));
        // }
            
        if ($num[0] < '1' or $num[0] > 9) {
            $num = '0' . $num; 
        }

        $zeros = true; 
        $punt = false; 
        $ent = ''; 
        $fra = ''; 
        for ($c = 0; $c < strlen($num); $c++) { 
            $n = $num[$c]; 
            if (! (strpos(".,'''", $n) === false)) { 
                if ($punt) break; 
                else{ 
                    $punt = true; 
                    continue; 
                } 

            }elseif (! (strpos('0123456789', $n) === false)) { 
                if ($punt) { 
                    if ($n != '0') $zeros = false; 
                    $fra .= $n; 
                }else 

                    $ent .= $n; 
            }else 

                break; 

        } 
        $ent = '     ' . $ent; 
        if ($dec and $fra and ! $zeros) { 
            $fin = ' coma'; 
            for ($n = 0; $n < strlen($fra); $n++) { 
                if (($s = $fra[$n]) == '0') 
                    $fin .= ' cero'; 
                elseif ($s == '1') 
                    $fin .= $fem ? ' una' : ' un'; 
                else 
                    $fin .= ' ' . $matuni[$s]; 
            } 
        }else 
            $fin = ''; 

        if ((int)$ent === 0) {
            // return 'Cero ' . $fin; 22.12.2019
            $tex = 'Cero';
            $con = '';
            if(isset($float[1])) {
                $con = ' CON '.$float[1].'/100 SOLES';
            } else {
                //10.11.2018
                $con = ' CON 00/100 SOLES';
            }

            $end_num= mb_strtoupper($tex).$con;
            return $end_num; 
        }

        $tex = ''; 
        $sub = 0; 
        $mils = 0; 
        $neutro = false; 
        while ( ($num = substr($ent, -3)) != '   ') { 
            $ent = substr($ent, 0, -3); 
            if (++$sub < 3 and $fem) { 
                $matuni[1] = 'una'; 
                $subcent = 'as'; 
            }else{ 
                $matuni[1] = $neutro ? 'un' : 'uno'; 
                $subcent = 'os'; 
            } 
            $t = ''; 
            $n2 = substr($num, 1); 
            if ($n2 == '00') { 
            }elseif ($n2 < 21) 
                $t = ' ' . $matuni[(int)$n2]; 
            elseif ($n2 < 30) { 
                $n3 = $num[2]; 
                if ($n3 != 0) $t = 'i' . $matuni[$n3]; 
                $n2 = $num[1]; 
                $t = ' ' . $matdec[$n2] . $t; 
            }else{ 
                $n3 = $num[2]; 
                if ($n3 != 0) $t = ' y ' . $matuni[$n3]; 
                $n2 = $num[1]; 
                $t = ' ' . $matdec[$n2] . $t; 
            } 
            $n = $num[0]; 
            if ($n == 1) { 
                $t = ' ciento' . $t; 
            }elseif ($n == 5){ 
                $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t; 
            }elseif ($n != 0){ 
                $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t; 
            } 
            if ($sub == 1) { 
            }elseif (! isset($matsub[$sub])) { 
                if ($num == 1) { 
                    $t = ' mil'; 
                }elseif ($num > 1){ 
                    $t .= ' mil'; 
                } 
            }elseif ($num == 1) { 
                $t .= ' ' . $matsub[$sub] . '?n'; 
            }elseif ($num > 1){ 
                $t .= ' ' . $matsub[$sub] . 'ones'; 
            }   
            if ($num == '000') $mils ++; 
            elseif ($mils != 0) { 
                if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub]; 
                $mils = 0; 
            } 
            $neutro = true; 
            $tex = $t . $tex; 
        } 
        $tex = $neg . substr($tex, 1) . $fin; 
        //Zi hack --> return ucfirst($tex);
        //$end_num= ucfirst($tex).' con '.$float[1].'/100  Soles';
        // dd($float);
        $con = '';
        if(isset($float[1])) {
            $con = ' CON '.$float[1].'/100 SOLES';
        } else {
            //10.11.2018
            $con = ' CON 00/100 SOLES';
        }

        $end_num= mb_strtoupper($tex).$con;
        return $end_num; 
    } 
}
