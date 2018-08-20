<?php

session_start();
include 'includes/dbh.inc.php';
include 'includes/usuarios.inc.php';

if (isset($_POST['loguin'])) {
  $usuarios = new Usuarios();
  $usuarios->login($_POST['usuario'], $_POST['contrasena']);
}

if (isset($_POST['cerrar_sesion'])) {
  $cerrar_sesion = new Usuarios();
  $cerrar_sesion->cerrar_sesion();
}

?>

<!DOCTYPE html>
<html lang="es-AR">

  <head>
    <meta charset="utf-8">
    <?php include 'includes/head.inc.php'; ?>
    <style>

    body {
    	width: 100wh;
    	height: 90vh;
    	background: linear-gradient(-45deg, #081461, #7791f0, #081461);
    	background-size: 400% 400%;
    	-webkit-animation: Gradient 15s ease infinite;
    	-moz-animation: Gradient 15s ease infinite;
    	animation: Gradient 15s ease infinite;
    }

    @-webkit-keyframes Gradient {
    	0% {
    		background-position: 0% 50%
    	}
    	50% {
    		background-position: 100% 50%
    	}
    	100% {
    		background-position: 0% 50%
    	}
    }

    @-moz-keyframes Gradient {
    	0% {
    		background-position: 0% 50%
    	}
    	50% {
    		background-position: 100% 50%
    	}
    	100% {
    		background-position: 0% 50%
    	}
    }

    @keyframes Gradient {
    	0% {
    		background-position: 0% 50%
    	}
    	50% {
    		background-position: 100% 50%
    	}
    	100% {
    		background-position: 0% 50%
    	}
    }


          .content {
          max-width: 500px;
          margin: auto;
          padding: 10px;
      }
    </style>
    <title>ORT polideportivo login</title>
  </head>

  <body class="content">
    <br>
    <div class="w3-card-4 w3-margin w3-border w3-border-grey"
      style="background:rgb(236, 236, 236);max-width:400px;">

      <div class="" style="background:rgb(255, 255, 255)">
        <div class="w3-container w3-center">

            <img class="w3-margin" src="imagenes/ortlogo.jpg" alt="ORT" width="120">
        </div>
      </div>

      <form class="" action="" method="post">
        <div class="w3-margin">
          <i class="fas fa-sign-in-alt"></i> inicio de sesion
          <br><br>
          <input style="margin-bottom:8px"
            class="w3-input w3-border"
            type="text" name="usuario"
            value=""
            placeholder="usuario"
            autofocus
            required>
          <input style="margin-bottom:8px"
            class="w3-input w3-border"
            type="password"
            name="contrasena"
            value=""
            placeholder="contraseña"
            required>
          <br>
          <span class="w3-tiny">ip:<b><?php echo $direccion_ip ?></b></span>
          <br>
          <button class="w3-button w3-block w3-light-grey w3-hover-teal w3-border"
            type="submit"
            name="loguin">
            ingresar</button>
        </div>
      </form>

    </div>
    <div class="w3-small w3-margin">
      <i class="fas fa-angle-left"></i> <a href="https://metodocientifico.com.ar">metodocientifico.com.ar</a>
    </div>
  </body>

</html>
