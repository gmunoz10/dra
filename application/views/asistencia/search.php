<div class="container-page-header" style="height: auto; padding-bottom: 50px;">
	<section>
		<div class="row">
			<div class="box-content col-md-12" style="line-height: 1.42857143; margin: 30px; width: 95%;">
			    <h2 class="title-sisgedo">Asistencias</h2>
                  <div class="form-group no-margin" style="width: 510px;">
                      <div class='input-group date box-date'>
                          <input type='text' class="form-control" id='fech_asi_search' value="<?= date("Y-m-d") ?>"/>
                          <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar">
                              </span>
                          </span>
                          <span class="input-group-btn">
                            <button id="btn_search" class="btn btn-default" style="color: black !important; font-weight: bold; border-radius: 0px !important;">Buscar</button>
                          </span>
                          <?php if(check_permission(REGISTRAR_ASISTENCIA)) { ?>
                            <span class="input-group-btn">
                              <button id="btn_asistencia" class="btn btn-orange" style="color: black !important; font-weight: bold;">Nueva asistencia</button>
                            </span>
                          <?php } ?>
                          <span class="input-group-btn">
                            <button id="btn_export" class="btn btn-danger" style="font-weight: bold;">Generar reporte</button>
                          </span>
                      </div>
                  </div>
                  <span class="input-group-btn">
                    <button id="btn_format" class="btn btn-default pull-right" style="font-weight: bold;">Descargar formato</button>
                  </span>
				<br>
				<div class="table-responsive" style="margin-top: 30px; padding-bottom: 30px;">
			        <table id="table_search" class="table table-bordered table-condensed">
			            <thead>
			                <tr>
			                    <th>Número</th>
                          <th>Fecha</th>
			                    <th>Empleado</th>
                          <th>D.N.I.</th>
                          <th>Oficina</th>
                          <th>Observación</th>
                          <th>Ingreso</th>
                          <th>Salida de refrigerio</th>
                          <th>Ingreso de refrigerio</th>
                          <th>Salida</th>
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

<div class="modal fade" id="modal_asi" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog">
  <div class="modal-dialog" role="document" style="width: 60%">
    <div class="modal-content box-content box-bold">
        <form id="form_asi" method="post" action="" accept-charset="utf-8">
          <input type="hidden" name="codi_asi">
          <div class="modal-header">
                <h4 class="modal-title" id="modal_asi_lbl"></h4>
            </div>
            <div class="modal-body">
              <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                        <label>Fecha*: </label>
                        <div class='input-group date box-date'>
                            <input type='text' class="form-control" name="fech_asi" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar">
                                </span>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Empleado*: </label>
                        <select class="form-control" name="codi_emp">
                          <?php foreach ($empleados as $row) { ?>
                            <option data-ofic="<?= $row->ofic_emp  ?>" data-docu="<?= $row->docu_emp  ?>" value="<?= $row->codi_emp ?>"><?= $row->apel_emp . ', ' . $row->nomb_emp  ?></option>
                          <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>N° de documento*: </label>
                        <input class="form-control" name="docu_emp" readonly="">
                    </div>
                    <div class="form-group">
                        <label>Oficina*: </label>
                        <input class="form-control" name="ofic_emp" readonly="">
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                        <label>Ingreso*: </label>
                        <div class='input-group date box-date'>
                            <input type='text' class="form-control" name="ingr_asi" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-time">
                                </span>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Salida de refrigerio: </label>
                        <div class='input-group date box-date'>
                            <input type='text' class="form-control" name="sare_asi" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-time">
                                </span>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Ingreso de refrigerio: </label>
                        <div class='input-group date box-date'>
                            <input type='text' class="form-control" name="inre_asi" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-time">
                                </span>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Salida: </label>
                        <div class='input-group date box-date'>
                            <input type='text' class="form-control" name="sali_asi" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-time">
                                </span>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                      <label>Observación*: </label>
                      <textarea class="form-control" rows="3" id="obsv_emp" name="obsv_emp"></textarea>
                    </div>
                  </div>
                </div>
            </div>
            <div class="modal-footer">
                <span class="pull-left" style="font-style: italic;">* Campo obligatorio</span>
                <br>
                <br>
                <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-top: 20px;">Volver</button>
                <button id="submit_asi" type="submit" class="btn btn-success" style="margin-top: 20px;">Guardar</button>
            </div>
        </form>
    </div>
  </div>
</div>

<form id="form_export" action="<?= base_url('asistencia/export') ?>" method="post">
  <input type="hidden" name="date">
  <input type="hidden" name="tipo">
</form>

<form id="form_format" action="<?= base_url('download_format') ?>" method="post">
  <input type="hidden" name="date">
  <input type="hidden" name="tipo">
</form>

<div class="modal fade" id="modal_export" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog">
  <div class="modal-dialog" role="document" style="width: 350px;">
    <div class="modal-content box-content box-bold">
      <div class="modal-header">
          <h4 class="modal-title" id="modal_exp_lbl">Seleccione tipo de empleado</h4>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-lg-12">
              <div class="form-group">
                  <label>Tipo de empleado: </label>
                  <select class="form-control" id="tipo_emp_export">
                    <option value="CAS">CAS</option>
                    <option value="TERCERO">TERCERO</option>
                    <option value="CARGO DE CONFIANZA">CARGO DE CONFIANZA</option>
                    <option value="TODOS">TODOS</option>
                  </select>
              </div>
            </div>
          </div>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Volver</button>
          <button id="btn_select" type="button" class="btn btn-danger">Generar reporte</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_format" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog">
  <div class="modal-dialog" role="document" style="width: 350px;">
    <div class="modal-content box-content box-bold">
      <div class="modal-header">
          <h4 class="modal-title" id="modal_for_lbl">Seleccione tipo de empleado</h4>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-lg-12">
              <div class="form-group">
                  <label>Tipo de empleado: </label>
                  <select class="form-control" id="tipo_emp_format">
                    <option value="CAS">CAS</option>
                    <option value="TERCERO">TERCERO</option>
                  </select>
              </div>
            </div>
          </div>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Volver</button>
          <button id="btn_select_format" type="button" class="btn btn-danger">Descargar formato</button>
      </div>
    </div>
  </div>
</div>