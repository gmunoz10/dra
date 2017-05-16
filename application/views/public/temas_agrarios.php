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
 			<p>Son funciones de la <b>Dirección Regional de Agricultura</b>:</p>
 			<br>
 				<ul class="funciones-agrarios">
				 	<li>Formular, aprobar, ejecutar, evaluar, dirigir, controlar y administrar los planes y políticas de la región en materia agraria, en concordancia con las políticas nacionales y los planes sectoriales, y las propuestas promocionales de desarrollo rural de parte de las municipalidades rurales.</li>
				    <li>Promover la transformación, comercialización, exportación y consumo de productos naturales y agroindustriales de la Región.</li>
				    <li>Promover la provisión de recursos financieros privados a las empresas y organizaciones de la Región, con énfasis en las micro, pequeñas y medianas empresas y las unidades productivas orientadas a la exportación.</li>
				    <li>Planificar, promover y concertar con el sector privado, la elaboración de planes y proyectos de desarrollo agrario y agroindustrial.</li>
				    <li>Cumplir y hacer cumplir las normas sobre los recursos naturales y de la actividad agraria, en coordinación con los Proyectos y Organismos Públicos Descentralizados.</li>
				    <li>Promover las actividades que faciliten la organización de los productores agrarios para el desarrollo de la cadena productiva de los productos más significativos.</li>
				    <li>Promover la creación de organizaciones agrarias privadas de tipo empresarial regional y local vinculadas a las cadenas productivas de los productos más significativos.</li>
				    <li>Velar por el cumplimiento de la normatividad concerniente al sector agrario en el ámbito regional.</li>
				    <li>Canalizar los flujos de información de interés sectorial regional desde y hacia los agentes económicos regionales.</li>
				    <li>Resolver en segunda instancia administrativa las impugnaciones que se interpongan contra resoluciones de primera instancia que versen en materia de aguas, únicamente en los ámbitos jurisdiccionales donde no se hayan conformado las Autoridades Autónomas de la Cuenca Hidrográfica.</li>
				    <li>Promover la formulación de propuestas de mecanismos de integración de la actividad agraria a nivel de cuenca con los gobiernos locales y entre el área rural y la urbana, a partir del conocimiento especializado de las cuencas productivas más importantes.</li>
				    <li>Participar en el seguimiento y evaluación del desempeño institucional del sector.</li>
				    <li>Proponer al Gobierno Regional de Lima los programas y proyectos agrarios para el desarrollo de la región.</li>
				    <li>Cumplir otras funciones asignadas por el Gobierno Regional de Lima.</li>
 				</ul>
 			<br>
      	</div>
      </div>
    </section>
</section>