<?php
session_start();

include 'includes/dbh.inc.php';
include 'includes/usuarios.inc.php';
$usuarios = new Usuarios();

$usuarios->validar_sesion($_SESSION['ortp_usuario'], $_SESSION['ortp_contrasena']);

include 'includes/anuncios.inc.php';
include 'includes/fechas.inc.php';
include 'includes/personas.inc.php';


$anuncios = new Anuncios();
$fechas = new Fechas();
$personas = new Personas();


if (isset($_POST['agregar_anuncio'])) {
  $anuncios->set_anuncio($_POST['anuncio']);
}

$lista_simple_usuarios = $usuarios->get_usuarios();

$nro_personas = $personas->get_nro_personas();
$total_usuarios = count($lista_simple_usuarios);
$ultimos_anuncios = $anuncios->get_ultimos_anuncios(5);
$grupos = $personas->get_grupos();

?>
<!DOCTYPE html>
<html lang="es-AR">

  <head>
    <meta charset="utf-8">
    <?php include 'includes/head.inc.php'; ?>
    <title>ORT Polideportivo</title>
    <style media="screen">
    </style>
  </head>

  <body>
    <?php include 'includes/menu.inc.php'; ?>

    <table class="w3-margin">
      <tr>
        <td>
            <img class="w3-hover-grayscale  w3-border-indigo" src="<?php echo $_SESSION['ortp_foto_usuario'] ?>" alt="avatar_usuario" width="88">

        </td>
        <td>
          <div style="margin-left:10px;" class="w3-xlarge">
            <?php echo $_SESSION['ortp_usuario'] ?>
          <div class="w3-small">
            Nivel: <b><?php echo $_SESSION['ortp_nivel_usuario'] ?></b>
            <br>
            <a href="#"><i>cambiar contraseña</i></a>

          </div>
          </div>
        </td>
      </tr>
    </table>



    <div class="w3-row">
      <div class="w3-third">
        <div class="w3-margin w3-card-4">
          <div class="w3-container w3-padding w3-indigo w3-large">
            <i class="fas fa-info-circle"></i> informacion del sistema
          </div>
          <div class="w3-small w3-margin">
            <!--
            <div class=" w3-margin-bottom">
              camas deshabilitadas: n/d
              <br>
              camas disponibles: n/d
              <br>
              camas reservadas: n/d
              <br>
              camas ocupadas: n/d
            </div>
          -->
            <div class=" w3-margin-bottom">
              Personas: <b><?php echo $nro_personas ?></b>
              <br>
              Usuarios: <b><?php echo $total_usuarios ?></b>
            </div>
            <div class=" w3-margin-bottom">
              Usuarios del sistema:
              <br>
              <?php foreach ($lista_simple_usuarios as $fila): ?>
                <a href="perfil_usuario.php?id=<?php echo $fila['id_usuario'] ?>"><?php echo $fila['usuario'] ?></a> -
              <?php endforeach; ?>
              <br><br>

            </div>
          </div>
        </div>
      </div>
      <div class="w3-twothird">
        <div class="w3-margin w3-card-4">
          <div class="w3-container w3-padding w3-indigo w3-large">
            <i class="fas fa-newspaper"></i> anuncios
          </div>
          <div class="w3-small w3-margin">
            <button onclick="document.getElementById('agregar_anuncio').style.display='block'" class="w3-button w3-light-grey w3-hover-indigo w3-border" type="button" name="button"><i class="fas fa-plus"></i></button>
          </div>
            <?php if (empty($ultimos_anuncios)): ?>
              <div class="w3-center w3-small w3-margin">
                <i>no hay anuncios</i>
                <br>
              </div>
              <?php else: ?>
                <?php foreach ($ultimos_anuncios as $fila): ?>
                  <div class="w3-margin">
                    <div class="" style="margin-bottom:6px;font-size:16px">
                      <i style="color:rgb(208, 208, 208);" class="fas fa-quote-left"></i> <i><?php echo $fila['anuncio'] ?></i> <i style="color:rgb(208, 208, 208);" class="fas fa-quote-right "></i>
                    </div>
                    <div class="w3-border-bottom w3-tiny">

                      <a href="perfil_usuario.php?id=<?php echo $fila['id'] ?>">
                      <b><?php echo $fila['usuario'] ?></b></a>, hace <?php echo $fechas->hace($fila["time_stamp"]) ?> (<?php echo $fechas->convertir_fecha_hora($fila["time_stamp"], "fecha_hora") ?>)
                    </div>
                  </div>
                <?php endforeach; ?>
            <?php endif; ?>
            <br>
        </div>
        </div>
    </div>

    <div class="w3-center w3-margin w3-border-top w3-small">
      <br>
      <a href="https://metodocientifico.com.ar" target="_blank"><i>metodo</i><b>cientifico</b>.com.ar</a>
    </div>
  </body>

<?php include 'modals/home_modals.inc.php'; ?>



</html>
