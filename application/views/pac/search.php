<div class="container-page-header" style="height: auto; padding-bottom: 50px;">
	<section>
		<div class="row">
			<div class="box-content col-md-8 col-md-offset-2" style="line-height: 1.42857143;">
			    <h2 class="title-sisgedo">PAC</h2>
                <?php if(check_permission(REGISTRAR_PAC)) { ?>
				    <button id="btn_pac" class="btn btn-orange" style="color: black !important; font-weight: bold;">Nuevo PAC</button>
                <?php } ?>
				<br>
				<div class="table-responsive" style="margin-top: 30px; padding-bottom: 30px;">
			        <table id="table_search" class="table table-bordered table-condensed">
			            <thead>
			                <tr>
			                    <th>Código</th>
                          <th>Grupo</th>
                          <th>Número</th>
			                    <th>Fecha</th>
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

<div id="select_view">
      <select class="form-control codi_gpa" class="form-control">
        <?php foreach ($grupos_pac as $grupo_pac) { ?>
                <option value="<?= $grupo_pac->codi_gpa ?>"><?= $grupo_pac->nomb_gpa ?></option>
        <?php } ?>
        </select>
</div>

<div class="modal fade" id="modal_pac" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog">
  <div class="modal-dialog" role="document" style="width: 60%">
    <div class="modal-content box-content box-bold">
        <form id="form_pac" method="post" action="" enctype="multipart/form-data" accept-charset="utf-8">
          <input type="hidden" name="codi_pac">
          <input type="hidden" name="count_rows">
          <div class="modal-header">
                <h4 class="modal-title" id="modal_pac_lbl"></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                  <div class="resolucion-multi" style="display: none">
                    <table id="table_multi" class="table table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th>Grupo</th>
                                <th>Número</th>
                                <th>Fecha</th>
                                <th>Descripción</th>
                                <th>Documento</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                  </div>
                  <div class="resolucion-uno">
                    <div class="col-lg-6">
                      <div class="form-group">
                          <label>Grupo de pac*: </label>
                      <select name="codi_gpa" class="form-control">
                        <?php foreach ($grupos_pac as $grupo_pac) { ?>
                                <option value="<?= $grupo_pac->codi_gpa ?>"><?= $grupo_pac->nomb_gpa ?></option>
                        <?php } ?>
                          </select>
                      </div>
                      <div class="form-group">
                        <label>Número*: </label>
                        <input class="form-control" name="nume_pac">
                      </div>
                      <div class="form-group">
                        <label>Fecha de pac*: </label>
                        <div class='input-group date box-date'>
                            <input type='text' class="form-control" name="fech_pac" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar">
                                </span>
                            </span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label>Descripción*: </label>
                        <textarea class="form-control" rows="3" id="desc_pac" name="desc_pac"></textarea>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label>Documento adjunto*: </label>
                        <input name="docu_pac" type="file" class="file-loading" data-allowed-file-extensions='["pdf", "doc", "docx"]'>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
            <div class="modal-footer">
                <span class="pull-left" style="font-style: italic;">* Campo obligatorio</span>
                <br>
                <br>
                <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-top: 20px;">Volver</button>
                <button id="submit_pac" type="submit" class="btn btn-success" style="margin-top: 20px;">Guardar</button>
                <button id="submit_multi_pac" type="button" class="btn btn-success" style="margin-top: 20px; display: none;">Guardar</button>
            </div>
        </form>
    </div>
  </div>
</div>
