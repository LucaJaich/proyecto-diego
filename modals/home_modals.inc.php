
  <div id="agregar_anuncio" class="w3-modal">
    <div class="w3-modal-content w3-animate-top w3-card-4">
      <header class="w3-container w3-large w3-padding w3-indigo">
        <span onclick="document.getElementById('agregar_anuncio').style.display='none'"
        class="w3-button w3-display-topright w3-hover-red">&times;</span>
        Agregar anuncio
      </header>
      <div class="w3-container">
        <form action="" method="post">
          <p class=" w3-margin">
            <textarea id="field" onkeyup="countChar(this)" style="resize: none;" class="w3-input w3-border" type="text" placeholder="anuncio..." name="anuncio" title="Ingresa el anuncio" rows="4" required></textarea>
          </p>
      </div>
      <p class="w3-center w3-margin-top">
        <button class="w3-large w3-btn w3-block w3-hover-indigo w3-border-top w3-border-grey w3-light-grey" id="agregar_anuncio" type="submit" name="agregar_anuncio">enviar <i class="fas fa-angle-right fa-sm"></i></button>
      </p>
    </form>
    </div>
  </div>
