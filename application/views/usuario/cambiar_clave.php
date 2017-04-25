<div class="container-page-header" style="height: auto; padding-bottom: 50px;">
	<section>
		<div class="row">
			<div class="box-content box-bold col-md-3 col-md-offset-4" style="line-height: 1.42857143;">
			    <h2 class="title-sisgedo">Cambiar contraseña</h2>
				  <hr>
          <form id="form_usuario" method="post" action="<?= base_url() . 'update_cont' ?>">
            <div class="form-group">
                <label>Contraseña actual*: </label>
                <input type="password" class="form-control" name="acon_usu">
            </div>
            <div class="form-group">
                <label>Contraseña*: </label>
                <input type="password" class="form-control" name="cont_usu">
            </div>
            <div class="form-group">
                <label>Confirmar contraseña*: </label>
                <input type="password" class="form-control" name="ccon_usu">
            </div>
            <button id="submit_usuario" type="submit" class="btn btn-success pull-right" style="margin-top: 20px;">Cambiar</button>
          </form>
			</div>
		</div>
	</section>
</div>