<!DOCTYPE html>
<html>
<head>
<?php
    
    $stationNumber = '';
    $nameOfStation = 'Spielleiter';
    $pageURL = 'Spielleiter.php';

    include('Framework/framework.php');

?>
    <title>Learn2Lean | <?php echo $nameOfStation;?></title>

    <!--Einbindung des CSS-Frameworks und Javascript/jQuery-Inhalte-->
     <?php include('include/head.php'); ?>

  </head>
<body>
	
	<!--Einbindung der Navigationsleiste/ Menuleiste-->
	<?php include 'include/nav.php'; ?>

	<script type="text/javascript">
		
		ladeSpielOptionen();

		ladeBestellModus();

		ladeProduktFreischaltungOption();

		ladeAktuelleTaktzeit();

		ladeAkkuAnzeige();

	</script>
	
	<div class='grid-container-spielleiter'>
		<div class='grid-item grid-spielsteuerung'>
			<div class='container'>
				<div class='title'>Spieloptionen Steuerung</div>
				<div class='spieltitle'>Spieltitle</div>
				<div class='spielOptionen'>
				</div>
			</div>
		</div>
		<div class='grid-item grid-bestellmodus'>
			<div class='container'>
				<div class='title'>Bestellungsmodus Materialnachschub</div>
				<div class='container-radiobutton'>

					<label class="control-rb control-rb-radio">
						Manuelle Bestellung
	            		<input type="radio" class='radiobutton' name="radio-rb" name='optionBestellungsModus' id='manuelleBestellungen' value='manuelleBestellungen' onclick='setzeBestellModus()' />
	        			<div class="control-rb_indicator"></div>
    				</label>

    				<label class="control-rb control-rb-radio">
	        			Automatische Bestellung
	            		<input type="radio" class='radiobutton' name="radio-rb" name='optionBestellungsModus' id='automatischeBestellungen' value='automatischeBestellungen' onclick='setzeBestellModus()' />
	        			<div class="control-rb_indicator"></div>
    				</label>


				</div>

			</div>
		</div>

		<div class='grid-item grid-ausgangsbestand'>
			<div class='container'>
				<div class='title'>Logistik Ausgangsbestand</div>
				<button class='action-button' onclick="ladeAusgangsbestand()">Ausgangsbestand aktivieren</button>
			</div>
		</div> 

		<div class='grid-item grid-analytics'>
			<div class='container'>

				<div class='title'>Analytics</div>

				<img class='img-analytics' src='Images/Spielleiter/analytics.png'/>

				<a href='analytics.php'>
					<button type='button' class='action-button' name='btnAnalytics'>Analytics öffnen</button>
				</a>

			</div>
		</div>

		<div class='grid-item grid-taktzeit'>
			<div class='container'>
				<div class='title'>Taktzeit</div>
				<div class='taktzeit-wrapper'>
					<select class='selectBox' id='pickerTaktzeit' onchange='setzeTacktzeit(this.value)'>
						<option value='10'>10 Sekunden</option>
						<option value='15'>15 Sekunden</option>
						<option value='20'>20 Sekunden</option>
						<option value='25'>25 Sekunden</option>
						<option value='30'>30 Sekunden</option>
						<option value='35'>35 Sekunden</option>
						<option value='40'>40 Sekunden</option>
						<option value='45'>45 Sekunden</option>
						<option value='50'>50 Sekunden</option>
					</select>
				</div>
			</div>
		</div>

		<div class='grid-item grid-akkumaterialstationen'>
			<div class='container'>
				<div class='title'>Akkustände Materialstationen</div>

				<table class='table' id='akkuArbeitsstationen'>
					
				</table>
				
			</div>
		</div>
		<div class='grid-item grid-produktfreischaltung'>
			<div class='container'>
				<div class='title'>Neue Produkte freischalten</div>
				<table class='table'>
					<tr class='table-row'>
						<td class='table-cell'>
							<img class='produkt-freischaltung-img' src='Images/LegoBricks/FertigeProdukte/WA_Weiss/Produkt_Lila.png'/>
						</td>
						<td class='table-cell freischalten6'>
						</td>
					</tr>
					<tr class='table-row'>
						<td class='table-cell'>
							<img class='produkt-freischaltung-img' src='Images/LegoBricks/FertigeProdukte/WA_Weiss/Produkt_Orange.png'/>
						</td>
						<td class='table-cell freischalten5'>
						</td>
					</tr>
					<tr class='table-row'>
						<td class='table-cell'>
							<img class='produkt-freischaltung-img' src='Images/LegoBricks/Anleitungen/1_Station/Schritt_2_Schwarz.jpg'/>
						</td>
						<td class='table-cell optionWerkzeugaufnahme'>
						</td>
					</tr>
				</table>
			</div>
		</div>

		<div class='grid-item grid-werkseinstellungen'>
			<div class='container'>
				
				<div class='title'>Werkseinstellungen</div>
				
				<button class='action-button' onclick='openPopUpKlein()'>Auf Werkseinstellungen zurücksetzen</button>

			</div>
		</div>
		
		<div class='grid-item grid-links'>
			<div class='container'>
				
				<div class='title'>Weiterführende Links</div>

				<a href='include/Handbuch/Learn2Lean_User_Handbuch.pdf'>
					<button type='button' class='action-button' name='btnAnalytics'>Handbuch</button>
				</a>

				<a href='Drittanbieter.php'>
					<button type='button' class='action-button' name='btnAnalytics'>Drittanbieterlizenzen</button>
				</a>
				
			</div>
		</div>

	</div>

	<div id='container-popup-hintergrund'>

		<div id='container-popup-klein'>

			<div class='container-popup-nav'>
				<div class='container-popup-title'>Auf Werkseinstellungen zurücksetzen</div>
				<div id='container-popup-close' onclick='closePopUp()'>
					<img class='container-popup-close-image' src='Icons/close.svg' />
				</div>
			</div>

			<div class='grid-popup-werkseinstellungen'>
				<div class='grid-popup-item grid-popup-infotext-werkseinstellungen'>
					Sind Sie sicher, dass Sie das System auf die Werkseinstellungen zurücksetzten möchten? Alle Spielstände werden unwiderruflich gelöscht!
				</div>
				<div class='grid-popup-item grid-popup-werkseinstellungen-button'>
					<button class='action-button-red' onclick='setzeWerkseinstellungen()'>Zurücksetzen</button>
				</div>
			</div>

		</div>

	</div>

</body>
</html>

