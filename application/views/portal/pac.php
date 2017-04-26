<input type="hidden" id="codi_gpa" value="<?= $codi_gpa ?>">
<div class="container-page-header" style="height: auto; padding-bottom: 50px;">
	<section>
		<div class="row" style="padding: 0px 30px;">
			<div class="box-content box-bold col-md-8 col-md-offset-2" style="line-height: 1.42857143;">
			    <h2 class="title-sisgedo"><?= $nomb_gpa ?></h2>
				<br>
				<div class="btn-group" data-toggle="buttons">
				  <?php foreach ($years as $key => $row) { ?>
				  	<label class="btn btn-default btn-year <?= ($key == "0") ? "active" : "" ?>">
				    	<input type="radio" name="year_pac" value="<?= $row->year_pac ?>" autocomplete="off" <?= ($key == "0") ? "checked" : "" ?>> <?= $row->year_pac ?>
				  	</label>
				  <?php } ?>
				</div>
				<div class="col-md-12">
					<div class="table-responsive" style="padding-bottom: 30px; border: none !important;">
				        <table id="table_search" class="table table-bordered table-condensed">
				            <thead>
				                <tr>
				                    <th>Descripción</th>
				                    <th>Fecha</th>
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