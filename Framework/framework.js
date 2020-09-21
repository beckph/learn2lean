
	
	/*------------------------------------------------------------------------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/
	/*----------------------------------------------Javascript----------------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/

	//In Framework.js werden die aus dem Framework.php erhaltenen Antworten ausgewertet und dynamisch ins
	//Interface geladen.

	/*------------------------------------------------------------------------------------------------------*/
	/*------------------------------------START VON ALLGEMEINE METHODEN-------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/

	/*Diese Methode öffnet den Brower im Fullscreen-Modus*/
	function launchFullscreen(element) {
			
		//Allgemein bzw. Chrome
		if(element.requestFullscreen) {
			element.requestFullscreen();
		}
		//Firefox
		else if(element.mozRequestFullScreen) {
			element.mozRequestFullScreen();
		}
		//Safari
		else if(element.webkitRequestFullscreen) {
			element.webkitRequestFullscreen();
		}
		//Internet Explorer
		else if(element.msRequestFullscreen) {
			element.msRequestFullscreen();
		}
	}

	/*Diese Methode schließt den Browser im Fullscreen-Modus*/
	function exitFullscreen() {
			
		//Allgemein bzw. Chrome
		if(document.exitFullscreen) {
			document.exitFullscreen();
		}
		//Firefox
		else if(document.mozCancelFullScreen) {
			document.mozCancelFullScreen();
		}
		//Safari
		else if(document.webkitExitFullscreen) {
			document.webkitExitFullscreen();
		}
	}

	//Diese Methode holt via Ajax und der POST-Methode aus pruefeSpielStatus die Inhalte und prüft ob das aktuelle Spiel pausiert oder beendet ist.
	function pruefeSpielStatus() {

		setInterval(function() {
			$.post('Framework/framework.php', { pruefeSpielStatus: 'true' }, function(data) {

				//Aktuelles Spiel ist pausiert
				if(data == 2) {

					$('#container-popup-hintergrund-spieloption').css("display", "block");
					$('#container-popup-spieloption').css('display', 'block');

					$('#container-popup-spieloption').html("<div class='grid-popup-spieloptionen'><div class='grid-popup-item grid-popup-spieloption-titel'>Produktionsstop</div><div class='grid-popup-item grid-popup-spieloption-img'><img class='popup-spieloption-img' src='Icons/pause_circle_filled.png'></div><div class='grid-popup-item grid-popup-spieloption-infotext'>Der Spielleiter hat die aktuelle Produktionsperiode pausiert.</div><div class='grid-popup-item grid-popup-spieloption-analytics-button'><a href='analytics.php'><button class='action-button'>Öffne Analytics</button></div></div>");

				}
				//Letztes Spiel ist beendet, d.h. es muss erst ein neues Spiel erstellt werden
				else if(data == 3) {

					$('#container-popup-hintergrund-spieloption').css("display", "block");
					$('#container-popup-spieloption').css('display', 'block');

					$('#container-popup-spieloption').html("<div class='grid-popup-spieloptionen'><div class='grid-popup-item grid-popup-spieloption-titel'>Keine Produktionsperiode vorhanden</div><div class='grid-popup-item grid-popup-spieloption-img'><img class='popup-spieloption-img' src='Icons/play_circle_filled.png'></div><div class='grid-popup-item grid-popup-spieloption-infotext'>Der Spielleiter muss erst eine neue Produktionsperiode erstellen.</div><div class='grid-popup-item grid-popup-spieloption-analytics-button'><a href='analytics.php'><button class='action-button'>Öffne Analytics</button></div></div>");

					//Sollte gerade ein Auslieferungspopup offen sein, wird es beendet.
					closePopUpKunde();

				}
				//Das Spiel läuft
				else {

					$('#container-popup-hintergrund-spieloption').css("display", "none");
					$('.container-popup-spieloption').css('display', 'none');

				}


			});
		}, 1500); //Alle 1,5 Sekunden

	}

	/*Hilfe-Button*/
	//Diese Methode überträgt via Ajax und der POST-Methode mit dem Parameter forderHilfe die Stationsnummer der Station,
	//die gerade Hilfe anfordert.
	function forderHilfe(stationsNummer) {

		$.post('Framework/framework.php', { forderHilfe: stationsNummer}, function(data) {
			
		});

		//Schließt das PopUp
		closePopUp();
	}

	//Diese Methode überträgt via Ajax und der POST-Methode mit dem Parameter abgeschlossenHilfe die Stationsnummer der Station, 
	//dessen Hilfe vom Produktionsleiter oder Meister abgeschlossen wurde 
	function abgeschlossenHilfe(stationsNummer) {

		$.post('Framework/framework.php', { abgeschlossenHilfe: stationsNummer }, function(data) {});

	}

	//Meister- und Produktionsleiterseite

	//Diese Methode überträgt via Ajax und der POST-Methode aus mit dem Parameter ladeHilfsanforderungen die Position (Produktionsleiter oder Meister)
	//und stellt die Antwort grafisch in HTML dar.
	function ladeHilfsanforderungen(position) {
		
		setInterval(function() {

			$.post('Framework/framework.php', { ladeHilfsanforderungen: position }, function(data) {

				//alert(data);
				//var obj = $.parseJSON(data);
				if(position == 'Meister') {

					$('.grid-hilfsanforderungen-meister').html(data);

				}
				else if(position == 'Produktionsleiter') {

					$('.grid-hilfsanforderungen-produktionsleiter').html(data);

				}
			});

		}, 1500); // Alle 1,5 Sekunden

	}

	/*Station 1 - 5, Qualitätskontrolle*/

	//Diese Methode überträgt via Ajax und der POST-Methode mit dem Parameter ladeAuftragsliste die Stationsnummer und gibt aus
	//der Antwort den Slider mit allen Produkten grafisch wieder.
	function ladeAuftragsliste(stationsNummer) {

		setInterval(function() {

			$.post('Framework/framework.php', { ladeAuftragsliste: stationsNummer } , function(data) {
				
				$('.slider').html(data);

				if(stationsNummer == 1 || stationsNummer == 2 || stationsNummer == 3 || stationsNummer == 4) {

					ladeTeilProdukt(stationsNummer);

				}
				else if(stationsNummer == 5) {

					ladeEndProdukt(stationsNummer);

				}
				else if(stationsNummer == 6) {

					ladeEndProduktQualitaet(stationsNummer);

				}

		});

		}, 1000);

		
	}

	//Meister- und Produktionsleiterseite

	//Diese Methode liest alle CAD-Anleitungen via AJAX und der POST-Methode aus dem Parameter ladeCADAnleitung aus und fügt
	//diese einer Liste hinzu
	function ladeCADAnleitungen() {

		openPopUpAnleitungen();

		$.post('Framework/framework.php', { ladeCADAnleitungen: 'true'}, function(data) {

			var obj = $.parseJSON(data);

			for(var key in obj) {

				//$('.anleitungsliste').append("<tr class='table-row><td class='table-cell'>" + obj[key].EndProduktID + "</td></tr>");
				$('.anleitungsliste').append("<button class='list-button' onclick=\"ladeCADViewer(" + obj[key].EndProduktID + ")\"><div class='list-item-ID'>" + obj[key].EndProduktID + "</div><div class='list-item-Produktbild'><img class='table-cell-produktbild' src='" + obj[key].EndProduktImage + "'></div><div class='list-item-Bezeichnung'>" + obj[key].EndProduktBezeichnung + "</div></button>");

			}

		});

	}

	//Diese Methode stellt den CAD-Viewer grafisch dar
	function ladeCADViewer(endProduktID) {

		$('.cadViewer').html("");
		$('.cadViewer').html("<iframe src='include/CAD-Viewer/EndProduktID" + endProduktID + ".html' width='100%' height='100%'></iframe>");		
		window.addEventListener('load', OnLoad, true);
		window.addEventListener('resize', OnResize, true);

	}

	//Diese Methode öffnet das PopUp-Anleitungen
	function openPopUpAnleitungen() {
		$('#container-popup-hintergrund').css("display", "block");
		$('#container-popup-anleitungen').css("display", "block");
	}

	//Diese Methode öffnet das PopUp-Klein, wird oft für die Hilfsanforderungen benutzt
	function openPopUpKlein() {
		$('#container-popup-hintergrund').css("display", "block");
		$('#container-popup-klein').css("display", "block");
	}

	//Diese Methode öffnet das große PopUp, wird oft für Materialbestellungen oder Grenzwerte benutzt
	function openPopUpGross() {
		$('#container-popup-hintergrund').css("display", "block");
		$('#container-popup-gross').css("display", "block");
	}

	//Diese Methode öffnet ein PopUp für die Auslieferungen an den Kunden
	function openPopUpKunde() {
		$('#container-popup-hintergrund').css("display", "block");
		$('#container-popup-kunde').css("display", "block");
	}

	//Diese Methode öffnet das PopUp für die vom Produktionsleiter maximal festgelegten Grenzwerte 
	function openPopUpMaximaleGrenzwerte() {
		$('#container-popup-hintergrund').css("display", "block");
		$('#container-popup-maximaleGrenzwerte').css("display", "block");
	}

	//Diese Methode schließt nur das PopUp für die Auslieferungen an den Kunden
	function closePopUpKunde() {
		$('#container-popup-hintergrund').css("display", "none");
		$('#container-popup-kunde').css("display", "none");
	}

	//Diese Methode schließt alle PopUps
	function closePopUp() {
		$('#container-popup-hintergrund').css("display", "none");
		$('#container-popup-klein').css("display", "none");
		$('#container-popup-gross').css("display", "none");
		$('#container-popup-anleitungen').css("display", "none");
		$('#container-popup-maximaleGrenzwerte').css("display", "none");
		$('#container-popup-kunde').css("display", "none");
	}

	//Diese Methode überträgt via Ajax und der POST-Methode die bestellungsID mit dem Parameter ladeSynchronisierteTaktzeit und
	//stellt den als Antwort erhalten Timer grafisch dar.
	function ladeSynchronisierteTaktzeit(bestellungsID) {

		$.post('Framework/framework.php', {ladeSynchronisierteTaktzeit: bestellungsID}, function(data) {
			

			$('#timer-anzeige').html(data);

		});

	}

	//Wird auf der Produktionsleiter- und Logisitkseite aufgerufen

	//Diese Methode verieht die Plus und Minus Button auf Produktionsleiterseite bei dem die maximalen Grenzwert festlegen kann,
	//mit Funktion.
	function btnProduktionsleiterPlusMinus(id, operator, txtName) {

		var txtMaterial = txtName + id;
		var txtMaterialVal = $(txtMaterial).val();
		
			
		if(operator == 'plus') {

			txtErgebnis = parseInt(txtMaterialVal) + 1;
			$(txtMaterial).val(txtErgebnis);

		}

		if(operator == 'minus' && (txtMaterialVal - 1) >= 0) {

			txtErgebnis = parseInt(txtMaterialVal) - 1;
			$(txtMaterial).val(txtErgebnis);

		}

	}


	/*------------------------------------------------------------------------------------------------------*/
	/*-------------------------------------ENDE VON ALLGEMEINE METHODEN-------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/

	/*------------------------------------------------------------------------------------------------------*/
	/*-----------------------------------------START VON SPIELLEITER----------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/

	//Diese Methode lädt das richtige Interface, je nachdem ob ein neues Spiel gestartet werden kann oder gerade ein Spiel läuft, sehen die
	//Spieloptionen unterschiedlich aus. Via Ajax und POST-Methode mit dem Parameter ladeSpielOptionen werden die Infos abgefangen und grafisch
	//verarbeitet.
	function ladeSpielOptionen() {

		$.post('Framework/framework.php', { ladeSpielOptionen: 'true' }, function(data) {
			
			var obj = $.parseJSON(data);

			if(obj.SpielID == null) {
				//Wenn kein aktives Spiel exisitiert (Alle Spiele sind beendet => Status 3)
				$('.spielOptionen').html("");
				$('.spieltitle').html("Keine Produktionsperiode aktiviert");
				$('.spielOptionen').append("<input type='text' class='textbox' placeholder='Produktionsperiodenname...' maxlength='15' id='txtSpielname'/>");
				$('.spielOptionen').append("<div class='checkbox-spielleiter-wrapper'><label class='control-ms control-ms-checkbox'>Materialstand übernehmen<input type='checkbox' id='uebernehmeMaterialstand' name='uebernehmeMaterialstand' value='uebernehmeMaterialstand'/><div class='control-ms_indicator'></div></label></div>");
				$('.spielOptionen').append("<button type='button' class='action-button' id='btnSpielErstellen' onclick='erstelleSpiel()'>Produktionsperiode erstellen</button>");
			} else {
				//Wenn ein Spiel exisitert (Ein Spiel hat den Status 1)

				//Beschriftet Button mit "Spiel pausieren"
				if(obj.Status == 1) {
					var btnText = "Produktionsperiode pausieren";
				}
				//Beschriftet Button mit "Spiel fortsetzen"
				else if(obj.Status == 2) {
					var btnText = "Produktionsperiode fortsetzen";
				}

				$('.spielOptionen').html("");
				$('.spieltitle').html(obj.Bezeichnung);
				$('.spielOptionen').append("<button type='button' class='action-button' id='btnSpielPausieren' onclick='pausiereSpiel(" + obj.SpielID + ")'>" + btnText + "</button>");
				$('.spielOptionen').append("<button type='button' class='action-button' id='btnSpielBeenden' onclick='beendeSpiel(" + obj.SpielID + ")'>Produktionsperiode beenden</button>");
			}
		});

	}

	//Diese Methode liest das Interface aus und überträgt die Infos via Ajax und der POST-Methode mit dem erstelleSpiel an das Framework.php
	function erstelleSpiel() {

		//Liest den Inhalt der Textbox aus, in der der Spielname eingetippt wird.
		var txtSpielname = $('#txtSpielname').val();
		var statusMaterialstand = 0;

		//Wenn die Checkbox "Materialstand übernehmen" aktiviert ist
		if($('#uebernehmeMaterialstand').is(':checked') == true) {
			
			statusMaterialstand = 1; //Materialstand Übernahme

		} else {

			statusMaterialstand = 0; //Keine Materialstand Übernahme

		}

		var jsonErstelleSpiel = JSON.stringify([txtSpielname, statusMaterialstand]);

		$.post('Framework/framework.php', { erstelleSpiel: jsonErstelleSpiel }, function(data) {

			ladeSpielOptionen();

		});

	}

	//Diese Methode überträgt via Ajax und POST-Methode mit dem Parameter beendeSpiel, dass das Spiel deren SpielID übertragen wird nun beendet.
	function beendeSpiel(spielID) {
		
		$.post('Framework/framework.php', { beendeSpiel: spielID}, function(data) {

			ladeSpielOptionen();
			ladeAktuelleTaktzeit();

		});

	}

	//Gleichzusetzten mit Produktionsstop
	//Diese Methode überträgt via Ajax und POST-Methode mit dem Parameter pausiereSpiel die SpielID, dessen Spiel pausiert werden soll.
	function pausiereSpiel(spielID) {

		$.post('Framework/framework.php', { pausiereSpiel: spielID}, function(data) {
			
			//Beschriftet Button mit "Spiel pausieren"
			if(data == 1) {
				$('#btnSpielPausieren').html('Produktionsperiode pausieren');
			}
			//Beschriftet Button mit "Spiel fortsetzen"
			else if(data == 2) {
				$('#btnSpielPausieren').html('Produktionsperiode fortsetzen');
			}

		});

	}
	
	//Diese Methode überträgt via Ajax und POST-Methode mit dem Parameter setzeWerkseinstellungen, dass die Datenbank alle vom User
	//generierten Daten wie Spiele, Bestellungen, Anlieferungen etc. löscht
	function setzeWerkseinstellungen() {
		
		$.post('Framework/framework.php', { setzeWerkseinstellungen: true}, function(data) {
			closePopUp();

			ladeSpielOptionen();
			ladeBestellModus();
			ladeAktuelleTaktzeit();
			ladeAkkuAnzeige();
			ladeProduktFreischaltungOption();
		});

	}

	//Diese Methode liest die aktuelle Taktzeit aus und setzt sie in der Selectbox auf den aktuell ausgewählten Wert (Defaultwert).
	function ladeAktuelleTaktzeit() {

		$.post('Framework/framework.php', { ladeAktuelleTaktzeit: true}, function(data) {

			$('#pickerTaktzeit').val("" + data + "");

		});

	}

	//Diese Methode übergibt die im Parameter übergegebene Taktzeit via Ajax und POST-Methode mit dem Parameter setzeTaktzeit an framework.php
	function setzeTacktzeit(taktzeit) {

		$.post('Framework/framework.php',{ setzeTaktzeit: taktzeit}, function(data) {});

	}

	//Diese Methode holt sich die aktuelle Akkuanzeige via Ajax und POST und stellt diese grafisch in einer Tabelle dar.
	function ladeAkkuAnzeige() {

		//Damit es beim ersten mal nach der Spielleiter Seitenöffnung sofort und nicht erst nach 10 Sekunden hereinlädt
		$.post('Framework/framework.php', {ladeAkkuAnzeige: true}, function(data) {

			var obj = $.parseJSON(data);
			$('#akkuArbeitsstationen').html("<tr class='table-row'><td class='table-cell'>Arbeitsplatz 1:</td>" + obj[0] + "</tr><tr class='table-row'><td class='table-cell'>Arbeitsplatz 2:</td>" + obj[1] + "</tr><tr class='table-row'><td class='table-cell'>Arbeitsplatz 3:</td>" + obj[2] + "</tr><tr class='table-row'><td class='table-cell'>Arbeitsplatz 4:</td>" + obj[3] + "</tr>");

		});

		//Diese Funktion aktualisiert sich jede Minute im Hintergrund
		setInterval(function() {

			$.post('Framework/framework.php', {ladeAkkuAnzeige: true}, function(data) {

				var obj = $.parseJSON(data);
				$('#akkuArbeitsstationen').html("<tr class='table-row'><td class='table-cell'>Arbeitsplatz 1:</td>" + obj[0] + "</tr><tr class='table-row'><td class='table-cell'>Arbeitsplatz 2:</td>" + obj[1] + "</tr><tr class='table-row'><td class='table-cell'>Arbeitsplatz 3:</td>" + obj[2] + "</tr><tr class='table-row'><td class='table-cell'>Arbeitsplatz 4:</td>" + obj[3] + "</tr>");

			});

		}, 60000); //60000 Millisekunden => 1 min

	}

	//Diese Methode übergibt via Ajax und POST-Methode mit dem Parameter freischaltenProdukt, 
	//welches EndProdukt (Lila oder Orange) bzw. Teilprodukt (schwarze oder weiße Werkzeugaufnahme) der Spielleiter freischaltet.
	function freischaltenProdukt(endProduktID) {

		$.post('Framework/framework.php', { freischaltenProdukt: endProduktID }, function(data) {
			
			ladeProduktFreischaltungOption();

		});

	}

	//Diese Methode lädt via Ajax und POST-Methode, das Interface in dem man sieht, 
	//welche Endprodukte und Teilprodukte freigeschaltet sind bzw. nicht freigeschaltet sind
	function ladeProduktFreischaltungOption() {

		$.post('Framework/framework.php', { ladeProduktFreischaltungOption: 'true'}, function(data) {
			
			var obj = $.parseJSON(data);

			if(obj.statusWerkzeugaufnahme != null) {

				//schwarze Werkzeugaufnahme aktiviert
				if(obj.statusWerkzeugaufnahme == 9) {
					$('.optionWerkzeugaufnahme').html("<button type='button' class='freischalten-button status-deaktivieren' onclick=\"optionWerzeugaufnahme(1)\">Deaktivieren</button>");
				} else { //weiße Werkzeugaufnahme aktiviert
					$('.optionWerkzeugaufnahme').html("<button type='button' class='freischalten-button status-freischalten' onclick=\"optionWerzeugaufnahme(9)\">Aktivieren</button>");
				}

				//Endprodukt Lila aktiviert
				if(obj.statusEndProduktLila == 1) {
					$('.freischalten5').html("<button type='button' class='freischalten-button status-deaktivieren' onclick=\"freischaltenProdukt(6)\">Deaktivieren</button>");
				} else { //Endprodukt Lila deaktivert
					$('.freischalten5').html("<button type='button' class='freischalten-button status-freischalten' onclick=\"freischaltenProdukt(6)\">Freischalten</button>");
				}

				//Endprodukt Orange aktiviert
				if(obj.statusEndProduktOrange == 1) {
					$('.freischalten6').html("<button type='button' class='freischalten-button status-deaktivieren' onclick=\"freischaltenProdukt(5)\">Deaktivieren</button>");
				} else { //Endprodukt Orange deaktiviert
					$('.freischalten6').html("<button type='button' class='freischalten-button status-freischalten' onclick=\"freischaltenProdukt(5)\">Freischalten</button>");
				}

			}

		});

	}

	//Diese Methode überträgt via Ajax und POST-Methode mit dem Parameter optionWerzeugaufnahme, die Freischaltung bzw. deaktivierung eines Teilprodukts Werkzeugaufnahme
	function optionWerzeugaufnahme(status) {

		$.post('Framework/framework.php', {optionWerzeugaufnahme: status}, function(data) {

			ladeProduktFreischaltungOption();
		});

	}

	//Diese Methode lädt via Ajax und POST-Methode den Bestellmodus und stellt diesen grafisch dar (der richtige Radiobutton ist angeklickt)
	function ladeBestellModus() {

		$.post('Framework/framework.php', { ladeBestellModus: 'true'}, function(data) {

			if(data == 1) {
				$('#manuelleBestellungen').attr('checked', '');
			}
			if(data == 2) {
				$('#automatischeBestellungen').attr('checked', '')
			}

		});

	}

	//Diese Methode setzt via Ajax und POST-Methode einen Bestellmodus, in dem es ausließt, welcher Radionbutton checked ist.
	function setzeBestellModus() {

		var status = $("input:checked").val();
		var bestellModus = 0;

		if(status == 'manuelleBestellungen') {
			bestellModus = 1;
		} 
		if(status == 'automatischeBestellungen') {
			bestellModus = 2;
		}

		$.post('Framework/framework.php', { setzeBestellModus: bestellModus}, function(data) {});

	}

	//Diese Methode lädt den Ausgangsbestand via Ajax und POST-Methode.
	function ladeAusgangsbestand() {

		$.post('Framework/framework.php', {ladeAusgangsbestand: true}, function(data) {});

	}
	

	/*------------------------------------------------------------------------------------------------------*/
	/*-----------------------------------------ENDE VON SPIELLEITER-----------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/

	/*------------------------------------------------------------------------------------------------------*/
	/*------------------------------------------START VON KUNDE---------------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/

	//Diese Methode lädt via Ajax und POST-Methode, die Bestellungsliste auf der Kundenseite rechts.
	function ladeKundeBestellungen() {

		setInterval(function() {

			$.post('Framework/framework.php', {ladeKundeBestellungen: 'true'}, function(data) {

				$('.table').html("");
				$('#timer-anzeige').html("");

				var obj = $.parseJSON(data);
				for(var key in obj) {

					//Lädt den Timer basierend auf der BestellungsID der letzten aufgegeben Bestellung (BestellungsID)
					if(key == (key.length - 1)) {
						
						//lädt die Taktzeit
						ladeSynchronisierteTaktzeit(obj[key].BestellungsID);

					}


					if(key == 0) {
						$('.table').html("");
						$('.table').html("<tr class='table-row'><th>ID</th><th>Bild</th><th>Bezeichnung</th><th>Status</th></tr>");
					}

					$('.table').append("<tr class='table-row'><td class='table-cell'>" + obj[key].BestellungsID + "</td><td class='table-cell'><img class='table-cell-produktbild' src='" + obj[key].EndProduktImage + "'></td><td class='table-cell'>" + obj[key].EndProduktBezeichnung + "</td><td class='table-cell'>" + obj[key].ProduktionsStatus + "</td></tr>");
					
				}

			});

		}, 1000);

	}

	//Diese Methode überträgt via Ajax und POST-Methode mit dem Parameter bestellungStornieren die BestellungsID, die Storniert werden soll.
	function bestellungStornieren(bestellungsID) {

		$.post('Framework/framework.php', { bestellungStornieren: bestellungsID }, function(data) {});

	}

	//Diese Methode lädt alle Bestellungsbuttons der aktuell aktivierten Produkte via Ajax und POST-Methode
	function ladeKundenBestellenButton() {

		setInterval(function() {

		$.post('Framework/framework.php', {ladeKundenBestellenButton: true}, function(data) {

			var obj = $.parseJSON(data);

			if(obj.statusWerkzeugaufnahme != null) {

				//weiße Werkzeugaufnahme ist aktiviert
				if(obj.statusWerkzeugaufnahme == 1) {

					$('.bestellung-blau').html("<button type='button' name='btnBestellungBlau' class='bestell-button bestell-button-blau' onclick='erstelleBestellung(1)'><p>Blau</p><img src='Images/LegoBricks/FertigeProdukte/WA_Weiss/Produkt_Blau.png' alt='Produkt Blau I'/></button>");
					$('.bestellung-gelb').html("<button type='button' name='btnBestellungGelb' class='bestell-button bestell-button-gelb' onclick='erstelleBestellung(2)'><p>Gelb</p><img src='Images/LegoBricks/FertigeProdukte/WA_Weiss/Produkt_Gelb.png' alt='Produkt Gelb I'/></button>");
					$('.bestellung-gruen').html("<button type='button' name='btnBestellungGruen' class='bestell-button bestell-button-gruen' onclick='erstelleBestellung(3)'><p>Grün</p><img src='Images/LegoBricks/FertigeProdukte/WA_Weiss/Produkt_Gruen.png' alt='Produkt Gruen I'/></button>");
					$('.bestellung-rot').html("<button type='button' name='btnBestellungRot' class='bestell-button bestell-button-rot' onclick='erstelleBestellung(4)'><p>Rot</p><img src='Images/LegoBricks/FertigeProdukte/WA_Weiss/Produkt_Rot.png' alt='Produkt Rot I'/></button>");


					if(obj.statusEndProduktLila == 1) {
						$('.bestellung-lila').html("<button type='button' name='btnBestellungLila' class='bestell-button bestell-button-lila' onclick='erstelleBestellung(5)'><p>Lila</p><img src='Images/LegoBricks/FertigeProdukte/WA_Weiss/Produkt_Lila.png' alt='Produkt Lila I'/></button>");
					} else{
						$('.bestellung-lila').html("");
					}

					if(obj.statusEndProduktOrange == 1) {
						$('.bestellung-orange').html("<button type='button' name='btnBestellungOrange' class='bestell-button bestell-button-orange' onclick='erstelleBestellung(6)'><p>Orange</p><img src='Images/LegoBricks/FertigeProdukte/WA_Weiss/Produkt_Orange.png' alt='Produkt Orange I'/></button>");
					} else {
						$('.bestellung-orange').html("");
					}

				}
				//schwarze Werkzeugaufnahme ist aktiviert
				if(obj.statusWerkzeugaufnahme == 9) {

					$('.bestellung-blau').html("<button type='button' name='btnBestellungBlauII' class='bestell-button bestell-button-blau' onclick='erstelleBestellung(7)'><p>Blau</p><img src='Images/LegoBricks/FertigeProdukte/WA_Schwarz/Produkt_Blau.png' alt='Produkt Blau II'/></button>");
					$('.bestellung-gelb').html("<button type='button' name='btnBestellungGelbII' class='bestell-button bestell-button-gelb' onclick='erstelleBestellung(8)'><p>Gelb</p><img src='Images/LegoBricks/FertigeProdukte/WA_Schwarz/Produkt_Gelb.png' alt='Produkt Gelb II'/></button>");
					$('.bestellung-gruen').html("<button type='button' name='btnBestellungGruenII' class='bestell-button bestell-button-gruen' onclick='erstelleBestellung(9)'><p>Grün</p><img src='Images/LegoBricks/FertigeProdukte/WA_Schwarz/Produkt_Gruen.png' alt='Produkt Gruen II'/></button>");
					$('.bestellung-rot').html("<button type='button' name='btnBestellungRotII' class='bestell-button bestell-button-rot' onclick='erstelleBestellung(10)'><p>Rot</p><img src='Images/LegoBricks/FertigeProdukte/WA_Schwarz/Produkt_Rot.png' alt='Produkt Rot II'/></button>");

					if(obj.statusEndProduktLila == 1) {
						$('.bestellung-lila').html("<button type='button' name='btnBestellungLilaII' class='bestell-button bestell-button-lila' onclick='erstelleBestellung(11)'><p>Lila</p><img src='Images/LegoBricks/FertigeProdukte/WA_Schwarz/Produkt_Lila.png' alt='Produkt Lila II'/></button>");
					} else{
						$('.bestellung-lila').html("");
					}

					if(obj.statusEndProduktOrange == 1) {
						$('.bestellung-orange').html("<button type='button' name='btnBestellungOrangeII' class='bestell-button bestell-button-orange' onclick='erstelleBestellung(12)'><p>Orange</p><img src='Images/LegoBricks/FertigeProdukte/WA_Schwarz/Produkt_Orange.png' alt='Produkt Orange II'/></button>");
					} else {
						$('.bestellung-orange').html("");
					}

				} 

			}

		});

	}, 1000);

	}

	//Diese Methode erstellt eine einache oder mehrfach Bestellung von dem Produkt welches als Parameter mit endProduktID übergeben wird.
	//Mithilfe von Ajax und der POST-Methode wird die Bestellung dann ans framework.php übertragen.
	function erstelleBestellung(endProduktID) {


		if($("input:checked").val() == 'MehrfachBestellungen') 
		{
			$.post('Framework/framework.php', { erstelleMehrfachBestellungen: endProduktID }, function(data) {});
			$('input[type=checkbox]').prop('checked',false);
		} 
		else 
		{
			$.post('Framework/framework.php', { erstelleBestellung: endProduktID }, function(data) {});
		}

	}

	//Diese Methode liest via Ajax und POST-Methode alle Auslieferungen an den Kunden aus und stellt diese als PopUp grafisch dar.
	function ladeAuslieferungKunde() {

		setInterval(function() {

			$.post('Framework/framework.php', { ladeAuslieferungKunde: 'true' }, function(data) {

				var obj = $.parseJSON(data);
				
				if(obj.BestellungsID != null) {
					//openPopUpGross();
					openPopUpKunde();

					$('.grid-popup-endprodukt-image').html("<img class='popup-endprodukt-image' src='" + obj.EndProduktImage + "' />");
					$('.grid-popup-endprodukt-infotext').html(obj.BestellungsID + " " + obj.EndProduktBezeichnung);
					$('.grid-popup-annehmen-button').html("<button type='button' name='bestellungAnnehmen' class='button-bestellung-annehmen' onclick='kundeWarenannahme(1, " + obj.BestellungsID + ")'>Annehmen</button>");
					$('.grid-popup-ablehnen-button').html("<button type='button' name='bestellungAblehnen' class='button-bestellung-ablehnen' onclick='kundeWarenannahme(2, " + obj.BestellungsID + ")'>Ablehnen</button>");
				}


			});

		}, 1000); //Jede Sekunde

	}

	//Diese Methode übergibt als den status (1 => Kunde nimmt Bestellung an, 2=> Kunde lehnt Bestellung ab) via Ajax und POST-Methode
	//mit dem Parameter kundeWarenannahme ans framework.php.
	function kundeWarenannahme(status, bestellungsID) {

		$.post('Framework/framework.php', { kundeWarenannahme: status, kundenWarenannahmeBestellungsID: bestellungsID }, function(data) {});
		
		//Schließt das PopUp
		closePopUp();

	}


	/*------------------------------------------------------------------------------------------------------*/
	/*-------------------------------------------ENDE VON KUNDE---------------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/

	/*------------------------------------------------------------------------------------------------------*/
	/*--------------------------------------START VON PRODUKTIONSLEITER-------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/

	//Diese Methode stellt grafisch dar, welche Produkte zur Produktions freigegeben sind. Via Ajax und POST-Methode bekommt es die Infos.
	function ladeFreigegebeneBestellungen() {

		setInterval(function() {

			$.post('Framework/framework.php', {ladeFreigegebeneBestellungen: 'true'}, function(data) {

				$('.table').html("");

				var obj = $.parseJSON(data);
				
				for(var key in obj) {
					
					if(key == 0) {
						$('.table').html("");
						$('.table').html("<tr class='table-row'><th>ID</th><th>Bild</th><th>Bezeichnung</th><th>Status</th></tr>");
					}

					$('.table').append("<tr class='table-row'><td class='table-cell'>" + obj[key].BestellungsID + "</td><!--<td class='table-cell'>" + obj[key].ProduktionsReihenfolge + "</td>--><td class='table-cell'><img class='table-cell-produktbild' src='" + obj[key].EndProduktImage + "'></td><td class='table-cell'>" + obj[key].EndProduktBezeichnung + "</td><td class='table-cell'>" + obj[key].ProduktionsStatus + "</td></tr>");
					
				}

			});

		}, 1000); // Jede Sekunde

	}

	/*Produktionsleiter Freigabe und Reihenfolge*/

	//Diese Methode übergibt die bestellungsID und die art (einfache = 0 oder mehrfachbestellung = 1) via Ajax und POST-Methode.
	function freigebenZurProduktion(bestellungsID, art) {

		//BestellungsID bezieht sich auf die Datenbank und Art, ob es sich um eine normale "einfach" Bestellung (art = 0) oder eine Mehrfachbestellung (art = 1) handelt
		var arrayProduktionsFreigabe = [bestellungsID, art];

		$.post('Framework/framework.php', { freigebenZurProduktion: arrayProduktionsFreigabe}, function(data) {});

	}

	//Diese Methode stellt die Inhalte für das PopUp Maximale Grenzwert auf der Produktionsleiterseite dar. Die Infos holt es sich via
	//Ajax und POST-Methode mit dem ladeProduktionsleiterMaximaleGrenzwerte Parameter.
	function ladeProduktionsleiterMaximaleGrenzwerte(stationsID) {

		openPopUpMaximaleGrenzwerte();

		$.post('Framework/framework.php', {ladeProduktionsleiterMaximaleGrenzwerte: stationsID}, function(data) {

			var obj = $.parseJSON(data);

			$(".grid-popup-maximaleBestellGrenzwerte-produktbild").html("");
			$(".grid-popup-maximaleBestellGrenzwerte-txtAnzahl").html("");

			$('#button-arbeitsstation1').css('color', '#000');
			$('#button-arbeitsstation1').css('border-bottom', '3px solid #fff');
			$('#button-arbeitsstation2').css('color', '#000');
			$('#button-arbeitsstation2').css('border-bottom', '3px solid #fff');
			$('#button-arbeitsstation3').css('color', '#000');
			$('#button-arbeitsstation3').css('border-bottom', '3px solid #fff');
			$('#button-arbeitsstation4').css('color', '#000');
			$('#button-arbeitsstation4').css('border-bottom', '3px solid #fff');

			var idButton = '#button-arbeitsstation' + stationsID;

			$(idButton).css('color', '#53ECBD');
			$(idButton).css('border-bottom', '3px solid #53ECBD');

			for(var key in obj) {

				

				$(".grid-popup-maximaleBestellGrenzwerte-produktbild").append("<div class='popup-material-produktbild'><img class='popup-material-produktbild' src='" + obj[key].SteinImage + "'></div>");
				$(".grid-popup-maximaleBestellGrenzwerte-txtAnzahl").append("<div class='popup-material-txtAnzahl'><button type='button' id='btnMaterialMinus' onclick='btnProduktionsleiterPlusMinus(" + key + ", \"minus\", \"#txtMaximaleGrenze\")'>-</button><input type='hidden' id='" + key + "hiddenSteinID' value='" + obj[key].SteinID + "'><input type='textbox' id='txtMaximaleGrenze" + key + "' class='txtMaterial' disabled='disabled' value='" + obj[key].MaximaleGrenze + "' placeholder='Max. Grenze'><button type='button' id='btnMaterialPlus' onclick='btnProduktionsleiterPlusMinus(" + key + ", \"plus\", \"#txtMaximaleGrenze\")'>+</button></div>");
				$(".grid-popup-maximaleBestellGrenzwerte-button").html("<button class='btnMaterialGrenzen' onclick='btnMaximaleGrenzen(" + stationsID + ", " + obj[key].AnzahlSteinTypen + ")'>Maximale Grenzen festlegen</button>");


			}

		});

	}

	//Diese Methode setzt die maximalen Grenzen. Dafür werden als Parameter die StationsID und die anzahlSteinTypen übergeben.
	//Das ganze wird dann als JSON-Objekt via Ajax und POST-Methode mit dem Parameter btnMaterialGrenzen and framework.php geschickt.
	function btnMaximaleGrenzen(stationsID, anzahlSteinTypen) {

		var arrayMaximaleGrenzen = [];
		var arrayStationMaximaleGrenzen = [];

		for(var i = 0; i < anzahlSteinTypen; i++) {

			arrayMaximaleGrenzen.push({SteinID: $("#" + i + "hiddenSteinID").val(), MaximaleMenge: $("#txtMaximaleGrenze" + i + "").val()});

		}

		arrayStationMaximaleGrenzen.push({StationsID: stationsID, MaximaleGrenzen: arrayMaximaleGrenzen});
	
		var jsonMaximaleGrenzen = JSON.stringify(arrayStationMaximaleGrenzen);
		
		$.post('Framework/framework.php', {btnMaterialGrenzen: jsonMaximaleGrenzen}, function(data) {

			closePopUp();

		});

	}

	/*------------------------------------------------------------------------------------------------------*/
	/*---------------------------------------ENDE VON PRODUKTIONSLEITER-------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/

	/*------------------------------------------------------------------------------------------------------*/
	/*-------------------------------------START VON ARBEITSSTATIONEN 1 - 5---------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/

	/*Station 1 bis Station 5*/

	//Diese Methode lädt das aktuelle TeilProdukt über Ajax und POST-Methode.
	function ladeTeilProdukt(stationsNummer) {

		$.post('Framework/framework.php', { ladeTeilProdukt: stationsNummer }, function(data) {

			var obj = $.parseJSON(data);

			if(obj.BestellungsID == null) {

				$('.name-baustueck').html("Aktuell keine offenen Bestellungen, die vom Produktionsleiter freigeben wurden!");

				//Alte Anleitungen ausblenden
				$('.anleitung-1').html("");
				$('.anleitung-2').html("");
				$('.anleitung-3').html("");
				$('.anleitung-4').html("");
				$('.grid-abgeschlossen-button').html("");
				$('.materialbedarf').html("");
				$('#timer-anzeige').html("");

			} else {

				//öffne funktion ladeAnleitungTeilProdukt
				ladeAnleitungTeilProdukt(obj.BestellungsID , obj.TeilProduktID, stationsNummer);

				//lädt die Taktzeit
				ladeSynchronisierteTaktzeit(obj.BestellungsID);

				$('.grid-abgeschlossen-button').html("<button name='btnMontiert' class='abgeschlossen-button' onclick='montiertTeilProdukt(" + obj.BestellungsID + "," + stationsNummer + ")'><img class='img-station-button' src='Icons/check_white.png'><br>Fertig</button>");
				$('.name-baustueck').html("BestellungsID: " + obj.BestellungsID);

			}

		});

	}

	//Diese Methode lädt das aktuelle EndProdukt über Ajax und POST-Methode.
	function ladeEndProdukt(stationsNummer) {

		
		$.post('Framework/framework.php', { ladeEndProdukt: stationsNummer }, function(data) {
			
			var obj = $.parseJSON(data);

			if(obj.BestellungsID == null) {

				$('.name-baustueck').html("Aktuell keine offenen Bestellungen, die vom Produktionsleiter freigeben wurden!");

				//Alte Anleitungen ausblenden
				$('.anleitung-1').html("");
				$('.anleitung-2').html("");
				$('.anleitung-3').html("");
				$('.anleitung-4').html("");
				$('.grid-abgeschlossen-button').html("");
				$('.materialbedarf').html("");
				$('#timer-anzeige').html("");

			} else {

			//öffne funktion ladeAnleitungEndProdukt
			ladeAnleitungEndProdukt(obj.BestellungsID , obj.EndProduktID, stationsNummer);

			//lädt die Taktzeit
			ladeSynchronisierteTaktzeit(obj.BestellungsID);

			$('.grid-abgeschlossen-button').html("<button name='btnMontiert' class='abgeschlossen-button' onclick='montiertTeilProdukt(" + obj.BestellungsID + "," + stationsNummer + ")'><img class='img-station-button' src='Icons/check_white.png'><br>Fertig</button>");
			$('.name-baustueck').html("BestellungsID: " + obj.BestellungsID);

			}

		});

	}

	//Diese Methode lädt die Anleitung des TeilProdukts mithilfe von Ajax und der POST-Methode. Als Parameter werden die BestellungsID,
	//die TeilProduktID und stationsNummer übergegeben, um die richtige Anleitung aus der Datenbank ein zu lesen.
	function ladeAnleitungTeilProdukt(BestellungsID, TeilProduktID, stationsNummer) {

		$.post('Framework/framework.php', {ladeAnleitungTeilProdukt_TeilProduktID: TeilProduktID, ladeAnleitungTeilProdukt_StationsNummer: stationsNummer}, function(data) {
			
			var obj = $.parseJSON(data);
				
			if(obj.length == 1) {
				$('.anleitung-1').html(obj[0].TeilProduktImage);
			}
			if(obj.length == 2) {
				$('.anleitung-1').html(obj[0].TeilProduktImage);
				$('.anleitung-2').html(obj[1].TeilProduktImage);

			}
			if(obj.length == 3) {
				$('.anleitung-1').html(obj[0].TeilProduktImage);
				$('.anleitung-2').html(obj[1].TeilProduktImage);
				$('.anleitung-3').html(obj[2].TeilProduktImage);
			}
			if(obj.length == 4) {
				$('.anleitung-1').html(obj[0].TeilProduktImage);
				$('.anleitung-2').html(obj[1].TeilProduktImage);
				$('.anleitung-3').html(obj[2].TeilProduktImage);
				$('.anleitung-4').html(obj[3].TeilProduktImage);
			}

			ladeMaterialbedarfTeilProdukt(TeilProduktID, stationsNummer);

			$('.grid-abgeschlossen-button').html("<button name='btnMontiert' class='abgeschlossen-button' onclick='montiertTeilProdukt(" + BestellungsID + "," + stationsNummer + ")'><img class='img-station-button' src='Icons/check_white.png'><br>Fertig</button>");
			$('.name-baustueck').html("BestellungsID: " + BestellungsID);

		});

	}

	//Diese Methode lädt die Anleitung des EndProdukts mithilfe von Ajax und der POST-Methode. Als Parameter werden die BestellungsID,
	//die EndProduktID und stationsNummer übergegeben, um die richtige Anleitung aus der Datenbank ein zu lesen.
	function ladeAnleitungEndProdukt(BestellungsID, EndProduktID, stationsNummer) {
		
		$.post('Framework/framework.php', {ladeAnleitungEndProdukt: EndProduktID}, function(data) {
			
			var obj = $.parseJSON(data);
			
			$('.anleitung-1').html(obj[0].EndProduktImage);
			$('.anleitung-2').html(obj[1].EndProduktImage);
			$('.anleitung-3').html(obj[2].EndProduktImage);
			$('.anleitung-4').html(obj[3].EndProduktImage);

			ladeMaterialbedarfEndProdukt(EndProduktID);

			$('.grid-abgeschlossen-button').html("<button name='btnMontiert' class='abgeschlossen-button' onclick='montiertTeilProdukt(" + BestellungsID + "," + stationsNummer + ")'><img class='img-station-button' src='Icons/check_white.png'><br>Fertig</button>");
			$('.name-baustueck').html("BestellungsID: " + BestellungsID);

		});

	}

	//Diese Methode lädt den Materialbedarf für TeilProdukte über Ajax und mithilfe der POST-Methode aus der Datenbank. Zur richtigen Zuordnung werden
	//als Parameter noch die TeilProduktID und die stationsNummer übertragen.
	function ladeMaterialbedarfTeilProdukt(TeilProduktID, stationsNummer) {

		$.post('Framework/framework.php', { ladeMaterialbedarfTeilProdukt_TeilProduktID: TeilProduktID, ladeMaterialbedarfTeilProdukt_StationsNummer: stationsNummer} , function(data) {
				
				var obj = $.parseJSON(data);
				
				//Zurücksetzen wichtig, damit nicht alte Farben drin bleiben
				$('.materialbedarf').html("");
				for(var key in obj) {
					$('.materialbedarf').append("<div class='materialbedarf-item'><div class='materialbedarf-item-anzahl'>" + obj[key].AnzahlSteine + "x		</div><img class='image-station-bauteile' src='" + obj[key].SteinImage + "'</div>");
				}		
				
		});

	}

	//Diese Methode lädt den Materialbedarf für EndProdukte über Ajax und mithilfe der POST-Methode aus der Datenbank. Zur richtigen Zuordnung wird
	//als Parameter noch die EndProduktID übertragen.
	function ladeMaterialbedarfEndProdukt(EndProduktID) {

		$.post('Framework/framework.php', { ladeMaterialbedarfEndProdukt: EndProduktID} , function(data) {
				
				var obj = $.parseJSON(data);

				//Zurücksetzen wichtig, damit nicht alte Farben drin bleiben
				$('.materialbedarf').html("");
				for(var key in obj) {
					$('.materialbedarf').append("<div class='materialbedarf-item'><div class='materialbedarf-item-anzahl'>" + obj[key].AnzahlTeilProdukte + "x 		</div><img class='image-station-bauteile' src='" + obj[key].TeilProduktImage + "'</div>");
				}
				
		});

	}

	//Diese Methode übermittelt and die Datenbank die BestellungsID und stationsNummer mithilfe von Ajax und der POST-Methode, wenn ein TeilProdukt an der
	//mit der stationsNummer übergeben Station montiert wurde.
	function montiertTeilProdukt(BestellungsID, stationsNummer) {

		$.post('Framework/framework.php', { montiertTeilProdukt: BestellungsID, stationNummer: stationsNummer} , function(data) {

			if(stationsNummer == 5) {

				//Neues Endprodukt
				ladeEndProdukt(stationsNummer);

			} else {

				//Neues Teilprodukt
				ladeTeilProdukt(stationsNummer);

			}
			

		});

	}

	//Diese Methode verieht die Plus und Minus Button auf den Arbeitsstationen bei dem die Materialgrenzen oder Materialbestellungen festgelegt werden,
	//mit Funktionen.
	function btnArbeitsstationPlusMinus(id, operator, txtName, steinID, stationsID) {

		$.post('Framework/framework.php', {ladeMaximaleGrenzwerte: [steinID, stationsID]}, function(data) {

			var txtMaterial = txtName + id;
			var txtMaterialVal = $(txtMaterial).val();
			var result = $.parseJSON(data);

			if(operator == 'plus' && txtMaterialVal < result) {

				txtErgebnis = parseInt(txtMaterialVal) + 1;
				$(txtMaterial).val(txtErgebnis);

			}

			if(operator == 'minus' && (txtMaterialVal - 1) >= 0) {

				txtErgebnis = parseInt(txtMaterialVal) - 1;
				$(txtMaterial).val(txtErgebnis);

			}

		});

	}

	/*PopUp Material bestellen (automatisch und manuell)*/

	//Diese Methode
	//Diese Methode stellt die Inhalte für das PopUp Material auf den Stationseiten 1 bis 4 dar. Die Infos holt es sich via
	//Ajax und POST-Methode mit dem ladeMaterialPopUpInhalt Parameter.
	function ladeMaterialPopUpInhalt(stationsID) {

		openPopUpGross();

		$.post('Framework/framework.php', { ladeMaterialPopUpInhalt: stationsID }, function(data) {

			var obj = $.parseJSON(data);

			$(".grid-popup-material-produktbild").html("");
			$(".grid-popup-material-txtAnzahl").html("");

			for(var key in obj) {

				//Manuelle Bestellungen
				if(obj[key].BestellModus == 1) {

					$(".grid-popup-material-infotext").html('Material muss manuell beordert werden:');
					$(".grid-popup-material-produktbild").append("<div class='popup-material-produktbild'><img class='popup-material-produktbild' src='" + obj[key].SteinImage + "' ></div>");
					$(".grid-popup-material-txtAnzahl").append("<div class='popup-material-txtAnzahl'><button type='button' id='btnMaterialMinus' class='btnMaterialMinusFarbe' onclick='btnArbeitsstationPlusMinus(" + key + ", \"minus\", \"#txtMaterial\", " + obj[key].SteinID + ", " + stationsID + ")'>-</button><input type='hidden' id='" + key + "hiddenSteinID' value='" + obj[key].SteinID + "'><input type='textbox' id='txtMaterial" + key + "' disabled='disabled' class='txtMaterial' value='0' placeholder='Anzahl'><button type='button' id='btnMaterialPlus' class='btnMaterialPlusFarbe' onclick='btnArbeitsstationPlusMinus(" + key + ", \"plus\", \"#txtMaterial\", " + obj[key].SteinID + ", " + stationsID + ")'>+</button></div>");
					$(".grid-popup-material-button").html("<button type='button' class='btnMaterialGrenzen' onclick='btnMaterialBestellen(" + stationsID + "," + key + ")'>Material bestellen</button>");

				}

				//Automatische Bestellungen
				if(obj[key].BestellModus == 2) {

					$(".grid-popup-material-infotext").html('Grenzen festlegen, wie viele Steine an der Station vorgehalten werden:');
					$(".grid-popup-material-produktbild").append("<div class='popup-material-produktbild'><img class='popup-material-produktbild' src='" + obj[key].SteinImage + "' ></div>");
					$(".grid-popup-material-txtAnzahl").append("<div class='popup-material-txtAnzahl'><button type='button' id='btnMaterialMinus' onclick='btnArbeitsstationPlusMinus(" + key + ", \"minus\", \"#txtMaterial\", " + obj[key].SteinID + ", " + stationsID + ")'>-</button><input type='hidden' id='" + key + "hiddenSteinID' value='" + obj[key].SteinID + "'><input type='textbox' id='txtMaterial" + key + "' disabled='disabled' class='txtMaterial' value='" + obj[key].Grenze + "' placeholder='Grenze'><button type='button' id='btnMaterialPlus' onclick='btnArbeitsstationPlusMinus(" + key + ", \"plus\", \"#txtMaterial\", " + obj[key].SteinID + ", " + stationsID + ")'>+</button></div>");
					$(".grid-popup-material-button").html("<button type='button' class='btnMaterialGrenzen' onclick='btnMaterialGrenzen(" + stationsID + ", " + key + ")'>Grenze festlegen</button>");

				}

			}	

		});

	}

	//Diese Methode liest im Interface alle dynamischen generierten Textboxen aus (bei manueller Bestellung) und übergibt es mit der StationsID und anzahlSteinTypen via
	//Ajax und POST-Methode ans framework.php
	function btnMaterialBestellen(stationsID, anzahlSteinTypen) {
		
		var arrayBestellung;

		//Achtung: anzahlSteinTypen beginnt bei 0 an zu zählen!

		//Zwei verschiedene SteinTypen
		if(anzahlSteinTypen == 1) {	
			//Funktioniert
			arrayBestellung = [{StationsID: stationsID, MaterialBestellung: [{SteinID: $('#0hiddenSteinID').val(), MaterialMenge: $('#txtMaterial0').val()}, {SteinID: $('#1hiddenSteinID').val(), MaterialMenge: $('#txtMaterial1').val()}]}];
		}
		//Drei verschiedene SteinTypen
		if(anzahlSteinTypen == 2) {

			arrayBestellung = [{StationsID: stationsID, MaterialBestellung: [{SteinID: $('#0hiddenSteinID').val(), MaterialMenge: $('#txtMaterial0').val()}, {SteinID: $('#1hiddenSteinID').val(), MaterialMenge: $('#txtMaterial1').val()}, {SteinID: $('#2hiddenSteinID').val(), MaterialMenge: $('#txtMaterial2').val()}]}];

		}
		//Vier verschiedene SteinTypen
		if(anzahlSteinTypen == 3) {

			arrayBestellung = [{StationsID: stationsID, MaterialBestellung: [{SteinID: $('#0hiddenSteinID').val(), MaterialMenge: $('#txtMaterial0').val()}, {SteinID: $('#1hiddenSteinID').val(), MaterialMenge: $('#txtMaterial1').val()}, {SteinID: $('#2hiddenSteinID').val(), MaterialMenge: $('#txtMaterial2').val()}, {SteinID: $('#3hiddenSteinID').val(), MaterialMenge: $('#txtMaterial3').val()}]}];
		}
		//Fünf verschiedene SteinTypen
		if(anzahlSteinTypen == 4) {

			arrayBestellung = [{StationsID: stationsID, MaterialBestellung: [{SteinID: $('#0hiddenSteinID').val(), MaterialMenge: $('#txtMaterial0').val()}, {SteinID: $('#1hiddenSteinID').val(), MaterialMenge: $('#txtMaterial1').val()}, {SteinID: $('#2hiddenSteinID').val(), MaterialMenge: $('#txtMaterial2').val()}, {SteinID: $('#3hiddenSteinID').val(), MaterialMenge: $('#txtMaterial3').val()}, {SteinID: $('#4hiddenSteinID').val(), MaterialMenge: $('#txtMaterial4').val()}]}];
		}

		var jsonBestellung = JSON.stringify(arrayBestellung);

		$.post('Framework/framework.php', {btnMaterialBestellen: jsonBestellung}, function(data) {
			//Schließt das Popup, nachdem die 
			closePopUp();
		});


	}

	//Diese Methode liest im Interface alle dynamischen generierten Textboxen aus (bei automatischer Bestellung) und übergibt es mit der StationsID und anzahlSteinTypen via
	//Ajax und POST-Methode ans framework.php
	function btnMaterialGrenzen(stationsID, anzahlSteinTypen) {

		var arrayBestellGrenzen;

		//Achtung: anzahlSteinTypen beginnt bei 0 an zu zählen!

		//Zwei verschiedene SteinTypen
		if(anzahlSteinTypen == 1) {	
			//Funktioniert
			arrayBestellGrenzen = [{StationsID: stationsID, MaterialGrenzen: [{SteinID: $('#0hiddenSteinID').val(), MaterialMenge: $('#txtMaterial0').val()}, {SteinID: $('#1hiddenSteinID').val(), MaterialMenge: $('#txtMaterial1').val()}]}];
		}
		//Drei verschiedene SteinTypen
		if(anzahlSteinTypen == 2) {

			arrayBestellGrenzen = [{StationsID: stationsID, MaterialGrenzen: [{SteinID: $('#0hiddenSteinID').val(), MaterialMenge: $('#txtMaterial0').val()}, {SteinID: $('#1hiddenSteinID').val(), MaterialMenge: $('#txtMaterial1').val()}, {SteinID: $('#2hiddenSteinID').val(), MaterialMenge: $('#txtMaterial2').val()}]}];

		}
		//Vier verschiedene SteinTypen
		if(anzahlSteinTypen == 3) {

			arrayBestellGrenzen = [{StationsID: stationsID, MaterialGrenzen: [{SteinID: $('#0hiddenSteinID').val(), MaterialMenge: $('#txtMaterial0').val()}, {SteinID: $('#1hiddenSteinID').val(), MaterialMenge: $('#txtMaterial1').val()}, {SteinID: $('#2hiddenSteinID').val(), MaterialMenge: $('#txtMaterial2').val()}, {SteinID: $('#3hiddenSteinID').val(), MaterialMenge: $('#txtMaterial3').val()}]}];
		}
		//Fünf verschiedene SteinTypen
		if(anzahlSteinTypen == 4) {

			arrayBestellGrenzen = [{StationsID: stationsID, MaterialGrenzen: [{SteinID: $('#0hiddenSteinID').val(), MaterialMenge: $('#txtMaterial0').val()}, {SteinID: $('#1hiddenSteinID').val(), MaterialMenge: $('#txtMaterial1').val()}, {SteinID: $('#2hiddenSteinID').val(), MaterialMenge: $('#txtMaterial2').val()}, {SteinID: $('#3hiddenSteinID').val(), MaterialMenge: $('#txtMaterial3').val()}, {SteinID: $('#4hiddenSteinID').val(), MaterialMenge: $('#txtMaterial4').val()}]}];
		}

		var jsonBestellGrenzen = JSON.stringify(arrayBestellGrenzen);

		$.post('Framework/framework.php', {btnMaterialGrenzen: jsonBestellGrenzen}, function(data) {
			
			closePopUp();

		});

	}

	/*------------------------------------------------------------------------------------------------------*/
	/*-------------------------------------ENDE VON ARBEITSSTATIONEN 1 - 5----------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/

	/*------------------------------------------------------------------------------------------------------*/
	/*--------------------------------------START VON QUALITÄTSKONTROLLE------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/

	//Diese Methode lädt das aktuelle EndProdukt für die Qualitätskontrolle über Ajax und POST-Methode.
	function ladeEndProduktQualitaet(stationsNummer) {

		$.post('Framework/framework.php', { ladeEndProduktQualitaet: stationsNummer }, function(data) {
			
			var obj = $.parseJSON(data);
			ladeEndProduktAnleitungQualitaet(obj.BestellungsID, obj.EndProduktID);

		});

	}

	//Diese Methode lädt die Anleitung eines mit dem Parameter übergebene EndProduktID und stellt es grafisch dar
	function ladeEndProduktAnleitungQualitaet(bestellungsID, endProduktID) {

		$.post('Framework/framework.php', { ladeEndProduktAnleitungQualitaet: endProduktID }, function(data) {
			
			var obj = $.parseJSON(data);

			if(obj.EndProduktImage == null) {

				$('.title-bauteile').html("");
				$('.grid-produktbild').html("");
				$('.grid-nachbessern-button').html("");
				$('.grid-ausliefern-button').html("");
				$('#timer-anzeige').html("");

			} else {

				$('.title-bauteile').html("BestellungsID: " + bestellungsID);

				$('.grid-produktbild').html("<div class='container'><img class='image-Quality' src='" + obj.EndProduktImage + "'/></div>");
				
				$('.grid-nachbessern-button').html("<button type='button' class='button-nachbessern' name='btnNachbessern' onclick='setzeQualitaetStatus(2, " + bestellungsID + ")'>Nachbessern</button>");
				$('.grid-ausliefern-button').html("<button type='button' class='button-ausliefern' name='btnAusliefern' onclick='setzeQualitaetStatus(1, " + bestellungsID + ")'>Ausliefern</button>");

				//lädt die Taktzeit
				ladeSynchronisierteTaktzeit(bestellungsID);

			}

			

		});

	}

	//Diese Methode übermittelt and die Datenbank die BestellungsID und den status (1 => Auslieferung Kunden, 2 => Nachbessern/Retoure Meister) mithilfe von Ajax und der POST-Methode
	function setzeQualitaetStatus(status, bestellungsID) {

		$.post('Framework/framework.php', { setzeQualitaetStatus: status, setzeQualitaetStatusBestellungsID: bestellungsID}, function(data) {});
		ladeEndProduktQualitaet(6);

	}


	/*------------------------------------------------------------------------------------------------------*/
	/*--------------------------------------ENDE VON QUALITÄTSKONTROLLE-------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/

	/*------------------------------------------------------------------------------------------------------*/
	/*------------------------------------------START VON LOGISTIK------------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/

	//Diese Methode lädt dynamisch via Ajax und der POST-Methode Inhalte für die Logistikübersicht in Echtzeit. Der Parameter stationsNummer wird dabei an die PHP-Methode mit übergeben. (Details siehe Framework.php)
	function ladeLogistikÜbersicht(stationsNummer) {

		var StationsNamenID = '#LogistikStation' + stationsNummer;

		setInterval(function() {
			$.post('Framework/framework.php', { ladeLogistik: stationsNummer }, function(data) {

				$(StationsNamenID).html(data);

			});
		}, 1500); //Alle 1,5 Sekunden

	}

	//Diese Methode lädt den Inhalt der Anlieferungsliste dynamisch via Ajax und POST-Methode über die Parameter ladeLogistikSlider nach.
	function ladeAnlieferungsliste() {

		setInterval(function() {

			$.post('Framework/framework.php', { ladeLogistikSlider: 'true' } , function(data) {
				
				$('.bestellungsslider').html(data);

			});

		}, 1500); //Alle 1,5 Sekunden
	}

	//Diese Methode setzt eine bestimmte Anlieferung übergeben mit AnlieferungsID in der Datenbank auf fertig. 
	function UpdateAnlieferungFertig(AnlieferungsID) {

		$.post('Framework/framework.php', { UpdateAnlieferungFertig: AnlieferungsID }, function(data) {});

	}

	//Diese Methode setzt eine bestimmte Anlieferung übergeben mit AnlieferungsID in der Datenbank auf in Bearbeitung. 
	function UpdateAnlieferungBearbeitung(AnlieferungsID) {

		$.post('Framework/framework.php', { UpdateAnlieferungBearbeitung: AnlieferungsID }, function(data) {});

	}

	//Diese Methode lädt dynamisch via Ajax und POST-Methode die Inhalte des Umbuchungs-PopUp.
	function ladeUmbuchungenPopUpInhalt() {

		openPopUpGross();

		$.post('Framework/framework.php', {ladeUmbuchungenPopUpInhalt: true}, function(data) {
			
			var obj = $.parseJSON(data);

			for(var key in obj) {

				$('#select-steintypen').append("<option value='" + obj[key].SteinID + "'>" + obj[key].SteinBezeichnung + "</option>");

			}

		});

	}

	//Diese Methode liest via Ajax und POST-Methode den Inhalt der Textboxen aus dem Umbuchungspopup aus und übergibt es in einem
	//json-objekt über den Parameter umbuchungStationZuStation an das framework.php.
	function umbuchungStationZuStation() {

		var ausgangsStation = $('#select-ausgangsStation').val();
		var zielStation = $('#select-zielStation').val();
		var steinTyp = $('#select-steintypen').val();
		var steinAnzahl = $('#txtAnzahlSteineUmbuchung').val();

		arrayUmbuchung = [steinTyp, ausgangsStation, zielStation, steinAnzahl];
		var jsonUmbuchung = JSON.stringify(arrayUmbuchung);

		$.post('Framework/framework.php', {umbuchungStationZuStation: jsonUmbuchung}, function(data) {
			//PopUp schließen
			closePopUp();
			
		});

	}

	/*------------------------------------------------------------------------------------------------------*/
	/*-------------------------------------------ENDE VON LOGISTIK------------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/

	/*------------------------------------------------------------------------------------------------------*/
	/*-------------------------------------------START VON MEISTER------------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/
	
	//Diese Methode lädt via Ajax und POST-Methode die Retouren in die Retourenliste.
	function ladeRetouren() {

		setInterval(function() {

			$.post('Framework/framework.php', { holeRetouren: true}, function(data) {

				var obj = $.parseJSON(data);

				//Wenn das Objekt leer ist. Überprüfung findet statt, sonst bleibt immer eine Retoure in der Liste stehen, egal ob sie schon fertig ist oder nicht.
				if($.isEmptyObject(obj) == true) {
					
					//Liste leeren
					$('.table').html("");
					$('.table').html("<tr class='table-row'><th>ID</th><th>Bild</th><th>Durchgefallen bei</th><th>Anzeigen</th></tr>");

				}

				for(var key in obj) {

					if(key == 0) {

						$('.table').html("");
						$('.table').html("<tr class='table-row'><th>ID</th><th>Bild</th><th>Durchgefallen bei</th><th>Anzeigen</th></tr>");
					
					}
					
					$('.table').append("<tr class='table-row'><td class='table-cell'>" + obj[key].BestellungsID +"</td><td class='table-cell'><img class='table-cell-produktbild' src='" + obj[key].EndProduktImage + "'></td><td class='table-cell'>" + obj[key].StationDurchgefallen + "</td><td class='table-cell'><button class='btnRetourenAnzeigen' name='btnRetoureReparieren' onclick=\"retoureAnzeigen(" + obj[key].BestellungsID + ", '"+ obj[key].EndProduktImage + "')\">Anzeigen</button></td></tr>");	

				}

			});

		}, 1000);

	}

	//Diese Methode zeigt das Endproduktbild und den Button "Reparieren" an, für das Produkt, auf dessen "Anzeigen"-Button geklickt wird.
	function retoureAnzeigen(bestellungsID, endProduktImage) {

		$('.grid-retourenAnleitung').html("<div class='container'><img class='retouren-Anleitung-Produktbild' src='" + endProduktImage + "'></div>");
		$('.grid-retoureButton').html("<button class='button-ausliefern' onclick=\"retoureRepariert(" + bestellungsID + ")\">Repariert</button>");

	}

	//Diese Methode übergibt via Ajax und POST-Methode an die Datenbank, dass das Produkt hinter der BestellungsID repariert ist.
	function retoureRepariert(bestellungsID) {

		$.post('Framework/framework.php', { retoureRepariert: bestellungsID}, function(data) {
			
			//Ausblenden
			$('.grid-retourenAnleitung').html("");
			$('.grid-retoureButton').html("");

		});

	}


	/*------------------------------------------------------------------------------------------------------*/
	/*--------------------------------------------ENDE VON MEISTER------------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/


	/*-------------------------------------------------------------------------------------------------------------------------*/
	/*-------------------------------------------------------------------------------------------------------------------------*/
	/*------------------------------------------------------ANALYTICS----------------------------------------------------------*/
	/*-------------------------------------------------------------------------------------------------------------------------*/
	/*-------------------------------------------------------------------------------------------------------------------------*/

	//Diese Methode lädt den Inhalt des PopUps Analytics-Auswahl auf der Analytics.php-Seite via Ajax und POST-Methode und stellt es grafisch dar.
	function ladeAnalyticsAuswahl() {

		openPopUpGross();

		$.post('Framework/framework.php', {ladeAnalyticsAuswahl: true}, function(data) {

			$(".grid-popup-analytics-produktionsperioden").html(""); //Alte Rückstände leeren

			var obj = $.parseJSON(data);
			
			for(var key in obj) {
				
				$(".grid-popup-analytics-infotext").html("Wählen Sie bis zu drei Produktionsperioden aus, die in den Analytics angezeigt werden sollen.");
				$(".grid-popup-analytics-produktionsperioden").append("<div class='checkbox-produktionsperioden-wrapper'><label class='control-ms control-ms-checkbox'>" + obj[key].Bezeichnung + "<input type='checkbox' name='cbAnalytics' id='cbAnalytics" + key + "' value='" + obj[key].SpielID + "'/><div class='control-ms_indicator'></div></label></div>");
				$(".grid-popup-analytics-button").html("<button class='btnMaterialGrenzen' onclick='btnAnalyticsAuswahl(" + key + ")'>Anzeigen</button>");

			}

		});

	}

	//Diese Methode liest den Wert der Checkboxen aus und übergibt ihn via Ajax und POST-Methode an die Datenbank.
	function btnAnalyticsAuswahl(anzahlSpiele) {

		var sperrStatus = 0; //Wird 1, wenn man das Fenster nicht schließen darf, weil die Fehlermeldung "max. 3 Checkboxen ankreuzen" anzeigt werden soll
		var arrayAuswahl = [];

		for(var i = 0; i <= anzahlSpiele; i++) {


			var idCheckName = "#cbAnalytics" + i;

			if($(idCheckName).is(':checked') == true) {

				var spielID = $(idCheckName).val();

				if(arrayAuswahl.length < 3){

					arrayAuswahl.push(spielID);

					sperrStatus = 0;

				} else {

					$(".grid-popup-analytics-infotext").html("<span class='status-red'>Es können maximal Analytics aus 3 Produktionsperioden gleichzeitig angezeigt werden</span>");

					sperrStatus = 1;
				}
				
			}

		}

		//Es sind 3 oder weniger Checkboxen ausgewählt
		if(sperrStatus == 0) {

			var jsonAuswahl = JSON.stringify(arrayAuswahl);
			$.post('Framework/framework.php', {setzeAnalyticsAuswahl: jsonAuswahl}, function(data) {

				closePopUp();

				//Seite neu laden, da man die Charts nur sehr mühsam dynamisch nachladen kann
				location.reload(true);

			});
		}
		

	}

	//Alle AnalyticsCharts befinden sich im analytics.php, weil sonst mit der Einbindung des Chart.js Frameworks nicht gekappt hätte.






	/*------------------------------------------------*/
	//Noch nicht einsortiert



	

	

	

	
	




	/*///Aufruf der Funktion zur 3D Ansicht
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

	function ladeCADViewer(endProduktID) {

		$('.cadViewer').html("");
		$('.cadViewer').html("<canvas id='fullscreen' class='3dviewer' sourcefiles='include/CAD-Viewer/emb/endpro-obj/EndProduktID" + endProduktID + "/Endprod.obj|include/CAD-Viewer/emb/endpro-obj/EndProduktID" + endProduktID + "/Endprod.mtl' width='300' height='300' style='width: 300px; height: 300px;'>p</canvas>");		

		window.addEventListener('load', OnLoad, true);
		window.addEventListener('resize', OnResize, true);

	}*/

	/*function ladeProduktionsleiterObergrenzen() {

		//Dies sind die Obergrenzen, die vom Produktionsleiter festgelegt werden können


	}*/


	/*	/*Slider
	function slider() {
		$(document).ready(function(){
	      $('.slider').slick({
	        arrows: true,
	        infinite: false,
	        slidesToShow: 10,
	        slidesToScroll: 3,
	        mobileFirst: true 
	      });
	    });
	}*/


	/*function erstelleMehrfachBestellung(endProduktID) {

	}

	//Timer
	/*var timeout;

	function timer(status) {
		//Wert des Timer Resets
		var counter = 30;
		

		//Timer zurücksetzen
		if (status == 1) {
			//clearTimeout(timeout);
			clearInterval(timeout);
			document.getElementById("timer-anzeige").innerHTML = "Timer: " + counter;
		}
		//Herunterzählen des Timers
		if (status == 0) {
			timeout = setInterval(function() {
			counter--;
			if( counter >= 0 ){
				id = document.getElementById("timer-anzeige");
				id.innerHTML = "Timer: " + counter;
			}
			//Anzeige wenn Timer auf null
			if( counter === 0 ){
				//id.innerHTML = "Bitte neue Bestellung tätigen!"; //Muss noch für Stationen und Kunde angepasst werden
			}
			//1000 = 1 Sekunde
			} ,1000);
		}
	}*/

		//Lädt den Button für die Spielleiterseite, auf der man die schwarze Werkzeugaufnahme aktivieren oder deaktivieren kann
	/*function ladeOptionWerkzeugaufnahme(status) {
		
		$.post('Framework/framework.php', {ladeOptionWerkzeugaufnahme: status}, function(data) {

			//Wenn die schwarze Werkzeugaufnahme aktiviert ist
			if(data == 9) {
				$('.optionWerkzeugaufnahme').html("<button class='action-button' onclick=\"ladeOptionWerkzeugaufnahme(1)\">Deaktivieren</button>");
			}
			//Wenn die weiße Werkzeugaufnahme aktiviert ist
			if(data == 1) {
				$('.optionWerkzeugaufnahme').html("<button class='action-button' onclick=\"ladeOptionWerkzeugaufnahme(9)\">Aktivieren</button>");
			}
			

		});

	}*/

	


	


	

