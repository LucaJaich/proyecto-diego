<?php

session_start();

include 'includes/dbh.inc.php';
include 'includes/usuarios.inc.php';

$usuarios = new Usuarios();
$usuarios->validar_sesion($_SESSION['ortp_usuario'], $_SESSION['ortp_contrasena'], 2);

if (isset($_POST['buscar_personas'])) {

  include 'includes/personas.inc.php';
  $personas = new Personas();

  $respuesta = $personas->get_buscar_personas($_POST['buscar_personas']);

  $nro_respuesta = count($respuesta);

}

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
    <?php include 'includes/menu.inc.php'; ?>

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
                <td>
                  <span style="white-space: nowrap;"><i class="fas fa-user"></i> <a href="perfil_persona.php?id=<?php echo $fila['id_persona'] ?>"><b><?php echo $fila['apellidos']; ?></b>, <?php echo $fila['nombres']; ?></a>
                  <span class="w3-tiny">(legajo: <?php echo $fila['legajo'] ?>)</span></span>
                </td>
                <td>
                  <b>
                  <a href="grupo.php?id=<?php echo $fila['grupo'] ?>"><?php echo $fila['grupo'] ?></a>
                  </b>
                </td>


              </tr>

              <div id="modal_evaluar_<?php echo $fila['id_persona'] ?>" class="w3-modal">
                <div class="w3-modal-content w3-animate-top w3-card-4">
                  <header class="w3-container w3-large w3-padding w3-indigo">
                    <span onclick="document.getElementById('modal_evaluar_<?php echo $fila['id_persona'] ?>').style.display='none'"
                    class="w3-button w3-display-topright w3-hover-red">&times;</span>
                    Evaluar
                  </header>
                  <div class="w3-container">
                    <form action="" method="post">
                      <p class="w3-margin">
                        <input class="w3-check" type="checkbox">
                        <label>Pediculosis</label>
                        <br>
                        <input class="w3-check" type="checkbox">
                        <label>Micosis</label>
                        <br>
                        <input class="w3-check" type="checkbox">
                        <label>Otras</label>
                      </p>
                      <p class="w3-margin">
                        notas:
                        <textarea id="notas" onkeyup="countChar(this)" style="resize: none;" class="w3-input w3-border" type="text" placeholder="..." name="notas" title="Ingresa las notas" rows="4" required></textarea>
                      </p>
                  </div>
                  <p class="w3-center w3-margin-top">
                    <button class="w3-large w3-btn w3-block w3-hover-indigo w3-border-top w3-border-grey w3-light-grey" id="agregar_evaluacion" type="submit" name="agregar_evaluacion">enviar <i class="fas fa-angle-right fa-sm"></i></button>
                  </p>
                </form>
                </div>
              </div>


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

    <div class="w3-card-4 w3-margin" style="max-width:800px;">
      <div class="w3-container w3-padding w3-large w3-indigo">
        <i class="fa fa-search" aria-hidden="true"></i> buscar personas
      </div>
      <div class="w3-container">
        <form class="w3-container" action="<?php basename($_SERVER['PHP_SELF']) ?>" method="post">
          <p class="w3-small w3-text-grey w3-margin-top">
            <i>Ingresa los apellidos y/o nombres.</i>
          </p>
          <p>
            <input id="dato" class="w3-input w3-border" name="dato" type="text" autofocus required>
          </p>
          <p>
            <input class="w3-button w3-block w3-light-grey w3-hover-indigo w3-border" type="submit" value="buscar" name="buscar_personas">
          </p>
          <br>
        </form>
      </div>
    </div>
    <div class="w3-card-4 w3-margin" style="max-width:800px;">
      <div class="w3-container w3-padding w3-large w3-dark-grey">
        <i class="fas fa-plus"></i> agregar personas
      </div>
      <div class="w3-container">
        <br>
        <p>
          <input onclick="location.href = 'agregar_persona.php';" class="w3-button w3-block w3-light-grey w3-hover-indigo w3-border" value="agregar_persona" disabled>
        </p>
        <br>
      </div>
    </div>

  </body>

</html>
