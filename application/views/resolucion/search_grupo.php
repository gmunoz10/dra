<div class="container-page-header" style="height: auto; padding-bottom: 50px;">
	<section>
		<div class="row">
			<div class="box-content col-md-8 col-md-offset-2" style="line-height: 1.42857143;">
			    <h2 class="title-sisgedo">Grupos de resolución</h2>
                <?php if(check_permission(REGISTRAR_GRUPO_RESOLUCION)) { ?>
				    <button id="btn_grupo_resolucion" class="btn btn-orange" style="color: black !important; font-weight: bold;">Crear nuevo grupo</button>
                <?php } ?>
				<br>
				<div class="table-responsive" style="margin-top: 30px; padding-bottom: 30px;">
			        <table id="table_search" class="table table-bordered table-condensed">
			            <thead>
			                <tr>
			                    <th>Codigo</th>
			                    <th>Nombre</th>
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

<div class="modal fade" id="modal_grupo_resolucion" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content box-content box-bold col-lg-10 col-md-offset-2">
        <form id="form_grupo_resolucion" method="post" action="">
			<input type="hidden" name="codi_gre">
        	<div class="modal-header">
                <h4 class="modal-title" id="modal_grupo_resolucion_lbl"></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                	<div class="col-lg-12">
                        <div class="form-group">
                            <label>Nombre de grupo*: </label>
                            <input class="form-control" name="nomb_gre">
                        </div>
                  	</div>
                </div>
            </div>
            <div class="modal-footer">
                <span class="pull-left" style="font-style: italic;">* Campo obligatorio</span>
                <br>
                <br>
                <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-top: 20px;">Volver</button>
                <button id="submit_grupo_resolucion" type="submit" class="btn btn-success" style="margin-top: 20px;">Guardar</button>
            </div>
        </form>
    </div>
  </div>
</div>