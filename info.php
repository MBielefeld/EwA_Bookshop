<!--Hauptelement-->
<div class="middle well col-md-8">
	<?php
	   
	   $useragent = $_SERVER ['HTTP_USER_AGENT'];
	   $producer = strstr($useragent, '/', true);
	   echo $producer;

	?>
</div>
<!--Ende Hauptelement-->