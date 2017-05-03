<div class="container-page-header" style="background-image: url('<?= asset_url() ?>img/background/contacto.jpg');">
    <button class="btn btn-youtube-home"><i class="fa fa-youtube" aria-hidden="true"></i></button>
    <button class="btn btn-twitter-home"><i class="fa fa-twitter" aria-hidden="true"></i></button>
    <a class="btn btn-facebook-home" href="https://www.facebook.com/DRALoficial/" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
</div>
<section class="container container-page-inner">
    <section>
      <div class="col-lg-6 col-md-offset-3" style="line-height: 1.42857143;">
        <h3>Contacto <span class="text-muted" style="font-size: 18px;"><i>(info_publica@dral.gob.pe)</i></span></h3>
      	<form method="post" action="<?= base_url() . 'enviar_mensaje' ?>" style="border: 1px solid #9e9e9e; border-radius: 10px; padding: 20px; margin-bottom: 30px; padding-bottom: 45px;">
		  <div class="form-group">
		    <label>Nombre</label>
		    <input name="name" type="text" class="form-control" placeholder="Nombre" required="">
		  </div>
		  <div class="form-group">
		    <label>Correo electrónico</label>
		    <input name="email" type="email" class="form-control" placeholder="Correo electrónico" required="">
		  </div>
		  <div class="form-group">
		    <label>Asunto</label>
		    <input name="asunto" type="text" class="form-control" placeholder="Asunto" required="">
		  </div>
		  <div class="form-group">
		    <label>Mensaje</label>
		    <textarea name="mensaje" class="form-control" name="mensaje" required="" placeholder="Escriba tu mensaje..."></textarea>
		  </div>
		  <button type="submit" class="btn btn-default pull-right">Enviar</button>
		</form>
      </div>
    </section>
</section>
