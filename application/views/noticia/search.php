<div class="container-page-header" style="height: auto; padding-bottom: 50px;">
	<section>
		<div class="row">
			<div class="box-content col-md-8 col-md-offset-2" style="line-height: 1.42857143;">
			    <h2 class="title-sisgedo">Noticias</h2>
                <?php if(check_permission(REGISTRAR_NOTICIA)) { ?>
				    <button id="btn_noticia" class="btn btn-orange" style="color: black !important; font-weight: bold;">Nueva noticia</button>
                <?php } ?>
				<br>
				<div class="table-responsive" style="margin-top: 30px; padding-bottom: 30px;">
			        <table id="table_search" class="table table-bordered table-condensed">
			            <thead>
			                <tr>
			                    <th>Código</th>
                          <th>Número</th>
                          <th>Título</th>
			                    <th>Fecha</th>
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


<div class="modal fade" id="modal_noticia" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog">
  <div class="modal-dialog" role="document" style="width: 60%">
    <div class="modal-content box-content box-bold">
        <form id="form_noticia" method="post" action="" enctype="multipart/form-data">
          <input type="hidden" name="codi_not">
          <div class="modal-header">
                <h4 class="modal-title" id="modal_noticia_lbl"></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label>Número*: </label>
                      <input class="form-control" name="nume_not">
                    </div>
                    <div class="form-group">
                      <label>Título*: </label>
                      <input class="form-control" name="titu_not">
                    </div>
                    <div class="form-group">
                      <label>Fecha de publicación*: </label>
                      <div class='input-group date box-date'>
                          <input type='text' class="form-control" name="fech_not" />
                          <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar">
                              </span>
                          </span>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group text-center">
                        <div class="col-lg-12">
                          <label class="control-label">Imagen</label>
                        </div>
                        <img id="preview" src="" class="img-thumbnail img-responsive" style="margin-bottom: 10px;">
                        <br>
                        <div class="col-lg-12">
                          <input class="form-control" id="file_lbl" placeholder="Seleccione una imagen" disabled="disabled" style="width: auto; margin: 0 auto;" />
                        </div>
                        <div class="fileUpload btn btn-primary">
                            <span>Seleccionar imagen</span>
                            <input name="imag_not" id="file_img" type="file" class="upload">
                        </div>
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="form-group">
                      <label>Contenido*: </label>
                      <textarea class="form-control" id="cont_not" name="cont_not" rows="10"></textarea>
                    </div>
                  </div>
                </div>
            </div>
            <div class="modal-footer">
                <span class="pull-left" style="font-style: italic;">* Campo obligatorio</span>
                <br>
                <br>
                <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-top: 20px;">Volver</button>
                <button id="submit_noticia" type="submit" class="btn btn-success" style="margin-top: 20px;">Guardar</button>
            </div>
        </form>
    </div>
  </div>
</div>
