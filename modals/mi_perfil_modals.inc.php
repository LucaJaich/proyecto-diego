

<?php
$es_admin = "enabled";

if ($_SESSION['uti_id_usuario'] == '1') {
  $es_admin = "disabled";
}

 ?>
<div id="editar_mi_informacion_modal" class="w3-modal">
  <div class="w3-modal-content w3-animate-top w3-card-4">
    <header class="w3-container w3-teal">
      <span onclick="document.getElementById('editar_mi_informacion_modal').style.display='none'"
      class="w3-button w3-display-topright w3-hover-red">&times;</span>
      <h2>Editar mi informacion</h2>
    </header>
    <div class="w3-container">
      <form action="" method="post">
        <p class=" w3-margin">
          <input style="margin-bottom:6px;" class="w3-input w3-border" type="text" name="correo" value="<?php echo $_SESSION['uti_usuario_correo'] ?>" placeholder="correo...">
          <input style="margin-bottom:6px;" class="w3-input w3-border" type="text" name="telefono" value="<?php echo $_SESSION['uti_usuario_telefono'] ?>" placeholder="telefono...">

          <textarea class="w3-input w3-border" type="text" placeholder="notas..." id="notas" name="notas" title="Ingresa la nota" rows="4"><?php echo $_SESSION['uti_usuario_notas'] ?></textarea>
        </p>
        <p class=" w3-margin">
          <button class="w3-btn w3-block w3-light-grey w3-border w3-hover-teal w3-large" id="editar_mi_informacion" name="editar_mi_informacion">enviar</button>
        </p>
      </form>
    </div>
    <footer class="w3-container w3-teal">
      <br>
    </footer>
  </div>
</div>


<div id="cambiar_mi_contrasena_modal" class="w3-modal">
  <div class="w3-modal-content w3-animate-top w3-card-4">
    <header class="w3-container w3-teal">
      <span onclick="document.getElementById('cambiar_mi_contrasena_modal').style.display='none'"
      class="w3-button w3-display-topright w3-hover-red">&times;</span>
      <h2>Cambiar mi contraseña</h2>
    </header>
    <div class="w3-container">
      <p class="w3-margin w3-small">
        <i>La contraseña debe contener al menos 6 caracteres alfanumericos. (ej: abc123)</i>
      </p>

      <form action="" method="post">
        <p class="w3-margin">
          <label for="">contraseña actual</label>
          <input style="margin-bottom:36px;" class="w3-input w3-border" type="password" name="contrasena_actual" value="" placeholder="contraseña actual...">
          <label for="">nueva contraseña</label>
          <input style="margin-bottom:6px;" class="w3-input w3-border" pattern=".{6,}" required title="al menos 6 caracteres alfanumericos" type="password" name="nueva_contrasena_1" value="" placeholder="nueva contraseña...">
          <label for="">repetir la nueva contraseña</label>
          <input style="margin-bottom:6px;" class="w3-input w3-border" pattern=".{6,}" required title="al menos 6 caracteres alfanumericos" type="password" name="nueva_contrasena_2" value="" placeholder="repita la nueva contraseña...">
        </p>
        <br>
        <p class="w3-margin">
          <button class="w3-btn w3-block w3-light-grey w3-border w3-hover-teal w3-large" id="cambiar_mi_contrasena" name="cambiar_mi_contrasena" <?php // echo $es_admin ?>>enviar</button>
        </p>
      </form>
    </div>
    <footer class="w3-container w3-teal">
      <br>
    </footer>
  </div>
</div>
