<div class="container-page-header" style="height: auto; padding-bottom: 50px;">
	<section>
		<div class="row">
			<div class="box-content col-md-8 col-md-offset-2" style="line-height: 1.42857143;">
			    <h2 class="title-sisgedo">Agenda</h2>
                <?php if(check_permission(REGISTRAR_AGENDA)) { ?>
				    <button id="btn_agenda" class="btn btn-orange" style="color: black !important; font-weight: bold;">Nueva agenda</button>
                <?php } ?>
				<br>
				<div class="table-responsive" style="margin-top: 30px; padding-bottom: 30px;">
			        <table id="table_search" class="table table-bordered table-condensed">
			            <thead>
			                <tr>
			                    <th>Código</th>
                          <th>Dependencia</th>
                          <th>Fecha</th>
                          <th>Lugar</th>
			                    <th>Descripción</th>
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

<div class="modal fade" id="modal_agenda" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog">
  <div class="modal-dialog" role="document" style="width: 60%">
    <div class="modal-content box-content box-bold">
        <form id="form_agenda" method="post" action="">
          <input type="hidden" name="codi_age">
          <div class="modal-header">
                <h4 class="modal-title" id="modal_agenda_lbl"></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                        <label>Dependencia*: </label>
                        <select name="codi_dpe" class="form-control">
                          <?php foreach ($dependencias as $dependencia) { ?>
                            <option value="<?= $dependencia->codi_dpe ?>"><?= $dependencia->nomb_dpe ?></option>
                          <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                      <label>Lugar*: </label>
                      <input class="form-control" name="luga_age">
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label>Fecha*: </label>
                      <div class='input-group date box-date'>
                          <input type='text' class="form-control" name="fech_age" />
                          <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar">
                              </span>
                          </span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Descripción*: </label>
                      <textarea class="form-control" rows="3" id="desc_age" name="desc_age"></textarea>
                    </div>
                  </div>
                </div>
            </div>
            <div class="modal-footer">
                <span class="pull-left" style="font-style: italic;">* Campo obligatorio</span>
                <br>
                <br>
                <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-top: 20px;">Volver</button>
                <button id="submit_agenda" type="submit" class="btn btn-success" style="margin-top: 20px;">Guardar</button>
            </div>
        </form>
    </div>
  </div>
</div>
