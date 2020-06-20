<!DOCTYPE html>
<html lang="es">
	<head>
	    <title>Comprobante electrónico</title>
	    <meta charset="utf-8" />
	</head>
	<body>
	    <img src="{{$imgHeader}}" width="100%">
	    <div style="padding: 0px 30px 0px 30px; color: #333; font-family: Arial; line-height: 20px;">
		    <p>Buen dia.</p>
		    <p>
		        Has recibido un nuevo comprobante.
		    </p> 
		    <p>
		        <strong>Emisor:</strong> 
		        {{$venta->empresa->razonsocial}}<br>
		        <strong>{{$venta->docnegocio->nombre}}:</strong> 
		        {{$venta->serie}}-{{$venta->numero}}<br>
		        <strong>Fecha emisión:</strong> {{$venta->fechaemision}}<br>
		    </p>  

		    <p>
		        No responder el presente correo.
		    </p> 
	    </div> 
	</body>
</html>