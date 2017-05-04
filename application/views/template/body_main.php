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
      <button class="btb pull-right" style="margin-right: 4px; margin-left: 10px; border: none; padding: 2px 10px; background: #9e9e9e; font-family: Verdana, sans-serif;"><a href="<?= base_url('logout') ?>" style="text-decoration: none;"><i class="fa fa-power-off" aria-hidden="true"></i> Cerrar sesión</a></button>
          <span class="pull-right" style="border: none; padding: 2px 10px; background: rgba(14,130,64, 1); color: white; font-family: Verdana, sans-serif;"><i class="fa fa-user" aria-hidden="true"></i> Bienvenido, <b><a href="<?= base_url() . 'cambiar_clave' ?>"><?= $this->session->userdata("usuario")->nomb_usu ?></b></a></span>
      <?php
        } else { 
      ?>
          <button class="btb pull-right" style="margin-right: 4px; border: none; padding: 2px 10px; background: rgba(14,130,64, 1); font-family: Verdana, sans-serif;"><a href="<?= base_url('login') ?>" style="text-decoration: none;"><i class="fa fa-user" aria-hidden="true"></i> Intranet - Login</a></button>
      <?php
        } 
      ?>
    </div>
    <div class="main-background" style="background-image: url('<?= asset_url() ?>img/background/granjero02.jpg');">
      <div class="box-logo">
        <a id="b" href="<?= base_url() ?>" class="navbar-brand-header">
          <img src="<?= asset_url() ?>img/brand/logo.png">
        </a>
        <a href="http://www.regionlima.gob.pe" target="_blank" class="navbar-brand-header">
          <img src="<?= asset_url() ?>img/brand/logo4.png">
        </a>
        <a href="<?= base_url() . 'transparencia' ?>" class="navbar-brand-header pull-right" style="padding-top: 0px; position: absolute; right: 15px;">
          <img src="<?= asset_url() ?>img/brand/ptes.jpg">
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
                <li>
                  <a href="<?= base_url('informacion-agraria') ?>">Información agraria</a>
                </li>
                <li>
                  <a href="<?= base_url('direccion-oficina') ?>">Dirección y Oficinas</a>
                </li>
                <li>
                  <a href="<?= base_url('agencias-agrarias') ?>">Agencias agrarias</a>
                </li>
                <li>
                  <a href="<?= base_url('institucional') ?>">Directorio Institucional</a>
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
              <a class="item-menu" href="<?= base_url('agenda/publico') ?>">Agenda</a>
            </li>
            <li>
              <a class="item-menu" href="http://corepo.dral.gob.pe/">COREPO</a>
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
    <footer class="well box-footer" style="padding: 0px;">
      <div class="col-lg-12 no-padding">
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
                  E-mail: info_publica@dral.gob.pe
                </p>
              </div>
          </div>
          <div class="col-lg-12 text-center" style="padding-bottom: 30px;">
            <hr>
            <p>© 2017 - Dirección Regional de Agricultura de Lima</p>
            <p><b>Dirección: </b>Av. Augusto B. Leguía 3° Cuadra S/N Huacho</p>
            <p><b>Teléfono: </b> 2323402 / 2323869</p>
            <p><b>E-mail: </b> webmaster@dral.gob.pe</p>
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

    </script>       
    <?php 
      foreach ($scripts as $script) {
        echo $script; 
      } 
    ?>
  </body>
</html>