Hola {{$usuario->name}}

Has cambiado tu correo electrónico. Por favor verifica la nueva dirección usando el siguiente enlace:

{{route('verify', $usuario->verification_token)}}