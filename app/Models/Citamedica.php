<?php

namespace App\Models;

use App\Models\Sede;
use App\Models\Entidad;
use App\Models\Examen;
use App\Models\Cliente;
use App\Models\Apertura;
use App\Models\Producto;
use App\Models\Citamedica;
use App\Models\Diagnostico;
use App\Models\Tratamiento;
use App\Models\Especialidad;
use App\Models\Aseguradoraplan;
use App\Models\Estadodocumento;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Citamedica extends Model
{
    use SoftDeletes;

    protected $table = 'citamedica';
    protected $primaryKey = 'idcitamedica';
    protected $dates = ['deleted_at'];

    protected $fillable = [ 
        'idsede',
        'idapertura',
        'idmedico',
        'idpaciente',
        'idconsultorio',
        'idestado',
        'idestadopago',
        'idcancelacion',
        'idreferencia',
        'idatencion',
        'idventa',
        'idordencompra',
        'idcicloatencion',
        // 'idtipo', //La calcula el API //42:Continuador43:Nuevo44:Reingresante 
        'fechahora',
        'fecha',
        'inicio',
        'fin',
        'descripcion',
        'motivo',
        'antecedente',
        'idconfirmacion',
        'fechaconfirmacion',
        'nota',
        'presupuesto',
        'tipocm',
        'tipocmcomentario',
        'smsreservacion',
        'smsinformativa',
        'costocero',
        'altamedica',
        'fechaanterior',
        'horaespera',
        'idpersonalatencion',
        'fechaatencion',
        'horaatencion',
        'iddiagnostico',
        'idpost',
        'idpersonalrev',
        'fecharev',
        'cantidadlla',
        'cantidadllae',
        'ultimallae',
        'notaespecialidad',
        'notaexamen',
        'notamedicamento',
        'eva',
        'idproductoref',
        'idproducto',
        'sugerencia',
        'adjunto',
        'idpaquete',
        'idaseguradoraplan',
    ];

    public $filterWhere = [
        'idcitamedica',
        'idpaciente',
        'fecha',
        'idestado',
        'idestadopago',
        'idsede',
        'idproducto'
    ];
    
    protected $hidden = [
        'pivot'
    ];
    
    //Recursos a solicitar
    public static function recursos() {
        return array('sede', 'apertura', 'medico', 'paciente', 'consultorio', 'ciclo.presupuesto.detalle.producto', 'personalatencion', 'diagnostico', 'especialidad', 'referencia', 'reservacion', 'producto', 'personalconfirmacion_id', 'diagnosticos', 'especialidades', 'examenes', 'tratamientos.producto', 'tratamientos.productoparent', 'paciente.documento',
            'seguroplan', 'productoreferencia.tarifas', 'ciclo.autorizaciones');        
    }

    public static function whereRango() {
        return array('fechaFrom', 'fechaTo');
    }

    //Relaciones
    public function sede()
    {
        return $this->belongsTo(Sede::class, 'idsede');
    }

    public function apertura()
    {
        return $this->belongsTo(Apertura::class);
    }

    public function medico()
    {
        return $this->belongsTo(Entidad::class, 'idmedico');
    }

    public function paciente()
    {
        return $this->belongsTo(Entidad::class, 'idpaciente');
    }

    public function consultorio()
    {
        return $this->belongsTo(Consultorio::class);
    }

    public function ciclo()
    {
        return $this->belongsTo(Ciclo::class, 'idcicloatencion');
    }

    public function personalatencion()
    {
        return $this->belongsTo(Entidad::class, 'personalatencion_id');
    }

    public function diagnostico()
    {
        return $this->belongsTo(Diagnostico::class);
    }

    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class);
    }

    public function referencia()
    {
        return $this->belongsTo(Estadodocumento::class, 'idreferencia');
    }

    public function reservacion()
    {
        return $this->belongsTo(Reservacion::class);
    }
 
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function productoreferencia()
    {
        return $this->belongsTo(Producto::class, 'idproductoref');
    }

    public function personalconfirmacion()
    {
        return $this->belongsTo(Entidad::class, 'personalconfirmacion_id');
    }

    public function seguroplan()
    {
        return $this->belongsTo(Aseguradoraplan::class, 'idaseguradoraplan');
    }

    public function tratamientos()
    {
        return $this->hasMany(Tratamiento::class, 'idcitamedica', 'idcitamedica');
    } 

    public function diagnosticos()
    {
        return $this->belongsToMany(Diagnostico::class);
    } 

    public function especialidades()
    {
        return $this->belongsToMany(Especialidad::class);
    } 

    public function examenes()
    {
        return $this->belongsToMany(Examen::class);
    } 

    public function saveLog($id, $id_created_at, $valores = []) {

        $camposauditables = ['idmedico', 'idestado', 'fecha', 'inicio'];

        $camposauditablesdesc = ['idmedico' => 'médico', 'idestado' => 'estado', 'fecha' => 'fecha cita', 'inicio' => 'hora cita'];

        if (!empty($valores)) {
            $citamedica = Citamedica::where('idcitamedica', '=', $id)->first()->getAttributes(); 

            $descripcion = '';

            foreach ($citamedica as $index => $valor) {
                foreach ($valores  as $index2 => $valornuevo) {  
                    // $descripcion.= '(Omitir) ' . $index . '|' . $index2;                   
                    if (in_array($index, $camposauditables) && $index === $index2 && $valor !== $valornuevo) {

                        if($index === 'idmedico') { 
                            $user = Entidad::select('entidad')->where('identidad', $valor)->first();
                            $valor = $user->entidad;

                            $user = Entidad::select('entidad')->where('identidad', $valornuevo)->first();
                            $valornuevo = $user->entidad;
                        }

                        if($index === 'fecha') { 
                            $valor = $valor;
                            $valornuevo = $valornuevo;
                        }

                        if($index === 'idestado') { 
                            if ($valor === 4) 
                                $valor = 'Pendiente';
                            if ($valor === 5) 
                                $valor = 'Confirmada';
                            if ($valor === 6) 
                                $valor = 'Atendido';
                            if ($valor === 7) 
                                $valor = 'Cancelada';
                            if ($valor === 48) 
                                $valor = 'Faltó';

                            if ($valornuevo === 4) 
                                $valornuevo = 'Pendiente';
                            if ($valornuevo === 5) 
                                $valornuevo = 'Confirmada';
                            if ($valornuevo === 6) 
                                $valornuevo = 'Atendido';
                            if ($valornuevo === 7) 
                                $valornuevo = 'Cancelada';
                            if ($valornuevo === 48) 
                                $valornuevo = 'Faltó'; 
                        }

                        $texto = $camposauditablesdesc[$index];

                        $descripcion .= (!empty($descripcion)?'|':'') . ('Cambió '.$texto.' de "'. $valor .'" a "' . $valornuevo.'"');

                        break;
                    }
                }            
            }
        } else {
            $descripcion = 'Registro nuevo creado.';
        }
        
        if (!empty($descripcion)) {
            $dataInsert = array(
                'idcitamedica' => $id,
                'descripcion' => $descripcion,
                'created_at' => date('Y-m-d H:i:s'),
                'id_created_at' => $id_created_at 
            );

            DB::table('citamedicalog')->insert($dataInsert); 
        } 
    }
}
