<?php

  $PHP_SELF = basename(__FILE__);

  // cargamos el fichero de configuración de acceso a la BD
  require 'configBD.php';

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <title>MySQL: Recuperación de Datos (II)</title>
</head>
<body bgcolor='white' text='navy'>
<h1 style="text-align: center">Eliminacion de un usuario</h1>
<table width='100%'>
    <tr>
        <td style="text-align: left; width: 50%"><a href='recuperacion.php'>Inicio</a></td>
    </tr>
</table>
<hr style="color: #000080;">

<?php

  // conectamos con el servidor
  $idDB = @mysqli_connect($BD_servidor, $BD_usuario, $BD_p_clave)
          or die('No puedo conectar con el gestor');
  mysqli_select_db($idDB, $BD_bdatos) or die('No puedo seleccionar BD');

    // realizamos la consulta (con cuidado ;-)
    $consulta = 'DELETE FROM miw_results.USERS WHERE id="'.$_GET['id'].'"';
    $resultado = mysqli_query($idDB, $consulta);

   echo "<p style=\"color: blue\">  El usuario " . $_GET['username'] . " ha sido eliminado de forma correcta</p>";
   // cerramos la conexión
   @mysqli_free_result($resultado);
   mysqli_close($idDB);

?>
<hr style="color: #000080;">
</body>
</html>
