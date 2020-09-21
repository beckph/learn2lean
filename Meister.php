<?php 
	
	include('Framework/framework.php');


?>
<!DOCTYPE html>
<html>
<head>
    <?php
      $stationsNummer = '8';
      $nameOfStation = 'Meister';
      $pageURL = 'Meister.php';
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

		ladeHilfsanforderungen('Meister');

		ladeRetouren();

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
			LoadOnline3DModels();
		}
	
		window.addEventListener('load', OnLoad, true);
		window.addEventListener('resize', OnResize, true);

	</script>

	<div class='grid-container-meister'>
		<div class='grid-item grid-title-hilfsanforderungen-meister'>
			<div class='container-title'>Hilfsanforderungen an den Meister</div>
		</div>
		<div class='grid-item grid-title-anleitungen-meister'>
			<div class='container-title'>Alle Anleitungen</div>
		</div>
		<div class='grid-item grid-hilfsanforderungen-meister'>
			<div class='container-hilfsanforderung'>
			</div>
		</div>
		<div class='grid-item grid-anleitungen-meister'>
			<button class='button-anleitungen' onclick='ladeCADAnleitungen()'>Anleitungen</button>
		</div>
		<div class='grid-item grid-hilfe-button-meister'>
			<button class='hilfe-button' onclick='openPopUpKlein()'>? Hilfe</button>
		</div>
		<div class='grid-item grid-title-retouren'>
			<div class='container-title'>Retouren</div>
		</div>
		<div class='grid-item grid-retourenListe'>
			<div class='container'>
				<table class='table'>
				</table>
			</div>
		</div>
		<div class='grid-item grid-retourenAnleitung'>
			<div class='container'>
				
			</div>
		</div>
		<div class='grid-item grid-retoureButton'></div>
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

	</div>

	<div id='container-popup-hintergrund-spieloption'>
		<div id='container-popup-spieloption'>
			
		</div>
	</div>
	
	

</body>
</html>