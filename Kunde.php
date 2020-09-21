<?php 
	
	include('Framework/framework.php');

?>
<!DOCTYPE html>
<html>
<head>

    <?php
      $stationNumber = '7';
      $nameOfStation = 'Kunde';
      $pageURL = 'Kunde.php';
    ?>

    <title>Learn2Lean | <?php echo $nameOfStation;?></title>

    <!--Einbindung des CSS-Frameworks und Javascript/jQuery-Inhalte-->
	<?php include 'include/head.php';?>

  </head>
<body>
	
	<?php include 'include/nav.php'; ?>

	<script type="text/javascript">

		pruefeSpielStatus();

		ladeKundenBestellenButton();

		ladeKundeBestellungen();

		ladeAuslieferungKunde();

		//Öffnet den Browser automatisch in Fullscreen
		//launchFullscreen(document.documentElement);

	</script>

	<div class='grid-container-kunde'>

		<div class='grid-item title-Bestelloptionen'>Bestelloptionen</div>

		<div class='grid-item title-Auftragsliste'>Auftragsliste</div>

		<div class='grid-item kunde-timer'>
			<div id='timer-anzeige'></div>
		</div>

		<div class='grid-item bestellung-blau'></div>

		<div class='grid-item bestellung-gelb'></div>

		<div class='grid-item bestellung-gruen'></div>

		<div class='grid-item bestellung-rot'></div>

		<div class='grid-item bestellung-orange'></div>

		<div class='grid-item bestellung-lila'>	</div>

		<div class='grid-item auftragsliste'>
			<div class='container'>

				<table class='table'>
					<tr class='table-row'></tr>
				</table>

				
			</div>
		</div>

		<div class='grid-item mehrfachbestellung'>

			<label class="control control-checkbox">
			   	5-fache Mehrfachbestellung als Sonderbestellung
			    <input type="checkbox" name='optionMehrfachbestellung' id='MehrfachBestellungen' value='MehrfachBestellungen'/>
			    <div class="control_indicator"></div>
			</label>

		</div>

	</div>

	<div id='container-popup-hintergrund'>

		<div id='container-popup-kunde'>
			<div class='container-popup-nav'>
				<div class='container-popup-title'>Auslieferung des Produktes</div>
			</div>
			<div class='grid-popup-auslieferung'>
				<div class='grid-popup-item grid-popup-endprodukt-image'>
				</div>
				<div class='grid-popup-item grid-popup-endprodukt-infotext'>
					Entspricht das Produkt Ihren Vorstellungen bzw. Ihrer Bestellung!?
				</div>
				<div class='grid-popup-item grid-popup-annehmen-button'>
					<button type='button' name='bestellungAnnehmen' class='button-bestellung-annehmen' onclick='kundeWarenannahme(1)'>Annehmen</button>
				</div>
				<div class='grid-popup-item grid-popup-ablehnen-button'>
					<button type='button' name='bestellungAnnehmen' class='button-bestellung-annehmen' onclick='kundeWarenannahme(2)'>Ablehnen</button>
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