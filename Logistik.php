<!DOCTYPE html>
<html>
<head>
	
	<title>Learn2Lean Logistik</title>

	<!--Einbindung des CSS-Frameworks und Javascript/jQuery-Inhalte-->
	<?php include 'include/head.php';?>

</head>
<body>
	
	<?php 
	$stationsNummer = 7;
	$nameOfStation = "Logistik";
	include 'include/nav.php'; 

	include('Framework/framework.php'); ?>

	<script type="text/javascript">

		pruefeSpielStatus();

		ladeLogistikÜbersicht(1);

		ladeLogistikÜbersicht(2);

		ladeLogistikÜbersicht(3);

		ladeLogistikÜbersicht(4);

		ladeAnlieferungsliste();

	</script>

	<div class='grid-container-logistik'>
		<div class='grid-item grid-title-logistik'>Bestellungen</div>
		<div class='grid-item bestellungsslider'>
				
		</div>
		<div class='grid-item grid-title-logistik'>Übersicht der Materialstände an den Materialstationen</div>
		<div class='grid-item grid-station-zu-station-button'>
			<button class='station-zu-station-button' onclick='ladeUmbuchungenPopUpInhalt()'>Stein Umbuchung</button>
		</div>
		<div class='grid-item grid-hilfe-button-logistik'>
			<button class='hilfe-button' onclick='openPopUpKlein()'>? Hilfe</button>
		</div>
		<div class='grid-item grid-stein-status-station'>
			<div class='container'>
				<div class='title'>Arbeitsplatz 1</div>
			</br>
				<table class='table' id='LogistikStation1'>
				</table>
			</div>
		</div>
		<div class='grid-item grid-stein-status-station'>
			<div class='container'>
				<div class='title'>Arbeitsplatz 2</div>
			</br>
				<table class='table' id='LogistikStation2'>
				</table>
			</div>
		</div>
		<div class='grid-item grid-stein-status-station'>
			<div class='container'>
				<div class='title'>Arbeitsplatz 3</div>
			</br>
				<table class='table' id='LogistikStation3'>
				</table>
			</div>
		</div>
		<div class='grid-item grid-stein-status-station'>
			<div class='container'>
				<div class='title'>Arbeitsplatz 4</div>
			</br>
				<table class='table' id='LogistikStation4'>
				</table>
			</div>
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


		<div id='container-popup-gross'>
			<div class='container-popup-nav'>
				<div class='container-popup-title'>Stein-Umbuchung zwischen zwei Stationen</div>
				<div id='container-popup-close' onclick='closePopUp()'>
					<img class='container-popup-close-image' src='Icons/close.svg' />
				</div>
			</div>
			
			<div class='grid-popup-umbuchung'>
				<div class='grid-popup-item grid-popup-infotext-umbuchung'>
					Hier können Stein zwischen zwei Stationen hin- und hergebucht werden.
				</div>
				<div class='grid-popup-item grid-popup-AusgangsStation'>
					<div class='container-title'>
						Ausgangsstation
					</div>
					<select id='select-ausgangsStation' class='selectBox'>
						<option value='1'>Arbeitsplatz 1 - Werkzeugaufnahme</option>
						<option value='2'>Arbeitsplatz 2 - Dach</option>
						<option value='3'>Arbeitsplatz 3 - Tischfuss</option>
						<option value='4'>Arbeitsplatz 4 - Tischplatte</option>
						<option value='7'>Arbeitsplatz 7 - Logistik</option>
					</select>
				</div>
				<div class='grid-popup-item grid-popup-ZielStation'>
					<div class='container-title'>
						Zielstation
					</div>
					<select id='select-zielStation' class='selectBox'>
						<option value='1'>Arbeitsplatz 1 - Werkzeugaufnahme</option>
						<option value='2'>Arbeitsplatz 2 - Dach</option>
						<option value='3'>Arbeitsplatz 3 - Tischfuss</option>
						<option value='4'>Arbeitsplatz 4 - Tischplatte</option>
						<option value='7'>Arbeitsplatz 7 - Logistik</option>
					</select>
				</div>
				<div class='grid-popup-item grid-popup-Steintyp'>
					<div class='container-title'>
						Steinarten
					</div>
					<select id='select-steintypen' class='selectBox'>
						
					</select>
				</div>
				<div class='grid-popup-item grid-popup-SteinAnzahl'>
					<div class='container-title'>
						Steinanzahl
					</div>
					<div class='popup-material-txtAnzahl'>
						<button type='button' id='btnMaterialMinus' onclick='btnProduktionsleiterPlusMinus("", "minus", "#txtAnzahlSteineUmbuchung")'>-</button>
						<input type='textbox' id='txtAnzahlSteineUmbuchung' class='txtMaterial' disabled='disabled' value='15' placeholder='Grenze'>
						<button type='button' id='btnMaterialPlus' onclick='btnProduktionsleiterPlusMinus("", "plus", "#txtAnzahlSteineUmbuchung")'>+</button>
					</div>

				</div>
				<div class='grid-popup-item grid-popup-umbuchung-button'>
					<button class='btnMaterialGrenzen' onclick='umbuchungStationZuStation()'>Umbuchen</button>
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