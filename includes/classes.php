<?php
// ESTE ARCHIVO PUEDE SER BORRADO

class Paciente {
  protected $nombres;
  protected $apellidos;
  protected $fecha_nacimiento;
  protected $genero;
  protected $tipo_documento;
  protected $nro_documento;
  protected $usuario_creacion;
  protected $timestamp_creacion;
  protected $notas;
  protected $obito_fecha;
  protected $obito_causa;
  protected $id_paciente;
  protected $foto = 'fotos_pacientes/';
  protected $edad;

  function edad($fecha_nacimiento) {

  }

  public function datos_desde_id($id_paciente){

  }
}



class Usuario {
  protected $nombres;
  protected $apellidos;
  protected $id_usuario;
  protected $usuario;
  protected $contrasena;
  protected $habilitado;

  function validacion($usuario, $contrasena) {
    if (!empty($usuario) && !empty($contrasena)) {
      # code...
    } else {
      return "error de usuario ó contraseña"
    }
  }

  function cambiar_contrasena($usuario, $contrasena) {
    # code...
  }

  function deshabilitar($usuario) {
    # code...
  }

}

/*
class Institucion {

}
/*




 ?>
