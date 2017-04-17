<div class="container-page-header" style="height: auto; padding-bottom: 50px;">
	<section>
		<div class="row">
			<div class="box-content col-md-8 col-md-offset-2" style="line-height: 1.42857143;">
			    <h2 class="title-sisgedo">Directivas</h2>
                <?php if(check_permission(REGISTRAR_DIRECTIVA)) { ?>
				    <button id="btn_directiva" class="btn btn-orange" style="color: black !important; font-weight: bold;">Nueva directiva</button>
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
      <select class="form-control codi_gdi" class="form-control">
        <?php foreach ($grupos_directiva as $grupo_directiva) { ?>
                <option value="<?= $grupo_directiva->codi_gdi ?>"><?= $grupo_directiva->nomb_gdi ?></option>
        <?php } ?>
        </select>
</div>

<div class="modal fade" id="modal_directiva" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog">
  <div class="modal-dialog" role="document" style="width: 60%">
    <div class="modal-content box-content box-bold">
        <form id="form_directiva" method="post" action="" enctype="multipart/form-data" accept-charset="utf-8">
          <input type="hidden" name="codi_dir">
          <input type="hidden" name="count_rows">
          <div class="modal-header">
                <h4 class="modal-title" id="modal_directiva_lbl"></h4>
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
                          <label>Grupo de directiva*: </label>
                      <select name="codi_gdi" class="form-control">
                        <?php foreach ($grupos_directiva as $grupo_directiva) { ?>
                                <option value="<?= $grupo_directiva->codi_gdi ?>"><?= $grupo_directiva->nomb_gdi ?></option>
                        <?php } ?>
                          </select>
                      </div>
                      <div class="form-group">
                        <label>Número*: </label>
                        <input class="form-control" name="nume_dir">
                      </div>
                      <div class="form-group">
                        <label>Fecha de directiva*: </label>
                        <div class='input-group date box-date'>
                            <input type='text' class="form-control" name="fech_dir" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar">
                                </span>
                            </span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label>Descripción*: </label>
                        <textarea class="form-control" rows="3" id="desc_dir" name="desc_dir"></textarea>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label>Documento adjunto*: </label>
                        <input name="docu_dir" type="file" class="file-loading" data-allowed-file-extensions='["pdf", "doc", "docx"]'>
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
                <button id="submit_directiva" type="submit" class="btn btn-success" style="margin-top: 20px;">Guardar</button>
                <button id="submit_multi_directiva" type="button" class="btn btn-success" style="margin-top: 20px; display: none;">Guardar</button>
            </div>
        </form>
    </div>
  </div>
</div>
