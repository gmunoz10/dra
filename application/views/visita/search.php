<div class="container-page-header" style="height: auto; padding-bottom: 50px;">
	<section>
		<div class="row">
			<div class="box-content col-md-12" style="line-height: 1.42857143; margin: 30px; width: 95%;">
			    <h2 class="title-sisgedo">Visitas</h2>
                <?php if(check_permission(REGISTRAR_VISITA)) { ?>
				    <button id="btn_visita" class="btn btn-orange" style="color: black !important; font-weight: bold;">Nueva visita</button>
                <?php } ?>
            <button id="btn_link" class="btn btn-default" style="color: black !important; font-weight: bold;">Enlace para transparencia</button>
				<br>
				<div class="table-responsive" style="margin-top: 30px; padding-bottom: 30px;">
			        <table id="table_search" class="table table-bordered table-condensed">
			            <thead>
			                <tr>
			                    <th>Número</th>
                          <th>Fecha</th>
			                    <th>Visitante</th>
                          <th>Tipo de documento</th>
                          <th>Documento</th>
                          <th>Entidad</th>
                          <th>Motivo</th>
                          <th>Sede</th>
                          <th>Empleado público</th>
                          <th>Oficina</th>
                          <th>Hora de ingreso</th>
                          <th>Hora de salida</th>
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

<div class="modal fade" id="modal_vis" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog">
  <div class="modal-dialog" role="document" style="width: 60%">
    <div class="modal-content box-content box-bold">
        <form id="form_vis" method="post" action="" accept-charset="utf-8">
          <input type="hidden" name="codi_vis">
          <div class="modal-header">
                <h4 class="modal-title" id="modal_vis_lbl"></h4>
            </div>
            <div class="modal-body">
              <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                        <label>Fecha*: </label>
                        <div class='input-group date box-date'>
                            <input type='text' class="form-control" name="fech_vis" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar">
                                </span>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Nombre*: </label>
                        <input class="form-control" name="nomb_vis">
                    </div>
                    <div class="form-group">
                        <label>Apellido*: </label>
                        <input class="form-control" name="apel_vis">
                    </div>
                    <div class="form-group">
                        <label>Tipo de documento*: </label>
                        <input class="form-control" name="tipo_vis">
                    </div>
                    <div class="form-group">
                        <label>Documento*: </label>
                        <input class="form-control" name="docu_vis">
                    </div>
                    <div class="form-group">
                        <label>Entidad*: </label>
                        <input class="form-control" name="enti_vis">
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label>Motivo*: </label>
                      <textarea class="form-control" rows="3" id="moti_vis" name="moti_vis"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Sede*: </label>
                        <select class="form-control" name="sede_vis">
                          <option value="SEDE CENTRAL">SEDE CENTRAL</option>
                          <option value="AGENCIA AGRARIA BARRANCA">AGENCIA AGRARIA BARRANCA</option>
                          <option value="AGENCIA AGRARIA HUAURA">AGENCIA AGRARIA HUAURA</option>
                          <option value="AGENCIA AGRARIA HUARAL">AGENCIA AGRARIA HUARAL</option>
                          <option value="AGENCIA AGRARIA CANTA">AGENCIA AGRARIA CANTA</option>
                          <option value="AGENCIA AGRARIA SANTA EULALIA">AGENCIA AGRARIA SANTA EULALIA</option>
                          <option value="AGENCIA AGRARIA MALA">AGENCIA AGRARIA MALA</option>
                          <option value="AGENCIA AGRARIA CAÑETE">AGENCIA AGRARIA CAÑETE</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Empleado público*: </label>
                        <select class="form-control" name="empl_vis">
                          <?php foreach ($empleado as $row) { ?>
                            <option value="<?= $row->apel_emp . ', ' . $row->nomb_emp  ?>"><?= $row->apel_emp . ', ' . $row->nomb_emp  ?></option>
                          <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Oficina*: </label>
                        <select class="form-control" name="ofic_vis">
                          <option value="DIRECCIÓN REGIONAL">DIRECCIÓN REGIONAL</option>
                          <option value="ASESORÍA JURÍDICA">ASESORÍA JURÍDICA</option>
                          <option value="DIRECCIÓN DE COMPETIVIDAD Y NEGOCIOS AGRARIOS">DIRECCIÓN DE COMPETIVIDAD Y NEGOCIOS AGRARIOS</option>
                          <option value="OFICINA DE ADMINISTRACIÓN">OFICINA DE ADMINISTRACIÓN</option>
                          <option value="UNIDAD DE LOGÍSTICA">UNIDAD DE LOGÍSTICA</option>
                          <option value="UNIDAD DE TESORERÍA">UNIDAD DE TESORERÍA</option>
                          <option value="UNIDAD DE PATRIMONIO">UNIDAD DE PATRIMONIO</option>
                          <option value="UNIDAD DE CONTABILIDAD">UNIDAD DE CONTABILIDAD</option>
                          <option value="UNIDAD DE INFORMÁTICA">UNIDAD DE INFORMÁTICA</option>
                          <option value="OFICINA DE RECURSOS HUMANOS">OFICINA DE RECURSOS HUMANOS</option>
                          <option value="OFICINA DE IMAGEN INSTITUCIONAL">OFICINA DE IMAGEN INSTITUCIONAL</option>
                          <option value="OFICINA DE PLANEAMIENTO Y PRESUPUESTO">OFICINA DE PLANEAMIENTO Y PRESUPUESTO</option>
                          <option value="COORDINACIÓN TÉCNICA DE PROYECTOS">COORDINACIÓN TÉCNICA DE PROYECTOS</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Hora de ingreso*: </label>
                        <div class='input-group date box-date'>
                            <input type='text' class="form-control" name="ingr_vis" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-time">
                                </span>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Hora de salida: </label>
                        <div class='input-group date box-date'>
                            <input type='text' class="form-control" name="sali_vis" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-time">
                                </span>
                            </span>
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
                <button id="submit_vis" type="submit" class="btn btn-success" style="margin-top: 20px;">Guardar</button>
            </div>
        </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_link" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content box-content box-bold col-lg-10 col-md-offset-2">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="modal_link_lbl">Enlace para portal de transparencia</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <div class="input-group">
                            <input class="form-control" name="link" id="enlace_vis" value="<?= base_url('visitas/portal') ?>" readonly="">
                            <span class="input-group-btn">
                                <button class="btn btn-default btn-copiar" type="button" data-clipboard-target="#enlace_vis" data-toggle="tooltip" data-placement="top" title="Copiar"><i class="fa fa-clipboard" aria-hidden="true"></i></button>
                              </span>
                          <span class="input-group-btn">
                            <button class="btn btn-primary btn-enlace" type="button" data-toggle="tooltip" data-placement="top" title="Ir al enlace"><i class="fa fa-external-link" aria-hidden="true"></i></button>
                          </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
