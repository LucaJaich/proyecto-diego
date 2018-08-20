<?php

class Usuarios extends Dbh {

  public function get_usuarios() {

    $sql = "SELECT usuario, id_usuario FROM usuarios ORDER BY usuario;";
    $resultado = $this->conectar()->query($sql);
    $total = $resultado->num_rows;
    if ($total > 0) {
      while ($fila = $resultado->fetch_assoc()) {
        $data[] = $fila;
      }
      return $data;
    }
    // ACA DEBERIA CERRAR LA CONEXION ???
  }


  public function get_datos_usuario($id) {

    $sql = "SELECT usuario, nombres, apellidos, deshabilitado, id, descripcion, correo, telefono, estrellas, notas FROM uti_usuarios WHERE id = $id LIMIT 1";
    $resultado = $this->conectar()->query($sql);
    $total = $resultado->num_rows;
    if ($total > 0) {
      while ($fila = $resultado->fetch_assoc()) {
        $data[] = $fila;
      }
      return $data;
    }
    // ACA DEBERIA CERRAR LA CONEXION ???
  }

  public function get_usuario_usuario($id) {

    $sql = "SELECT usuario FROM uti_usuarios WHERE id = $id LIMIT 1";
    $resultado = $this->conectar()->query($sql);
    $resultado = mysqli_fetch_assoc($resultado);
    echo $resultado['usuario'];

    // ACA DEBERIA CERRAR LA CONEXION ???
  }


  public function login($usuario, $contrasena) {

    $usuario = strip_tags($usuario); // Retira las etiquetas HTML y PHP de un string
    $usuario = stripslashes($usuario); // Quita las barras de un string con comillas escapadas
    $usuario = strtolower($usuario); // Convierte una cadena a minúsculas

    $contrasena = strip_tags($contrasena); // Retira las etiquetas HTML y PHP de un string
    $contrasena = stripslashes($contrasena); // Quita las barras de un string con comillas escapadas
    $contrasena = md5($contrasena); // Calcula el 'hash' md5 de un string

    $sql = "SELECT usuario, contrasena, id_usuario, nivel
      FROM usuarios WHERE usuario = '$usuario'
      AND contrasena = '$contrasena'";
    $resultado = $this->conectar()->query($sql);
    $total = $resultado->num_rows;
    if ($total > 0) {
      $datos_usuario = mysqli_fetch_assoc($resultado);
      $_SESSION['ortp_usuario'] = $datos_usuario['usuario'];
      $_SESSION['ortp_contrasena'] = $datos_usuario['contrasena'];
      $_SESSION['ortp_id_usuario'] = $datos_usuario['id_usuario'];
      $_SESSION['ortp_nivel_usuario'] = $datos_usuario['nivel'];

      $foto_usuario = "fotos_usuarios/" . $_SESSION['ortp_id_usuario']  . ".png";
      if (file_exists($foto_usuario)) {
        $_SESSION['ortp_foto_usuario'] = $foto_usuario;
      } else {
        $_SESSION['ortp_foto_usuario'] = "fotos_usuarios/no_foto.png";
      }

      header("Location: home.php");
    } else {
      header("Location: ../error_usr_psw.php");
    }
    // ACA DEBERIA CERRAR LA CONEXION ???
  }

  public function validar_sesion($usuario, $contrasena) {

    $sql = "SELECT usuario, contrasena, id_usuario, nivel
    FROM usuarios WHERE usuario = '$usuario'
      AND contrasena = '$contrasena'
      LIMIT 1;";
    $resultado = $this->conectar()->query($sql);
    $total = $resultado->num_rows;
    if ($total == 0 || $total > 1) {
      header("Location: ../error_usr_psw.php");
    } else {
        $datos_usuario = mysqli_fetch_assoc($resultado);
        $_SESSION['ortp_usuario'] = $datos_usuario['usuario'];
        $_SESSION['ortp_contrasena'] = $datos_usuario['contrasena'];
        $_SESSION['ortp_id_usuario'] = $datos_usuario['id_usuario'];
        $_SESSION['ortp_nivel_usuario'] = $datos_usuario['nivel'];

        $foto_usuario = "fotos_usuarios/" . $_SESSION['ortp_id_usuario']  . ".png";
        if (file_exists($foto_usuario)) {
          $_SESSION['ortp_foto_usuario'] = $foto_usuario;
        } else {
          $_SESSION['ortp_foto_usuario'] = "fotos_usuarios/no_foto.png";
        }


    }
    // ACA DEBERIA CERRAR LA CONEXION ???
  }

  public function cerrar_sesion() {
    session_destroy();
    header("Location: index.php");
  }


  public function set_cambiar_contrasena($contrasena_actual, $nueva_contrasena_1, $nueva_contrasena_2) {

    $contrasena_actual = md5($contrasena_actual); // Calcula el 'hash' md5 de un string
    if ($contrasena_actual != $_SESSION['uti_contrasena']) {
      header("Location: ../error_usr_psw.php");
      exit();

    }
    if ($nueva_contrasena_1 != $nueva_contrasena_2) {
      header("Location: ../error_usr_psw.php");
      exit();
    }
    $nueva_contrasena = md5($nueva_contrasena_1);
    $_SESSION['uti_contrasena'] = $nueva_contrasena;
    $sql = "UPDATE uti_usuarios SET ";
    $sql .= "contrasena = '$nueva_contrasena' ";
    $sql .= "WHERE id = ";
    $sql .= $_SESSION['uti_id_usuario'];
    $sql .= ";";
    $this->conectar()->query($sql);
    header("Location: mi_perfil.php");

    //$resultado = $this->conectar()->query($sql);
  }



}

?>
