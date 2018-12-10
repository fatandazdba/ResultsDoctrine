<?php

  $PHP_SELF = basename(__FILE__);

  // cargamos el fichero de configuración de acceso a la BD
  require 'configBD.php';
  
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <title>PHP: Recuperación de Datos de MIW_RESULTS</title>
  <meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1" />
</head>
<body style="background: white; color: navy">
  <h1 style="text-align: center">PHP: Recuperación de Datos de MIW_RESULTS</h1>
  <table style="width: 100%">
    <tr>
        <td style="text-align: left; width: 50%"><a href='recuperacion.php'>Inicio</a></td>
        <td style="text-align: right"> <a href='insercion_users.php'>Insercion Users</a></td>
        <td style="text-align: right"> <a href='insercion_result.php'>Insercion Results</a></td>
    </tr>
  </table>
<hr style='color: navy;'>
  <?php

if (IsSet($_GET['show'])) { // mostrar el código fuente del script
  highlight_file($PHP_SELF);
  exit();
}

// conectamos con el servidor y elegimos la BD
$idDB = @mysqli_connect($BD_servidor, $BD_usuario, $BD_p_clave) 
        or die('No puedo conectar con el gestor');
mysqli_select_db($idDB, $BD_bdatos) or die('No puedo seleccionar BD');

// realizamos la consulta a users
$consulta = 'SELECT * FROM USERS ';
//echo "Consulta SQL: <code>$consulta</code> <br>" . PHP_EOL;
$resultado = mysqli_query($idDB, $consulta);

// mostramos el resultado
echo "<h2>Contenido de la tabla User</h2>\n";
echo "<table border='1' align='CENTER'>\n";
echo "<tr><td colspan='59'>N&ordm; de filas recuperadas: <b>", mysqli_num_rows($resultado), "</b></td></tr>\n";
echo "<tr><th> Id </th><th> Username </th><th> Email </th> <th> Enabled </th> <th> Admin </th><th> Password </th><th></th></tr>\n";
while ($tupla = mysqli_fetch_assoc($resultado)) {
  echo '<tr><td>', $tupla['id'], "</td>\n";
  echo '    <td>', $tupla['username'], "</td>\n";
  echo '    <td>', $tupla['email'], "</td>\n";
  echo '    <td>', $tupla['enabled'], "</td>\n";
  echo '    <td>', $tupla['admin'], "</td>\n";
  echo '    <td>', $tupla['password'], "</td>\n";
  echo '    <td>' . "<a href ='delete_users.php?id=".$tupla['id']."&username=".$tupla['username']."'". " class='btn btn-info text-white'>eliminar</a>". "</td>\n";
  echo "</tr>\n";
  // echo '<pre>', print_r($tupla), '</pre>';
}
echo "</table>\n";



// realizamos la consulta a la tabla results
  echo "<hr style='color: navy;'>";
  $consulta_results = 'SELECT R.ID AS RESULTS_ID, U.ID AS USERS_ID, U.USERNAME , R.RESULT AS RESULTS_VALUE, R.TIME
 FROM miw_results.RESULTS  R
 INNER JOIN miw_results.USERS U ON R.user_id=U.id ';
  //echo "Consulta SQL: <code>$consulta_results</code> <br>" . PHP_EOL;
  $resultado_res = mysqli_query($idDB, $consulta_results);

  // mostramos el resultado de results
  echo "<h2>Contenido de la tabla Result</h2>\n";
  echo "<table border='1' align='CENTER'>\n";
  echo "<tr><td colspan='59'>N&ordm; de filas recuperadas: <b>", mysqli_num_rows($resultado_res), "</b></td></tr>\n";
  echo "<tr><th> IdResults </th><th> idUsers </th><th> Username </th> <th> Result </th> <th> Time </th><th></th></tr>\n";
  while ($tupla = mysqli_fetch_assoc($resultado_res)) {
      echo '<tr><td>', $tupla['RESULTS_ID'], "</td>\n";
      echo '    <td>', $tupla['USERS_ID'], "</td>\n";
      echo '    <td>', $tupla['USERNAME'], "</td>\n";
      echo '    <td>', $tupla['RESULTS_VALUE'], "</td>\n";
      echo '    <td>', $tupla['TIME'], "</td>\n";
      echo '    <td>' . "<a href ='delete_results.php?id=".$tupla['RESULTS_ID']."&username=".$tupla['USERNAME']."'". " class='btn btn-info text-white'>eliminar</a>". "</td>\n";
      echo "</tr>\n";
      // echo '<pre>', print_r($tupla), '</pre>';
  }
  echo "</table>\n";



// cerramos la conexión
mysqli_free_result($resultado_res);
mysqli_close($idDB);
?>
<hr style="color: #000080;">
</body>
</html>
