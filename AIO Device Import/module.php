<?php
declare(strict_types=1);

require_once(__DIR__ . "/../bootstrap.php");
require_once __DIR__ . '/../libs/ProfileHelper.php';
require_once __DIR__ . '/../libs/ConstHelper.php';

use Fonzo\Mediola\AIOGateway;

class AIOImport extends IPSModule
{
	private const NEO = 1; // AIO Creator NEO
	private const CREATOR = 2; // AIO Creator
	private const BARTHELME = "{7D7F8917-195F-E373-C4A8-CE04A0EDCA4C}"; // Barthelme
	private const BECKERCENTRONIC = "{2A7246B6-45C1-B1FE-F83F-7B236751A57D}"; // Becker Centronic
	private const BRENNENSTUHL = "{FA4B17DE-D93D-B79E-A23C-16DBE6532CF8}"; // Brennenstuhl
	private const CONRADRSL = "{85634A3C-A962-06DD-9786-3E9715F9C299}"; // Conrad RSL
	private const DOOYA = "{BFD0DE8E-5A3C-458C-828B-C26B53220B8C}"; // Dooya
	private const ELERO = "{2525C553-31BB-B796-81CE-0349F91BBCD3}"; // Elero
	private const ELRO = "{1B755DCC-7F12-4136-8D14-2ED86E6609B7}"; // Elro
	private const ENOCEAN = "{3374E1BD-2E55-B2D8-D340-62190D6FD711}"; // EnOcean
	private const FHT = "{ADACCFBE-941D-0436-07B6-5819C9AC9F4F}"; // FHT80B
	private const FS20 = "{8C7554CA-2530-4E6B-98DB-AC59CD6215A6}"; // FS20
	private const GREENTEQ = "{264F6A46-D193-935E-F365-65E1B9DFA5A4}"; // Greenteq
	private const HOMEEASY = "{28F6C31B-E3B4-3B44-2317-3FCEFAC80181}"; // HOMEEasy
	private const HOMEMATIC = "{BDADB57D-564E-0A1A-6791-BD6C0C0DEF5C}"; // Homematic
	private const INSTABUS = "{CE1FF157-8689-895A-3971-2602FAA246CC}"; // Instabus
	private const INTERNORM = "{B2E280E8-D707-F0DB-C075-95A4B8106FC8}"; // Internorm
	private const INTERTECHNO = "{C45FF6B3-92E9-4930-B722-0A6193C7FFB5}"; // Intertechno
	private const IRDEVICE = "{4B0D8167-2932-4AD0-8455-26DC0C74485C}"; // IR
	private const KAISERNIENHAUS = "{FFC21213-9DFD-C5CD-BBAD-ACF9CECA2F85}"; // Kaiser Nienhaus
	private const KOPPFREECONTROL = "{747DF394-4E87-61EE-E0C6-9DBFA2846232}"; // Kopp Free Control
	private const LIGHT1 = "{488F8C6E-9448-44AD-8015-DF9DAD3232F3}"; // Lightmanager 1
	private const LIGHT2 = "{12E05C8F-C409-4061-8838-492744227EFF}"; // Lightmanager 2
	private const NUEVA = "{73DC9B3A-E551-1D20-703E-0AD4C390A984}"; // Nueva
	private const PCA = "{E5469C47-6030-4E1E-AD86-E25F664F03BD}"; // PCA-301
	private const RFDEVICE = "{8BFB0E47-BA7E-44B3-A8DE-95243B3DB186}"; // RF Device
	private const SCHALK = "{40955866-5582-0FFC-4753-7AE62DF253DE}"; // Schalk	FX3
	private const SOMFY = "{0F83D875-4737-4244-8234-4CF08E6F2626}"; // Somfy RTS
	private const SYSTEQ = "{C6C87B42-5CB3-9529-3796-5A845A3081D0}"; // systeQ
	private const WAREMA = "{4829E1AC-C87A-95AA-848F-A28C3DBF3561}"; // Warema
	private const WIR = "{44106CC3-2D39-EEB3-ECF2-B9C1B75BBC4B}"; // WIR

	public function Create()
	{
		//Never delete this line!
		parent::Create();

		// 1. Verfügbarer AIOSplitter wird verbunden oder neu erzeugt, wenn nicht vorhanden.
		$this->ConnectParent("{7E03C651-E5BF-4EC6-B1E8-397234992DB4}");

		$this->RegisterPropertyString("directory", "webfront/user/neo/");
		$this->RegisterAttributeString("ircodes", "");
		$this->RegisterAttributeString("devices", "");
        $this->RegisterPropertyString('mac', '');
        $this->RegisterPropertyString('model', '');
        $this->RegisterPropertyString('version', '');
		$this->RegisterPropertyString("Configuration_" . $this->GetModuleIdent(self::BARTHELME), "");
		$this->RegisterPropertyString("Configuration_" . $this->GetModuleIdent(self::BECKERCENTRONIC), "");
		$this->RegisterPropertyString("Configuration_" . $this->GetModuleIdent(self::BRENNENSTUHL), "");
		$this->RegisterPropertyString("Configuration_" . $this->GetModuleIdent(self::CONRADRSL), "");
		$this->RegisterPropertyString("Configuration_" . $this->GetModuleIdent(self::DOOYA), "");
		$this->RegisterPropertyString("Configuration_" . $this->GetModuleIdent(self::ELERO), "");
		$this->RegisterPropertyString("Configuration_" . $this->GetModuleIdent(self::ELRO), "");
		$this->RegisterPropertyString("Configuration_" . $this->GetModuleIdent(self::ENOCEAN), "");
		$this->RegisterPropertyString("Configuration_" . $this->GetModuleIdent(self::FHT), "");
		$this->RegisterPropertyString("Configuration_" . $this->GetModuleIdent(self::FS20), "");
		$this->RegisterPropertyString("Configuration_" . $this->GetModuleIdent(self::GREENTEQ), "");
		$this->RegisterPropertyString("Configuration_" . $this->GetModuleIdent(self::HOMEEASY), "");
		$this->RegisterPropertyString("Configuration_" . $this->GetModuleIdent(self::HOMEMATIC), "");
		$this->RegisterPropertyString("Configuration_" . $this->GetModuleIdent(self::INSTABUS), "");
		$this->RegisterPropertyString("Configuration_" . $this->GetModuleIdent(self::INTERNORM), "");
		$this->RegisterPropertyString("Configuration_" . $this->GetModuleIdent(self::INTERTECHNO), "");
		$this->RegisterPropertyString("Configuration_" . $this->GetModuleIdent(self::IRDEVICE), "");
		$this->RegisterPropertyString("Configuration_" . $this->GetModuleIdent(self::KAISERNIENHAUS), "");
		$this->RegisterPropertyString("Configuration_" . $this->GetModuleIdent(self::KOPPFREECONTROL), "");
		$this->RegisterPropertyString("Configuration_" . $this->GetModuleIdent(self::LIGHT1), "");
		$this->RegisterPropertyString("Configuration_" . $this->GetModuleIdent(self::LIGHT2), "");
		$this->RegisterPropertyString("Configuration_" . $this->GetModuleIdent(self::NUEVA), "");
		$this->RegisterPropertyString("Configuration_" . $this->GetModuleIdent(self::PCA), "");
		$this->RegisterPropertyString("Configuration_" . $this->GetModuleIdent(self::RFDEVICE), "");
		$this->RegisterPropertyString("Configuration_" . $this->GetModuleIdent(self::SCHALK), "");
		$this->RegisterPropertyString("Configuration_" . $this->GetModuleIdent(self::SOMFY), "");
		$this->RegisterPropertyString("Configuration_" . $this->GetModuleIdent(self::SYSTEQ), "");
		$this->RegisterPropertyString("Configuration_" . $this->GetModuleIdent(self::WAREMA), "");
		$this->RegisterPropertyString("Configuration_" . $this->GetModuleIdent(self::WIR), "");
		$this->RegisterPropertyString("device_db", "");
		$this->RegisterPropertyInteger('device_selection', -1);
		$this->RegisterPropertyInteger("Version", 0);
		$this->RegisterPropertyInteger("ImportCategoryID", 0);
		$this->RegisterPropertyBoolean("RoomImport", false);

		$this->RegisterAttributeString($this->GetModuleIdent(self::BARTHELME), "[]");
		$this->RegisterAttributeString($this->GetModuleIdent(self::BECKERCENTRONIC), "[]");
		$this->RegisterAttributeString($this->GetModuleIdent(self::BRENNENSTUHL), "[]");
		$this->RegisterAttributeString($this->GetModuleIdent(self::CONRADRSL), "[]");
		$this->RegisterAttributeString($this->GetModuleIdent(self::DOOYA), "[]");
		$this->RegisterAttributeString($this->GetModuleIdent(self::ELERO), "[]");
		$this->RegisterAttributeString($this->GetModuleIdent(self::ELRO), "[]");
		$this->RegisterAttributeString($this->GetModuleIdent(self::ENOCEAN), "[]");
		$this->RegisterAttributeString($this->GetModuleIdent(self::FHT), "[]");
		$this->RegisterAttributeString($this->GetModuleIdent(self::FS20), "[]");
		$this->RegisterAttributeString($this->GetModuleIdent(self::GREENTEQ), "[]");
		$this->RegisterAttributeString($this->GetModuleIdent(self::HOMEEASY), "[]");
		$this->RegisterAttributeString($this->GetModuleIdent(self::HOMEMATIC), "[]");
		$this->RegisterAttributeString($this->GetModuleIdent(self::INSTABUS), "[]");
		$this->RegisterAttributeString($this->GetModuleIdent(self::INTERNORM), "[]");
		$this->RegisterAttributeString($this->GetModuleIdent(self::INTERTECHNO), "[]");
		$this->RegisterAttributeString($this->GetModuleIdent(self::IRDEVICE), "[]");
		$this->RegisterAttributeString($this->GetModuleIdent(self::KAISERNIENHAUS), "[]");
		$this->RegisterAttributeString($this->GetModuleIdent(self::KOPPFREECONTROL), "[]");
		$this->RegisterAttributeString($this->GetModuleIdent(self::LIGHT1), "[]");
		$this->RegisterAttributeString($this->GetModuleIdent(self::LIGHT2), "[]");
		$this->RegisterAttributeString($this->GetModuleIdent(self::NUEVA), "[]");
		$this->RegisterAttributeString($this->GetModuleIdent(self::PCA), "[]");
		$this->RegisterAttributeString($this->GetModuleIdent(self::RFDEVICE), "[]");
		$this->RegisterAttributeString($this->GetModuleIdent(self::SCHALK), "[]");
		$this->RegisterAttributeString($this->GetModuleIdent(self::SOMFY), "[]");
		$this->RegisterAttributeString($this->GetModuleIdent(self::SYSTEQ), "[]");
		$this->RegisterAttributeString($this->GetModuleIdent(self::WAREMA), "[]");
		$this->RegisterAttributeString($this->GetModuleIdent(self::WIR), "[]");
		$this->RegisterAttributeString("Rooms", "[]");
        $this->RegisterAttributeString("AIOGateways", "[]");

	}

	public function ApplyChanges()
	{
		//Never delete this line!
		parent::ApplyChanges();

		$this->ValidateConfiguration();


	}

	/**
	 * Die folgenden Funktionen stehen automatisch zur Verfügung, wenn das Modul über die "Module Control" eingefügt wurden.
	 * Die Funktionen werden, mit dem selbst eingerichteten Prefix, in PHP und JSON-RPC wiefolgt zur Verfügung gestellt:
	 *
	 * PUBLIC
	 */

	private function ValidateConfiguration()
	{
		//Version
		$Version = $this->ReadPropertyInteger('Version');

		if ($Version == 1) {
			$ircodes = $this->ReadAttributeString('ircodes');
			$devices = $this->ReadAttributeString('devices');
			if ($ircodes == "") {
				// Status Error Felder dürfen nicht leer sein
				$this->SetStatus(204);
			}
			if ($devices == "") {
				// Status Error Felder dürfen nicht leer sein
				$this->SetStatus(205);
			}
		} else {
			$device_db = $this->ReadPropertyString('device_db');
			if ($device_db == "") {
				// Status Error Felder dürfen nicht leer sein
				$this->SetStatus(203);
			}
		}


		//Import Kategorie
		$ImportCategoryID = $this->ReadPropertyInteger('ImportCategoryID');
		if ($ImportCategoryID === 0) {
			// Status Error Kategorie zum Import auswählen
			$this->SetStatus(211);
		} elseif ($ImportCategoryID != 0) {
			$this->SetStatus(IS_ACTIVE);
		}
	}


	protected function GetParent()
	{
		$instance = IPS_GetInstance($this->InstanceID);//array
		return ($instance['ConnectionID'] > 0) ? $instance['ConnectionID'] : false;//ConnectionID
	}


	//IP Gateway 
	protected function GetIPGateway()
	{
		$ParentID = $this->GetParent();
		$IPGateway = IPS_GetProperty($ParentID, 'Host');
		return $IPGateway;
	}


	//Homematic Instanz erstellen 
	public function HomematicCreateInstance(string $InstName, string $Ident, string $HomematicAddress, string $HomematicData, string $HomematicSNR, string $HomematicType, int $CategoryID)
	{
		//Prüfen ob Instanz schon existiert
		$InstanzID = @IPS_GetObjectIDByIdent($Ident, $CategoryID);
		//$InstanzID = @IPS_GetInstanceIDByName($InstName, $CategoryID);
		if ($InstanzID === false) {
			//echo "Instanz nicht gefunden!";
			$HomematicTypeName = $this->GetHomematicTypeName($HomematicType);
			if ($HomematicType == "00AC") // powerswitch
			{
				//Neue Instanz anlegen
				$InstanzID = IPS_CreateInstance("{484B3E98-4395-4E65-A0D3-BDEE013A4B1A}");
			} elseif ($HomematicType == "0066") // switch
			{
				//Neue Instanz anlegen
				$InstanzID = IPS_CreateInstance("{562CC7AE-0BD7-4C97-9E5B-0C9D6DD73F40}");
			} elseif ($HomematicType == "0095") // thermocontrol
			{
				//Neue Instanz anlegen
				$InstanzID = IPS_CreateInstance("{9CA28339-2DCB-4295-9C22-EBCDE6025052}");
			} elseif ($HomematicType == "00F4") // sensor RGB Controller
			{
				//Neue Instanz anlegen
				$InstanzID = IPS_CreateInstance("{54E09F68-FE44-4E09-9E4B-B66D20CB970E}");
			}
			IPS_SetName($InstanzID, $InstName); // Instanz benennen
			IPS_SetIdent($InstanzID, $Ident); // Ident
			IPS_SetParent($InstanzID, $CategoryID); // Instanz einsortieren unter dem Objekt mit der ID "$CategoryID"
			IPS_SetProperty($InstanzID, "HomematicAddress", $HomematicAddress); // HomematicAddress setzten.
			IPS_SetProperty($InstanzID, "HomematicData", $HomematicData); // HomematicData setzten.
			IPS_SetProperty($InstanzID, "HomematicSNR", $HomematicSNR); // HomematicSNR setzten.
			IPS_SetProperty($InstanzID, "HomematicType", $HomematicType); // HomematicType setzten.
			IPS_SetProperty($InstanzID, "HomematicTypeName", $HomematicTypeName); // HomematicTypeName setzten.
			IPS_ApplyChanges($InstanzID); //Neue Konfiguration übernehmen
			IPS_LogMessage("Instanz erstellt:", "Name: " . $InstName);
			return $InstanzID;
		} else {
			//echo "Die Instanz-ID lautet: ". $InstanzID;
			return $InstanzID;
		}
	}

	protected function GetHomematicTypeName($HomematicType)
	{
		$HomematicTypeName = false;
		if ($HomematicType == "003D") {
			$HomematicTypeName = "HM-WDS10-TH-O";
			// Beschreibung outdoor radio-controlled temperature/humidity sensor
			// Gerät Kleine Wetterstation
		} elseif ($HomematicType == "003F") {
			$HomematicTypeName = "HM-WDS40-TH-I";
			// Beschreibung indoor radio-controlled temperature and humidty sensor
			// Gerät Kleine Wetterstation
		} elseif ($HomematicType == "0045") {
			$HomematicTypeName = "HM-Sec-WDS";
			// Beschreibung radio-controlled water detection sensor
			// Gerät Water detection
		} elseif ($HomematicType == "0005") {
			$HomematicTypeName = "HM-LC-Bl1-FM";
			// Beschreibung radio-controlled blind actuator 1-channel (flush-mount)
			// Gerät Blind
		} elseif ($HomematicType == "0011") {
			$HomematicTypeName = "HM-LC-Sw1-Pl";
			// Beschreibung radio-controlled socket adapter switch actuator 1-channel
			// Gerät Switch
		} elseif ($HomematicType == "0042") {
			$HomematicTypeName = "HM-Sec-SD";
			// Beschreibung radio-controlled smoke detector
			// Gerät Smoke Sensor
		} elseif ($HomematicType == "0030") {
			$HomematicTypeName = "HM-Sec-RHS";
			// Beschreibung Rotary Handle Sensor
			// Gerät Window
		} elseif ($HomematicType == "0095") {
			$HomematicTypeName = "HM-CC-RT-DN";
		} elseif ($HomematicType == "00AD") {
			$HomematicTypeName = "HM-TC-IT-WM-W-EU";
		} elseif ($HomematicType == "0039") {
			$HomematicTypeName = "HM-CC-TC";
			// Beschreibung ClimateControl-ThermoControl
			// Gerät FHT
		} elseif ($HomematicType == "0009") {
			$HomematicTypeName = "HM-LC-Sw2-FM";
			// Beschreibung radio-controlled switch actuator 2-channel
			// Gerät Switch
		} elseif ($HomematicType == "0004") {
			$HomematicTypeName = "HM-LC-Sw1-FM";
			// Beschreibung radio-controlled switch actuator 1-channel (flush-mount)
			// Gerät Switch
		} elseif ($HomematicType == "002F") {
			$HomematicTypeName = "HM-Sec-SC";
			// Beschreibung Shutter Contact
			// Gerät contact
		} elseif ($HomematicType == "00B1") {
			$HomematicTypeName = "HM-Sec-SC-2";
			// Beschreibung Shutter Contact
			// Gerät contact
		} elseif ($HomematicType == "0013") {
			$HomematicTypeName = "HM-LC-Dim1L-Pl";
			// Beschreibung radio-controlled socket adapter 1-channel leading edge
			// Gerät dimmer
		} elseif ($HomematicType == "0069") {
			$HomematicTypeName = "HM-LC-Sw1PBU-FM";
		} elseif ($HomematicType == "0068") {
			$HomematicTypeName = "HM-LC-Dim1TPBU-FM";
		} elseif ($HomematicType == "006A") {
			$HomematicTypeName = "HM-LC-Bl1PBU-FM";
		} elseif ($HomematicType == "0040") {
			$HomematicTypeName = "HM-WDS100-C6-O";
			// Beschreibung radio-controlled weather data senor (OC3)
			// Gerät Große Wetterstation
		} elseif ($HomematicType == "00AC") {
			$HomematicTypeName = "HM-ES-PMSw1-PI";
			// Beschreibung Powerswitch
			// Gerät Powerswitch
		} elseif ($HomematicType == "0066") {
			$HomematicTypeName = "HM-LC-Sw4-WM";
			// Beschreibung 4 Kanal Aktor
			// Gerät Switch
		} elseif ($HomematicType == "00F4") {
			$HomematicTypeName = "HM-LC-RGBW-WM";
			// Beschreibung sensor RGB Controller
			// Gerät RGB
		}

		return $HomematicTypeName;
	}


	public function GetDatabase()
	{
		// get file
		$device_db = base64_decode($this->ReadPropertyString('device_db'));
		// convert the string to a json object
		$data_json = json_decode($device_db);
		return $data_json;
	}


	private function GetDeviceType($device_guid)
	{
		$device_types = $this->DeviceTypes();
		$key = array_key_exists($device_guid, $device_types);
		$device_type = false;
		if($key)
		{
			$device_type = $device_types[$device_guid]["device_type"];
		}
		return $device_type;
	}

	private function GetSubtype($device_guid)
	{
		$device_types = $this->DeviceTypes();
		$key = array_key_exists($device_guid, $device_types);
		$subtype = false;
		if($key)
		{
			$subtype = $device_types[$device_guid]["subtype"];
		}
		return $subtype;
	}

	private function DeviceTypes()
	{
		$device_types = [
			self::BARTHELME => ["device_type" => "CF4", "subtype" => "CF4", "alias" => "BARTHELME"],
			self::BECKERCENTRONIC => ["device_type" => "BK", "subtype" => "BK", "alias" => "BECKERCENTRONIC"],
			self::BRENNENSTUHL => ["device_type" => "", "subtype" => "", "alias" => "BRENNENSTUHL"],
			self::CONRADRSL => ["device_type" => "CR", "subtype" => "CR", "alias" => "CONRADRSL"],
			self::DOOYA => ["device_type" => "DY", "subtype" => "DY", "alias" => "DOOYA"],
			self::ELERO => ["device_type" => "ER", "subtype" => "ER", "alias" => "ELERO"],
			self::ELRO => ["device_type" => "ELRO", "subtype" => "ELRO", "alias" => "ELRO"],
			self::ENOCEAN => ["device_type" => "EO", "subtype" => "EO", "alias" => "ENOCEAN"],
			self::FHT => ["device_type" => "FHT80b", "subtype" => "FHT80b", "alias" => "FHT"],
			self::FS20 => ["device_type" => "FS20", "subtype" => "FS20", "alias" => "FS20"],
			self::GREENTEQ => ["device_type" => "GQ", "subtype" => "GQ", "alias" => "GREENTEQ"],
			self::HOMEEASY => ["device_type" => "", "subtype" => "", "alias" => "HOMEEASY"],
			self::HOMEMATIC => ["device_type" => "HM", "subtype" => "HM", "alias" => "HOMEMATIC"],
			self::INSTABUS => ["device_type" => "IA", "subtype" => "IA", "alias" => "INSTABUS"],
			self::INTERNORM => ["device_type" => "IN", "subtype" => "IN", "alias" => "INTERNORM"],
			self::INTERTECHNO => ["device_type" => "IT", "subtype" => "IT", "alias" => "INTERTECHNO"],
			self::IRDEVICE => ["device_type" => "CODE", "subtype" => "IR", "alias" => "IRDEVICE"],
			self::KAISERNIENHAUS => ["device_type" => "DY2", "subtype" => "DY2", "alias" => "KAISERNIENHAUS"],
			self::KOPPFREECONTROL => ["device_type" => "KOPP", "subtype" => "KOPP", "alias" => "KOPPFREECONTROL"],
			self::LIGHT1 => ["device_type" => "LEDS", "subtype" => "LED1", "alias" => "LIGHT1"],
			self::LIGHT2 => ["device_type" => "L2", "subtype" => "LED2", "alias" => "LIGHT2"],
			self::NUEVA => ["device_type" => "NTH", "subtype" => "NTH", "alias" => "NUEVA"],
			self::PCA => ["device_type" => "PE", "subtype" => "PE", "alias" => "PCA"],
			self::RFDEVICE => ["device_type" => "CODE", "subtype" => "RF", "alias" => "RFDEVICE"],
			self::SCHALK => ["device_type" => "FX3", "subtype" => "FX3", "alias" => "SCHALK"],
			self::SOMFY => ["device_type" => "RT", "subtype" => "RT", "alias" => "SOMFY"],
			self::SYSTEQ => ["device_type" => "QA", "subtype" => "QA", "alias" => "SYSTEQ"],
			self::WAREMA => ["device_type" => "", "subtype" => "", "alias" => "WAREMA"],
			self::WIR => ["device_type" => "WR", "subtype" => "WR", "alias" => "WIR"]
		];
		return $device_types;
	}

	private function GetDeviceImportList(string $device_guid)
	{
		$list = $this->ReadAttributeString($this->GetModuleIdent($device_guid));
		return $list;
	}

	private function GetRooms()
	{
		$rooms = $this->ReadAttributeString("Rooms");
		// $this->SendDebug("Rooms:", $rooms, 0);
		$rooms = json_decode($rooms, true);
		return $rooms;
	}

	private function GetRoomName($room_id)
	{
		$roomname = "";
		$rooms = $this->GetRooms();
		$roomname_exists = array_key_exists($room_id, $rooms);
		if($roomname_exists)
		{
			$roomname = $rooms[$room_id]["name"];
		}
		return $roomname;
	}

	public function GetAttribute(string $guid)
	{
		$content =$this->ReadAttributeString($this->GetModuleIdent($guid));
		return $content;
	}

	public function SetAttribute(string $guid, string $content)
	{
		$this->WriteAttributeString($this->GetModuleIdent($guid), $content);
	}

	public function Import()
	{
		$device_db = $this->ReadPropertyString('device_db');
		if ($device_db == "") {
			return false;
		}
		$this->SelectImport();
		return true;
	}

	private function SelectImport()
	{
		$Version = $this->ReadPropertyInteger('Version');
		//Datei nach Version einlesen
		$devices = false;
		if ($Version === self::NEO) {
			//NEO device_db JSON
			$this->SendDebug("Import:", "Start import from NEO Creator device.db", 0);
			$devices = $this->NEOJSONImport();
		} elseif ($Version === self::CREATOR) {
			//AIO Creator ircodes.xml, devices.xml
			$this->SendDebug("Import:", "Start import from AIO Creator", 0);
			$devices = $this->ImportCreator();
		}
		return $devices;
	}

	private function ImportCreator()
	{
		// get file
		$devices = base64_decode($this->ReadAttributeString('devices'));
		// Intertechno
		$type = $this->GetDeviceType(self::INTERTECHNO);
		$xml = new SimpleXMLElement($devices);
		foreach ($xml->xpath("//device[@type='" . $type . "']") as $device) {
			$address = $device['address'];
			$ITType =  ucfirst(strval($device['data']));
			$InstName = strval($device['id']);
			$Ident = str_replace(".", "", $address);
			$lengthaddress = strlen($address);
			$address_arr = explode(".", $address);
			$address = str_replace(".", "", $address);
			$ITFamilyCode = false;
			$ITDeviceCode = false;
			// Anpassen der Daten
			if ($lengthaddress == 3) // alter Code aus Buchstaben und Ziffer
			{
				$ITDeviceCode_import = strval($address_arr[1]);
				$ITDeviceCode_dec = hexdec($ITDeviceCode_import);
				$ITDeviceCode = strval($ITDeviceCode_dec + 1); // Devicecode auf Original umrechen +1
				$ITFamilyCode = $address_arr[0]; // Zahlencode in Buchstaben Familencode umwandeln
				$hexsend = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23);
				$itfc = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W");
				$ITFamilyCode = hexdec($ITFamilyCode);
				$ITFamilyCode = str_replace($hexsend, $itfc, $ITFamilyCode);
			} elseif ($lengthaddress == 9) //neuer Code
			{
				$ITDeviceCode = $address_arr[1]; // Devicecode
				$ITFamilyCode = $address_arr[0]; // Familencode
			}
			$this->SendDebug("AIO Import Intertechno:", "Device:  " . $InstName .", Address: ". json_encode($address).", Type: ". json_encode($type), 0);
			if($ITFamilyCode != false)
			{
				$array = $this->AddITDevicetoList($InstName, $Ident, $address, $ITFamilyCode, $ITDeviceCode, $type, $ITType, 0, "Intertecho");
				$this->SendDebug("AIO Import Intertechno:", "List:  " . json_encode($array), 0);
			}
		}
		// FS 20
		$type = $this->GetDeviceType(self::FS20);
		foreach ($xml->xpath("//device[@type='" . $type . "']") as $device) {
			$AIOFS20Adresse = strval($device['address']);
			$FS20Type = ucfirst(strval($device['data']));
			$InstName = strval($device['id']);
			$Ident = str_replace(".", "", $AIOFS20Adresse);
			$address = str_replace(".", "", $AIOFS20Adresse);
			$this->SendDebug("AIO Import FS20:", "Device:  " . $InstName .", Address: ".$address.", Type: ".$FS20Type, 0);
			$array = $this->AddDevicetoList(self::FS20, $InstName, $Ident, $address, $type, $FS20Type, 0, "FS20");
			$this->SendDebug("AIO Import FS20:", "List:  " . json_encode($array), 0);
		}
		// Somfy
		$type = $this->GetDeviceType(self::SOMFY);
		foreach ($xml->xpath("//device[@type='" . $type . "']") as $device) {
			$AIOSomfyAdresse = (string)$device['address'];
			$SomfyType = (string)$device['data'];
			$InstName = (string)$device['id'];

			// Anpassen der Daten
			$SomfyType = ucfirst($SomfyType); //erster Buchstabe groß
			$AIOSomfyAdresse = str_replace(".", "", $AIOSomfyAdresse);
			$this->SendDebug("AIO Import Somfy:", "Device:  " .$InstName .", Address: ".$AIOSomfyAdresse.", Type: ".$type, 0);
			$array = $this->AddDevicetoList(self::SOMFY, $InstName, "", $AIOSomfyAdresse, $type, $SomfyType, 0, "Somfy");
			$this->SendDebug("AIO Import Somfy:", "List:  " . json_encode($array), 0);
		}
		// ELRO
		$type = $this->GetDeviceType(self::ELRO);
		foreach ($xml->xpath("//device[@type='" . $type . "']") as $device) {
			$ELROAdresse = (string)$device['address'];
			$ELROType = ucfirst(strval($device['data']));
			$InstName = strval($device['id']);
			// Anpassen der Daten
			$ELROAdresse = str_replace(".", "", $ELROAdresse);
			$this->SendDebug("AIO Import ELRO:", "Device:  " . $InstName .", Address: ".$ELROAdresse.", Type: ".$type, 0);
			$array = $this->AddDevicetoList(self::ELRO, $InstName, "", $ELROAdresse, $type, $ELROType, 0, "ELRO");
			$this->SendDebug("AIO Import ELRO:", "List:  " . json_encode($array), 0);
		}
		// Light 1
		$type = $this->GetDeviceType(self::LIGHT1);
		foreach ($xml->xpath("//device[@type='" . $type . "']") as $device) {
			$LEDAdresse = strval($device['address']);
			$InstName = strval($device['id']);
			$this->SendDebug("AIO Import Lightmanager:", "Device:  " . $InstName .", Address: ".$LEDAdresse.", Type: ".$type, 0);
			$array = $this->AddDevicetoList(self::LIGHT1, $InstName, $LEDAdresse, $LEDAdresse, $type, "", 0, "Light Manager 1");
			$this->SendDebug("AIO Import Lightmanager:", "List:  " . json_encode($array), 0);
		}
		// Light 2
		$type = $this->GetDeviceType(self::LIGHT2);
		foreach ($xml->xpath("//device[@type='" . $type . "']") as $device) {
			$LEDAdresse = (string)$device['address'];
			$InstName = (string)$device['id'];
			$this->SendDebug("AIO Import Lightmanager 2:", "Device:  " . $InstName .", Address: ".$LEDAdresse.", Type: ".$type, 0);
			$array = $this->AddDevicetoList(self::LIGHT2, $InstName, $LEDAdresse, $LEDAdresse, $type, "", 0, "Light Manager 2");
			$this->SendDebug("AIO Import Lightmanager 2:", "List:  " . json_encode($array), 0);
		}
		// Homematic
		$type = $this->GetDeviceType(self::HOMEMATIC);
		foreach ($xml->xpath("//device[@type='" . $type . "']") as $device) {
			$HomematicAddress = strval($device['address']);
			$HomematicData = strval($device['data']);
			$InstName = strval($device['id']);
			$HomematicSNR = strval($device['snr']);
			$HomematicType = ucfirst(strval($device['typecode']));
			// Anpassen der Daten
			$HomematicAddress = str_replace(":", "", $HomematicAddress);
			$Ident = $HomematicSNR . "_" . substr($HomematicAddress, 0, 6);
			$list_homematic = $this->AddHMDevicetoList($InstName, $Ident, $HomematicAddress, $HomematicData, $HomematicSNR, $HomematicType, 0, "Homematic");
			$this->SendDebug("AIO Import Homematic:", "List:  " . json_encode($list_homematic), 0);
		}
		// RF
		// get file
		$ircodesxml = base64_decode($ircodes = $this->ReadAttributeString('ircodes'));
		$codes_xml = new SimpleXMLElement($ircodesxml);
		$ircodes = [];
		foreach ($codes_xml as $device) {
			$name = $device['id'];
			$i = 0;
			foreach($device as $key => $code)
			{
				$ircodes[$i][0] = strval($code['id']);
				$ircodes[$i][1] = strval($code['code']);
				$i++;
			}
			$this->SendDebug("AIO Import RF:", "Device:  " . $name .", Type: RF", 0);
			$array = $this->AddRFDevicetoList($name, "", "", "RF", $ircodes, $i, 0, "RF");
			$this->SendDebug("AIO Import RF:", "List:  " . json_encode($array), 0);
		}
		// IR
		$ircodes = [];
		foreach ($codes_xml as $device) {
			$name = $device['id'];
			$i = 0;
			foreach($device as $key => $code)
			{
				$ircodes[$i][0] = strval($code['id']);
				$ircodes[$i][1] = strval($code['code']);
				$i++;
			}
			$this->SendDebug("AIO Import IR:", "Device:  " . $name .", Type: IR", 0);
			$array = $this->AddIRDevicetoList($name, "", "", "IR", $ircodes, $i, 0, "IR");
			$this->SendDebug("AIO Import IR:", "List:  " . json_encode($array), 0);
		}
		return $devices;
	}

	protected function NEOJSONImport()
	{
		$this->SendDebug("Import:", "loading NEO device.db", 0);
		$data = $this->GetDatabase();
		$devices = $data->devices;
		$this->SendDebug("Import:", "finished reading device.db", 0);

		$this->SaveRooms($data);
        $this->SaveMediolaGateways($data);

		// copy the devices array to a php var
		//$devices = $json->devices;
		//$devicetype = $this->GetDeviceType($device_guid);
		//$subtype = $this->GetSubtype($device_guid);

		// listing devices
		foreach ($devices as $device) {
			$name = $device->name; //Device name
			$index = $device->index;
			$sys = $device->info->sys; //System
			$address = false;
			$subtype = false;
			//sys ist aio beim AIO Gateway und type IT (Intertechno), FS20, CODE (IR)oder (RF:01) , Lightmanager LEDS, L2, RT (Somfy),
			if ($sys == "aio" && isset($device->info->type)) {
				//$device_id = $device->info->id;
				$type = $device->info->type; //Type
				$room_id = $device->room;
				//$subtype = $device->info->type; //Subtype

					if (isset($device->info->address)) {
						$address = $device->info->address; //Adresse
						$addressparts = explode(":", $address);
						$subtype = $addressparts[0];
					}
				$this->SendDebug("AIO Import:", "Device:  " . utf8_decode($name). " (".$index."), Type: ". $type, 0);
					if (isset($device->info->data)) {
						$data = $device->info->data; //Switch / Dimmer / shutter
					}
					if (isset($device->info->address) && isset($device->info->data)) //Lightmanager hat keinen data typ
					{
						switch ($type) {
							case $this->GetDeviceType(self::FS20): // FS20
								$subtype = ucfirst($data); //erster Buchstabe groß
								$address = str_replace(".", "", $address);
								$this->SendDebug("AIO Import FS20:", "Device:  " . $name .", Address: ".$address.", Type: ".$subtype, 0);
								$array = $this->AddDevicetoList(self::FS20, $name, $index, $address, $type, $subtype, $room_id, "FS20");
								$this->SendDebug("AIO Import FS20:", "List:  " . json_encode($array), 0);
								break;
							case $this->GetDeviceType(self::INSTABUS): // Instabus
								$subtype = ucfirst($data); //erster Buchstabe groß
								$this->SendDebug("AIO Import Instabus:", "Device:  " . $name .", Address: ".$address.", Type: ".$subtype, 0);
								$array = $this->AddDevicetoList(self::INSTABUS, $name, $index, $address, $type, $subtype, $room_id, "Gira");
								$this->SendDebug("AIO Import Instabus:", "List:  " . json_encode($array), 0);
								break;
							case $this->GetDeviceType(self::SOMFY): // Somfy
								$type = $data;
								$this->SendDebug("AIO Import Somfy:", "Device:  " . $name .", Address: ".$address.", Type: ".$type, 0);
								$array = $this->AddDevicetoList(self::SOMFY, $name, $index, $address, $type, $subtype, $room_id, "Somfy");
								$this->SendDebug("AIO Import Somfy:", "List:  " . json_encode($array), 0);
								break;
                            case $this->GetDeviceType(self::DOOYA): // Dooya
                                $type = $data;
                                $this->SendDebug("AIO Import Dooya:", "Device:  " . $name .", Address: ".$address.", Type: ".$type, 0);
                                $array = $this->AddDevicetoList(self::DOOYA, $name, $index, $address, $type, $subtype, $room_id, "Dooya");
                                $this->SendDebug("AIO Import Dooya:", "List:  " . json_encode($array), 0);
                                break;
							case $this->GetDeviceType(self::ELRO): // ELRO
								$type = $data;
								$this->SendDebug("AIO Import ELRO:", "Device:  " . $name .", Address: ".$address.", Type: ".$type, 0);
								$array = $this->AddDevicetoList(self::ELRO, $name, $index, $address, $type, $subtype, $room_id, "ELRO");
								$this->SendDebug("AIO Import ELRO:", "List:  " . json_encode($array), 0);
								break;
							case $this->GetDeviceType(self::HOMEMATIC): // Homematic
								// Anpassen der Daten
/*
 * 	{
		"name": "Putzfrau zu",
		"room": 28,
		"info": {
			"sys": "hm",
			"id": "Putzfrau zu",
			"type": "HM-RC-Key3-B",
			"address": "JEQ0223760:1",
			"interface": "BidCos-RF",
			"channels": {
				"KEY": {
					"id": "Putzfrau zu",
					"address": "1",
					"room": ["Flur EG"],
					"group": "null",
					"datapoints": []
				}
			},
			"gateway": 12
		},
		"index": 103
	},
	{
		"name": "SA Arbeitszimmer",
		"room": 0,
		"info": {
			"sys": "hm",
			"id": "SA Arbeitszimmer",
			"type": "HmIP-BSM",
			"address": "000858A994D524",
			"interface": "HmIP-RF",
			"channels": {
				"MAINTENANCE": {
					"id": "SA Arbeitszimmer:0",
					"address": "0",
					"room": [],
					"group": ""
				},
				"SWITCH_TRANSMITTER": {
					"id": "HmIP-BSM 000858A994D524:3",
					"address": "3",
					"room": [],
					"group": ""
				},
				"SWITCH_VIRTUAL_RECEIVER:4": {
					"id": "SA Arbeitszimmer:4",
					"address": "4",
					"room": ["Büro"],
					"group": "Licht"
				},
				"SWITCH_VIRTUAL_RECEIVER:5": {
					"id": "HmIP-BSM 000858A994D524:5",
					"address": "5",
					"room": [],
					"group": ""
				},
				"SWITCH_VIRTUAL_RECEIVER:6": {
					"id": "HmIP-BSM 000858A994D524:6",
					"address": "6",
					"room": [],
					"group": ""
				},
				"ENERGIE_METER_TRANSMITTER": {
					"id": "SA Arbeitszimmer:7",
					"address": "7",
					"room": ["Büro"],
					"group": "Licht"
				}
			},
			"gateway": 12
		},
		"index": 104
	},
 */
								$HomematicData = $data;
								$HomematicSNR = $device->info->snr; // Seriennummer
								$HomematicType = $device->info->typecode; // Typencode
								// Anpassen der Daten
								//$HomematicType = ucfirst($HomematicType); //erster Buchstabe groß

								// $ident = $HomematicSNR . "_" . substr($HomematicAddress, 0, 6);
								$list_homematic = $this->AddHMDevicetoList($name, $index, $address, $HomematicData, $HomematicSNR, $HomematicType, $room_id, "Homematic");
								$this->SendDebug("AIO Import Homematic:", "List:  " . json_encode($list_homematic), 0);
								break;
							case $this->GetDeviceType(self::INTERTECHNO): //Intertechno
								$ITFamilyCode = false;
								$ITDeviceCode = false;
								// Anpassen der Daten
								$lengthaddress = strlen($address);
								$address_arr = explode(".", $address);
								$address = str_replace(".", "", $address);
								// Anpassen der Daten
								$ITType = ucfirst($data); //erster Buchstabe groß
								//$ident = $ITType . "_" . $device_id;
								if ($lengthaddress == 3) // alter Code aus Buchstaben und Ziffer
								{
									$ITDeviceCode_import = strval($address_arr[1]);
									$ITDeviceCode_dec = hexdec($ITDeviceCode_import);
									$ITDeviceCode = strval($ITDeviceCode_dec + 1); // Devicecode auf Original umrechen +1
									$ITFamilyCode = $address_arr[0]; // Zahlencode in Buchstaben Familencode umwandeln
									$hexsend = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23);
									$itfc = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W");
									$ITFamilyCode = hexdec($ITFamilyCode);
									$ITFamilyCode = str_replace($hexsend, $itfc, $ITFamilyCode);
								} elseif ($lengthaddress == 9) //neuer Code
								{
									$ITDeviceCode = $address_arr[1]; // Devicecode
									$ITFamilyCode = $address_arr[0]; // Familencode
								}
								$this->SendDebug("AIO Import Intertechno:", "Device:  " . json_encode($name) .", Address: ". json_encode($address).", Type: ". json_encode($type), 0);
								if($ITFamilyCode != false)
								{
									$array = $this->AddITDevicetoList($name, $index, $address, $ITFamilyCode, $ITDeviceCode, $type, $ITType, $room_id, "Intertecho");
									$this->SendDebug("AIO Import Intertechno:", "List:  " . json_encode($array), 0);
								}
								break;
						}
					}
					if (isset($device->info->address) && !isset($device->info->data)) //Lightmanager hat keinen data typ
					{
						//passende Instanz anlegen
						switch ($type) {
							case $this->GetDeviceType(self::LIGHT1): //Light Manager 1
								$this->SendDebug("AIO Import Lightmanager:", "Device:  " . $name .", Address: ".$address.", Type: ".$type, 0);
								$array = $this->AddDevicetoList(self::LIGHT1, $name, $index, $address, $type, $subtype, $room_id, "Light Manager 1");
								$this->SendDebug("AIO Import Lightmanager:", "List:  " . json_encode($array), 0);
								break;
							case $this->GetDeviceType(self::LIGHT2): //Light Manager 2
								$this->SendDebug("AIO Import Lightmanager 2:", "Device:  " . $name .", Address: ".$address.", Type: ".$type, 0);
								$array = $this->AddDevicetoList(self::LIGHT2, $name, $index, $address, $type, $subtype, $room_id, "Light Manager 2");
								$this->SendDebug("AIO Import Lightmanager 2:", "List:  " . json_encode($array), 0);
								break;
						}
					}
					//IR oder RF Codes address (IR:0X) Sendediode oder RF:0X
					if (isset($device->info->ircodes) && $subtype == $this->GetSubtype(self::RFDEVICE)) // Funkgerät
					{
						$key = $device->info->ircodes->codes;
						$count = count($key);
						/*
						for ($i = 0; $i <= $count - 1; $i++) {
							$ident = $subtype . "_" . $i;
						}
						*/
						$rfcodes = array();
						for ($i = 0; $i <= $count - 1; $i++) {
							$rfcodes[$i][0] = $key[$i]->key;
							$rfcodes[$i][1] = $key[$i]->code;
							$code = $rfcodes[$i][1];
							$valcode = substr($code, 0, 1);
							//del instanz
							if ($valcode == "{") {
								// $this->DeleteInstance($InsID);
								break;
							}
						}
						$this->SendDebug("AIO Import RF:", "Device:  " . $name .", Address: ".$address.", Type: ".$type, 0);
						$array = $this->AddRFDevicetoList($name, $index, $address, $type, $rfcodes, $count, $room_id, "RF");
						$this->SendDebug("AIO Import RF:", "List:  " . json_encode($array), 0);
					} elseif (isset($device->info->ircodes) && $subtype == $this->GetSubtype(self::IRDEVICE)) // IR Gerät
					{
						$key = $device->info->ircodes->codes;
						$count = count($key);
						/*
						for ($i = 0; $i <= $count - 1; $i++) {
							$ident = $subtype . "_" . $i;
						}
						*/
						$ircodes = array();
						for ($i = 0; $i <= $count - 1; $i++) {
							$ircodes[$i][0] = $key[$i]->key;
							$ircodes[$i][1] = $key[$i]->code;
							$code = $ircodes[$i][1];
							$valcode = substr($code, 0, 1);
							//del instanz
							if ($valcode == "{") {
								// $this->DeleteInstance($InsID);
								break;
							}
						}
						$this->SendDebug("AIO Import IR:", "Device:  " . $name ." (".$index."), Address: ".$address.", Type: ".$type, 0);
						$array = $this->AddIRDevicetoList($name, $index, $address, $type, $ircodes, $count, $room_id, "IR");
						$this->SendDebug("AIO Import IR:", "List:  " . json_encode($array), 0);
					}
			}
		}
	}

	private function SaveMediolaGateways($data)
    {
        $gateways_all = $data->gateways;
        $gateways = [];
        foreach($gateways_all as $gateway)
        {
            $gateway_info = $gateway->info;
            if(property_exists($gateway_info, 'gateway_vendor'))
            {
                $vendor = $gateway_info->gateway_vendor;
                if($vendor == "mediola")
                {
                    $gateways [$gateway->index] = $gateway;
                }
            }
        }
        $this->WriteAttributeString("AIOGateways", json_encode($gateways));
        return $gateways;
    }

    public function GetAIOGateways()
    {
        $AIOGateways = $this->ReadAttributeString('AIOGateways');
        return $AIOGateways;
    }

    private function SaveRooms($data)
    {
        //rooms auslesen
        $rooms = $data->rooms;
        $this->SendDebug("AIO Import:", "Rooms:  " . json_encode($rooms), 0);

        $roomsneo = array();
        foreach ($rooms as $key => $room) {
            $roomname = $room->name;
            $roomindex = $room->index;
            $roomnameprogs = stripos($roomname, "_progs&sysvars");
            $roomnamecamera = stripos($roomname, "_cameras");
            $roomnamewebpages = stripos($roomname, "_webpages");
            if (($roomnamewebpages === false) && ($roomnameprogs === false) && ($roomnamecamera === false)) {
                $roomsneo[$roomindex] = array("name" => $roomname, "index" => $roomindex);
            }
        }
        $this->WriteAttributeString("Rooms", json_encode($roomsneo));
        return $rooms;
    }


	protected function ListColumnColour($type)
	{
		if ($type == "fs20") {
			$colour = '"#ff0000"'; //rot
		} else {
			$colour = '"#C0FFC0"'; // Hellgrün
		}
		/*
		 * Hellgrün	#C0FFC0
Lila	#C0C0FF
Gelb	#FFFFC0
Rot	#FFC0C0
Grau	#DFDFDF
		 */
		return $colour;
	}

	protected function AddDevicetoList($device_guid, $name, $index, $address, $type, $subtype, $room_id, $manufacturer)
	{
		$newdevice = array("Address" => $address, "Import" => false, "InstanceID" => 0, "Subtype" => $subtype, "Type" => $type, "Name" => $name, "Index" => $index, "Room_ID" => $room_id, "Manufacturer" => $manufacturer);
		$devices = $this->AddDevicetoDevicelist($device_guid, $newdevice);
		return $devices;
	}

	protected function AddHMDevicetoList($name, $index, $HomematicAddress, $HomematicData, $HomematicSNR, $HomematicType, $room_id, $manufacturer)
	{
		$newdevice = array("Address" => $HomematicAddress, "HomematicData" => $HomematicData, "HomematicSNR" => $HomematicSNR, "HomematicType" => $HomematicType, "Import" => false, "InstanceID" => 0, "Name" => $name, "Index" => $index, "Room_ID" => $room_id, "Manufacturer" => $manufacturer);
		$devices = $this->AddDevicetoDevicelist(self::HOMEMATIC, $newdevice);
		return $devices;
	}

	protected function AddITDevicetoList($name, $index, $address, $familycode, $devicecode, $type, $subtype, $room_id, $manufacturer)
	{
		$newdevice = array("Address" => $address, "familycode" => $familycode, "devicecode" => $devicecode, "Import" => false, "InstanceID" => 0, "Subtype" => $subtype, "Type" => $type, "Name" => $name, "Index" => $index, "Room_ID" => $room_id, "Manufacturer" => $manufacturer);
		$devices = $this->AddDevicetoDevicelist(self::INTERTECHNO, $newdevice);
		return $devices;
	}

	protected function AddRFDevicetoList($name, $index, $address, $type, $rfcodes, $count, $room_id, $manufacturer)
	{
		$newdevice = array("Address" => $address, "Import" => false, "InstanceID" => 0, "Subtype" => "", "Type" => $type, "Name" => $name, "Index" => $index, "RFCodes" => $rfcodes, "Count" => $count, "Room_ID" => $room_id, "Manufacturer" => $manufacturer);
		$devices = $this->AddDevicetoDevicelist(self::RFDEVICE, $newdevice);
		return $devices;
	}

	protected function AddIRDevicetoList($name, $index, $address, $type, $ircodes, $count, $room_id, $manufacturer)
	{
		$newdevice = array("Address" => $address, "Import" => false, "InstanceID" => 0, "Subtype" => "", "Type" => $type, "Name" => $name, "Index" => $index, "IRCodes" => $ircodes, "Count" => $count, "Room_ID" => $room_id, "Manufacturer" => $manufacturer);
		$devices = $this->AddDevicetoDevicelist(self::IRDEVICE, $newdevice);
		return $devices;
	}

	protected function AddDevicetoDevicelist($device_guid, $newdevice)
	{
		$devices = json_decode($this->ReadAttributeString($this->GetModuleIdent($device_guid)), true);
		$count = count($devices);
		$index = $newdevice["Index"];
		$name = $newdevice["Name"];
		$manufacturer = $newdevice["Manufacturer"];
		$add_device = true;
		if($count > 0)
		{
			foreach($devices as $device)
			{
				if(isset($device["Index"]))
				{
					if($device["Index"] == $index)
					{
						$this->SendDebug("Add ".$manufacturer." Device", "Device ".$name." (".$index.") already exist", 0);
						$add_device = false;
					}
				}
			}
		}
		if($add_device){
			$this->SendDebug("Add ".$manufacturer." Device", "Device ".$name." (".$index."): ". json_encode($newdevice), 0);
			array_push($devices, $newdevice);
		}
		$this->WriteAttributeString($this->GetModuleIdent($device_guid), json_encode($devices));
		return $devices;
	}


	/***********************************************************
	 * Configuration Form
	 ***********************************************************/

	/**
	 * build configuration form
	 * @return string
	 */
	public function GetConfigurationForm()
	{
		// return current form
		$form = json_encode([
			'elements' => $this->FormHead(),
			'actions' => $this->FormActions(),
			'status' => $this->FormStatus()
		]);
		$this->SendDebug("Config Form:", $form, 0);
		return $form;
	}

	/**
	 * return form configurations on configuration step
	 * @return array
	 */
	protected function FormHead()
	{
		$Version = $this->ReadPropertyInteger('Version');
		$form = [
			[
				'type' => 'Image',
				'image' => 'data:image/png;base64, iVBORw0KGgoAAAANSUhEUgAAAMgAAABLCAYAAAA1fMjoAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMDY3IDc5LjE1Nzc0NywgMjAxNS8wMy8zMC0yMzo0MDo0MiAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTUgKFdpbmRvd3MpIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjY2QUI2MjE1REVGMzExRThCMzJGRjEwMzUxRUM2N0I3IiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjY2QUI2MjE2REVGMzExRThCMzJGRjEwMzUxRUM2N0I3Ij4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6NjZBQjYyMTNERUYzMTFFOEIzMkZGMTAzNTFFQzY3QjciIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6NjZBQjYyMTRERUYzMTFFOEIzMkZGMTAzNTFFQzY3QjciLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz6GmGzYAAAM4UlEQVR42uxd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'
			],
			[
				'type' => 'Label',
				'label' => 'import of devices from AIO Creator:'
			],
			[
				'type' => 'Label',
				'caption' => 'choose the AIO Creator version:'
			],
			[
				'name' => 'Version',
				'type' => 'Select',
				'caption' => 'Version Creator',
				'options' => [
					[
						'caption' => 'Please select Creator Version',
						'value' => 0
					],
					[
						'caption' => 'AIO Creator NEO',
						'value' => 1
					],
					[
						'caption' => 'AIO Creator (old version)',
						'value' => 2
					]
				]
			]
		];
		// NEO
		if ($Version == 1) {
			$form = array_merge_recursive(
				$form,
				[
					[
						'type' => 'Label',
						'caption' => 'AIO Creator NEO, import device_db, can be found in the folder AIO CREATOR NEO/tenants/[ID of the remote]/'
					],
					[
						'name' => 'device_db',
						'type' => 'SelectFile',
						'caption' => 'device_db',
						'extensions' => ''
					]
				]
			);
		}
		// old creator
		if ($Version == 2) {
			$form = array_merge_recursive(
				$form,
				[
					[
						'type' => 'Label',
						'caption' => 'AIO Creator, import ircodes.xml and devices.xml'
					],
					[
						'type' => 'Label',
						'caption' => 'choose ircodes.xml, can be found in the folder of the a.i.o. Creator'
					],
					[
						'name' => 'ircodes',
						'type' => 'SelectFile',
						'caption' => 'ircodes.xml',
						'extensions' => '.xml'
					],
					[
						'type' => 'Label',
						'caption' => 'choose devices.xml, can be found in the folder of the a.i.o. Creator'
					],
					[
						'name' => 'devices',
						'type' => 'SelectFile',
						'caption' => 'devices.xml',
						'extensions' => '.xml'
					]
				]
			);
		}

		$form = array_merge_recursive(
			$form,
			[
				[
					'type' => 'Label',
					'caption' => 'category for import of the devices:'
				],
				[
					'name' => 'ImportCategoryID',
					'type' => 'SelectCategory',
					'caption' => 'category',
				]
				/*,
				[
					'type' => 'Label',
					'caption' => 'import categories and device in rooms:'
				],
				[
					'name' => 'RoomImport',
					'type' => 'CheckBox',
					'caption' => 'import rooms',
				]
				*/
			]
		);
		$ircodes = $this->ReadAttributeString('ircodes');
		$devices = $this->ReadAttributeString('devices');
		$device_db = $this->ReadPropertyString('device_db');
		if (($Version == 1 && $device_db != "") || (($Version == 2 && $ircodes != "") || ($Version == 2 && $devices != "") )) {
			// show list
			$this->SelectImport();
			// $rooms = $this->GetRooms();
            $gateways = json_decode($this->ReadAttributeString('AIOGateways'), true);
            $number_gateways = count($gateways);
            $form = array_merge_recursive(
                $form,
                [
                    [
                        'type' => 'Configurator',
                        'name' => 'Configuration_AIOGateways',
                        'caption' => $this->Translate('configuration ') . "AIO Gateways",
                        'rowCount' => $number_gateways,
                        'add' => false,
                        'delete' => false,
                        'sort' => [
                            'column' => 'name',
                            'direction' => 'ascending'
                        ],
                        'columns' => [
                            [
                                'caption' => 'ID',
                                'name' => 'id',
                                'width' => '200px',
                                'visible' => false
                            ],
                            [
                                'caption' => 'Name',
                                'name' => 'name',
                                'width' => 'auto'
                            ],
                            [
                                'caption' => 'Gateway Name',
                                'name' => 'gatewayname',
                                'width' => '200px'
                            ],
                            [
                                'caption' => 'IP',
                                'name' => 'ip_gateway',
                                'width' => '200px'
                            ],
                            [
                                'caption' => 'MAC',
                                'name' => 'mac',
                                'width' => '200px'
                            ],
                            [
                                'caption' => 'Version',
                                'name' => 'version',
                                'width' => '100px'
                            ],
                            [
                                'caption' => 'Firmware',
                                'name' => 'firmware',
                                'width' => '100px'
                            ],
                            [
                                'caption' => 'SID',
                                'name' => 'sid',
                                'width' => '350px',
                                'visible' => 'false'
                            ]
                        ],
                        'values' => $this->GetConfigurationListAIOGateways($number_gateways)
                    ]
                ]
            );




			$barthelme_devices = $this->GetDeviceNumber(self::BARTHELME);
			$name = $this->GetModuleName(self::BARTHELME);
			$this->SendDebug("AIO Barthelme:", "From " . $name . " " . $barthelme_devices . " instances were found.", 0);
			if ($barthelme_devices > 0) {
				$form = array_merge_recursive(
					$form,
					[

						[
							'type' => 'ExpansionPanel',
							'caption' => 'Barthelme Device Configuration',
							'items' => [
								[
									'type' => 'Image',
									'image' => 'data:image/png;base64, iVBORw0KGgoAAAANSUhEUgAAAMgAAAAvCAYAAACmGYWkAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyhpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMDY3IDc5LjE1Nzc0NywgMjAxNS8wMy8zMC0yMzo0MDo0MiAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6Mzc0NDMwRDRERUYzMTFFOEFFNzNBM0RCOTU0RTgxQTIiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6Mzc0NDMwRDNERUYzMTFFOEFFNzNBM0RCOTU0RTgxQTIiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTUgKE1hY2ludG9zaCkiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDo1MTEwQjM5RjIxNjkxMUU1QUIwRUVCQUQ2QUVFODFERSIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDo1MTEwQjNBMDIxNjkxMUU1QUIwRUVCQUQ2QUVFODFERSIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PuhWxLMAACnlSURBVHja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'
								],
								$this->GetConfigurationList(self::BARTHELME, $barthelme_devices)

							]
						]
					]
				);
			}
			$becker_devices = $this->GetDeviceNumber(self::BECKERCENTRONIC);
			$name = $this->GetModuleName(self::BECKERCENTRONIC);
			$this->SendDebug("AIO Becker:", "From " . $name . " " . $becker_devices . " instances were found.", 0);
			if ($becker_devices > 0) {
				$form = array_merge_recursive(
					$form,
					[
						[
							'type' => 'ExpansionPanel',
							'caption' => 'Becker Centronic Device Configuration',
							'items' => [
								[
									'type' => 'Image',
									'image' => 'data:image/png;base64, iVBORw0KGgoAAAANSUhEUgAAAMgAAAAxCAYAAACfxeZPAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMDY3IDc5LjE1Nzc0NywgMjAxNS8wMy8zMC0yMzo0MDo0MiAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6NDlENjQ0MDIzQTYyMTFFOUFDM0JGNkRCMUVGMkJCRDUiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6NDlENjQ0MDEzQTYyMTFFOUFDM0JGNkRCMUVGMkJCRDUiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNS4xIFdpbmRvd3MiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDowMDU2MkJGN0Y5QzQxMUU2QURFNkNDRTQ5MTU2MjhDMiIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDowMDU2MkJGOEY5QzQxMUU2QURFNkNDRTQ5MTU2MjhDMiIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PjXUbFwAAC3wSURBVHja7H0HfFTV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'
								],
								$this->GetConfigurationList(self::BECKERCENTRONIC, $becker_devices)

							]
						]
					]
				);
			}
			$brennenstuhl_devices = $this->GetDeviceNumber(self::BRENNENSTUHL);
			$name = $this->GetModuleName(self::BRENNENSTUHL);
			$this->SendDebug("AIO Brennenstuhl:", "From " . $name . " " . $brennenstuhl_devices . " instances were found.", 0);
			if ($brennenstuhl_devices > 0) {
				$form = array_merge_recursive(
					$form,
					[
						[
							'type' => 'ExpansionPanel',
							'caption' => 'Brennenstuhl Device Configuration',
							'items' => [

								$this->GetConfigurationList(self::BRENNENSTUHL, $brennenstuhl_devices)

							]
						]
					]
				);
			}
			$conradrsl_devices = $this->GetDeviceNumber(self::CONRADRSL);
			$name = $this->GetModuleName(self::CONRADRSL);
			$this->SendDebug("AIO Conrad RSL:", "From " . $name . " " . $conradrsl_devices . " instances were found.", 0);
			if ($conradrsl_devices > 0) {
				$form = array_merge_recursive(
					$form,
					[
						[
							'type' => 'ExpansionPanel',
							'caption' => 'Conrad RSL Device Configuration',
							'items' => [

								$this->GetConfigurationList(self::CONRADRSL, $conradrsl_devices)

							]
						]
					]
				);
			}
			$dooya_devices = $this->GetDeviceNumber(self::DOOYA);
			$name = $this->GetModuleName(self::DOOYA);
			$this->SendDebug("AIO Dooya:", "From " . $name . " " . $dooya_devices . " instances were found.", 0);
			if ($dooya_devices > 0) {
				$form = array_merge_recursive(
					$form,
					[
						[
							'type' => 'ExpansionPanel',
							'caption' => 'Dooya Device Configuration',
							'items' => [

								$this->GetConfigurationList(self::DOOYA, $dooya_devices)

							]
						]
					]
				);
			}
			$elero_devices = $this->GetDeviceNumber(self::ELERO);
			$name = $this->GetModuleName(self::ELERO);
			$this->SendDebug("AIO Elero:", "From " . $name . " " . $elero_devices . " instances were found.", 0);
			if ($elero_devices > 0) {
				$form = array_merge_recursive(
					$form,
					[
						[
							'type' => 'ExpansionPanel',
							'caption' => 'Elero Device Configuration',
							'items' => [

								$this->GetConfigurationList(self::ELERO, $elero_devices)

							]
						]
					]
				);
			}
			$elro_devices = $this->GetDeviceNumber(self::ELRO);
			$name = $this->GetModuleName(self::ELRO);
			$this->SendDebug("AIO ELRO:", "From " . $name . " " . $elro_devices . " instances were found.", 0);
			if ($elro_devices > 0) {
				$form = array_merge_recursive(
					$form,
					[

						[
							'type' => 'ExpansionPanel',
							'caption' => 'Elro Device Configuration',
							'items' => [
								[
									'type' => 'Image',
									'image' => 'data:image/png;base64, iVBORw0KGgoAAAANSUhEUgAAAIoAAABkCAYAAABZyaiWAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMDY3IDc5LjE1Nzc0NywgMjAxNS8wMy8zMC0yMzo0MDo0MiAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTUgKFdpbmRvd3MpIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjY5M0E3N0JBRjFCQzExRThCODA4OUM5ODRGMTg1ODFFIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjY5M0E3N0JCRjFCQzExRThCODA4OUM5ODRGMTg1ODFFIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6NjkzQTc3QjhGMUJDMTFFOEI4MDg5Qzk4NEYxODU4MUUiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6NjkzQTc3QjlGMUJDMTFFOEI4MDg5Qzk4NEYxODU4MUUiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz5d34HPAAAfnElEQVR42uxd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'
								],
								$this->GetConfigurationList(self::ELRO, $elro_devices)

							]
						]

					]
				);
			}
			$enocean_devices = $this->GetDeviceNumber(self::ENOCEAN);
			$name = $this->GetModuleName(self::ENOCEAN);
			$this->SendDebug("AIO EnOcean:", "From " . $name . " " . $enocean_devices . " instances were found.", 0);
			if ($enocean_devices > 0) {
				$form = array_merge_recursive(
					$form,
					[
						[
							'type' => 'ExpansionPanel',
							'caption' => 'EnOcean Device Configuration',
							'items' => [

								$this->GetConfigurationList(self::ENOCEAN, $enocean_devices)

							]
						]
					]
				);
			}
			$fht_devices = $this->GetDeviceNumber(self::FHT);
			$name = $this->GetModuleName(self::FHT);
			$this->SendDebug("AIO FHT:", "From " . $name . " " . $fht_devices . " instances were found.", 0);
			if ($fht_devices > 0) {
				$form = array_merge_recursive(
					$form,
					[
						[
							'type' => 'ExpansionPanel',
							'caption' => 'FHT80B Device Configuration',
							'items' => [

								$this->GetConfigurationList(self::FHT, $fht_devices)

							]
						]
					]
				);
			}
			$fs20_devices = $this->GetDeviceNumber(self::FS20);
			$name = $this->GetModuleName(self::FS20);
			$this->SendDebug("AIO FS20:", "From " . $name . " " . $fs20_devices . " instances were found.", 0);
			if ($fs20_devices > 0) {
				$form = array_merge_recursive(
					$form,
					[
						[
							'type' => 'ExpansionPanel',
							'caption' => 'FS20 Device Configuration',
							'items' => [
								[
									'type' => 'Image',
									'image' => 'data:image/png;base64, iVBORw0KGgoAAAANSUhEUgAAAKkAAABkCAYAAAD9oxBFAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMDY3IDc5LjE1Nzc0NywgMjAxNS8wMy8zMC0yMzo0MDo0MiAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTUgKFdpbmRvd3MpIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOkFERkYzRjVGRjFCQzExRTg5ODZERjY1NTgwRTYzMkI3IiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOkFERkYzRjYwRjFCQzExRTg5ODZERjY1NTgwRTYzMkI3Ij4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6QURGRjNGNURGMUJDMTFFODk4NkRGNjU1ODBFNjMyQjciIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6QURGRjNGNUVGMUJDMTFFODk4NkRGNjU1ODBFNjMyQjciLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz5p8+nnAAAWGElEQVR42uxd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'
								],
								$this->GetConfigurationList(self::FS20, $fs20_devices)

							]
						]
					]
				);
			}
			$greenteq_devices = $this->GetDeviceNumber(self::GREENTEQ);
			$name = $this->GetModuleName(self::GREENTEQ);
			$this->SendDebug("AIO Greenteq:", "From " . $name . " " . $greenteq_devices . " instances were found.", 0);
			if ($greenteq_devices > 0) {
				$form = array_merge_recursive(
					$form,
					[
						[
							'type' => 'ExpansionPanel',
							'caption' => 'Greenteq Device Configuration',
							'items' => [

								$this->GetConfigurationList(self::GREENTEQ, $greenteq_devices)

							]
						]
					]
				);
			}
			$homeeasy_devices = $this->GetDeviceNumber(self::HOMEEASY);
			$name = $this->GetModuleName(self::HOMEEASY);
			$this->SendDebug("AIO Homeeasy:", "From " . $name . " " . $homeeasy_devices . " instances were found.", 0);
			if ($homeeasy_devices > 0) {
				$form = array_merge_recursive(
					$form,
					[
						[
							'type' => 'ExpansionPanel',
							'caption' => 'HOMEEasy Device Configuration',
							'items' => [

								$this->GetConfigurationList(self::HOMEEASY, $homeeasy_devices)

							]
						]
					]
				);
			}
			$homematic_devices = $this->GetDeviceNumber(self::HOMEMATIC);
			$name = $this->GetModuleName(self::HOMEMATIC);
			$this->SendDebug("AIO Homematic:", "From " . $name . " " . $homematic_devices . " instances were found.", 0);
			if ($homematic_devices > 0) {
				$form = array_merge_recursive(
					$form,
					[
						[
							'type' => 'ExpansionPanel',
							'caption' => 'Homematic Device Configuration',
							'items' => [
								[
									'type' => 'Image',
									'image' => 'data:image/png;base64, iVBORw0KGgoAAAANSUhEUgAAAMgAAAAfCAYAAACiY4IJAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMDY3IDc5LjE1Nzc0NywgMjAxNS8wMy8zMC0yMzo0MDo0MiAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTUgKFdpbmRvd3MpIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjk1MDExMjQ2RERFQjExRThCMkRBQUU1MEQxOEFCRjhFIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjk1MDExMjQ3RERFQjExRThCMkRBQUU1MEQxOEFCRjhFIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6OTUwMTEyNDREREVCMTFFOEIyREFBRTUwRDE4QUJGOEUiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6OTUwMTEyNDVEREVCMTFFOEIyREFBRTUwRDE4QUJGOEUiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz4rvVp1AAAX5UlEQVR42uxc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'
								],
								$this->GetConfigurationList(self::HOMEMATIC, $homematic_devices)
							]
						]
					]
				);
			}
			$instabus_devices = $this->GetDeviceNumber(self::INSTABUS);
			$name = $this->GetModuleName(self::INSTABUS);
			$this->SendDebug("AIO Instabus:", "From " . $name . " " . $instabus_devices . " instances were found.", 0);
			if ($instabus_devices > 0) {
				$form = array_merge_recursive(
					$form,
					[
						[
							'type' => 'ExpansionPanel',
							'caption' => 'Instabus Device Configuration',
							'items' => [

								$this->GetConfigurationList(self::INSTABUS, $instabus_devices)

							]
						]
					]
				);
			}
			$internorm_devices = $this->GetDeviceNumber(self::INTERNORM);
			$name = $this->GetModuleName(self::INTERNORM);
			$this->SendDebug("AIO Internorm:", "From " . $name . " " . $internorm_devices . " instances were found.", 0);
			if ($internorm_devices > 0) {
				$form = array_merge_recursive(
					$form,
					[
						[
							'type' => 'ExpansionPanel',
							'caption' => 'Internorm Device Configuration',
							'items' => [

								$this->GetConfigurationList(self::INTERNORM, $internorm_devices)

							]
						]
					]
				);
			}
			$intertechno_devices = $this->GetDeviceNumber(self::INTERTECHNO);
			$name = $this->GetModuleName(self::INTERTECHNO);
			$this->SendDebug("AIO Intertechno:", "From " . $name . " " . $intertechno_devices . " instances were found.", 0);
			if ($intertechno_devices > 0) {
				$form = array_merge_recursive(
					$form,
					[
						[
							'type' => 'ExpansionPanel',
							'caption' => 'Intertechno Device Configuration',
							'items' => [
								[
									'type' => 'Image',
									'image' => 'data:image/png;base64, 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'
								],
								$this->GetConfigurationList(self::INTERTECHNO, $intertechno_devices)

							]
						]
					]
				);
			}
			$ir_devices = $this->GetDeviceNumber(self::IRDEVICE);
			$name = $this->GetModuleName(self::IRDEVICE);
			$this->SendDebug("AIO IR:", "From " . $name . " " . $ir_devices . " instances were found.", 0);
			if ($ir_devices > 0) {
				$form = array_merge_recursive(
					$form,
					[
						[
							'type' => 'ExpansionPanel',
							'caption' => 'IR Device Configuration',
							'items' => [

								$this->GetConfigurationList(self::IRDEVICE, $ir_devices)

							]
						]
					]
				);
			}
			$kaiser_devices = $this->GetDeviceNumber(self::KAISERNIENHAUS);
			$name = $this->GetModuleName(self::KAISERNIENHAUS);
			$this->SendDebug("AIO Kaiser:", "From " . $name . " " . $kaiser_devices . " instances were found.", 0);
			if ($kaiser_devices > 0) {
				$form = array_merge_recursive(
					$form,
					[
						[
							'type' => 'ExpansionPanel',
							'caption' => 'Kaiser Nienhaus Device Configuration',
							'items' => [

								$this->GetConfigurationList(self::KAISERNIENHAUS, $kaiser_devices)

							]
						]
					]
				);
			}
			$kopp_devices = $this->GetDeviceNumber(self::KOPPFREECONTROL);
			$name = $this->GetModuleName(self::KOPPFREECONTROL);
			$this->SendDebug("AIO Kopp:", "From " . $name . " " . $kopp_devices . " instances were found.", 0);
			if ($kopp_devices > 0) {
				$form = array_merge_recursive(
					$form,
					[
						[
							'type' => 'ExpansionPanel',
							'caption' => 'Kopp Free Control Device Configuration',
							'items' => [

								$this->GetConfigurationList(self::KOPPFREECONTROL, $kopp_devices)

							]
						]
					]
				);
			}
			$light1_devices = $this->GetDeviceNumber(self::LIGHT1);
			$name = $this->GetModuleName(self::LIGHT1);
			$this->SendDebug("AIO Light 1:", "From " . $name . " " . $kopp_devices . " instances were found.", 0);
			if ($light1_devices > 0) {
				$form = array_merge_recursive(
					$form,
					[
						[
							'type' => 'ExpansionPanel',
							'caption' => 'Lightmanager 1 Device Configuration',
							'items' => [

								$this->GetConfigurationList(self::LIGHT1, $light1_devices)

							]
						]
					]
				);
			}
			$light2_devices = $this->GetDeviceNumber(self::LIGHT2);
			$name = $this->GetModuleName(self::LIGHT2);
			$this->SendDebug("AIO Light 2:", "From " . $name . " " . $kopp_devices . " instances were found.", 0);
			if ($light2_devices > 0) {
				$form = array_merge_recursive(
					$form,
					[
						[
							'type' => 'ExpansionPanel',
							'caption' => 'Lightmanager 2 Device Configuration',
							'items' => [

								$this->GetConfigurationList(self::LIGHT2, $light2_devices)

							]
						]
					]
				);
			}
			$nueva_devices = $this->GetDeviceNumber(self::NUEVA);
			$name = $this->GetModuleName(self::NUEVA);
			$this->SendDebug("AIO Nueva:", "From " . $name . " " . $kopp_devices . " instances were found.", 0);
			if ($nueva_devices > 0) {
				$form = array_merge_recursive(
					$form,
					[
						[
							'type' => 'ExpansionPanel',
							'caption' => 'Nueva Device Configuration',
							'items' => [

								$this->GetConfigurationList(self::NUEVA, $nueva_devices)

							]
						]
					]
				);
			}
			$pca_devices = $this->GetDeviceNumber(self::PCA);
			$name = $this->GetModuleName(self::PCA);
			$this->SendDebug("AIO PCA:", "From " . $name . " " . $kopp_devices . " instances were found.", 0);
			if ($pca_devices > 0) {
				$form = array_merge_recursive(
					$form,
					[
						[
							'type' => 'ExpansionPanel',
							'caption' => 'PCA-301 Device Configuration',
							'items' => [

								$this->GetConfigurationList(self::PCA, $pca_devices)

							]
						]
					]
				);
			}
			$rf_devices = $this->GetDeviceNumber(self::NUEVA);
			$name = $this->GetModuleName(self::NUEVA);
			$this->SendDebug("AIO RF:", "From " . $name . " " . $kopp_devices . " instances were found.", 0);
			if ($rf_devices > 0) {
				$form = array_merge_recursive(
					$form,
					[
						[
							'type' => 'ExpansionPanel',
							'caption' => 'RF Device Configuration',
							'items' => [

								$this->GetConfigurationList(self::NUEVA, $rf_devices)

							]
						]
					]
				);
			}
			$schalk_devices = $this->GetDeviceNumber(self::SCHALK);
			$name = $this->GetModuleName(self::SCHALK);
			$this->SendDebug("AIO Schalk:", "From " . $name . " " . $kopp_devices . " instances were found.", 0);
			if ($schalk_devices > 0) {
				$form = array_merge_recursive(
					$form,
					[
						[
							'type' => 'ExpansionPanel',
							'caption' => 'Schalk FX3 Device Configuration',
							'items' => [

								$this->GetConfigurationList(self::SCHALK, $schalk_devices)

							]
						]
					]
				);
			}
			$somfy_devices = $this->GetDeviceNumber(self::SOMFY);
			$name = $this->GetModuleName(self::SOMFY);
			$this->SendDebug("AIO Somfy:", "From " . $name . " " . $kopp_devices . " instances were found.", 0);
			if ($somfy_devices > 0) {
				$form = array_merge_recursive(
					$form,
					[
						[
							'type' => 'ExpansionPanel',
							'caption' => 'Somfy RTS Device Configuration',
							'items' => [
								[
									'type' => 'Image',
									'image' => 'data:image/png;base64, iVBORw0KGgoAAAANSUhEUgAAAJYAAABkCAYAAABkW8nwAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA3BpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMDY3IDc5LjE1Nzc0NywgMjAxNS8wMy8zMC0yMzo0MDo0MiAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDphYjNhMzU4My1kNGIyLTRkMTItODAwYy00OTA5MjQyZWU5MmMiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6N0I0NkE2OERGMUJDMTFFOEJCMDFEOUM5NkNDQzAyMEQiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6N0I0NkE2OENGMUJDMTFFOEJCMDFEOUM5NkNDQzAyMEQiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTQgKE1hY2ludG9zaCkiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDo3NzFBOEU0QjlBMzkxMUU0QTQzQ0IyMTI5M0Y4NjVERCIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDo3NzFBOEU0QzlBMzkxMUU0QTQzQ0IyMTI5M0Y4NjVERCIvPiA8L3Jk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'
								],
								$this->GetConfigurationList(self::SOMFY, $somfy_devices)
							]
						]
					]
				);
			}
			$systeq_devices = $this->GetDeviceNumber(self::SYSTEQ);
			$name = $this->GetModuleName(self::SYSTEQ);
			$this->SendDebug("AIO Systeq:", "From " . $name . " " . $kopp_devices . " instances were found.", 0);
			if ($systeq_devices > 0) {
				$form = array_merge_recursive(
					$form,
					[
						[
							'type' => 'ExpansionPanel',
							'caption' => 'systeQ Device Configuration',
							'items' => [

								$this->GetConfigurationList(self::SYSTEQ, $systeq_devices)

							]
						]
					]
				);
			}
			$warema_devices = $this->GetDeviceNumber(self::WAREMA);
			$name = $this->GetModuleName(self::WAREMA);
			$this->SendDebug("AIO Warema:", "From " . $name . " " . $kopp_devices . " instances were found.", 0);
			if ($warema_devices > 0) {
				$form = array_merge_recursive(
					$form,
					[
						[
							'type' => 'ExpansionPanel',
							'caption' => 'Warema Device Configuration',
							'items' => [

								$this->GetConfigurationList(self::WAREMA, $warema_devices)

							]
						]
					]
				);
			}
			$wir_devices = $this->GetDeviceNumber(self::WIR);
			$name = $this->GetModuleName(self::WIR);
			$this->SendDebug("AIO WIR:", "From " . $name . " " . $kopp_devices . " instances were found.", 0);
			if ($wir_devices > 0) {
				$form = array_merge_recursive(
					$form,
					[
						[
							'type' => 'ExpansionPanel',
							'caption' => 'WIR Device Configuration',
							'items' => [

								$this->GetConfigurationList(self::WIR, $wir_devices)

							]
						]
					]
				);
			}
		}

		return $form;
	}



	private function GetInstanceList($device_guid)
	{
		$device_list = IPS_GetInstanceListByModuleID($device_guid);
		return $device_list;
	}

	private function GetDeviceNumber($device_guid)
	{
		//$InstanceIDList = $this->GetInstanceList($device_guid);
		//$current_number_devices = count($InstanceIDList);
		//$number_devices = $current_number_devices;
		$number_devices = 0;
		$imported_devices = $this->GetDeviceImportList($device_guid);
		if($imported_devices != "[]") {
			$imported_devices = json_decode($imported_devices, true);
			/* $i = $current_number_devices;
			foreach ($imported_devices as $key => $device) {
				$devices[$key] = $device;
				$address = $device["Address"];
				foreach ($InstanceIDList as $Device_InstanceID) {
					if ($address == IPS_GetProperty($Device_InstanceID, 'address')) {
						$i--;
					}
				}
			}
			*/
			//$number_devices = count($imported_devices) - $i;
			$number_devices = count($imported_devices);
		}
		return $number_devices;
	}

	private function GetModuleIdent($device_guid)
	{
		$device_ident = trim($device_guid, '{}');
		$device_ident = str_replace("-", "", $device_ident);
		return $device_ident;
	}

	private function GetModuleName($device_guid)
	{
        $device_types = $this->DeviceTypes();
        $key = array_key_exists($device_guid, $device_types);
        $module_name = "Unkown";
        if($key)
        {
            $module_name = $device_types[$device_guid]["alias"];
        }
        return $module_name;
	}

	private function GetConfigurationListAIOGateways($number_gateways)
    {
        $config_list = [];
        if($number_gateways == 0)
        {
            $config_list = [];
        }
        else
        {
            $instanceID = 0;
            $imported_gateways = $this->ReadAttributeString('AIOGateways');
            $InstanceIDList = $this->GetInstanceList("{7E03C651-E5BF-4EC6-B1E8-397234992DB4}");
            if($imported_gateways != "[]")
            {
                $gateways = json_decode($imported_gateways, true);
                $this->SendDebug("Import List AIO Gateways:", json_encode($gateways), 0);
                foreach ($gateways as $gateway) {
                    $index = $gateway['index'];
                    $name = $gateway['name'];
                    $info = $gateway['info'];
                    $gatewayname = $info['name'];
                    $gateway_arr = explode(" ", $gatewayname);
                    $gateway_type = $gateway_arr[array_key_last($gateway_arr)];
                    $ip = $info['ip'];
                    $mac = $info['mac'];
                    $version = $info['version'];
                    $firmware = $info['firmware'];
                    $sid = $info['sid'];
                    foreach ($InstanceIDList as $Device_InstanceID) {
                        if ($index == @IPS_GetProperty($Device_InstanceID, 'index') && $mac == @IPS_GetProperty($Device_InstanceID, 'mac')) {
                            $instance_name = IPS_GetName($Device_InstanceID);
                            $this->SendDebug('AIO Config', 'existing device found: ' . utf8_decode($instance_name) . ' (' . $Device_InstanceID . ') with index ' .$index, 0);
                            $instanceID = $Device_InstanceID;
                        }
                    }

                    if ($gateway_type == 'V5' || $gateway_type == 'V5+' || $gateway_type == 'V6' || $gateway_type == 'V6Mini') {
                        $config_list[] = [
                            "instanceID" => $instanceID,
                            "id" => $index,
                            "name" => $name,
                            "gatewayname" => $gatewayname,
                            "ip_gateway" => $ip,
                            "mac" => $mac,
                            "version" => $version,
                            "firmware" => $firmware,
                            "sid" => $sid,
                            "create" => [
                                [
                                    "moduleID" => "{7E03C651-E5BF-4EC6-B1E8-397234992DB4}",
                                    "configuration" => [
                                        "index" => $index,
                                        'name' => $name,
                                        "gatewayname" => $gatewayname,
                                        "gatewaytype" => $gateway_type,
                                        "Host" => $ip,
                                        "mac" => $mac,
                                        "version" => $version,
                                        "firmware" => $firmware,
                                        "sid" => $sid
                                    ]
                                ],
                                [
                                    'moduleID' => '{BAB408E0-0A0F-48C3-B14E-9FB2FA81F66A}',
                                    'configuration' => [
                                        'Host' => $this->GetHostIP(),
                                        'Port' => 1901,
                                        'MulticastIP' => "239.255.255.250",
                                        'BindPort' => 1901,
                                        'EnableBroadcast' => true,
                                        'EnableReuseAddress' => true,
                                        'EnableLoopback' => false,
                                        'Open' => true
                                    ]
                                ]
                            ]
                        ];
                    }
                    else{
                        $config_list[] = [
                            "instanceID" => $instanceID,
                            "id" => $index,
                            "name" => $name,
                            "gatewayname" => $gatewayname,
                            "ip_gateway" => $ip,
                            "mac" => $mac,
                            "version" => $version,
                            "firmware" => $firmware,
                            "sid" => $sid,
                            "create" => [
                                [
                                    "moduleID" => "{7E03C651-E5BF-4EC6-B1E8-397234992DB4}",
                                    "configuration" => [
                                        "index" => $index,
                                        'name' => $name,
                                        "gatewayname" => $gatewayname,
                                        "gatewaytype" => $gateway_type,
                                        "Host" => $ip,
                                        "mac" => $mac,
                                        "version" => $version,
                                        "firmware" => $firmware,
                                        "sid" => $sid
                                    ]
                                ],
                                [
                                    'moduleID' => '{BAB408E0-0A0F-48C3-B14E-9FB2FA81F66A}',
                                    'configuration' => [
                                        'Host' => $this->GetHostIP(),
                                        'Port' => 1902,
                                        'MulticastIP' => "239.255.255.250",
                                        'BindPort' => 1902,
                                        'EnableBroadcast' => true,
                                        'EnableReuseAddress' => true,
                                        'EnableLoopback' => false,
                                        'Open' => true
                                    ]
                                ]
                            ]
                        ];
                    }
                }
            }
        }
        return $config_list;
    }

    protected function GetHostIP()
    {
        $ip = exec("sudo ifconfig eth0 | grep 'inet Adresse:' | cut -d: -f2 | awk '{ print $1}'");
        if ($ip == "") {
            $ipinfo = Sys_GetNetworkInfo();
            foreach($ipinfo as $networkcard)
            {
                $hyper_v = strpos($networkcard['Description'], 'Virtual Ethernet Adapter');
                if($networkcard['IP'] != '0.0.0.0' && $hyper_v == false)
                {
                    $ip = $networkcard['IP'];
                }
            }
        }
        return $ip;
    }

	private function GetConfigurationList($device_guid, $number_devices)
	{
		$module_name = $this->GetModuleName($device_guid);
		$this->SendDebug("Import:", "Module " . $module_name, 0);
		$device_ident = $this->GetModuleIdent($device_guid);
		$device_list = $this->GetInstanceList($device_guid);
		$this->SendDebug("Device List:", json_encode($device_list), 0);
		$configurator = [
			'type' => 'Configurator',
			'name' => 'Configuration_' . $device_ident,
			'caption' => $this->Translate('configuration ') . $module_name,
			'rowCount' => $number_devices,
			'add' => false,
			'delete' => false,
			'sort' => [
				'column' => 'name',
				'direction' => 'ascending'
			],
			'columns' => [
				[
					'caption' => 'ID',
					'name' => 'id',
					'width' => '200px',
					'visible' => false
				],
				[
					'caption' => 'Name',
					'name' => 'name',
					'width' => 'auto'
				],
                [
                    'caption' => 'Gateway',
                    'name' => 'gateway',
                    'width' => '200px'
                ],
				[
					'caption' => 'Type',
					'name' => 'type',
					'width' => '200px'
				],
				[
					'caption' => 'Room',
					'name' => 'room',
					'width' => '200px'
				],
				[
					'caption' => 'Manufacturer',
					'name' => 'manufacturer',
					'width' => '250px'
				],
				[
					'caption' => 'Ident',
					'name' => 'device_id',
					'width' => '200px',
					'visible' => 'false'
				],
				[
					'caption' => 'Address',
					'name' => 'address',
					'width' => '250px',
					'visible' => 'false'
				]
			],
			'values' => $this->Get_ListConfiguration($device_guid, $module_name, $number_devices)
		];
		return $configurator;
	}

	/** Get Config Device
	 * @param $device_guid
	 * @param $module_name
	 * @param $number_devices
	 * @return array
	 */
	private function Get_ListConfiguration($device_guid, $module_name, $number_devices)
	{
		$config_list = [];
		if($number_devices == 0)
		{
			$config_list = [];
		}
		else
		{
			$instanceID = 0;
			$InstanceIDList = $this->GetInstanceList($device_guid);

			$imported_devices = $this->GetDeviceImportList($device_guid);
			$this->SendDebug("Import List:", $module_name. ": ". json_encode($imported_devices), 0);
			if($imported_devices != "[]")
			{
				$imported_devices = json_decode($imported_devices, true);
				foreach ($imported_devices as $device) {
					$device_name = $device["Name"];
					$type = $device["Type"];
					$room_id = $device["Room_ID"];
					$room_name = $this->GetRoomName($room_id);
					$this->SendDebug('AIO Config', 'device: ' . $device_name . ' , room: ' . $room_name , 0);
					//$device_id = $device["DeviceID"];
					$index = $device["Index"];
					if(isset($device["Manufacturer"]))
					{
						$manufacturer = $device["Manufacturer"];
					}
					else{
						$manufacturer = "";
					}
					$address = $device["Address"];
					foreach ($InstanceIDList as $Device_InstanceID) {
						if ($index == @IPS_GetProperty($Device_InstanceID, 'device_id')) {
							$instance_name = IPS_GetName($Device_InstanceID);
							$this->SendDebug('AIO Config', 'existing device found: ' . utf8_decode($instance_name) . ' (' . $Device_InstanceID . ') with index ' .$index, 0);
							$instanceID = $Device_InstanceID;
						}
					}
					if($device_guid == self::IRDEVICE)
					{
						$ircodes = $device["IRCodes"];
						$ircount = $device["Count"];
						$config_list[] = [
							"instanceID" => $instanceID,
							// "parent" => $room_id,
							"id" => $index,
							"type" => $this->Translate($type),
							"room" => $room_name,
							"name" => $device_name,
							"manufacturer" => $manufacturer,
							"device_id" => $index,
							"address" => $address,
							"create" => [
								[
									"moduleID" => $device_guid,
									"configuration" => [
										"name" => $device_name,
										"type" => $type,
										"room_id" => $room_id,
										"room_name" => $room_name,
										"device_id" => $index,
										"address" => $address,
										"NumberIRCodes" => $ircount,
										"ircodes" => json_encode($ircodes)
									],
                                    "location" => $this->SetLocation($module_name, $room_name)
								]
							]
						];
					}
					elseif($device_guid == self::RFDEVICE)
					{
						$rfcodes = $device["RFCodes"];
						$rfcount = $device["Count"];
						$config_list[] = [
							"instanceID" => $instanceID,
							// "parent" => $room_id,
							"id" => $index,
							"type" => $this->Translate($type),
							"room" => $room_name,
							"name" => $device_name,
							"manufacturer" => $manufacturer,
							"device_id" => $index,
							"address" => $address,
							"create" => [
								[
									"moduleID" => $device_guid,
									"configuration" => [
										"name" => $device_name,
										"type" => $type,
										"room_id" => $room_id,
										"room_name" => $room_name,
										"device_id" => $index,
										"address" => $address,
										"NumberIRCodes" => $rfcount,
										"ircodes" => json_encode($rfcodes)
									],
                                    "location" => $this->SetLocation($module_name, $room_name)
								]
							]
						];
					}
					elseif($device_guid == self::HOMEMATIC)
					{
						// $newdevice = array("Address" => $HomematicAddress, "HomematicData" => $HomematicData, "HomematicSNR" => $HomematicSNR, "HomematicType" => $HomematicType, "Import" => false, "InstanceID" => 0, "Name" => $name, "Index" => $index, "Room_ID" => $room_id, "Manufacturer" => $manufacturer);
						$homematictype = $device["HomematicType"];
						$homematictypename = "";
						$homematiccategory = "";
						$homematicdeviceid = "";
						$config_list[] = [
							"instanceID" => $instanceID,
							// "parent" => $room_id,
							"id" => $index,
							"type" => $this->Translate($type),
							"room" => $room_name,
							"name" => $device_name,
							"manufacturer" => $manufacturer,
							"device_id" => $index,
							"address" => $address,
							"create" => [
								[
									"moduleID" => $device_guid,
									"configuration" => [
										"name" => $device_name,
										"type" => $type,
										"room_id" => $room_id,
										"room_name" => $room_name,
										"device_id" => $index,
										"address" => $address,
										"HomematicAddress" => $address,
										"HomematicType" => $homematictype,
										"HomematicTypeName" => $homematictypename,
										"HomematicCategory" => $homematiccategory,
										"HomematicTypeID" => $homematicdeviceid,
										"HomematicTypeNameID" => $homematicdeviceid,
										"HomematicSNR" => ""
									],
                                    "location" => $this->SetLocation($module_name, $room_name)
								]
							]
						];
					}
					elseif($device_guid == self::FS20)
					{
						$subtype = $device["Subtype"];
						$this->SendDebug('AIO Config', 'FS20 type: ' . $subtype , 0);
						$config_list[] = [
							"instanceID" => $instanceID,
							// "parent" => $room_id,
							"id" => $index,
							"type" => $this->Translate($subtype),
							"room" => $room_name,
							"name" => $device_name,
							"manufacturer" => $manufacturer,
							"device_id" => $index,
							"address" => $address,
							"create" => [
								[
									"moduleID" => $device_guid,
									"configuration" => [
										"name" => $device_name,
										"type" => $type,
										"room_id" => $room_id,
										"room_name" => $room_name,
										"device_id" => $index,
										"address" => $address,
										"AIOAdresse" => $address,
										"FS20Type" => $subtype
									],
                                    "location" => $this->SetLocation($module_name, $room_name)
								]
							]
						];
					}
					else
					{
						$config_list[] = [
							"instanceID" => $instanceID,
							// "parent" => $room_id,
							"id" => $index,
							"type" => $this->Translate($type),
							"room" => $room_name,
							"name" => $device_name,
							"manufacturer" => $manufacturer,
							"device_id" => $index,
							"address" => $address,
							"create" => [
								[
									"moduleID" => $device_guid,
									"configuration" => [
										"name" => $device_name,
										"type" => $type,
										"room_id" => $room_id,
										"room_name" => $room_name,
										"device_id" => $index,
										"address" => $address
									],
                                    "location" => $this->SetLocation($module_name, $room_name)
								]
							]
						];
					}

				}
			}
		}
		return $config_list;
	}



	private function SetLocation($module_name, $room_name)
	{
		$category = $this->ReadPropertyInteger("ImportCategoryID");
		$tree_position[] = IPS_GetName($category);
		$parent = IPS_GetObject($category)['ParentID'];
		$tree_position[] = IPS_GetName($parent);
		do {
			$parent = IPS_GetObject($parent)['ParentID'];
			$tree_position[] = IPS_GetName($parent);
		} while ($parent > 0);
		// delete last key
		end($tree_position);
		$lastkey = key($tree_position);
		unset($tree_position[$lastkey]);
		// reverse array
		$tree_position = array_reverse($tree_position);
		array_push($tree_position, $this->Translate($module_name));
		if($room_name != "")
		{
			array_push($tree_position, $room_name);
		}
		return $tree_position;
	}

	/**
	 * return form actions by token
	 * @return array
	 */
	protected function FormActions()
	{
		$form = [];

		return $form;
	}

	/**
	 * return from status
	 * @return array
	 */
	protected function FormStatus()
	{
		$form = [
			[
				'code' => IS_CREATING,
				'icon' => 'inactive',
				'caption' => 'Creating instance.'
			],
			[
				'code' => IS_ACTIVE,
				'icon' => 'active',
				'caption' => 'configuration valid.'
			],
			[
				'code' => IS_INACTIVE,
				'icon' => 'inactive',
				'caption' => 'interface closed.'
			],
			[
				'code' => 201,
				'icon' => 'inactive',
				'caption' => 'Please follow the instructions.'
			],
			[
				'code' => 202,
				'icon' => 'error',
				'caption' => 'field must not be empty.'
			],
			[
				'code' => 203,
				'icon' => 'error',
				'caption' => 'no file device_db found.'
			],
			[
				'code' => 204,
				'icon' => 'error',
				'caption' => 'no file ircodes.xml found.'
			],
			[
				'code' => 205,
				'icon' => 'error',
				'caption' => 'no file devices.xml found.'
			],
			[
				'code' => 206,
				'icon' => 'error',
				'caption' => 'directory not found.'
			],
			[
				'code' => 207,
				'icon' => 'error',
				'caption' => 'nothing found to import.'
			],
			[
				'code' => 208,
				'icon' => 'error',
				'caption' => 'AIO gateway IP address must not be empty.'
			],
			[
				'code' => 209,
				'icon' => 'error',
				'caption' => 'No valid IP address.'
			],
			[
				'code' => 210,
				'icon' => 'error',
				'caption' => 'connection lost to AIO Gateway.'
			],
			[
				'code' => 211,
				'icon' => 'error',
				'caption' => 'choose category for import.'
			]
		];

		return $form;
	}
	/***********************************************************
	 * Helper methods
	 ***********************************************************/

	/** Ergänzt SendDebug um Möglichkeit Objekte und Array auszugeben.
	 * @param string $Message Nachricht für Data.
	 * @param mixed $Data
	 * @param int $Format
	 * @return bool|void
	 */
	protected function SendDebug($Message, $Data, $Format)
	{
		if (is_object($Data)) {
			foreach ($Data as $Key => $DebugData) {

				$this->SendDebug($Message . ":" . $Key, $DebugData, 0);
			}
		} else if (is_array($Data)) {
			foreach ($Data as $Key => $DebugData) {
				$this->SendDebug($Message . ":" . $Key, $DebugData, 0);
			}
		} else if (is_bool($Data)) {
			$this->SendDebug($Message, ($Data ? 'TRUE' : 'FALSE'), 0);
		} else {
			if (IPS_GetKernelRunlevel() == KR_READY) {
				parent::SendDebug($Message, (string)$Data, $Format);
			} else {
				IPS_LogMessage('AIO Gateway Import:' . $Message, (string)$Data);
			}
		}
	}


	protected function GetIPSVersion()
	{
		$ipsversion = floatval(IPS_GetKernelVersion());
		if ($ipsversion < 4.1) // 4.0
		{
			$ipsversion = 0;
		} elseif ($ipsversion >= 4.1 && $ipsversion < 4.2) // 4.1
		{
			$ipsversion = 1;
		} elseif ($ipsversion >= 4.2 && $ipsversion < 4.3) // 4.2
		{
			$ipsversion = 2;
		} elseif ($ipsversion >= 4.3 && $ipsversion < 4.4) // 4.3
		{
			$ipsversion = 3;
		} elseif ($ipsversion >= 4.4 && $ipsversion < 5) // 4.4
		{
			$ipsversion = 4;
		} else   // 5
		{
			$ipsversion = 5;
		}

		return $ipsversion;
	}

	/***********************************************************
	 * Migrations
	 ***********************************************************/

	/**
	 * Polyfill for IP-Symcon 4.4 and older
	 * @param $Ident
	 * @param $Value
	 */
	protected function SetValue($Ident, $Value)
	{
		if (IPS_GetKernelVersion() >= 5) {
			parent::SetValue($Ident, $Value);
		} else if ($id = @$this->GetIDForIdent($Ident)) {
			SetValue($id, $Value);
		}
	}
}
