<div class="container-page-header" style="height: auto; padding-bottom: 50px;">
	<section>
		<div class="row">
			<div class="box-content col-md-8 col-md-offset-2" style="line-height: 1.42857143;">
			    <h2 class="title-sisgedo">Resoluciones</h2>
                <?php if(check_permission(REGISTRAR_RESOLUCION)) { ?>
				    <button id="btn_resolucion" class="btn btn-orange" style="color: black !important; font-weight: bold;">Subir resoluciones</button>
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

<div class="modal fade" id="modal_resolucion" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog">
  <div class="modal-dialog" role="document" style="width: 90%">
    <div class="modal-content box-content box-bold">
        	<div class="modal-header">
                <h4 class="modal-title" id="modal_resolucion_lbl"></h4>
            </div>
            <div class="modal-body">
                <div class="row">
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
            </div>
            <div class="modal-footer">
                <span class="pull-left" style="font-style: italic;">* Campo obligatorio</span>
                <br>
                <br>
                <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-top: 20px;">Volver</button>
                <button id="submit_resolucion" type="button" class="btn btn-success" style="margin-top: 20px;">Guardar</button>
            </div>
    </div>
  </div>
</div>

<div id="select_view">
      <select name="codi_gre" class="form-control">
        <?php foreach ($grupos_resolucion as $grupo_resolucion) { ?>
                <option value="<?= $grupo_resolucion->codi_gre ?>"><?= $grupo_resolucion->nomb_gre ?></option>
        <?php } ?>
        </select>
</div>

<!--
<div class="modal fade" id="modal_resolucion" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog">
  <div class="modal-dialog" role="document" style="width: 60%">
    <div class="modal-content box-content box-bold">
        <form id="form_resolucion" method="post" action="" enctype="multipart/form-data" accept-charset="utf-8">
      <input type="hidden" name="codi_res">
          <div class="modal-header">
                <h4 class="modal-title" id="modal_resolucion_lbl"></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                        <label>Grupo de resolución*: </label>
                    <select name="codi_gre" class="form-control">
                      <?php foreach ($grupos_resolucion as $grupo_resolucion) { ?>
                              <option value="<?= $grupo_resolucion->codi_gre ?>"><?= $grupo_resolucion->nomb_gre ?></option>
                      <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                      <label>Número*: </label>
                      <input class="form-control" name="nume_res">
                    </div>
                    <div class="form-group">
                      <label>Fecha de resolución*: </label>
                      <div class='input-group date box-date'>
                          <input type='text' class="form-control" name="fech_res" />
                          <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar">
                              </span>
                          </span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Descripción*: </label>
                      <textarea class="form-control" rows="3" id="desc_res" name="desc_res"></textarea>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label>Documento adjunto*: </label>
                      <input name="docu_res" type="file" class="file-loading" data-allowed-file-extensions='["pdf", "doc", "docx"]'>
                    </div>
                  </div>
                </div>
            </div>
            <div class="modal-footer">
                <span class="pull-left" style="font-style: italic;">* Campo obligatorio</span>
                <br>
                <br>
                <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-top: 20px;">Volver</button>
                <button id="submit_resolucion" type="submit" class="btn btn-success" style="margin-top: 20px;">Guardar</button>
            </div>
        </form>
    </div>
  </div>
</div>
-->