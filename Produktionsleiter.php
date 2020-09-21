<?php 
	
	include('Framework/framework.php');


?>
<!DOCTYPE html>
<html>
<head>
    <?php
      /*include 'head.php';*/
      $stationNumber = '';
      $nameOfStation = 'Produktionsleiter';
      $pageURL = 'Produktionsleiter.php';
    ?>
    <title>Learn2Lean | <?php echo $nameOfStation;?></title>

    <!--Einbindung des CSS-Frameworks und Javascript/jQuery-Inhalte-->
	<?php include 'include/head.php';?>

  </head>
<body>
	
	<!--Einbindung der Navigationsleiste/ Menuleiste-->
	<?php include 'include/nav.php'; ?>

	<!--Einbindung der Module für den CAD Viewer-->
	<script type="text/javascript" src="include/CAD-Viewer/jsmodeler/three.min.js"></script>
	<script type="text/javascript" src="include/CAD-Viewer/jsmodeler/jsmodeler.js"></script>
	<script type="text/javascript" src="include/CAD-Viewer/jsmodeler/jsmodeler.ext.three.js"></script>
	<script type="text/javascript" src="include/CAD-Viewer/emb/include/online3dembedder.js"></script>

	<script type="text/javascript">

		pruefeSpielStatus();

		ladeAuftragsliste(0);

		ladeFreigegebeneBestellungen();

		ladeHilfsanforderungen('Produktionsleiter');

		ladeCADAnleitungen();


		///Aufruf der Funktion zur 3D Ansicht
		function OnResize ()
		{
			var canvas = document.getElementById ('fullscreen');
			canvas.width = '300';
			canvas.height = '300';
		}
		
		function OnLoad ()
		{
			OnResize ();
			LoadOnline3DModels ();
		}
	
		window.addEventListener('load', OnLoad, true);
		window.addEventListener('resize', OnResize, true);

	</script>

	<div class='grid-container-produktionsleiter'>
		<div class='grid-item grid-title-produktionsreihenfolge'>
			<div class='container-title'>Produktionsreihenfolge festlegen</div>
		</div>
		<div class='grid-item grid-produktionsreihenfolge'>
			
			<div class='auftragsslider'>
			<div class='container'>	
				<div class='slider'>
				</div>
			</div>
			</div>

		</div>

		<div class='grid-item grid-title-hilfsanforderungen-produktionsleiter'>
			<div class='container-title'>Hilfsanforderungen</div>
		</div>
		<div class='grid-item grid-title-freigegebene-Bestellungen'>
			<div class='container-title'>freigegebene Bestellungen</div>
		</div>
		<div class='grid-item grid-hilfsanforderungen-produktionsleiter'>
			<div class='container-hilfsanforderung'>
			</div>
		</div>

		<div class='grid-item grid-freigegebene-Bestellungen'>
			<div class='container'>

				<table class='table'>
					<tr class='table-row'>
							
					</tr>
				</table>

				
			</div>
		</div>
		<div class='grid-item grid-title-anleitungen-produktionsleiter'>
			<div class='container-title'>Anleitungen</div>
		</div>

		<div class='grid-item grid-title-grenzwerte'>
			<div class='container-title'>Maximale Grenzen</div>
		</div>

		<div class='grid-item grid-anleitungen-produktionsleiter'>
			<button class='button-anleitungen' onclick='openPopUpAnleitungen()'>Anleitungen</button>
		</div>

		<div class='grid-item grid-grenzwerte'>
			
			<button onclick="ladeProduktionsleiterMaximaleGrenzwerte(1)" class="maximale-grenzwerte-button">Maximale Grenzwerte</button>

		</div>
	</div>

	<div id='container-popup-hintergrund'>

		<div id='container-popup-anleitungen'>
			
			<div class='container-popup-nav'>
				<div class='container-popup-title'>Alle Anleitungen</div>
				<div id='container-popup-close' onclick='closePopUp()'>
					<img class='container-popup-close-image' src='Icons/close.svg' />
				</div>
			</div>

			<div class='grid-popup-anleitungen'>

				<div class='grid-popup-item grid-popup-title-produktauswahl'>
					<div class='container-title'>Alle EndProdukte</div>
				</div>

				<div class='grid-popup-item grid-popup-title-CADViewer'>
					<div class='container-title'>3D Ansicht</div>
				</div>

				<div class='grid-popup-item grid-popup-produktauswahl'>	
					<div class='container-noborder'>
						<div class='anleitungsliste'>
								
						</div>
					</div>
				</div>

				<div class='grid-popup-item grid-popup-CADViewer'>
					<div class='container cadViewer'>			
						
						<canvas id='fullscreen' class='3dviewer' sourcefiles='include/CAD-Viewer/emb/endpro-obj/EndProduktID1/Endprod.obj|include/CAD-Viewer/emb/endpro-obj/EndProduktID1/Endprod.mtl'></canvas>

					</div>
				</div>
			</div>

		</div>


		<div id='container-popup-maximaleGrenzwerte'>
				
			<div class='container-popup-nav'>
				<div class='container-popup-title'>Maximale Grenzwerte festlegen</div>
				<div id='container-popup-close' onclick='closePopUp()'>
					<img class='container-popup-close-image' src='Icons/close.svg' />
				</div>
			</div>

			<div class='grid-popup-maximaleBestellGrenzwerte'>
				<div class='grid-popup-item grid-popup-maximaleBestellGrenzwerte-infotext'>
					<div class=''>
						<button class='menu-maximalegrenzwerte-arbeitsstation' id='button-arbeitsstation1' onclick='ladeProduktionsleiterMaximaleGrenzwerte(1)'>AP 1</button>
						<button class='menu-maximalegrenzwerte-arbeitsstation' id='button-arbeitsstation2' onclick='ladeProduktionsleiterMaximaleGrenzwerte(2)'>AP 2</button>
						<button class='menu-maximalegrenzwerte-arbeitsstation' id='button-arbeitsstation3' onclick='ladeProduktionsleiterMaximaleGrenzwerte(3)'>AP 3</button>
						<button class='menu-maximalegrenzwerte-arbeitsstation' id='button-arbeitsstation4' onclick='ladeProduktionsleiterMaximaleGrenzwerte(4)'>AP 4</button>
					</div>
				</div>
				<div class='grid-popup-item grid-popup-maximaleBestellGrenzwerte-produktbild'>
					2
				</div>
				<div class='grid-popup-item grid-popup-maximaleBestellGrenzwerte-txtAnzahl'>
					3
				</div>
				<div class='grid-popup-item grid-popup-maximaleBestellGrenzwerte-button'>
					4
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