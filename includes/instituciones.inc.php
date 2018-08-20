<?php
class Instituciones extends Dbh {

  public function get_instituciones() {
    $sql = "SELECT institucion, id FROM uti_instituciones WHERE deshabilitado = 'no' ORDER BY institucion ASC;";
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

}
?>
