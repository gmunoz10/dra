<div class="container-page-header" style="background-image: url('<?= asset_url() ?>img/background/contacto.jpg');">
    <button class="btn btn-youtube-home"><i class="fa fa-youtube" aria-hidden="true"></i></button>
    <button class="btn btn-twitter-home"><i class="fa fa-twitter" aria-hidden="true"></i></button>
    <a class="btn btn-facebook-home" href="https://www.facebook.com/DRALoficial/" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
</div>
<section class="container container-page-inner">
    <section>
      <div class="col-lg-6" style="line-height: 1.42857143;">
      	<table style="color: #727171; margin: 0 auto; margin-top: 25px; margin-bottom: 25px;">
			<tr>
				<td>
					<img src="<?= asset_url() ?>img/brand/contacto01.png" height="50">
				</td>
				<td style="padding-left: 15px; font-weight: bold; font-size: 18px;">Ing. Luis Antonio Jiménez Sánchez</td>
			</tr>
			<tr><td colspan="2"  style="height: 20px;"></td></tr>
			<tr>
				<td>
					<img src="<?= asset_url() ?>img/brand/contacto02.png" height="50">
				</td>
				<td style="padding-left: 15px; font-weight: bold; font-size: 18px;">(+51) 01 232-3402</td>
			</tr>
			<tr><td colspan="2"  style="height: 20px;"></td></tr>
			<tr>
				<td>
					<img src="<?= asset_url() ?>img/brand/contacto03.png" height="50">
				</td>
				<td style="padding-left: 15px; font-weight: bold; font-size: 18px;">info_publica@dral.gob.pe</td>
			</tr>
			<tr><td colspan="2"  style="height: 20px;"></td></tr>
			<tr>
				<td>
					<img src="<?= asset_url() ?>img/brand/contacto04.png" height="50">
				</td>
				<td style="padding-left: 15px; font-weight: bold; font-size: 18px;">Av. Augusto B. Leguía s/n - Huacho</td>
			</tr>
			<tr><td colspan="2"  style="height: 20px;"></td></tr>
		</table>
      </div>
      <div class="col-lg-6" style="line-height: 1.42857143;">
      	<h3>Contacto</h3>
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
