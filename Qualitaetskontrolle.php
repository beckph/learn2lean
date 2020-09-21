<?php 
	
	include('Framework/framework.php');

    $stationsNummer = '6';
    $nameOfStation = 'Qualitätskontrolle';
    $seitenURL = 'Qualitaetskontrolle.php';

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

		ladeEndProduktQualitaet(<?php echo $stationsNummer; ?>);

	</script>

	<div class='grid-container-qualität'>
		
		<!--Slider-->
		<div class='grid-item grid-auftragsslider-qualitätskontrolle'>
			<div class='container'>	
				<div class='slider'>
				</div>
			</div>
		</div>



		<div class='grid-item title-bauteile'>Produktbezeichnung</div>
		<div class='grid-item qm-timer'><div id='timer-anzeige'></div></div>
		<div class='grid-item grid-hilfe-button-qm'>
			<button class='hilfe-button' onclick='openPopUpKlein()'>? Hilfe</button>
		</div>
		<div class='grid-item grid-produktbild'>
			
		</div>
		<div class='grid-item grid-nachbessern-button'>
			
		</div>
		<div class='grid-item grid-ausliefern-button'>
			
		</div>
		
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
					Wenn Sie Ihre Hilfsanforderung unten auf dem Button bestätigen, wird der Produktionsleiter informiert und kommt zu Ihrer Station.
				</div>
				<div class='grid-popup-item grid-popup-hilfe-button'>
					<button name='btnHilfe' class='action-button' onclick='forderHilfe(<?php echo $stationsNummer; ?>)'>Hilfsanforderung bestätigen</button>
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