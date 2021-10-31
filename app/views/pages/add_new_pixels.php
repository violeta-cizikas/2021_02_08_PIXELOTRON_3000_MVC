<?php
require APPROOT . '/views/inc/header.php'; ?>
<!-- jumbotron - demonstracine bootstrapo klase -->
<div class="jumbotron jumbotron-fluid">
		<div class="container">
			<h1><?php echo $data['title']?></h1>
			<!-- kuriama add new pixel forma --> 
			<form method="post">
				<div class="form-group">
					<input name="coordinate_x" min="1" max="480" type="number" class="form-control <?php echo (!empty($data['coordinate_xErr'])) ? 'is-invalid' : ''; ?>" placeholder="X coordinate">
					<span class='invalid-feedback'><?php echo $data['coordinate_xErr'] ?></span>
				</div>

				<div class="form-group">
					<input name="coordinate_y" min="1" max="480" type="number" class="form-control <?php echo (!empty($data['coordinate_yErr'])) ? 'is-invalid' : ''; ?>" placeholder="Y coordinate">
					<span class='invalid-feedback'><?php echo $data['coordinate_yErr'] ?></span>
				</div>

				<div class="form-group">
					<!-- spalvu gradient'o input'as -->
					<input name="color" type="color" class="form-control <?php echo (!empty($data['colorsErr'])) ? 'is-invalid' : ''; ?> colorCursorPointer" placeholder="Colors">

					<span class='invalid-feedback'><?php echo $data['colorslErr'] ?></span>
				</div>

				<div class="form-group">
				    <label for="formControlRange" id="pixelSize">Pixel size</label>
				    <input name="size" type="range" min="1" max="20" class="form-control-range rangeCursorPointer" id="formControlRange">
 				</div>

				<button type="submit" class="btn btn-primary"><?php echo $data['title']?></button>
			</form>
	</div>
</div>

<script>
	// teksto atsinaujinimas slider'yje
	let size = document.getElementById('formControlRange');
	size.addEventListener('change', function() {
		// pixelSize issitraukiams, kad sizeLabel.innerText butu galima pakeist teksta
		let sizeLabel = document.getElementById('pixelSize');
		// istraukiams input'as
		let range = document.getElementById('formControlRange');
		// is input'o istraukiamas value (reiksmes range.value issitraukimas)
		// atsinaujins atleidus pele, nes yra ivykis 'change' ir 
		// prie jo prirista f-ja, ir jos viduje atnaujinamas tekstas
		sizeLabel.innerText = `Pixel size ${range.value}`;
	});

	// papildymas ivykiu 'mousemove' ir jis gali buti naudojamas ant betkokio html elemento
	// naudojamas iskvieciant f-ja, kai judinama pele
	// atsinaujins judinant pele slider'i 
	size.addEventListener('mousemove', function() {
		let sizeLabel = document.getElementById('pixelSize');
		let range = document.getElementById('formControlRange');
		sizeLabel.innerText = `Pixel size ${range.value}`;
	});

</script>

<!-- footeryje uzdaromas html'as ir body -->
<?php require APPROOT . '/views/inc/footer.php';
