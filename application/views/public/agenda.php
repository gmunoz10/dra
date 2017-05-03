<div class="container-page-header" style="background-image: url('<?= asset_url() ?>img/background/agenda.jpg');">
    <button class="btn btn-youtube-home"><i class="fa fa-youtube" aria-hidden="true"></i></button>
    <button class="btn btn-twitter-home"><i class="fa fa-twitter" aria-hidden="true"></i></button>
    <a class="btn btn-facebook-home" href="https://www.facebook.com/DRALoficial/" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
</div>
<section class="container container-page-inner">
    <section>
      <div class="col-lg-8 col-md-offset-2 box-shadow-agenda box-filtro-agenda">
          <div class="col-lg-8 col-md-offset-2 no-padding">
            <div class="input-group box-dependencia">
                <span class="input-group-addon label-dependencia-agenda">Dependencia:</span>
                <select class="form-control filter-dependencia" id="dependencia">
                  <?php foreach ($dependencias as $dependencia) { ?>
                    <option value="<?= $dependencia->codi_dpe ?>"><?= $dependencia->nomb_dpe ?></option>
                  <?php } ?>
                </select>
            </div>
            <div class="input-group box-time">
                <span class="input-group-addon label-mes-agenda">Mes:</span>
                <select class="form-control filter-mes" id="mes_search">
                  <option selected="true" disabled="true">Seleccionar</option>
                  <option value="01" <?= (date("m") == "01") ? "selected" : "" ?>>Enero</option>
                  <option value="02" <?= (date("m") == "02") ? "selected" : "" ?>>Febrero</option>
                  <option value="03" <?= (date("m") == "03") ? "selected" : "" ?>>Marzo</option>
                  <option value="04" <?= (date("m") == "04") ? "selected" : "" ?>>Abril</option>
                  <option value="05" <?= (date("m") == "05") ? "selected" : "" ?>>Mayo</option>
                  <option value="06" <?= (date("m") == "06") ? "selected" : "" ?>>Junio</option>
                  <option value="07" <?= (date("m") == "07") ? "selected" : "" ?>>Julio</option>
                  <option value="08" <?= (date("m") == "08") ? "selected" : "" ?>>Agosto</option>
                  <option value="09" <?= (date("m") == "09") ? "selected" : "" ?>>Septiembre</option>
                  <option value="10" <?= (date("m") == "10") ? "selected" : "" ?>>Octubre</option>
                  <option value="11" <?= (date("m") == "11") ? "selected" : "" ?>>Noviembre</option>
                  <option value="12" <?= (date("m") == "12") ? "selected" : "" ?>>Diciembre</option>
                </select>
                <span class="input-group-addon label-year-agenda">Año:</span>
                <select class="form-control filter-year" id="year_search">
                  <option selected="true" disabled="true">Seleccionar</option>
                  <?php foreach ($years as $key => $row) { ?>
                    <option value="<?= $row->year ?>" <?= ($key == "0") ? "selected" : "" ?>><?= $row->year ?></option>
                  <?php } ?>
                </select>
                <span class="input-group-btn box-search-dependencia">
                  <button class="btn btn-search-agenda" style="color: white;">Buscar</button>
                </span>
            </div>
          </div>
      </div>
      <div class="col-lg-8 col-md-offset-2 box-shadow-agenda box-resultado-agenda">
        <p class="text-muted" style="margin-top: 30px;">Utilice los filtros para realizar búsqueda.</p>
      </div>
    </section>
</section>
