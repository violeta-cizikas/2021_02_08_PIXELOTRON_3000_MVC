<?php
require APPROOT . '/views/inc/header.php'; ?>

<div>
	<div class="container">
		<!-- pixeliu lenta -->
		<div class="pixelSpace">
			<!-- naudojamas foreach($pixel), kad kiekvienam pikseliui butu sukuriamas div'as -->
			<?php foreach($data['pixels'] as $pixel): ?>
				<div style="width: <?php echo $pixel['size']?>px;
							height: <?php echo $pixel['size']?>px;
							background-color: <?php echo $pixel['color']?>;
							top: <?php echo $pixel['coordinate_y']?>px;
							left: <?php echo $pixel['coordinate_x']?>px;
							position: absolute;">
				</div>
			<?php endforeach; ?>
		</div> 

		<!-- lentele idedama i kondicija--> 
		<?php if($data['showTable']): ?>
			<!-- pridetuju pikseliu lentele -->
			<br>   
			<table class="table table-hover table-dark">
			  	<thead>
					<tr>
					  	<th scope="col">Pixel ID</th>
					  	<th scope="col">Coordinate X</th>
					  	<th scope="col">Coordinate Y</th>
					  	<th scope="col">Pixel Color</th>
					  	<th scope="col">Pixel Size</th>
					  	<th scope="col">Actions</th>
					</tr>
			  	</thead>

			  	<tbody>
			  		<?php foreach($data['pixels'] as $pixel): ?>
						<tr>
						  	<th scope="row"><?php echo $pixel['pixel_id']?></th>
						  	<td><?php echo $pixel['coordinate_x']?></td>
						  	<td><?php echo $pixel['coordinate_y']?></td>
						  	<td><?php echo $pixel['color']?></td>
						  	<td><?php echo $pixel['size']?></td>
						  	<td>
						  		<!-- kai nera veiksmo (nesikeicia kazkas DB), - rekomenduojama naudoti http(interneto protokolas, kad bendrautu su beckend'u) metoda get -->
						  		<form style="display: inline;" method="get" action="<?php echo URLROOT?>/pages/pixel_edit">
						  			<!-- input naudojamas issiusti duomenis submit'inant forma -->
						  			<input type="hidden" name="pixel_id" value="<?php echo $pixel['pixel_id']?>">
						  			<button class="btn btn-primary btn-sm">Edit</button>
						  		</form>
						  		<!-- nesulauzomas space'as -->
						  		&nbsp;
						  		<!-- kai yra veiksmai (keiciantys kazka DB), - rekomenduojama del saugumo naudoti post metoda -->
						  		<form style="display: inline;" method="post" action="<?php echo URLROOT?>/pages/pixel_delete">
						  			<!-- input naudojamas issiusti duomenis submit'inant forma -->
						  			<input type="hidden" name="pixel_id" value="<?php echo $pixel['pixel_id']?>">
						  			<button type="submit" class="btn btn-danger btn-sm">Delete</button>
						  		</form>
						  	</td>
						</tr>
					<?php endforeach; ?>	
			  	</tbody>
			</table> 
		<?php endif; ?>  
	</div>
</div>

<!-- <?php
var_dump($data);
?> -->	

<?php require APPROOT . '/views/inc/footer.php';