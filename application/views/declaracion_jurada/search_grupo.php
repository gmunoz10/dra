<div class="container-page-header" style="height: auto; padding-bottom: 50px;">
	<section>
		<div class="row">
			<div class="box-content col-md-8 col-md-offset-2" style="line-height: 1.42857143;">
			    <h2 class="title-sisgedo">Grupos de declaración jurada</h2>
                <?php if(check_permission(REGISTRAR_GRUPO_DECLARACION_JURADA)) { ?>
				    <button id="btn_grupo_declaracion_jurada" class="btn btn-orange" style="color: black !important; font-weight: bold;">Crear nuevo grupo</button>
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

<div class="modal fade" id="modal_grupo_declaracion_jurada" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content box-content box-bold col-lg-10 col-md-offset-2">
        <form id="form_grupo_declaracion_jurada" method="post" action="">
			<input type="hidden" name="codi_gdj">
        	<div class="modal-header">
                <h4 class="modal-title" id="modal_grupo_declaracion_jurada_lbl"></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                	<div class="col-lg-12">
                        <div class="form-group">
                            <label>Nombre de grupo*: </label>
                            <input class="form-control" name="nomb_gdj">
                        </div>
                  	</div>
                </div>
            </div>
            <div class="modal-footer">
                <span class="pull-left" style="font-style: italic;">* Campo obligatorio</span>
                <br>
                <br>
                <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-top: 20px;">Volver</button>
                <button id="submit_grupo_declaracion_jurada" type="submit" class="btn btn-success" style="margin-top: 20px;">Guardar</button>
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
            <h4 class="modal-title" id="modal_link_lbl"></h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label id="reso_label"></label>
                        <div class="input-group">
                            <input class="form-control" name="link" id="enlace_gdj" readonly="">
                            <span class="input-group-btn">
                                <button class="btn btn-default btn-copiar" type="button" data-clipboard-target="#enlace_gdj" data-toggle="tooltip" data-placement="top" title="Copiar"><i class="fa fa-clipboard" aria-hidden="true"></i></button>
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