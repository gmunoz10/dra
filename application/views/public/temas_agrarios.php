<div class="container-page-header" style="background-image: url('<?= asset_url() ?>img/background/vision-mision.jpg');">
    <a class="btn btn-youtube-home" href="https://www.youtube.com/channel/UCk1ZPrg8G-hMKDcT8Rk6HJg" target="_blank"><i class="fa fa-youtube" aria-hidden="true"></i></a>
    <a class="btn btn-twitter-home" href="https://twitter.com/DRAL59954891" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
    <a class="btn btn-facebook-home" href="https://www.facebook.com/DRALoficial/" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
</div>
<section class="container container-page-inner">
    <section>
      <div class="col-lg-11 box-padding-75" style="padding-left: 75px; line-height: 1.42857143;">
      	<div class="box-padding-75" style="padding-left: 75px;">
      		<div class="col-lg-12 no-padding" style="margin-bottom: 30px;">
		      <div class="box-temas_agrarios">
		        <h3><a href="<?= base_url() . 'tema_agrario/page' ?>" style="color: rgba(14,130,64, 1);">Temas agrarios</a></h3>
		        <div id="carousel-temas_agrarios" class="carousel slide carousel-temas_agrarios" data-ride="carousel">
		          <!-- Indicators -->
		          <ol class="carousel-indicators">
		            <?php foreach ($temas_agrarios as $key => $tema_agrario) { ?>
		              <li data-target="#carousel-temas_agrarios" data-slide-to="<?= $key ?>" class="<?= ($key == 0) ? "active" : "" ?>"></li>
		            <?php } ?>
		          </ol>

		          <!-- Wrapper for slides -->
		          <div class="carousel-inner" role="listbox">
		            <?php foreach ($temas_agrarios as $key => $tema_agrario) { ?>
		              <div data-codi="<?= $tema_agrario->codi_tea ?>" class="item <?= ($key == 0) ? "active" : "" ?>">
		                <img src="<?= asset_url() ?>tema_agrario/<?= $tema_agrario->imag_tea ?>" alt="...">
		                <div class="carousel-caption">
		                  <h4><?= $tema_agrario->titu_tea ?></h4>
		                  <?= limit_to(strip_tags($tema_agrario->cont_tea), 120) ?>...
		                </div>
		              </div>
		            <?php } ?>
		          </div>
		          <div class="carousel-more">
		          <p class="carousel-share">
		            <b><i style="color: white;">Comparte en: </i></b>
		            <button type="button" class="btn btn-twitter btn-circle">
		              <i class="fa fa-twitter" aria-hidden="true"></i>
		            </button>
		            <button type="button" class="btn btn-facebook btn-circle">
		              <i class="fa fa-facebook" aria-hidden="true"></i>
		            </button>
		            <button type="button" class="btn btn-document btn-circle">
		              <i class="fa fa-file" aria-hidden="true"></i>
		            </button>
		            <button type="button" class="btn btn-feed btn-circle">
		              <i class="fa fa-rss" aria-hidden="true"></i>
		            </button>

		            <span id="tema_agrario_link" href="#" class="carousel-link" style="cursor: pointer; color: #f8bf00;"><b>Ver mas</b></span>
		          </p>
		          </div>
		        </div>
		      </div>
		    </div>
      	</div>
      </div>
    </section>
</section>