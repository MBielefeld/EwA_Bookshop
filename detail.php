<!--Hauptelement-->
<div class="middle well col-md-8">
	<?php
		$ID=0;
		if ((isset($_GET['ID'])) and ($_GET['ID'] !== "")){
			$ID = $_GET['ID'];
		}

		$link = new mysqli("localhost", "G04", "qe43z", "g04" );   
		$link->query("SET NAMES 'utf8'");
		if ($link->connect_error ){
			die ("NoDBengine?" . $link->connect_error);
		}
		else {
			$query = "select * from buecher where ProduktID = ".$ID; 
			$result =   $link->query ( $query ) or die ("Wrong query !?" . mysqlerror());
			// now output data 
			if ( $result->num_rows > 0 ) 
			{
				echo '<table class="table table-bordered table-striped">';
				while ($row = $result->fetch_assoc()) {
					echo '<tr><th>'.$row['ProduktTitel'].'</th><th>'.$row['Autorname'].'</th><th>'.$row['Kurzinhalt'].'</th></tr>';
				}
				echo '</table>';
				}
			$link->close();    
		}
	?>
</div>
<!--Ende Hauptelement-->