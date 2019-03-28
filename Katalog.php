<?php
define("MAX_EINTRAEGE",10);

function navigationsLeiste($SitesComplete,$seiteAktuell,$extVariables){
        
    // Die Menge der angezeigten Links für die Seiten werden errechnet 
    $NavCeil = floor( 11 / 2);
    $string = "";
    // Eine Seite zurück oder zum Anfang nur anzeigen, wenn mindestens eine Seite zurück
    // geblättert werden kann 
    if($seiteAktuell > 1){
        $string .= '<a href="Katalog.php?site=1'.$extVariables.'"><<</a>&nbsp;&nbsp;';
        $string .= '<a href="Katalog.php?site='.($seiteAktuell-1).$extVariables.'">
            <</a>&nbsp;&nbsp;';
    }
    
    // Baut die Seitennavigation aúf (1 2 3 4 5 6 ... n)
    for($x=$seiteAktuell-$NavCeil;$x<=$seiteAktuell+$NavCeil;$x++){
        // Alle Seitenzahlen vor und nach der aktuellen Seite verlinken
        if(($x>0 && $x<$seiteAktuell) || ($x>$seiteAktuell && $x<=$SitesComplete))
            $string .= '<a href="Katalog.php?site='.$x.$extVariables.'">'.$x.'</a>&nbsp;&nbsp;';
        
        // Die Seitenzahl der aktuellen Seite nicht verlinken
        if($x==$seiteAktuell)
            $string .= $x . '&nbsp;&nbsp;';
    }
    
    // Eine Seite vor oder zum Ende nur anzeigen, wenn mindestens eine Seite weiter
    // geblättert werden kann 
    if($seiteAktuell < $SitesComplete){
        $string .= '<a href="Katalog.php?site='.($seiteAktuell+1).$extVariables.'">>
         </a>&nbsp;&nbsp;';
        $string .= '<a href="Katalog.php?site='.$SitesComplete.$extVariables.'">>>
          </a>&nbsp;&nbsp;';
    }
    
    return $string;
    
}
?>

<!--Hauptelement-->
<div class="middle well col-md-8">
	<?php
	
	// Die aktuell angeforderte Seite
	if (isset($_GET['site']))
	$seiteAktuell = $_GET['site'] + 0;

	// Falls noch keine Seitenzahl übergeben wurde, den Wert auf die erste Seite setzen
	if(empty($seiteAktuell))
	$seiteAktuell = 1;

	// Berechnet die nächsten Eintraege aus MAX_EINTRAEGE
	$start = $seiteAktuell * MAX_EINTRAEGE - MAX_EINTRAEGE; 

	
	$link = new mysqli("localhost", "G04", "qe43z", "g04" );   
	$link->query("SET NAMES 'utf8'");
	$query = "";
	if ($link->connect_error ){
		die ("NoDBengine?" . $link->connect_error);
	}
	else {
		if (((isset ($_GET['Buchtitel'])) and ($_GET['Buchtitel'] !== "")) and ((isset ($_GET['Autor'])) and ($_GET['Autor'] !== ""))){
			
		$query = "select * from buecher WHERE ( ProduktTitel like '%".$_GET['Buchtitel']."%' ) and ( Autorname like '%".$_GET['Autor']."%' ) LIMIT $start, ".MAX_EINTRAEGE;
		$query2 = "SELECT COUNT(*) AS menge FROM buecher WHERE ( ProduktTitel like '%".$_GET['Buchtitel']."%' ) and ( Autorname like '%".$_GET['Autor']."%' )";
		}
		else if ((isset ($_GET['Buchtitel'])) and ($_GET['Buchtitel'] !== ""))
		{
			
			$query = "select * from buecher WHERE ProduktTitel like '%".$_GET['Buchtitel']."%' LIMIT $start, ".MAX_EINTRAEGE;
			$query2 = "SELECT COUNT(*) AS menge FROM buecher WHERE ProduktTitel like '%".$_GET['Buchtitel']."%'";
			
		} else if ((isset ($_GET['Autor'])) and ($_GET['Autor'] !== "")){
			$query = "select * from buecher WHERE Autorname like '%".$_GET['Autor']."%' LIMIT $start, ".MAX_EINTRAEGE;
			$query2 = "SELECT COUNT(*) AS menge FROM buecher WHERE Autorname like '%".$_GET['Autor']."%'";
		}else {
		$query = "select * from buecher LIMIT $start, ".MAX_EINTRAEGE; 
		$query2 = "SELECT COUNT(*) AS menge FROM buecher";}
		//$query = "select * from buecher";
		$result =   $link->query ( $query ) or die ("Wrong query !?" . mysqlerror());
		
		
		$resultGesamt = $link->query ( $query2 ) or die ("Wrong query !?" . mysqlerror());
		$row = $resultGesamt->fetch_assoc();
		$Eintraege = $row['menge'];
		$contentWeb = "";
		// now output data 
		if ( $result->num_rows > 0 ) 
		{
			$contentWeb .=   '<table class="table table-bordered table-striped">';
			while ($row = $result->fetch_assoc()) {
			$contentWeb .='<tr><th>'.$row['ProduktTitel'].'</th><th>'.$row['Autorname'].'</th><th><a href="/EWA/G04/EwA_Projekt/detail.php?ID='.$row['ProduktID'].'">Detailinformationen</a></th></tr>';
			}
			$contentWeb .=  '</table>';
		}else{
			$contentWeb .= 'Keine Ergebnisse gefunden. <br>';
		}
		$link->close(); 
		
		// Errechnet die kompletten Seiten
		$SitesComplete = ceil($Eintraege / MAX_EINTRAEGE);
		
		// Ergebnisseite x von y anzeigen
		$contentWeb .= 'Ergebnisseite ' . $seiteAktuell . ' von ' . $SitesComplete . '<br>';

		// Weitere Variablen den Seitenzahlem mit übergeben in Form:
		// &var1=wert1&var2=wert2
		$BuchT = "";
		$Autor = "";
		
		if (isset($_GET['Buchtitel']))
		$BuchT = $_GET['Buchtitel'];
		
		if (isset($_GET['Autor']))
		$Autor = $_GET['Autor'];
		
		$extVariables = '&Buchtitel='.$BuchT.'&Autor='.$Autor;

		// Navigation mit in Ausgabe einfügen
		$contentWeb .= navigationsLeiste($SitesComplete,$seiteAktuell,$extVariables); 

		
		echo $contentWeb;   
	}
	?>
</div>
<!--Ende Hauptelement-->