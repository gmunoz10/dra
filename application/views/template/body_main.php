<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <base href="/">
    <title>DRAL</title>
    <meta name="description" content="DESCRIPTION">
    <meta name="fragment" content="!">

    <link rel="icon" type="image/x-icon" href="<?= asset_url() ?>img/brand/favicon.ico">
    <link rel="shortcut icon" href="<?= asset_url() ?>img/brand/favicon.ico" type="image/x-icon" />

    <link href="<?= asset_url() ?>plugins/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link href="<?= asset_url() ?>plugins/toastr/toastr.min.css" rel="stylesheet">
    <link href="<?= asset_url() ?>plugins/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="<?= asset_url() ?>css/core.css" rel="stylesheet">

    <?php 
      foreach ($styles as $style) {
        echo $style; 
      } 
    ?>
  </head>
  <body>
    <div class="super-header">
      <a href="http://www.regionlima.gob.pe" target="_blank">http://www.regionlima.gob.pe</a>
      <?php
        if ($this->session->userdata("usuario")) {
      ?>
      <button class="btb pull-right" style="margin-right: 4px; margin-left: 10px; border: none; padding: 2px 10px; background: #9e9e9e;"><a href="<?= base_url('logout') ?>" style="text-decoration: none;"><i class="fa fa-power-off" aria-hidden="true"></i> Cerrar sesión</a></button>
          <span class="pull-right" style="border: none; padding: 2px 10px; background: #f60d0d; color: white;"><i class="fa fa-user" aria-hidden="true"></i> Bienvenido, <b><?= $this->session->userdata("usuario")->nomb_usu ?></b></span>
      <?php
        } else { 
      ?>
          <button class="btb pull-right" style="margin-right: 4px; border: none; padding: 2px 10px; background: #f60d0d;"><a href="<?= base_url('login') ?>" style="text-decoration: none;">Webmaster - Login</a></button>
      <?php
        } 
      ?>
    </div>
    <div class="main-background" style="background-image: url('<?= asset_url() ?>img/background/granjero02.jpg');">
      <div class="box-logo">
        <a href="<?= base_url() ?>" class="navbar-brand-header">
          <img src="<?= asset_url() ?>img/brand/logo.png">
        </a>
        <a href="http://www.regionlima.gob.pe" target="_blank" class="navbar-brand-header">
          <img src="<?= asset_url() ?>img/brand/logo4.png">
        </a>
      </div>
      <header class="navbar navbar-inverse navbar-group navbar-main-group">
        <div class="container no-margin">
          <div class="navbar-header navbar-static-top nav-main">
            <button class="navbar-toggle" type="button">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
          </div>
          <ul class="nav navbar-nav navbar-header-menu navbar-left">
            <li>
              <a class="item-menu" href="<?= base_url() ?>">Inicio</a>
            </li>
            <li class="dropdown">
              <a class="item-menu dropdown-toggle" data-toggle="dropdown">Nosotros</a>
              <ul class="dropdown-menu no-padding">
                <li>
                  <a href="<?= base_url('vision-mision') ?>">Visión y Misión</a>
                </li>
                <li>
                  <a href="<?= base_url('temas-agrarios') ?>">Temas agrarios</a>
                </li>
                <li class="dropdown-submenu no-padding">
                  <a tabindex="-1">Institucional</a>
                  <ul class="dropdown-menu no-padding">
                    <li>
                      <a href="<?= base_url('direccion-oficina') ?>">Dirección y oficinas</a>
                    </li>
                    <li>
                      <a href="<?= base_url('agencias-agrarias') ?>">Agencias agrarias</a>
                    </li>
                  </ul>
                </li>
              </ul>
            </li>
            <li>
              <a class="item-menu" href="<?= base_url('contacto') ?>">Contáctenos</a>
            </li>
            <li>
              <a class="item-menu" href="<?= base_url('galeria') ?>">Galería</a>
            </li>
            <li>
              <a class="item-menu" href="<?= base_url('agenda') ?>">Agenda</a>
            </li>
            <li>
              <a class="item-menu" href="<?= base_url('transparencia') ?>">Transparencia</a>
            </li>
            <?php
              if ($this->session->userdata("usuario")) {
            ?>
            <li class="dropdown">
              <a class="item-menu dropdown-toggle" data-toggle="dropdown">Operaciones</a>
              <ul class="dropdown-menu no-padding">
                <?php if (check_permission(BUSCAR_CUENTA)) { ?>
                  <li><a href="<?= base_url('usuario') ?>">Cuentas de acceso</a></li>
                <?php } ?>
              </ul>
            </li>
            <?php
              }
            ?>
            <li class="divider-vertical"></li>
          </ul>
        </div>
      </header>

      <section class="content">
        
        <?php if ($this->session->userdata('ci_message_system') != '') { ?>
          <input type="hidden" id="ci_type" value="<?= $this->session->userdata('ci_message_system')["type"] ?>">
          <input type="hidden" id="ci_message" value="<?= $this->session->userdata('ci_message_system')["message"] ?>">
        <?php $this->session->set_userdata('ci_message_system', ''); } ?>

        <?= $content ?>
      
      </section>
      <br>
      <br>
    </div>
    <footer class="well box-footer">
      <section class="container">
        <div class="row">
          <div class="col-lg-4 no-padding">
            <div class="col-lg-9 no-padding">
              <div class="input-group">
                <input type="text" class="form-control input-gray-search field-flat" placeholder="Buscar">
                <span class="input-group-btn">
                  <button class="btn btn-secondary btn-gray-search field-flat" type="button">
                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                  </button>
                </span>
              </div>
            </div>
            <div class="col-lg-12 no-padding">
              <h3>Direccionar a</h3>
              <ul class="links-direcciones">
                <li><a href="<?= base_url() ?>">Inicio</a></li>
                <li><a href="<?= base_url('vision-mision') ?>">Visión y misión</a></li>
                <li><a href="<?= base_url('temas-agrarios') ?>">Temas agrarios</a></li>
                <li><a href="<?= base_url('direccion-oficina') ?>">Dirección y oficinas</a></li>
                <li><a href="<?= base_url('agencias-agrarias') ?>">Agencias agrarias</a></li>
                <li><a href="<?= base_url('transparencia') ?>">Transparencia</a></li>
                <li><a href="http://sisgedo2.regionlima.gob.pe/sisgedonew/app/main.php?_op=1I&_type=L&_nameop=Login%20de%20Acceso" target="_blank">SISGEDO</a></li>
                <li><a href="http://webmail.dral.gob.pe" target="_blank">Webmail</a></li>
                <li><a href="<?= base_url('agenda') ?>">Agenda</a></li>
                <li><a href="<?= base_url('galeria') ?>">Galería</a></li>
                <li><a href="<?= base_url('contacto') ?>">Contáctenos</a></li>
              </ul>
            </div>
          </div>
          <div class="col-lg-4">
            <h3 class="web-recomendadas" class="no-margin">Webs recomendadas</h3>
              <ul class="links-direcciones">
                <li><a href="http://www.regionlima.gob.pe/" target="_blank">www.regionlima.gob.pe</a></li>
                <li><a href="http://www.munihuacho.gob.pe/" target="_blank">www.munihuacho.gob.pe</a></li>
              </ul>
             <h3 class="ayuda" class="no-margin">Ayuda</h3>
              <ul class="links-direcciones">
                <li><a href="#">A dónde llamar</a></li>
                <li><a href="#">Qué buscas</a></li>
              </ul>
          </div>
          <div class="col-lg-4">
             <h3 class="contacto" class="no-margin">Contacto</h3>
            <div class="box-contacto-footer">
              <p>
                Gobierno Regional de Lima
                <br>
                Dirección Regional de Agricultura
                <br>
                Av. Augusto B. Leguía s/n - Huacho
                <br>
                E-mail: dra_lima@minag.gob.pe
              </p>
            </div>
          </div>
        </div>
      </section>
    </footer>

    <script src="<?= asset_url() ?>plugins/jquery/dist/jquery.js"></script>        
    <script src="<?= asset_url() ?>plugins/bootstrap/dist/js/bootstrap.js"></script>        
    <script src="<?= asset_url() ?>plugins/toastr/toastr.min.js"></script>   
    <script>
        // App data
        var base_url = '<?= base_url() ?>';

        toastr.options = {
            closeButton: true,
            progressBar: false,
            showMethod: 'slideDown',
            timeOut: 3000
        };
        if ($("#ci_message").length) {
            toastr[$("#ci_type").val()]($("#ci_message").val());
        }
    </script>       
    <?php 
      foreach ($scripts as $script) {
        echo $script; 
      } 
    ?>
  </body>
</html>