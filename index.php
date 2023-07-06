<?php

	// $path_name="manager/";
	// if(substr($path_name,-1,1)=="/") $path_name_short=substr($path_name,0,strlen($path_name)-1);
	// else $path_name_short=$path_name;
	// $niv="";
	// include $niv."style/detection_langue.php";
	// include $niv."lang/index_".$lang.".php";
	session_start();

	
?>

<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/ef8ede057e.js" crossorigin="anonymous"></script>
	
	<link rel="stylesheet" type="text/css" href="style/index.css">
	<link rel="stylesheet" type="text/css" href="style/header.css">
	<link rel="stylesheet" type="text/css" href="style/footer.css">
	<link rel="stylesheet" type="text/css" href="style/acceuil.css">
	
	<link rel="stylesheet" type="text/css" href="style/adopter.css">
	<link rel="stylesheet" type="text/css" href="style/tech.css">
	<link rel="stylesheet" type="text/css" href="style/login.css">
	<link rel="stylesheet" type="text/css" href="style/gestion.css">
	<link rel="stylesheet" type="text/css" href="style/gestion_photos.css">
	
	<link rel="stylesheet" type="text/css" href="style/costisationgue.css"> 
	<link rel="stylesheet" type="text/css" href="style/profil_animal.css"> 

	<link type="png" sizes="96x96" rel="icon" href="style/logoSPA.png">
	<title>NGB</title>
</head>

<body>

<?php
	include "admin/connect_pdo_b.php";
	include "page/header.php";
?>
	
<div class="clear"></div>
		

<div class="main_page">
	<?php		
	
	if(isset($_SESSION["nom"]))
		{
		// --> Utilisateur connecté
		$tab_auth_pages[]="cotisationgue";
		$tab_auth_pages[]="dons";
		$tab_auth_pages[]="adopter";
		$tab_auth_pages[]="profil_animal";
		$tab_auth_pages[]="code_profil";
		
		$tab_auth_pages[]="login";
		$tab_auth_pages[]="logout";
		$tab_auth_pages[]="tech";
		$tab_auth_pages[]="gestion_animaux";
		$tab_auth_pages[]="gestion_photos";
		$tab_auth_pages[]="gestion_utilisateur";
		if(isset($_GET["page"]))
			{
			if(in_array($_GET["page"],$tab_auth_pages)) $page=$_GET["page"];
			}
		if(!isset($page)) include "page/acceuil.php";
		else include "page/".$page.".php";	
		}
	else
		{
		// --> Utilisateur non connecté
		$tab_auth_pages[]="cotisationgue";
		$tab_auth_pages[]="dons";
		$tab_auth_pages[]="adopter";
		$tab_auth_pages[]="profil_animal";
		$tab_auth_pages[]="code_profil";

		$tab_auth_pages[]="login";
		$tab_auth_pages[]="logout";

		if(isset($_GET["page"]))
			{
			if(in_array($_GET["page"],$tab_auth_pages)) $page=$_GET["page"];
			}
		if(!isset($page)) include "page/acceuil.php";
		else include "page/".$page.".php";	
		}
	
	?>
</div>

<?php


	include "page/footer.php";
	include "admin/close_pdo_b.php";
	
	//echo "<pre>";
	//print_r($_SESSION);
	//echo "</pre>";

	// $password = 'cassandre';
	// $hash = password_hash($password, PASSWORD_DEFAULT);
	// echo $hash;
?>

</body>

</html>