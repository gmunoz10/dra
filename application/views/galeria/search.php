<div class="container-page-header" style="height: auto; padding-bottom: 50px;">
	<section>
		<div class="row">
			<div class="box-content box-bold col-md-8 col-md-offset-2" style="line-height: 1.42857143;">
			    <h2 class="title-sisgedo">Galería</h2>
                <?php if(check_permission(REGISTRAR_ALBUM_IMAGEN)) { ?>
				    <button id="btn_nuevo_album" class="btn btn-orange" style="color: black !important; font-weight: bold;">Crear nuevo álbum</button>
                <?php } ?>
                    <div class="form-inline pull-right">
                      <div class="form-group">
                        <input id="txt_search" value="<?= $search ?>" type="text" class="form-control" placeholder="Buscar...">
                      </div>
                      <button id="btn_search" type="submit" class="btn btn-default">Buscar</button>
                    </div>
                <br>
				<br>
                <?php foreach ($albumes as $album) { ?>
                    <hr style="border-color: #999; margin-top: 10px; margin-bottom: 10px;">
                        <h4 class="title-sisgedo" style="margin-bottom: 5px;">
                            <b style="vertical-align: middle;"><?= $album->titu_alb ?></b>
                            &nbsp;
                            <?php if(check_permission(MODIFICAR_ALBUM_IMAGEN)) { ?>
                                <button class="btn btn-primary btn-xs btn-change-album" data-toggle="tooltip" data-placement="top" title="Cambiar título" data-codi="<?= $album->codi_alb ?>" data-titu="<?= $album->titu_alb ?>"><i class="fa fa-edit" aria-hidden="true"></i></button>
                                <button class="btn btn-primary btn-xs btn-upload-album" data-toggle="tooltip" data-placement="top" title="Subir imágenes" data-codi="<?= $album->codi_alb ?>"><i class="fa fa-upload" aria-hidden="true"></i></button>
                                <button class="btn btn-primary btn-xs btn-fecha-album" data-toggle="tooltip" data-placement="top" title="Cambiar fecha de publicación" data-codi="<?= $album->codi_alb ?>" data-fech="<?= $album->fech_alb ?>"><i class="fa fa-calendar" aria-hidden="true"></i></button>
                            <?php } ?>
                            <?php if (check_permission(DESHABILITAR_ALBUM_IMAGEN) && $album->esta_alb == "1") { ?>
                                <button class="btn btn-warning btn-xs btn-deshabilitar-album" data-toggle="tooltip" data-placement="top" title="Deshabilitar" data-codi="<?= $album->codi_alb ?>"><i class="fa fa-ban" aria-hidden="true"></i></button>
                            <?php } else if (check_permission(HABILITAR_ALBUM_IMAGEN) && $album->esta_alb == "0") { ?>
                                <button class="btn btn-success btn-xs btn-habilitar-album" data-toggle="tooltip" data-placement="top" title="´Habilitar" data-codi="<?= $album->codi_alb ?>"><i class="fa fa-check" aria-hidden="true"></i></button>
                            <?php } ?>
                            <?php if(check_permission(ELIMINAR_ALBUM_IMAGEN)) { ?>
                                <button class="btn btn-danger btn-xs btn-delete-album" data-toggle="tooltip" data-placement="top" title="Eliminar" data-codi="<?= $album->codi_alb ?>"><i class="fa fa-times" aria-hidden="true"></i></button>
                            <?php } ?>
                        </h4>
                        <p style="color: #666"><i>Publicado por <b><?= $album->nomb_usu ?></b></i><span class="pull-right"><i class="fa fa-clock-o" aria-hidden="true"></i> <i>Fecha de publicación: <?= date("d/m/Y h:i A", strtotime($album->fech_alb)) ?></i></span></p>
                    <hr style="border-color: #999; margin-top: 10px; margin-bottom: 10px;">
                    <div class="col-md-12" style="padding: 0px;">
                        <?php $cont = 0; foreach ($album->imagenes as $imagen) { ?>
                            <?php if ($cont == 0) { ?>
                                <div class="col-md-12">
                            <?php } ?>
                                <div class="col-sm-4 a-imagen-galeria">
                                    <a href="<?= asset_url() ?>galeria/<?= $imagen->imag_ial ?>" data-toggle="lightbox" data-gallery="example-gallery">
                                        <img src="<?= asset_url() ?>galeria/<?= $imagen->imag_ial ?>" class="img-thumbnail img-responsive img-fluid">
                                    </a>
                                    <?php if(check_permission(QUITAR_IMAGEN_ALBUM)) { ?>
                                        <button class="btn btn-danger btn-xs btn-delete-imagen" data-toggle="tooltip" data-placement="top" title="Eliminar" data-codi="<?= $imagen->codi_ial ?>"><i class="fa fa-times" aria-hidden="true"></i></button>
                                    <?php } ?>
                                </div>
                            <?php if ($cont == 2) { $cont = 0; ?>
                                </div>
                            <?php } else {$cont++;} ?>
                        <?php } ?>
                        <?php if (count($album->imagenes) == 0) { ?>
                            <p class="text-muted text-center well"><i>No se encontró imágenes</i></p>
                        <?php } ?>
                    </div>
                <?php } ?>
                <?php if (count($albumes) == 0) { ?>
                    <p class="text-muted text-center well"><i>No se encontró resultados</i></p>
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

<form id="form_custom" method="post" action="<?= base_url().'galeria/eliminar_imagen' ?>">
    <input type="hidden" name="codigo">
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
                        <div class="form-group box-titulo-album">
                            <label>Título*: </label>
                            <input class="form-control" name="titu_alb">
                        </div>
                        <div class="form-group box-fecha-album">
                            <label>Fecha de publicación*: </label>
                            <div class='input-group date box-date'>
                                <input type='text' class="form-control" name="fech_alb" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar">
                                    </span>
                                </span>
                            </div>
                        </div>
                        <div class="form-group box-imagen-upload">
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