<div class="container-page-header" style="height: auto; padding-bottom: 50px;">
	<section>
		<div class="row" style="padding: 0px 30px;">
			<div class="box-content box-bold col-md-12" style="line-height: 1.42857143;">
			    <h2 class="title-sisgedo">Visitas</h2>
				<br>
				<div style="width: 280px;">
					<div class="form-group">
			            <div class='input-group date box-date'>
			                <input type='text' class="form-control" id='fech_vis' value="<?= date("Y-m-d") ?>"/>
			                <span class="input-group-addon">
			                    <span class="glyphicon glyphicon-calendar">
			                    </span>
			                </span>
			                <span class="input-group-btn">
						        <button id="btn_search_vis" class="btn btn-orange" style="color: black !important; font-weight: bold;">Buscar visitas</button>
						    </span>
			            </div>
			        </div>
		        </div>
				<div class="col-md-12">
					<div class="table-responsive" style="padding-bottom: 30px; border: none !important;">
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
				                </tr>
				            </thead>
				            <tbody>
				            </tbody>
				        </table>
				    </div>
			    </div>
			</div>
		</div>
	</section>
</div>