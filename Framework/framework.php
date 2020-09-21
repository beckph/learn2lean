<?php
	
	//Setzt als Timezone "Europa/Berlin" für alle Timestamps
	date_default_timezone_set('Europe/Berlin');

	/*------------------------------------------------------------------------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/
	/*-------------------------------------VERBINDUNG PHP UND Javascript------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/

	//Hier befindet sich die Verbindung zwischen dem Framework.js und dem Framework.php. Für die Kommunikation wird
	//auf im Framework.js auf die AJAX-Technologie zurückgegriffen und via POST-Method an Framework.php geschickt.

	/*------------------------------------------------------------------------------------------------------*/
	/*------------------------------------START VON ALLGEMEINE METHODEN-------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/
	//ALLE POST-Methoden die auf mehr als einer Seite aufgerufen werden aufgerufen werden.

	if(isset($_POST['ladeSynchronisierteTaktzeit'])) {
		
		$taktZeit = $_POST['ladeSynchronisierteTaktzeit'];
		holeSychroneTaktzeit($taktZeit);
	}

	/*Produktionsleiter und Meister*/
	if(isset($_POST['ladeCADAnleitungen'])) {
		
		zeigeCADAnleitungen();
	}

	/*Hilfe*/
	if(isset($_POST['forderHilfe'])) {
		
		$stationsNummer = $_POST['forderHilfe'];
		anforderungHilfe($stationsNummer);
	}

	if(isset($_POST['ladeHilfsanforderungen'])) {
		
		$position = $_POST['ladeHilfsanforderungen']; //Übergibt ob Meister oder Produktionsleiter die Hilfsanforderungen abruft
		holeHilfsanforderungen($position);
	}

	if(isset($_POST['abgeschlossenHilfe'])) {
		
		$stationsNummer = $_POST['abgeschlossenHilfe'];
		abgeschlossenHilfe($stationsNummer);
	}

	/*------------------------------------------------------------------------------------------------------*/
	/*------------------------------------START VON ALLGEMEINE METHODEN-------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/

	/*------------------------------------------------------------------------------------------------------*/
	/*-----------------------------------------START VON SPIELLEITER----------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/
	//ALLE POST-Methoden die auf der Spielleiterseite aufgerufen werden.

	if(isset($_POST['ladeSpielOptionen'])) {
		
		$querySpiel = abfrageDB("SELECT MAX(SpielID), Bezeichnung, Status FROM spiel WHERE Status = '1' OR Status = '2' GROUP BY SpielID");
		$resultSpiel = mysqli_fetch_array($querySpiel);
		echo json_encode(["SpielID" => $resultSpiel[0], "Bezeichnung" => $resultSpiel[1], "Status" => $resultSpiel[2]]);
	}

	if(isset($_POST['erstelleSpiel'])) {
		
		$arrayErstelleSpiel = json_decode($_POST['erstelleSpiel']);

		$spielName = $arrayErstelleSpiel[0];
		$statusMaterialstandUebernahme = $arrayErstelleSpiel[1];
		erstelleNeuesSpiel($spielName, $statusMaterialstandUebernahme);
	}

	if(isset($_POST['beendeSpiel'])) {
		
		$spielID = $_POST['beendeSpiel'];
		beendeSpiel($spielID);
	}

	if(isset($_POST['pausiereSpiel'])) {
		//Übergabe
		$spielID = $_POST['pausiereSpiel'];
		pausiereSpiel($spielID);
	}
	if(isset($_POST['ladeBestellModus'])) {
		echo holeSpielModusBestellungen();
	}

	if(isset($_POST['pruefeSpielStatus'])) {
		$spielID = holeSpielID();
		$spielStatus = holeSpielStatus($spielID);
		echo $spielStatus;
	}

	if(isset($_POST['optionWerzeugaufnahme'])) {
		$status = $_POST['optionWerzeugaufnahme'];

		setzeWerkzeugaufnahmeStatus($status);
	}

	if(isset($_POST['setzeWerkseinstellungen'])) {
		setzteAufWerkseinstellungen();
	}

	if(isset($_POST['ladeAktuelleTaktzeit'])) {
		echo holeAktuelleTaktzeit();
	}

	
	if(isset($_POST['setzeTaktzeit'])) {
		$taktzeit = $_POST['setzeTaktzeit'];
		abfrageDB("UPDATE spiel SET Takt = '" . $taktzeit . "' WHERE SpielID = '" . holeSpielID() . "'");
	}

	if(isset($_POST['ladeAkkuAnzeige'])) {

		holeAkkuStand();
	}

	if(isset($_POST['ladeAusgangsbestand'])) {

		aktiviereAusgangsbestand();

	}

	/*------------------------------------------------------------------------------------------------------*/
	/*-----------------------------------------ENDE VON SPIELLEITER-----------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/

	/*------------------------------------------------------------------------------------------------------*/
	/*------------------------------------------START VON KUNDE---------------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/
	//ALLE POST-Methoden die auf der Kundenseite aufgerufen werden.

	/*Kunde*/
	if(isset($_POST['ladeKundenBestellenButton'])) {

		//Synergieeffekte durch auslagern in eine Methode mit ladeProduktfreischaltungOption zusammenlegen
		$statusWerkzeugaufnahme = holeWerkzeugaufnahmeStatus();

		$statusEndProduktLila = pruefeEndProduktFreischaltungen(6);
		$statusEndProduktOrange = pruefeEndProduktFreischaltungen(5);

		$arrayResult = ['statusWerkzeugaufnahme' => $statusWerkzeugaufnahme, 'statusEndProduktLila' => $statusEndProduktLila, 'statusEndProduktOrange' => $statusEndProduktOrange];

		echo json_encode($arrayResult);


	}

	if(isset($_POST['ladeKundeBestellungen'])) {
		
		zeigeBestellungenKunde();
	}

	if(isset($_POST['erstelleBestellung'])) 
	{
		$farbe = $_POST['erstelleBestellung'];
		erstelleBestellung($farbe);
	}
	
	//Mehrfach	
	if(isset($_POST['erstelleMehrfachBestellungen'])) 
	{
		$farbe = $_POST['erstelleMehrfachBestellungen'];
		erstelleMehrfachBestellungen($farbe);
	}
		

	if(isset($_POST['ladeAuslieferungKunde'])) {
		holeAuslieferungKunde();
	}

	if(isset($_POST['bestellungStornieren'])) {
		
		$bestellungsID = $_POST['bestellungStornieren'];
		abfrageDB("DELETE FROM bestellungen WHERE BestellungsID = '" . $bestellungsID . "'");
	}

	if(isset($_POST['kundeWarenannahme'])) {
		
		$status = $_POST['kundeWarenannahme'];
		$bestellungsID = $_POST['kundenWarenannahmeBestellungsID'];
		if($status == 1) {
			genehmigtKunde($bestellungsID);
		} 
		if($status == 2) {
			abgelehntKunde($bestellungsID);
		}
	}

	if(isset($_POST['pruefeEndProduktFreischaltungen'])) {
		
		$endProduktID = $_POST['pruefeEndProduktFreischaltungen'];
		echo pruefeEndProduktFreischaltungen($endProduktID);
	}

	if(isset($_POST['freischaltenProdukt'])) {
		
		$endProduktID = $_POST['freischaltenProdukt'];
		freischaltenProdukt($endProduktID);
	}

	if(isset($_POST['ladeProduktFreischaltungOption'])) {

		////Synergieeffekte durch auslagern in eine Methode mit ladeKundeBestellenButton zusammenlegen in eine Methode, da der Code 100%ig gleich ist
		$statusWerkzeugaufnahme = holeWerkzeugaufnahmeStatus();

		$statusEndProduktLila = pruefeEndProduktFreischaltungen(6);
		$statusEndProduktOrange = pruefeEndProduktFreischaltungen(5);

		$arrayResult = ['statusWerkzeugaufnahme' => $statusWerkzeugaufnahme, 'statusEndProduktLila' => $statusEndProduktLila, 'statusEndProduktOrange' => $statusEndProduktOrange];

		echo json_encode($arrayResult);
	}

	/*------------------------------------------------------------------------------------------------------*/
	/*-------------------------------------------ENDE VON KUNDE---------------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/

	/*------------------------------------------------------------------------------------------------------*/
	/*--------------------------------------START VON PRODUKTIONSLEITER-------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/
	//ALLE POST-Methoden die auf der Produktionsleiterseite aufgerufen werden.

	if(isset($_POST['freigebenZurProduktion'])) {

		$arrayProduktionsFreigabe = $_POST['freigebenZurProduktion'];
		$bestellungsID = $arrayProduktionsFreigabe[0];
		$art = $arrayProduktionsFreigabe[1];
		
		freigebenZurProduktion($bestellungsID, $art);
	}

	if(isset($_POST['ladeFreigegebeneBestellungen'])) {
		
		zeigeFreigegebeneBestellungen();
	}

	if(isset($_POST['ladeProduktionsleiterMaximaleGrenzwerte'])) {

		$stationsID = $_POST['ladeProduktionsleiterMaximaleGrenzwerte'];
		zeigeProduktionsleiterMaximaleGrenzwerte($stationsID);
	}

	if(isset($_POST['btnMaterialGrenzen'])) {

		$maximaleGrenzwerte = $_POST['btnMaterialGrenzen'];
		setzeProduktionsleiterMaximaleGrenzwerte($maximaleGrenzwerte);
	}

	/*------------------------------------------------------------------------------------------------------*/
	/*---------------------------------------ENDE VON PRODUKTIONSLEITER-------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/

	/*------------------------------------------------------------------------------------------------------*/
	/*-------------------------------------START VON ARBEITSSTATIONEN 1 - 5---------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/
	//ALLE POST-Methoden die auf den Arbeitsstationsseiten aufgerufen werden.

	if(isset($_POST['ladeAuftragsliste'])) {
		$stationsNummer = $_POST['ladeAuftragsliste'];

		if($stationsNummer == 6) {
			$seitenurl = "Qualitaetskontrolle.php";
		} else {
			$seitenurl = "Station" . $stationsNummer . ".php";
		}
		
		zeigeAuftragsliste($stationsNummer, $seitenurl);
	}

	if(isset($_POST['ladeTeilProdukt'])) {
		
		$stationsNummer = $_POST['ladeTeilProdukt'];
		holeZurProduktionFreigegebeneProdukte($stationsNummer);
	}

	if(isset($_POST['ladeEndProdukt'])) {
		
		$stationsNummer = $_POST['ladeEndProdukt'];
		holeZurProduktionFreigegebeneProdukte($stationsNummer);	
	}

	if(isset($_POST['ladeAnleitungTeilProdukt_TeilProduktID'])) {
		$teilProduktID = $_POST['ladeAnleitungTeilProdukt_TeilProduktID'];

		if(isset($_POST['ladeAnleitungTeilProdukt_StationsNummer'])) {
			$stationsNummer = $_POST['ladeAnleitungTeilProdukt_StationsNummer'];
			zeigeTeilProduktAnleitung($teilProduktID, $stationsNummer);
		}	
	}

	if(isset($_POST['ladeAnleitungEndProdukt'])) {
		$endProduktID = $_POST['ladeAnleitungEndProdukt'];
		zeigeEndProduktAnleitung($endProduktID);
	}

	if(isset($_POST['ladeMaterialbedarfTeilProdukt_TeilProduktID'])) {
		$teilProduktID = $_POST['ladeMaterialbedarfTeilProdukt_TeilProduktID'];

		if(isset($_POST['ladeMaterialbedarfTeilProdukt_StationsNummer'])) {
			$stationsNummer = $_POST['ladeMaterialbedarfTeilProdukt_StationsNummer'];
			zeigeMaterialbedarfTeilProdukt($teilProduktID, $stationsNummer);
		}
	}

	if(isset($_POST['ladeMaterialbedarfEndProdukt'])) {
		$endProduktID = $_POST['ladeMaterialbedarfEndProdukt'];
		zeigeMaterialbedarfEndProdukt($endProduktID);
	}

	if(isset($_POST['montiertTeilProdukt'])) {
		$bestellungsID = $_POST['montiertTeilProdukt'];
		$stationsNummer = $_POST['stationNummer'];
		montiertTeilProdukt($bestellungsID, $stationsNummer);
	}

	if(isset($_POST['ladeMaterialPopUpInhalt'])) {

		$stationsNummer = $_POST['ladeMaterialPopUpInhalt'];
		$bestellModus = holeSpielModusBestellungen();
		holeMaterialPopUpInhalt($bestellModus, $stationsNummer);
	}

	if(isset($_POST['setzeBestellModus'])) {
		$aktuellerSpielModus = $_POST['setzeBestellModus'];
		bearbeiteSpielModusBestellungen($aktuellerSpielModus);
	}

	if(isset($_POST['btnMaterialBestellen'])) {
		
		erstelleManuelleBestellung($_POST['btnMaterialBestellen']);
	}

	if(isset($_POST['btnMaterialGrenzen'])) {

		setzeAutoBestellungsGrenzen($_POST['btnMaterialGrenzen']);
	}

	if(isset($_POST['ladeMaximaleGrenzwerte'])) {

		$arrayMaximaleGrenzwerte = $_POST['ladeMaximaleGrenzwerte'];

		$steinID = $arrayMaximaleGrenzwerte[0];
		$stationsNummer = $arrayMaximaleGrenzwerte[1];

		echo holeMaximaleGrenzwerte($steinID, $stationsNummer);
	}


	/*------------------------------------------------------------------------------------------------------*/
	/*-------------------------------------ENDE VON ARBEITSSTATIONEN 1 - 5----------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/

	/*------------------------------------------------------------------------------------------------------*/
	/*--------------------------------------START VON QUALITÄTSKONTROLLE------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/
	//ALLE POST-Methoden die auf der Qualityseite aufgerufen werden.

	if(isset($_POST['ladeEndProduktQualitaet'])) {
		
		$stationsNummer = $_POST['ladeEndProduktQualitaet'];
		holeZurProduktionFreigegebeneProdukte($stationsNummer);

		/*$bestellungsID = holeGeringsteBestellungsID($stationNummer);
		$endProduktID = holeEndProduktID($bestellungsID);
		echo json_encode(['BestellungsID' => $bestellungsID, 'EndProduktID' => $endProduktID]);*/
	}

	if(isset($_POST['ladeEndProduktAnleitungQualitaet'])) {
		$endProduktID = $_POST['ladeEndProduktAnleitungQualitaet'];
		zeigeEndProduktQualitaet($endProduktID);
	}

	if(isset($_POST['setzeQualitaetStatus'])) {
		$status = $_POST['setzeQualitaetStatus'];
		$bestellungsID = $_POST['setzeQualitaetStatusBestellungsID'];
		if($status == 1) {
			//Produkt ausliefern
			ausliefernEndProdukt($bestellungsID);
		}
		if($status == 2) {
			//Produkt nachbessern
			nachbessernEndProdukt($bestellungsID);
		}
	}

	/*------------------------------------------------------------------------------------------------------*/
	/*--------------------------------------ENDE VON QUALITÄTSKONTROLLE-------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/

	/*------------------------------------------------------------------------------------------------------*/
	/*------------------------------------------START VON LOGISTIK------------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/
	//ALLE POST-Methoden die auf der Logistikseite aufgerufen werden.

	if(isset($_POST['ladeLogistik'])) {
		$stationNummer = $_POST['ladeLogistik'];
		zeigeLogistikStatus($stationNummer);
	}
	//Slider
	if(isset($_POST['ladeLogistikSlider'])) {
		aktuelleAnlieferungeninBearbeitungSlider();
		aktuelleAnlieferungenSlider();
	}

	if(isset($_POST['UpdateAnlieferungFertig'])) {
		$AnlieferungsID = $_POST['UpdateAnlieferungFertig'];
		updateAnlieferungBearbeitung($AnlieferungsID);
	}
	if(isset($_POST['UpdateAnlieferungBearbeitung'])) {
		$AnlieferungsID = $_POST['UpdateAnlieferungBearbeitung'];
		updateAnlieferungFertiggestellt($AnlieferungsID);
	}
	if(isset($_POST['ladeUmbuchungenPopUpInhalt'])) {
		zeigeUmbuchungenPopUpInhalt();
	}
	if(isset($_POST['umbuchungStationZuStation'])) {
		
		$arrayUmbuchung = json_decode($_POST['umbuchungStationZuStation']);
		
		//Parameter: SteinID, AusgangsStation, ZielStation, Anzahl
		lieferungZuAndererStation($arrayUmbuchung[0], $arrayUmbuchung[1], $arrayUmbuchung[2], $arrayUmbuchung[3]);
	}

	/*------------------------------------------------------------------------------------------------------*/
	/*-------------------------------------------ENDE VON LOGISTIK------------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/

	/*------------------------------------------------------------------------------------------------------*/
	/*-------------------------------------------START VON MEISTER------------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/
	//ALLE POST-Methoden die auf der Meisterseite aufgerufen werden.

	/*Meister*/
	if(isset($_POST['holeRetouren'])) {
		
		holeRetouren();
	}

	if(isset($_POST['retoureRepariert'])) {
		
		$bestellungsID = $_POST['retoureRepariert'];
		retoureRepariert($bestellungsID);
	}

	/*------------------------------------------------------------------------------------------------------*/
	/*--------------------------------------------ENDE VON MEISTER------------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/

	/*------------------------------------------------------------------------------------------------------*/
	/*-------------------------------------------START VON ANALYTICS----------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/
	//ALLE POST-Methoden die auf der Analyticsseite aufgerufen werden.
	
	if(isset($_POST['ladeAnalyticsAuswahl'])) {

		zeigeAnalyticsAuswahl();

	}
	
	if(isset($_POST['setzeAnalyticsAuswahl'])) {

		$arrayAuswahl = json_decode($_POST['setzeAnalyticsAuswahl']);

		setzeAnalyticsAuswahl($arrayAuswahl[0], $arrayAuswahl[1], $arrayAuswahl[2]);

	}
	

	/*------------------------------------------------------------------------------------------------------*/
	/*--------------------------------------------ENDE VON ANALYTICS----------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/









	/*------------------------------------------------------------------------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/
	/*-------------------------------------------LOGIK------------------------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/


	//Hier befindet sich die Logik, und die Kommunikation mit der Datenbank.


	/*------------------------------------------------------------------------------------------------------*/
	/*------------------------------------START VON ALLGEMEINE METHODEN-------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/
	//Hier finden Sie alle Methoden, die von mehr als einer Rolle bzw. einer Seite aufgerufen werden oder als Hilfsmethoden dienen, die in anderen Methoden aufgerufen werden


	//Die Methode abfrageDB wird für alle interaktionen mit der MySQL-Datenbank 'learn2lean' benutzt
	//Als einziger Paramter muss ein SQL-Befehl übergeben werden
	function abfrageDB($sqlBefehl){

		
		//Parameter für die Datenbankverbindung
		$pfadDB = 'localhost';
		$usernameDB = 'root';
		$passwortDB = '';
		$datenbankName = 'learn2lean';

		//Öffnet die Verbindung mit der MySQL-Datenbank
		$connection = mysqli_connect($pfadDB, $usernameDB, $passwortDB, $datenbankName);

		//Schickt den übergebenen SQL-Befehl an die Datenbank und speichert die Antwort in der Variable $query
		$query = mysqli_query($connection, $sqlBefehl);

		//Schließt die geöffnete Verbindung zur Datenbank
		mysqli_close($connection);

		//Gibt das Ergebnis aus der Datenbank zurück
		return $query;
	}

	
	//Die Methode holeSpielID() gibt die aktuelle SpielID zurück
	function holeSpielID() {

		//Wir holen
		$query = abfrageDB("SELECT MAX(SpielID) from spiel");
		$resultaktuelleSpielID = mysqli_fetch_array($query);
		if(isset($resultaktuelleSpielID)){
			//Gibt die aktuelle SpielID zurück
			return $resultaktuelleSpielID[0];
		}
		else {
			//Wenn es keine SpielID gibt, gibt er 1 zurücl
			return 1;
		}

	}

	//Diese Methode holt den Spielstatus, d.h. es prüft ob das Spiel  läuft, pausiert oder beendet ist
	function holeSpielStatus($spielID) {

		$querySpielStatus = abfrageDB("SELECT Status FROM spiel WHERE SpielID = '" . $spielID . "'");
		$resultSpielStatus = mysqli_fetch_array($querySpielStatus);

		//Gibt das Ergebnis aus der Datenbank zurück
		return $resultSpielStatus[0];

	}

	//Diese Methode gibt die EndProduktID aus einer Bestellung aus. Damit man weiß, welches Endprodukt sich hinter einer Bestellung verbirgt.
	function holeEndProduktID($bestellungsID) {

		$queryEndProduktID = abfrageDB("SELECT EndProduktID FROM bestellungen WHERE BestellungsID = '" . $bestellungsID . "'");

		$resultEndProduktID = mysqli_fetch_array($queryEndProduktID);

		return $resultEndProduktID[0];

	}

	//Diese Methode liest die TeilProdukte einer Bestellung aus unter Berücksichtigung der Station, die mit dem Parameter $stationsNummer übergeben werden. 
	function holeTeilProduktID($bestellungsID, $stationsNummer) {

		$endproduktID = holeEndProduktID($bestellungsID);

		$queryTeilProduktID = abfrageDB("SELECT TeilProduktID FROM endprodukt_teilprodukt WHERE EndProduktID = '" . $endproduktID . "' AND StationsID = '" . $stationsNummer . "' AND TeilProduktID != '2'"); //TeilProduktID 2 ausschließen, sonst wird ein Fehler bei der Anleitungsdarstellung in Station 1 produziert. Liegt daran, dass an Station 1 zwei Teilprodukte gebaut werden

		$resultTeilProduktID = mysqli_fetch_array($queryTeilProduktID);

		return $resultTeilProduktID[0];

	}

	//Diese Methode liest die TeilProduktBezeichnung einer Bestellung aus unter der Berücksichtigung der Station, die mit dem Parameter $stationsnummer übergeben werden.
	function holeTeilProduktBezeichnung($bestellungsID, $stationsNummer) {

		$teilproduktid = holeTeilProduktID($bestellungsID, $stationsNummer);

		$queryTeilProduktBezeichnung = abfrageDB("SELECT TeilProduktBezeichnung FROM teilprodukt WHERE TeilProduktID = '" . $teilproduktid . "'");

		$resultTeilProduktBezeichnung = mysqli_fetch_array($queryTeilProduktBezeichnung);

		return $resultTeilProduktBezeichnung[0];

	}

	//Diese Methode liest die Bezeichnung des Steines aus der Datenbank aus, dessen SteinID mit dem Parameter $steinID übergeben wird.
	function holeSteinBezeichnung($steinID) {

		$querySteinBezeichnung = abfrageDB("SELECT SteinBezeichnung FROM steine WHERE SteinID = '" . $steinID . "'");

		$resultSteinBezeichnung = mysqli_fetch_array($querySteinBezeichnung);

		return $resultSteinBezeichnung[0];
	}

	//Diese Methode liest das Steinbild des Steines aus der Datenbank aus, dessen SteinID mit dem Parameter $steinID übergeben wird.
	function holeSteinBild($steinID) {

		$querySteinBezeichnung = abfrageDB("SELECT SteinImage FROM steine WHERE SteinID = '" . $steinID . "'");

		$resultSteinBezeichnung = mysqli_fetch_array($querySteinBezeichnung);

		return $resultSteinBezeichnung[0];
	}

	//Diese Methode holt die höchste Produktionsreihenfolgenummer des aktuellen Spiels (Spiel mit der höchsten SpielID)
	function holeHoechsteProduktionsReihenfolgeNr() {

		$queryProduktionsReihenfolge = abfrageDB("SELECT MAX(b.ProduktionsReihenfolge) FROM bestellungen b WHERE SpielID = '" . holeSpielID() . "'");

		$resultProduktionsReihenfolge = mysqli_fetch_array($queryProduktionsReihenfolge);

		return $resultProduktionsReihenfolge[0];

	}

	//Diese Methode holt die gerinste BestellungsID des aktuellen Spiels (Spiel mit der höchsten SpielID)
	function holeGeringsteBestellungsID($stationsnummer) {

		$statusStation = statusStation($stationsnummer);

		$queryAktuelleBestellungsID = abfrageDB("SELECT MIN(BestellungsID) FROM bestellungen WHERE " . $statusStation . " = '0' AND SpielID = '" . holeSpielID() . "'");

		$resultAktuelleBestellungsID = mysqli_fetch_array($queryAktuelleBestellungsID);

		return $resultAktuelleBestellungsID[0];

	}

	//Diese Methode holt die AutoBestellGrenzen aus der Datenbank für einen bestimmten Stein an einer bestimmten Station. Als Parameter werden dafür die $steinID und die $stationsID übergegeben. 
	function holeAutoBestellungGrenze($steinID, $stationsID){

		$query =abfrageDB("SELECT  `AutobestellungGrenze`FROM `logistik` WHERE SteinID = '" . $steinID . "' AND StationsID = '" . $stationsID . "' ");
		$result = mysqli_fetch_array($query);
		return $result[0];
	}

	//Diese Methode holt die empfohlenen Liefermengen für einen bestimmten Stein an einer bestimmten Station aus der Datenbank. Als Parameter werden dafür die $steinID und die $stationsID übergeben.
	function holeEmpfohleneLieferMenge($steinID, $stationsID) {

		$query = abfrageDB("SELECT `EmpfohleneLieferMenge` FROM `logistik` WHERE SteinID = '" . $steinID . "' AND StationsID = '" . $stationsID . "' ");
		$result = mysqli_fetch_array($query);
		return $result[0];
	}

	//Diese Methode liest aus der Logistik Tabelle der Datenbank die Anzahl SteinTypen pro Arbeitsstation aus. Als Parameter wird dafür die $stationsID übergeben.
	function holeAnzahlSteinTypenLogistik($stationsID) {

		$queryAnzahl = abfrageDB("SELECT COUNT(SteinID) FROM logistik WHERE StationsID = '" . $stationsID . "'");

		$resultAnzahl = mysqli_fetch_array($queryAnzahl);

		return $resultAnzahl[0];

	}

	//Diese Methode überprüft den Status der Werkzeugaufnahme, d.h. ob die "weiße" Werkzeugaufnahme mit der TeilProduktID 1 freigeschaltet ist ob die "schwarze" Werkzeugaufnahme mit der TeilProduktID 9 freigeschaltet ist
	function holeWerkzeugaufnahmeStatus() {

		$queryWA_weiss = abfrageDB("SELECT Status FROM teilprodukt WHERE TeilProduktID = '1'");
		$queryWA_schwarz = abfrageDB("SELECT Status FROM teilprodukt WHERE TeilProduktID = '9'");

		$resultWA_weiss = mysqli_fetch_array($queryWA_weiss);
		$resultWA_schwarz = mysqli_fetch_array($queryWA_schwarz);

		//Überprüfe, ob die Ergebnisse des Status unterschiedlich sind. Es können nicht beide Werkzeugaufnahmen gleichzeitig aktiviert sein
		if($resultWA_weiss[0] != $resultWA_schwarz) {

			//Wenn die Werkzeugaufnahme mit dem weißen Stein aktiviert ist
			if($resultWA_weiss[0] == 1) {
				return 1; //Gibt zurück, dass alle Produkte mit weißer Werkzeugaufnahme nur zu bestellen sind (TeilProduktID = 1)
			}
			//Wenn die Werkzeugaufnahme mit dem schwarzen Stein aktiviert ist
			else if($resultWA_schwarz[0] == 1) {
				return 9; //Gibt zurück, dass alle Produkte mit schwarzer Werkzeugaufnahme nur zu bestellen sind (TeilProduktID = 9)
			}

		}

	}

	//Diese Methode liest aus der Datenbank das aktuelle Taktzeitintervall aus, welches vom Spielleiter festgelegt wurde bzw. geändert werden kann
	function holeAktuelleTaktzeit() {

		$queryTaktzeit = abfrageDB("SELECT Takt FROM spiel WHERE SpielID = '" . holeSpielID() . "'");

		$resultTaktzeit = mysqli_fetch_array($queryTaktzeit);

		return $resultTaktzeit[0];

	}

	//Diese Methode übersetzt die als Parameter übergebene $stationsNummer in den in der Datenbank hinterlegten Spaltennamen für die Stationen.
	function statusStation($stationsNummer) {

		if($stationsNummer == 0) {
			$statusStation = 'Produktionsleiter';
		}
		if($stationsNummer == 1) {
			$statusStation = 'StatusStation1';
		}
		if($stationsNummer == 2) {
			$statusStation = 'StatusStation2';
		}
		if($stationsNummer == 3) {
			$statusStation = 'StatusStation3';
		}
		if($stationsNummer == 4) {
			$statusStation = 'StatusStation4';
		}
		if($stationsNummer == 5) {
			$statusStation = 'StatusStation5';
		}
		if($stationsNummer == 6) {
			$statusStation = 'StatusQuality';
		}

		return $statusStation;

	}

	//Diese Methode übesetzt die als Parameter übergebene $stationsNummer in den in der Datenbank hinterlegten Spaltennamen für die Timestamps.
	function statustime($stationsNummer) {

		if($stationsNummer == 0) {
			$statustime = 'Produktionsleiter_timestamp';
		}
		if($stationsNummer == 1) {
			$statustime = 'Station1_timestamp';
		}
		if($stationsNummer == 2) {
			$statustime = 'Station2_timestamp';
		}
		if($stationsNummer == 3) {
			$statustime = 'Station3_timestamp';
		}
		if($stationsNummer == 4) {
			$statustime = 'Station4_timestamp';
		}
		if($stationsNummer == 5) {
			$statustime = 'Station5_timestamp';
		}
		if($stationsNummer == 6) {
			$statustime = 'Qualitaet_timestamp';
		}

		return $statustime;

	}

	//Diese Methode übesetzt die als Parameter übergebene $stationsNummer in den in der Datenbank hinterlegten Spaltennamen für die AnzahlHilfsanforderungen.
	function anzahlHilfeSpalte($stationsNummer) {

		
		if($stationsNummer == 1) {
			$anzahlHilfe  = 'AnzahlHilfeStation1';
		}
		if($stationsNummer == 2) {
			$anzahlHilfe  = 'AnzahlHilfeStation2';
		}
		if($stationsNummer == 3) {
			$anzahlHilfe  = 'AnzahlHilfeStation3';
		}
		if($stationsNummer == 4) {
			$anzahlHilfe  = 'AnzahlHilfeStation4';
		}
		if($stationsNummer == 5) {
			$anzahlHilfe  = 'AnzahlHilfeStation5';
		}
		if($stationsNummer == 6) {
			$anzahlHilfe  = 'AnzahlHilfeQuality';
		}
		if($stationsNummer == 7) {
			$anzahlHilfe = 'AnzahlHilfeLogistik';
		}
		if($stationsNummer == 8) {
			$anzahlHilfe = 'AnzahlHilfeMeister';
		}

		return $anzahlHilfe ;

	}

	/*--------------------Sektion LOGISTIK, ARBEITSSTATIONEN 1-5 START--------------------*/

	//Diese Methode erstellt eine neue Anlieferung bei der als Parameter die $steinID, $stationsNummer sowie die $anzahlSteine übergeben werden.
	function erstelleNeueAnlieferung($SteinID, $stationsNummer, $anzahlSteine){

		//Automatische Bestellungen
		if(holeSpielModusBestellungen() == 2){

		$sqlAnlieferungVorhandenCheck = abfrageDB("SELECT SteinID from anlieferungen WHERE  SteinID = '" .$SteinID."' AND SpielID = '" . holeSpielID() ."'  AND (StatusAnlieferung = '1' OR StatusAnlieferung = '0') " );
		$resultAnlieferungCheck = mysqli_fetch_array($sqlAnlieferungVorhandenCheck);

			//Überprüfung Bestellung ist vorhanden
			if(isset($resultAnlieferungCheck)){

				//echo "Diese Nachricht wird angezeigt, wenn es die Anlieferung bereits gibt";
			}
			else {
				//Neue Bestellung erstellen
				abfrageDB("INSERT INTO `anlieferungen`( `SteinID`, `StationsID`, `AnzahlSteine`, `StatusAnlieferung`, `BoxID`, `SpielID`) VALUES ('" .$SteinID."' , '" .$stationsNummer."', '" .$anzahlSteine."', 0, 0, '" . holeSpielID() ."'  )");

			}

		}
		//Manuelle Bestellungen
		else if(holeSpielModusBestellungen() == 1) {

			//Neue Bestellung erstellen
			abfrageDB("INSERT INTO `anlieferungen`( `SteinID`, `StationsID`, `AnzahlSteine`, `StatusAnlieferung`, `BoxID`, `SpielID`) VALUES ('" .$SteinID."' , '" .$stationsNummer."', '" .$anzahlSteine."', 0, 0, '" . holeSpielID() ."'  )");

		}

	}

	/*-------------------Sektion LOGISTIK, ARBEITSSTATIONEN 1-5----------------------*/

	/*------------------------ Sektion HILFE START---------*/

	//Diese Methode wird aufgerufen, wenn der Hilfebutton an einer Station gedrückt wird. Den Hilfebutton kann man von den Arbeitsstationen 1 bis 5, in der Qualitätskontrolle, in der Logisitk und auf der Meisterseite drücken. Jede Station hat eine feste Nummer. Mithilfe des Parameters $stationsNummer, wird der StatusHilfe für die jeweilige Station auf 1 gesetzt (=> Hilfsanforderung).
	function anforderungHilfe($stationsNummer){

		$spaltenName = anzahlHilfeSpalte($stationsNummer);

		//Hole aktuelle AnzahlHilfsanforderungen aus der Datenbank
		$queryAnzahlHilfe = abfrageDB("SELECT " . $spaltenName . " FROM spiel WHERE SpielID = '" . holeSpielID() . "'");
		$resultAnzahlHilfe = mysqli_fetch_array($queryAnzahlHilfe);

		//Anzahl um 1 erhöhen
		$anzahl = $resultAnzahlHilfe[0] + 1;

		abfrageDB("UPDATE spiel SET " . $spaltenName . " = '" . $anzahl . "' WHERE SpielID = '" . holeSpielID() . "'");
		abfrageDB("UPDATE stationen SET StatusHilfe = '1' WHERE StationsID = '" . $stationsNummer . "'");
	
	}

	//Diese Methode lädt alle Hilfsanforderungen die entweder für die Meister- oder die Produktionsleiterseite bestehen aus und stellt sie im Interface da. Der Parameter $position übergibt, ob die Hilfsanforderungen für die Meister- oder Produktionsleiterseite angefordert werden sollen.
	function holeHilfsanforderungen($position) {

		//Hilfsanforderungen an den Meister betreffen die Arbeitsplätze 1 bis 5
		if($position == 'Meister') {

			$queryStation = abfrageDB("SELECT StationsID, StationsBezeichnung FROM stationen WHERE StatusHilfe = '1' AND (StationsID = '1' OR StationsID = '2' OR StationsID = '3' OR StationsID = '4' OR StationsID = '5')");

			while($resultStation = mysqli_fetch_array($queryStation)) {

				//HTML-Code mit dynamischen Datenbankergebnissen dazwischen
				echo "<div class='container-hilfsanforderung'>
					<div class='container-hilfsanforderung-station'>" . $resultStation[1] . "</div>
					<div class='container-hilfsanforderung-img'><img class='container-hilfsanforderung-img' src='Icons/help_outline.png'></div>
					<div class='container-hilfsanforderung-annehmen'><button type='button' name='annehmenHilfe' class='button-hilfe-annehmen' onclick='abgeschlossenHilfe(" . $resultStation[0] . ")'>Annehmen</button></div>
				</div>";

			}

		}
		//Hilfsanforderungen an den Produktionsleiter betreffen die Qualitätskontrolle und die Logistik
		else if($position = 'Produktionsleiter') {

			$queryStation = abfrageDB("SELECT StationsID, StationsBezeichnung FROM stationen WHERE StatusHilfe = '1' AND (StationsID = '6' OR StationsID = '7' OR StationsID = '8')");

			while($resultStation = mysqli_fetch_array($queryStation)) {

				echo "<div class='container-hilfsanforderung'>
					<div class='container-hilfsanforderung-station'>" . $resultStation[1] . "</div>
					<div class='container-hilfsanforderung-img'><img class='container-hilfsanforderung-img' src='Icons/help_outline.png'></div>
					<div class='container-hilfsanforderung-annehmen'><button type='button' name='annehmenHilfe' class='button-hilfe-annehmen' onclick='abgeschlossenHilfe(" . $resultStation[0] . ")'>Annehmen</button></div>
				</div>";

			}

		}

	}


	//Diese Methode wird ausgeführt, wenn der Produktionsleiter oder Meister die Hilfe an einer Station abgeschlossen hat. Jede Station hat eine feste Nummer. Mithilfe des Parameters $stationsNummer, wird der StatusHilfe für die jeweilige Station wieder auf 0 gesetzt (=> Keine Hilfe).
	function abgeschlossenHilfe($stationsNummer) {

		abfrageDB("UPDATE stationen SET StatusHilfe = '0' WHERE StationsID = '" . $stationsNummer . "'");

	}


	/*---------------Sektion HILFE ENDE---------------*/


	/*---------------Sektion KUNDE, PRODUKTIONSLEITER START------------------*/

	//Diese Methode zeigt für alle Bestellungen den Status an. Als Parameter wird die $bestellungsID übergeben, für die der Status angezeigt werden soll
	function zeigeProduktionsStatus($bestellungsID) {

		$queryProduktionsStatus = abfrageDB("SELECT StatusProduktionsleiter, StatusStation1, StatusStation2, StatusStation3, StatusStation4, StatusStation5, StatusQuality, StatusKunde FROM bestellungen WHERE BestellungsID = '" . $bestellungsID . "'");

		$resultProduktionsStatus = mysqli_fetch_array($queryProduktionsStatus);

		//Variablen
		$statusProduktionsleiter = $resultProduktionsStatus['StatusProduktionsleiter'];
		$statusStation1 = $resultProduktionsStatus['StatusStation1'];
		$statusStation2 = $resultProduktionsStatus['StatusStation2'];
		$statusStation3 = $resultProduktionsStatus['StatusStation3'];
		$statusStation4 = $resultProduktionsStatus['StatusStation4'];
		$statusStation5 = $resultProduktionsStatus['StatusStation5'];
		$statusQuality = $resultProduktionsStatus['StatusQuality'];
		$statusKunde = $resultProduktionsStatus['StatusKunde'];

		//Bestellt => Sobald der Kunde bestellt hat, der Produktionsleiter es aber noch nicht zur Produktion freigegeben hat
		//Änderung auf 2
		if($statusProduktionsleiter == 0 OR $statusProduktionsleiter == 2 ) {
			return "<button class='btnBestellungStornieren' onclick='bestellungStornieren(" . $bestellungsID . ")'>Stornieren</button>"; //Storinieren-Button
		}

		//In Produktion => Sobald der Produktionsleiter es zu den Arbeitsstationen zur Produktion freigegeben hat
		else if(($statusProduktionsleiter == 1 OR $statusProduktionsleiter == 3) AND  $statusStation5 == 0) {
			return "<span class='status-orange'>In Produktion</span";
		}
		//In Qualitätskontrolle => In der Qualitätskontrolle
		else if($statusStation5 == 1 AND $statusQuality == 0) {
			return "<span class='status-orange'>Qualitätskontrolle</span";
		}

		//Ausgeliefert => Kunde muss erst prüfen ob er die Bestellung annimmt oder nicht
		else if($statusQuality == 1 AND $statusKunde == 0) {
			return "<span class='status-green'>Ausgeliefert</span";
		}

		//Zugestellt => der Kunde hat angenommen
		else if($statusKunde == 1 AND $statusKunde != 3) {
			return "<span class='status-green'>Zugestellt</span";
		}

		//In Retoure => der Kunde hat vorerst abgelehnt
		else if($statusQuality == 2 OR $statusKunde == 2) {
			return "<span class='status-red'>In Retoure</span";
		} 
		//Storniert => der Kunde hat das Produkt storiniert, noch bevor es in Produktion ging
		/*if($statusKunde == 3) {
			return "<span class='status-red'>Storniert</span";
		}*/

	}

	/*---------------Sektion KUNDE; PRODUKTIONSLEITER ENDE-------------------*/

	
	/*---------------Sektion ??? START-------------------*/

	//Diese Methode liest den Status des Endproduktes aus, dessen EndProduktID mit dem Parameter $endProduktID übergeben wird.
	function pruefeEndProduktFreischaltungen($endProduktID) {

		$queryStatus = abfrageDB("SELECT Status FROM endprodukt WHERE EndProduktID = '" . $endProduktID . "'");

		$resultStatus = mysqli_fetch_array($queryStatus);

		return $resultStatus[0];

	}
	
	//??? Klären, was diese Methode macht
	function holeZurProduktionFreigegebeneProdukte($stationsNummer) {

		$statusStation = statusStation($stationsNummer);

		$queryProduktionsReihenfolge= abfrageDB("SELECT b.BestellungsID FROM bestellungen b WHERE (b.StatusProduktionsleiter = 1 OR b.StatusProduktionsleiter = 3) AND " . $statusStation . " = 0 AND b.SpielID = '" . holeSpielID() . "' ORDER BY b.ProduktionsReihenfolge ASC");

		$arrayResult = [];

		$resultProduktionsReihenfolge = mysqli_fetch_array($queryProduktionsReihenfolge);

		//Stationen mit Teilprodukten
		if($stationsNummer == 1 OR $stationsNummer == 2 OR $stationsNummer == 3 OR $stationsNummer == 4) {

			$teilProduktID = holeTeilProduktID($resultProduktionsReihenfolge[0], $stationsNummer);

			$arrayResult = ['BestellungsID' => $resultProduktionsReihenfolge[0] ,'TeilProduktID' => $teilProduktID];

		}
		//Station mit Endprodukten
		if ($stationsNummer == 5 OR $stationsNummer == 6) {

			$endProduktID = holeEndProduktID($resultProduktionsReihenfolge[0]);

			$arrayResult = ['BestellungsID' => $resultProduktionsReihenfolge[0] ,'EndProduktID' => $endProduktID];

		}

		echo json_encode($arrayResult);

	}

	//Diese Methode zeigt den Takt an. Anhand der mit dem Parameter übergebenen $bestellungsID kann mit unterschiedlichen Farben gearbeitet werden, je nachdem ob man im soll ist oder ob man hinter her hängt.
	function holeSychroneTaktzeit($bestellungsID) {

		$queryTakt = abfrageDB("SELECT Takt, BestellStartzeit FROM bestellungen WHERE BestellungsID = '" . $bestellungsID . "'");
		
		$resultTakt = mysqli_fetch_array($queryTakt);

		$startZeit = date($resultTakt[1]);
		$taktZeit = $resultTakt[0];

		//Liest die aktuelle Zeit aus
		$aktuelleZeit = date('Y-m-d H:i:s');

		//$differenzZeit = strtotime($aktuelleZeit) - strtotime($startZeit);
		$differenzZeit = (strtotime($startZeit) + $taktZeit) - strtotime($aktuelleZeit);

		if($differenzZeit < 0) {

			echo "<div class='status-red-big'>" . $differenzZeit . "</div>";

		} else {

			echo "<div class='status-green-big'>" . $differenzZeit . "</div>";

		}

	}

	//Diese Methode lädt auf der Produktions- und Meisterseite im PopUp Anleitungen, die angklickbare Liste an Endprodukte 
	function zeigeCADAnleitungen() {

		$queryCADAnleitungen = abfrageDB("SELECT EndProduktID, EndProduktBezeichnung, EndProduktImage FROM endprodukt");

		$arrayResult = [];

		while($resultCADAnleitungen = mysqli_fetch_array($queryCADAnleitungen)) {

			array_push($arrayResult, ["EndProduktID" => $resultCADAnleitungen[0], "EndProduktBezeichnung" => $resultCADAnleitungen[1], "EndProduktImage" => $resultCADAnleitungen[2]]);

		}

		echo json_encode($arrayResult);

	}



	/*------------------------------------------------------------------------------------------------------*/
	/*-------------------------------------ENDE VON ALLGEMEINE METHODEN-------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/

	/*------------------------------------------------------------------------------------------------------*/
	/*----------------------------------------START VON SPIELLEITER-----------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/
	//Hier finden Sie alle Methoden, die nur vom Spielleiter bzw. nur von der Spielleiterseite aufgerufen werden

	//Mit dieser Methode kann ein neues Spiel erstellt werden
	function erstelleNeuesSpiel($bezeichnung, $statusMaterialstandUebernahme){

		//Neues Spiel erstellen
		abfrageDB("INSERT INTO spiel (SpielID, Bezeichnung, Status, SpielModusBestellungen, SpielStartzeit, Takt, AnzahlHilfeStation1, AnzahlHilfeStation2, AnzahlHilfeStation3, AnzahlHilfeStation4, AnzahlHilfeStation5, AnzahlHilfeQuality, AnzahlHilfeLogistik, AnzahlHilfeMeister, AnalyticsSpielID1, AnalyticsSpielID2, AnalyticsSpielID3, MaterialstandUebernahme) VALUES (NULL, '" . $bezeichnung . "', 1, 2, '" . date('Y-m-d H:i:s') . "', " . holeAktuelleTaktzeit() . ", 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '" . $statusMaterialstandUebernahme . "')");

		//Stationstabelle und deren StatusHilfe zurücksetzen 
		abfrageDB("UPDATE stationen SET StatusHilfe = 0");

	}

	//Mit dieser Methode wird ein Spiel/Produktionspriode pausiert.
	function pausiereSpiel($spielID) {

		//holt den aktuellen SpielStatus
		$spielStatus = holeSpielStatus($spielID);

		//Spiel pausieren
		if($spielStatus == 1) {
			//Setze Status auf 2 in der Datenbank
			abfrageDB("UPDATE spiel SET Status = '2' WHERE SpielID = '" . $spielID . "'");
			//Damit JS den richtigen Button laden kann
			echo "2";
		}
		//Spiel forsetzten
		else if($spielStatus == 2) {
			//Setze Status auf 1 in der Datenbank
			abfrageDB("UPDATE spiel SET Status = '1' WHERE SpielID = '" . $spielID . "'");
			//Damit JS den richtigen Button laden kann
			echo "1";
		}

	}

	//Mit dieser Methode kann ein Spiel beendet werden
	function beendeSpiel($spielID) {

		abfrageDB("UPDATE spiel SET Status = '3', SpielEndzeit = '" . date('Y-m-d H:i:s') . "' WHERE SpielID = '" . $spielID . "'");

	}

	//Diese Methode gibt zurück ob vom Spielleiter der Bestellungsmodus 'automatische Bestellungen' oder 'manuelle Bestellungen' aktiviert ist.
	function holeSpielModusBestellungen() {

		//Hole aktuelle SpielID
		$spielID = holeSpielID();

		$querySpielModus = abfrageDB("SELECT MAX(SpielID), SpielModusBestellungen FROM spiel WHERE SpielID = '" . $spielID . "'");
		$resultSpielModus = mysqli_fetch_array($querySpielModus);

		return $resultSpielModus[1];

	}

	//Mit dieser Methode kann der Bestellmodus geändert werden.
	function bearbeiteSpielModusBestellungen($aktuellerSpielModus) {

		abfrageDB("UPDATE spiel SET SpielModusBestellungen = '" . $aktuellerSpielModus . "' WHERE SpielID = '" . holeSpielID() . "'");

	}

	//Diese Methode aktiviert oder deaktivert das Produkt, dessen EndProduktID im Parameter $endProduktID übergeben wird.
	function freischaltenProdukt($endProduktID) {

		$aktuellerStatus = pruefeEndProduktFreischaltungen($endProduktID);

		if($aktuellerStatus == 0) {
			abfrageDB("UPDATE endprodukt SET Status = '1' WHERE EndProduktID = '" . $endProduktID . "'");
			
		}
		else if($aktuellerStatus == 1) {
			abfrageDB("UPDATE endprodukt SET Status = '0' WHERE EndProduktID = '" . $endProduktID . "'");
			
		}

	}

	//Diese Methode ändert den Werkzeugaufnahmestatus. Mit dem Parameter $status wird die TeilProduktID der Werkzeugaufnahme übergeben, welche aktiviert werden soll. Sprich 1 für "weiße" Werkzeugaufnahme und 9 für "schwarze" Werkzeugaufnahme
	function setzeWerkzeugaufnahmeStatus($status) {

		//Aktiviert das Teilprodukt 1 Werkzeugaufnahme_Weiss
		if($status == 1) {

			abfrageDB("UPDATE teilprodukt SET Status = '0' WHERE TeilProduktID = '9'"); //Deaktiviert die schwarze Werkzeugaufnahme
			abfrageDB("UPDATE teilprodukt SET Status = '1' WHERE TeilProduktID = '1'"); //Aktiviert die weiße Werkzeugaufnahme

		}
		//Aktiviert das Teilprodukt 9 Werkzeugaufnahme_Schwarz
		else if($status == 9) {

			abfrageDB("UPDATE teilprodukt SET Status = '0' WHERE TeilProduktID = '1'"); //Deaktiviert die weiße Werkzeugaufnahme
			abfrageDB("UPDATE teilprodukt SET Status = '1' WHERE TeilProduktID = '9'"); //Aktiviert die schwarze Werkzeugaufnahme

		}

	}

	//Diese Methode setzt alle vom User getätigten Einstellungen zurück und löscht alle Spielstände. Wie der Name schon sagt, wird die Software auf die Werkseinstellungen zurückgesetzt.
	function setzteAufWerkseinstellungen() {
		
		abfrageDB("UPDATE `stationen` SET `StatusHilfe`= 0,`AkkustandMaterialstation`=100");
		//abfrageDB("UPDATE logistik SET AutobestellungGrenze = 35, EmpfohleneLieferMenge = 50, MaximaleGrenzen = 60 WHERE 1");

		//Leeren der Tabellen Bestellungen und Anlieferungen
		abfrageDB("TRUNCATE TABLE `bestellungen`");
		abfrageDB("TRUNCATE TABLE `anlieferungen`");

		//Löschen der Fremdschlüssel auf SpielID
		abfrageDB("ALTER TABLE `bestellungen` DROP FOREIGN KEY `Bestellungen_ibfk_2` "); 
		abfrageDB("ALTER TABLE `anlieferungen` DROP FOREIGN KEY `anlieferungen_ibfk_3` ");

		//Leeren der Spiel-Tabelle
		abfrageDB("TRUNCATE TABLE `spiel` ");
		

		//Wiederherstellen der Fremdschlüssel auf SpielID und erstellen eines toten Spiels
		abfragedb("ALTER TABLE `bestellungen` ADD CONSTRAINT `Bestellungen_ibfk_2` FOREIGN KEY (`SpielID`) REFERENCES `spiel`(`SpielID`) " );
		abfragedb("ALTER TABLE `anlieferungen` ADD CONSTRAINT `anlieferungen_ibfk_3` FOREIGN KEY (`SpielID`) REFERENCES `spiel`(`SpielID`) ");
		//abfrageDB("INSERT INTO `spiel`(`SpielID`, `Bezeichnung`, `Status`, `SpielModusBestellungen`) VALUES (NULL,Reset,3,1)");

		//Erstelle neues Psydospiel, damit die PopUps "Keine Produktionsperiode vorhanden" geladen werden oder die Methode holeAktuelleTaktzeit einen Takt findet. Und noch viele weitere Methoden sind davon abhängig, dass mindestens ein Spiel in der Spiel-Tabelle exisitert.
		abfrageDB("INSERT INTO spiel (SpielID, Bezeichnung, Status, SpielModusBestellungen, SpielStartzeit, Takt, AnzahlHilfeStation1, AnzahlHilfeStation2, AnzahlHilfeStation3, AnzahlHilfeStation4, AnzahlHilfeStation5, AnzahlHilfeQuality, AnzahlHilfeLogistik, AnzahlHilfeMeister, AnalyticsSpielID1, AnalyticsSpielID2, AnalyticsSpielID3, MaterialstandUebernahme) VALUES (1 , 'Psydo Resetspiel', 3, 2, '" . date('Y-m-d H:i:s') . "', 30, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)");

	}

	//Diese Methode liest den aktuellen Akkustand aus der Datenbank aus
	function holeAkkuStand(){

		$query = abfrageDB("SELECT  `AkkustandMaterialstation` FROM `stationen` WHERE StationsID = '1' OR StationsID = '2' OR StationsID = '3' OR StationsID = '4'");

		$arrayResult = [];

		while($result = mysqli_fetch_array($query)) {
			
			if($result[0] > 40) {
			 	$ausgabe = "<td class='table-cell status-green'>" . $result[0] ."%</td>";
			}
			else if($result[0] > 20) {
			 	$ausgabe = "<td class='table-cell status-orange'>" . $result[0] ."%</td>";
			}
			else if($result[0] < 21) {
			 	$ausgabe = "<td class='table-cell status-red'>" . $result[0] ."%</td>";
			}

			array_push($arrayResult, $ausgabe);
		}

		echo json_encode($arrayResult);

	}

	//Diese Methode aktiviert einen Ausgangsbestand 
	function aktiviereAusgangsbestand()
	{
		//Station 1
		//SteinID 1 * 4
		abfrageDB("INSERT INTO `anlieferungen`( `SteinID`, `StationsID`, `AnzahlSteine`, `StatusAnlieferung`, `BoxID`, `SpielID`) VALUES (1, 1, 8, 1, 0, '" . holeSpielID() ."'  )");
		//SteinID 2 * 4
		abfrageDB("INSERT INTO `anlieferungen`( `SteinID`, `StationsID`, `AnzahlSteine`, `StatusAnlieferung`, `BoxID`, `SpielID`) VALUES ( 2, 1, 8, 1, 0, '" . holeSpielID() ."'  )");
		//SteinID 3 * 4
		abfrageDB("INSERT INTO `anlieferungen`( `SteinID`, `StationsID`, `AnzahlSteine`, `StatusAnlieferung`, `BoxID`, `SpielID`) VALUES ( 3, 1, 16, 1, 0, '" . holeSpielID() ."'  )");
		//SteinID 4 * 4
		abfrageDB("INSERT INTO `anlieferungen`( `SteinID`, `StationsID`, `AnzahlSteine`, `StatusAnlieferung`, `BoxID`, `SpielID`) VALUES (4, 1, 4, 1, 0, '" . holeSpielID() ."'  )");

		//Station 2
		//SteinID 4 * 4
		abfrageDB("INSERT INTO `anlieferungen`( `SteinID`, `StationsID`, `AnzahlSteine`, `StatusAnlieferung`, `BoxID`, `SpielID`) VALUES (4, 2, 16, 1, 0, '" . holeSpielID() ."'  )");
		//SteinID 6 * 4
		abfrageDB("INSERT INTO `anlieferungen`( `SteinID`, `StationsID`, `AnzahlSteine`, `StatusAnlieferung`, `BoxID`, `SpielID`) VALUES (6, 2, 16, 1, 0, '" . holeSpielID() ."'  )");

		//Station 3
		//SteinID 7 * 4
		abfrageDB("INSERT INTO `anlieferungen`( `SteinID`, `StationsID`, `AnzahlSteine`, `StatusAnlieferung`, `BoxID`, `SpielID`) VALUES (7, 3, 8, 1, 0, '" . holeSpielID() ."'  )");
		//SteinID 5 * 4
		abfrageDB("INSERT INTO `anlieferungen`( `SteinID`, `StationsID`, `AnzahlSteine`, `StatusAnlieferung`, `BoxID`, `SpielID`) VALUES (5, 3, 8, 1, 0, '" . holeSpielID() ."'  )");
		//SteinID 10 * 4
		abfrageDB("INSERT INTO `anlieferungen`( `SteinID`, `StationsID`, `AnzahlSteine`, `StatusAnlieferung`, `BoxID`, `SpielID`) VALUES (10, 3, 8, 1, 0, '" . holeSpielID() ."'  )");
		//SteinID 6 * 4
		abfrageDB("INSERT INTO `anlieferungen`( `SteinID`, `StationsID`, `AnzahlSteine`, `StatusAnlieferung`, `BoxID`, `SpielID`) VALUES (6, 3, 16, 1, 0, '" . holeSpielID() ."'  )");
		//SteinID 9 * 4
		abfrageDB("INSERT INTO `anlieferungen`( `SteinID`, `StationsID`, `AnzahlSteine`, `StatusAnlieferung`, `BoxID`, `SpielID`) VALUES (9, 3, 16, 1, 0, '" . holeSpielID() ."'  )");

		//Station 4
		//SteinID 8 * 4
		abfrageDB("INSERT INTO `anlieferungen`( `SteinID`, `StationsID`, `AnzahlSteine`, `StatusAnlieferung`, `BoxID`, `SpielID`) VALUES (8, 4, 24, 1, 0, '" . holeSpielID() ."'  )");
		//SteinID 10 * 4
		abfrageDB("INSERT INTO `anlieferungen`( `SteinID`, `StationsID`, `AnzahlSteine`, `StatusAnlieferung`, `BoxID`, `SpielID`) VALUES (10, 4, 24, 1, 0, '" . holeSpielID() ."'  )");
	}

	/*------------------------------------------------------------------------------------------------------*/
	/*----------------------------------------ENDE VON SPIELLEITER-----------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/

	/*------------------------------------------------------------------------------------------------------*/
	/*------------------------------------------START VON KUNDE---------------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/
	//Hier finden Sie alle Methoden, die nur vom Kunden bzw. nur von der Kundenseite aufgerufen werden

	//Diese Methode erstellt eine normale (einfache) Bestellung. Im Parameter wird die EndproduktID übergeben.
	function erstelleBestellung($endProduktID) {

		//abfrageDB("INSERT INTO bestellungen (BestellungsID, EndProduktID, BestellStartzeit, StatusProduktionsleiter, ProduktionsReihenfolge, Takt, StatusStation1, StatusStation2, StatusStation3, StatusStation4, StatusStation5, StatusQuality, AnzahlRetoureQuality, AnzahlRetoureKunde, SpielID) VALUES (NULL, '" . $endProduktID . "', '" . date('Y-m-d H:i:s') . "' , 0, 0, '" . holeAktuelleTaktzeit() . "', 0,0,0,0,0,0,0,0, '" . holeSpielID() . "')");

		abfrageDB("INSERT INTO bestellungen (BestellungsID, EndProduktID, BestellStartzeit, StatusProduktionsleiter, ProduktionsReihenfolge, Takt, StatusStation1, StatusStation2, StatusStation3, StatusStation4, StatusStation5, StatusQuality, AnzahlRetoureQuality, AnzahlRetoureKunde, Statuskunde, SpielID) VALUES (NULL, '" . $endProduktID . "', '" . date('Y-m-d H:i:s') . "' , 0, 0, '" . holeAktuelleTaktzeit() . "', 0,0,0,0,0,0,0,0,0, '" . holeSpielID() . "')");

	}

	//Diese Methode erstellt eine mehrfach (5 fache) Bestellung. Im Parameter wird die EndproduktID übergeben.
	function erstelleMehrfachBestellungen($endProduktID)
	{
		
		for($Mehrfach = 0; $Mehrfach < 5; $Mehrfach++) {

			abfrageDB("INSERT INTO bestellungen (BestellungsID, EndProduktID, BestellStartzeit, StatusProduktionsleiter, ProduktionsReihenfolge, Takt, StatusStation1, StatusStation2, StatusStation3, StatusStation4, StatusStation5, StatusQuality, AnzahlRetoureQuality, AnzahlRetoureKunde, SpielID) VALUES (NULL, '" . $endProduktID . "', '" . date('Y-m-d H:i:s') . "' , 2, 0, 0, 0,0,0,0,0,0,0,0, '" . holeSpielID() . "')");

		}

	}

	//Diese Methode holt alle vom Kunden getätigten Bestellungen des aktuellen Spiels
	function zeigeBestellungenKunde() {

		$query = abfrageDB("SELECT a.BestellungsID, b.EndProduktBezeichnung, a.BestellStartzeit, b.EndProduktImage FROM bestellungen a, endprodukt b WHERE a.EndProduktID = b.EndProduktID /*AND (a.StatusKunde = 0 OR a.StatusKunde = 2)*/ AND a.SpielID = '" . holeSpielID() . "' ORDER BY a.BestellungsID DESC");
		
		$arrayResult = [];

		while($result = mysqli_fetch_array($query)) {

			$produktionsStatus = zeigeProduktionsStatus($result[0]); //BestellungsID wird übergeben

			array_push($arrayResult, ['BestellungsID' => $result[0], 'EndProduktBezeichnung' => $result[1], 'BestellStartzeit' => $result[2], 'EndProduktImage' => $result[3], 'ProduktionsStatus' => $produktionsStatus]);

		}

		echo json_encode($arrayResult);

	}

	//Diese Methode liest die Auslieferungen für den Kunden im aktuellen Spiel aus
	function holeAuslieferungKunde() {
		
		$queryAuslieferung = abfrageDB("SELECT MIN(b.ProduktionsReihenfolge), b.BestellungsID, b.EndProduktID, e.EndProduktBezeichnung, e.EndProduktImage FROM bestellungen b INNER JOIN endprodukt e ON b.EndProduktID = e.EndproduktID WHERE b.StatusQuality = '1' AND b.StatusKunde = '0' AND b.SpielID = '" . holeSpielID() . "'");

		$resultAuslieferung = mysqli_fetch_array($queryAuslieferung);

		echo json_encode(['BestellungsID' => $resultAuslieferung[1], 'EndProduktBezeichnung' => $resultAuslieferung[3], 'EndProduktImage' => $resultAuslieferung[4]]);

	}

	//Diese Methode wird aufgerufen, wenn der Kunde mit einer Bestellung, die mit dem Parameter $bestellungsID übergeben wird, zufrieden ist und annimmt.
	function genehmigtKunde($bestellungsID) {

		abfrageDB("UPDATE bestellungen SET StatusKunde = '1', Kunde_timestamp =  '" . date('Y-m-d H:i:s') .  "', BestellEndzeit = '" . date('Y-m-d H:i:s') . "' WHERE BestellungsID = '" . $bestellungsID . "'");

	}

	//Diese Methode wird aufgerufen, wenn der Kunde mit einer Bestellung, die mit dem Parameter $bestellungsID übergeben wird, unzufrieden ist und diese reklamieren möchte.
	function abgelehntKunde($bestellungsID) {

		//Anzahl an Retouren aus der Datenbank auslesen
		$queryAnzahl = abfrageDB("SELECT AnzahlRetoureKunde FROM bestellungen WHERE BestellungsID = '" . $bestellungsID . "'");

		$resultAnzahl = mysqli_fetch_array($queryAnzahl);

		//Anzahl um 1 erhöhen
		$anzahl = $resultAnzahl[0] + 1;

		abfrageDB("UPDATE bestellungen SET StatusKunde = '2', AnzahlRetoureKunde = '" . $anzahl . "' WHERE BestellungsID = '" . $bestellungsID . "'");

	}


	/*------------------------------------------------------------------------------------------------------*/
	/*-------------------------------------------ENDE VON KUNDE---------------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/

	/*------------------------------------------------------------------------------------------------------*/
	/*--------------------------------------START VON PRODUKTIONSLEITER-------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/
	//Hier finden Sie alle Methoden, die nur vom Produktionsleiter bzw. nur von der Produktionsleiterseite aufgerufen werden


	//Diese Methode gibt eine Bestellung frei zur Produktion, sodass diese bei den Arbeitsstationen, Qualitätskontrolle etc. angezeigt wird. Mithilfe der Parameter $bestellungsID wird die Bestellung übergeben, um dessen Bestellung es sich handelt und $art übergibt, ob es sich um eine normale "einfache" Bestellung oder um eine mehrfache "5 face" Bestellung handelt.
	function freigebenZurProduktion($bestellungsID, $art) {

		$aktuelleProduktionsReihenfolgeNr = holeHoechsteProduktionsReihenfolgeNr();
		$neueProduktionsReihenfolgeNr = $aktuelleProduktionsReihenfolgeNr + 1;

		//normale "einfache" Bestellung
		if($art == 0) {

			abfrageDB("UPDATE bestellungen SET StatusProduktionsleiter = 1, Produktionsleiter_timestamp =  '" . date('Y-m-d H:i:s') .  "', ProduktionsReihenfolge = '" . $neueProduktionsReihenfolgeNr . "' WHERE BestellungsID = '" . $bestellungsID . "'");

		}
		//Mehrfachbestellung
		else if($art == 1) {

			abfrageDB("UPDATE bestellungen SET StatusProduktionsleiter = 3, Produktionsleiter_timestamp =  '" . date('Y-m-d H:i:s') .  "', ProduktionsReihenfolge = '" . $neueProduktionsReihenfolgeNr . "' WHERE BestellungsID = '" . $bestellungsID . "'");

		}

		

	}

	//Diese Methode liest alle zur Produktion freigegeben Bestellungen des aktuellen Spiels aus.
	function zeigeFreigegebeneBestellungen() {

		//Anzeige der freigegebenen Bestellungen
		$queryFreigegebeneBestellungen = abfrageDB("SELECT b.BestellungsID, b.ProduktionsReihenfolge, e.EndProduktBezeichnung, e.EndProduktImage FROM bestellungen b INNER JOIN endprodukt e ON b.EndProduktID = e.EndProduktID WHERE (b.StatusProduktionsleiter = 1 OR b.StatusProduktionsleiter = 3) /*AND b.StatusKunde = 0*/ AND b.SpielID = '" . holeSpielID() . "' ORDER BY b.ProduktionsReihenfolge DESC");

		$arrayResult = [];

		while($result = mysqli_fetch_array($queryFreigegebeneBestellungen)) {

			$produktionsStatus = zeigeProduktionsStatus($result[0]);

			array_push($arrayResult, ['BestellungsID' => $result[0],'ProduktionsReihenfolge' => $result[1] , 'EndProduktBezeichnung' => $result[2], 'EndProduktImage' => $result[3], 'ProduktionsStatus' => $produktionsStatus]);

		}

		echo json_encode($arrayResult);

	}

	//Diese Methode lädt den Inhalt, der für das Interface des maximale Grenzwerte PopUps benötigt wird. Als Parameter wird die $stationsID übergeben, da immer nur Steine und deren maximale Menge von einer Station gleichzeitig angezeigt werden.
	function zeigeProduktionsleiterMaximaleGrenzwerte($stationsID) {

		$anzahl = holeAnzahlSteinTypenLogistik($stationsID);

		$queryMaximaleGrenze = abfrageDB("SELECT l.SteinID, l.MaximaleGrenze, s.SteinImage FROM logistik l INNER JOIN steine s ON l.SteinID = s.SteinID WHERE StationsID ='" . $stationsID . "'");

		$arrayResult = [];

		while($resultMaximaleGrenze = mysqli_fetch_array($queryMaximaleGrenze)) {

			array_push($arrayResult, ['SteinID' => $resultMaximaleGrenze[0], 'MaximaleGrenze' => $resultMaximaleGrenze[1], 'SteinImage' => $resultMaximaleGrenze[2], 'AnzahlSteinTypen' => $anzahl]);

		}

		echo json_encode($arrayResult);

	}

	//Diese Methode setzt die maximalen Grenzwerte fest. Als Parameter $maximaleGrenzwerte wird ein Array übergeben, der die StationsID, alle SteinIDs und deren Mengen übergibt.
	function setzeProduktionsleiterMaximaleGrenzwerte($maximaleGrenzwerte) {

		$arrayMaximaleGrenzwerte = json_decode($maximaleGrenzwerte);

		$anzahl = count($arrayMaximaleGrenzwerte[0]->MaximaleGrenzen);
		$maximaleGrenzen = $arrayMaximaleGrenzwerte[0]->MaximaleGrenzen;
		$stationsID = $arrayMaximaleGrenzwerte[0]->StationsID;

		for($i = 0; $i <= ($anzahl - 1); $i++) {

			$steinID = $maximaleGrenzen[$i]->SteinID;
			$menge = $maximaleGrenzen[$i]->MaximaleMenge;

			abfrageDB("UPDATE logistik SET MaximaleGrenze = '" . $menge . "' WHERE SteinID = '" . $steinID . "' AND StationsID = '" . $stationsID . "'");

			//Hole AutobestellungGrenze für Stein und Station an der eine neue Maximale Grenze gesetzt wurde
			$queryAutobestellungGrenze = abfrageDB("SELECT AutobestellungGrenze FROM logistik WHERE SteinID = '" . $steinID . "' AND StationsID = '" . $stationsID . "'");

			$resultAutobestellungGrenze = mysqli_fetch_array($queryAutobestellungGrenze);

			//Wenn die AutobestellungGrenze über der neuen Maximalen Grenze liegt
			if($resultAutobestellungGrenze[0] > $menge) {

				//Setzte AutobestellungGrenze auf neue niedrigere Maximale Grenze herab
				abfrageDB("UPDATE logistik SET AutobestellungGrenze = '" . $menge . "' WHERE SteinID = '" . $steinID . "' AND StationsID = '" . $stationsID . "'");

			}

		}

	}

	/*------------------------------------------------------------------------------------------------------*/
	/*---------------------------------------ENDE VON PRODUKTIONSLEITER-------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/

	/*------------------------------------------------------------------------------------------------------*/
	/*-------------------------------------START VON ARBEITSSTATIONEN 1 - 5---------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/
	//Hier finden Sie alle Methoden, die nur von den Arbeitsstationen 1 - 5 aufgerufen werden

	//Diese Methode zeigt die Auftragslisten der Arbeitsstationen an. Mit dem Parameter werden die Stationsnummer und die dazugehörige Seitenurl übergeben.
	function zeigeAuftragsliste($stationsnummer, $seitenurl) {


		$statusStation = statusStation($stationsnummer);

		//Produktionsleiterseite - reinladen der neuen Aufträge
		if($stationsnummer == 0) {

			$queryProduktionsleiter = abfrageDB("SELECT b.BestellungsID, b.EndProduktID, e.EndProduktImage, b.StatusProduktionsleiter FROM bestellungen b INNER JOIN endprodukt e ON b.EndProduktID = e.EndProduktID WHERE (StatusProduktionsleiter = 0 OR StatusProduktionsleiter = 2) AND StatusStation1 = 0 AND StatusStation2 = 0 AND StatusStation3 = 0 AND StatusStation4 = 0 AND StatusStation5 = 0 AND StatusQuality = 0 AND StatusKunde = 0 AND SpielID = '" . holeSpielID() . "' ORDER BY b.BestellungsID ASC");

			while($resultProduktionsleiter = mysqli_fetch_array($queryProduktionsleiter)) {

				if($resultProduktionsleiter[3] == 0)
				{
					echo "<div class='slider-item'><button type='submit' class='button-auftragsliste' name='btnAuftrag' id='btn" . $resultProduktionsleiter[0] . "' onclick='freigebenZurProduktion(" . $resultProduktionsleiter[0] . ",0)'><img class='image-teilprodukt-auftragsliste' src='" . $resultProduktionsleiter[2] . "'/></button></div>";
				}
				//Roter Rahmen bei Mehrfachbestellungen
				else
				{
					echo "<div class='slider-item-mehrfachbestellung'><button type='submit' class='button-auftragsliste' name='btnAuftrag' id='btn" . $resultProduktionsleiter[0] . "' onclick='freigebenZurProduktion(" . $resultProduktionsleiter[0] . ",1)'><img class='image-teilprodukt-auftragsliste' src='" . $resultProduktionsleiter[2] . "'/></button></div>";
				}
				
			}

		}

		if($stationsnummer == 1) {

			$queryStation1 = abfrageDB("SELECT b.BestellungsID, t.TeilProduktID, t.TeilProduktBezeichnung, t.TeilProduktImage, b.StatusProduktionsleiter FROM bestellungen b INNER JOIN endprodukt_teilprodukt e_t ON b.EndProduktID = e_t.EndProduktID INNER JOIN teilprodukt t ON e_t.TeilProduktID = t.TeilProduktID WHERE (b.StatusProduktionsleiter = 1 OR b.StatusProduktionsleiter = 3) AND e_t.StationsID = '1' AND StatusStation1 = '0' AND t.TeilProduktID != '2' AND b.SpielID = '" . holeSpielID() . "' ORDER BY b.ProduktionsReihenfolge ASC");

			while($resultStation1 = mysqli_fetch_array($queryStation1)) {


				if($resultStation1[4] == 1) {
					echo "<div class='slider-item'><img class='image-teilprodukt-auftragsliste' src='" . $resultStation1[3] . "'/></div>";
				} 
				//roter Rahmen um Mehrfachbestellung
				else {
					echo "<div class='slider-item-mehrfachbestellung'><img class='image-teilprodukt-auftragsliste' src='" . $resultStation1[3] . "'/></div>";
				}

			}

		}
		//INNER JOINS
		else if($stationsnummer != 0 AND $stationsnummer != 1 AND $stationsnummer != 5 AND $stationsnummer != 6) {

			$queryStation234 = abfrageDB("SELECT b.BestellungsID, t.TeilProduktID, t.TeilProduktBezeichnung, t.TeilProduktImage, b.StatusProduktionsleiter FROM bestellungen b INNER JOIN endprodukt_teilprodukt et ON b.EndProduktID = et.EndProduktID INNER JOIN teilprodukt t ON et.TeilProduktID = t.TeilProduktID WHERE (b.StatusProduktionsleiter = 1 OR b.StatusProduktionsleiter = 3) AND et.StationsID = '" . $stationsnummer . "' AND " . $statusStation . " = '0' AND SpielID = '" . holeSpielID() . "' ORDER BY b.ProduktionsReihenfolge ASC");

			while($resultStation234 = mysqli_fetch_array($queryStation234)) {


				if($resultStation234[4] == 1) {
					echo "<div class='slider-item'><img class='image-teilprodukt-auftragsliste' src='" . $resultStation234[3] . "'/></div>";
				}
				//roter Rahmen um Mehrfachbestellung
				else {
					echo "<div class='slider-item-mehrfachbestellung'><img class='image-teilprodukt-auftragsliste' src='" . $resultStation234[3] . "'/></div>";
				}

			}

		} 
		//Endmontage INNER JOINS
		else if ($stationsnummer == 5) {

			$queryStation5 = abfrageDB("SELECT b.BestellungsID, e.EndProduktID, e.EndProduktBezeichnung, e.EndProduktImage, b.StatusProduktionsleiter FROM bestellungen b INNER JOIN endprodukt e ON b.EndProduktID = e.EndProduktID WHERE (b.StatusProduktionsleiter = 1 OR b.StatusProduktionsleiter = 3) AND b.StatusStation5 = 0 AND b.StatusQuality = 0 AND b.StatusKunde = 0 AND b.SpielID = '" . holeSpielID() . "' ORDER BY b.ProduktionsReihenfolge ASC");

			while($resultStation5 = mysqli_fetch_array($queryStation5)) {

				if($resultStation5[4] == 1) {
					echo "<div class='slider-item'><img class='image-teilprodukt-auftragsliste' src='" . $resultStation5[3] . "'/></div>";
				}
				//roter Rahmen um die Mehrfachbestellung
				else {
					echo "<div class='slider-item-mehrfachbestellung'><img class='image-teilprodukt-auftragsliste' src='" . $resultStation5[3] . "'/></div>";
				}

			}

		}
		//Qualitätskontrolle INNER JOINS
		else if($stationsnummer == 6) {

			$queryStation6 = abfrageDB("SELECT b.BestellungsID, b.EndProduktID, e.EndProduktBezeichnung, e.EndProduktImage, b.StatusProduktionsleiter FROM bestellungen b INNER JOIN endprodukt e ON b.EndProduktID = e.EndProduktID WHERE (b.StatusProduktionsleiter = 1 OR b.StatusProduktionsleiter = 3) AND b.StatusQuality = 0 AND b.StatusKunde = 0 AND b.SpielID = '" . holeSpielID() . "' ORDER BY b.ProduktionsReihenfolge ASC");

			while($resultStation6 = mysqli_fetch_array($queryStation6)) {

				if($resultStation6[4] == 1) {
					echo "<div class='slider-item'><img class='image-teilprodukt-auftragsliste' src='" . $resultStation6[3] . "'/></div>";
				}
				//roter Rahmen um die Mehrfachbestellung
				else {
					echo "<div class='slider-item-mehrfachbestellung'><img class='image-teilprodukt-auftragsliste' src='" . $resultStation6[3] . "'/></div>";
				}

			}


		} 


	}

	//Diese Methode liest die Anleitung für das TeilProdukt aus, dessen TeilProduktID als Parameter $teilProduktID übergeben wird. Mit dem Parameter $stationsNummer wird die StationsNummer übergegeben, an dessen Station die TeilProduktAnleitung dargestellt werden soll.
	function zeigeTeilProduktAnleitung($teilProduktID, $stationsNummer) {

		$arrayResult = [];

		if($stationsNummer == 2 OR $stationsNummer == 3 OR $stationsNummer == 4) {

			$queryTeilProduktImage = abfrageDB("SELECT TeilProduktImage, MontageSchritt FROM anleitungs_teilproduktimage WHERE TeilProduktID = '$teilProduktID'");

		}
		if($stationsNummer == 1) {

			$queryTeilProduktImage = abfrageDB("SELECT a.TeilProduktImage, a.MontageSchritt FROM teilprodukt t INNER JOIN anleitungs_teilproduktimage a ON t.TeilProduktID = a.TeilProduktID WHERE t.Station = '$stationsNummer' AND (t.TeilProduktID = '$teilProduktID' OR t.TeilProduktID = '2') ORDER BY a.MontageSchritt ASC");

		}

		while($resultTeilProduktImage = mysqli_fetch_array($queryTeilProduktImage)) {

			array_push($arrayResult, ["TeilProduktImage" => "<img class='image-station-schritt' src='" . $resultTeilProduktImage[0] . "'/>", "MontageSchritt" => $resultTeilProduktImage[1]]);

		}

		echo json_encode($arrayResult);	

	}

	//Diese Methode liest die Anleitung für das EndProdukt aus, dessen EndProduktID als Parameter $endProduktID übergeben wird.
	function zeigeEndProduktAnleitung($endProduktID) {

		$queryEndProduktImage = abfrageDB("SELECT EndProduktImage, MontageSchritt FROM anleitungs_endproduktimage WHERE EndProduktID = '" . $endProduktID . "'");

		//echo "<img class='image-station-schritt' src='" . $resultEndProduktImage[0] . "'/>";

		$arrayResult = [];

		while($resultEndProduktImage = mysqli_fetch_array($queryEndProduktImage)) {

			array_push($arrayResult, ["EndProduktImage" => "<img class='image-station-schritt' src='" . $resultEndProduktImage[0] . "'/>", "MontageSchritt" => $resultEndProduktImage[1]]);

		}

		echo json_encode($arrayResult);	

	}

	//Diese Funktion liest den kompletten Materialbedarf an Steinen für alle Teilprodukte aus, die an einer Station gebaut werden, dessen TeilProduktID und StationID als Parameter übergeben werden.
	function zeigeMaterialbedarfTeilProdukt($teilProduktID, $stationsNummer) {

		$query = abfrageDB("SELECT SteinID, AnzahlSteine FROM teilprodukt_steine WHERE TeilProduktID = '" . $teilProduktID . "'");

		$arrayResult = [];

		//In Station 1 werden zwei unterschiedliche TeilProdukte gebaut
		if($teilProduktID == 1 OR $teilProduktID == 9) {

			$query = abfrageDB("SELECT SteinID, AnzahlSteine FROM teilprodukt_steine WHERE TeilProduktID = '$teilProduktID' OR TeilProduktID = '2' ORDER BY SteinID ASC");

			while($result = mysqli_fetch_array($query)) {

				$querySteinImage = abfrageDB("SELECT SteinImage FROM steine WHERE SteinID = '" . $result[0] . "'");
				$resultSteinImage = mysqli_fetch_array($querySteinImage);

				array_push($arrayResult, ["AnzahlSteine" => $result[1], "SteinImage" => $resultSteinImage[0]]);
			}

		}
		//In Station 4 wird die Tischplatte_Rot auf den Tischfuss aus Station 3 montiert
		if($teilProduktID == 5) {

			array_push($arrayResult, ["AnzahlSteine" => "1", "SteinImage" => "Images/LegoBricks/Anleitungen/3_Station/SchwarzGelb/Schritt_4.png"]);

		}
		//In Station 4 wird die Tischplatte_Grau auf den Tischfuss aus Station 3 montiert
		if($teilProduktID == 8) {

			array_push($arrayResult, ["AnzahlSteine" => "1", "SteinImage" => "Images/LegoBricks/Anleitungen/3_Station/SchwarzGrauRot/Schritt_4.png"]);

		}
		//Bei allen anderen Stationen müssen keine ferigen Teilprodukte oder extra Steine angezeigt werden. Alles normal, wie in der Datenbank abgebildet

		while($result = mysqli_fetch_array($query)) {

		$querySteinImage = abfrageDB("SELECT SteinImage FROM steine WHERE SteinID = '" . $result[0] . "'");
		$resultSteinImage = mysqli_fetch_array($querySteinImage);
			
		array_push($arrayResult, ["AnzahlSteine" => $result[1], "SteinImage" => $resultSteinImage[0]]);


		}

		echo json_encode($arrayResult);
		

	}

	//Diese Funktion liest den kompletten Materialbedarf an TeilProdukten für alle Endprodukte aus, dessen EndproduktID als Parameter übergeben wird
	function zeigeMaterialbedarfEndProdukt($endProduktID) {

		$queryTeilProduktID = abfrageDB("SELECT TeilProduktID FROM endprodukt_teilprodukt WHERE EndProduktID = '" . $endProduktID . "'");


		$arrayResult = [];

		while($resultTeilProduktID = mysqli_fetch_array($queryTeilProduktID)) {

			$queryTeilProduktImage = abfrageDB("SELECT TeilProduktImage FROM teilprodukt WHERE TeilProduktID = '" . $resultTeilProduktID[0] . "'");
			$resultTeilProduktImage = mysqli_fetch_array($queryTeilProduktImage);
			
			array_push($arrayResult, ["AnzahlTeilProdukte" => 1, "TeilProduktImage" => $resultTeilProduktImage[0]]);

		}

		echo json_encode($arrayResult);

	}

	//Diese Methode wird aufgerufen, sobald an einer Arbeitsstation alle notwendigen Arbeitsschritte erledigt wurden. Als Parameter werden sowohl die BestellungsID und die StationNummer übergeben
	function montiertTeilProdukt($bestellungsID, $stationsnummer) {

		$statusStation = statusStation($stationsnummer);
		$statustime = statustime($stationsnummer);

		abfrageDB("UPDATE `bestellungen` SET " . $statusStation . " = '1', " . $statustime ." = '" . date('Y-m-d H:i:s') .  "' WHERE SpielID = '" . holeSpielID() . "' AND BestellungsID = '". $bestellungsID . "'");

	}

	//Diese Methode lädt den dynamischen Inhalt, wenn man auf den Arbeitsstationen 1 bis 4 den blauen "Material"-Button drückt. Je nach dem welcher Bestellmodus (manuell oder automatisch) aktiviert ist, ändert sich der Inhalt.
	function holeMaterialPopUpInhalt($bestellModus, $stationNummer) {

		$arrayResult = [];

		$queryMaterial = abfrageDB("SELECT DISTINCT s.SteinImage, s.SteinID, l.AutobestellungGrenze FROM teilprodukt t INNER JOIN teilprodukt_steine ts ON t.TeilProduktID = ts.TeilProduktID INNER JOIN steine s ON ts.SteinID = s.SteinID INNER JOIN logistik l ON s.SteinID = l.SteinID AND l.StationsID = '" . $stationNummer . "' WHERE t.Station = '" . $stationNummer . "'");

		while($resultMaterial = mysqli_fetch_array($queryMaterial)) {

			array_push($arrayResult, ["BestellModus" => $bestellModus ,"SteinImage" => $resultMaterial[0], "SteinID" => $resultMaterial[1], "Grenze" => $resultMaterial[2]]);

		}

		echo json_encode($arrayResult);


	}

	//Diese Methode holt den maximalen Grenzwert aus der Datenbank, die vom Produktionsleiter festgelegt wurde. Als Parameter werden dafür die $steinID und die $stationsNummer übergeben.
	function holeMaximaleGrenzwerte($steinID, $stationsNummer) {

		$queryMaximaleGrenzen = abfrageDB("SELECT MaximaleGrenze FROM logistik WHERE SteinID = '" . $steinID . "' AND StationsID = '" . $stationsNummer . "'");

		$resultMaximaleGrenzen = mysqli_fetch_array($queryMaximaleGrenzen);

		return $resultMaximaleGrenzen[0];

	}

	//Diese Methode erstellt eine neue manuelle Bestllung. Als Parameter wird als Json-Array alle Bestellungen alle SteinIDs, deren Menge und dazu die StationsID übergeben.
    function erstelleManuelleBestellung($bestellung) {

    	$arrayMaterialBestellungen = json_decode($bestellung);

		$anzahl = count($arrayMaterialBestellungen[0]->MaterialBestellung);
		$materialBestellung = $arrayMaterialBestellungen[0]->MaterialBestellung;

		$stationsID = $arrayMaterialBestellungen[0]->StationsID;

		for($i = 0; $i <= ($anzahl - 1); $i++) {
			
			$steinID = $materialBestellung[$i]->SteinID;
			$menge = $materialBestellung[$i]->MaterialMenge;

			//Wenn die Menge ungleich 0 ist => Bestellung
			if($menge != 0) {
				//echo "SteinID: " . $steinID . " MaterialMenge: " . $menge;
				erstelleNeueAnlieferung($steinID, $stationsID, $menge);
			} //Wenn die Menge 0 ist, wurde es nur mit Übertragen, handelt sich aber um keine Materialbestellung

		}

    }

    //Diese Methode setzt alle Grenzen für die automatische Bestellung. Als Parameter wird als Json-Array alle SteinIDs, deren Grenzen und dazu die StationsID übergeben.
	function setzeAutoBestellungsGrenzen($grenzen) {

		$arrayMaterialGrenzen = json_decode($grenzen);

		$anzahl = count($arrayMaterialGrenzen[0]->MaterialGrenzen);
		$materialGrenzen = $arrayMaterialGrenzen[0]->MaterialGrenzen;
		$stationsID = $arrayMaterialGrenzen[0]->StationsID;

		for($i = 0; $i <= ($anzahl - 1); $i++) {

			$steinID = $materialGrenzen[$i]->SteinID;
			$menge = $materialGrenzen[$i]->MaterialMenge;

			abfrageDB("UPDATE logistik SET AutobestellungGrenze = '" . $menge . "' WHERE SteinID = '" . $steinID . "' AND StationsID = '" . $stationsID . "'");

		}

	}


	/*------------------------------------------------------------------------------------------------------*/
	/*-------------------------------------ENDE VON ARBEITSSTATIONEN 1 - 5----------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/

	/*------------------------------------------------------------------------------------------------------*/
	/*--------------------------------------START VON QUALITÄTSKONTROLLE------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/
	//Hier finden Sie alle Methoden, die nur von der Qualitätskontrolle bzw. nur von der Qualityseite aufgerufen werden


	//Auftragsliste von Qualitätskontrolle findet man in unter Arbeitsstationen 1 - 5

	//Diese Methode liest die Anleitungen und Bilder aus, die bei der Qualitätskontrolle angezeigt werden. Der Parameter $endProduktID übergibt die EndproduktID des Produktes gewünschten Produkts.
	function zeigeEndProduktQualitaet($endproduktid) {

		$queryEndProduktImage = abfrageDB("SELECT EndProduktImage FROM endprodukt WHERE EndProduktID = '" . $endproduktid . "'");

		$resultEndProduktImage = mysqli_fetch_array($queryEndProduktImage);

		$arrayResult = ['EndProduktImage' => $resultEndProduktImage[0]];

		echo json_encode($arrayResult);

	}

	//Diese Methode wird aufgerufen, wenn die Qualitätskontrolle mit einer Bestellung nicht zufrieden ist und der Meister nachbessern soll. Als Parameter wird die $bestellungsID übergeben, dessen Bestellung nachgebessert werden muss.
	function nachbessernEndProdukt($bestellungsID) {

		//Anzahl an Retouren aus der Datenbank auslesen
		$queryAnzahl = abfrageDB("SELECT AnzahlRetoureQuality FROM bestellungen WHERE BestellungsID = '" . $bestellungsID . "'");

		$resultAnzahl = mysqli_fetch_array($queryAnzahl);

		//Anzahl um 1 erhöhen
		$anzahl = $resultAnzahl[0] + 1;

		abfrageDB("UPDATE bestellungen SET StatusQuality = '2', AnzahlRetoureQuality = '" . $anzahl . "' WHERE BestellungsID = '" . $bestellungsID . "'");

	}

	//Diese Methode wird aufgerufen, wenn die Qualitätskontrolle mit einer Bestellung zufrieden ist und an den Kunden ausgeliefert werden kann. Als Parameter wird die $bestellungsID übergeben, dessen Bestellung ausgeliefert werden kann.
	function ausliefernEndProdukt($bestellungsID) {

		abfrageDB("UPDATE bestellungen SET StatusQuality = '1', Quality_timestamp =  '" . date('Y-m-d H:i:s') .  "' WHERE BestellungsID = '" . $bestellungsID . "'");

	}


	/*------------------------------------------------------------------------------------------------------*/
	/*--------------------------------------ENDE VON QUALITÄTSKONTROLLE-------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/

	/*------------------------------------------------------------------------------------------------------*/
	/*------------------------------------------START VON LOGISTIK------------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/
	//Hier finden Sie alle Methoden, die nur vom Logistiker bzw. nur von der Logistikseite aufgerufen werden

	//Diese Methode liest alle aktuellen Anlieferungen für das aktuelle Spiel aus der Datenbank aus, deren Lieferungen sich noch nicht in der Bearbeitung befinden (kein grüner Rahmen)
	function aktuelleAnlieferungenSlider() {

 

        $sqlAnlieferungen = abfrageDB("SELECT AnlieferungsID, SteinID, AnzahlSteine, StationsID from anlieferungen  WHERE StatusAnlieferung = 0 AND SpielID = '" . holeSpielID() . "'");

 

        while($resultAnlieferungen = mysqli_fetch_array($sqlAnlieferungen)) {    

 

        echo "    <div class='container-logistik-slider'>
                <div class='title'>Arbeitsplatz ". $resultAnlieferungen[3] . "<br>" . holeSteinBezeichnung($resultAnlieferungen[1]) ."</div>
                <img class='image-logistik-slider' src='" . holeSteinBild($resultAnlieferungen[1]) ."'/>
                <div class='logistik-anzahl'>Anzahl ". $resultAnlieferungen[2] ."</div>
                <button class='button-logistik-slider' id='btn" . $resultAnlieferungen[0] . "' onclick ='UpdateAnlieferungFertig(" . $resultAnlieferungen[0] . ")'>Annehmen</button>
                </div>"    ;
        
        }

 

    }

    //Diese Methode liest alle aktuellen Anlieferungen für das aktuelle Spiel aus der Datenbank aus, deren Lieferung sich in Bearbeittung befinden (grüner Rahmen)
	function aktuelleAnlieferungeninBearbeitungSlider() {

 

        $sqlAnlieferungen = abfrageDB("SELECT AnlieferungsID, SteinID, AnzahlSteine, StationsID from anlieferungen  WHERE StatusAnlieferung = 1 AND SpielID = '" . holeSpielID() . "'");

 

        while($resultAnlieferungen = mysqli_fetch_array($sqlAnlieferungen)) {    

 

        echo "    <div class='container-logistik-slider container-logistik-slider-bearbeitung'>
                <div class='title'>Arbeitsplatz ". $resultAnlieferungen[3] . "<br>" . holeSteinBezeichnung($resultAnlieferungen[1]) ."</div>
                <img class='image-logistik-slider' src='" . holeSteinBild($resultAnlieferungen[1]) ."'/>
                <div class='logistik-anzahl'>Anzahl ". $resultAnlieferungen[2] ."</div>
                <button class='button-logistik-slider'  id='btn" . $resultAnlieferungen[0] . "' onclick='UpdateAnlieferungBearbeitung(" . $resultAnlieferungen[0] . ")' >Angeliefert</button>
                </div>"    ;
        
        }

 

    }

    //Diese Methode setzt eine Anlieferung auf Status "in Bearbeitung", sichtbar wird dies durch den grünen Rahmen. Als Parameter wird die $anlieferungsID übergeben, dessen Status auf "in Bearbeitung" gesetzt wird.
	function updateAnlieferungBearbeitung($anlieferungsID) {

		abfrageDB("UPDATE anlieferungen SET StatusAnlieferung = '1' WHERE AnlieferungsID = '" . $anlieferungsID . "'");
	}

	//Diese Methode schließt eine Anlieferung ab. Als Paraemter wird die $anlieferungsID übergeben, um dessen Anlieferung es sich handelt.
	function updateAnlieferungFertiggestellt($anlieferungsID) {

		abfrageDB("UPDATE anlieferungen SET StatusAnlieferung = '2' WHERE AnlieferungsID = '" . $anlieferungsID . "'");
	}

	//Diese Methode überprüft, ob bereits Bestellungen vorhanden sind, wenn eine oder mehr Bestellungen vorhanden sind, gibt die funktion “true“ zurück Andernfalls ist der Rückgabewert “false“.
	function bestellungenVorhanden(){

		$sqlendprodukte = abfrageDB("SELECT SUM(BestellungsID) FROM bestellungen");
		
		while($resultendprodukte = mysqli_fetch_array($sqlendprodukte)) {
			
			$ergebnis = $resultendprodukte[0];

		}

		if($ergebnis <= 0) {
			return false;
		}
		else {
			return true;
		}

	}

	//Diese Funktion ermittelt wieviele Steine bereits an eine Station geliefert wurden(Tabelle anlieferungen, StatusAnlieferung = 2) Beim auslesen matcht die Funktion alle Anlieferung mit der übergebenen Stationsnummer ($stationsnummer)und der übergebenen SteinID ($SteinID)  summiert die Anzahl aller Steine (Spalte AnzahlSteine) Diese werden als Zahlenwert zurückgegeben.
	function anlieferungStatus($stationsnummer, $SteinID) {

		if(holeMaterialStandModus() == 0) {

			$queryAngelieferteSteine = abfrageDB("SELECT SUM(AnzahlSteine) FROM anlieferungen WHERE StatusAnlieferung = '2' AND StationsID = '" .$stationsnummer."' AND SteinID = '" .$SteinID."' AND SpielID = '" . holeSpielID() . "'");

		} else {

			$queryAngelieferteSteine = abfrageDB("SELECT SUM(AnzahlSteine) FROM anlieferungen WHERE StatusAnlieferung = '2' AND StationsID = '" .$stationsnummer."' AND SteinID = '" .$SteinID."'");

		}
        
        
        $resultanlieferungen = mysqli_fetch_array($queryAngelieferteSteine);
        
        return $resultanlieferungen[0];
            
    }

    //Diese Methode fragt ab, ob beim Spielstart Materialstand übernehmen ausgewählt wurde und gibt die ausgewählte Option aus der Spieltabelle zurück
    function holeMaterialStandModus() {

        //Wir holen
        $query = abfrageDB("SELECT MaterialstandUebernahme from spiel WHERE SpielID = '" . holeSpielID() . "'");
        $resultMaterialStand = mysqli_fetch_array($query);
        if(isset($resultMaterialStand)){
            //Gibt die aktuelle SpielID zurück
            return $resultMaterialStand[0];
        }
        else {
            //Wenn es keine SpielID gibt, gibt er 1 zurücl
            return 1;
        }

    }

	//Diese Methode liest die aktuellen Steinbestände der einzelnen Arbeitsstationen aus. Als Parameter wird die $stationsnummer übergeben, dessen aktuelle Steinbestände ausgelesen werden sollen.
	function zeigeLogistikStatus($stationsnummer)
	{

		if(bestellungenVorhanden() == true)
		{

			echo "	<tr class='table-row'><td class='table-header'>Steintyp</td><td class='table-header'>Anzahl</td></tr>";

				//$query = abfrageDB("SELECT b.EndProduktID, COUNT(b.EndProduktID), ts.SteinID, ts.AnzahlSteine, s.SteinBezeichnung from bestellungen b INNER Join endprodukt_teilprodukt et ON b.EndProduktID = et.EndProduktID INNER Join teilprodukt_steine ts ON et.TeilProduktID = ts.TeilProduktID INNER Join steine s ON s.SteinID = ts.SteinID WHERE b.SpielID = '" . holeSpielID() . "' AND et.StationsID = '" . $stationsnummer . "' GROUP by ts.SteinID ");

			if(holeMaterialStandModus()== 0){

                $query = abfrageDB("SELECT b.EndProduktID, COUNT(b.EndProduktID), ts.SteinID, ts.AnzahlSteine, s.SteinBezeichnung from bestellungen b INNER Join endprodukt_teilprodukt et ON b.EndProduktID = et.EndProduktID INNER Join teilprodukt_steine ts ON et.TeilProduktID = ts.TeilProduktID INNER Join steine s ON s.SteinID = ts.SteinID WHERE b.SpielID = '" . holeSpielID() . "' AND et.StationsID = '" . $stationsnummer . "' GROUP by ts.SteinID ");
                
            }
            else {
                
                $query = abfrageDB("SELECT b.EndProduktID, COUNT(b.EndProduktID), ts.SteinID, ts.AnzahlSteine, s.SteinBezeichnung from bestellungen b INNER Join endprodukt_teilprodukt et ON b.EndProduktID = et.EndProduktID INNER Join teilprodukt_steine ts ON et.TeilProduktID = ts.TeilProduktID INNER Join steine s ON s.SteinID = ts.SteinID WHERE et.StationsID = '" . $stationsnummer . "' GROUP by ts.SteinID ");

            }
				

			while($result = mysqli_fetch_array($query))
			{

				$SteinanzahlStation = anlieferungStatus($stationsnummer, $result[2])  + (($result[1]*$result[3])*(-1));


				if($SteinanzahlStation <= holeAutoBestellungGrenze($result[2], $stationsnummer) )
				{
					echo "	<tr class='table-row'><td class='table-cell'>" .  $result[4] ."</td><td class='table-cell status-red'>" . $SteinanzahlStation ."</td></tr>";

					//Nur wenn automatische Bestellungen (SpielModusBestellungen == 2), bestellt er automatisch nach
					if(holeSpielModusBestellungen() == 2) {

						erstelleNeueAnlieferung($result[2], $stationsnummer, holeEmpfohleneLieferMenge($result[2], $stationsnummer));

					}

					//erstelleNeueAnlieferung($result[2], $stationsnummer, holeEmpfohleneLieferMenge($result[2], $stationsnummer));
					//erstellt eine neue Anlieferung, übergebene Parameter: SteinID, Stationsnummer, empfohlene Menge
					//erstelleNeueAnlieferung($result[4], $stationsnummer, 60);
				}
				else if( $SteinanzahlStation <= holeAutoBestellungGrenze($result[2], $stationsnummer) +10  )
				{
					echo "	<tr class='table-row'><td class='table-cell'>" .  $result[4] ."</td><td class='table-cell status-orange'>" . $SteinanzahlStation ."</td></tr>";


					//Hier Steinanzahl ändern, die bestellt wird, wenn die Steine unter 20 Steine sind (3. parameter)

					//erstelleNeueAnlieferung($result[2], $stationsnummer, 50);
				}
				else
				{
					echo "	<tr class='table-row'><td class='table-cell'>" .  $result[4] ."</td><td class='table-cell status-green'>" . $SteinanzahlStation ."</td></tr>";
							//erstelleNeueAnlieferung($result[4], $stationsnummer, 60);
				}



			}
		}
	}

	//Diese Methode liest Interfacerelevante Informationen für das UmbuchungsPopUp aus.
	function zeigeUmbuchungenPopUpInhalt() {

		$querySteine = abfrageDB("SELECT SteinID, SteinBezeichnung, SteinImage FROM steine");

		$arrayResult = [];

		while($resultSteine = mysqli_fetch_array($querySteine)) {

			array_push($arrayResult, ["SteinID" => $resultSteine[0], "SteinBezeichnung" => $resultSteine[1], "SteinImage" => $resultSteine[2]]);

		}

		echo json_encode($arrayResult);

	}

	//Diese Methode bucht Steine zwischen zwei Stationen um. Als Parameter werden $steinID, $vonStation, $zurStation und $anzahlSteine übergeben. Diese geben den Steintyp, von welcher Station zu welcher Station und welche Anzahl umgebucht werden soll.
	function lieferungZuAndererStation($steinID, $vonStation, $zurStation, $anzahlSteine){

		abfrageDB("INSERT INTO `anlieferungen`( `SteinID`, `StationsID`, `AnzahlSteine`, `StatusAnlieferung`, `BoxID`, `SpielID`) VALUES ('" .$steinID."' , '" .$vonStation."', '" .$anzahlSteine *(-1)."', 2, 0, '" . holeSpielID() ."'  )");
		abfrageDB("INSERT INTO `anlieferungen`( `SteinID`, `StationsID`, `AnzahlSteine`, `StatusAnlieferung`, `BoxID`, `SpielID`) VALUES ('" .$steinID."' , '" .$zurStation."', '" .$anzahlSteine."', 2, 0, '" . holeSpielID() ."'  )");

	}

	/*------------------------------------------------------------------------------------------------------*/
	/*-------------------------------------------ENDE VON LOGISTIK------------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/

	/*------------------------------------------------------------------------------------------------------*/
	/*-------------------------------------------START VON MEISTER------------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/
	//Hier finden Sie alle Methoden, die nur vom Meister bzw. nur von der Meisterseite aufgerufen werden

	//Diese Methode liest alle Retouren für das aktuelle Spiel aus der Datenbank aus. Es handelt sich dabei um Bestellungen die entweder durch die Qualitätskontrolle gefallen sind oder vom Kunden reklamiert wurden.
	function holeRetouren() {

		$queryRetoure = abfrageDB("SELECT b.BestellungsID, b.EndProduktID, e.EndProduktBezeichnung, e.EndProduktImage, b.StatusQuality, b.StatusKunde, b.ProduktionsReihenfolge FROM bestellungen b INNER JOIN endprodukt e ON b.EndProduktID = e.EndProduktID WHERE b.StatusQuality = '2' OR b.StatusKunde = '2' ORDER BY b.ProduktionsReihenfolge ASC");

		$arrayResult = [];

		while($resultRetoure = mysqli_fetch_array($queryRetoure)) {

			//StatusQuality = 2, d.h. es ist bei der Qualitätskontrolle durchgefallen
			if($resultRetoure[4] == '2') {
				$station = "<div class='status-orange'>Qualität</div>";
			}
			//StatusKunde = 2, d.h. der Kunde hat die Annahme verweigert und es reklamiert
			if($resultRetoure[5] == '2') {
				$station = "<div class='status-red'>Kunde</div>";
			}

			array_push($arrayResult, ['BestellungsID' => $resultRetoure[0], 'EndProduktID' => $resultRetoure[1], 'EndProduktBezeichnung' => $resultRetoure[2], 'EndProduktImage' => $resultRetoure[3], 'StationDurchgefallen' => $station]);

		}

		echo json_encode($arrayResult);

	}

	//Diese Methode markiert in der Datenbank, sobald der Meister ein reklamierte Bestellung repariert hat damit anschließend die Qualitätskontrolle wieder prüfen kann. Als Parameter wird die $bestellunsID übergeben.
	function retoureRepariert($bestellungsID) {

		abfrageDB("UPDATE bestellungen SET StatusQuality = '0', StatusKunde = '0' WHERE BestellungsID = '" . $bestellungsID . "'");

	}


	/*------------------------------------------------------------------------------------------------------*/
	/*--------------------------------------------ENDE VON MEISTER------------------------------------------*/
	/*------------------------------------------------------------------------------------------------------*/

	
	/*-------------------------------------------------------------------------------------------------------------------------*/
	/*-------------------------------------------------------------------------------------------------------------------------*/
	/*------------------------------------------------------ANALYTICS----------------------------------------------------------*/
	/*-------------------------------------------------------------------------------------------------------------------------*/
	/*-------------------------------------------------------------------------------------------------------------------------*/

	//Diese Methode liest die in der Datebank hinterlegten SpielIDs, die aktuell in den Analytics dargestellt werden aus
	function holeAnalyticsSpielIDs() {

		$queryAnalyticsSpielIDs = abfrageDB("SELECT AnalyticsSpielID1, AnalyticsSpielID2, AnalyticsSpielID3 FROM spiel WHERE SpielID = '" . holeSpielID() . "'");

		$resultAnalyticsSpielIDs = mysqli_fetch_array($queryAnalyticsSpielIDs);

		$arrayResult = [];

		if($resultAnalyticsSpielIDs['AnalyticsSpielID1'] != 0)  {

			array_push($arrayResult, $resultAnalyticsSpielIDs['AnalyticsSpielID1']);

		}
		if($resultAnalyticsSpielIDs['AnalyticsSpielID2'] != 0)  {

			array_push($arrayResult, $resultAnalyticsSpielIDs['AnalyticsSpielID2']);

		}
		if($resultAnalyticsSpielIDs['AnalyticsSpielID3'] != 0)  {

			array_push($arrayResult, $resultAnalyticsSpielIDs['AnalyticsSpielID3']);

		}

		return $arrayResult;

	}

	//Diese Methode liest alle Spiele aus der Datenbank, die im PopUp AnalyticsAuswahl angezeigt werden können
	function zeigeAnalyticsAuswahl() {

		$querySpiele = abfrageDB("SELECT SpielID, Bezeichnung FROM spiel WHERE SpielID != '1'"); //Das Reset-Spiel wird nicht angezeigt

		$arrayResult = [];

		while($resultSpiele = mysqli_fetch_array($querySpiele)) {

			array_push($arrayResult, ['SpielID' => $resultSpiele['SpielID'], 'Bezeichnung' => $resultSpiele['Bezeichnung']]);

		}

		echo json_encode($arrayResult);

	}

	//Diese Methode speichert die AnalyticsAuswahl für das aktuelle Spiel (bzw. letzte Spiel wenn keins erstellt ist) in der Datenbank
	function setzeAnalyticsAuswahl($auswahl1, $auswahl2, $auswahl3) {

		abfrageDB("UPDATE spiel SET AnalyticsSpielID1 = '" . $auswahl1 . "', AnalyticsSpielID2 = '" . $auswahl2 . "', AnalyticsSpielID3 = '" . $auswahl3 . "' WHERE SpielID = '" . holeSpielID() . "'");

	}


	//Diese Methode leifert die Daten für die Tabelle mit der Spielübersicht, Durchlaufzeit etc.
	function tabelleSpielDurchlaufzeitenAnzahlBestellungen() {
		
		$arraySpielIDs = holeAnalyticsSpielIDs();
		$anzahlSpielIDs = count($arraySpielIDs);
		$arraySpiel1 = [];
		$arraySpiel2 = [];
		$arraySpiel3 = [];

		for($i = 0; $i < $anzahlSpielIDs; $i++) {


			if($arraySpielIDs[$i] != 0) {

				$arrayBestellungenZeiten = [];
				$spielID = '';
				$spielBezeichnung = '';
				$spielZeit = '';
				$anzahlPuenktlichGeliefert = 0;
				$anzahlVerspaetetGeliefert = 0;

				$query = abfrageDB("SELECT s.SpielID, s.Bezeichnung, s.SpielStartzeit, s.SpielEndzeit, b.BestellungsID, b.BestellStartzeit, b.BestellEndzeit, b.Takt, b.StatusKunde FROM spiel s INNER JOIN bestellungen b ON s.SpielID = b.SpielID WHERE s.SpielID = '" . $arraySpielIDs[$i] . "'");
				

				while($result = mysqli_fetch_array($query)) {

					//Wenn das Spiel noch aktiv und nicht beendet ist
					if($result['SpielEndzeit'] == '0000-00-00 00:00:00') {
						//Differenzzeit von der aktuellen Zeit
						$differenzSpielZeit = strtotime(date("Y-m-d H:i:s")) - strtotime($result['SpielStartzeit']);
					} else {
						$differenzSpielZeit = strtotime($result['SpielEndzeit']) - strtotime($result['SpielStartzeit']);
					}
					

					//Spielzeit von Sekunden in Minuten umrechnen
					$spielZeit = round($differenzSpielZeit / 60, 0);

					if($result['BestellEndzeit'] != '0000-00-00 00:00:00') {
						$differenzBestellungen = strtotime($result['BestellEndzeit']) - strtotime($result['BestellStartzeit']);
					} else {
						$differenzBestellungen = 0;
					}
					

					$statusKunde = $result['StatusKunde'];

					//Bestellungszeit über der dazugehörigen Taktzeit => Verpätet geliefert/ Wenn der Takt = 0 ist, handelt es sich um eine Sonderbestellung, d.h. die werden immer pünktlich geliefert
					if($statusKunde == 1 AND $differenzBestellungen > $result['Takt'] AND $result['Takt'] != 0) {

						$anzahlVerspaetetGeliefert++; //= $anzahlVerspaetetGeliefert + 1;

					} 
					//Bestellungszeit unter oder gleich der dazugehörigen Taktzeit => Pünktlich geliefert
					else if($statusKunde == 1 AND ($differenzBestellungen <= $result['Takt'] OR $result['Takt'] == 0)) {

						$anzahlPuenktlichGeliefert++;// = $anzahlPuenktlichGeliefert + 1;

					}

					array_push($arrayBestellungenZeiten, $differenzBestellungen);


					$spielID = $result['SpielID'];
					$spielBezeichnung = $result['Bezeichnung'];

				}


				if(empty($arrayBestellungenZeiten) == false) {

					$anzahlBestellungen = count($arrayBestellungenZeiten);
					$minDurchlaufzeit = min($arrayBestellungenZeiten);
					$maxDurchlaufzeit = max($arrayBestellungenZeiten);
					$durchschnittDurchlaufszeit = round(array_sum($arrayBestellungenZeiten) / $anzahlBestellungen, 0);

				} else {
					$anzahlBestellungen = count($arrayBestellungenZeiten);;
					$minDurchlaufzeit = 0;
					$maxDurchlaufzeit = 0;
					$durchschnittDurchlaufszeit = 0;
				}
				
				


				if($i == 0) {
					$arraySpiel1 = ['SpielBezeichnung' => $spielBezeichnung, 'SpielZeit' => $spielZeit, 'minDurchlaufzeit' => $minDurchlaufzeit, 'durchschnittDurchlaufszeit' => $durchschnittDurchlaufszeit, 'maxDurchlaufzeit' => $maxDurchlaufzeit, 'AnzahlBestellungen' => $anzahlBestellungen, 'PuentlichGeliefert' => $anzahlPuenktlichGeliefert, 'VerspaetetGeliefert' => $anzahlVerspaetetGeliefert];
				}
				else if($i == 1) {
					$arraySpiel2 = ['SpielBezeichnung' => $spielBezeichnung, 'SpielZeit' => $spielZeit, 'minDurchlaufzeit' => $minDurchlaufzeit, 'durchschnittDurchlaufszeit' => $durchschnittDurchlaufszeit, 'maxDurchlaufzeit' => $maxDurchlaufzeit, 'AnzahlBestellungen' => $anzahlBestellungen, 'PuentlichGeliefert' => $anzahlPuenktlichGeliefert, 'VerspaetetGeliefert' => $anzahlVerspaetetGeliefert];
				}
				else if($i == 2) {
					$arraySpiel3 = ['SpielBezeichnung' => $spielBezeichnung, 'SpielZeit' => $spielZeit, 'minDurchlaufzeit' => $minDurchlaufzeit, 'durchschnittDurchlaufszeit' => $durchschnittDurchlaufszeit, 'maxDurchlaufzeit' => $maxDurchlaufzeit, 'AnzahlBestellungen' => $anzahlBestellungen, 'PuentlichGeliefert' => $anzahlPuenktlichGeliefert, 'VerspaetetGeliefert' => $anzahlVerspaetetGeliefert];
				}

			}

			

		}

		$result = "";

		if(empty($arraySpiel1) == false) { 

			$result = $result . "<tr>
		 		<td class='table-cell-padding'>" . $arraySpiel1['SpielBezeichnung'] . "</td>
		 		<td class='table-cell-padding'>" . $arraySpiel1['SpielZeit'] . " min.</td>
		 		<td class='table-cell-padding'>" . $arraySpiel1['minDurchlaufzeit'] . " sek.</td>
		 		<td class='table-cell-padding'>" . $arraySpiel1['durchschnittDurchlaufszeit'] . " sek.</td>
		 		<td class='table-cell-padding'>" . $arraySpiel1['maxDurchlaufzeit'] . " sek.</td>
		 		<td class='table-cell-padding'>" . $arraySpiel1['AnzahlBestellungen']. "</td>
		 		<td class='table-cell-padding'>" . $arraySpiel1['PuentlichGeliefert'] . "</td>
		 		<td class='table-cell-padding'>" . $arraySpiel1['VerspaetetGeliefert'] . "</td>
		 		</tr>";
		} 
		if(empty($arraySpiel2) == false) { 
		 	
		 	$result = $result . "<tr>
		 		<td class='table-cell-padding'>" . $arraySpiel2['SpielBezeichnung'] . "</td>
		 		<td class='table-cell-padding'>" . $arraySpiel2['SpielZeit'] . " min.</td>
		 		<td class='table-cell-padding'>" . $arraySpiel2['minDurchlaufzeit'] . " sek.</td>
		 		<td class='table-cell-padding'>" . $arraySpiel2['durchschnittDurchlaufszeit'] . " sek.</td>
		 		<td class='table-cell-padding'>" . $arraySpiel2['maxDurchlaufzeit'] . " sek.</td>
		 		<td class='table-cell-padding'>" . $arraySpiel2['AnzahlBestellungen']. "</td>
		 		<td class='table-cell-padding'>" . $arraySpiel2['PuentlichGeliefert'] . "</td>
		 		<td class='table-cell-padding'>" . $arraySpiel2['VerspaetetGeliefert'] . "</td>
		 		</tr>";

		} 
		if(empty($arraySpiel3) == false) { 

		 	$result = $result . "<tr>
		 		<td class='table-cell-padding'>" . $arraySpiel3['SpielBezeichnung'] . "</td>
		 		<td class='table-cell-padding'>" . $arraySpiel3['SpielZeit'] . " min.</td>
		 		<td class='table-cell-padding'>" . $arraySpiel3['minDurchlaufzeit'] . " sek.</td>
		 		<td class='table-cell-padding'>" . $arraySpiel3['durchschnittDurchlaufszeit'] . " sek.</td>
		 		<td class='table-cell-padding'>" . $arraySpiel3['maxDurchlaufzeit'] . " sek.</td>
		 		<td class='table-cell-padding'>" . $arraySpiel3['AnzahlBestellungen']. "</td>
		 		<td class='table-cell-padding'>" . $arraySpiel3['PuentlichGeliefert'] . "</td>
		 		<td class='table-cell-padding'>" . $arraySpiel3['VerspaetetGeliefert'] . "</td>
		 	</tr>"; 
		}


		if(empty($arraySpiel1) == true AND empty($arraySpiel2) == true AND empty($arraySpiel3) == true) {

			echo '<div class="infotext-analytics">Bitte wählen Sie erst unter "Produktionsperioden" bis zu 3 Produktionsperioden aus, die hier als Analytics dargestellt werden sollen.</div>';

		} else {

			echo "<table class='table'>
		 	<tr>
		 		<th class='table-header-padding'>Bezeichnung</th>
		 		<th class='table-header-padding'>Dauer</th>
		 		<th class='table-header-padding'>min Ø Durchlaufszeit</th>
		 		<th class='table-header-padding'>Ø Durchlaufszeit</th>
		 		<th class='table-header-padding'>max Ø Durchlaufszeit</th>
		 		<th class='table-header-padding'>Anzahl Bestellungen</th>
		 		<th class='table-header-padding'>Pünktlich geliefert</t>
		 		<th class='table-header-padding'>Verpätet geliefert</th>
		 	</tr> " . $result . "
		 </table>";

		}

	}

	//Diese Methode gibt die Durchschnitsslaufzeit der einzelnen Bestellungen aus und formatiert sie in json.
	function barChartDurchlaufzeitenBestellungen() {

		//$arraySpielIDs = [2, 3, 4];
		$arraySpielIDs = holeAnalyticsSpielIDs();

		$anzahlSpielIDs = count($arraySpielIDs);

		$stringLabels = "";
		$stringData = "";
		$stringBackgroundColor = "";
		$stringBorderColor = "";
		$stringTakt = "";

		for($i = 0; $i < $anzahlSpielIDs; $i++) {

			$query = abfrageDB("SELECT SpielID, BestellungsID, BestellStartzeit, BestellEndzeit, Takt FROM bestellungen WHERE StatusKunde = '1' AND SpielID = '" . $arraySpielIDs[$i] . "' ORDER BY ProduktionsReihenfolge"); 

			

			while($result = mysqli_fetch_array($query)) {

				//Differenz der Zeit berechnen
				$differenz = strtotime($result['BestellEndzeit']) - strtotime($result['BestellStartzeit']);

				$stringLabels = $stringLabels . "'" . $result['BestellungsID'] . "'" . ',';
				$stringData = $stringData . $differenz . ',';

				$stringTakt = $stringTakt . $result['Takt'] . ',';

				if($i == 0) {
					$stringBackgroundColor = $stringBackgroundColor . "'rgba(255, 99, 132, 0.2)',";
					$stringBorderColor = $stringBorderColor . "'rgba(255, 99, 132, 1)',";
				}
				else if($i == 1) {
					$stringBackgroundColor = $stringBackgroundColor . "'rgba(54, 162, 235, 0.2)',";
					$stringBorderColor = $stringBorderColor . "'rgba(54, 162, 235, 1)',";
				}
				else if($i == 2) {
					$stringBackgroundColor = $stringBackgroundColor . "'rgba(255, 206, 86, 0.2)',";
					$stringBorderColor = $stringBorderColor . "'rgba(255, 206, 86, 1)',";
				}

			}

		}

		//Das letzte Komma abtrennen
		$stringLabels = trim($stringLabels,",");
		$stringData = trim($stringData, ",");
		$stringBackgroundColor = trim($stringBackgroundColor, ",");
		$stringBorderColor = trim($stringBorderColor, ",");
		$stringTakt = trim($stringTakt, ",");


		echo "datasets: [{label: 'Bestellungen', data: [$stringData], backgroundColor: [$stringBackgroundColor], borderColor: [$stringBorderColor], borderWidth: 1, order: 1}, { label: 'Takt', data: [$stringTakt], type: 'line', backgroundColor: 'rgba(153, 102, 255, 0.2)', borderColor: 'rgba(153, 102, 255, 1)', borderWidth: 1, order: 2}], labels: [$stringLabels]";

	}

	//Diese Methode gibt die Durchschnittslaufzeit der einzelnen Arbeitsstationen aus und formatiert sie in json.
	function mixedChartDurchschnittslaufzeitArbeitsstationen() {

		$arraySpielIDs = holeAnalyticsSpielIDs();

		$anzahlSpielIDs = count($arraySpielIDs);

		$stringLabels = "'AP 1', 'AP 2', 'AP 3', 'AP 4', 'AP 5', 'Qualität'";
		$stringDataSpiel1 = "";
		$stringDataSpiel2 = "";
		$stringDataSpiel3 = "";

		$arrayZeitenStation1 = [];
		$arrayZeitenStation2 = [];
		$arrayZeitenStation3 = [];
		$arrayZeitenStation4 = [];
		$arrayZeitenStation5 = [];
		$arrayZeitenQuality = [];

		$spielName1 = "";
		$spielName2 = "";
		$spielName3 = "";

		for($i = 0; $i < $anzahlSpielIDs; $i++) {

			$query = abfrageDB("SELECT b.Produktionsleiter_timestamp, b.Station1_timestamp, b.Station2_timestamp, b.Station3_timestamp, b.Station4_timestamp, b.Station5_timestamp, b.Quality_timestamp, s.Bezeichnung FROM bestellungen b INNER JOIN spiel s ON b.SpielID = s.SpielID WHERE b.StatusKunde = 1 AND b.SpielID = '" . $arraySpielIDs[$i] . "'"); 

			
			while($result = mysqli_fetch_array($query)) {

				//Differenz der Zeiten berechnen
				$differenzStation1 = strtotime($result['Station1_timestamp']) - strtotime($result['Produktionsleiter_timestamp']);
				$differenzStation2 = strtotime($result['Station2_timestamp']) - strtotime($result['Produktionsleiter_timestamp']);
				$differenzStation3 = strtotime($result['Station3_timestamp']) - strtotime($result['Produktionsleiter_timestamp']);
				$differenzStation4 = strtotime($result['Station4_timestamp']) - strtotime($result['Produktionsleiter_timestamp']);
				$differenzStation5 = strtotime($result['Station5_timestamp']) - strtotime($result['Produktionsleiter_timestamp']);
				$differenzQuality = strtotime($result['Quality_timestamp']) - strtotime($result['Produktionsleiter_timestamp']);


				//Die errechnet Differenz muss größer als 0 sein. Ist Sie kleiner als 0, weil z.B. ein Teilprodukt nicht zuende gebaut wurde aber trotzdem ausgeliefert wurde, wird er einfach nicht berücksichtigt, da sonst der Graph ins negative rutscht.
				if($differenzStation1 > 0) {
					//Alle Zeiten in Array zwischenspeichern
					array_push($arrayZeitenStation1, $differenzStation1);
				}
				if($differenzStation2 > 0) {
					//Alle Zeiten in Array zwischenspeichern
					array_push($arrayZeitenStation2, $differenzStation2);
				} 
				if($differenzStation3 > 0) {
					//Alle Zeiten in Array zwischenspeichern
					array_push($arrayZeitenStation3, $differenzStation3);
				} 
				if($differenzStation4 > 0) {
					//Alle Zeiten in Array zwischenspeichern
					array_push($arrayZeitenStation4, $differenzStation4);
				} 
				if($differenzStation5 > 0) {
					//Alle Zeiten in Array zwischenspeichern
					array_push($arrayZeitenStation5, $differenzStation5);
				} 
				if($differenzQuality > 0) {
					//Alle Zeiten in Array zwischenspeichern
					array_push($arrayZeitenQuality, $differenzQuality);
				}

				//nur erste berücksichtigte Produktionsperiode/ Spiel
				if($i == 0) {

					$spielName1 = $result['Bezeichnung'];

				}
				//nur zweite berücksichtigte Produktionsperiode/ Spiel
				else if($i == 1) {

					$spielName2 = $result['Bezeichnung'];

				}
				//nur dritte berücksichtigte Produktionsperiode/ Spiel
				else if($i == 2) {

					$spielName3 = $result['Bezeichnung'];

				}


			}

			 

			$durchschnittStation1 = round(array_sum($arrayZeitenStation1) / count($arrayZeitenStation1), 0);
			$durchschnittStation2 = round(array_sum($arrayZeitenStation2) / count($arrayZeitenStation2), 0);
			$durchschnittStation3 = round(array_sum($arrayZeitenStation3) / count($arrayZeitenStation3), 0);
			$durchschnittStation4 = round(array_sum($arrayZeitenStation4) / count($arrayZeitenStation4), 0);
			$durchschnittStation5 = round(array_sum($arrayZeitenStation5) / count($arrayZeitenStation5), 0);
			$durchschnittQuality = round(array_sum($arrayZeitenQuality) / count($arrayZeitenQuality), 0);

			//nur erste berücksichtigte Produktionsperiode/ Spiel
			if($i == 0) {

				$stringDataSpiel1 = $stringDataSpiel1 . $durchschnittStation1 . ', ' . $durchschnittStation2 . ', ' . $durchschnittStation3 . ', ' . $durchschnittStation4 . ', ' . $durchschnittStation5 . ', ' . $durchschnittQuality . ', ';

			}
			//nur zweite berücksichtigte Produktionsperiode/ Spiel
			else if($i == 1) {

				$stringDataSpiel2 = $stringDataSpiel2 . $durchschnittStation1 . ', ' . $durchschnittStation2 . ', ' . $durchschnittStation3 . ', ' . $durchschnittStation4 . ', ' . $durchschnittStation5 . ', ' . $durchschnittQuality . ', ';

			}
			//nur dritte berücksichtigte Produktionsperiode/ Spiel
			else if($i == 2) {

				$stringDataSpiel3 = $stringDataSpiel3 . $durchschnittStation1 . ', ' . $durchschnittStation2 . ', ' . $durchschnittStation3 . ', ' . $durchschnittStation4 . ', ' . $durchschnittStation5 . ', ' . $durchschnittQuality . ', ';

			}

			

		}

		//Das letzte Komma abtrennen
		$stringDataSpiel1 = trim($stringDataSpiel1, ",");
		$stringDataSpiel2 = trim($stringDataSpiel2, ",");
		$stringDataSpiel3 = trim($stringDataSpiel3, ",");


		//Wenn nur ein Spiel zur Ansicht ausgewählt wurde
		if($anzahlSpielIDs == 1) {

			echo "datasets: [{
		           	label: '$spielName1',
		            data: [$stringDataSpiel1],
		            backgroundColor: [
		            	'rgba(255, 99, 132, 0.2)',
		            	'rgba(255, 99, 132, 0.2)',
		            	'rgba(255, 99, 132, 0.2)',
		            	'rgba(255, 99, 132, 0.2)',
		            	'rgba(255, 99, 132, 0.2)',
		            	'rgba(255, 99, 132, 0.2)'
		            ],
		            borderColor: [
		            	'rgba(255, 99, 132, 1)',
		                'rgba(255, 99, 132, 1)',
		                'rgba(255, 99, 132, 1)',
		                'rgba(255, 99, 132, 1)',
		                'rgba(255, 99, 132, 1)',
		                'rgba(255, 99, 132, 1)'
		            ],
		            borderWidth: 1,
		            order: 1
		        }],
		        labels: ['AP 1', 'AP 2', 'AP 3', 'AP 4', 'AP 5', 'Qualität']";

		}
		//Wenn zwei Spiele zur Ansicht augewählt wurden
		if($anzahlSpielIDs == 2) {

			echo "datasets: [{
		           	label: '$spielName1',
		            data: [$stringDataSpiel1],
		            backgroundColor: [
		            	'rgba(255, 99, 132, 0.2)',
		            	'rgba(255, 99, 132, 0.2)',
		            	'rgba(255, 99, 132, 0.2)',
		            	'rgba(255, 99, 132, 0.2)',
		            	'rgba(255, 99, 132, 0.2)',
		            	'rgba(255, 99, 132, 0.2)'
		            ],
		            borderColor: [
		            	'rgba(255, 99, 132, 1)',
		                'rgba(255, 99, 132, 1)',
		                'rgba(255, 99, 132, 1)',
		                'rgba(255, 99, 132, 1)',
		                'rgba(255, 99, 132, 1)',
		                'rgba(255, 99, 132, 1)'
		            ],
		            borderWidth: 1,
		            order: 1
		        }, {
		        	label: '$spielName2',
		            data: [$stringDataSpiel2],
		            backgroundColor: [
		            	'rgba(54, 162, 235, 0.2)',
		            	'rgba(54, 162, 235, 0.2)',
		            	'rgba(54, 162, 235, 0.2)',
		            	'rgba(54, 162, 235, 0.2)',
		            	'rgba(54, 162, 235, 0.2)',
		            	'rgba(54, 162, 235, 0.2)'
		            ],
		            borderColor: [
		            	'rgba(54, 162, 235, 1)',
		            	'rgba(54, 162, 235, 1)',
		            	'rgba(54, 162, 235, 1)',
		            	'rgba(54, 162, 235, 1)',
		            	'rgba(54, 162, 235, 1)',
		            	'rgba(54, 162, 235, 1)'
		            ],
		            borderWidth: 1,
		            order: 1
		        }],
		        labels: ['AP 1', 'AP 2', 'AP 3', 'AP 4', 'AP 5', 'Qualität']";

		}
		//Wenn alle 3 Spiele zur Ansicht ausgewählt wurden
		if($anzahlSpielIDs == 3) {

			echo "datasets: [{
		           	label: '$spielName1',
		            data: [$stringDataSpiel1],
		            backgroundColor: [
		            	'rgba(255, 99, 132, 0.2)',
		            	'rgba(255, 99, 132, 0.2)',
		            	'rgba(255, 99, 132, 0.2)',
		            	'rgba(255, 99, 132, 0.2)',
		            	'rgba(255, 99, 132, 0.2)',
		            	'rgba(255, 99, 132, 0.2)'
		            ],
		            borderColor: [
		            	'rgba(255, 99, 132, 1)',
		                'rgba(255, 99, 132, 1)',
		                'rgba(255, 99, 132, 1)',
		                'rgba(255, 99, 132, 1)',
		                'rgba(255, 99, 132, 1)',
		                'rgba(255, 99, 132, 1)'
		            ],
		            borderWidth: 1,
		            order: 1
		        }, {
		        	label: '$spielName2',
		            data: [$stringDataSpiel2],
		            backgroundColor: [
		            	'rgba(54, 162, 235, 0.2)',
		            	'rgba(54, 162, 235, 0.2)',
		            	'rgba(54, 162, 235, 0.2)',
		            	'rgba(54, 162, 235, 0.2)',
		            	'rgba(54, 162, 235, 0.2)',
		            	'rgba(54, 162, 235, 0.2)'
		            ],
		            borderColor: [
		            	'rgba(54, 162, 235, 1)',
		            	'rgba(54, 162, 235, 1)',
		            	'rgba(54, 162, 235, 1)',
		            	'rgba(54, 162, 235, 1)',
		            	'rgba(54, 162, 235, 1)',
		            	'rgba(54, 162, 235, 1)'
		            ],
		            borderWidth: 1,
		            order: 1
		        },
		        {
		            label: '$spielName3',
		            data: [$stringDataSpiel3],
		            backgroundColor: [
		            	'rgba(255, 206, 86, 0.2)',
		            	'rgba(255, 206, 86, 0.2)',
		            	'rgba(255, 206, 86, 0.2)',
		            	'rgba(255, 206, 86, 0.2)',
		            	'rgba(255, 206, 86, 0.2)',
		            	'rgba(255, 206, 86, 0.2)'
		            ],
		            borderColor: [
		            	'rgba(255, 206, 86, 1)',
		            	'rgba(255, 206, 86, 1)',
		            	'rgba(255, 206, 86, 1)',
		            	'rgba(255, 206, 86, 1)',
		            	'rgba(255, 206, 86, 1)',
		            	'rgba(255, 206, 86, 1)'
		            ],
		            borderWidth: 1,
		            order: 1
		        }],
		        labels: ['AP 1', 'AP 2', 'AP 3', 'AP 4', 'AP 5', 'Qualität']";

		}

		
		

	}

	//Diese Methode gibt die Anzahl der Retouren in json-Formatierung aus.
	function barChartRetouren() {

		$arraySpielIDs = holeAnalyticsSpielIDs();

		$anzahlSpielIDs = count($arraySpielIDs);

		$stringLabels = "'Qualitätskontrolle', 'Kunden'";
		$stringDataSpiel1 = "";
		$stringDataSpiel2 = "";
		$stringDataSpiel3 = "";

		$spielName1 = "";
		$spielName2 = "";
		$spielName3 = "";

		for($i = 0; $i < $anzahlSpielIDs; $i++) {

			$queryAnzahlRetouren = abfrageDB("SELECT SUM(b.AnzahlRetoureQuality), SUM(b.AnzahlRetoureKunde), s.Bezeichnung FROM bestellungen b INNER JOIN spiel s ON b.SpielID = s.SpielID WHERE b.SpielID = '" . $arraySpielIDs[$i] . "'");

			while($resultAnzahlRetouren = mysqli_fetch_array($queryAnzahlRetouren)) {

				if($i == 0) {
					$stringDataSpiel1 = $resultAnzahlRetouren[0] . ", " . $resultAnzahlRetouren[1];
					$spielName1 = $resultAnzahlRetouren['Bezeichnung'];
				}
				else if($i == 1) {
					$stringDataSpiel2 = $resultAnzahlRetouren[0] . ", " . $resultAnzahlRetouren[1];
					$spielName2 = $resultAnzahlRetouren['Bezeichnung'];
				}
				else if($i == 2) {
					$stringDataSpiel3 = $resultAnzahlRetouren[0] . ", " . $resultAnzahlRetouren[1];
					$spielName3 = $resultAnzahlRetouren['Bezeichnung'];
				}

			}

		}

		//Wenn nur ein Spiel zur Ansicht ausgewählt wurde
		if($anzahlSpielIDs == 1) {

			echo "datasets: [{
		           	label: '$spielName1',
		            data: [$stringDataSpiel1],
		            backgroundColor: 'rgba(255, 99, 132, 0.2)',
		            borderColor: 'rgba(255, 99, 132, 1)',
		            borderWidth: 1,
		            order: 1
		        }],
		        labels: [$stringLabels]";

		}
		//Wenn zwei Spiele zur Ansicht augewählt wurden
		if($anzahlSpielIDs == 2) {

			echo "datasets: [{
		           	label: '$spielName1',
		            data: [$stringDataSpiel1],
		            backgroundColor: 'rgba(255, 99, 132, 0.2)',
		            borderColor: 'rgba(255, 99, 132, 1)',
		            borderWidth: 1,
		            order: 1
		        }, 
		        {
		            label: '$spielName2',
		            data: [$stringDataSpiel2],
		            backgroundColor: 'rgba(54, 162, 235, 0.2)',
		            borderColor: 'rgba(54, 162, 235, 1)',
		            borderWidth: 1,
		            order: 2
		        }],
		        labels: [$stringLabels]";

		}
		//Wenn alle 3 Spiele zur Ansicht ausgewählt wurden
		if($anzahlSpielIDs == 3) {

			echo "datasets: [{
		           	label: '$spielName1',
		            data: [$stringDataSpiel1],
		            backgroundColor: 'rgba(255, 99, 132, 0.2)',
		            borderColor: 'rgba(255, 99, 132, 1)',
		            borderWidth: 1,
		            order: 1
		        }, 
		        {
		            label: '$spielName2',
		            data: [$stringDataSpiel2],
		            backgroundColor: 'rgba(54, 162, 235, 0.2)',
		            borderColor: 'rgba(54, 162, 235, 1)',
		            borderWidth: 1,
		            order: 2
		        },
		        {
		            label: '$spielName3',
		            data: [$stringDataSpiel3],
		            backgroundColor: 'rgba(255, 206, 86, 0.2)',
		            borderColor: 'rgba(255, 206, 86, 1)',
		            borderWidth: 1,
		            order: 2
		        }],
		        labels: [$stringLabels]";

		}



	}

	//Diese Methode liest die Anzahl der Hilfsanforderungen an den Meister und Produktionsleiter aus und formatiert es in json.
	function barChartHilfsanforderungenMeisterProduktionsleiter() {

		$arraySpielIDs = holeAnalyticsSpielIDs();

		$anzahlSpielIDs = count($arraySpielIDs);

		$stringLabels = "'Meister', 'Produktionsleiter'";
		$stringDataSpiel1 = "";
		$stringDataSpiel2 = "";
		$stringDataSpiel3 = "";

		$spielName1 = "";
		$spielName2 = "";
		$spielName3 = "";

		for($i = 0; $i < $anzahlSpielIDs; $i++) {

			$queryAnzahlHilfe = abfrageDB("SELECT s.AnzahlHilfeStation1, s.AnzahlHilfeStation2, s.AnzahlHilfeStation3, s.AnzahlHilfeStation4, s.AnzahlHilfeStation5, s.AnzahlHilfeQuality, s.AnzahlHilfeLogistik, s.AnzahlHilfeMeister, s.Bezeichnung FROM spiel s WHERE s.SpielID = '" . $arraySpielIDs[$i] . "'");

			while($resultAnzahlHilfe = mysqli_fetch_array($queryAnzahlHilfe)) {

				$anzahlMeister = $resultAnzahlHilfe['AnzahlHilfeStation1'] + $resultAnzahlHilfe['AnzahlHilfeStation2'] + $resultAnzahlHilfe['AnzahlHilfeStation3'] + $resultAnzahlHilfe['AnzahlHilfeStation4'] + $resultAnzahlHilfe['AnzahlHilfeStation5'];

				$anzahlProduktionsleiter = $resultAnzahlHilfe['AnzahlHilfeQuality'] + $resultAnzahlHilfe['AnzahlHilfeLogistik'] + $resultAnzahlHilfe['AnzahlHilfeMeister'];

				if($i == 0) {
					$stringDataSpiel1 = $anzahlMeister . ", " . $anzahlProduktionsleiter;
					$spielName1 = $resultAnzahlHilfe['Bezeichnung'];
				}
				else if($i == 1) {
					$stringDataSpiel2 = $anzahlMeister . ", " . $anzahlProduktionsleiter;
					$spielName2 = $resultAnzahlHilfe['Bezeichnung'];
				}
				else if($i == 2) {
					$stringDataSpiel3 = $anzahlMeister . ", " . $anzahlProduktionsleiter;
					$spielName3 = $resultAnzahlHilfe['Bezeichnung'];
				}

			}



		}

		//Wenn nur ein Spiel zur Ansicht ausgewählt wurde
		if($anzahlSpielIDs == 1) {

			echo "datasets: [{
		           	label: '$spielName1',
		            data: [$stringDataSpiel1],
		            backgroundColor: 'rgba(255, 99, 132, 0.2)',
		            borderColor: 'rgba(255, 99, 132, 1)',
		            borderWidth: 1,
		            order: 1
		        }],
		        labels: [$stringLabels]";

		}
		//Wenn zwei Spiele zur Ansicht augewählt wurden
		if($anzahlSpielIDs == 2) {

			echo "datasets: [{
		           	label: '$spielName1',
		            data: [$stringDataSpiel1],
		            backgroundColor: 'rgba(255, 99, 132, 0.2)',
		            borderColor: 'rgba(255, 99, 132, 1)',
		            borderWidth: 1,
		            order: 1
		        }, 
		        {
		            label: '$spielName2',
		            data: [$stringDataSpiel2],
		            backgroundColor: 'rgba(54, 162, 235, 0.2)',
		            borderColor: 'rgba(54, 162, 235, 1)',
		            borderWidth: 1,
		            order: 2
		        }],
		        labels: [$stringLabels]";

		}
		//Wenn alle 3 Spiele zur Ansicht ausgewählt wurden
		if($anzahlSpielIDs == 3) {

			echo "datasets: [{
		           	label: '$spielName1',
		            data: [$stringDataSpiel1],
		            backgroundColor: 'rgba(255, 99, 132, 0.2)',
		            borderColor: 'rgba(255, 99, 132, 1)',
		            borderWidth: 1,
		            order: 1
		        }, 
		        {
		            label: '$spielName2',
		            data: [$stringDataSpiel2],
		            backgroundColor: 'rgba(54, 162, 235, 0.2)',
		            borderColor: 'rgba(54, 162, 235, 1)',
		            borderWidth: 1,
		            order: 2
		        },
		        {
		            label: '$spielName3',
		            data: [$stringDataSpiel3],
		            backgroundColor: 'rgba(255, 206, 86, 0.2)',
		            borderColor: 'rgba(255, 206, 86, 1)',
		            borderWidth: 1,
		            order: 2
		        }],
		        labels: [$stringLabels]";

		}


		


	}

	//Diese Methode liefert die Hilfsanforderungen der einzelnen Stationen in json formatiert.
	function barChartHilfsanforderungenStationen() {

		$arraySpielIDs = holeAnalyticsSpielIDs();

		$anzahlSpielIDs = count($arraySpielIDs);

		$stringLabels = "'AP 1', 'AP 2', 'AP 3', 'AP 4', 'AP 5', 'Qualität', 'Logistik', 'Meister'";
		$stringDataSpiel1 = "";
		$stringDataSpiel2 = "";
		$stringDataSpiel3 = "";

		$spielName1 = "";
		$spielName2 = "";
		$spielName3 = "";

		for($i = 0; $i < $anzahlSpielIDs; $i++) {

			$queryAnzahlHilfe = abfrageDB("SELECT s.AnzahlHilfeStation1, s.AnzahlHilfeStation2, s.AnzahlHilfeStation3, s.AnzahlHilfeStation4, s.AnzahlHilfeStation5, s.AnzahlHilfeQuality, s.AnzahlHilfeLogistik, s.AnzahlHilfeMeister, s.Bezeichnung FROM spiel s WHERE s.SpielID = '" . $arraySpielIDs[$i] . "'");

			while($resultAnzahlHilfe = mysqli_fetch_array($queryAnzahlHilfe)) {

				if($i == 0) {
					$stringDataSpiel1 = $resultAnzahlHilfe['AnzahlHilfeStation1'] . "," . $resultAnzahlHilfe['AnzahlHilfeStation2']  . "," . $resultAnzahlHilfe['AnzahlHilfeStation3'] . "," . $resultAnzahlHilfe['AnzahlHilfeStation4'] . "," . $resultAnzahlHilfe['AnzahlHilfeStation5'] . "," . $resultAnzahlHilfe['AnzahlHilfeQuality'] . "," . $resultAnzahlHilfe['AnzahlHilfeLogistik'] . "," . $resultAnzahlHilfe['AnzahlHilfeMeister'];
					$spielName1 = $resultAnzahlHilfe['Bezeichnung'];
				}
				else if($i == 1) {
					$stringDataSpiel2 = $resultAnzahlHilfe['AnzahlHilfeStation1'] . "," . $resultAnzahlHilfe['AnzahlHilfeStation2']  . "," . $resultAnzahlHilfe['AnzahlHilfeStation3'] . "," . $resultAnzahlHilfe['AnzahlHilfeStation4'] . "," . $resultAnzahlHilfe['AnzahlHilfeStation5'] . "," . $resultAnzahlHilfe['AnzahlHilfeQuality'] . "," . $resultAnzahlHilfe['AnzahlHilfeLogistik'] . "," . $resultAnzahlHilfe['AnzahlHilfeMeister'];
					$spielName2 = $resultAnzahlHilfe['Bezeichnung'];
				}
				else if($i == 2) {
					$stringDataSpiel3 = $resultAnzahlHilfe['AnzahlHilfeStation1'] . "," . $resultAnzahlHilfe['AnzahlHilfeStation2']  . "," . $resultAnzahlHilfe['AnzahlHilfeStation3'] . "," . $resultAnzahlHilfe['AnzahlHilfeStation4'] . "," . $resultAnzahlHilfe['AnzahlHilfeStation5'] . "," . $resultAnzahlHilfe['AnzahlHilfeQuality'] . "," . $resultAnzahlHilfe['AnzahlHilfeLogistik'] . "," . $resultAnzahlHilfe['AnzahlHilfeMeister'];
					$spielName3 = $resultAnzahlHilfe['Bezeichnung'];
				}

			}



		}

		//Wenn nur ein Spiel zur Ansicht ausgewählt wurde
		if($anzahlSpielIDs == 1) {

			echo "datasets: [{
		           	label: '$spielName1',
		            data: [$stringDataSpiel1],
		            backgroundColor: 'rgba(255, 99, 132, 0.2)',
		            borderColor: 'rgba(255, 99, 132, 1)',
		            borderWidth: 1,
		            order: 1
		        }],
		        labels: [$stringLabels]";

		}
		//Wenn zwei Spiele zur Ansicht augewählt wurden
		if($anzahlSpielIDs == 2) {

			echo "datasets: [{
		           	label: '$spielName1',
		            data: [$stringDataSpiel1],
		            backgroundColor: 'rgba(255, 99, 132, 0.2)',
		            borderColor: 'rgba(255, 99, 132, 1)',
		            borderWidth: 1,
		            order: 1
		        }, 
		        {
		            label: '$spielName2',
		            data: [$stringDataSpiel2],
		            backgroundColor: 'rgba(54, 162, 235, 0.2)',
		            borderColor: 'rgba(54, 162, 235, 1)',
		            borderWidth: 1,
		            order: 2
		        }],
		        labels: [$stringLabels]";

		}
		//Wenn alle 3 Spiele zur Ansicht ausgewählt wurden
		if($anzahlSpielIDs == 3) {

			echo "datasets: [{
		           	label: '$spielName1',
		            data: [$stringDataSpiel1],
		            backgroundColor: 'rgba(255, 99, 132, 0.2)',
		            borderColor: 'rgba(255, 99, 132, 1)',
		            borderWidth: 1,
		            order: 1
		        }, 
		        {
		            label: '$spielName2',
		            data: [$stringDataSpiel2],
		            backgroundColor: 'rgba(54, 162, 235, 0.2)',
		            borderColor: 'rgba(54, 162, 235, 1)',
		            borderWidth: 1,
		            order: 2
		        },
		        {
		            label: '$spielName3',
		            data: [$stringDataSpiel3],
		            backgroundColor: 'rgba(255, 206, 86, 0.2)',
		            borderColor: 'rgba(255, 206, 86, 1)',
		            borderWidth: 1,
		            order: 2
		        }],
		        labels: [$stringLabels]";

		}

	}

	//Diese Methode liest die Erfolgsrate der Spiele aus der Datenbank aus und gibt als json formatiert ist.
	function lineChartErfolgsrateSpiele() {


		$arraySpielIDs = holeAnalyticsSpielIDs();

		$anzahlSpielIDs = count($arraySpielIDs);

		$stringLabels = "";
		$stringData = "";

		for($i = 0; $i < $anzahlSpielIDs; $i++) {

			$queryAnzahlAbgeschlosseneBestellungen = abfrageDB("SELECT COUNT(BestellungsID) FROM bestellungen WHERE StatusKunde = '1' AND SpielID = '" . $arraySpielIDs[$i] . "'");

			$queryAnzahlAlleBestellungen = abfrageDB("SELECT COUNT(BestellungsID) FROM bestellungen WHERE SpielID = '" . $arraySpielIDs[$i] . "'");

			$spielID = $arraySpielIDs[$i];			
			$queryHoleSpielNamen = abfrageDB("SELECT Bezeichnung FROM spiel WHERE SpielID = '" . $spielID . "'");

			$resultAnzahlAbgeschlosseneBestellungen = mysqli_fetch_array($queryAnzahlAbgeschlosseneBestellungen);
			$resultAnzahlAlleBestellungen = mysqli_fetch_array($queryAnzahlAlleBestellungen);
			$resultHoleSpielNamen = mysqli_fetch_array($queryHoleSpielNamen);

			if($resultAnzahlAlleBestellungen[0] > 0) {
				$erfolgsrate = round(($resultAnzahlAbgeschlosseneBestellungen[0] / $resultAnzahlAlleBestellungen[0]) * 100, 0);
			}

			$stringData = $stringData . $erfolgsrate . ", ";
			$stringLabels = $stringLabels . "'" .$resultHoleSpielNamen[0] . "',";
		}

		//Das letzte Komma abtrennen
		$stringData = trim($stringData, ",");
		$stringLabels = trim($stringLabels, ",");

		echo "datasets: [{
					label:  'Erfolgsrate in %',
					data: [$stringData],
					backgroundColor: 'rgba(54, 162, 235, 0.2)',
		            borderColor: 'rgba(54, 162, 235, 1)',
		            borderWidth: 1
				}],
				labels: [$stringLabels]";

	}

	//Diese Methode liest die Arbeitsstationenprodukitvität aus der Datenbank und gibt es in json-Formatierung aus.
	function barChartArbeitsstationenProduktivitaet() {

		$arraySpielIDs = holeAnalyticsSpielIDs();

		$anzahlSpielIDs = count($arraySpielIDs);

		$stringLabels = "'AP 1', 'AP 2', 'AP 3', 'AP 4', 'AP 5', 'Qualität'";
		$stringDataSpiel1 = "";
		$stringDataSpiel2 = "";
		$stringDataSpiel3 = "";

		$spielName1 = "";
		$spielName2 = "";
		$spielName3 = "";

		for($i = 0; $i < $anzahlSpielIDs; $i++) {


			for($z = 1; $z <= 6; $z++) {

				$queryProduktMenge = abfrageDB("SELECT COUNT(BestellungsID) FROM bestellungen  WHERE " . statusStation($z) . " = '1' AND SpielID = '" . $arraySpielIDs[$i] . "'");

				$queryGesamtzeit = abfrageDB("SELECT SpielStartzeit, SpielEndzeit FROM spiel WHERE SpielID = '" . holeSpielID() . "'");

				$resultProduktMenge = mysqli_fetch_array($queryProduktMenge);
				$resultGesamtzeit = mysqli_fetch_array($queryGesamtzeit);

				$endZeit = 0;

				//Wenn das Spiel noch nicht abgeschlossen ist, gibt es keine Endzeit. Dann soll er die aktuelle Zeit nehmen um die Produktivität in diesem Moment zu messen
				if($resultGesamtzeit['SpielEndzeit'] == 0) {

					//Wandelt in Timestamp um
					$endZeit = strtotime(date('Y-m-d H:i:s'));

				} else {

					//Wandelt in Timestamp um
					$endZeit = strtotime($resultGesamtzeit['SpielEndzeit']);

				}

				$gesamtZeit = round(($endZeit - strtotime($resultGesamtzeit['SpielStartzeit'])) / 60, 2);

				$arbeitsstationenprod = ($resultProduktMenge[0] / $gesamtZeit);

				//nur erste berücksichtigte Produktionsperiode/ Spiel
				if($i == 0) {

					$stringDataSpiel1 = $stringDataSpiel1 . $arbeitsstationenprod . ", ";

				}
				//nur zweite berücksichtigte Produktionsperiode/ Spiel
				else if($i == 1) {

					$stringDataSpiel2 = $stringDataSpiel2 . $arbeitsstationenprod . ", ";

				}
				//nur dritte berücksichtigte Produktionsperiode/ Spiel
				else if($i == 2) {

					$stringDataSpiel3 = $stringDataSpiel3 . $arbeitsstationenprod . ", ";

				}

			}

			$querySpielBezeichnung = abfrageDB("SELECT s.Bezeichnung FROM spiel s WHERE s.SpielID = '" . $arraySpielIDs[$i] . "'");

			$resultSpielBezeichnung = mysqli_fetch_array($querySpielBezeichnung);

			//nur erste berücksichtigte Produktionsperiode/ Spiel
			if($i == 0) {

				$spielName1 = $resultSpielBezeichnung['Bezeichnung'];

			}
			//nur zweite berücksichtigte Produktionsperiode/ Spiel
			else if($i == 1) {

				$spielName2 = $resultSpielBezeichnung['Bezeichnung'];

			}
			//nur dritte berücksichtigte Produktionsperiode/ Spiel
			else if($i == 2) {

				$spielName3 = $resultSpielBezeichnung['Bezeichnung'];
			}


			

		}

		//Das letzte Komma abtrennen
		$stringDataSpiel1 = trim($stringDataSpiel1, ",");
		$stringDataSpiel2 = trim($stringDataSpiel2, ",");
		$stringDataSpiel3 = trim($stringDataSpiel3, ",");

		//Wenn nur ein Spiel zur Ansicht ausgewählt wurde
		if($anzahlSpielIDs == 1) {

			echo "datasets: [{
		           	label: '$spielName1',
		            data: [$stringDataSpiel1],
		            backgroundColor: 'rgba(255, 99, 132, 0.2)',
		            borderColor: 'rgba(255, 99, 132, 1)',
		            borderWidth: 1,
		            order: 1
		        }],
		        labels: [$stringLabels]";

		}
		//Wenn zwei Spiele zur Ansicht augewählt wurden
		if($anzahlSpielIDs == 2) {

			echo "datasets: [{
		           	label: '$spielName1',
		            data: [$stringDataSpiel1],
		            backgroundColor: 'rgba(255, 99, 132, 0.2)',
		            borderColor: 'rgba(255, 99, 132, 1)',
		            borderWidth: 1,
		            order: 1
		        }, 
		        {
		            label: '$spielName2',
		            data: [$stringDataSpiel2],
		            backgroundColor: 'rgba(54, 162, 235, 0.2)',
		            borderColor: 'rgba(54, 162, 235, 1)',
		            borderWidth: 1,
		            order: 2
		        }],
		        labels: [$stringLabels]";

		}
		//Wenn alle 3 Spiele zur Ansicht ausgewählt wurden
		if($anzahlSpielIDs == 3) {

			echo "datasets: [{
		           	label: '$spielName1',
		            data: [$stringDataSpiel1],
		            backgroundColor: 'rgba(255, 99, 132, 0.2)',
		            borderColor: 'rgba(255, 99, 132, 1)',
		            borderWidth: 1,
		            order: 1
		        }, 
		        {
		            label: '$spielName2',
		            data: [$stringDataSpiel2],
		            backgroundColor: 'rgba(54, 162, 235, 0.2)',
		            borderColor: 'rgba(54, 162, 235, 1)',
		            borderWidth: 1,
		            order: 2
		        },
		        {
		            label: '$spielName3',
		            data: [$stringDataSpiel3],
		            backgroundColor: 'rgba(255, 206, 86, 0.2)',
		            borderColor: 'rgba(255, 206, 86, 1)',
		            borderWidth: 1,
		            order: 2
		        }],
		        labels: [$stringLabels]";

		}


				

	}

	//Diese Methode liest die Logik für das Chart Anzahl Bestellungen der EndProdukte aus der Datenbank und gibt in json-Formatierung aus.
	function barChartAnzahlBestellungenEndProdukte() {

		$arraySpielIDs = holeAnalyticsSpielIDs();

		$anzahlSpielIDs = count($arraySpielIDs);

		$stringLabels = "'Blau I', 'Gelb I', 'Grün I', 'Rot I', 'Lila I', 'Orange I', 'Blau II', 'Gelb II', 'Grün II', 'Rot II', 'Lila II', 'Orange II'";
		$stringDataSpiel1 = "";
		$stringDataSpiel2 = "";
		$stringDataSpiel3 = "";

		$spielName1 = "";
		$spielName2 = "";
		$spielName3 = "";

		for($i = 0; $i < $anzahlSpielIDs; $i++) {


			for($z = 1; $z <= 12; $z++) {

				$queryAnzahlEndProdukte = abfrageDB("SELECT COUNT(b.EndProduktID)FROM bestellungen b WHERE b.endProduktID = '" . $z . "' AND b.SpielID = '" . $arraySpielIDs[$i] . "'");

				$resultAnzahlEndProdukte = mysqli_fetch_array($queryAnzahlEndProdukte);

				//nur erste berücksichtigte Produktionsperiode/ Spiel
				if($i == 0) {

					$stringDataSpiel1 = $stringDataSpiel1 . $resultAnzahlEndProdukte[0] . ", ";

				}
				//nur zweite berücksichtigte Produktionsperiode/ Spiel
				else if($i == 1) {

					$stringDataSpiel2 = $stringDataSpiel2 . $resultAnzahlEndProdukte[0] . ", ";

				}
				//nur dritte berücksichtigte Produktionsperiode/ Spiel
				else if($i == 2) {

					$stringDataSpiel3 = $stringDataSpiel3 . $resultAnzahlEndProdukte[0] . ", ";

				}

			}

			$querySpielBezeichnung = abfrageDB("SELECT s.Bezeichnung FROM spiel s WHERE s.SpielID = '" . $arraySpielIDs[$i] . "'");

			$resultSpielBezeichnung = mysqli_fetch_array($querySpielBezeichnung);

			//nur erste berücksichtigte Produktionsperiode/ Spiel
			if($i == 0) {

				$spielName1 = $resultSpielBezeichnung['Bezeichnung'];

			}
			//nur zweite berücksichtigte Produktionsperiode/ Spiel
			else if($i == 1) {

				$spielName2 = $resultSpielBezeichnung['Bezeichnung'];

			}
			//nur dritte berücksichtigte Produktionsperiode/ Spiel
			else if($i == 2) {

				$spielName3 = $resultSpielBezeichnung['Bezeichnung'];
			}


			

		}

		//Das letzte Komma abtrennen
		$stringDataSpiel1 = trim($stringDataSpiel1, ",");
		$stringDataSpiel2 = trim($stringDataSpiel2, ",");
		$stringDataSpiel3 = trim($stringDataSpiel3, ",");

		//Wenn nur ein Spiel zur Ansicht ausgewählt wurde
		if($anzahlSpielIDs == 1) {

			echo "datasets: [{
		           	label: '$spielName1',
		            data: [$stringDataSpiel1],
		            backgroundColor: 'rgba(255, 99, 132, 0.2)',
		            borderColor: 'rgba(255, 99, 132, 1)',
		            borderWidth: 1,
		            order: 1
		        }],
		        labels: [$stringLabels]";

		}
		//Wenn zwei Spiele zur Ansicht augewählt wurden
		if($anzahlSpielIDs == 2) {

			echo "datasets: [{
		           	label: '$spielName1',
		            data: [$stringDataSpiel1],
		            backgroundColor: 'rgba(255, 99, 132, 0.2)',
		            borderColor: 'rgba(255, 99, 132, 1)',
		            borderWidth: 1,
		            order: 1
		        }, 
		        {
		            label: '$spielName2',
		            data: [$stringDataSpiel2],
		            backgroundColor: 'rgba(54, 162, 235, 0.2)',
		            borderColor: 'rgba(54, 162, 235, 1)',
		            borderWidth: 1,
		            order: 2
		        }],
		        labels: [$stringLabels]";

		}
		//Wenn alle 3 Spiele zur Ansicht ausgewählt wurden
		if($anzahlSpielIDs == 3) {

			echo "datasets: [{
		           	label: '$spielName1',
		            data: [$stringDataSpiel1],
		            backgroundColor: 'rgba(255, 99, 132, 0.2)',
		            borderColor: 'rgba(255, 99, 132, 1)',
		            borderWidth: 1,
		            order: 1
		        }, 
		        {
		            label: '$spielName2',
		            data: [$stringDataSpiel2],
		            backgroundColor: 'rgba(54, 162, 235, 0.2)',
		            borderColor: 'rgba(54, 162, 235, 1)',
		            borderWidth: 1,
		            order: 2
		        },
		        {
		            label: '$spielName3',
		            data: [$stringDataSpiel3],
		            backgroundColor: 'rgba(255, 206, 86, 0.2)',
		            borderColor: 'rgba(255, 206, 86, 1)',
		            borderWidth: 1,
		            order: 2
		        }],
		        labels: [$stringLabels]";

		}

		

	}







	




	





	

	


















	/*ALTER STAFF, KANN WAHRSCHEINLICH GELÖSCHT WERDEN*/


	/*

	function steinstatus($stationsnummer) {


		if(bestellungenVorhanden() == "true"){

		echo "	<tr class='table-row'>
				<td class='table-header'>Steintyp</td>
				<td class='table-header'>Anzahl</td>
				</tr>";

				//abfrageDB("SELECT b.EndProduktID, COUNT(b.EndProduktID), ts.SteinID, ts.AnzahlSteine, s.SteinBezeichnung from bestellungen b INNER Join endprodukt_teilprodukt et ON b.EndProduktID = et.EndProduktID INNER Join teilprodukt_steine ts ON et.TeilProduktID = ts.TeilProduktID INNER Join steine s ON s.SteinID = ts.SteinID WHERE b.SpielID = '" . holeSpielID() . "' AND et.StationsID = '" . $stationsnummer . "' GROUP by b.EndProduktID ");

		//Alle Enprodukte und die Anzahl wird abgefragt
		$sqlendprodukte = abfrageDB("SELECT EndProduktID, COUNT(EndProduktID) FROM bestellungen  WHERE SpielID = '" . holeSpielID() . "' GROUP BY EndProduktID");
		while($resultendprodukte = mysqli_fetch_array($sqlendprodukte)) {
			
			//TeilproduktID ermitteln, um den Steinbedarf zu ermitteln
			$sqlteilprodukte  = abfrageDB("SELECT TeilProduktID FROM endprodukt_teilprodukt WHERE StationsID = '" . $stationsnummer . "' AND endproduktID = '" . $resultendprodukte[0] ."'");
			while($resultteilprodukte = mysqli_fetch_array($sqlteilprodukte)) {
				//Mit der TeilproduktID wird die SteinID und die Anzahl der Steine von dem Teilprodukt ermitteln
				$querysteinID = abfrageDB("SELECT SteinID, AnzahlSteine FROM teilprodukt_steine WHERE TeilProduktID = '" . $resultteilprodukte[0] . "'");



				while($resultsteininfo = mysqli_fetch_array($querysteinID)) {

					$Steinbeschreibung = abfrageDB("SELECT SteinBezeichnung from steine WHERE SteinID = '" . $resultsteininfo[0] ."'");

					$resultsteinbeschreibung = mysqli_fetch_array($Steinbeschreibung);

					//Speichern in mehrdemensinalem Array (Stationsnummer/SteinID/Steinbeschreibung = Steinanzahl)
					if(isset($geladeneSteine[$stationsnummer][$resultsteininfo[0]][$resultsteinbeschreibung[0]])){


						$geladeneSteine[$stationsnummer][$resultsteininfo[0]][$resultsteinbeschreibung[0]] = $geladeneSteine[$stationsnummer][$resultsteininfo[0]][$resultsteinbeschreibung[0]] + ($resultsteininfo[1]* $resultendprodukte[1]);
					}
					else {

						$geladeneSteine[$stationsnummer][$resultsteininfo[0]][$resultsteinbeschreibung[0]]= ($resultsteininfo[1] * $resultendprodukte[1]);

					}
				}
			}

		}

								//Ausgabe des kompletten mehrdemensionalen Arrays
								//print_r($geladeneSteine);

									/*	foreach ($geladeneSteine as $nr => $inhalt)
									{
									    $resultsteinbeschreibung[$nr]  = ( $inhalt['SteinID'] );
									    $resultsteininfo[$nr]   = ( $inhalt['Anzahl'] );
									    echo "<br>";
									    echo $resultsteinbeschreibung[0];
									    echo "<br>";
									    echo $resultsteininfo[0];
									}*//*

		foreach ($geladeneSteine as $key1 => $value1) {
			foreach ($value1 as $key2 => $value2) {
				foreach ($value2 as $key3) {
						//echo "Station " . $key1 . " ";
						//echo "SteinID " . holeSteinBezeichnung($key2) . " ";
						//echo "Anzahl " . $key3 . "<br>";

					//Key 1: Station, key2 SteinID, key2 ist verbrachte Steine

						$SteinanzahlStation = anlieferungstatus($stationsnummer, $key2)  - $key3;
					if( $SteinanzahlStation <= 10) {
						echo "	<tr class='table-row'>
								<td class='table-cell'>" .  holeSteinBezeichnung($key2) ."</td>
								<td class='table-cell status-red'>" . $SteinanzahlStation ."</td>
								</tr>";


								//Hier Steinanzahl ändern, die bestellt wird, wenn die Steine unter 20 Steine sind (3. parameter)

								erstelleNeueAnlieferung($key2, $stationsnummer, 35);

					}
					else if( $SteinanzahlStation <= 20) {
						echo "	<tr class='table-row'>
								<td class='table-cell'>" .  holeSteinBezeichnung($key2) ."</td>
								<td class='table-cell status-orange'>" . $SteinanzahlStation ."</td>
								</tr>";


								//Hier Steinanzahl ändern, die bestellt wird, wenn die Steine unter 20 Steine sind (3. parameter)

								erstelleNeueAnlieferung($key2, $stationsnummer, 20);
					}
					else {
						echo "	<tr class='table-row'>
								<td class='table-cell'>" .  holeSteinBezeichnung($key2) ."</td>
								<td class='table-cell status-green'>" . $SteinanzahlStation ."</td>
								</tr>";

					}
												
				}
			}
		}

	}

}

	/*Ende Logistik*/


	/*function anlieferungstatus($stationsnummer, $SteinID) {


		$queryAngelieferteSteine = abfrageDB("SELECT SUM(AnzahlSteine) FROM anlieferungen WHERE StatusAnlieferung = '2' AND StationsID = '" .$stationsnummer."' AND SteinID = '" .$SteinID."' ");
		
		$resultanlieferungen = mysqli_fetch_array($queryAngelieferteSteine);

		
		
		return $resultanlieferungen[0];
			
	}*/

	




    

	


	/*function aktuelleAnlieferungenSlider() {

		$sqlAnlieferungen = abfrageDB("SELECT AnlieferungsID, SteinID, AnzahlSteine, StationsID from anlieferungen  WHERE StatusAnlieferung = 0");

		while($resultAnlieferungen = mysqli_fetch_array($sqlAnlieferungen)) {	

		echo "	<div class='container-logistik-slider'>
				<div class='title'>Arbeitsplatz ". $resultAnlieferungen[3] . "<br>" . holeSteinBezeichnung($resultAnlieferungen[1]) ."</div>
				<img class='image-logistik-slider' src='" . holeSteinBild($resultAnlieferungen[1]) ."'/>
				<div class='logistik-anzahl'>Anzahl ". $resultAnlieferungen[2] ."</div>
				<button class='button-logistik-slider' id='btn" . $resultAnlieferungen[0] . "' onclick ='UpdateAnlieferungFertig(" . $resultAnlieferungen[0] . ")'>Annehmen</button>
				</div>"	;
		
		}

	}*/


	
	/*function aktuelleAnlieferungeninBearbeitungSlider() {

		$sqlAnlieferungen = abfrageDB("SELECT AnlieferungsID, SteinID, AnzahlSteine, StationsID from anlieferungen  WHERE StatusAnlieferung = 1");

		while($resultAnlieferungen = mysqli_fetch_array($sqlAnlieferungen)) {	

		echo "	<div class='container-logistik-slider container-logistik-slider-bearbeitung'>
				<div class='title'>Arbeitsplatz ". $resultAnlieferungen[3] . "<br>" . holeSteinBezeichnung($resultAnlieferungen[1]) ."</div>
				<img class='image-logistik-slider' src='" . holeSteinBild($resultAnlieferungen[1]) ."'/>
				<div class='logistik-anzahl'>Anzahl ". $resultAnlieferungen[2] ."</div>
				<button class='button-logistik-slider'  id='btn" . $resultAnlieferungen[0] . "' onclick='UpdateAnlieferungBearbeitung(" . $resultAnlieferungen[0] . ")' >Angeliefert</button>
				</div>"	;
		
		}

	}*/


	





	



	
?>