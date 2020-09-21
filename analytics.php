<?php 
	
	//Unnötig??????
	/*include 'head.php';*/
    $stationsNummer = '9';
    $nameOfStation = 'Analytics';
    $seitenURL = 'analytics.php';

	include('Framework/framework.php');

?>
<!DOCTYPE html>
<html>
<head>
	<title>Analytics</title>

	<!-- Alle Header-Inhalte ausgelagert -->
	<?php include 'include/head.php';?>

	<!-- Einbindung vom Chart.js Framework-->
	<script src='Framework/Chart.js-2.9.3/dist/Chart.js'></script>

</head>
<body>

	<?php include 'include/nav.php'; ?>

	<script type="text/javascript">
			
		

	</script>

	<div class='grid-container-analytics'>

		<div class='grid-item grid-spielauswahl-button'><button class='analytics-spielauswahl-button' onclick="ladeAnalyticsAuswahl()">Produktionsperioden</button></div>
		<div class='grid-item grid-pdf-export-button'><button class='analytics-pdfexport-button' onclick='window.print()'>PDF Export</button></div>

		<div class='grid-item grid-title-komplett'>
			<div class='title'>Tabelle Spieldurchlaufzeit</div>
		</div>

		<div class='grid-item grid-chart-tabelleSpielDurchlaufzeit'>
			<div class='container'>
				<?php tabelleSpielDurchlaufzeitenAnzahlBestellungen(); ?>
			</div>
		</div>

		<div class='grid-item grid-title-komplett'>
			<div class='title'>Durchlaufszeiten der Bestellungen und deren Takt</div>
		</div>
		<div class='grid-item grid-chartDurchlaufzeitenBestellungen'>
			
			<div class='container-DurchlaufzeitenBestellungen'>	
				<canvas id='chartDurchlaufzeitenBestellungen'></canvas>
			</div>

		</div>

		<div class='grid-item grid-title-komplett'>
			<div class='title'>Ø Durchlaufzeit der Arbeitsstationen</div>
		</div>
		<div class='grid-item grid-chartDurchschnittslaufzeitArbeitsstation'>

			<div class='container'>	
				<canvas id='chartDurchschnittslaufzeitArbeitsstation'></canvas>
			</div>

		</div>

		<div class='grid-item grid-title-halb'>
			<div class='title'>Retouren</div>
		</div>
		<div class='grid-item grid-title-halb'>
			<div class='title'>Anzahl Hilfsanforderungen an Meister und Produktionsleiter</div>
		</div>

		<div class='grid-item grid-chartRetouren'>

			<div class='container'>	
				<canvas id='chartRetouren'></canvas>
			</div>

		</div>

		<div class='grid-item grid-chartHilfsanforderungenMeisterProduktionsleiter'>

			<div class='container'>	
				<canvas id='chartHilfsanforderungenMeisterProduktionsleiter'></canvas>
			</div>

		</div>

		<div class='grid-item grid-title-komplett'>
			<div class='title'>Anzahl Hilferufe der einzelnen Arbeitstationen</div>
		</div>
		<div class='grid-item grid-chartHilfsanforderungenStationen'>

			<div class='container'>	
				<canvas id='chartHilfsanforderungenStationen'></canvas>
			</div>

		</div>


		<div class='grid-item grid-title-halb'>
			<div class='title'>Erfolgsrate der Produktionsperioden</div>
		</div>
		<div class='grid-item grid-title-halb'>
			<div class='title'>Arbeitsstationenproduktivität</div>
		</div>

		<div class='grid-item grid-chartErfolgsrateSpiele'>

			<div class='container'>	
				<canvas id='chartErfolgsrateSpiele'></canvas>
			</div>

		</div>

		<div class='grid-item grid-chartArbeitsstationenProduktivitaet'>
			
			<div class='container'>	
				<canvas id='chartArbeitsstationenProduktivitaet'></canvas>
			</div>

		</div>
		

		<div class='grid-item grid-title-komplett'>
			<div class='title'>Anzahl Bestellungen aller EndProdukte</div>
		</div>

		<div class='grid-item grid-chartAnzahlBestellungenEndProdukte'>

			<div class='container'>	
				<canvas id='chartAnzahlBestellungenEndProdukte'></canvas>
			</div>	

		</div>

		<div class='grid-item grid-footer'></div>

	</div>

	<div id='container-popup-hintergrund'>

		<div id='container-popup-gross'>
			<div class='container-popup-nav'>
				<div class='container-popup-title'>Analytics Produktionsperioden</div>
				<div id='container-popup-close' onclick='closePopUp()'>
					<img class='container-popup-close-image' src='Icons/close.svg' />
				</div>
			</div>
			<div class='grid-popup-analytics'>
				<div class='grid-popup-item grid-popup-analytics-infotext'>
					
				</div>
				<div class='grid-popup-item grid-popup-analytics-produktionsperioden'>

				</div>
				<div class='grid-popup-item grid-popup-analytics-button'>
					
				</div>
			</div>
		</div>

	</div>

	<script>
	


		ladeAnalyticsCharts();

		function ladeAnalyticsCharts() {

			//BarChart Alle Durchlaufszeiten der Bestellungen und deren Takt
			var barChartDurchlaufzeitenBestellungen = new Chart('chartDurchlaufzeitenBestellungen', {
			    type: 'bar',
			    data: { <?php barChartDurchlaufzeitenBestellungen(); ?>
			    },
			    options: {
			        scales: {
			            yAxes: [{
			            	scaleLabel: {
			            		display: true,
			            		labelString: 'Produktionszeit in Sekunden'
			            	},
			                ticks: {
			                    beginAtZero: true
			                }
			            }],
			            xAxes: [{
			            	scaleLabel: {
			            		display: true,
			            		labelString: 'BestellungsID sortiert nach Produktionsreihenfolge'
			            	}
			            }]
			        },
			        title: {
			        	display: false,
			        	text: 'Durchlaufzeit Bestellungen nach Produktionsreihenfolge sortiert'
			        }
			    }
			});


			
			//MixedChart Durchschnittslaufzeit der Arbeiststationen pro Spiel
			var mixedChartDurchschnittslaufzeitArbeitsstationen = new Chart('chartDurchschnittslaufzeitArbeitsstation', {
			    type: 'bar',
			    data: { <?php mixedChartDurchschnittslaufzeitArbeitsstationen(); ?>
			    },
			    options: {
			        scales: {
			            yAxes: [{
			            	scaleLabel: {
			            		display: true,
			            		labelString: 'Produktionszeit in Sekunden'
			            	},
			                ticks: {
			                    beginAtZero: true
			                }
			            }],
			            xAxes: [{
			            	scaleLabel: {
			            		display: true,
			            		labelString: 'Arbeitsstationen'
			            	}
			            }]
			        },
			        title: {
			        	display: false,
			        	text: 'Ø Durchlaufzeit der Arbeitsstationen'
			        }
			    }
			});

			//BarChart Retouren 
			var barChartRetouren = new Chart('chartRetouren', {
			    type: 'bar',
			    data: { <?php barChartRetouren(); ?>
			    },
			    options: {
			        scales: {
			            yAxes: [{
			            	scaleLabel: {
			            		display: true,
			            		labelString: 'Anzahl'
			            	},
			                ticks: {
			                    beginAtZero: true
			                }
			            }],
			            xAxes: [{
			            	scaleLabel: {
			            		display: true,
			            		labelString: 'Aufgetreten bei'
			            	}
			            }]
			        },
			        title: {
			        	display: false,
			        	text: 'Retouren'
			        }
			    }
			});

			//BarChart Hilfsanforderungen an Meister oder Produktionsleiter pro Spiel
			var barChartHilfsanforderungenMeisterProduktionsleiter = new Chart('chartHilfsanforderungenMeisterProduktionsleiter', {
			    type: 'bar',
			    data: { <?php barChartHilfsanforderungenMeisterProduktionsleiter(); ?>
			    },
			    options: {
			        scales: {
			            yAxes: [{
			            	scaleLabel: {
			            		display: true,
			            		labelString: 'Anzahl'
			            	},
			                ticks: {
			                    beginAtZero: true
			                }
			            }],
			            xAxes: [{
			            	scaleLabel: {
			            		display: true,
			            		labelString: 'Arbeitsstationen'
			            	}
			            }]
			        },
			        title: {
			        	display: false,
			        	text: 'Anzahl Hilfsanforderungen an Meister und Produktionsleiter'
			        }
			    }
			});

			//BarChart Hilfsanforderungen ausgehend von welcher Station?
			var barChartHilfsanforderungenStationen = new Chart('chartHilfsanforderungenStationen', {
			    type: 'bar',
			    data: { <?php barChartHilfsanforderungenStationen(); ?>
			    },
			    options: {
			        scales: {
			            yAxes: [{
			            	scaleLabel: {
			            		display: true,
			            		labelString: 'Anzahl'
			            	},
			                ticks: {
			                    beginAtZero: true
			                }
			            }],
			            xAxes: [{
			            	scaleLabel: {
			            		display: true,
			            		labelString: 'Arbeitsstationen'
			            	}
			            }]
			        },
			        title: {
			        	display: false,
			        	text: 'Anzahl Hilferufe der einzelnen Arbeitsplätze'
			        }
			    }
			});


			//LineChart - Erfolgsrate der Produkionsperioden/Spiele
			var lineChartErfolgsrateSpiele = new Chart('chartErfolgsrateSpiele', {
				type: 'line',
				data: { <?php lineChartErfolgsrateSpiele(); ?>
				},
				options: {
					 scales: {
			            yAxes: [{
			            	scaleLabel: {
			            		display: true,
			            		labelString: 'Erfolgsrate in %'
			            	},
			                ticks: {
			                    beginAtZero: true
			                }
			            }],
			            xAxes: [{
			            	scaleLabel: {
			            		display: true,
			            		labelString: 'Produktionsperioden'
			            	}
			            }]
			        },
			        title: {
			        	display: false,
			        	text: 'Erfolgsrate der Produktionsperioden'
			        }
				}
			});



			//BarChart Arbeitsstationenproduktivität
			var barChartArbeitsstationenProduktivitaet = new Chart('chartArbeitsstationenProduktivitaet', {
			    type: 'bar',
			    data: { <?php barChartArbeitsstationenProduktivitaet(); ?>
			    },
			    options: {
			        scales: {
			            yAxes: [{
			            	scaleLabel: {
			            		display: true,
			            		labelString: 'Produktivität in [Stück pro Minute]'
			            	},
			                ticks: {
			                    beginAtZero: true
			                }
			            }],
			            xAxes: [{
			            	scaleLabel: {
			            		display: true,
			            		labelString: 'Arbeitsstationen [Stück pro Minute]'
			            	}
			            }]
			        },
			        title: {
			        	display: false,
			        	text: 'Arbeitsstationenproduktivität'
			        }
			    }
			});


			//BarChart Anzahl Bestellungen aller EndProdukte pro Spiel
			var barChartAnzahlBestellungenEndProdukte = new Chart('chartAnzahlBestellungenEndProdukte', {
			    type: 'bar',
			    data: { <?php barChartAnzahlBestellungenEndProdukte(); ?>
			    },
			    options: {
			        scales: {
			            yAxes: [{
			            	scaleLabel: {
			            		display: true,
			            		labelString: 'Anzahl'
			            	},
			                ticks: {
			                    beginAtZero: true
			                }
			            }],
			            xAxes: [{
			            	scaleLabel: {
			            		display: true,
			            		labelString: 'EndProdukte'
			            	}
			            }]
			        },
			        title: {
			        	display: false,
			        	text: 'Anzahl Bestellungen aller EndProdukte pro Spiel'
			        }
			    }
			});

		}

	</script>

</body>
</html>