<div class="text-center box-search vcenter">
  <button class="btn btn-youtube-home"><i class="fa fa-youtube" aria-hidden="true"></i></button>
  <button class="btn btn-twitter-home"><i class="fa fa-twitter" aria-hidden="true"></i></button>
  <a class="btn btn-facebook-home" href="https://www.facebook.com/DRALoficial/" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
  <div class="col-lg-6 col-md-offset-2">
    <script>
      (function() {
        var cx = '013980864906967710135:ytegr_r5yni';
        var gcse = document.createElement('script');
        gcse.type = 'text/javascript';
        gcse.async = false;
        gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(gcse, s);
      })();
    </script>
    <div class="input-group" style="width: 100%;">
      <gcse:search></gcse:search>
      <!--
      <span class="input-group-btn">
        <button class="btn btn-secondary btn-orange btn-lg" type="button">
          <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
        </button>
      </span>
      -->
    </div>
      <!--
    <div class="input-group">
      <input type="text" class="form-control input-lg search-main">
      <span class="input-group-btn">
        <button class="btn btn-secondary btn-orange btn-lg" type="button">
          <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
        </button>
      </span>
    </div>
      -->
  </div>
  <div class="box-menu-side col-lg-3" style="line-height: 1.42857143;">
    <h2 class="title-sisgedo">Sistema de Gestión Documentaria</h2>
    <p>Puedes encontrar cualquier expediente pinchando en el siguiente botón</p>
    <a href="http://sisgedo2.regionlima.gob.pe/sisgedonew/app/main.php?_op=1I&_type=L&_nameop=Login%20de%20Acceso" target="_blank" class="btn btn-sisgedo" >SISGEDO</a>
    <hr>
    <h2 class="title-sisgedo">Correo Institucional sólo para personal</h2>
    <form class="form-correo" method="post" action="http://webmail.dral.gob.pe?_task=login" target="_blank">
      <input type="hidden" name="_token" value="rXu2cbeANBQMmyQT0daFlJqDmNKRRB5l">
      <input type="hidden" name="_task" value="login">
      <input type="hidden" name="_action" value="login">
      <input type="hidden" name="_timezone" id="rcmlogintz" value="America/Bogota">
      <input type="hidden" name="_url" id="rcmloginurl" value="_task=login">
      <div class="form-group">
        <label>Correo electrónico</label>
        <input type="email" name="_user" class="form-control" required="">
      </div>
      <div class="form-group">
        <label>Contraseña</label>
        <input type="password" name="_pass" class="form-control" required="">
      </div>
      <input type="submit" class="btn btn-orange pull-right" value="Entrar" />
    </form>
  </div>
</div>

<section class="container box-noticias-eventos" style="line-height: 1.42857143;">
  <div class="col-lg-12 no-padding">
    <div class="col-lg-6 no-padding">
      <div class="box-noticias">
        <h3><a href="<?= base_url() . 'noticia/page' ?>" style="color: #fff;">Noticias</a></h3>
        <div id="carousel-noticias" class="carousel slide carousel-noticias" data-ride="carousel">
          <!-- Indicators -->
          <ol class="carousel-indicators">
            <?php foreach ($noticias as $key => $noticia) { ?>
              <li data-target="#carousel-noticias" data-slide-to="<?= $key ?>" class="<?= ($key == 0) ? "active" : "" ?>"></li>
            <?php } ?>
          </ol>

          <!-- Wrapper for slides -->
          <div class="carousel-inner" role="listbox">
            <?php foreach ($noticias as $key => $noticia) { ?>
              <div data-codi="<?= $noticia->codi_not ?>" class="item <?= ($key == 0) ? "active" : "" ?>">
                <img src="<?= asset_url() ?>noticia/<?= $noticia->imag_not ?>" alt="...">
                <div class="carousel-caption">
                  <h4><?= $noticia->titu_not ?></h4>
                  <?= limit_to(strip_tags($noticia->cont_not), 120) ?>...
                </div>
              </div>
            <?php } ?>
          </div>
          <div class="carousel-more">
          <p class="carousel-share">
            <b><i>Comparte en: </i></b>
            <button type="button" class="btn btn-twitter btn-circle">
              <i class="fa fa-twitter" aria-hidden="true"></i>
            </button>
            <button type="button" class="btn btn-facebook btn-circle">
              <i class="fa fa-facebook" aria-hidden="true"></i>
            </button>
            <button type="button" class="btn btn-document btn-circle">
              <i class="fa fa-file" aria-hidden="true"></i>
            </button>
            <button type="button" class="btn btn-feed btn-circle">
              <i class="fa fa-rss" aria-hidden="true"></i>
            </button>

            <span id="noticia_link" href="#" class="carousel-link" style="cursor: pointer;"><b>Ver mas</b></span>
          </p>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-6 no-padding">
      <div class="box-eventos">
        <h3><a href="<?= base_url() . 'evento/page' ?>" style="color: #fff;">Eventos</a></h3>
        <div id="carousel-eventos" class="carousel slide carousel-eventos" data-ride="carousel">
          <!-- Indicators -->
          <ol class="carousel-indicators">
            <?php foreach ($eventos as $key => $evento) { ?>
              <li data-target="#carousel-eventos" data-slide-to="<?= $key ?>" class="<?= ($key == 0) ? "active" : "" ?>"></li>
            <?php } ?>
          </ol>

          <!-- Wrapper for slides -->
          <div class="carousel-inner" role="listbox">
            <?php foreach ($eventos as $key => $evento) { ?>
              <div data-codi="<?= $evento->codi_eve ?>" class="item <?= ($key == 0) ? "active" : "" ?>">
                <img src="<?= asset_url() ?>evento/<?= $evento->imag_eve ?>" alt="...">
                <div class="carousel-caption">
                  <h4><?= $evento->titu_eve ?></h4>
                  <?= limit_to(strip_tags($evento->cont_eve), 120) ?>...
                </div>
              </div>
            <?php } ?>
          </div>
          <div class="carousel-more">
          <p class="carousel-share">
            <b><i>Comparte en: </i></b>
            <button type="button" class="btn btn-twitter btn-circle">
              <i class="fa fa-twitter" aria-hidden="true"></i>
            </button>
            <button type="button" class="btn btn-facebook btn-circle">
              <i class="fa fa-facebook" aria-hidden="true"></i>
            </button>
            <button type="button" class="btn btn-document btn-circle">
              <i class="fa fa-file" aria-hidden="true"></i>
            </button>
            <button type="button" class="btn btn-feed btn-circle">
              <i class="fa fa-rss" aria-hidden="true"></i>
            </button>

            <span id="evento_link" href="#" class="carousel-link" style="cursor: pointer;"><b>Ver mas</b></span>
          </p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-12 no-padding text-center" style="margin-top: 50px;">
    <div class="col-lg-4">
      <dir class="box-content-o box-bold no-padding" style="margin: 5px;">
        <div class="no-margin" style="padding: 10px; padding-left: 15px; padding-right: 15px; text-align: center; font-weight: bold; background: #eabf21; color: white;">Imagen Institucional</div>
        <br>
        <p class="text-center no-margin" style="padding: 0px 15px;"><b>Res.: </b>Lic. Paola Yuvigsa Vega Muñoz</p>
        <p class="text-center no-margin" style="padding: 0px 15px;"><b>R.P.C.: </b>980542856</p>
        <p class="text-center no-margin" style="padding: 0px 15px;"><b>E-mail: </b>pvega@dral.gob.pe</p>
        <p class="text-center no-margin" style="padding: 0px 15px;"><b>Teléfono: </b>239-3869</p>
        <br>
      </dir>
    </div>
    <div class="col-lg-4">
      <dir class="box-content-o box-bold no-padding" style="margin: 5px;">
        <div class="no-margin" style="padding: 10px; padding-left: 15px; padding-right: 15px; text-align: center; font-weight: bold; background: #eabf21; color: white;">Información Pública</div>
        <br>
        <p class="text-center no-margin" style="padding: 0px 15px;"><b>Res.: </b>Sr. Miguel Ángel Cuadros Huertas</p>
        <p class="text-center no-margin" style="padding: 0px 15px;">RDS N° 0077-2017-GRDE-DRA</p>
        <p class="text-center no-margin" style="padding: 0px 15px;"><b>E-mail:</b> info_publica@dral.gob.pe</p>
        <p class="text-center no-margin" style="padding: 0px 15px;"><b>Teléfono: </b> 239 6421</p>
        <br>
      </dir>
    </div>
    <div class="col-lg-4">
      <dir class="box-content-o box-bold no-padding" style="margin: 5px;">
        <div class="no-margin" style="padding: 10px; padding-left: 15px; padding-right: 15px; text-align: center; font-weight: bold; background: #eabf21; color: white;">Portal de Transparencia</div>
        <br>
        <p class="text-center no-margin" style="padding: 0px 15px;"><b>Res.: </b>Ing. Milagros Angely Cruz Balarezo</p>
        <p class="text-center no-margin">RDS N° 0077-2017-GRDE-DRA</p>
        <p class="text-center no-margin" style="padding: 0px 15px;"><b>E-mail:</b> transparencia@dral.gob.pe</p>
        <p class="text-center no-margin" style="padding: 0px 15px;"><b>Teléfono: </b> 239 6421</p>
        <br>
      </dir>
    </div>
  </div>
</section>


<div class="modal fade" id="modal_aviso" tabindex="-1" data-backdrop="false" data-keyboard="true" role="dialog">
  <div class="modal-dialog" role="document" style="width: 60%; margin-top: 10px;">
    <div class="modal-content box-content box-bold" style="margin-top: 0px;">
      <div class="modal-header" style="padding: 0px;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal_aviso_lbl">Aviso</h4>
      </div>
      <div class="modal-body">
        <img src="<?= asset_url() ?>avisos/06-04-2017.jpg" style="width: 100%;">
      </div>
      <div class="modal-footer">
          <span class="pull-left" style="font-style: italic;">Fecha de publicación: 7 de Marzo del 2017.</span>
      </div>
    </div>
  </div>
</div>
