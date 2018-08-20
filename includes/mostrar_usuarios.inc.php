<?php

class MostrarUsuarios extends Usuarios {

  public function mostrar_usuarios() {
    $datas = $this->get_usuarios();
    foreach ($datas as $data) {
      echo $data['usuario']."<br>";

    }
  }



}


?>
