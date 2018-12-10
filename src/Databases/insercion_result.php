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


// conectamos con el servidor y elegimos la BD
$idDB = @mysqli_connect($BD_servidor, $BD_usuario, $BD_p_clave)
or die('No puedo conectar con el gestor');
mysqli_select_db($idDB, $BD_bdatos) or die('No puedo seleccionar BD');

// realizamos la consulta a users
$consulta = 'SELECT * FROM USERS ';
//echo "Consulta SQL: <code>$consulta</code> <br>" . PHP_EOL;
$resultado = mysqli_query($idDB, $consulta);


echo '<hr style="color: navy;">' . PHP_EOL;

// Si el metodo es GET o no hay DNI: mostramos el formulario
if (($_SERVER['REQUEST_METHOD'] === 'GET') || empty($_POST['username'])) {

  echo "<h2 align=\"center\">Tabla Results</h2>";
  echo "<form method=\"post\" action=\"$PHP_SELF\">";
  echo  "Username: <select name='username'>";
  while ($tupla = mysqli_fetch_assoc($resultado)) {
        echo "<option value='".$tupla['id']."'".">".$tupla['username']."</option>";
  }
  echo  "</select><br />";
  echo  "Result:    <input type='text' name='result' size='20'><br />";
  echo  "<input type='submit' value='enviar'>";
  echo  "</form>";

}
// Si existe el DNI es porque tenemos datos... Hay que insertarlos
else { 
  echo "<h2 align='center'>Tabla Results</h2>\n";
  // conectamos con el servidor
  $idDB = mysqli_connect($BD_servidor, $BD_usuario, $BD_p_clave)
          or die("No puedo conectar con el gestor");
  mysqli_select_db($idDB, $BD_bdatos);

  // realizamos la consulta
  $consulta = "INSERT INTO miw_results.results  VALUES ('','$_POST[username]', '$_POST[result]', '0000-00-00 00:00:00')";

  // echo "Consulta SQL: <code>$consulta</code> <br>\n";

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
