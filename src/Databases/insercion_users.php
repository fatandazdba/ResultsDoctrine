<?php

  $PHP_SELF = basename(__FILE__);

  // cargamos el fichero de configuracion de acceso a la BD
  require 'configBD.php';

?>
<!DOCTYPE html>

<html lang="es">
<head>
  <title>PHP: Inserci&oacute;n de Datos en MySQL</title>
</head>
<body bgcolor='white' text='navy'>
<table width='100%'>
  <tr>
      <td align='left' width='50%'><a href='recuperacion.php'>Inicio</a></td>
  </tr>
</table>
<?php

echo '<hr style="color: navy;">' . PHP_EOL;

// Si el metodo es GET o no hay DNI: mostramos el formulario
if (($_SERVER['REQUEST_METHOD'] === 'GET') || empty($_POST['username'])) {
  echo <<< __MARCA_FIN
  <h2 align="center">Tabla Users</h2>
  <form method="post" action="$PHP_SELF">
    Username: <input type="text" name="username" size="10"><br />
    Email:    <input type="text" name="email" size="20"><br />
    Password: <input type="text" name="password" size="20"><br />
    <input type="submit" value="enviar">
  </form>
__MARCA_FIN;
}
// Si existe el DNI es porque tenemos datos... Hay que insertarlos
else { 
  echo "<h2 align='center'>Tabla Users</h2>\n";
  // conectamos con el servidor
  $idDB = mysqli_connect($BD_servidor, $BD_usuario, $BD_p_clave)
          or die("No puedo conectar con el gestor");
  mysqli_select_db($idDB, $BD_bdatos);

  // realizamos la consulta
  $consulta = "INSERT INTO USERS VALUES ('', '$_POST[username]', '$_POST[email]', '1', '0','$_POST[password]')";

  //echo "Consulta SQL: <code>$consulta</code> <br>\n";

  $resultado = mysqli_query($idDB, $consulta);
  echo "N&uacute;mero de filas insertadas: <tt>", mysqli_affected_rows($idDB), "</tt><br>\n";
  if (mysqli_affected_rows($idDB) != 1)
    echo "Error: <code>", mysqli_error($idDB), "</code><br>\n";

  // cerramos la conexi�n
  mysqli_close($idDB);
}
?>
<hr style="color: navy;">
</body>
</html>
