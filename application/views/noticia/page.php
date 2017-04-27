<div class="container-page-header" style="height: auto; padding-bottom: 50px;">
	<section>
		<div class="row">
			<div class="box-content box-bold col-md-8 col-md-offset-2" style="line-height: 1.42857143;">
			    <h3 class="title-sisgedo" style="margin-bottom: 5px;"><a href="<?= base_url(). "noticia/page" ?>">Noticias</a></h3>
			    <br>
        		<?php foreach ($noticias as $key => $noticia) { ?>
					<div class="col-lg-12" style="margin-bottom: 30px;">
			    		<hr style="border-color: #999; margin-top: 10px; margin-bottom: 10px;">
					    <h4 class="title-sisgedo" style="margin-bottom: 5px;"><a href="<?= base_url() . 'noticia/' . $noticia->codi_not ?>"><span style="color: #666"><?= $noticia->nume_not ?>: </span><b><?= $noticia->titu_not ?></b></a></h4>
					    <p style="color: #666"><i>Publicado por <b><?= $noticia->nomb_usu ?></b></i><span class="pull-right"><i class="fa fa-clock-o" aria-hidden="true"></i> <i>Fecha de publicación: <?= date("d/m/Y h:i A", strtotime($noticia->fech_not)) ?></i></span></p>
					    <hr style="border-color: #999; margin-top: 10px; margin-bottom: 10px;">
						<div class="col-lg-4">
							<img src="<?= asset_url() ?>noticia/<?= $noticia->imag_not ?>" class="img-thumbnail img-responsive">
					  	</div>
						<div class="col-lg-8">
							<p><?= limit_to(strip_tags($noticia->cont_not), 512) ?>...</p>
							<a href="<?= base_url() . 'noticia/' . $noticia->codi_not ?>" class="pull-right" style="font-weight: bold;">Ver nota completa</a>
					  	</div>
						<div class="col-lg-12" style="margin-top: 15px;">
							<b><i>Comparte en: </i></b>
					        <button type="button" class="btn btn-twitter btn-circle">
					          <i class="fa fa-twitter" aria-hidden="true"></i>
					        </button>
					        <button type="button" class="btn btn-facebook btn-circle" data-href="<?= base_url() . 'noticia/' . $noticia->codi_not ?>">
					          <i class="fa fa-facebook" aria-hidden="true"></i>
					        </button>
					        <button type="button" class="btn btn-document btn-circle">
					          <i class="fa fa-file" aria-hidden="true"></i>
					        </button>
					        <button type="button" class="btn btn-feed btn-circle">
					          <i class="fa fa-rss" aria-hidden="true"></i>
					        </button>
					  	</div>
				  	</div>
        		<?php } ?>
				<div class="col-lg-12 text-center">
	        		<ul class="pagination">
        				<?php for ($i=1; $i <= $pages ; $i++) { ?>
						  <li class="<?= ((int) $i == (int) $page) ? "active" : "" ?>"><a href="<?= base_url() . 'noticia/page/' . $i ?>"><?= $i ?></a></li>
        				<?php } ?>
					</ul>
		  		</div>
				<div class="col-lg-12 text-center">
					<div class="fb-page" data-href="https://www.facebook.com/DRALoficial/" data-tabs="timeline" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="false"><blockquote cite="https://www.facebook.com/DRALoficial/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/DRALoficial/">DRAL oficial</a></blockquote></div>
		  		</div>
		  </div>
		</div>
	</section>
</div>
