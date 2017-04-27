<div class="container-page-header" style="background-image: url('<?= asset_url() ?>img/background/galeria.jpg');">
    <button class="btn btn-youtube-home"><i class="fa fa-youtube" aria-hidden="true"></i></button>
    <button class="btn btn-twitter-home"><i class="fa fa-twitter" aria-hidden="true"></i></button>
    <a class="btn btn-facebook-home" href="https://www.facebook.com/DRALoficial/" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
</div>
<section class="container container-page-inner" style="background-color: #9b9b9b;line-height: 1.42857143;">
    <section>
      <div class="col-lg-12" style="padding-left: 75px; padding-bottom: 30px;">
 			<h3 style="font-weight: bold; color: white;"><span>Galería</span>
 			<div class="form-inline pull-right">
              <div class="form-group">
                <input id="txt_search" value="<?= $search ?>" type="text" class="form-control" placeholder="Buscar...">
              </div>
              <button id="btn_search" type="submit" class="btn btn-default">Buscar</button>
            </div>
            </h3>
 			<div class="resultado-galeria">
 				<?php foreach ($albumes as $key => $album) { ?>
  				<div class="col-lg-12 box-content-o box-bold" style="margin-top: <?= ($key == 0) ? "0" : "30"; ?>px;">
             <h4 class="title-sisgedo" style="margin-bottom: 5px;">
               <b style="vertical-align: middle;"><?= $album->titu_alb ?></b>
               &nbsp;
             </h4>
             <p style="color: #666"><i>Publicado por <b><?= $album->nomb_usu ?></b></i><span class="pull-right"><i class="fa fa-clock-o" aria-hidden="true"></i> <i>Fecha de publicación: <?= date("d/m/Y h:i A", strtotime($album->fech_alb)) ?></i></span></p>
             <hr style="border-color: #999; margin-top: 10px; margin-bottom: 10px;">
             <div class="col-md-12" style="padding: 0px;">
               <?php $cont = 0; foreach ($album->imagenes as $key => $imagen) { ?>
                 <?php if ($cont == 0) { ?>
                   <div class="col-md-12">
                 <?php } ?>
                 <div class="col-sm-4 a-imagen-galeria">
                   <a href="<?= asset_url() ?>galeria/<?= $imagen->imag_ial ?>" data-toggle="lightbox" data-gallery="example-gallery">
                     <img src="<?= asset_url() ?>galeria/<?= $imagen->imag_ial ?>" class="img-thumbnail img-responsive img-fluid">
                   </a>
                 </div>
                 <?php if ($cont == 2 || $key == count($album->imagenes)-1) { $cont = 0; ?>
                    </div>
                 <?php } else {$cont++;} ?>
               <?php } ?>
               <?php if (count($album->imagenes) == 0) { ?>
                 <p class="text-muted text-center well"><i>No se encontró imágenes</i></p>
               <?php } ?>
             </div>
          </div>
        <?php } ?>
        <?php if (count($albumes) == 0) { ?>
            <p class="text-muted text-center well"><i>No se encontró resultados</i></p>
        <?php } ?>
        <div class="col-lg-12 text-center">
            <ul class="pagination">
                <?php for ($i=1; $i <= $pages ; $i++) { ?>
                  <li class="<?= ((int) $i == (int) $page) ? "active" : "" ?>"><a href="<?= base_url() . 'galeria/' . $i ?>"><?= $i ?></a></li>
                <?php } ?>
            </ul>
        </div>
 			</div>
 			<p style="text-align: center; margin-top: 25px; margin-bottom: 25px;">
 			</p>
      </div>
    </section>
</section>
