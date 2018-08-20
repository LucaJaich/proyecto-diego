<?php

date_default_timezone_set("America/Argentina/Buenos_Aires");

function get_ip_cliente() {
    $direccion_ip = '';
    if (getenv('HTTP_CLIENT_IP'))
        $direccion_ip = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $direccion_ip = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $direccion_ip = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $direccion_ip = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $direccion_ip = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $direccion_ip = getenv('REMOTE_ADDR');
    else
        $direccion_ip = 'UNKNOWN';
    return $direccion_ip;
}
$direccion_ip = get_ip_cliente();

class Dbh {

  private $dbhost;
  private $dbuser;
  private $dbpass;
  private $dbname;
  private $set_time_zone = "SET @@session.time_zone = '-3:00';";

  protected function conectar() {
    $this->dbhost = "localhost";
    $this->dbuser = "root";
    $this->dbpass = "";
    $this->dbname = "u853587864_ortp";

    $conn = new mysqli($this->dbhost, $this->dbuser, $this->dbpass, $this->dbname);

    mysqli_query($conn, $this->set_time_zone);

    return $conn;
  }

  public function desconectar() {
    mysqli_close($conn); // No se si esta bien !?
  }

}

?>
