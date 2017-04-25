<div class="container-page-header" style="height: auto; padding-bottom: 50px;">
	<section>
		<div class="row">
			<div class="box-content col-md-8 col-md-offset-2" style="line-height: 1.42857143;">
			    <h2 class="title-sisgedo">Cuentas de acceso</h2>
                <?php if(check_permission(REGISTRAR_CUENTA)) { ?>
				    <button id="btn_usuario" class="btn btn-orange" style="color: black !important; font-weight: bold;">Crear nueva cuenta</button>
                <?php } ?>
				<br>
				<div class="table-responsive" style="margin-top: 30px; padding-bottom: 30px;">
			        <table id="table_search" class="table table-bordered table-condensed">
			            <thead>
			                <tr>
			                    <th>Codigo</th>
			                    <th>Nombre de usuario</th>
			                    <th>Rol</th>
			                    <th>Estado</th>
			                    <th>Acciones</th>
			                </tr>
			            </thead>
			            <tbody>
			            </tbody>
			        </table>
			    </div>
			</div>
		</div>
	</section>
</div>

<div class="modal fade" id="modal_usuario" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content box-content box-bold col-lg-10 col-md-offset-2">
        <form id="form_usuario" method="post" action="">
			<input type="hidden" name="codi_usu">
        	<div class="modal-header">
                <h4 class="modal-title" id="modal_usuario_lbl"></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                	<div class="col-lg-6">
                        <div class="form-group">
                            <label>Rol*: </label>
                  			<select name="codi_rol" class="form-control">
  	                			<?php foreach ($roles as $rol) { ?>
                                	<option value="<?= $rol->codi_rol ?>"><?= $rol->desc_rol ?></option>
  	                			<?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nombre de usuario*: </label>
                            <input class="form-control" name="nomb_usu">
                        </div>
                  	</div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Contraseña*: </label>
                            <input type="password" class="form-control" name="cont_usu">
                        </div>
                        <div class="form-group">
                            <label>Confirmar contraseña*: </label>
                            <input type="password" class="form-control" name="ccon_usu">
                        </div>
                  	</div>
                </div>
            </div>
            <div class="modal-footer">
                <span class="pull-left" style="font-style: italic;">* Campo obligatorio</span>
                <br>
                <br>
                <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-top: 20px;">Volver</button>
                <button id="submit_usuario" type="submit" class="btn btn-success" style="margin-top: 20px;">Guardar</button>
            </div>
        </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_permiso" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog">
  <div class="modal-dialog" role="document" style="width: 80%;">
    <div class="modal-content box-content box-bold col-lg-12">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"></h4>
          </div>
          <div class="modal-body">
          </div>
    </div>
  </div>
</div>