<?

require_once(__DIR__ . "/../AIOGatewayClass.php");  // diverse Klassen

class AIOImport extends IPSModule
{

   
    public function Create()
    {
        //Never delete this line!
        parent::Create();

        // 1. Verfügbarer AIOSplitter wird verbunden oder neu erzeugt, wenn nicht vorhanden.
        $this->ConnectParent("{7E03C651-E5BF-4EC6-B1E8-397234992DB4}");
		
		$this->RegisterPropertyString("directory", "webfront/user/neo/");
		$this->RegisterPropertyInteger("Version", 0);
		$this->RegisterPropertyInteger("ImportCategoryID", 0);
		$this->RegisterPropertyBoolean("IRImport", false);
		$this->RegisterPropertyBoolean("ITImport", false);
		$this->RegisterPropertyBoolean("ELROImport", false);
		$this->RegisterPropertyBoolean("FS20Import", false);
		$this->RegisterPropertyBoolean("LM1Import", false);
		$this->RegisterPropertyBoolean("LM2Import", false);
		
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
			
		// directory  prüfen
		$directory = $this->ReadPropertyString('directory');
		$directoryIPS = IPS_GetKernelDir().$directory;
		if ( $directory == '')
			{
				// Status Error Felder dürfen nicht leer sein
				$this->SetStatus(202);
			}
		//Verzeichnis überprüfen	
		elseif (!file_exists($directoryIPS))
			{
				// Status Error Verzeichnis wurde nicht gefunden
				$this->SetStatus(206);	
					
			}
			
		//Version
		$Version = $this->ReadPropertyInteger('Version');
			
			
			
		//Import Kategorie
		$ImportCategoryID = $this->ReadPropertyInteger('ImportCategoryID');
		if ( $ImportCategoryID === 0)
			{
				// Status Error Kategorie zum Import auswählen
				$this->SetStatus(211);
			}
		elseif ( $ImportCategoryID != 0)	
			{
				// Status Error Kategorie zum Import auswählen
				$this->SetStatus(102);
			}
			
		//Importoptionen
		$IRImport = $this->ReadPropertyBoolean('IRImport');
		$ITImport = $this->ReadPropertyBoolean('ITImport');
		$ELROImport = $this->ReadPropertyBoolean('ELROImport');
		$FS20Import = $this->ReadPropertyBoolean('FS20Import');
		$LM1Import = $this->ReadPropertyBoolean('LM1Import');
		$LM2Import = $this->ReadPropertyBoolean('LM2Import');
		
		//Auswahl Prüfen
		if ($IRImport === false && $ITImport === false && $ELROImport === false && $FS20Import === false && $LM1Import === false && $LM2Import === false )
			{
				//$this->SetStatus(207); //Es wurde nichts zum Importieren ausgewählt
			}
		if ($IRImport === true)
			{
				//IR Import
				$this->IRImport($Version);
				//$instance = IPS_GetInstance($this->InstanceID)["InstanceID"];
				IPS_SetProperty($this->InstanceID, "IRImport", false); //Haken entfernen.
				IPS_ApplyChanges($this->InstanceID); //Neue Konfiguration übernehmen				
			}
		if ($ITImport === true)
			{
				//Intertechno Import
				$this->ITImport($Version);
				//$instance = IPS_GetInstance($this->InstanceID)["InstanceID"];
				IPS_SetProperty($this->InstanceID, "ITImport", false); //Haken entfernen.
				IPS_ApplyChanges($this->InstanceID); //Neue Konfiguration übernehmen
			}
		if ($ELROImport === true)
			{
				//ELRO Import
				$this->ELROImport($Version);
				//$instance = IPS_GetInstance($this->InstanceID)["InstanceID"];
				IPS_SetProperty($this->InstanceID, "ELROImport", false); //Haken entfernen.
				IPS_ApplyChanges($this->InstanceID); //Neue Konfiguration übernehmen
			}
		if ($FS20Import === true)
			{
				//FS20 Import
				$this->FS20Import($Version);
				//$instance = IPS_GetInstance($this->InstanceID)["InstanceID"];
				IPS_SetProperty($this->InstanceID, "FS20Import", false); //Haken entfernen.
				IPS_ApplyChanges($this->InstanceID); //Neue Konfiguration übernehmen
			}
		if ($LM1Import === true)
			{
				//Light Manager 1 Import
				$this->Light1Import($Version);
				//$instance = IPS_GetInstance($this->InstanceID)["InstanceID"];
				IPS_SetProperty($this->InstanceID, "LM1Import", false); //Haken entfernen.
				IPS_ApplyChanges($this->InstanceID); //Neue Konfiguration übernehmen
			}		
		if ($LM2Import === true)
			{
				//Light Manager 2 Import
				$this->Light2Import($Version);
				//$instance = IPS_GetInstance($this->InstanceID)["InstanceID"];
				IPS_SetProperty($this->InstanceID, "LM2Import", false); //Haken entfernen.
				IPS_ApplyChanges($this->InstanceID); //Neue Konfiguration übernehmen
			}	
			//$this->SetStatus(102); //IP Adresse ist gültig -> aktiv
	
	}
	
		
	
	protected function GetParent()
    {
        $instance = IPS_GetInstance($this->InstanceID);//array
		return ($instance['ConnectionID'] > 0) ? $instance['ConnectionID'] : false;//ConnectionID
    }
	
		
	//IP Gateway 
	protected function GetIPGateway(){
		$ParentID = $this->GetParent();
		$IPGateway = IPS_GetProperty($ParentID, 'Host');
		return $IPGateway;
	}
	
	protected function SetupCategory($CategoryName)
		{
			$ImportCategoryID = $this->ReadPropertyInteger('ImportCategoryID');
			//Prüfen ob Kategorie exitiert ansonsten anlegen
			$KategorieID = @IPS_GetCategoryIDByName($CategoryName, $ImportCategoryID);
			if ($KategorieID === false)
				{
				//echo "Kategorie nicht gefunden!";
				// Anlegen einer neuen Kategorie mit dem Namen "Mediola [Typ] Geräte"
				$CategoryID = $this->CreateCategory ($CategoryName);
				return $CategoryID;				
				}
				 
			else
				{
				 //Kategorie exixtiert
				 //echo "Die Kategorien-ID lautet: ". $KategorieID;
				 $CategoryID = $KategorieID;
				 return $CategoryID;
				}
		}
	
	// Anlegen einer neuen Kategorie 
	protected function CreateCategory ($CategoryName)	
		{
			$ImportCategoryID = $this->ReadPropertyInteger('ImportCategoryID');	
			$CatID = IPS_CreateCategory();       // Kategorie anlegen
			$CategoryName = (string)$CategoryName;
			IPS_SetName($CatID, $CategoryName); // Kategorie benennen
			IPS_SetParent($CatID, $ImportCategoryID); // Kategorie einsortieren unter dem Objekt mit der ID "$ImportCategoryID"
			return $CatID;
		}
	
	protected function IRImport($Version)
		{
			
			$CategoryID = $this->SetupCategory("Mediola IR Geräte");
			
			//Datei nach Version einlesen
			if ($Version === 0)	
				{
					//NEO device_db JSON
					$this->IRImportNeo($CategoryID);
				}
			else
				{
					//AIO Creator ircodes.xml, devices.xml
					$this->IRImportCreator($CategoryID);
				}
			
		}
	
	protected function ITImport($Version)
		{
			$CategoryID = $this->SetupCategory("Mediola IT Geräte");
			
			//Datei nach Version einlesen
			if ($Version === 0)	
				{
					//NEO device_db JSON
					$this->ITImportNeo($CategoryID);
					
				}
			elseif ($Version === 1)
				{
					//AIO Creator ircodes.xml, devices.xml
					$this->ITImportCreator($CategoryID);
				}
			
		}
	
	protected function ELROImport($Version)
		{
			$CategoryID = $this->SetupCategory("Mediola ELRO Geräte");
						
			//Datei nach Version einlesen
			if ($Version === 0)	
				{
					//NEO device_db JSON
					echo "ELRO Import NEO / JSON";
					$this->ELROImportNeo($CategoryID);
					
				}
			else
				{
					//AIO Creator ircodes.xml, devices.xml
					echo "ELRO Import Creator / XML";
					$this->ELROImportCreator($CategoryID);
				}
			
		}
	
	protected function FS20Import($Version)
		{
			$CategoryID = $this->SetupCategory("Mediola FS20 Geräte");
						
			//Datei nach Version einlesen
			if ($Version === 0)	
				{
					//NEO device_db JSON
					$this->FS20ImportNeo($CategoryID);
					
				}
			else
				{
					//AIO Creator ircodes.xml, devices.xml
					$this->FS20ImportCreator($CategoryID);
				}
			
		}
	
	protected function Light1Import($Version)
		{
			$CategoryID = $this->SetupCategory("Mediola Lightmanager 1 Geräte");
						
			//Datei nach Version einlesen
			if ($Version === 0)	
				{
					//NEO device_db JSON
					$this->Light1ImportNeo($CategoryID);
					
				}
			else
				{
					//AIO Creator ircodes.xml, devices.xml
					$this->Light1ImportCreator($CategoryID);
				}
			
		}
	
	protected function Light2Import($Version)
		{
			$CategoryID = $this->SetupCategory("Mediola Lightmanager 2 Geräte");
						
			//Datei nach Version einlesen
			if ($Version === 0)	
				{
					//NEO device_db JSON
					$this->Light2ImportNeo($CategoryID);
					
				}
			else
				{
					//AIO Creator ircodes.xml, devices.xml
					$this->Light2ImportCreator($CategoryID);
				}
			
		}
	
	//AIOITDevice Instanz erstellen 
	public function ITCreateInstance(string $InstName, string $ITFamilyCode, string $ITDeviceCode, string $ITType, integer $CategoryID)
	{
	//Prüfen ob Instanz schon existiert
	$InstanzID = @IPS_GetInstanceIDByName($InstName, $CategoryID);
	if ($InstanzID === false)
		{
			//echo "Instanz nicht gefunden!";
			//Neue Instanz anlegen
			$InsID = IPS_CreateInstance("{C45FF6B3-92E9-4930-B722-0A6193C7FFB5}");
			IPS_SetName($InsID, $InstName); // Instanz benennen
			IPS_SetParent($InsID, $CategoryID); // Instanz einsortieren unter dem Objekt mit der ID "$CategoryID"
			IPS_SetProperty($InsID, "ITFamilyCode", $ITFamilyCode); //Familiencode setzten.
			IPS_SetProperty($InsID, "ITDeviceCode", $ITDeviceCode); //Devicecode setzten.
			IPS_SetProperty($InsID, "ITType", $ITType); //Typ setzten.
			IPS_ApplyChanges($InsID); //Neue Konfiguration übernehmen
			IPS_LogMessage( "Instanz erstellt:" , "Name: ".$InstName );
			return $InsID;	
		}
			
	else
		{
			//echo "Die Instanz-ID lautet: ". $InstanzID;
			return $InstanzID;
		}	
	}	
	
	//AIOFS20 Instanz erstellen 
	public function FS20CreateInstance(string $InstName, string $AIOFS20Adresse, string $FS20Type, integer $CategoryID)
	{
	//Prüfen ob Instanz schon existiert
	$InstanzID = @IPS_GetInstanceIDByName($InstName, $CategoryID);
	if ($InstanzID === false)
		{
			//echo "Instanz nicht gefunden!";
			//Neue Instanz anlegen
			$InsID = IPS_CreateInstance("{8C7554CA-2530-4E6B-98DB-AC59CD6215A6}"); 
			IPS_SetName($InsID, $InstName); // Instanz benennen
			IPS_SetParent($InsID, $CategoryID); // Instanz einsortieren unter dem Objekt mit der ID "$CategoryID"
			IPS_SetProperty($InsID, "AIOAdresse", $AIOFS20Adresse); //AIOAdresse setzten.
			IPS_SetProperty($InsID, "FS20Type", $FS20Type); //Typ setzten.
			IPS_ApplyChanges($InsID); //Neue Konfiguration übernehmen
			IPS_LogMessage( "Instanz erstellt:" , "Name: ".$InstName );	
			return $InsID;	
		}
			
		else
			{
				//echo "Die Instanz-ID lautet: ". $InstanzID;
				return $InstanzID;
			}		
	}	
	
	//AIOIR Instanz erstellen 
	public function IRCreateInstance(string $InstName, integer $CategoryID)
	{
	//echo "Instanz IR anlegen";
	//Prüfen ob Instanz schon existiert
	$InstanzID = @IPS_GetInstanceIDByName($InstName, $CategoryID);
	if ($InstanzID === false)
		{
			//echo "Instanz nicht gefunden!";
			//Neue Instanz anlegen
			$InsID = IPS_CreateInstance("{4B0D8167-2932-4AD0-8455-26DC0C74485C}");
			$InstName = (string)$InstName;
			IPS_SetName($InsID, $InstName); // Instanz benennen
			IPS_SetParent($InsID, $CategoryID); // Instanz einsortieren unter dem Objekt mit der ID "$CategoryID"
			IPS_ApplyChanges($InsID); //Neue Konfiguration übernehmen
			IPS_LogMessage( "Instanz erstellt:" , "Name: ".$InstName );	
			return $InsID;	
		}
			
	else
		{
			//echo "Die Instanz-ID lautet: ". $InstanzID;
			return $InstanzID;
		}		
	}
		
	//IR Instanz löschen
	protected function IRDeleteInstance($InsID)
	{
	//Prüfen ob Instanz existiert
	$InstanzID = @IPS_GetInstance($InsID);
	if ($InstanzID === false)
		{
			//echo "Instanz nicht gefunden!";
			//Instanz muss nicht gelöscht werden, existiert nicht.
			return $InsID;	
		}
			
	else
		{
			//echo "Die Instanz-ID wurde gelöscht: ". $InstanzID;
			IPS_DeleteInstance($InsID);	
			return $InstanzID;
		}	
	}
	
	//IR Code zufügen		
	protected function IRAddCode($InsID, $ircodes, $count)
	{
		for ($i = 0; $i <= $count-1; $i++)
			{
			    $IRLabel = (string)"IRLabel".($i+1);
				$IRCode = (string)"IRCode".($i+1);
				$InsID = (integer)$InsID;
				(string)$label = $ircodes[$i][0];
				(string)$code = $ircodes[$i][1]; 
				IPS_SetProperty($InsID, $IRLabel, $label); //IR Label setzten.
				IPS_SetProperty($InsID, $IRCode, $code); //IR Code setzten.
			}
		IPS_SetProperty($InsID, "NumberIRCodes", $count); //Anzahl IR Codes setzten.
		IPS_ApplyChanges($InsID); //Neue Konfiguration übernehmen
		IPS_LogMessage( "IR Code hinzugefügt:" , "Name: ".$label );	
	}
	
	//AIOELRO Instanz erstellen 
	public function ELROCreateInstance(string $InstName, string $ELROFamilyCode, string $ELRODeviceCode, integer $CategoryID)
	{
	//Prüfen ob Instanz schon existiert
	$InstanzID = @IPS_GetInstanceIDByName($InstName, $CategoryID);
	if ($InstanzID === false)
		{
			//echo "Instanz nicht gefunden!";
			//Neue Instanz anlegen
			$InsID = IPS_CreateInstance("{1B755DCC-7F12-4136-8D14-2ED86E6609B7}");
			IPS_SetName($InsID, $InstName); // Instanz benennen
			IPS_SetParent($InsID, $CategoryID); // Instanz einsortieren unter dem Objekt mit der ID "$CategoryID"
			IPS_SetProperty($InsID, "ELROFamilyCode", $ELROFamilyCode); //Familiencode setzten.
			IPS_SetProperty($InsID, "ELRODeviceCode", $ELRODeviceCode); //Devicecode setzten.
			IPS_ApplyChanges($InsID); //Neue Konfiguration übernehmen
			IPS_LogMessage( "Instanz erstellt:" , "Name: ".$InstName );	
			return $InsID;	
		}
			
	else
		{
			//echo "Die Instanz-ID lautet: ". $InstanzID;
			return $InstanzID;
		}		
	}
		
	//AIOLight1 Instanz erstellen 
	public function Light1CreateInstance(string $InstName, string $LEDAdresse, integer $CategoryID)
		{
		//Prüfen ob Instanz schon existiert
		$InstanzID = @IPS_GetInstanceIDByName($InstName, $CategoryID);
		if ($InstanzID === false)
			{
				//echo "Instanz nicht gefunden!";
				//Neue Instanz anlegen
				$InsID = IPS_CreateInstance("{488F8C6E-9448-44AD-8015-DF9DAD3232F3}");
				IPS_SetName($InsID, $InstName); // Instanz benennen
				IPS_SetParent($InsID, $CategoryID); // Instanz einsortieren unter dem Objekt mit der ID "$CategoryID"
				IPS_SetProperty($InsID, "LEDAdresse", $LEDAdresse); //LEDAdresse setzten.
				IPS_ApplyChanges($InsID); //Neue Konfiguration übernehmen
				IPS_LogMessage( "Instanz erstellt:" , "Name: ".$InstName );	
				return $InsID;	
			}
			
		else
			{
				//echo "Die Instanz-ID lautet: ". $InstanzID;
				return $InstanzID;
			}		
		}

	//AIOLight2 Instanz erstellen 
	public function Light2CreateInstance(string $InstName, string $LEDAdresse, string $CategoryID)
		{
		//Prüfen ob Instanz schon existiert
		$InstanzID = @IPS_GetInstanceIDByName($InstName, $CategoryID);
		if ($InstanzID === false)
			{
				//echo "Instanz nicht gefunden!";
				//Neue Instanz anlegen
				$InsID = IPS_CreateInstance("{12E05C8F-C409-4061-8838-492744227EFF}");
				IPS_SetName($InsID, $InstName); // Instanz benennen
				IPS_SetParent($InsID, $CategoryID); // Instanz einsortieren unter dem Objekt mit der ID "$CategoryID"
				IPS_SetProperty($InsID, "LEDAdresse", $LEDAdresse); //LEDAdresse setzten.
				IPS_ApplyChanges($InsID); //Neue Konfiguration übernehmen
				IPS_LogMessage( "Instanz erstellt:" , "Name: ".$InstName );		
				return $InsID;	
			}
			
		else
			{
				//echo "Die Instanz-ID lautet: ". $InstanzID;
				return $InstanzID;
			}		
		}		
	
	
	/********************************************************
	*Import
	********************************************************/
	//Intertechno
	protected function ITImportNeo($CategoryID)
		{
			$directory = $this->ReadPropertyString('directory');
			$devicetype = "IT";
			$this->NEOJSONImport($devicetype, $directory, $CategoryID);		
		}
		
	protected function ITImportCreator($CategoryID)
		{
			$directory = $this->ReadPropertyString('directory');
			$file = IPS_GetKernelDir().$directory.'devices.xml';
			$type = "IT";
						
			if (file_exists($file))
				{
				//echo "Datei wurde gefunden";
				$xml = new SimpleXMLElement(file_get_contents($file));
					foreach($xml->xpath("//device[@type='".$type."']") as $device)
					{
					$adress = str_split($device['address']);
					$ITType = (string) $device['data'];
					$InstName = (string) $device['id'];
					// Anpassen der Daten
					$ITType = ucfirst($ITType); //erster Buchstabe groß
					$ITDeviceCode = strval($adress[2]+1); //Devicecode auf Original umrechen +1
					$ITFamilyCode = $adress[0]; // Zahlencode in Buchstaben Familencode umwandeln
					$hexsend = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
					$itfc = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J");
					$ITFamilyCode = str_replace($hexsend, $itfc, $ITFamilyCode);
					$this->ITCreateInstance($InstName, $ITFamilyCode, $ITDeviceCode, $ITType, $CategoryID);
					}
				}
			else
				{
				exit("Datei ".$file." konnte nicht geöffnet werden.");
				}
		}
	
	//FS20	
	protected function FS20ImportNeo($CategoryID)
		{
			$directory = $this->ReadPropertyString('directory');
			$devicetype = "FS20";
			$this->NEOJSONImport($devicetype, $directory, $CategoryID);			
		}
		
	protected function FS20ImportCreator($CategoryID)
		{
			$directory = $this->ReadPropertyString('directory');
			$file = IPS_GetKernelDir().$directory.'devices.xml';
			$type = "FS20";
						
			if (file_exists($file))
				{
				//echo "Datei wurde gefunden";
				$xml = new SimpleXMLElement(file_get_contents($file));
					foreach($xml->xpath("//device[@type='".$type."']") as $device)
					{
					 $AIOFS20Adresse = (string) $device['address'];
					 $FS20Type = (string) $device['data'];
					 $InstName = (string) $device['id'];
						
					// Anpassen der Daten
					$FS20Type = ucfirst($FS20Type); //erster Buchstabe groß
					$AIOFS20Adresse = str_replace(".", "", $AIOFS20Adresse);
					//echo "Funktion aufrufen mit ".$FS20Type." ".$AIOFS20Adresse." ".$InstName." <br>";
					$this->FS20CreateInstance($InstName, $AIOFS20Adresse, $FS20Type, $CategoryID);
					}
				}
			else
				{
				exit("Datei ".$file." konnte nicht geöffnet werden.");
				}
		}	
	
	//IR	
	protected function IRImportNeo($CategoryID)
		{
			//echo "IR Import NEO";
			$directory = $this->ReadPropertyString('directory');
			$devicetype = "CODE";
			$this->NEOJSONImport($devicetype, $directory, $CategoryID);
		}
		
	protected function IRImportCreator($CategoryID)
		{
			//echo "IR Import Creator in ".$CategoryID;
			$directory = $this->ReadPropertyString('directory');
			$file = IPS_GetKernelDir().$directory.'ircodes.xml';
			$type = "CODE";
						
			if (file_exists($file))
				{
				//echo "Datei wurde gefunden";
				$xml = new SimpleXMLElement(file_get_contents($file));
				foreach($xml->device as $device)
					{
					$name = $device['id'];
					//Prüfen ob IR Code für AIO Gateway
					$count = $device->key->count();
					$key = $device->key;
					$InsID = $this->IRCreateInstance($name, $CategoryID);
					$ircodes = array();
					for ($i = 0; $i <= $count-1; $i++)
						{
						    $ircodes[$i][0] = (string)$key[$i]['id'];
							$ircodes[$i][1] = (string)$key[$i]['code'];
							$valcode = substr(($ircodes[$i][1]), 0, 1);
							//del instanz
							if ($valcode == "{" || $valcode == "C")
								{
									$this->IRDeleteInstance($InsID);
									break;
								}
						}
					if($valcode != "{" || $valcode != "C")
						{
							$this->IRAddCode($InsID, $ircodes, $count); 
						}		
					
					}
				}
			else
				{
				exit("Datei ".$file." konnte nicht geöffnet werden.");
				}
		}

	protected function ELROImportNeo($CategoryID)
		{
			//-- Daten müssen aus JSON ausgelesen werden
			$InstName = "ELRO Export Test";
			
			$adress = str_split("0.2");
			// Anpassen der Daten
			$ELRODeviceCode = $adress[2]+1; //Devicecode auf Original umrechen +1
			$ELROFamilyCode = $adress[0]; // Zahlencode in Buchstaben Familencode umwandeln
			$hexsend = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
			$form = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J");
			$ELROFamilyCode = str_replace($hexsend, $form, $ELROFamilyCode);
			$this->ELROCreateInstance($InstName, $ELROFamilyCode, $ELRODeviceCode, $CategoryID);
		}
		
	protected function ELROImportCreator($CategoryID)
		{
			/*
			$directory = $this->ReadPropertyString('directory');
			$file = IPS_GetKernelDir().$directory.'devices.xml';
			$type = "ELRO";
						
			if (file_exists($file))
				{
				//echo "Datei wurde gefunden";
				$xml = new SimpleXMLElement(file_get_contents($file));
					foreach($xml->xpath("//device[@type='".$type."']") as $device)
					{
					 $adress = $device['address'];
					 $ELROType = $device['data'];
					 $InstName = $device['id'];
					
					$this->FS20CreateInstance($InstName, $AIOELROAdresse, $ELROType, $CategoryID);
					}
				}
			else
				{
				exit("Datei ".$file." konnte nicht geöffnet werden.");
				}
			*/
			//-- Daten müssen aus XML ausgelesen werden
			$InstName = "ELRO Export Test";
			
			$adress = str_split("0.2");
			// Anpassen der Daten
			$ELRODeviceCode = $adress[2]+1; //Devicecode auf Original umrechen +1
			$ELROFamilyCode = $adress[0]; // Zahlencode in Buchstaben Familencode umwandeln
			$hexsend = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
			$form = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J");
			$ELROFamilyCode = str_replace($hexsend, $form, $ELROFamilyCode);
			$this->ELROCreateInstance($InstName, $ELROFamilyCode, $ELRODeviceCode, $CategoryID);
		}			
		
	protected function Light1ImportNeo($CategoryID)
		{
			$directory = $this->ReadPropertyString('directory');
			$devicetype = "LEDS";
			$this->NEOJSONImport($devicetype, $directory, $CategoryID);	
		}
		
	protected function Light1ImportCreator($CategoryID)
		{
			$directory = $this->ReadPropertyString('directory');
			$file = IPS_GetKernelDir().$directory.'devices.xml';
			$type = "LEDS";
									
			if (file_exists($file))
				{
				//echo "Datei wurde gefunden";
				$xml = new SimpleXMLElement(file_get_contents($file));
					foreach($xml->xpath("//device[@type='".$type."']") as $device)
					{
						$LEDAdresse = (string) $device['address'];
						$InstName = (string) $device['id'];
						$this->Light1CreateInstance($InstName, $LEDAdresse, $CategoryID);
					}
				}
			else
				{
				exit("Datei ".$file." konnte nicht geöffnet werden.");
				}
		}

	protected function Light2ImportNeo($CategoryID)
		{
			$directory = $this->ReadPropertyString('directory');
			$devicetype = "L2";
			$this->NEOJSONImport($devicetype, $directory, $CategoryID);	
		}
		
	protected function Light2ImportCreator($CategoryID)
		{
			$directory = $this->ReadPropertyString('directory');
			$file = IPS_GetKernelDir().$directory.'devices.xml';
			$type = "L2";
									
			if (file_exists($file))
				{
				//echo "Datei wurde gefunden";
				$xml = new SimpleXMLElement(file_get_contents($file));
					foreach($xml->xpath("//device[@type='".$type."']") as $device)
					{
						$LEDAdresse = (string) $device['address'];
						$InstName = (string) $device['id'];
						$this->Light2CreateInstance($InstName, $LEDAdresse, $CategoryID);
					}
				}
			else
				{
				exit("Datei ".$file." konnte nicht geöffnet werden.");
				}
			
		}
	

	//Type
	/*
	* IT (Intertechno)
	* FS20
	* CODE (IR Codes)
	* LEDS
	* L2
	*/	
	protected function NEOJSONImport($devicetype, $directory, $CategoryID)
	{
		//echo "NEOJSONImport";
	// get file
	$file =  IPS_GetKernelDir().$directory.'device_db';

	// convert the string to a json object
	$json = json_decode(file_get_contents($file));

	// copy the devices array to a php var
	$devices = $json->devices;
	
	// listing devices
	foreach ($devices as $device)
		{
	   $name = $device->name; //Device name
		$sys = $device->info->sys; //System
	     //sys ist aio beim AIO Gateway und type IT (Intertechno), FS20, CODE (IR) , Lightmanager LEDS, L2
	   if ($sys == "aio" && isset($device->info->type))
			{
			$type = $device->info->type; //Type
			if ($type == $devicetype)
				{
				if (isset($device->info->address)) {
				    $address = $device->info->address; //Adress
					}
				if (isset($device->info->data)) {
				    $data = $device->info->data; //Switch / Dimmer
				    }
				if (isset($device->info->address) && isset($device->info->data)) //Lightmanager hat keinen data typ
				   {
				    //passende Instanz anlegen
					switch ($type)
					   {
							case "FS20": //FS20
								// Anpassen der Daten
								$FS20Type = ucfirst($data); //erster Buchstabe groß
								$AIOFS20Adresse = str_replace(".", "", $address);
								$this->FS20CreateInstance($name, $AIOFS20Adresse, $FS20Type, $CategoryID);
								 break;
							case "IT": //Intertechno
								// Anpassen der Daten
								$adress = str_split($address);
								$ITType = ucfirst($data); //erster Buchstabe groß
								$ITDeviceCode = $adress[2]+1; //Devicecode auf Original umrechen +1
								$ITFamilyCode = $adress[0]; // Zahlencode in Buchstaben Familencode umwandeln
								$hexsend = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
								$itfc = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J");
								$ITFamilyCode = str_replace($hexsend, $itfc, $ITFamilyCode);
								$this->ITCreateInstance($name, $ITFamilyCode, $ITDeviceCode, $ITType, $CategoryID);
								 break;
						}
				   }
				if (isset($device->info->address) && !isset($device->info->data)) //Lightmanager hat keinen data typ
					{
					//passende Instanz anlegen
					switch ($type)
					   {
							case "LEDS": //Light Manager 1
								$this->Light1CreateInstance($name, $address, $CategoryID);
								 break;
							case "L2": //Light Manager 2
								$this->Light2CreateInstance($name, $address, $CategoryID);
								 break;			
						}
					}
				//IR Codes adress (IR:01) Sendediode
				if (isset($device->info->ircodes))
					{
					$codes = $device->info->ircodes->codes;
					//Prüfen ob IR Code für AIO Gateway
					$InsID = $this->IRCreateInstance($name, $CategoryID);
					$key = $device->info->ircodes->codes;
					$count = count($key);
					$ircodes = array();
					for ($i = 0; $i <= $count-1; $i++)
						{
						    $ircodes[$i][0]  = $key[$i]->key;
							$ircodes[$i][1] = $key[$i]->code;
							$code = $ircodes[$i][1];
							$valcode = substr($code, 0, 1);
							//del instanz
							if ($valcode == "{")
								{
									$this->IRDeleteInstance($InsID);
									break;
								}
						}	
					$this->IRAddCode($InsID, $ircodes, $count); 
					}
				}
			}		
		}
	}


		
}

?>