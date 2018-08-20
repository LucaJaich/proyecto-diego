<div class="w3-container w3-center w3-small w3-indigo">
  <div style="margin-bottom:4px;margin-top:4px;">
    <b>ORT</b> Polideportivo Belgrano
  </div>
</div>

<div class="w3-bar w3-small w3-bottombar w3-border-indigo" style="background:#ffffff;">
  <a href="home.php" class="w3-bar-item w3-button" style="text-decoration:none;"><i class="fas fa-home"></i> inicio</a>

  <!--<a href="institucion.php" class="w3-bar-item w3-button" style="text-decoration:none;"><i class="fas fa-th"></i> salas</a>-->

  <a href="grupos.php" class="w3-bar-item w3-button" style="text-decoration:none;"><i class="fas fa-users"></i> grupos</a>

  <a href="buscar_personas.php" class="w3-bar-item w3-button w3-hide-small" style="text-decoration:none;"><i class="fas fa-user"></i> buscar personas</a>

  <a href="mailto:diego@metodocientifico.com.ar" class="w3-bar-item w3-button w3-hide-small" style="text-decoration: none;"><i class="fas fa-wrench"></i> soporte</a>

  <form class="w3-right" action="index.php" method="post">
    <button class="w3-bar-item w3-button w3-hide-small w3-hover-red " type="submit" name="cerrar_sesion"><i class="fas fa-sign-out-alt"></i> cerrar sesion</button>
  </form>

  <a href="javascript:void(0)" class="w3-bar-item w3-button w3-right w3-hide-large w3-hide-medium" onclick="myFunction_menu()"><i class="fas fa-bars"></i></a>
</div>

<div id="demo" class="w3-bar-block w3-small w3-hide w3-hide-large w3-hide-medium" style="background:#F2F5FA;border-bottom: 5px solid;border-color:#D5E1EC;">
  <!--<a href="buscar_pacientes.php" class="w3-bar-item w3-button" style="text-decoration: none;"><i class="fas fa-search"></i> paciente</a>-->

  <a href="buscar_personas.php" class="w3-bar-item w3-button" style="text-decoration:none;"><i class="fas fa-user"></i> buscar personas</a>


  <!--<a href="buscar_protocolos.php" class="w3-bar-item w3-button" style="text-decoration: none;"><i class="fas fa-search"></i> protocolo</a>-->


  <a href="mailto:diego@metodocientifico.com.ar" class="w3-bar-item w3-button" style="text-decoration: none;"><i class="fas fa-wrench"></i> soporte</a>
  <form class="" action="index.php" method="post">
    <button class="w3-bar-item w3-button w3-hover-red" type="submit" name="cerrar_sesion"><i class="fas fa-sign-out-alt"></i> cerrar sesion</button>
  </form>
</div>





<!--
<div class="w3-bar w3-small" style="background:rgb(255, 255, 255);border-bottom: 5px solid;border-color:rgb(62, 145, 255);">
  <a href="institucion.php?id=<?php echo $_SESSION['uti_id_institucion'] ?>" style="text-decoration: none;" class="w3-bar-item w3-button w3-mobile w3-hover-green"><i class="far fa-hospital"></i> Salas</a>
  <a href="agregar.php" style="text-decoration: none;" class="w3-bar-item w3-button w3-mobile w3-hover-green"><i class="fas fa-search"></i> paciente</a>
  <a onclick="document.getElementById('modal_anuncio').style.display='block'" style="text-decoration: none;" class="w3-bar-item w3-button w3-mobile w3-hover-green"><i class="fas fa-plus"></i> paciente</a>
  <a onclick="document.getElementById('modal_anuncio').style.display='block'" style="text-decoration: none;" class="w3-bar-item w3-button w3-mobile w3-hover-green"><i class="fas fa-plus"></i> anuncio</a>

  <a href="mailto:diego@metodocientifico.com.ar" style="text-decoration: none;" class="w3-bar-item w3-button w3-mobile w3-hover-green"><i class="fas fa-wrench"></i> soporte</a>
  <a href="logout.php" style="text-decoration: none;" class="w3-bar-item w3-button w3-mobile w3-hover-red w3-right"><i class="fas fa-sign-out-alt"></i> cerrar sesion <?php echo $_SESSION['uti_usuario'] ?></a>
</div>
-->

<script>
function myFunction_menu() {
    var x = document.getElementById("demo");
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
    } else {
        x.className = x.className.replace(" w3-show", "");
    }
}
</script>
