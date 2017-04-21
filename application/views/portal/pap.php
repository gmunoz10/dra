<input type="hidden" id="codi_gpa" value="<?= $codi_gpa ?>">
<div class="container-page-header" style="height: auto; padding-bottom: 50px;">
	<section>
		<div class="row" style="padding: 0px 30px;">
			<div class="box-content box-bold col-md-8 col-md-offset-2" style="line-height: 1.42857143;">
			    <h2 class="title-sisgedo"><?= $nomb_gpa ?></h2>
				<br>
				<div style="width: 280px;">
					<div class="form-group">
			            <div class='input-group date box-date'>
			                <input type='text' class="form-control" id='year_pap' value="<?= date("Y") ?>"/>
			                <span class="input-group-addon">
			                    <span class="glyphicon glyphicon-calendar">
			                    </span>
			                </span>
			                <span class="input-group-btn">
						        <button id="btn_search_year" class="btn btn-orange" style="color: black !important; font-weight: bold;">Buscar documento</button>
						    </span>
			            </div>
			        </div>
		        </div>
				<div class="col-md-12">
					<div class="table-responsive" style="margin-top: 30px; padding-bottom: 30px; border: none !important;">
				        <table id="table_search" class="table table-bordered table-condensed">
				            <thead>
				                <tr>
	                          		<th>N°</th>
				                    <th>Fecha</th>
				                    <th>Descripción</th>
				                    <th>Acción</th>
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