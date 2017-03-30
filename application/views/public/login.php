<div class="container-page-header">
    <button class="btn btn-youtube-home"><i class="fa fa-youtube" aria-hidden="true"></i></button>
    <button class="btn btn-twitter-home"><i class="fa fa-twitter" aria-hidden="true"></i></button>
    <button class="btn btn-facebook-home"><i class="fa fa-facebook" aria-hidden="true"></i></button>

    <div class="box-login col-md-4 col-md-offset-4" style="line-height: 1.42857143;">
	    <h2 class="title-sisgedo">Inicio de sesión</h2>
	    <form class="form-correo" method="post" action="<?= base_url('validar_login') ?>">
	      <div class="form-group">
	        <label>Usuario</label>
	        <input name="username" class="form-control" value="<?= (isset($username_login)) ? $username_login : "" ?>" required="">
	      </div>
	      <div class="form-group">
	        <label>Contraseña</label>
	        <input type="password" name="password" class="form-control" required="">
	      </div>
	      <input type="submit" class="btn btn-orange pull-right" value="Entrar" />
	      <br>
	      <br>
	      <?php
		  	if (isset($label_login)) {
		  ?>
	     	<p style="text-align: center;"><span class="label label-<?= $label_login ?>" style="font-size: 90%;"><?= $mensaje_login ?></span></p>
	      <?php
		  	}
		  ?>
	    </form>
	  </div>
</div>