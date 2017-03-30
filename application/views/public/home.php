<div class="text-center box-search vcenter">
  <button class="btn btn-youtube-home"><i class="fa fa-youtube" aria-hidden="true"></i></button>
  <button class="btn btn-twitter-home"><i class="fa fa-twitter" aria-hidden="true"></i></button>
  <button class="btn btn-facebook-home"><i class="fa fa-facebook" aria-hidden="true"></i></button>
  <div class="col-lg-6 col-md-offset-2">
    <div class="input-group">
      <input type="text" class="form-control input-lg search-main">
      <span class="input-group-btn">
        <button class="btn btn-secondary btn-orange btn-lg" type="button">
          <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
        </button>
      </span>
    </div>
  </div>
  <div class="box-menu-side col-lg-3" style="line-height: 1.42857143;">
    <h2 class="title-sisgedo">Sistema de Gestión Documentaria</h2>
    <p>Puedes encontrar cualquier expediente pinchando en el siguiente botón</p>
    <a href="http://sisgedo2.regionlima.gob.pe/sisgedonew/app/main.php?_op=1I&_type=L&_nameop=Login%20de%20Acceso" target="_blank" class="btn btn-sisgedo" >SISGEDO</a>
    <hr>
    <h2 class="title-sisgedo">Correo Insitucional sólo para personal</h2>
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

<section class="container box-noticias-eventos">
<div class="col-lg-12 no-padding">
  <div class="col-lg-5 box-noticias">
    <h3>Noticias</h3>
    <div id="carousel-noticias" class="carousel slide carousel-noticias" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#carousel-noticias" data-slide-to="0" class="active"></li>
        <li data-target="#carousel-noticias" data-slide-to="1"></li>
        <li data-target="#carousel-noticias" data-slide-to="2"></li>
        <li data-target="#carousel-noticias" data-slide-to="3"></li>
        <li data-target="#carousel-noticias" data-slide-to="4"></li>
      </ol>

      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
        <div class="item active">
          <img src="<?= asset_url() ?>img/carousel/agricultura01.jpg" alt="...">
          <div class="carousel-caption">
            <h4>NOTICIA 1</h4>
            <?= limit_to($label, 120) ?>...
          </div>
        </div>
        <div class="item">
          <img src="<?= asset_url() ?>img/carousel/agricultura02.jpg" alt="...">
          <div class="carousel-caption">
            <h4>NOTICIA 2</h4>
            <?= limit_to($label, 120) ?>...
          </div>
        </div>
        <div class="item">
          <img src="<?= asset_url() ?>img/carousel/agricultura03.jpg" alt="...">
          <div class="carousel-caption">
            <h4>NOTICIA 3</h4>
            <?= limit_to($label, 120) ?>...
          </div>
        </div>
        <div class="item">
          <img src="<?= asset_url() ?>img/carousel/agricultura04.jpg" alt="...">
          <div class="carousel-caption">
            <h4>NOTICIA 4</h4>
            <?= limit_to($label, 120) ?>...
          </div>
        </div>
        <div class="item">
          <img src="<?= asset_url() ?>img/carousel/agricultura05.jpg" alt="...">
          <div class="carousel-caption">
            <h4>NOTICIA 5</h4>
            <?= limit_to($label, 120) ?>...
          </div>
        </div>
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

        <a href="#" class="carousel-link"><b>Ver mas</b></a>
      </p>
      </div>
    </div>
  </div>
  <div class="col-lg-5 box-eventos">
    <h3>Eventos</h3>
    <div id="carousel-eventos" class="carousel slide carousel-eventos" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#carousel-eventos" data-slide-to="0" class="active"></li>
        <li data-target="#carousel-eventos" data-slide-to="1"></li>
        <li data-target="#carousel-eventos" data-slide-to="2"></li>
        <li data-target="#carousel-eventos" data-slide-to="3"></li>
        <li data-target="#carousel-eventos" data-slide-to="4"></li>
      </ol>

      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
        <div class="item active">
          <img src="<?= asset_url() ?>img/carousel/agricultura01.jpg" alt="...">
          <div class="carousel-caption">
            <h4>EVENTO 1</h4>
            <?= limit_to($label, 120) ?>...
          </div>
        </div>
        <div class="item">
          <img src="<?= asset_url() ?>img/carousel/agricultura02.jpg" alt="...">
          <div class="carousel-caption">
            <h4>EVENTO 2</h4>
            <?= limit_to($label, 120) ?>...
          </div>
        </div>
        <div class="item">
          <img src="<?= asset_url() ?>img/carousel/agricultura03.jpg" alt="...">
          <div class="carousel-caption">
            <h4>EVENTO 3</h4>
            <?= limit_to($label, 120) ?>...
          </div>
        </div>
        <div class="item">
          <img src="<?= asset_url() ?>img/carousel/agricultura04.jpg" alt="...">
          <div class="carousel-caption">
            <h4>EVENTO 4</h4>
            <?= limit_to($label, 120) ?>...
          </div>
        </div>
        <div class="item">
          <img src="<?= asset_url() ?>img/carousel/agricultura05.jpg" alt="...">
          <div class="carousel-caption">
            <h4>EVENTO 5</h4>
            <?= limit_to($label, 120) ?>...
          </div>
        </div>
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

        <a href="#" class="carousel-link"><b>Ver mas</b></a>
      </p>
      </div>
    </div>
  </div>
</div>