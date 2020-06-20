<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Titulo de la web</title>
        <meta charset="utf-8" />
    </head>
    <body>  
        <img src="{{$imgHeader}}" width="100%">
        <div style="padding: 0px 30px 0px 30px; color: #333; font-family: Arial; line-height: 20px;">

            <p>Hola {{$usuario->name}}.</p>
            <p>
                Gracias por crear una cuenta. Por favor confirma usando el siguente enlace: http://localhost:4200/login/{{$usuario->verification_token}}
            </p>   
            <p>
                No responder el presente correo.
            </p>         
        </div>
    </body>
</html>
<!-- {{route('verify', $usuario->verification_token)}} -->