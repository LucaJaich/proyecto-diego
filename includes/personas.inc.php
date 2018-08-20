<?php
class Personas extends Dbh {

  public $id;
  public $nombres;
  public $apellidos;
  public $genero;
  public $fecha_nacimiento;
  public $documento_numero;
  public $documento_tipo;
  public $pais_nacimiento;

  public $edad;
  public $foto_perfil;

  public $estado;

  public $fecha_obito;

  public function get_nro_pacientes() {

    $sql = "SELECT COUNT(id_persona) AS total FROM personas;";
    $resultado = $this->conectar()->query($sql);
    $resultado = mysqli_fetch_assoc($resultado);

    return $resultado['total'];

  }

  public function set_paciente() {

    $sql = "SELECT id
      FROM uti_pacientes
      WHERE documento_numero = '$this->documento_numero'
      AND documento_tipo = '$this->documento_tipo'";
    $resultado = $this->conectar()->query($sql);
    $total = $resultado->num_rows;
    if ($total > 0) {
      $resultado = mysqli_fetch_assoc($resultado);
      return $resultado['id'];
    } else {
      $sql = "INSERT INTO uti_pacientes (nombres, apellidos, fecha_nacimiento, genero, pais_nacimiento, documento_numero, documento_tipo, usuario_creacion, institucion_creacion) VALUES ";
      $sql .= "('";
      $sql .= $this->nombres;
      $sql .= "', '";
      $sql .= $this->apellidos;
      $sql .= "', '";
      $sql .= $this->fecha_nacimiento;
      $sql .= "', '";
      $sql .= $this->genero;
      $sql .= "', '";
      $sql .= $this->pais_nacimiento;
      $sql .= "', '";
      $sql .= $this->documento_numero;
      $sql .= "', '";
      $sql .= $this->documento_tipo;
      $sql .= "', '";
      $sql .= $_SESSION['uti_id_usuario'];
      $sql .= "', '";
      $sql .= $_SESSION['uti_id_institucion'];
      $sql .= "');";
      $this->conectar()->query($sql);
      sleep(1);

      $sql = "SELECT id
        FROM uti_pacientes
        WHERE documento_numero = '$this->documento_numero'
        AND documento_tipo = '$this->documento_tipo'";
      $resultado = $this->conectar()->query($sql);
      $resultado = mysqli_fetch_assoc($resultado);
      //return $resultado['id'];
      $id_paciente_agregado = $resultado['id'];
      header("Location: perfil_paciente.php?id=$id_paciente_agregado");
    }
  }


  public function get_datos_paciente($id) {

    $sql = "SELECT id, nombres, apellidos, genero, fecha_nacimiento, pais_nacimiento, documento_tipo, documento_numero FROM uti_pacientes WHERE id = $id";
    $resultado = $this->conectar()->query($sql);
    $total = $resultado->num_rows;
    if ($total > 0) {
      $resultado = mysqli_fetch_assoc($resultado);
      return $resultado;
    }
    // ACA DEBERIA CERRAR LA CONEXION ???
  }


  public function set_apto_higienico($persona, $pediculosis, $micosis, $otras, $notas, $ortp_id_usuario) {

    if ($pediculosis != 'si') {
      $pediculosis = 'no';
    }
    if ($micosis != 'si') {
      $micosis = 'no';
    }
    if ($otras != 'si') {
      $otras = 'no';
    }

    $sql = "INSERT INTO aptos_higienicos (persona, usuario, pediculosis, micosis, otras, notas) VALUES ";
    $sql .= "('";
    $sql .= $persona;
    $sql .= "', '";
    $sql .= $_SESSION['ortp_id_usuario'];
    $sql .= "', '";
    $sql .= $pediculosis;
    $sql .= "', '";
    $sql .= $micosis;
    $sql .= "', '";
    $sql .= $otras;
    $sql .= "', '";
    $sql .= $notas;
    $sql .= "');";
    $this->conectar()->query($sql);

  }



  public function get_datos_grupo($id) {

    $sql = "SELECT id_grupo, docente FROM grupos WHERE identificador = '$id'";
    $resultado = $this->conectar()->query($sql);
    $total = $resultado->num_rows;
    if ($total > 0) {
      $resultado = mysqli_fetch_assoc($resultado);
      return $resultado;
    }
    // ACA DEBERIA CERRAR LA CONEXION ???
  }


  public function get_nro_personas_grupo($grupo) {

    $sql = "SELECT COUNT(*) AS total FROM personas WHERE grupo='$grupo';";
    $resultado = $this->conectar()->query($sql);
    $resultado = mysqli_fetch_assoc($resultado);

    return $resultado['total'];

  }



  public function get_nro_personas() {

    $sql = "SELECT COUNT(*) AS nro_personas FROM personas;";
    $resultado = $this->conectar()->query($sql);
    $resultado = mysqli_fetch_assoc($resultado);

    return $resultado['nro_personas'];

  }





  public function set_editar_grupo($grupo, $id_persona) {

    $sql = "UPDATE personas SET grupo='$grupo', usuario='$_SESSION[ortp_id_usuario]' WHERE id_persona=$id_persona;";
    $this->conectar()->query($sql);
    //header("Location: grupo.php?id=$grupo");
  }





  public function get_grupos() {



    $sql = "SELECT id_grupo, identificador, docente FROM grupos ORDER BY identificador";
    $resultado = $this->conectar()->query($sql);
    $total = $resultado->num_rows;
    if ($total > 0) {
      while ($fila = $resultado->fetch_assoc()) {
        $data[] = $fila;
        //convertir fecha desde clase fechas.inc.php
      }
      return $data;
    }

  }


  public function get_contenido_grupos($grupo) {

    $sql = "SELECT id_persona, nombres, apellidos, grupo FROM personas WHERE grupo = '$grupo' ORDER BY apellidos";
    $resultado = $this->conectar()->query($sql);
    $total = $resultado->num_rows;
    if ($total > 0) {
      while ($fila = $resultado->fetch_assoc()) {
        $data[] = $fila;
        //convertir fecha desde clase fechas.inc.php
      }
      return $data;
    }

  }



  public function get_ultimo_apto_higienico($persona) {

    $sql = "SELECT aptos_higienicos.pediculosis, aptos_higienicos.micosis, aptos_higienicos.otras, aptos_higienicos.notas, aptos_higienicos.time_stamp, personas.nombres, personas.apellidos FROM aptos_higienicos, personas  WHERE id_persona = $persona AND aptos_higienicos.persona = personas.id_persona ORDER BY aptos_higienicos.time_stamp DESC LIMIT 1";
    $resultado = $this->conectar()->query($sql);
    $total = $resultado->num_rows;
    if ($total > 0) {
      while ($fila = $resultado->fetch_assoc()) {
        $data[] = $fila;
      }
      return $data;
    }

  }


  public function logo_genero($genero) {
    if ($genero == "femenino") {
      echo "<i class='fas fa-venus w3-text-pink'></i>";
    }
    if ($genero == "masculino") {
      echo "<i class='fas fa-mars w3-text-indigo'></i>";
    }

  }


  public function get_registros_pacientes($id_paciente) {
    $sql = "SELECT uti_resumenes.registro, uti_resumenes.valor, uti_resumenes.time_stamp, uti_resumenes.conjunto, uti_resumenes.time_stamp_eliminacion, uti_resumenes.usuario_eliminacion, uti_usuarios.usuario, uti_usuarios.id, uti_instituciones.institucion, uti_formularios.tabla, uti_formularios.nombre AS nombre_formulario, uti_resumenes.id AS id_resumen, uti_resumenes.eliminado
      FROM uti_resumenes, uti_usuarios, uti_instituciones, uti_formularios
      WHERE uti_resumenes.usuario = uti_usuarios.id
      AND uti_resumenes.institucion = uti_instituciones.id
      AND uti_resumenes.formulario = uti_formularios.id
      AND uti_resumenes.paciente = $id_paciente
      ORDER BY time_stamp DESC;";
    $resultado = $this->conectar()->query($sql);
    $total = $resultado->num_rows;
    if ($total > 0) {
      while ($fila = $resultado->fetch_assoc()) {
        $data[] = $fila;
        //convertir fecha desde clase fechas.inc.php
      }
      return $data;
    }
    // ACA DEBERIA CERRAR LA CONEXION ???
  }


  public function paciente_existe($id_paciente) {

    $sql = "SELECT COUNT(id)
      AS total
      FROM uti_pacientes
      WHERE id = '$id_paciente';";

    $resultado = $this->conectar()->query($sql);
    $resultado = mysqli_fetch_assoc($resultado);

    if ($resultado['total'] == 1) {
      return "si";
    } else {
      return "no";
    }

  }



  public function get_buscar_personas($dato) {

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
        $sql .= "FROM personas ";
        $sql .= "WHERE apellidos LIKE '%";
        $sql .= $value;
        $sql .= "%' ";
        $sql .= "OR nombres LIKE '%";
        $sql .= $value;
        $sql .= "%' ";
        $sql .= "OR legajo LIKE '%";
        $sql .= $value;
        $sql .= "%' ";
        $sql .= "ORDER BY apellidos ASC ";
        $sql .= "LIMIT 100 ";
        $sql .= ";";
        $resultado = $this->conectar()->query($sql);

        // --Por cada resultado, ingresa los datos en el array a_json
        if ($resultado && mysqli_num_rows($resultado)) {
          while ($row = mysqli_fetch_array($resultado)) {

            $id_persona = htmlentities(stripslashes($row['id_persona']));
            $apellidos = htmlentities(stripslashes($row['apellidos']));
            $nombres = htmlentities(stripslashes($row['nombres']));
            $legajo = htmlentities(stripslashes($row['legajo']));
            $grupo = htmlentities(stripslashes($row['grupo']));


            //---------------------------------$edad = edad($fecha_nacimiento);

            // --Calcula la edad del paciente segun su fecha de nacimiento
            //$edad = edad($fecha_nacimiento);
            //$hace = hace($time_stamp);

            // --Arma el array a_json
            $a_json_row["id_persona"] = $id_persona;
            $a_json_row["nombres"] = $nombres;
            $a_json_row["apellidos"] = $apellidos;
            $a_json_row["legajo"] = $legajo;
            $a_json_row["grupo"] = $grupo;

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
      return strcmp($elem1['apellidos'], $elem2['apellidos']);
    }

    uasort($a_json, "compareElems");

    return $a_json;

    //$nro_resultado = count($a_json);
    //echo $nro_resultado;

  }


}
?>
