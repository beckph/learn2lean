<!DOCTYPE html>
<html>
<head>
	
	<title>Learn2Lean Start</title>

	<!--Einbindung des CSS-Frameworks und Javascript/jQuery-Inhalte-->
	<?php include 'include/head.php';?>

</head>
<body>
<?php 
	
	$nameOfStation = "Startseite";
?>

	<!-- Auf die Startseite angepasste Navigationsbar (ohne Zurückbutton)-->
	<nav class = 'navbar'>
	    <div class = 'navbar-links'>
	    </div>

	    <div class = 'navbar-mitte' onclick='launchFullscreen(document.documentElement);'>
	        <div class = 'navbar-title'><?php echo $nameOfStation ?></div>
	    </div>

	    <div class = 'navbar-rechts' onclick='exitFullscreen();'>
	        <img class = "navbar-logo" src="Images/Navbar/Logo.png">
	    </div>
	</nav>

	<div class='grid-container-startseite'>
		<div class='grid-item main-title-startseite'>
			Wählen Sie bitte Ihre Rolle aus!
		</div>
		<div class='grid-item sub-title-startseite-1'>
			Arbeitstationen:
		</div>
		<div class='grid-item item3'>
			<div class='container'>
				<div class='title'>Arbeitsplatz 1</div>
				<img class='img-Rollenauswahl' src='Images/LegoBricks/Anleitungen/1_Station/Schritt_2_Weiss.png'></br>
				<a href='Station1.php'><button class='menu-button'>Auswählen</button></a>
			</div>
		</div>
		<div class='grid-item item4'>
			<div class='container'>
				<div class='title'>Arbeitsplatz 2</div>
					<img class='img-Rollenauswahl' src='Images/LegoBricks/Anleitungen/2_Station/Weiss/Schritt_1.png'></br>
					<a href='Station2.php'><button class='menu-button'>Auswählen</button></a>
				</div>
			</div>
		<div class='grid-item item5'>
			<div class='container'>
				<div class='title'>Arbeitsplatz 3</div>
				<img class='img-Rollenauswahl' src='Images/LegoBricks/Anleitungen/3_Station/SchwarzGelb/Schritt_3.png'></br>
				<a href='Station3.php'><button class='menu-button'>Auswählen</button></a>
			</div>
		</div>
		<div class='grid-item item6'>
			<div class='container'>
				<div class='title'>Arbeitsplatz 4</div>
				<img class='img-Rollenauswahl' src='Images/LegoBricks/Anleitungen/4_Station/SchwarzGelbRot/Schritt_2.png'></br>
				<a href='Station4.php'><button class='menu-button'>Auswählen</button></a>
			</div>
		</div>
		<div class='grid-item item7'>
			<div class='container'>
				<div class='title'>Arbeitsplatz 5</div>
				<img class='img-Rollenauswahl' src='Images/LegoBricks/Anleitungen/5_Station/Blau/Schritt_4_Weiss.png'></br>
				<a href='Station5.php'><button class='menu-button'>Auswählen</button></a>
			</div>
		</div>
		<div class='grid-item sub-title-startseite-2'>Managementstationen:</div>
		<div class='grid-item item9'>
			<div class='container'>
				<div class='title'>Qualitätskontrolle</div>
				<img class='img-Rollenauswahl' src='Images/Roles/QM.png'></br>
				<a href='Qualitaetskontrolle.php'><button class='menu-button'>Auswählen</button></a>
			</div>
		</div>
		<div class='grid-item item10'>
			<div class='container'>
			<div class='title'>Kunde</div>
			<img class='img-Rollenauswahl' src='Images/Roles/Kunde.png'></br>
			<a href='Kunde.php'><button class='menu-button'>Auswählen</button></a>
		</div>
		</div>
		<div class='grid-item item11'>
			<div class='container'>
			<div class='title'>Logistik</div>
			<img class='img-Rollenauswahl' src='Images/Roles/Logistiker.png'></br>
			<a href='Logistik.php'><button class='menu-button'>Auswählen</button></a>
		</div>
		</div>
		<div class='grid-item item12'>
			<div class='container'>
			<div class='title'>Meister</div>
			<img class='img-Rollenauswahl' src='Images/Roles/Meister.png'></br>
			<a href='Meister.php'><button class='menu-button'>Auswählen</button></a>
		</div>
		</div>
		<div class='grid-item item13'>
			<div class='container'>
			<div class='title'>Produktionsleiter</div>
			<img class='img-Rollenauswahl' src='Images/Roles/Produktionsleiter.png'></br>
			<a href='Produktionsleiter.php'><button class='menu-button'>Auswählen</button></a>
		</div>
		<div class='grid-item item14'>
			<a href='Spielleiter.php'><button class='menu-button'>Spielleiter</button></a>
	</div>

</body>
</html>