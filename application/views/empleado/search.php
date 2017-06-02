<div class="container-page-header" style="height: auto; padding-bottom: 50px;">
	<section>
		<div class="row">
			<div class="box-content col-md-12" style="line-height: 1.42857143; margin: 30px; width: 95%;">
			    <h2 class="title-sisgedo">Empleados</h2>
                <?php if(check_permission(REGISTRAR_EMPLEADO)) { ?>
				    <button id="btn_empleado" class="btn btn-orange" style="color: black !important; font-weight: bold;">Nueva empleado</button>
                <?php } ?>
				<br>
				<div class="table-responsive" style="margin-top: 30px; padding-bottom: 30px;">
			        <table id="table_search" class="table table-bordered table-condensed">
			            <thead>
			                <tr>
			                    <th>Código</th>
                          <th>Empleado</th>
			                    <th>Cargo</th>
                          <th>Documento</th>
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

<div class="modal fade" id="modal_emp" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog">
  <div class="modal-dialog" role="document" style="width: 60%">
    <div class="modal-content box-content box-bold">
        <form id="form_emp" method="post" action="" accept-charset="utf-8">
          <input type="hidden" name="codi_emp">
          <div class="modal-header">
                <h4 class="modal-title" id="modal_emp_lbl"></h4>
            </div>
            <div class="modal-body">
              <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                        <label>Nombre*: </label>
                        <input class="form-control" name="nomb_emp">
                    </div>
                    <div class="form-group">
                        <label>Apellido*: </label>
                        <input class="form-control" name="apel_emp">
                    </div>
                    <div class="form-group">
                        <label>D.N.I.*: </label>
                        <input class="form-control" name="docu_emp">
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                        <label>Cargo*: </label>
                        <input class="form-control" name="carg_emp">
                    </div>
                    <div class="form-group">
                        <label>Oficina*: </label>
                        <select class="form-control" name="ofic_emp">
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
                        <label>Tipo*: </label>
                        <select class="form-control" name="tipo_emp">
                          <option value="NOMINADO">NOMINADO</option>
                          <option value="CAST">CAST</option>
                          <option value="TERCERO">TERCERO</option>
                        </select>
                    </div>
                  </div>
                </div>
            </div>
            <div class="modal-footer">
                <span class="pull-left" style="font-style: italic;">* Campo obligatorio</span>
                <br>
                <br>
                <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-top: 20px;">Volver</button>
                <button id="submit_emp" type="submit" class="btn btn-success" style="margin-top: 20px;">Guardar</button>
            </div>
        </form>
    </div>
  </div>
</div>
