 <?php 
if (((isset($_POST['action'])) and ($_POST['action'] !== "")) and ((isset($_POST['username'])) and ($_POST['username'] !== ""))){
	
if($_POST['action'] == 'logout'){ 
    session_start(); 
    session_unset(); 
    session_destroy(); 
} else {

    // Den Dateinamen zusammenbauen und dem Pfad anhaengen. 
    // Das Ergebnis koennte so aussehen: 
    // "./users/Daniel%20Kresslere.txt" 
    //$filepath = '../admin/users/' . rawurlencode($_POST['username']) . '.txt'; 

	$link = new mysqli("localhost", "G04", "qe43z", "g04" );   
	$link->query("SET NAMES 'utf8'");
	$query = "";
	if ($link->connect_error ){
		die ("NoDBengine?" . $link->connect_error);
	}
	else {
		
		$query = "select * from user where Username like '".$_POST['username']."'";
		$result =   $link->query ( $query ) or die ("Wrong query !?" . mysqlerror());
		$row = $result->fetch_assoc();
		$Name = $row['Username'];
		$ID = $row['UserID'];
		$hash_db = $row['Userpwmd5'];

		//if(file_exists($filepath)){ 
		if($Name !== ""){
		// Array mit Userguppen 
		//$usergroups = array(0 => 'Normale User', 
		//					1 => 'Mitwirkende', 
		//					2 => 'Administratoren'); 

		//	$userdata = file($filepath); 

			// $userdata[2] enthaelt den Passwort-Hash 
			if(trim($hash_db) !== md5($_POST['password'])){ 

				// Hier verweigern Sie den Zutritt. 

				header('location: /EWA/G04/EwA_Projekt/login.php?error'); 

				exit(); 
			} 

			session_start(); 

			// $userdata[0] enthaelt die User ID. 
			$_SESSION['uid'] = trim($ID); 

			// $userdata[1] enthaelt den Username. 
			$_SESSION['uname'] = trim($Name); 

			// $userdata[3] enthaelt die Usergroup ID. 
			//$_SESSION['ugid'] = $userdata[3];        
			 
			// Mit der Usergroup ID kann man das betreffende 
			// Element im Array "$usergroups" selektieren. 
			//$_SESSION['ug'] = $usergroups[$userdata[3]]; 

			header('location: /EWA/G04/EwA_Projekt/home.html?' . SID); 
			
			//exit();
			
		}else{ 

			// Hier verweigern Sie den Zutritt ebenfalls. 

			header('location: /EWA/G04/EwA_Projekt/login.php?error'); 
		} 
	}
	
	}
}else{ 
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" 
     "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"> 
<html> 
    <head> 
        <title> 
            FBL-System 
        </title> 
        <meta http-equiv="content-type" 
            content="text/html; charset=ISO-8859-1" /> 
        <style type="text/css" media="screen"> 
            <!-- 
            table{ 
                font-family: arial, sans-serif; 
            } 
            .container{ 
                width: 100%; 
                text-align: center; 
            } 
            .loginform{ 
                border-width: 10px; 
                border-style: solid; 
                border-color: #EEEEEE; 
                background-color: #FFFFE0; 
            } 
            .vxhtml{ 
                border-width: 0px; 
                height: 31px; 
                width: 88px; 
            } 
            --> 
        </style> 
    </head> 
    <body> 
        <table class="container"> 
            <tr> 
                <td> 

                    <table cellpadding="0" cellspacing="0"> 
                        <tr> 
                           <td> 
                                FBL-System<br /> 
                                <br /> 
                            </td> 
                        </tr> 
                    </table> 
<?php 
// Im Falle einer Falschen Eingabe 
if(isset($_GET['error'])){ ?> 
                    <table cellpadding="0" cellspacing="0"> 
                        <tr> 
                            <td> 
                                Die eingegebenen Daten sind falsch! 
                            </td> 
                        </tr> 
                    </table> 
<?php } ?> 
                    <form action="login.php" method="post"> 
                        <table class="loginform" cellpadding="10" cellspacing="0"> 
                            <tr> 
                                <td> 
                                    Test Username:<br> 
                                    Test Passwort: 
                                </td> 
                                <td> 
                                    USER<br> 
                                    TEST<br> 
                                </td> 
                            </tr> 
                            <tr> 
                                <td> 
                                    Username:&nbsp; 
                                </td> 
                                <td> 
                                    <input type="text" name="username" size="20" /> 
                                </td> 
                            </tr> 
                            <tr> 
                                <td> 
                                    Passwort:&nbsp; 
                                </td> 
                                <td> 
                                    <input type="password" name="password" size="20" /> 
                                </td> 
                            </tr> 
                            <tr> 
                                <td> 
                                    <input type="submit" name="action" value="Login"/> 
                                </td> 
                            </tr> 
                        </table> 
                    </form> 
                    <p> 
                        <a href="http://validator.w3.org/check?uri=referer"> 
                            <img src="http://www.w3.org/Icons/valid-xhtml11" 
                            alt="Valid XHTML 1.1!" class="vxhtml" /></a> 
                    </p> 
                </td> 
            </tr> 
        </table> 
    </body> 
</html> 
<?php  }  ?>
