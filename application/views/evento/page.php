<div class="container-page-header" style="height: auto; padding-bottom: 50px;">
	<section>
		<div class="row">
			<div class="box-content box-bold col-md-8 col-md-offset-2" style="line-height: 1.42857143;">
			    <h3 class="title-sisgedo" style="margin-bottom: 5px;"><a href="<?= base_url(). "evento/page" ?>">Eventos</a></h3>
			    <br>
        		<?php foreach ($eventos as $key => $evento) { ?>
					<div class="col-lg-12" style="margin-bottom: 30px;">
			    		<hr style="border-color: #999; margin-top: 10px; margin-bottom: 10px;">
					    <h4 class="title-sisgedo" style="margin-bottom: 5px;"><a href="<?= base_url() . 'evento/' . $evento->codi_eve ?>"><span style="color: #666"><?= $evento->nume_eve ?>: </span><b><?= $evento->titu_eve ?></b></a></h4>
					    <p style="color: #666"><i>Publicado por <b><?= $evento->nomb_usu ?></b></i><span class="pull-right"><i class="fa fa-clock-o" aria-hidden="true"></i> <i>Fecha de publicación: <?= date("d/m/Y h:i A", strtotime($evento->fech_eve)) ?></i></span></p>
					    <hr style="border-color: #999; margin-top: 10px; margin-bottom: 10px;">
						<div class="col-lg-4">
							<img src="<?= asset_url() ?>evento/<?= $evento->imag_eve ?>" class="img-thumbnail img-responsive">
					  	</div>
						<div class="col-lg-8">
							<p><?= limit_to(strip_tags($evento->cont_eve), 512) ?>...</p>
							<a href="<?= base_url() . 'evento/' . $evento->codi_eve ?>" class="pull-right" style="font-weight: bold;">Ver nota completa</a>
					  	</div>
						<div class="col-lg-12" style="margin-top: 15px;">
							<b><i>Comparte en: </i></b>
					        <button type="button" class="btn btn-twitter btn-circle">
					          <i class="fa fa-twitter" aria-hidden="true"></i>
					        </button>
					        <button type="button" class="btn btn-facebook btn-circle" data-href="<?= base_url() . 'evento/' . $evento->codi_eve ?>">
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
						  <li class="<?= ((int) $i == (int) $page) ? "active" : "" ?>"><a href="<?= base_url() . 'evento/page/' . $i ?>"><?= $i ?></a></li>
        				<?php } ?>
					</ul>
		  		</div>
		  </div>
		</div>
	</section>
</div>
