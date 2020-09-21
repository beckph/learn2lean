<?php 
	
    $stationsNummer = '1';
    $nameOfStation = 'Arbeitsplatz 1';
    $seitenURL = 'Station1.php';

	include('Framework/framework.php');

?>
<!DOCTYPE html>
<html>
<head>
    <title>Learn2Lean | <?php echo $nameOfStation;?></title>

	<!--Einbindung des CSS-Frameworks und Javascript/jQuery-Inhalte-->
	<?php include 'include/head.php';?>

  </head>
<body>

	<!--Einbindung der Navigationsleiste/ Menuleiste-->
	<?php include 'include/nav.php'; ?>

	<script type="text/javascript">

		pruefeSpielStatus();

		ladeAuftragsliste(<?php echo $stationsNummer; ?>);

		ladeTeilProdukt(<?php echo $stationsNummer; ?>);

	</script>

	<div class='grid-container-station'>
		<div class='auftragsslider'>
			<div class='container'>	
				<div class='slider'>

				</div>
			</div>
		</div>
		<div class='grid-item name-baustueck'>Werkzeugbanküberdachung</div>
		<div class='grid-item title-bauteile'>Verwendete Bauteile <div id='timer-anzeige'></div></div>
		<div class='grid-item title-schritt'>Schritt 1</div>
		<div class='grid-item title-schritt'>Schritt 2</div>
		<div class='grid-item image-schritt'>
			<div class='container'>
				<div class='anleitung-1'>
				</div>
			</div>
		</div>
		<div class='grid-item image-schritt'>
			<div class='container'>
				<div class='anleitung-2'></div>
			</div>
		</div>
		<div class='grid-item title-schritt'>Schritt 3</div>
		<div class='grid-item title-schritt'>Schritt 4</div>
		<div class='grid-item image-schritt'>
			<div class='container'>
				<div class='anleitung-3'></div>
			</div>
		</div>
		<div class='grid-item image-schritt'>
			<div class='container'>
				<div class='anleitung-4'></div>
			</div>
		</div>
		<div class='grid-item liste-bauteile'>
			<div class='container'>
				<div class='materialbedarf'></div>
			</div>
		</div>
		<div class='grid-item grid-hilfe-button'>
			<button class='hilfe-button' onclick='openPopUpKlein()'>? Hilfe</button>
		</div>
		<div class='grid-item grid-bestellen-button'>
			<button type='button' class='bestellen-button' onclick='ladeMaterialPopUpInhalt(<?php echo $stationsNummer; ?>)'><img class='img-station-button' src='Icons/shopping_cart_white.png'><br>Material</button>
		</div>
		<div class='grid-item grid-abgeschlossen-button'></div>
	</div>


	<div id='container-popup-hintergrund'>
		<div id='container-popup-klein'>
			<div class='container-popup-nav'>
				<div class='container-popup-title'>Hilfeanforderung bestätigen</div>
				<div id='container-popup-close' onclick='closePopUp()'>
					<img class='container-popup-close-image' src='Icons/close.svg' />
				</div>
			</div>
			<div class='grid-popup-hilfebutton'>
				<div class='grid-popup-item grid-popup-infotext-hilfe'>
					Wenn Sie Ihre Hilfsanforderung unten auf dem Button bestätigen, wird der Meister informiert und kommt zu Ihrer Station.
				</div>
				<div class='grid-popup-item grid-popup-hilfe-button'>
					<button name='btnHilfe' class='action-button' onclick='forderHilfe(<?php echo $stationsNummer; ?>)'>Hilfsanforderung bestätigen</button>
				</div>
			</div>
		</div>

		<div id='container-popup-gross'>
			<div class='container-popup-nav'>
				<div class='container-popup-title'>Material bestellen</div>
				<div id='container-popup-close' onclick='closePopUp()'>
					<img class='container-popup-close-image' src='Icons/close.svg' />
				</div>
			</div>
			<div class='grid-popup-material'>
				<div class='grid-popup-item grid-popup-material-infotext'>
					
				</div>
				<div class='grid-popup-item grid-popup-material-produktbild'>

				</div>
				<div class='grid-popup-item grid-popup-material-txtAnzahl'>
				
				</div>
				<div class='grid-popup-item grid-popup-material-button'>
					
				</div>
			</div>
		</div>

	</div>


	<div id='container-popup-hintergrund-spieloption'>
		<div id='container-popup-spieloption'>

		</div>
	</div>



</body>
</html>