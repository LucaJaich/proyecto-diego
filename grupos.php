<?php

session_start();

include 'includes/dbh.inc.php';
include 'includes/usuarios.inc.php';

$usuarios = new Usuarios();
$usuarios->validar_sesion($_SESSION['ortp_usuario'], $_SESSION['ortp_contrasena'], 2);

include 'includes/personas.inc.php';

$personas = new Personas();

if (isset($_POST['buscar_personas'])) {


  $respuesta = $personas->get_buscar_personas($_POST['buscar_personas']);

  $nro_respuesta = count($respuesta);

}
$grupos = $personas->get_grupos();

$nro_grupos = count($grupos);


include 'includes/fechas.inc.php';
$fechas = new Fechas();

?>

<!DOCTYPE html>
<html lang="es-AR">

  <head>
    <meta charset="utf-8">
    <?php include 'includes/head.inc.php'; ?>
    <title>ORT Polideportivo</title>
  </head>

  <body>
    <?php
    include 'includes/menu.inc.php';
    ?>


    <div class="w3-card-3 w3-margin">
        <div class="w3-container w3-padding w3-large w3-indigo w3-center">
            Grupos (<?php echo $nro_grupos ?>)
        </div>
    </div>

    <div class="w3-row">
            <div class="w3-third">
                <div class="w3-card-4 w3-margin">
                    <header class="w3-indigo w3-container w3-padding w3-large w3-center">
                        1er año
                    </header>
                    <table class="w3-table-all">
                        <tr>
                            <th class="w3-button w3-center"><i class="fas fa-users w3-large"></i> 1A-2018</th>
                        </tr>
                        <tr>
                            <th class="w3-button w3-center"><i class="fas fa-users w3-large"></i> 1B-2018</th>
                        </tr>
                        <tr>
                            <th class="w3-button w3-center"><i class="fas fa-users w3-large"></i> 1C-2018</th>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="w3-third">
                <div class="w3-card-4 w3-margin">
                    <header class="w3-indigo w3-container w3-padding w3-large w3-center">
                        2do año
                    </header>
                    <table class="w3-table-all">
                        <tr>
                            <th class="w3-button w3-center"><i class="fas fa-users w3-large"></i> 2A-2018</th>
                        </tr>
                        <tr>
                            <th class="w3-button w3-center"><i class="fas fa-users w3-large"></i> 2B-2018</th>
                        </tr>
                        <tr>
                            <th class="w3-button w3-center"><i class="fas fa-users w3-large"></i> 2C-2018</th>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="w3-third">
                <div class="w3-card-4 w3-margin">
                    <header class="w3-indigo w3-container w3-padding w3-large w3-center">
                        3er año
                    </header>
                    <table class="w3-table-all">
                        <tr>
                            <th class="w3-button w3-center"><i class="fas fa-users w3-large"></i> 3A-2018</th>
                        </tr>
                        <tr>
                            <th class="w3-button w3-center"><i class="fas fa-users w3-large"></i> 3B-2018</th>
                        </tr>
                        <tr>
                            <th class="w3-button w3-center"><i class="fas fa-users w3-large"></i> 3C-2018</th>
                        </tr>
                        <tr>
                            <th class="w3-button w3-center"><i class="fas fa-users w3-large"></i> 3D-2018</th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="w3-row">
            <div class="w3-third">
                <div class="w3-card-4 w3-margin">
                    <header class="w3-indigo w3-container w3-padding w3-large w3-center">
                        1er año
                    </header>
                    <table class="w3-table-all">
                        <tr>
                            <th class="w3-button w3-center"><i class="fas fa-users w3-large"></i> 1A-2018</th>
                        </tr>
                        <tr>
                            <th class="w3-button w3-center"><i class="fas fa-users w3-large"></i> 1B-2018</th>
                        </tr>
                        <tr>
                            <th class="w3-button w3-center"><i class="fas fa-users w3-large"></i> 1C-2018</th>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="w3-third">
                <div class="w3-card-4 w3-margin">
                    <header class="w3-indigo w3-container w3-padding w3-large w3-center">
                        2do año
                    </header>
                    <table class="w3-table-all">
                        <tr>
                            <th class="w3-button w3-center"><i class="fas fa-users w3-large"></i> 2A-2018</th>
                        </tr>
                        <tr>
                            <th class="w3-button w3-center"><i class="fas fa-users w3-large"></i> 2B-2018</th>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="w3-third">
                <div class="w3-card-4 w3-margin">
                    <header class="w3-indigo w3-container w3-padding w3-large w3-center">
                        3er año
                    </header>
                    <table class="w3-table-all">
                        <tr>
                            <th class="w3-button w3-center"><i class="fas fa-users w3-large"></i> 3A-2018</th>
                        </tr>
                        <tr>
                            <th class="w3-button w3-center"><i class="fas fa-users w3-large"></i> 3B-2018</th>
                        </tr>
                        <tr>
                            <th class="w3-button w3-center"><i class="fas fa-users w3-large"></i> 3C-2018</th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

<br>

    <script>
    function myFunction() {
      var input, filter, table, tr, td, i;
      input = document.getElementById("myInput");
      filter = input.value.toUpperCase();
      table = document.getElementById("myTable");
      tr = table.getElementsByTagName("tr");
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
          if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }
      }
    }
    </script>

  </body>

</html>
