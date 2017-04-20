<div class="container-page-header" style="height: auto; padding-bottom: 50px;">
	<section>
		<div class="row">
			<div class="box-content box-bold col-md-8 col-md-offset-2" style="line-height: 1.42857143;">
			    <h2 class="title-sisgedo">Galería</h2>
                <?php if(check_permission(REGISTRAR_ALBUM_IMAGEN)) { ?>
				    <button id="btn_nuevo_album" class="btn btn-orange" style="color: black !important; font-weight: bold;">Crear nuevo álbum de imágenes</button>
                <?php } ?>
                <br>
				<br>
                <?php foreach ($albumes as $album) { ?>
                    <hr style="border-color: #999; margin-top: 10px; margin-bottom: 10px;">
                        <h4 class="title-sisgedo" style="margin-bottom: 5px;"><b><?= $album->titu_alb ?></b></h4>
                        <p style="color: #666"><i>Publicado por <b><?= $album->nomb_usu ?></b></i><span class="pull-right"><i class="fa fa-clock-o" aria-hidden="true"></i> <i>Fecha de publicación: <?= date("d/m/Y h:i A", strtotime($album->fech_alb)) ?></i></span></p>
                    <hr style="border-color: #999; margin-top: 10px; margin-bottom: 10px;">
                    <div class="col-md-12" style="padding: 0px;">
                        <?php foreach ($album->imagenes as $imagen) { ?>
                        <div class="col-sm-4 a-imagen-galeria">
                            <a href="<?= asset_url() ?>galeria/<?= $imagen->imag_ial ?>" data-toggle="lightbox" data-gallery="example-gallery">
                                <img src="<?= asset_url() ?>galeria/<?= $imagen->imag_ial ?>" class="img-fluid">
                            </a>
                            <button class="btn btn-danger btn-xs btn-delete-imagen" data-codi="<?= $imagen->codi_ial ?>"><i class="fa fa-times" aria-hidden="true"></i></button>
                        </div>
                        <?php } ?>
                    </div>
                <?php } ?>
                <div class="col-lg-12 text-center">
                    <ul class="pagination">
                        <?php for ($i=1; $i <= $pages ; $i++) { ?>
                          <li class="<?= ((int) $i == (int) $page) ? "active" : "" ?>"><a href="<?= base_url() . 'galeria/admin/' . $i ?>"><?= $i ?></a></li>
                        <?php } ?>
                    </ul>
                </div>
			</div>
		</div>
	</section>
</div>

<form id="form_imagen_delete" method="post" action="<?= base_url().'galeria/eliminar_imagen' ?>">
    <input type="hidden" name="codi_ial">
</form>

<div class="modal fade" id="modal_galeria" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content box-content box-bold col-lg-10 col-md-offset-2">
        <form id="form_galeria" method="post" action="" enctype="multipart/form-data" accept-charset="utf-8">
            <input type="hidden" name="codi_alb">
            <div class="modal-header">
                <h4 class="modal-title" id="modal_galeria_lbl"></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Título*: </label>
                            <input class="form-control" name="titu_alb">
                        </div>
                        <div class="form-group">
                            <label>Imágenes: </label>
                            <input name="imag_ial[]" type="file" class="file-loading" multiple data-allowed-file-extensions='["png", "jpg"]'>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <span class="pull-left" style="font-style: italic;">* Campo obligatorio</span>
                <br>
                <br>
                <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-top: 20px;">Volver</button>
                <button id="submit_galeria" type="submit" class="btn btn-success" style="margin-top: 20px;">Guardar</button>
            </div>
        </form>
    </div>
  </div>
</div>