<?php


$SPHPW = 0.00;
$SPHPG = 0.00;

$SPHPA = 0;
$PHPRA = 0;
$PHPKA= 0;

if ((isset($_POST['SelfPHP'])) and ($_POST['SelfPHP'] !== ""))
{
	$SPHPW += $_POST['SelfPHP'] * 25.40 ;
	$SPHPG = $_POST['SelfPHP'] * 800 ;
	$SPHPA = $_POST['SelfPHP'];
}
if ((isset($_POST['PHPR'])) and ($_POST['PHPR'] !== ""))
{
	$SPHPW += $_POST['PHPR'] * 18 ;
	$SPHPG += $_POST['PHPR'] * 600 ;
	$PHPRA = $_POST['PHPR'];
}
if ((isset($_POST['PHPK'])) and ($_POST['PHPK'] !== ""))
{
	$SPHPW += $_POST['PHPK'] * 39 ;
	$SPHPG += $_POST['PHPK'] * 1300 ;
	$PHPKA= $_POST['PHPK'];
}

$BRUTTO = $SPHPW * 1.07;
$VERSAND = 0;

if ($BRUTTO < 100){
	if ($SPHPG <= 1000){
		$VERSAND = 4;}
	else if ( $SPHPG <= 2000 ){
		$VERSAND = 4.5;}
	else if ( $SPHPG <= 5000){
		$VERSAND = 6.99;}
	else if ($SPHPG <= 10000){
		$VERSAND = 10;}
	else if ( $SPHPG <= 31500 ){
		$VERSAND = 16.49;}
}

?>

<!--Hauptelement-->
<div class="middle well col-md-8">
	<!-- Kontaktformular -->
	
<?php

	echo 'Preis : (netto) '.$SPHPW.' € / (brutto) '.$BRUTTO.' € | GEWICHT : '.$SPHPG.' g Versandpreis : '.$VERSAND.' €';

?>
	
	<form id="bestellformular" name="bestellformular" action="/EWA/G04/EwA_Projekt/berechnung.php" method="POST">
		<div>
			<div class="form-group">
				<label for="SelfPHP">SelfPHP Anzahl:</label>
				<input class="form-control" type="number" min=0 id="SelfPHP" name="SelfPHP" value="<?php echo $SPHPA;?>" />
			</div>

			<div class="form-group">
				<label for="PHPR">PHP-Referenz Anzahl:</label>
				<input class="form-control" type="number" min=0 id="PHPR" name="PHPR" value="<?php echo $PHPRA;?>" />
			</div>

			<div class="form-group">
				<label for="PHPK">PHP-Kochbuch Anzahl:</label>
				<input class="form-control" type="number" min=0 id="PHPK" name="PHPK" value="<?php echo $PHPKA;?>" />
			</div>

			<select class="form-control">
				<option value="Stammkunde">Stammkunde</option>
				<option value="TV Werbung">TV Werbung</option>
				<option value="Telefonbuch">Telefonbuch</option>
				<option value="Mundpropaganda">Mundpropaganda</option>
			</select>
		</div>
		<div>
			<input class="btn btn-default" type="submit" value="Bestellen" />
		</div>
	</form>
	<!-- Ende Kontaktformular-->
</div>
<!-- Ende Hauptelement -->