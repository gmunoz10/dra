<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <base href="/">
    <title>Dirección Regional de Agricultura Lima - DRAL</title>
    <meta name="description" content="Dirección Regional de Agricultura Lima">
    <meta name="fragment" content="!">
    
    <meta property="og:title" content="<?= (isset($title) && $title != "") ? $title : "DRAL" ?>" />
    <meta property="og:description" content="<?= (isset($description) && $description != "") ? $description : "Dirección Regional de Agricultura Lima" ?>" />
    <meta property="og:url" content="<?= base_url(uri_string()); ?>" />
    <meta property="og:image" content="<?= (isset($img) && $img != "") ? $img : asset_url() . 'img/brand/logo-200.jpg' ?>" />
    <meta property="og:locale" content="es_ES" />
    <meta property="og:site_name" content="Dirección Regional de Agricultura Lima" />

    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="@DRAL59954891" />
    <meta name="twitter:title" content="<?= (isset($title) && $title != "") ? $title : "DRAL" ?>" />
    <meta name="twitter:description" content="<?= (isset($description) && $description != "") ? $description : "Dirección Regional de Agricultura Lima" ?>" />
    <meta name="twitter:image" content="<?= (isset($img) && $img != "") ? $img : asset_url() . 'img/brand/logo-200.jpg' ?>" />

    <meta property="fb:app_id" content="1327135627399921" />
    <meta property="fb:pages" content="182498662244220" />

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
      <button class="btn pull-right" style="margin-right: 4px; margin-left: 10px; border: none; padding: 2px 10px; background: #9e9e9e; font-family: Verdana, sans-serif;"><a href="<?= base_url('logout') ?>" style="text-decoration: none;"><i class="fa fa-power-off" aria-hidden="true"></i> Cerrar sesión</a></button>
          <span class="pull-right" style="border: none; padding: 2px 10px; background: rgba(14,130,64, 1); color: white; font-family: Verdana, sans-serif;"><i class="fa fa-user" aria-hidden="true"></i> Bienvenido, <b><a href="<?= base_url() . 'cambiar_clave' ?>"><?= $this->session->userdata("usuario")->nomb_usu ?></b></a></span>
      <?php
        } else { 
      ?>
          <button class="btn pull-right sesion-login" style="margin-right: 4px; border: none; padding: 2px 10px; background: rgba(14,130,64, 1); font-family: Verdana, sans-serif;"><a href="<?= base_url('login') ?>" style="text-decoration: none;"><i class="fa fa-user" aria-hidden="true"></i> Intranet</a></button>
      <?php
        } 
      ?>
    </div>
    <div class="main-background" style="background-image: url('<?= asset_url() ?>img/background/granjero02.jpg');">
      <div class="box-logo text-center">
        <a id="b" href="<?= base_url() ?>" class="navbar-brand-header">
          <img class="logo-01" src="<?= asset_url() ?>img/brand/logo.png">
        </a>
        <a href="<?= base_url() . 'transparencia' ?>" class="navbar-brand-header pull-right pte-res" style="padding-top: 0px; position: absolute; right: 15px;">
          <img class="logo-02" src="<?= asset_url() ?>img/brand/ptes.jpg">
        </a>
      </div>
      <nav class="navbar navbar-inverse navbar-group navbar-main-group">
        <div class="container-fluid no-padding">
          <div class="navbar-header navbar-static-top nav-main">
            <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#main-menu" aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
          </div>
          <div class="collapse navbar-collapse" id="main-menu">
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
                    <a href="<?= base_url('funciones') ?>">Funciones</a>
                  </li>
                  <li>
                    <a href="<?= base_url('temas-agrarios') ?>">Temas agrarios</a>
                  </li>
                  <li>
                    <a href="<?= base_url('produccion') ?>">Producción agrícola</a>
                  </li>
                  <li>
                    <a href="<?= base_url('direccion-oficina') ?>">Dirección y Oficinas</a>
                  </li>
                  <li>
                    <a href="<?= base_url('agencias-agrarias') ?>">Agencias agrarias</a>
                  </li>
                </ul>
              </li>
              <li>
                <a class="item-menu" href="<?= base_url('agenda/publico') ?>">Agenda</a>
              </li>
              <li>
                <a class="item-menu" href="<?= base_url('galeria') ?>">Galería</a>
              </li>
              <li>
                <a class="item-menu" href="http://corepo.dral.gob.pe/">COREPO</a>
              </li>
              <li>
                <a class="item-menu" href="<?= base_url('noticia/page') ?>">Noticias</a>
              </li>
              <li>
                <a class="item-menu" href="<?= base_url('evento/page') ?>">Eventos</a>
              </li>
              <li>
                <a class="item-menu" href="<?= base_url('contacto') ?>">Contáctenos</a>
              </li>
              <?php
                if ($this->session->userdata("usuario")) {
              ?>
              <li class="dropdown">
                <a class="item-menu dropdown-toggle" data-toggle="dropdown">Operaciones</a>
                <ul class="dropdown-menu no-padding">
                  <?php if (check_permission(BUSCAR_ROL)) { ?>
                    <li><a href="<?= base_url('rol') ?>">Roles</a></li>
                  <?php } ?>
                  <?php if (check_permission(BUSCAR_CUENTA)) { ?>
                    <li><a href="<?= base_url('usuario') ?>">Cuentas de acceso</a></li>
                  <?php } ?>
                  <?php if (check_permission(BUSCAR_GRUPO_RESOLUCION)) { ?>
                    <li><a href="<?= base_url('grupo_resolucion') ?>">Grupos de resolución</a></li>
                  <?php } ?>
                  <?php if (check_permission(BUSCAR_RESOLUCION)) { ?>
                    <li><a href="<?= base_url('resolucion') ?>">Resoluciones</a></li>
                  <?php } ?>
                  <?php if (check_permission(BUSCAR_GRUPO_DIRECTIVA)) { ?>
                    <li><a href="<?= base_url('grupo_directiva') ?>">Grupos de directiva</a></li>
                  <?php } ?>
                  <?php if (check_permission(BUSCAR_DIRECTIVA)) { ?>
                    <li><a href="<?= base_url('directiva') ?>">Directivas</a></li>
                  <?php } ?>
                  <?php if (check_permission(BUSCAR_GRUPO_PAC)) { ?>
                    <li><a href="<?= base_url('grupo_pac') ?>">Grupos de PAC</a></li>
                  <?php } ?>
                  <?php if (check_permission(BUSCAR_PAC)) { ?>
                    <li><a href="<?= base_url('pac') ?>">PAC</a></li>
                  <?php } ?>
                  <?php if (check_permission(BUSCAR_GRUPO_DECLARACION_JURADA)) { ?>
                    <li><a href="<?= base_url('grupo_declaracion_jurada') ?>">Grupos de declaración jurada</a></li>
                  <?php } ?>
                  <?php if (check_permission(BUSCAR_DECLARACION_JURADA)) { ?>
                    <li><a href="<?= base_url('declaracion_jurada') ?>">Declaraciones juradas</a></li>
                  <?php } ?>
                  <?php if (check_permission(BUSCAR_DEPENDENCIA)) { ?>
                    <li><a href="<?= base_url('dependencia') ?>">Dependencias</a></li>
                  <?php } ?>
                  <?php if (check_permission(BUSCAR_AGENDA)) { ?>
                    <li><a href="<?= base_url('agenda') ?>">Agenda</a></li>
                  <?php } ?>
                  <?php if (check_permission(BUSCAR_NOTICIA)) { ?>
                    <li><a href="<?= base_url('noticia') ?>">Noticia</a></li>
                  <?php } ?>
                  <?php if (check_permission(BUSCAR_NOTICIA)) { ?>
                    <li><a href="<?= base_url('evento') ?>">Evento</a></li>
                  <?php } ?>
                  <?php if (check_permission(BUSCAR_ALBUM_IMAGEN)) { ?>
                    <li><a href="<?= base_url('galeria/admin') ?>">Galería</a></li>
                  <?php } ?>
                  <?php if (check_permission(BUSCAR_TEMA_AGRARIO)) { ?>
                    <li><a href="<?= base_url('tema_agrario') ?>">Temas agrarios</a></li>
                  <?php } ?>
                  <?php if (check_permission(BUSCAR_EMPLEADO)) { ?>
                    <li><a href="<?= base_url('empleado') ?>">Empleados</a></li>
                  <?php } ?>
                  <?php if (check_permission(BUSCAR_VISITA)) { ?>
                    <li><a href="<?= base_url('visita') ?>">Visitas</a></li>
                  <?php } ?>
                  <?php if (check_permission(BUSCAR_COMISION)) { ?>
                    <li><a href="<?= base_url('comision') ?>">Comisiones</a></li>
                  <?php } ?>
                  <?php if (check_permission(BUSCAR_ASISTENCIA)) { ?>
                    <li><a href="<?= base_url('asistencia') ?>">Asistencias</a></li>
                  <?php } ?>
                </ul>
              </li>
              <?php
                }
              ?>
              <li class="divider-vertical"></li>
            </ul>
          </div>
        </div>
      </nav>

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
    <footer class="well box-footer" style="padding: 0px;">
      <div class="col-lg-12 no-padding box-external">
        <div class="col-lg-2 no-padding" style="height: 120px; background-color: #f5f5f5; z-index: 1;">
        </div>
        <div id="box_move" class="col-lg-8 no-padding" style="padding: 15px; height: 120px; position: relative;">
          <a class="img-aus-01" data-pos="0" href="http://www.peru.gob.pe/" target="_blank" style="position: absolute; left: 0px;">
            <img src="<?= asset_url() ?>img/externas/01.png">
          </a>
          <a class="img-aus-02" data-pos="140" href="http://spij.minjus.gob.pe/" target="_blank" style="position: absolute; left: 140px;">
            <img src="<?= asset_url() ?>img/externas/02.png">
          </a>
          <a class="img-aus-03" data-pos="280" href="http://www.pcm.gob.pe/" target="_blank" style="position: absolute; left: 280px;">
            <img src="<?= asset_url() ?>img/externas/03.png">
          </a>
          <a class="img-aus-04" data-pos="420" href="http://www.ongei.gob.pe/" target="_blank" style="position: absolute; left: 420px;">
            <img src="<?= asset_url() ?>img/externas/04.png">
          </a>
          <a class="img-aus-05" data-pos="560" href="http://www.mef.gob.pe/DGPM/snipnet.php" target="_blank" style="position: absolute; left: 560px;">
            <img src="<?= asset_url() ?>img/externas/05.png">
          </a>
          <a class="img-aus-06" data-pos="700" href="http://www.comprasestatales.org/index2.php?Itemid=66" target="_blank" style="position: absolute; left: 700px;">
            <img src="<?= asset_url() ?>img/externas/06.png">
          </a>
          <a class="img-aus-07" data-pos="840" href="http://dntdt.pcm.gob.pe/" target="_blank" style="position: absolute; left: 840px;">
            <img src="<?= asset_url() ?>img/externas/07.png">
          </a>
          <a class="img-aus-08" data-pos="980" href="https://www.senasa.gob.pe/senasa/" target="_blank" style="position: absolute; left: 980px;">
            <img src="<?= asset_url() ?>img/externas/08.png">
          </a>
          <a class="img-aus-09" data-pos="1120" href="http://www.agrorural.gob.pe/" target="_blank" style="position: absolute; left: 1120px;">
            <img src="<?= asset_url() ?>img/externas/09.png">
          </a>
          <a class="img-aus-10" data-pos="1260" href="http://www.minagri.gob.pe/" target="_blank" style="position: absolute; left: 1260px;">
            <img src="<?= asset_url() ?>img/externas/10.png">
          </a>
          <a class="img-aus-11" data-pos="1400" href="http://www.lamolina.edu.pe/" target="_blank" style="position: absolute; left: 1400px;">
            <img src="<?= asset_url() ?>img/externas/11.png">
          </a>
          <a class="img-aus-12" data-pos="1540" href="http://www.caritas.org.pe/" target="_blank" style="position: absolute; left: 1540px;">
            <img src="<?= asset_url() ?>img/externas/12.png">
          </a>
          <a class="img-aus-13" data-pos="1680" href="http://www.minam.gob.pe/" target="_blank" style="position: absolute; left: 1680px;">
            <img src="<?= asset_url() ?>img/externas/13.png">
          </a>
        </div>
        <div class="col-lg-2 no-padding" style="height: 120px; background-color: #f5f5f5; z-index: 1;">
        </div>
      </div>
      <section class="container">
        <div class="row">
          <div class="col-lg-4 no-padding">
            <!--
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
            -->
            <div class="col-lg-12 no-padding">
              <h3>Direccionar a</h3>
              <ul class="links-direcciones">
                <li><a href="<?= base_url() ?>">Inicio</a></li>
                <li><a href="<?= base_url('noticia/page') ?>">Noticias</a></li>
                <li><a href="<?= base_url('evento/page') ?>">Eventos</a></li>
                <li><a href="<?= base_url('vision-mision') ?>">Visión y misión</a></li>
                <li><a href="<?= base_url('direccion-oficina') ?>">Dirección y oficinas</a></li>
                <li><a href="<?= base_url('agencias-agrarias') ?>">Agencias agrarias</a></li>
                <li><a href="<?= base_url('transparencia') ?>">Transparencia</a></li>
                <li><a href="http://sisgedo2.regionlima.gob.pe/sisgedonew/app/main.php?_op=1I&_type=L&_nameop=Login%20de%20Acceso" target="_blank">SISGEDO</a></li>
                <li><a href="http://corepo.dral.gob.pe/" target="_blank">COREPO</a></li>
                <li><a href="http://webmail.dral.gob.pe" target="_blank">Webmail</a></li>
                <li><a href="<?= base_url('agenda') ?>">Agenda</a></li>
                <li><a href="<?= base_url('galeria') ?>">Galería</a></li>
                <li><a href="<?= base_url('contacto') ?>">Contáctenos</a></li>
              </ul>
            </div>
          </div>
          <div class="col-lg-4">
              <h3 class="ayuda" class="no-margin">Informaciones</h3>
              <ul class="links-direcciones">
                <li><a href="<?= base_url('temas-agrarios') ?>">Temas agrarios</a></li>
                <li><a href="<?= base_url('informacion-agraria') ?>">Información agraria</a></li>
                <li><a href="<?= base_url('competitividad-negocios') ?>">Competividad y Negocios Agrarios</a></li>
              </ul>
              <h3 class="web-recomendadas" class="no-margin">Webs recomendadas</h3>
              <ul class="links-direcciones">
                <li><a href="http://www.regionlima.gob.pe/" target="_blank">www.regionlima.gob.pe</a></li>
                <li><a href="http://www.munihuacho.gob.pe/" target="_blank">www.munihuacho.gob.pe</a></li>
              </ul>
          </div>
          <div class="col-lg-4">
             <h3 class="contacto" class="no-margin">Video</h3>
             <div id="player"></div>
             <button class="btn btn-danger"><a href="https://www.youtube.com/channel/UCk1ZPrg8G-hMKDcT8Rk6HJg/videos" style="color: white;" target="_blank">Ver más videos</a></button>
          </div>
          <hr>
        </div>
      </section>
          <div class="col-lg-12 text-center footer-info" style="margin-top: 0px; padding-bottom: 30px;padding-top: 10%;color: white;padding-left: 0px;background-repeat: no-repeat !important;background-position-x: center !important;background-size: cover !important;background: url(<?= asset_url() ?>img/background/piepagina.jpg);">
            <br>
            <br>
            <p class="text-center"><img src="<?= asset_url() ?>img/brand/logo-icon-blank.png"></p>
            <p>© 2017 - Dirección Regional de Agricultura de Lima</p>
            <p><b>Dirección: </b>Av. Augusto B. Leguía 3° Cuadra S/N Huacho</p>
            <p><b>Teléfono: </b> 2323402 / 2323869</p>
            <p><b>E-mail: </b> webmaster@dral.gob.pe</p>
            <br>
            <?php if ($this->session->userdata("usuario") && $this->session->userdata("usuario")->codi_rol == "1") { ?>
              <div class="col-lg-2 col-md-offset-5" style="background: #eabf21;color: darkgoldenrod;border-radius: 15px;padding-top: 7px;padding-bottom: 5px;border: 1px solid darkgoldenrod;">
                <h1 class="no-margin" style="font-size: 18px;">
                  <i class="fa fa-globe" aria-hidden="true"></i>
                  <span style="font-size: inherit;"><?= $this->mod_counter->get_count() ?></span>
                </h1>
                <p class="no-margin"><b>Contador de visitas</b></p>
              </div>
            <?php } ?>
          </div>
          <!-- 
          <section id="counter" class="counter">
            <div class="main_counter_area">
                <div class="overlay p-y-3">
                    <div class="container">
                        <div class="row">
                            <div class="main_counter_content text-center white-text wow fadeInUp text-center">
                                <div class="col-md-3">
                                    <div class="single_counter p-y-2 m-t-1">
                                        <i class="fa fa-user m-b-1"></i>
                                        <h2 class="statistic-counter">100</h2>
                                        <p>Visitas</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </section>
          -->
    </footer>

    <script>
      var tag = document.createElement('script');

      tag.src = "https://www.youtube.com/iframe_api";
      var firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

      var player;
      function onYouTubeIframeAPIReady() {
        player = new YT.Player('player', {
          height: '200',
          width: 'auto',
          videoId: '<?= json_decode(file_get_contents('https://www.googleapis.com/youtube/v3/search?order=date&part=snippet&channelId=UCk1ZPrg8G-hMKDcT8Rk6HJg&key=AIzaSyCn7DuplyahzwHTAxc0EHQJ_Wd8a0FQpvk'))->items[0]->id->videoId ?>',
          events: {
            //'onReady': onPlayerReady,
            //'onStateChange': onPlayerStateChange
          }
        });
      }
      function onPlayerReady(event) {
        event.target.playVideo();
      }
      var done = false;
      function onPlayerStateChange(event) {
        if (event.data == YT.PlayerState.PLAYING && !done) {
          setTimeout(stopVideo, 6000);
          done = true;
        }
      }
      function stopVideo() {
        player.stopVideo();
      }
    </script>
    <script src="<?= asset_url() ?>plugins/jquery/dist/jquery.js"></script>        
    <script src="<?= asset_url() ?>plugins/bootstrap/dist/js/bootstrap.js"></script>        
    <script src="<?= asset_url() ?>plugins/toastr/toastr.min.js"></script>   
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Counter-Up/1.0.0/jquery.counterup.min.js"></script>
    <script>
        // App data
        var base_url = '<?= base_url() ?>';

        toastr.options = {
            closeButton: true,
            progressBar: false,
            showMethod: 'slideDown',
            timeOut: 3000
        };

        function show_toast(type, message) {
          toastr[type](message);
        }

        if ($("#ci_message").length) {
            show_toast($("#ci_type").val(), $("#ci_message").val());
        }

        function toMove(element) {
          var left = parseInt(element.data("pos"));
          if (left === -124) {
            left = parseInt($("#box_move").width()+870);
          }
          left--;
          if (left > parseInt($("#box_move").width())+30) {
            element.hide();
          } else {
            element.show();
          }
          element.data("pos", left);
          var _element = element;
          element.animate({"left": left+"px"}, 1, function() {
            toMove(_element);
          });
        }


        $(function() {

            toMove($(".img-aus-01"));
            toMove($(".img-aus-02"));
            toMove($(".img-aus-03"));
            toMove($(".img-aus-04"));
            toMove($(".img-aus-05"));
            toMove($(".img-aus-06"));
            toMove($(".img-aus-07"));
            toMove($(".img-aus-08"));
            toMove($(".img-aus-09"));
            toMove($(".img-aus-10"));
            toMove($(".img-aus-11"));
            toMove($(".img-aus-12"));
            toMove($(".img-aus-13"));

        });

        jQuery('.statistic-counter').counterUp({
            delay: 10,
            time: 2000
        });

    </script>       
    <?php 
      foreach ($scripts as $script) {
        echo $script; 
      } 
    ?>
  </body>
</html>