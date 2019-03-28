<!--Hauptelement-->
<div class="middle well col-md-8">
	<?php
		$zeilenanzahl = 11;
		echo '<table class="table table-bordered table-striped">';
		
		for ($i = 1; $i < $zeilenanzahl; $i++){
			echo '<tr><th>Nr.'.$i.'</th><th>produkt'.$i.'</th></tr>';
		}
		echo '</table>';
	?>	
</div>
<!--Ende Hauptelement-->