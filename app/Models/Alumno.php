<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Services\DiasHabiles;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class Alumno extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'alumnos';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'dni',
        'nombre',
        'apellido',
        'fecha_nacimiento',
        'ciudad',
        'calle',
        'casa_numero' ,
        'dpto' ,
        'piso' ,
        'estado_civil' ,
        'email',
        'titulo_anterior' ,
        'becas',
        'observaciones',
        'telefono1',
        'telefono2' ,
        'telefono3',
        'codigo_postal',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'fecha_nacimiento' => 'datetime',
    ];


    static function existeSinPassword($correo){
        return Alumno::where('email', $correo)->where('password','0')->first();
    }

    public function verificar(){
        $this->verificado = 1;
        $this->save();
    }

    public function cursadas(){
        return $this -> hasMany(Cursada::class,'id_alumno');
    }

    static function inscribibles(){
        $exAprob = Examen::select('id_asignatura')
            -> where('id_alumno',Auth::id())
            -> where('nota','>=',4)
            -> get()
            -> pluck('id_asignatura')
            -> toArray();

        $listaAprobados = implode(',',$exAprob);

        $carreraDefault = Carrera::getDefault();

        $sinRendir = Cursada::select('cursada.id_asignatura','asignaturas.nombre')
        -> join('asignaturas', 'asignaturas.id','cursada.id_asignatura')
        -> where('cursada.aprobada', 1)
        -> where('cursada.id_alumno', Auth::id())
        -> whereRaw('cursada.id_asignatura NOT IN ('.$listaAprobados.')')
        -> where('asignaturas.id_carrera', $carreraDefault)
        -> get();

        $posibles=[];

        foreach($sinRendir as $materia){
            $puede=true;

            $correlativas = Correlativa::select('asignatura_correlativa')
            -> where('id_asignatura', $materia -> id_asignatura)
            -> get();

            if(count($correlativas)>0){
                foreach($correlativas as $correlativa){
                    if(!in_array($correlativa->asignatura_correlativa,$exAprob)){
                        $puede=false;
                    }
                }
            }
            if($puede) $posibles[]=$materia;    
        }

        
        foreach($posibles as $key => $materia){
            $mesas = Mesa::select('id', 'fecha', 'llamado')
            -> where('id_asignatura', $materia->id_asignatura)
            -> whereRaw('fecha > NOW()')
            -> get();
            
            
            foreach($mesas as $keyMesa => $mesa){
                $mesa -> {'diasHabiles'} = DiasHabiles::desdeHoyHasta($mesa->fecha);
                $mesas[$keyMesa] = $mesa;
            }

            $materia -> {'mesas'} = $mesas;
            $posibles[$key] = $materia;
            
        }
        return $posibles;
    }
    
}
