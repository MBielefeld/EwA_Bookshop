<?php
if ((((isset($_POST['Name'])) and ($_POST['Name'] !== ""))and((isset($_POST['Passwort'])) and ($_POST['Passwort'] !== "")))
and ((isset($_POST['Adresse'])) and ($_POST['Adresse'] !== ""))){
	
	$link = new mysqli("localhost", "G04", "qe43z", "g04" );   
	$link->query("SET NAMES 'utf8'");
	$query = "";
	if ($link->connect_error ){
		die ("NoDBengine?" . $link->connect_error);
	}
	else {
		
		$query = "Select Count(*) as Menge from user where Username like '".$_POST['Name']."'";
		
		$result =   $link->query ( $query ) or die ("Wrong query !?" . mysqlerror());
			
		$row = $result->fetch_assoc();
			
		$Eintraege = $row['Menge'];
		
		if($Eintraege == 0){
			
			$query = "Select Max(UserID) as ID from user";
			
			$result =   $link->query ( $query ) or die ("Wrong query !?" . mysqlerror());
			
			$row = $result->fetch_assoc();
			
			$Eintraege = $row['ID'] + 1;
			
			$hash = md5($_POST['Passwort']);
			
			//echo  'Name: '.$_POST['Name'].' pw: '.$hash.' ID: '.$Eintraege;
			
			if ((isset($_POST['Anrede'])) and ($_POST['Anrede'] !== "")){
				
				$Anrede = $_POST['Anrede'];
				
			}else {
				
				$Anrede = "";
				
			}
			
			$query = "insert into user (Username , Userpwmd5 , UserID , UserAnrede , UserAdresse ) values ('".$_POST['Name']."','".$hash."','".$Eintraege."','".$Anrede."','".$_POST['Adresse']."')";
			
			$result =   $link->query ( $query ) or die ("Wrong query !?" . mysqlerror());
			
			echo "Eintrag erfolgreich.";
			
			$link->close();
			
		}else {
			echo 'Name vorhanden';
		}
	}
	
}else{
	//echo 'Formulardaten pruefen. ';
}
?>

<!--Hauptelement-->
<div class="middle well col-md-8">
	<!-- Kontaktformular -->
	<form id="registrierung" name="registrierung" action="/EWA/G04/EwA_Projekt/registrierung.php" method="POST">
		<div>
			
			<select name="Anrede" class="form-control">
				<option value="Herr">Herr</option>
				<option value="Frau">Frau</option>
				<option value="Mensch">Mensch</option>
			</select>
			<div class="form-group">
				<label for="Name">Name: </label>
				<input class="form-control" type="text" min=3 id="Name" name="Name" />
			</div>

			<div class="form-group">
				<label for="Passwort">Passwort:</label>
				<input class="form-control" type="text" min=5 id="Passwort" name="Passwort" />
			</div>
			<div class="form-group">
				<label for="Adresse">Adresse:</label>
				<input class="form-control" type="text" min=5 id="Adresse" name="Adresse" />
			</div>
		</div>
		<div>
			<input class="btn btn-default" type="submit" value="Registrieren" />
		</div>
	</form>
	<!-- Ende Kontaktformular-->
</div>
<!-- Ende Hauptelement -->
