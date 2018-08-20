<?php

session_start();

include 'includes/dbh.inc.php';
include 'includes/usuarios.inc.php';
$usuarios = new Usuarios();
$usuarios->validar_sesion(
  $_SESSION['ortp_usuario'],
  $_SESSION['ortp_contrasena']
);

include 'includes/personas.inc.php';
include 'includes/fechas.inc.php';
$personas = new Personas();
$fechas = new Fechas();

$grupo = $_GET['id'];

if (isset($_POST['editar_grupo'])) {
  $personas->set_editar_grupo(
    $_POST['grupo'],
    $_POST['persona']
  );

  header("Location: grupo.php?id=$grupo");

}

if (isset($_POST['agregar_apto_higienico'])) {
  $personas->set_apto_higienico(
    $_POST['persona'],
    $_POST['pediculosis'],
    $_POST['micosis'],
    $_POST['otras'],
    $_POST['notas'],
    $_SESSION['ortp_id_usuario']
  );

  header("Location: grupo.php?id=$grupo");

}

$contenido_grupos = $personas->get_contenido_grupos($grupo);
$nro_personas = count($contenido_grupos);
$datos_grupos = $personas->get_datos_grupo($grupo);

$grupos = $personas->get_grupos();




?>

<!DOCTYPE html>
<html lang="es-AR">

  <head>
    <meta charset="utf-8">
    <?php include 'includes/head.inc.php'; ?>
    <title>ORT Polideportivo</title>
  </head>

  <body>
    <?php include 'includes/menu.inc.php'; ?>

    <div class="w3-card-4 w3-margin">
      <div class="w3-container w3-padding w3-xlarge w3-indigo w3-center">
       <i class="fas fa-users"></i> <b><?php echo $grupo; ?></b> (<?php echo $nro_personas ?>)
      </div>
      <div class="w3-margin">
        Docente: <b><?php echo $datos_grupos['docente']; ?></b>
      </div>
<p class="w3-margin">
  <input class="w3-input w3-border w3-padding" type="text" placeholder="Filtro..." id="myInput" onkeyup="myFunction()">
</p>
      <div class="w3-responsive">
        <table id="myTable"  class="w3-table w3-bordered w3-striped">
          <tr class="w3-indigo w3-tiny">
            <th>
              apellidos y nombres
            </th>
            <th>
              actividades
            </th>
            <th>
              aptos higienicos
            </th>
            <th>
              aptos fisicos
            </th>
            <th class="w3-center">
              exenciones
            </th>

            <th class="w3-center">
              cambiar grupo
            </th>
          </tr>
          <?php foreach ($contenido_grupos as $fila): ?>

            <?php

            $ultimo_apto_higienico = $personas->get_ultimo_apto_higienico($fila['id_persona']);

if (!empty($ultimo_apto_higienico[0]['time_stamp'])) {
  $hace = "hace " . $fechas->hace($ultimo_apto_higienico[0]['time_stamp']);
} else {
  $hace = "nunca";
}


            if ($ultimo_apto_higienico[0]['pediculosis'] == 'no') {
                $pediculosis = "w3-green";
            } else {
              $pediculosis = "w3-red";
            }
            if ($ultimo_apto_higienico[0]['micosis'] == 'no') {
                $micosis = "w3-green";
            } else {
              $micosis = "w3-red";
            }
            if ($ultimo_apto_higienico[0]['otras'] == 'no') {
                $otras = "w3-green";
            } else {
              $otras = "w3-red";
            }
            if (!empty($ultimo_apto_higienico[0]['notas'])) {
              $notas_icono = "<i class='fas fa-sticky-note'></i>";
            } else {
              $notas_icono = "";
            }

            if ($ultimo_apto_higienico[0]['pediculosis'] == 'no' && $ultimo_apto_higienico[0]['micosis'] == 'no' && $ultimo_apto_higienico[0]['otras'] == 'no') {
              $apto_natacion = "w3-green";
              $apto_natacion_icono = "";

            } else {
              $apto_natacion = "w3-red";
              $apto_natacion_icono = "";
            }

            $apto_general = "w3-green";

            ?>
            <tr>
              <td>
                <span style="white-space: nowrap;">
                  <i class="fas fa-user"></i> <b><?php echo $fila['apellidos'] ?></b>, <?php echo $fila['nombres'] ?>
              </span>
              </td>
              <td>
                <span style="white-space: nowrap;">

                <span class="w3-tag w3-grey w3-round"><i class="fas fa-question"></i> Ed. fisica</span>
                <span class="w3-tag <?php echo $apto_natacion; ?> w3-round"><?php echo $apto_natacion_icono; ?> Natacion</span>



              </span>
              </td>

              <td>
                <span style="white-space: nowrap;">
                  <?php if ($_SESSION['ortp_nivel_usuario'] >= 5): ?>

                  <span class="w3-tag w3-indigo w3-round w3-hover-grey" style="cursor:pointer" onclick="document.getElementById('modal_apto_higienico_<?php echo $fila['id_persona'] ?>').style.display='block'"><i class="fas fa-plus"></i></span>
                <?php endif; ?>

                  <span class="w3-tag w3-round <?php echo $pediculosis; ?>">P</span> <span class="w3-tag w3-round <?php echo $micosis; ?>">M</span> <span class="w3-tag w3-round <?php echo $otras; ?>">O</span>

                  <?php echo $notas_icono; ?>




                  <span class="w3-small">(<?php echo $hace ?>)</span>
                </span>
              </td>



              <td style="cursor:pointer">
                <span style="white-space: nowrap;">
                  <?php if ($_SESSION['ortp_nivel_usuario'] >= 5): ?>

                  <span class="w3-tag w3-indigo w3-round w3-hover-grey" style="cursor:pointer" onclick="document.getElementById('modal_agregar_apto_fisico_<?php echo $fila['id_persona'] ?>').style.display='block'"><i class="fas fa-plus"></i></span>
                <?php endif; ?>

                <span class="w3-tag w3-grey w3-round"><i class="fas fa-question"></i> Apto fisico </span>
                <span class="w3-small">00-0000</span>
              </span>

              </td>
              <td class="w3-center">

                <?php if ($_SESSION['ortp_nivel_usuario'] >= 5): ?>

                <span class="w3-tag w3-indigo w3-round w3-hover-grey" style="cursor:pointer" onclick="document.getElementById('modal_agregar_exencion_<?php echo $fila['id_persona'] ?>').style.display='block'"><i class="fas fa-plus"></i></span>
              <?php endif; ?>


              </td>

              <?php if ($_SESSION['ortp_nivel_usuario'] >= 3): ?>
                <td class="w3-center">
                  <span style="white-space: nowrap;">


                  <span class="w3-tag w3-indigo w3-round w3-hover-grey" style="cursor:pointer" onclick="document.getElementById('modal_editar_<?php echo $fila['id_persona'] ?>').style.display='block'"><i class="far fa-object-ungroup"></i></span>

                </span>

                </td>



              <?php endif; ?>



            </tr>

            <div id="modal_apto_higienico_<?php echo $fila['id_persona'] ?>" class="w3-modal">
              <div class="w3-modal-content w3-animate-top w3-card-4">
                <header class="w3-container w3-large w3-padding w3-indigo">
                  <span onclick="document.getElementById('modal_apto_higienico_<?php echo $fila['id_persona'] ?>').style.display='none'"
                  class="w3-button w3-display-topright w3-hover-red">&times;</span>
                  Agregar Apto Higienico
                </header>
                <div class="w3-container">
                  <form action="" method="post">
                    <p class="w3-margin w3-xlarge w3-border-bottom">
                      <b><?php echo $fila['apellidos'] ?></b>, <?php echo $fila['nombres'] ?>
                      <input type="hidden" name="persona" value="<?php echo $fila['id_persona'] ?>">

                    </p>
                    <p class="w3-margin w3-padding w3-leftbar w3-border-indigo">
                      <input class="w3-check" type="checkbox" name="pediculosis" value="si">
                      <label>Pediculosis</label>
                      <br>
                      <input class="w3-check" type="checkbox" name="micosis" value="si">
                      <label>Micosis</label>
                      <br>
                      <input class="w3-check" type="checkbox" name="otras" value="si">
                      <label>Otras</label>
                    </p>
                    <p class="w3-margin">
                      notas:
                      <textarea id="notas" onkeyup="countChar(this)" style="resize: none;" class="w3-input w3-border" type="text" placeholder="..." name="notas" title="Ingresa las notas" rows="4"></textarea>
                    </p>
                </div>
                <p class="w3-center w3-margin-top">
                  <button class="w3-large w3-btn w3-block w3-hover-indigo w3-border-top w3-border-grey w3-light-grey" id="agregar_apto_higienico" type="submit" name="agregar_apto_higienico">enviar <i class="fas fa-angle-right fa-sm"></i></button>
                </p>
              </form>
              </div>
            </div>


            <div id="modal_agregar_apto_fisico_<?php echo $fila['id_persona'] ?>" class="w3-modal">
              <div class="w3-modal-content w3-animate-top w3-card-4">
                <header class="w3-container w3-large w3-padding w3-indigo">
                  <span onclick="document.getElementById('modal_agregar_apto_fisico_<?php echo $fila['id_persona'] ?>').style.display='none'"
                  class="w3-button w3-display-topright w3-hover-red">&times;</span>
                  Agregar apto fisico
                </header>
                <div class="w3-container">
                  <form action="" method="post">
                    <p class="w3-margin w3-xlarge w3-border-bottom">

                      <b><?php echo $fila['apellidos'] ?></b>, <?php echo $fila['nombres'] ?>
                      <input type="hidden" name="persona" value="<?php echo $fila['id_persona'] ?>">

                    </p>
                    <p class="w3-margin w3-padding w3-leftbar w3-border-indigo">
                      <input type="date" name="" value="">
                      <br>
                      <input class="w3-check" type="checkbox" name="confirmacion" value="si" required>
                      <label>se encuentra apto</label>
                    </p>

                    <p class="w3-margin">
                      notas:
                      <textarea id="notas" onkeyup="countChar(this)" style="resize: none;" class="w3-input w3-border" type="text" placeholder="..." name="notas" title="Ingresa las notas" rows="4"></textarea>
                    </p>
                </div>
                <p class="w3-center w3-margin-top">
                  <button class="w3-large w3-btn w3-block w3-hover-indigo w3-border-top w3-border-grey w3-light-grey" id="agregar_apto_higienico" type="submit" name="agregar_apto_higienico" disabled>enviar <i class="fas fa-angle-right fa-sm"></i></button>
                </p>
              </form>
              </div>
            </div>



            <div id="modal_agregar_exencion_<?php echo $fila['id_persona'] ?>" class="w3-modal">
              <div class="w3-modal-content w3-animate-top w3-card-4">
                <header class="w3-container w3-large w3-padding w3-indigo">
                  <span onclick="document.getElementById('modal_agregar_exencion_<?php echo $fila['id_persona'] ?>').style.display='none'"
                  class="w3-button w3-display-topright w3-hover-red">&times;</span>
                  Agregar exencion
                </header>
                <div class="w3-container">
                  <form action="" method="post">
                    <p class="w3-margin w3-xlarge w3-border-bottom">

                      <b><?php echo $fila['apellidos'] ?></b>, <?php echo $fila['nombres'] ?>
                      <input type="hidden" name="persona" value="<?php echo $fila['id_persona'] ?>">

                    </p>
                    <p class="w3-margin w3-padding w3-leftbar w3-border-indigo">

                    <input class="w3-check" type="checkbox" name="confirmacion" value="si" required checked>
                    <label>Ed. fisica</label>
                    <br>
                    <input class="w3-check" type="checkbox" name="confirmacion" value="si" required checked>
                    <label>Natacion</label>
                  </p>

                    <p class="w3-margin w3-padding w3-leftbar w3-border-indigo">
                      <input class="w3-radio" type="radio" name="gender" value="male" checked>
                      <label>Parcial</label>,
                      <input class="w3-radio" type="radio" name="gender" value="female">
                      <label>Anual</label>
                      <br><br>
                      Hasta: <input type="date" name="" value="">


                  </p>

                    <p class="w3-margin">
                      notas:
                      <textarea id="notas" onkeyup="countChar(this)" style="resize: none;" class="w3-input w3-border" type="text" placeholder="..." name="notas" title="Ingresa las notas" rows="4"></textarea>
                    </p>
                </div>
                <p class="w3-center w3-margin-top">
                  <button class="w3-large w3-btn w3-block w3-hover-indigo w3-border-top w3-border-grey w3-light-grey" id="agregar_apto_higienico" type="submit" name="agregar_apto_higienico" disabled>enviar <i class="fas fa-angle-right fa-sm"></i></button>
                </p>
              </form>
              </div>
            </div>




            <div id="modal_editar_<?php echo $fila['id_persona'] ?>" class="w3-modal">
              <div class="w3-modal-content w3-animate-top w3-card-4">
                <header class="w3-container w3-large w3-padding w3-indigo">
                  <span onclick="document.getElementById('modal_editar_<?php echo $fila['id_persona'] ?>').style.display='none'"
                  class="w3-button w3-display-topright w3-hover-red">&times;</span>
                  <i class="far fa-object-ungroup"></i> Cambiar de grupo - <?php echo $fila['grupo'] ?>
                </header>
                <form action="" method="post">
                  <div class="w3-container">
                    <p class="w3-margin w3-xlarge w3-border-bottom">
                      <b><?php echo $fila['apellidos'] ?></b>, <?php echo $fila['nombres'] ?>
                      <input type="hidden" name="persona" value="<?php echo $fila['id_persona'] ?>">
                    </p>
                    <p class="w3-margin w3-padding w3-leftbar w3-border-indigo">
                      <select class="w3-select w3-border" name="grupo">
                        <option value="" disabled selected>Grupo...</option>
                        <?php foreach ($grupos as $fila): ?>
                          <option value="<?php echo $fila['identificador'] ?>"><?php echo $fila['identificador'] ?> (<?php echo $fila['docente'] ?>)</option>
                        <?php endforeach; ?>
                      </select>
                    </p>
                  </div>

                  <p class="w3-center w3-margin-top">
                    <button class="w3-large w3-btn w3-block w3-hover-indigo w3-border-top w3-border-grey w3-light-grey" id="editar_grupo" type="submit" name="editar_grupo">enviar <i class="fas fa-angle-right fa-sm"></i></button>
                  </p>
                </form>
              </div>
            </div>


          <?php endforeach; ?>
        </table>
      </div>
    </div>



    <?php if (isset($respuesta)): ?>
    <?php if (!empty($respuesta)): ?>
      <div class="w3-card-4 w3-margin">
        <div class="w3-container w3-padding w3-large w3-indigo w3-center">
         resultados (<?php echo $nro_respuesta; ?>)
        </div>

        <div class="w3-responsive">

          <table class="w3-table w3-bordered w3-striped">
            <?php foreach ($respuesta as $fila): ?>
              <tr>

                <td class="w3-text-green">
                  <i class="fas fa-thumbs-up"></i>
                </td>

                <td>
                  <a href="perfil_persona.php?id=<?php echo $fila['id_persona'] ?>"><b><?php echo $fila['apellidos']; ?></b>, <?php echo $fila['nombres']; ?></a>
                  <span class="w3-small">(legajo: <?php echo $fila['legajo'] ?>)</span>
                </td>
                <td>
                  <a href=""><?php echo $fila['grupo'] ?></a>
                </td>
                <td>
                  00-00-0000 (hace...)
                </td>
                <td>
                  P <i class="fas fa-times w3-text-red"></i> M <i class="fas fa-check-circle w3-text-green"></i> O <i class="fas fa-check-circle w3-text-green"></i>
                </td>
                <td>
                  SAF
                </td>
                <td>
                  <i class="fas fa-sticky-note"></i>
                </td>

                <td>
                  <span class="w3-tag w3-round w3-light-grey w3-hover-blue">evaluar</span>

                </td>

              </tr>

            <?php endforeach; ?>
          </table>
        </div>
      </div>
    <?php else: ?>
    <div class="w3-card-4 w3-margin w3-padding w3-yellow">
      <i>no se encontraron <b>personas</b> con los datos especificados.</i>
    </div>
    <?php endif; ?>
    <?php endif; ?>



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
