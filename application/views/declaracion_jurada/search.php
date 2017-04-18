<div class="container-page-header" style="height: auto; padding-bottom: 50px;">
	<section>
		<div class="row">
			<div class="box-content col-md-8 col-md-offset-2" style="line-height: 1.42857143;">
			    <h2 class="title-sisgedo">Declaraciones juradas</h2>
                <?php if(check_permission(REGISTRAR_DECLARACION_JURADA)) { ?>
				    <button id="btn_declaracion_jurada" class="btn btn-orange" style="color: black !important; font-weight: bold;">Nueva declaración jurada</button>
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
      <select class="form-control codi_gdj" class="form-control">
        <?php foreach ($grupos_declaracion_jurada as $grupo_declaracion_jurada) { ?>
                <option value="<?= $grupo_declaracion_jurada->codi_gdj ?>"><?= $grupo_declaracion_jurada->nomb_gdj ?></option>
        <?php } ?>
        </select>
</div>

<div class="modal fade" id="modal_declaracion_jurada" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog">
  <div class="modal-dialog" role="document" style="width: 60%">
    <div class="modal-content box-content box-bold">
        <form id="form_declaracion_jurada" method="post" action="" enctype="multipart/form-data" accept-charset="utf-8">
          <input type="hidden" name="codi_dju">
          <input type="hidden" name="count_rows">
          <div class="modal-header">
                <h4 class="modal-title" id="modal_declaracion_jurada_lbl"></h4>
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
                          <label>Grupo de declaración jurada*: </label>
                      <select name="codi_gdj" class="form-control">
                        <?php foreach ($grupos_declaracion_jurada as $grupo_declaracion_jurada) { ?>
                                <option value="<?= $grupo_declaracion_jurada->codi_gdj ?>"><?= $grupo_declaracion_jurada->nomb_gdj ?></option>
                        <?php } ?>
                          </select>
                      </div>
                      <div class="form-group">
                        <label>Número*: </label>
                        <input class="form-control" name="nume_dju">
                      </div>
                      <div class="form-group">
                        <label>Fecha de declaración jurada*: </label>
                        <div class='input-group date box-date'>
                            <input type='text' class="form-control" name="fech_dju" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar">
                                </span>
                            </span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label>Descripción*: </label>
                        <textarea class="form-control" rows="3" id="desc_dju" name="desc_dju"></textarea>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label>Documento adjunto*: </label>
                        <input name="docu_dju" type="file" class="file-loading" data-allowed-file-extensions='["pdf", "doc", "docx"]'>
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
                <button id="submit_declaracion_jurada" type="submit" class="btn btn-success" style="margin-top: 20px;">Guardar</button>
                <button id="submit_multi_declaracion_jurada" type="button" class="btn btn-success" style="margin-top: 20px; display: none;">Guardar</button>
            </div>
        </form>
    </div>
  </div>
</div>
