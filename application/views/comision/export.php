<?php
	function base64_encode_image($filename=string,$filetype=string) {
	    if ($filename) {
	        $imgbinary = fread(fopen($filename, "r"), filesize($filename));
	        return 'data:image/' . $filetype . ';base64,' . base64_encode($imgbinary);
	    }
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title></title>
<link href="<?= asset_url() ?>plugins/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
<style type="text/css">
	table thead tr th {
		text-align: center !important;
		vertical-align: middle !important;
		font-size: 12px;
	}
</style>
</head>
<body>
	<div>
		<table>
			<tr>
				<td>
    				<img src="data:image/png;base64,<?= base64_encode(file_get_contents(asset_url().'img/brand/logo.png')) ?>" style="height: 35px;">
				</td>
				<td style="padding-left: 10px; font-size: 12px;" class="text-muted">DIRECCIÓN<br>REGIONAL DE<br>AGRICULTURA</td>
			</tr>
		</table>
	</div>
	<br>
	<h3 style="text-align: center; margin-bottom: 5px; padding-bottom: 0px;">REPORTE DE COMISIONES: <?= $tipo ?></h3>
	<p style="text-align: center; margin-top: 0px; padding-top: 0px;"><b>Fecha: </b><?= date('d/m/Y', strtotime($date)) ?></p>
	<br>
	<table class="table table-bordered table-asistencia">
		<thead>
			<tr>
				<th>N°</th>
				<th>APELLIDOS Y NOMBRES</th>
				<th>INICIO</th>
				<th>FIN</th>
				<th>OBSSERVACIÓN</th>
			</tr>
		</thead>
		<tbody>
			<?php $i = 1; foreach ($comisiones as $row) { ?>
				<tr>
					<td style="text-align: center;">
						<?= $i ?>
					</td>
					<td>
						<?= $row->full_asi ?>
					</td>
					<td style="text-align: center;">
						<?= $row->ingr_dco ?>
					</td>
					<td style="text-align: center;">
						<?= $row->sali_dco ?>
					</td>
					<td style="text-align: center;">
						<?= $row->obsv_dco ?>
					</td>
				</tr>
			<?php $i++; } ?>
		</tbody>
	</table>

    <script src="<?= asset_url() ?>plugins/bootstrap/dist/js/bootstrap.js"></script>        
</body>
</html>