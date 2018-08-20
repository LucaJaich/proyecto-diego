<?php
class Anuncios extends Dbh {

  public function get_ultimos_anuncios($cantidad = 3) {
    $sql = "SELECT anuncios.anuncio, usuarios.usuario, anuncios.time_stamp
      FROM anuncios, usuarios
      WHERE anuncios.usuario = usuarios.id_usuario
      ORDER BY anuncios.time_stamp DESC
      LIMIT $cantidad;";
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

  public function set_anuncio($anuncio) {

    $sql = "INSERT INTO anuncios (anuncio, usuario) VALUES ";
    $sql .= "('";
    $sql .= $anuncio;
    $sql .= "', '";
    $sql .= $_SESSION['ortp_id_usuario'];
    $sql .= "');";
    $this->conectar()->query($sql);
    header("Location: home.php");

    //$resultado = $this->conectar()->query($sql);
  }

}
?>
