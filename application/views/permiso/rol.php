<div class="container-page-header" style="height: auto; padding-bottom: 50px;">
	<section>
		<div class="row">
			<div class="box-content col-md-8 col-md-offset-2" style="line-height: 1.42857143;">
			    <h2 class="title-sisgedo">Permisos por rol</h2>
                <div class="form-inline">
                    <div class="form-group">
                        <label >Rol: </label>
                        <select id="codi_rol" class="form-control" style="width: auto;">
                            <?php foreach ($roles as $rol) { ?>
                                <option value="<?= $rol->codi_rol ?>"><?= $rol->desc_rol ?></option>
                            <?php } ?>
                        </select>
                    </div>
    				<button id="btn_cargar" class="btn btn-orange" style="color: black !important; font-weight: bold;"><i class="fa fa-refresh" aria-hidden="true"></i> Cargar permisos</button>
                </div>
                <div class="box-resultado">
                </div>
			</div>
		</div>
	</section>
</div>
