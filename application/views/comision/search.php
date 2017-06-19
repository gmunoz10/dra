<div class="container-page-header" style="height: auto; padding-bottom: 50px;">
	<section>
		<div class="row">
			<div class="box-content col-md-12" style="line-height: 1.42857143; margin: 30px; width: 95%;">
			    <h2 class="title-sisgedo">Comisiones</h2>
                  <div class="form-group no-margin" style="width: 440px;">
                      <div class='input-group date box-date'>
                          <input type='text' class="form-control" id='fech_com_search' value="<?= date("Y-m-d") ?>"/>
                          <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar">
                              </span>
                          </span>
                            <span class="input-group-btn">
                              <button id="btn_search" class="btn btn-default" style="color: black !important; font-weight: bold; border-radius: 0px !important;">Buscar</button>
                            </span>
                          <?php if(check_permission(REGISTRAR_COMISION)) { ?>
                            <span class="input-group-btn">
                              <button id="btn_comision" class="btn btn-orange" style="color: black !important; font-weight: bold;">Nueva comisión</button>
                            </span>
                          <?php } ?>
                      </div>
                  </div>
                
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
                          <th>Tipo</th>
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

<div class="modal fade" id="modal_com" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog">
  <div class="modal-dialog" role="document" style="width: 80%">
    <div class="modal-content box-content box-bold">
        <form id="form_com" method="post" action="" accept-charset="utf-8">
          <input type="hidden" name="codi_com">
          <div class="modal-header">
                <h4 class="modal-title" id="modal_com_lbl"></h4>
            </div>
            <div class="modal-body">
              <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                        <label>Fecha*: </label>
                        <div class='input-group date box-date'>
                            <input type='text' class="form-control" name="fech_com" />
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
                        <label>Tipo*: </label>
                        <select class="form-control" name="tipo_com">
                          <option value="1">CON RETORNO</option>
                          <option value="0">SIN RETORNO</option>
                        </select>
                    </div>
                    <div id="box_retorno">
                      <div class="form-group">
                          <label>Número de retornos*: </label>
                          <select class="form-control" name="retornos">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                          </select>
                      </div>
                      <table id="tbl_comision_con" class="table table-bordered table-condensed table-striped">
                        <thead>
                          <tr>
                            <th>Salida</th>
                            <th>Ingreso</th>
                            <th>Obsv.</th>
                          </tr>
                          <tbody>
                          </tbody>
                        </thead>
                      </table>
                    </div>
                    <div id="box_sin_retorno">
                      <table id="tbl_comision_sin" class="table table-bordered table-condensed table-striped">
                        <thead>
                          <tr>
                            <th>Salida</th>
                            <th>Ingreso</th>
                            <th>Obsv.</th>
                          </tr>
                          <tbody>
                            <tr>
                              <td>  
                                <div class="input-group date box-date">
                                  <input type="text" class="form-control" name="sali_com" value="06:00 PM" />
                                  <span class="input-group-addon"> 
                                    <span class="glyphicon glyphicon-time"> 
                                    </span> 
                                  </span> 
                                </div>
                              </td>
                              <td> 
                                <div class="input-group date box-date"> 
                                  <input type="text" class="form-control" name="ingr_com" value="09:00 AM" /> 
                                  <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span> 
                                  </span> 
                                </div>
                              </td>
                              <td>
                                <input class="form-control" name="obsv_com"> </td> 
                              </tr>
                          </tbody>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
            </div>
            <div class="modal-footer">
                <span class="pull-left" style="font-style: italic;">* Campo obligatorio</span>
                <br>
                <br>
                <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-top: 20px;">Volver</button>
                <button id="submit_com" type="submit" class="btn btn-success" style="margin-top: 20px;">Guardar</button>
            </div>
        </form>
    </div>
  </div>
</div>
