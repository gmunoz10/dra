<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.8&appId=1327135627399921";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class="container-page-header" style="height: auto; padding-bottom: 50px;">
	<section>
		<div class="row">
			<div class="box-content box-bold col-md-8 col-md-offset-2" style="line-height: 1.42857143;">
				<div class="col-lg-12" style="margin-bottom: 30px;">
					<a href="javascript:history.back(1)" class="btn btn-orange pull-right">Volver Atrás</a>			   
		  		</div>
			    <h3 class="title-sisgedo" style="margin-bottom: 5px;"><a href="<?= base_url(). "evento/" . $evento->codi_eve ?>"><?= $evento->titu_eve ?></a></h3>
			    <p style="color: #666"><span><?= $evento->nume_eve ?></span> - <i>Publicado por <b><?= $evento->nomb_usu ?></b></i><span class="pull-right"><i class="fa fa-clock-o" aria-hidden="true"></i> <i>Fecha de publicación: <?= date("d/m/Y h:i A", strtotime($evento->fech_eve)) ?></i></span></p>
			    <hr>
				<div class="col-lg-12 text-center">
					<img src="<?= asset_url() . "evento/" . $evento->imag_eve ?>" class="img-thumbnail img-responsive">
	            </div>
				<div class="col-lg-12" style="margin-top: 15px;">
					<?= $evento->cont_eve ?>
		  		</div>
				<div class="col-lg-12" style="margin-top: 15px;">
			  		<b><i>Comparte en: </i></b>
			        <button type="button" class="btn btn-twitter btn-circle" data-href="<?= base_url(). "evento/" . $evento->codi_eve ?>">
			          <i class="fa fa-twitter" aria-hidden="true"></i>
			        </button>
			        <button type="button" class="btn btn-facebook btn-circle" data-href="<?= base_url(). "evento/" . $evento->codi_eve ?>">
			          <i class="fa fa-facebook" aria-hidden="true"></i>
			        </button>
		  		</div>
				<?php if ($evento->id_fb != "") { ?>
		  		<br>
		  		<br>
			    <hr>
				<div class="col-lg-12 text-center">
					<div class="fb-comments" data-href="https://www.facebook.com/<?= $pageId ?>/posts/<?= str_replace($pageId."_", "",$evento->id_fb) ?>" data-numposts="5">
					</div>
		  		</div>
				<?php } ?>
				<div class="col-lg-12" style="margin-top: 30px;">
					<a href="javascript:history.back(1)" class="btn btn-orange pull-right">Volver Atrás</a>			   
		  		</div>
		  </div>
		</div>
	</section>
</div>
