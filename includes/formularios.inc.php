<?php
class Formularios extends Dbh {


  public function get_datos_formulario($archivo) {
    $sql = "SELECT nombre, descripcion, tabla, id
      FROM uti_formularios
      WHERE archivo = '$archivo'
      LIMIT 1;";
    $resultado = $this->conectar()->query($sql);

    $resultado = mysqli_fetch_assoc($resultado);

    return $resultado;

    // ACA DEBERIA CERRAR LA CONEXION ???
  }


  public function get_formularios_mas_utilizados($cantidad = 5) {

    $sql = "SELECT uti_resumenes.formulario, uti_formularios.nombre, uti_formularios.descripcion, uti_formularios.archivo, COUNT(uti_resumenes.formulario) AS magnitud
      FROM uti_resumenes, uti_formularios
      WHERE uti_resumenes.formulario = uti_formularios.id
      GROUP BY uti_resumenes.formulario
      ORDER BY magnitud DESC
      LIMIT $cantidad;";
    $resultado = $this->conectar()->query($sql);

    //$resultado = mysqli_fetch_assoc($resultado);

    return $resultado;

  }



  public function get_total_formularios() {

    $sql = "SELECT COUNT(*) AS total
      FROM uti_formularios";
    $resultado = $this->conectar()->query($sql);
    $resultado = mysqli_fetch_assoc($resultado);

    return $resultado['total'];

  }

  public function set_formulario_data($data, $id_paciente, $id_usuario, $id_institucion, $resumen, $tabla, $id_formulario) {

    $sql = "SELECT COUNT(*) AS total FROM information_schema.tables WHERE table_name = '$tabla' ";
    $resultado = $this->conectar()->query($sql);
    $resultado = mysqli_fetch_assoc($resultado);

    if ($resultado['total'] < 1) {
      $sql = "CREATE TABLE $tabla (
        id int(38) NOT NULL AUTO_INCREMENT,
        registro varchar(38) COLLATE utf8_unicode_ci NOT NULL,
        valor varchar(280) COLLATE utf8_unicode_ci NOT NULL,
        paciente int(38) NOT NULL,
        time_stamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        usuario int(38) NOT NULL,
        institucion int(38) NOT NULL,
        conjunto varchar(155) COLLATE utf8_unicode_ci NOT NULL,
        PRIMARY KEY (id)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
      $this->conectar()->query($sql);
    }

    $conjunto = "";
    $conjunto .= time();
    $conjunto .= "000";
    $conjunto .= $id_paciente;
    $conjunto .= "000";
    $conjunto .= $id_usuario;
    $conjunto .= "000";
    $conjunto .= $id_institucion;

    foreach($data as $key=>$value) {
      if ($key != "enviar" && !empty($value)) {
        $sql = "INSERT INTO $tabla (registro, valor, paciente, usuario, institucion, conjunto) VALUES ";
        $sql .= "('";
        $sql .= $key;
        $sql .= "', '";
        $sql .= $value;
        $sql .= "', '";
        $sql .= $id_paciente;
        $sql .= "', '";
        $sql .= $id_usuario;
        $sql .= "', '";
        $sql .= $id_institucion;
        $sql .= "', '";
        $sql .= $conjunto;
        $sql .= "');";
        $this->conectar()->query($sql);
      }

    }

    $sql = "INSERT INTO uti_resumenes (registro, valor, paciente, usuario, institucion, conjunto, formulario) VALUES ";
    $sql .= "('";
    $sql .= "resumen";
    $sql .= "', '";
    $sql .= $resumen;
    $sql .= "', '";
    $sql .= $id_paciente;
    $sql .= "', '";
    $sql .= $id_usuario;
    $sql .= "', '";
    $sql .= $id_institucion;
    $sql .= "', '";
    $sql .= $conjunto;
    $sql .= "', '";
    $sql .= $id_formulario;
    $sql .= "');";
    $this->conectar()->query($sql);
    header("Location: perfil_paciente.php?id=$id_paciente");

  }

  public function borrar_formulario_data($id_resumen, $conjunto, $tabla_form, $id_paciente, $usuario, $time_stamp) {

    $fecha = date_create();
    $fecha = date_timestamp_get($fecha);

    $fecha2 = date_create($time_stamp);
    $fecha2 = date_timestamp_get($fecha2);

    $fecha_diff = $fecha -  $fecha2;

    if ($fecha_diff > 3600) {
      $es = "inborrable";
    } else {
      $es = "borrable";

      if ($tabla_form == "uti_form_farmacoterapia") {
        //$sql = "INSERT INTO uti_farmacoterapia_eliminada select * from $tabla_form where conjunto = '$conjunto';";
        //$this->conectar()->query($sql);
      } else {
        $sql = "INSERT INTO uti_registros_eliminados select * from $tabla_form where conjunto = '$conjunto';";
        $this->conectar()->query($sql);
      }

      $sql = "DELETE FROM $tabla_form where conjunto = '$conjunto';";
      $this->conectar()->query($sql);

      //date_default_timezone_set("America/Argentina/Buenos_Aires");
      $ahora = date('Y-m-d H:i:s');

      $sql = "UPDATE uti_resumenes SET eliminado='si', usuario_eliminacion='$usuario', time_stamp_eliminacion='$ahora' WHERE conjunto='$conjunto'";
      $this->conectar()->query($sql);

    }


    header("Location: perfil_paciente.php?id=$id_paciente");

  }


  public function get_buscar_formularios($dato) {

    $dato = $_POST["dato"];

    // --Separa los grupos de caracteres contenidos en el string dato en un array
    $a_datos = explode(" ", $_POST["dato"]);

    // --Cuenta el contenido de datos en el array
    $n_datos = count($a_datos);

    $respuesta = "";

    $a_json = array();
    $a_json_row = array();

  // --Por cada dato en el array datos -->
    foreach ($a_datos as $value) {

      // --Si el dato tiene 2 o mas caracteres --> busca el dato en las columnas apellidos, nombres o id
      //   en la tabla pacientes de la base de datos medmem
      if (strlen($value) > 1) {




        // --Arma el query
        $sql = "SELECT * ";
        $sql .= "FROM uti_formularios ";
        $sql .= "WHERE nombre LIKE '%";
        $sql .= $value;
        $sql .= "%' ";
        $sql .= "OR descripcion LIKE '%";
        $sql .= $value;
        $sql .= "%' ";
        $sql .= "ORDER BY nombre ASC ";
        $sql .= "LIMIT 100 ";
        $sql .= ";";
        $resultado = $this->conectar()->query($sql);

        // --Por cada resultado, ingresa los datos en el array a_json
        if ($resultado && mysqli_num_rows($resultado)) {
          while ($row = mysqli_fetch_array($resultado)) {

            $id = htmlentities(stripslashes($row['id']));
            $nombre = htmlentities(stripslashes($row['nombre']));
            $descripcion = htmlentities(stripslashes($row['descripcion']));
            $archivo = htmlentities(stripslashes($row['archivo']));


            //---------------------------------$edad = edad($fecha_nacimiento);

            // --Calcula la edad del paciente segun su fecha de nacimiento
            //$edad = edad($fecha_nacimiento);
            //$hace = hace($time_stamp);

            // --Arma el array a_json
            $a_json_row["id"] = $id;
            $a_json_row["nombre"] = $nombre;
            $a_json_row["descripcion"] = $descripcion;
            $a_json_row["archivo"] = $archivo;

            //---------------------------------$a_json_row["edad"] = $edad;

            array_push($a_json, $a_json_row);
          }
        }
      }
    }

  // --Elimina los resultados duplicados en el array a_json
    $a_json = array_map("unserialize", array_unique(array_map("serialize", $a_json)));

  // --Ordena los resultados en el array a_json

    function compareElems($elem1, $elem2) {
      return strcmp($elem1['nombre'], $elem2['nombre']);
    }

    uasort($a_json, "compareElems");

    return $a_json;

    //$nro_resultado = count($a_json);
    //echo $nro_resultado;

  }



}


class Farmacoterapia extends Dbh {

  public $principios_activos;
  public $dosis_absoluta;
  public $via;
  public $fecha_inicio;
  public $frecuencia;
  public $intervalo;
  public $dosis_maxima;
  public $duracion;
  public $duracion_detalle;
  public $nota;
  public $resumen;


  public function set_farmacoterapia_data($id_paciente, $id_usuario, $id_institucion) {


    $sql = "SELECT COUNT(*) AS total FROM information_schema.tables WHERE table_name = 'uti_form_farmacoterapia' ";
    $resultado = $this->conectar()->query($sql);
    $resultado = mysqli_fetch_assoc($resultado);

    if ($resultado['total'] < 1) {
      $sql = "CREATE TABLE uti_form_farmacoterapia (
        id int(38) NOT NULL AUTO_INCREMENT,
        principios_activos varchar(280) COLLATE utf8_unicode_ci NOT NULL,
        dosis_absoluta varchar(38) COLLATE utf8_unicode_ci NOT NULL,
        via varchar(38) COLLATE utf8_unicode_ci NOT NULL,
        fecha_inicio varchar(38) COLLATE utf8_unicode_ci NOT NULL,
        frecuencia varchar(38) COLLATE utf8_unicode_ci NOT NULL,
        intervalo varchar(38) COLLATE utf8_unicode_ci,
        dosis_maxima varchar(38) COLLATE utf8_unicode_ci,
        duracion varchar(38) COLLATE utf8_unicode_ci,
        duracion_detalle varchar(155) COLLATE utf8_unicode_ci,
        nota varchar(280) COLLATE utf8_unicode_ci,
        paciente varchar(38) COLLATE utf8_unicode_ci NOT NULL,
        conjunto varchar(155) COLLATE utf8_unicode_ci NOT NULL,
        usuario_creacion varchar(38) COLLATE utf8_unicode_ci NOT NULL,
        institucion_creacion varchar(38) COLLATE utf8_unicode_ci NOT NULL,
        time_stamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        usuario_desactivacion varchar(38) COLLATE utf8_unicode_ci,
        institucion_desactivacion varchar(38) COLLATE utf8_unicode_ci,
        time_stamp_desactivacion timestamp,
        desactivado varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',

        PRIMARY KEY (id)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
      $this->conectar()->query($sql);
    }

    $conjunto = "";
    $conjunto .= time();
    $conjunto .= "000";
    $conjunto .= $id_paciente;
    $conjunto .= "000";
    $conjunto .= $id_usuario;
    $conjunto .= "000";
    $conjunto .= $id_institucion;




    $sql = "INSERT INTO uti_form_farmacoterapia (principios_activos, dosis_absoluta, via, fecha_inicio, frecuencia, intervalo, dosis_maxima, duracion, duracion_detalle, nota, paciente, conjunto, usuario_creacion, institucion_creacion) VALUES ";
    $sql .= "('";
    $sql .= $this->principios_activos;
    $sql .= "', '";
    $sql .= $this->dosis_absoluta;
    $sql .= "', '";
    $sql .= $this->via;
    $sql .= "', '";
    $sql .= date('Y-m-d', strtotime($this->fecha_inicio));
    $sql .= "', '";
    $sql .= $this->frecuencia;
    $sql .= "', '";
    $sql .= $this->intervalo;
    $sql .= "', '";
    $sql .= $this->dosis_maxima;
    $sql .= "', '";
    $sql .= $this->duracion;
    $sql .= "', '";
    $sql .= $this->duracion_detalle;
    $sql .= "', '";
    $sql .= $this->nota;
    $sql .= "', '";
    $sql .= $id_paciente;
    $sql .= "', '";
    $sql .= $conjunto;
    $sql .= "', '";
    $sql .= $id_usuario;
    $sql .= "', '";
    $sql .= $id_institucion;
    $sql .= "');";
    $this->conectar()->query($sql);

    $sql = "INSERT INTO uti_resumenes (registro, valor, paciente, usuario, institucion, conjunto, formulario) VALUES ";
    $sql .= "('";
    $sql .= "resumen";
    $sql .= "', '";
    $sql .= $this->resumen;
    $sql .= "', '";
    $sql .= $id_paciente;
    $sql .= "', '";
    $sql .= $id_usuario;
    $sql .= "', '";
    $sql .= $id_institucion;
    $sql .= "', '";
    $sql .= $conjunto;
    $sql .= "', '";
    $sql .= "8";
    $sql .= "');";
    $this->conectar()->query($sql);
    header("Location: perfil_paciente.php?id=$id_paciente");

  }

  public function get_farmacoterapia_paciente($id_paciente, $desactivado = "no") {

    $sql = "SELECT uti_form_farmacoterapia.id, uti_form_farmacoterapia.principios_activos, uti_form_farmacoterapia.dosis_absoluta, uti_form_farmacoterapia.via, uti_form_farmacoterapia.fecha_inicio, uti_form_farmacoterapia.frecuencia, uti_form_farmacoterapia.intervalo, uti_form_farmacoterapia.dosis_maxima, uti_form_farmacoterapia.duracion, uti_form_farmacoterapia.duracion_detalle, uti_form_farmacoterapia.nota, uti_form_farmacoterapia.conjunto, uti_form_farmacoterapia.time_stamp, uti_usuarios.usuario, uti_usuarios.id AS id_usuario, uti_instituciones.institucion
      FROM uti_form_farmacoterapia, uti_usuarios, uti_instituciones
      WHERE uti_form_farmacoterapia.paciente = '$id_paciente'
      AND uti_form_farmacoterapia.desactivado = '$desactivado'
      AND uti_form_farmacoterapia.institucion_creacion = uti_instituciones.id
      AND uti_form_farmacoterapia.usuario_creacion = uti_usuarios.id";
    $resultado = $this->conectar()->query($sql);
    $data = [];
    while ($fila = $resultado->fetch_assoc()) {
      $data[] = $fila;
    }
    return $data;
    // ACA DEBERIA CERRAR LA CONEXION ???
  }


  public function desactivar_farmacoterapia($id_farmacoterapia, $frecuencia, $fecha_finalizacion, $adherencia, $razon, $nota, $id_paciente, $id_institucion, $id_usuario, $conjunto, $detalle_farmacoterapia, $principios_activos, $dosis_absoluta) {

    $ahora = date('Y-m-d H:i:s');

    $resumen = "farmacoterapia DESACTIVADA el dia ";
    $resumen .= $fecha_finalizacion;

    if ($frecuencia == "unica") {
      if ($razon == "aplicado") {
        $resumen .= ", aplicado. ";
      }
      if ($razon == "no_aplicado") {
        $resumen .= ", no aplicado. ";
      }

    } else {
      if ($razon == "fin_tratamiento") {
        $resumen .= ", fin del tratamiento. ";
      }
      if ($razon == "decision_paciente") {
        $resumen .= " por desicion del paciente. ";
      }
      if ($razon == "cambio") {
        $resumen .= " por cambio de dosis/via/frecuencia. ";
      }
      if ($razon == "efectos_secundarios") {
        $resumen .= " por efectos secundarios inmanejables/intolerables. ";
      }
      $resumen .= "Adherencia ";
      $resumen .= $adherencia;
      $resumen .= ". ";
    }


    if (!empty($nota)) {
      $resumen .= $nota;
    }
    $resumen .= " [ ";
    $resumen .= $principios_activos;
    $resumen .= " ";
    $resumen .= $dosis_absoluta;
    $resumen .= ". ";
    $resumen .= $detalle_farmacoterapia;
    $resumen .= " ] ";

    $sql = "UPDATE uti_form_farmacoterapia SET desactivado='si', usuario_desactivacion='$id_usuario', institucion_desactivacion='$id_institucion', time_stamp_desactivacion='$ahora', fecha_finalizacion='$fecha_finalizacion', adherencia='$adherencia', razon='$razon', nota_desactivacion='$nota' WHERE id=$id_farmacoterapia";
    $this->conectar()->query($sql);

    $sql = "INSERT INTO uti_resumenes (registro, valor, paciente, usuario, institucion, conjunto, formulario) VALUES ";
    $sql .= "('";
    $sql .= "desactivacion";
    $sql .= "', '";
    $sql .= $resumen;
    $sql .= "', '";
    $sql .= $id_paciente;
    $sql .= "', '";
    $sql .= $id_usuario;
    $sql .= "', '";
    $sql .= $id_institucion;
    $sql .= "', '";
    $sql .= $conjunto;
    $sql .= "', '";
    $sql .= "8";
    $sql .= "');";
    $this->conectar()->query($sql);

    header("Location: perfil_paciente.php?id=$id_paciente");

  }



}





class Diagnosticos extends Dbh {


  public $codigo;
  public $codificacion;
  public $detalle;

  public $fecha_inicio;
  public $tipo;
  public $nota;
  public $resumen;

  public function get_datos_diagnostico($codigo, $codificacion) {

    if ($codificacion == "cie10") {
      $sql = "SELECT dec10, grp
        FROM cie10
        WHERE id = '$codigo'
        LIMIT 1;";
      $resultado = $this->conectar()->query($sql);

      $resultado = mysqli_fetch_assoc($resultado);

      return $resultado;
    }

    if ($codificacion == "ciap2") {
      $sql = "SELECT descripcion, grupo_a
        FROM ciap2
        WHERE codigo = '$codigo'
        LIMIT 1;";
      $resultado = $this->conectar()->query($sql);

      $resultado = mysqli_fetch_assoc($resultado);

      return $resultado;
    }



  }


  public function set_diagnosticos_data($id_paciente, $id_usuario, $id_institucion) {

/*
    $sql = "SELECT COUNT(*) AS total FROM information_schema.tables WHERE table_name = 'uti_form_farmacoterapia' ";
    $resultado = $this->conectar()->query($sql);
    $resultado = mysqli_fetch_assoc($resultado);

    if ($resultado['total'] < 1) {
      $sql = "CREATE TABLE uti_form_farmacoterapia (
        id int(38) NOT NULL AUTO_INCREMENT,
        principios_activos varchar(280) COLLATE utf8_unicode_ci NOT NULL,
        dosis_absoluta varchar(38) COLLATE utf8_unicode_ci NOT NULL,
        via varchar(38) COLLATE utf8_unicode_ci NOT NULL,
        fecha_inicio varchar(38) COLLATE utf8_unicode_ci NOT NULL,
        frecuencia varchar(38) COLLATE utf8_unicode_ci NOT NULL,
        intervalo varchar(38) COLLATE utf8_unicode_ci,
        dosis_maxima varchar(38) COLLATE utf8_unicode_ci,
        duracion varchar(38) COLLATE utf8_unicode_ci,
        duracion_detalle varchar(155) COLLATE utf8_unicode_ci,
        nota varchar(280) COLLATE utf8_unicode_ci,
        paciente varchar(38) COLLATE utf8_unicode_ci NOT NULL,
        conjunto varchar(155) COLLATE utf8_unicode_ci NOT NULL,
        usuario_creacion varchar(38) COLLATE utf8_unicode_ci NOT NULL,
        institucion_creacion varchar(38) COLLATE utf8_unicode_ci NOT NULL,
        time_stamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        usuario_desactivacion varchar(38) COLLATE utf8_unicode_ci,
        institucion_desactivacion varchar(38) COLLATE utf8_unicode_ci,
        time_stamp_desactivacion timestamp,
        desactivado varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',

        PRIMARY KEY (id)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
      $this->conectar()->query($sql);
    }

    */

    $conjunto = "";
    $conjunto .= time();
    $conjunto .= "000";
    $conjunto .= $id_paciente;
    $conjunto .= "000";
    $conjunto .= $id_usuario;
    $conjunto .= "000";
    $conjunto .= $id_institucion;

    $sql = "INSERT INTO form_diagnosticos (codigo, codificacion, detalle, fecha_diagnostico_inicio, nota_creacion, paciente, conjunto, usuario_creacion, institucion_creacion) VALUES ";
    $sql .= "('";
    $sql .= $this->codigo;
    $sql .= "', '";
    $sql .= $this->codificacion;
    $sql .= "', '";
    $sql .= $this->detalle;
    $sql .= "', '";
    $sql .= date('Y-m-d', strtotime($this->fecha_inicio));
    $sql .= "', '";
    $sql .= $this->nota;
    $sql .= "', '";
    $sql .= $id_paciente;
    $sql .= "', '";
    $sql .= $conjunto;
    $sql .= "', '";
    $sql .= $id_usuario;
    $sql .= "', '";
    $sql .= $id_institucion;
    $sql .= "');";
    $this->conectar()->query($sql);

    $sql = "INSERT INTO uti_resumenes (registro, valor, paciente, usuario, institucion, conjunto, formulario) VALUES ";
    $sql .= "('";
    $sql .= "resumen";
    $sql .= "', '";
    $sql .= $this->resumen;
    $sql .= "', '";
    $sql .= $id_paciente;
    $sql .= "', '";
    $sql .= $id_usuario;
    $sql .= "', '";
    $sql .= $id_institucion;
    $sql .= "', '";
    $sql .= $conjunto;
    $sql .= "', '";
    $sql .= "9";
    $sql .= "');";
    $this->conectar()->query($sql);
    header("Location: perfil_paciente.php?id=$id_paciente");

  }

  public function get_diagnosticos_paciente($id_paciente, $desactivado = "no") {

    $sql = "SELECT form_diagnosticos.id, form_diagnosticos.codigo, form_diagnosticos.codificacion, form_diagnosticos.detalle, form_diagnosticos.fecha_diagnostico_inicio, form_diagnosticos.nota_creacion, form_diagnosticos.conjunto, form_diagnosticos.time_stamp_creacion, uti_usuarios.usuario, uti_usuarios.id AS id_usuario, uti_instituciones.institucion
      FROM form_diagnosticos, uti_usuarios, uti_instituciones
      WHERE form_diagnosticos.paciente = '$id_paciente'
      AND form_diagnosticos.desactivado = '$desactivado'
      AND form_diagnosticos.institucion_creacion = uti_instituciones.id
      AND form_diagnosticos.usuario_creacion = uti_usuarios.id";
    $resultado = $this->conectar()->query($sql);
    $data = [];

    while ($fila = $resultado->fetch_assoc()) {
      $data[] = $fila;
    }
    return $data;
    // ACA DEBERIA CERRAR LA CONEXION ???
  }


  public function desactivar_diagnostico($id_farmacoterapia, $frecuencia, $fecha_finalizacion, $adherencia, $razon, $nota, $id_paciente, $id_institucion, $id_usuario, $conjunto, $detalle_farmacoterapia, $principios_activos, $dosis_absoluta) {

    $ahora = date('Y-m-d H:i:s');

    $resumen = "enfermedad / problema DESACTIVADX el dia ";
    $resumen .= $fecha_finalizacion;

    if (!empty($nota)) {
      $resumen .= $nota;
    }
    $resumen .= " [ ";
    $resumen .= $principios_activos;
    $resumen .= " ";
    $resumen .= $dosis_absoluta;
    $resumen .= ". ";
    $resumen .= $detalle_farmacoterapia;
    $resumen .= " ] ";

    $sql = "UPDATE uti_form_farmacoterapia SET desactivado='si', usuario_desactivacion='$id_usuario', institucion_desactivacion='$id_institucion', time_stamp_desactivacion='$ahora', fecha_finalizacion='$fecha_finalizacion', adherencia='$adherencia', razon='$razon', nota_desactivacion='$nota' WHERE id=$id_farmacoterapia";
    $this->conectar()->query($sql);

    $sql = "INSERT INTO uti_resumenes (registro, valor, paciente, usuario, institucion, conjunto, formulario) VALUES ";
    $sql .= "('";
    $sql .= "desactivacion";
    $sql .= "', '";
    $sql .= $resumen;
    $sql .= "', '";
    $sql .= $id_paciente;
    $sql .= "', '";
    $sql .= $id_usuario;
    $sql .= "', '";
    $sql .= $id_institucion;
    $sql .= "', '";
    $sql .= $conjunto;
    $sql .= "', '";
    $sql .= "8";
    $sql .= "');";
    $this->conectar()->query($sql);

    header("Location: perfil_paciente.php?id=$id_paciente");

  }



}


?>
