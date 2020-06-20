<div style="background: #eceff4; padding: 50px 20px; color: #514d6a;" width="100%">
  <div style="max-width: 700px; margin: 0px auto; font-size: 14px">
    <table border="0" cellpadding="0" cellspacing="0" style="width: 100%; margin-bottom: 20px">
      <tr>
        <td style="vertical-align: top;">
          <!---->
          <!---->
          <!---->
          <!----><img alt="Profactura.pe" src="{{$imgHeader}}" style="height: 40px"></td>
        <td style="vertical-align: middle;">
          <!---->
          <!---->
          <!---->
          <!----><span style="color: #a09bb9;"> Software de Facturación Electrónica </span></td>
      </tr>
    </table>
    <div style="padding: 40px 40px 20px 40px; background: #fff;">
      <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
        <tbody>
          <tr>
            <td>
              <!---->
              <!---->
              <!---->
              <!---->
              <h5 style="margin-bottom: 20px; color: #24222f; font-weight: 600; font-size: 18px;">Restablecer contraseña</h5>
              <p>Hola {{$usuario->name}}, solicitaste generar una nueva contraseñaa. Por favor confirma usando el siguente botón.
              </p>
              <div style="text-align: center"><a href="http://localhost:4200/generar-contrasena/{{$tokene}}"
                  style="display: inline-block; padding: 11px 30px 6px; margin: 20px 0px 30px; font-size: 15px; color: #fff; background: #01a8fe; border-radius: 5px; text-decoration: none;">Resetear Contraseña</a>
              </div>
              <div style="text-align: center">O siguiendo el siguiente enlace. 
                	<a href="http://localhost:4200/generar-contrasena/{{$tokene}}"
                  style="display: inline-block; padding: 11px 30px 6px; margin: 20px 0px 30px; font-size: 15px; color: #fff; background: #01a8fe; border-radius: 5px">http://localhost:4200/generar-contrasena/{{$tokene}}
              	</a>
              </div>
              <p>Si no olvidó su contraseña, puede ignorar este correo electrónico.</p>
              <p>Saludos,<br>ProFactura.pe</p>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div style="text-align: center; font-size: 12px; color: #a09bb9; margin-top: 20px">
      <p> Jr. Eleazar Guzmán y Barrón Nro. 2636<br> Don't like these emails? <a
          href="javascript: void(0);" style="color: #a09bb9; text-decoration: underline;">Unsubscribe</a><br> Powered by
        Clean UI </p>
    </div>
  </div>
</div>