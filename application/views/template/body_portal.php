<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <base href="/">
    <title>DRAL - Dirección Regional de Agricultura Lima</title>
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
    </script>       
    <?php 
      foreach ($scripts as $script) {
        echo $script; 
      } 
    ?>
  </body>
</html>