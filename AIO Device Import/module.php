<?

require_once(__DIR__ . "/../AIOGatewayClass.php");  // diverse Klassen

class AIOImport extends IPSModule
{

   
    public function Create()
    {
        //Never delete this line!
        parent::Create();

        // 1. Verf�gbarer AIOSplitter wird verbunden oder neu erzeugt, wenn nicht vorhanden.
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
		$this->RegisterPropertyBoolean("SomfyImport", false);
		$this->RegisterPropertyBoolean("RFImport", false);
		$this->RegisterPropertyBoolean("HomematicImport", false);
		$this->RegisterPropertyBoolean("RoomImport", false);
    }


    public function ApplyChanges()
    {
        //Never delete this line!
        parent::ApplyChanges();
		
		$this->ValidateConfiguration();
		
			
	}
		
	/**
    * Die folgenden Funktionen stehen automatisch zur Verf�gung, wenn das Modul �ber die "Module Control" eingef�gt wurden.
    * Die Funktionen werden, mit dem selbst eingerichteten Prefix, in PHP und JSON-RPC wiefolgt zur Verf�gung gestellt:
    *
	* PUBLIC
    */
 
	private function ValidateConfiguration()
	{
			
		// directory  pr�fen
		$directory = $this->ReadPropertyString('directory');
		$directoryIPS = IPS_GetKernelDir().$directory;
		if ( $directory == '')
			{
				// Status Error Felder d�rfen nicht leer sein
				$this->SetStatus(202);
			}
		//Verzeichnis �berpr�fen	
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
				// Status Error Kategorie zum Import ausw�hlen
				$this->SetStatus(211);
			}
		elseif ( $ImportCategoryID != 0)	
			{
				// Status Error Kategorie zum Import ausw�hlen
				$this->SetStatus(102);
			}
			
		//Importoptionen
		$IRImport = $this->ReadPropertyBoolean('IRImport');
		$ITImport = $this->ReadPropertyBoolean('ITImport');
		$ELROImport = $this->ReadPropertyBoolean('ELROImport');
		$FS20Import = $this->ReadPropertyBoolean('FS20Import');
		$LM1Import = $this->ReadPropertyBoolean('LM1Import');
		$LM2Import = $this->ReadPropertyBoolean('LM2Import');
		$SomfyImport = $this->ReadPropertyBoolean('SomfyImport');
		$RFImport = $this->ReadPropertyBoolean('RFImport');
		$HomematicImport = $this->ReadPropertyBoolean('HomematicImport');
		$RoomImport = $this->ReadPropertyBoolean('RoomImport');
		
		//Auswahl Pr�fen
		if ($IRImport === false && $ITImport === false && $ELROImport === false && $FS20Import === false && $LM1Import === false && $LM2Import === false && $SomfyImport === false && $RFImport === false && $HomematicImport && $RoomImport)
			{
				//$this->SetStatus(207); //Es wurde nichts zum Importieren ausgew�hlt
			}
		if ($IRImport === true)
			{
				//IR Import
				$this->IRImport($Version);
				//$instance = IPS_GetInstance($this->InstanceID)["InstanceID"];
				IPS_SetProperty($this->InstanceID, "IRImport", false); //Haken entfernen.
				IPS_ApplyChanges($this->InstanceID); //Neue Konfiguration �bernehmen				
			}
		if ($ITImport === true)
			{
				//Intertechno Import
				$this->ITImport($Version);
				//$instance = IPS_GetInstance($this->InstanceID)["InstanceID"];
				IPS_SetProperty($this->InstanceID, "ITImport", false); //Haken entfernen.
				IPS_ApplyChanges($this->InstanceID); //Neue Konfiguration �bernehmen
			}
		if ($ELROImport === true)
			{
				//ELRO Import
				$this->ELROImport($Version);
				//$instance = IPS_GetInstance($this->InstanceID)["InstanceID"];
				IPS_SetProperty($this->InstanceID, "ELROImport", false); //Haken entfernen.
				IPS_ApplyChanges($this->InstanceID); //Neue Konfiguration �bernehmen
			}
		if ($FS20Import === true)
			{
				//FS20 Import
				$this->FS20Import($Version);
				//$instance = IPS_GetInstance($this->InstanceID)["InstanceID"];
				IPS_SetProperty($this->InstanceID, "FS20Import", false); //Haken entfernen.
				IPS_ApplyChanges($this->InstanceID); //Neue Konfiguration �bernehmen
			}
		if ($LM1Import === true)
			{
				//Light Manager 1 Import
				$this->Light1Import($Version);
				//$instance = IPS_GetInstance($this->InstanceID)["InstanceID"];
				IPS_SetProperty($this->InstanceID, "LM1Import", false); //Haken entfernen.
				IPS_ApplyChanges($this->InstanceID); //Neue Konfiguration �bernehmen
			}		
		if ($LM2Import === true)
			{
				//Light Manager 2 Import
				$this->Light2Import($Version);
				//$instance = IPS_GetInstance($this->InstanceID)["InstanceID"];
				IPS_SetProperty($this->InstanceID, "LM2Import", false); //Haken entfernen.
				IPS_ApplyChanges($this->InstanceID); //Neue Konfiguration �bernehmen
			}
		if ($SomfyImport === true)
			{
				//Somfy Import
				$this->SomfyImport($Version);
				//$instance = IPS_GetInstance($this->InstanceID)["InstanceID"];
				IPS_SetProperty($this->InstanceID, "SomfyImport", false); //Haken entfernen.
				IPS_ApplyChanges($this->InstanceID); //Neue Konfiguration �bernehmen
			}		
		if ($RFImport === true)
			{
				//RF Import
				$this->RFImport($Version);
				//$instance = IPS_GetInstance($this->InstanceID)["InstanceID"];
				IPS_SetProperty($this->InstanceID, "RFImport", false); //Haken entfernen.
				IPS_ApplyChanges($this->InstanceID); //Neue Konfiguration �bernehmen
			}
		if ($HomematicImport === true)
			{
				//RF Import
				$this->HomematicImport($Version);
				//$instance = IPS_GetInstance($this->InstanceID)["InstanceID"];
				IPS_SetProperty($this->InstanceID, "HomematicImport", false); //Haken entfernen.
				IPS_ApplyChanges($this->InstanceID); //Neue Konfiguration �bernehmen
			}	
		if ($RoomImport === true)
			{
				//RF Import
				$this->RFImport($Version);
				//$instance = IPS_GetInstance($this->InstanceID)["InstanceID"];
				IPS_SetProperty($this->InstanceID, "RoomImport", false); //Haken entfernen.
				IPS_ApplyChanges($this->InstanceID); //Neue Konfiguration �bernehmen
			}			
		//$this->SetStatus(102); //IP Adresse ist g�ltig -> aktiv
	
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
	
	
	
	protected function SetupCategory($CategoryName, $ParentID)
		{
			//Pr�fen ob Kategorie exitiert ansonsten anlegen
			$KategorieID = @IPS_GetCategoryIDByName($CategoryName, $ParentID);
			if ($KategorieID === false)
				{
				$this->SendDebug("AIO Import","Kategorie nicht gefunden!",0);
				// Anlegen einer neuen Kategorie mit dem Namen "Mediola [Typ] Ger�te"
				$CategoryID = $this->CreateCategory ($CategoryName, $ParentID);
				$this->SendDebug("AIO Import","Kategorie ".$CategoryName." angelegt.",0);
				return $CategoryID;				
				}
				 
			else
				{
				 //Kategorie exixtiert
				 $this->SendDebug("AIO Import","Kategorie ".$CategoryName." exixtiert mit ObjektID ".$KategorieID,0);
				 $CategoryID = $KategorieID;
				 return $CategoryID;
				}
		}
	
	// Anlegen einer neuen Kategorie 
	protected function CreateCategory ($CategoryName, $ParentID)	
		{
			$ImportCategoryID = $this->ReadPropertyInteger('ImportCategoryID');	
			$CatID = IPS_CreateCategory();       // Kategorie anlegen
			$CategoryName = (string)$CategoryName;
			IPS_SetName($CatID, $CategoryName); // Kategorie benennen
			IPS_SetParent($CatID, $ParentID); // Kategorie einsortieren unter dem Objekt mit der ID "$ParentID"
			return $CatID;
		}
	
	protected function IRImport($Version)
		{
			$ImportCategoryID = $this->ReadPropertyInteger('ImportCategoryID');
			$CategoryID = $this->SetupCategory("Mediola IR Ger�te", $ImportCategoryID);
			
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
			$ImportCategoryID = $this->ReadPropertyInteger('ImportCategoryID');
			$CategoryID = $this->SetupCategory("Mediola IT Ger�te", $ImportCategoryID);
			
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
			$ImportCategoryID = $this->ReadPropertyInteger('ImportCategoryID');
			$CategoryID = $this->SetupCategory("Mediola ELRO Ger�te", $ImportCategoryID);
						
			//Datei nach Version einlesen
			if ($Version === 0)	
				{
					//NEO device_db JSON
					$this->ELROImportNeo($CategoryID);
					
				}
			else
				{
					//AIO Creator ircodes.xml, devices.xml
					$this->ELROImportCreator($CategoryID);
				}
			
		}
	
	protected function FS20Import($Version)
		{
			$ImportCategoryID = $this->ReadPropertyInteger('ImportCategoryID');
			$CategoryID = $this->SetupCategory("Mediola FS20 Ger�te", $ImportCategoryID);
						
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
			$ImportCategoryID = $this->ReadPropertyInteger('ImportCategoryID');
			$CategoryID = $this->SetupCategory("Mediola Lightmanager 1 Ger�te", $ImportCategoryID);
						
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
			$ImportCategoryID = $this->ReadPropertyInteger('ImportCategoryID');
			$CategoryID = $this->SetupCategory("Mediola Lightmanager 2 Ger�te", $ImportCategoryID);
						
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
		
	protected function SomfyImport($Version)
		{
			$ImportCategoryID = $this->ReadPropertyInteger('ImportCategoryID');
			$CategoryID = $this->SetupCategory("Somfy Ger�te", $ImportCategoryID);
						
			//Datei nach Version einlesen
			if ($Version === 0)	
				{
					//NEO device_db JSON
					$this->SomfyImportNeo($CategoryID);
					
				}
			else
				{
					//AIO Creator ircodes.xml, devices.xml
					$this->SomfyImportCreator($CategoryID);
				}
			
		}	
	
	protected function RFImport($Version)
		{
			$ImportCategoryID = $this->ReadPropertyInteger('ImportCategoryID');
			$CategoryID = $this->SetupCategory("Funk Ger�te", $ImportCategoryID);
						
			//Datei nach Version einlesen
			if ($Version === 0)	
				{
					//NEO device_db JSON
					$this->RFImportNeo($CategoryID);
					
				}
			else
				{
					//AIO Creator ircodes.xml, devices.xml
					$this->RFImportCreator($CategoryID);
				}
			
		}	
	
	protected function HomematicImport($Version)
		{
			$ImportCategoryID = $this->ReadPropertyInteger('ImportCategoryID');
			$CategoryID = $this->SetupCategory("Homematic Ger�te", $ImportCategoryID);
						
			//Datei nach Version einlesen
			if ($Version === 0)	
				{
					//NEO device_db JSON
					$this->HomematicImportNeo($CategoryID);
					
				}
			else
				{
					//AIO Creator ircodes.xml, devices.xml
					$this->HomematicImportCreator($CategoryID);
				}
			
		}
	
	//AIOITDevice Instanz erstellen 
	public function ITCreateInstance(string $InstName, string $Ident, string $ITFamilyCode, string $ITDeviceCode, string $ITType, integer $CategoryID)
	{
	//Pr�fen ob Instanz schon existiert
	$InstanzID = @IPS_GetObjectIDByIdent($Ident, $CategoryID);
	//$InstanzID = @IPS_GetInstanceIDByName($InstName, $CategoryID);
	if ($InstanzID === false)
		{
			//echo "Instanz nicht gefunden!";
			//Neue Instanz anlegen
			$InsID = IPS_CreateInstance("{C45FF6B3-92E9-4930-B722-0A6193C7FFB5}");
			IPS_SetName($InsID, $InstName); // Instanz benennen
			IPS_SetIdent ($InsID, $Ident); // Ident
			IPS_SetParent($InsID, $CategoryID); // Instanz einsortieren unter dem Objekt mit der ID "$CategoryID"
			IPS_SetProperty($InsID, "ITFamilyCode", $ITFamilyCode); //Familiencode setzten.
			IPS_SetProperty($InsID, "ITDeviceCode", $ITDeviceCode); //Devicecode setzten.
			IPS_SetProperty($InsID, "ITType", $ITType); //Typ setzten.
			IPS_ApplyChanges($InsID); //Neue Konfiguration �bernehmen
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
	public function FS20CreateInstance(string $InstName, string $Ident, string $AIOFS20Adresse, string $FS20Type, integer $CategoryID)
	{
	//Pr�fen ob Instanz schon existiert
	$InstanzID = @IPS_GetObjectIDByIdent($Ident, $CategoryID);
	//$InstanzID = @IPS_GetInstanceIDByName($InstName, $CategoryID);
	if ($InstanzID === false)
		{
			//echo "Instanz nicht gefunden!";
			//Neue Instanz anlegen
			$InsID = IPS_CreateInstance("{8C7554CA-2530-4E6B-98DB-AC59CD6215A6}"); 
			IPS_SetName($InsID, $InstName); // Instanz benennen
			IPS_SetIdent ($InsID, $Ident); // Ident
			IPS_SetParent($InsID, $CategoryID); // Instanz einsortieren unter dem Objekt mit der ID "$CategoryID"
			IPS_SetProperty($InsID, "AIOAdresse", $AIOFS20Adresse); //AIOAdresse setzten.
			IPS_SetProperty($InsID, "FS20Type", $FS20Type); //Typ setzten.
			IPS_ApplyChanges($InsID); //Neue Konfiguration �bernehmen
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
	public function IRCreateInstance(string $InstName, string $Ident, integer $CategoryID)
	{
	//echo "Instanz IR anlegen";
	//Pr�fen ob Instanz schon existiert
	$InstanzID = @IPS_GetObjectIDByIdent($Ident, $CategoryID);
	//$InstanzID = @IPS_GetInstanceIDByName($InstName, $CategoryID);
	if ($InstanzID === false)
		{
			//echo "Instanz nicht gefunden!";
			//Neue Instanz anlegen
			$InsID = IPS_CreateInstance("{4B0D8167-2932-4AD0-8455-26DC0C74485C}");
			$InstName = (string)$InstName;
			IPS_SetName($InsID, $InstName); // Instanz benennen
			IPS_SetIdent ($InsID, $Ident); // Ident
			IPS_SetParent($InsID, $CategoryID); // Instanz einsortieren unter dem Objekt mit der ID "$CategoryID"
			IPS_ApplyChanges($InsID); //Neue Konfiguration �bernehmen
			IPS_LogMessage( "Instanz erstellt:" , "Name: ".$InstName );	
			return $InsID;	
		}
			
	else
		{
			//echo "Die Instanz-ID lautet: ". $InstanzID;
			return $InstanzID;
		}		
	}
		
	//Instanz l�schen
	protected function DeleteInstance($InsID)
	{
	//Pr�fen ob Instanz existiert
	$InstanzID = @IPS_GetInstance($InsID);
	if ($InstanzID === false)
		{
			//echo "Instanz nicht gefunden!";
			//Instanz muss nicht gel�scht werden, existiert nicht.
			return $InsID;	
		}
			
	else
		{
			//echo "Die Instanz-ID wurde gel�scht: ". $InstanzID;
			IPS_DeleteInstance($InsID);	
			return $InstanzID;
		}	
	}
	
	//IR Code zuf�gen		
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
		IPS_ApplyChanges($InsID); //Neue Konfiguration �bernehmen
		IPS_LogMessage( "IR Code hinzugef�gt:" , "Name: ".$label );	
	}
	
	//AIORF Instanz erstellen 
	public function RFCreateInstance(string $InstName, string $Ident, string $Ident, integer $CategoryID)
	{
	//echo "Instanz RF anlegen";
	//Pr�fen ob Instanz schon existiert
	
	$InstanzID = @IPS_GetObjectIDByIdent($Ident, $CategoryID);
	//$InstanzID = @IPS_GetInstanceIDByName($InstName, $CategoryID);
	if ($InstanzID === false)
		{
			//echo "Instanz nicht gefunden!";
			//Neue Instanz anlegen
			$InsID = IPS_CreateInstance("{8BFB0E47-BA7E-44B3-A8DE-95243B3DB186}");
			$InstName = (string)$InstName;
			IPS_SetName($InsID, $InstName); // Instanz benennen
			IPS_SetIdent ($InsID, $Ident); // Ident
			IPS_SetParent($InsID, $CategoryID); // Instanz einsortieren unter dem Objekt mit der ID "$CategoryID"
			IPS_ApplyChanges($InsID); //Neue Konfiguration �bernehmen
			IPS_LogMessage( "Instanz erstellt:" , "Name: ".$InstName );	
			return $InsID;	
		}
			
	else
		{
			//echo "Die Instanz-ID lautet: ". $InstanzID;
			return $InstanzID;
		}		
	}
		
		
	//RF Code zuf�gen		
	protected function RFAddCode($InsID, $rfcodes, $count)
	{
		for ($i = 0; $i <= $count-1; $i++)
			{
			    $RFLabel = (string)"RFLabel".($i+1);
				$RFCode = (string)"RFCode".($i+1);
				$InsID = (integer)$InsID;
				(string)$label = $rfcodes[$i][0];
				(string)$code = $rfcodes[$i][1]; 
				IPS_SetProperty($InsID, $RFLabel, $label); //IR Label setzten.
				IPS_SetProperty($InsID, $RFCode, $code); //IR Code setzten.
			}
		IPS_SetProperty($InsID, "NumberRFCodes", $count); //Anzahl IR Codes setzten.
		IPS_ApplyChanges($InsID); //Neue Konfiguration �bernehmen
		IPS_LogMessage( "RF Code hinzugef�gt:" , "Name: ".$label );	
	}
	
	//AIOELRO Instanz erstellen 
	public function ELROCreateInstance(string $InstName, string $Ident, string $ELROAdresse, string $ELROType, integer $CategoryID)
	{
	//Pr�fen ob Instanz schon existiert
	$InstanzID = @IPS_GetObjectIDByIdent($Ident, $CategoryID);
	//$InstanzID = @IPS_GetInstanceIDByName($InstName, $CategoryID);
	if ($InstanzID === false)
		{
			//echo "Instanz nicht gefunden!";
			//Neue Instanz anlegen
			$InsID = IPS_CreateInstance("{1B755DCC-7F12-4136-8D14-2ED86E6609B7}");
			IPS_SetName($InsID, $InstName); // Instanz benennen
			IPS_SetIdent ($InsID, $Ident); // Ident
			IPS_SetParent($InsID, $CategoryID); // Instanz einsortieren unter dem Objekt mit der ID "$CategoryID"
			IPS_SetProperty($InsID, "ELROAddress", $ELROAdresse); //ELROAddress setzten.
			IPS_ApplyChanges($InsID); //Neue Konfiguration �bernehmen
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
	public function Light1CreateInstance(string $InstName, string $Ident, string $LEDAdresse, integer $CategoryID)
		{
		//Pr�fen ob Instanz schon existiert
		$InstanzID = @IPS_GetObjectIDByIdent($Ident, $CategoryID);
		//$InstanzID = @IPS_GetInstanceIDByName($InstName, $CategoryID);
		if ($InstanzID === false)
			{
				//echo "Instanz nicht gefunden!";
				//Neue Instanz anlegen
				$InsID = IPS_CreateInstance("{488F8C6E-9448-44AD-8015-DF9DAD3232F3}");
				IPS_SetName($InsID, $InstName); // Instanz benennen
				IPS_SetIdent ($InsID, $Ident); // Ident
				IPS_SetParent($InsID, $CategoryID); // Instanz einsortieren unter dem Objekt mit der ID "$CategoryID"
				IPS_SetProperty($InsID, "LEDAdresse", $LEDAdresse); //LEDAdresse setzten.
				IPS_ApplyChanges($InsID); //Neue Konfiguration �bernehmen
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
	public function Light2CreateInstance(string $InstName, string $Ident, string $LEDAdresse, string $CategoryID)
		{
		//Pr�fen ob Instanz schon existiert
		$InstanzID = @IPS_GetObjectIDByIdent($Ident, $CategoryID);
	    //$InstanzID = @IPS_GetInstanceIDByName($InstName, $CategoryID);
		if ($InstanzID === false)
			{
				//echo "Instanz nicht gefunden!";
				//Neue Instanz anlegen
				$InsID = IPS_CreateInstance("{12E05C8F-C409-4061-8838-492744227EFF}");
				IPS_SetName($InsID, $InstName); // Instanz benennen
				IPS_SetIdent ($InsID, $Ident); // Ident
				IPS_SetParent($InsID, $CategoryID); // Instanz einsortieren unter dem Objekt mit der ID "$CategoryID"
				IPS_SetProperty($InsID, "LEDAdresse", $LEDAdresse); //LEDAdresse setzten.
				IPS_ApplyChanges($InsID); //Neue Konfiguration �bernehmen
				IPS_LogMessage( "Instanz erstellt:" , "Name: ".$InstName );		
				return $InsID;	
			}
			
		else
			{
				//echo "Die Instanz-ID lautet: ". $InstanzID;
				return $InstanzID;
			}		
		}		
	
	//Somfy Instanz erstellen 
	public function SomfyCreateInstance(string $InstName, string $Ident, string $AIOSomfyAdresse, string $SomfyType, string $CategoryID)
		{
		//Pr�fen ob Instanz schon existiert
		$InstanzID = @IPS_GetObjectIDByIdent($Ident, $CategoryID);
	    //$InstanzID = @IPS_GetInstanceIDByName($InstName, $CategoryID);
		if ($InstanzID === false)
			{
				//echo "Instanz nicht gefunden!";
				//Neue Instanz anlegen
				$InsID = IPS_CreateInstance("{0F83D875-4737-4244-8234-4CF08E6F2626}");
				IPS_SetName($InsID, $InstName); // Instanz benennen
				IPS_SetIdent ($InsID, $Ident); // Ident
				IPS_SetParent($InsID, $CategoryID); // Instanz einsortieren unter dem Objekt mit der ID "$CategoryID"
				IPS_SetProperty($InsID, "Adresse", $AIOSomfyAdresse); //Adresse setzten.
				IPS_ApplyChanges($InsID); //Neue Konfiguration �bernehmen
				IPS_LogMessage( "Instanz erstellt:" , "Name: ".$InstName );		
				return $InsID;	
			}
			
		else
			{
				//echo "Die Instanz-ID lautet: ". $InstanzID;
				return $InstanzID;
			}		
		}	
	
	//Homematic Instanz erstellen 
	public function HomematicCreateInstance(string $InstName, string $Ident, string $HomematicAdress, string $HomematicData, string $HomematicSNR, string $HomematicType, integer $CategoryID)
	{
	//Pr�fen ob Instanz schon existiert
	$InstanzID = @IPS_GetObjectIDByIdent($Ident, $CategoryID);
	//$InstanzID = @IPS_GetInstanceIDByName($InstName, $CategoryID);
	if ($InstanzID === false)
		{
			//echo "Instanz nicht gefunden!";
			if($HomematicType == "00AC") // powerswitch
			{
				//Neue Instanz anlegen
				$InsID = IPS_CreateInstance("{484B3E98-4395-4E65-A0D3-BDEE013A4B1A}");
			}
			elseif($HomematicType == "0066") // switch
			{
				//Neue Instanz anlegen
				$InsID = IPS_CreateInstance("{562CC7AE-0BD7-4C97-9E5B-0C9D6DD73F40}");
			}
			elseif($HomematicType == "0095") // thermocontrol
			{
				//Neue Instanz anlegen
				$InsID = IPS_CreateInstance("{9CA28339-2DCB-4295-9C22-EBCDE6025052}");
			}
			elseif($HomematicType == "00F4") // sensor RGB Controller
			{
				//Neue Instanz anlegen
				$InsID = IPS_CreateInstance("{54E09F68-FE44-4E09-9E4B-B66D20CB970E}");
			}
			IPS_SetName($InsID, $InstName); // Instanz benennen
			IPS_SetIdent ($InsID, $Ident); // Ident
			IPS_SetParent($InsID, $CategoryID); // Instanz einsortieren unter dem Objekt mit der ID "$CategoryID"
			IPS_SetProperty($InsID, "HomematicAddress", $HomematicAdress); // HomematicAddress setzten.
			IPS_SetProperty($InsID, "HomematicData", $HomematicData); // HomematicData setzten.
			IPS_SetProperty($InsID, "HomematicSNR", $HomematicSNR); // HomematicSNR setzten.
			IPS_SetProperty($InsID, "HomematicType", $HomematicType); // HomematicType setzten.	
			IPS_SetProperty($InsID, "HomematicTypeName", $HomematicTypeName); // HomematicTypeName setzten.	
			IPS_ApplyChanges($InsID); //Neue Konfiguration �bernehmen
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
			$subtype = "IT";
			$this->NEOJSONImport($devicetype, $directory, $CategoryID, $subtype);		
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
					$ITType = ucfirst($ITType); //erster Buchstabe gro�
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
				exit("Datei ".$file." konnte nicht ge�ffnet werden.");
				}
		}
	
	//FS20	
	protected function FS20ImportNeo($CategoryID)
		{
			$directory = $this->ReadPropertyString('directory');
			$devicetype = "FS20";
			$subtype = "FS20";
			$this->NEOJSONImport($devicetype, $directory, $CategoryID, $subtype);			
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
					$FS20Type = ucfirst($FS20Type); //erster Buchstabe gro�
					$AIOFS20Adresse = str_replace(".", "", $AIOFS20Adresse);
					//echo "Funktion aufrufen mit ".$FS20Type." ".$AIOFS20Adresse." ".$InstName." <br>";
					$this->FS20CreateInstance($InstName, $AIOFS20Adresse, $FS20Type, $CategoryID);
					}
				}
			else
				{
				exit("Datei ".$file." konnte nicht ge�ffnet werden.");
				}
		}	
	
	//Somfy	
	protected function SomfyImportNeo($CategoryID)
		{
			$directory = $this->ReadPropertyString('directory');
			$devicetype = "RT";
			$subtype = "RT";
			$this->NEOJSONImport($devicetype, $directory, $CategoryID, $subtype);			
		}
		
	protected function SomfyImportCreator($CategoryID)
		{
			$directory = $this->ReadPropertyString('directory');
			$file = IPS_GetKernelDir().$directory.'devices.xml';
			$type = "RT";
						
			if (file_exists($file))
				{
				//echo "Datei wurde gefunden";
				$xml = new SimpleXMLElement(file_get_contents($file));
					foreach($xml->xpath("//device[@type='".$type."']") as $device)
					{
					 $AIOSomfyAdresse = (string) $device['address'];
					 $SomfyType = (string) $device['data'];
					 $InstName = (string) $device['id'];
						
					// Anpassen der Daten
					$SomfyType = ucfirst($SomfyType); //erster Buchstabe gro�
					$AIOSomfyAdresse = str_replace(".", "", $AIOSomfyAdresse);
					$this->SomfyCreateInstance($InstName, $AIOSomfyAdresse, $SomfyType, $CategoryID);
					}
				}
			else
				{
				exit("Datei ".$file." konnte nicht ge�ffnet werden.");
				}
		}	
	
	//RF	
	protected function RFImportNeo($CategoryID)
		{
			//echo "RF Import NEO";
			$directory = $this->ReadPropertyString('directory');
			$devicetype = "CODE";
			$subtype = "RF";
			$this->NEOJSONImport($devicetype, $directory, $CategoryID, $subtype);
		}
	
	protected function RFImportCreator($CategoryID)
		{
			//echo "RF Import Creator in ".$CategoryID;
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
					//Pr�fen ob IR Code f�r AIO Gateway
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
				exit("Datei ".$file." konnte nicht ge�ffnet werden.");
				}
		}
	
	
	//IR	
	protected function IRImportNeo($CategoryID)
		{
			//echo "IR Import NEO";
			$directory = $this->ReadPropertyString('directory');
			$devicetype = "CODE";
			$subtype = "IR";
			$this->NEOJSONImport($devicetype, $directory, $CategoryID, $subtype);
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
					//Pr�fen ob IR Code f�r AIO Gateway
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
				exit("Datei ".$file." konnte nicht ge�ffnet werden.");
				}
		}

	protected function ELROImportNeo($CategoryID)
		{
			$directory = $this->ReadPropertyString('directory');
			$devicetype = "ELRO";
			$subtype = "ELRO";
			$this->NEOJSONImport($devicetype, $directory, $CategoryID, $subtype);	
		}
		
	protected function ELROImportCreator($CategoryID)
		{
			$directory = $this->ReadPropertyString('directory');
			$file = IPS_GetKernelDir().$directory.'devices.xml';
			$type = "ELRO";
						
			if (file_exists($file))
				{
				//echo "Datei wurde gefunden";
				$xml = new SimpleXMLElement(file_get_contents($file));
					foreach($xml->xpath("//device[@type='".$type."']") as $device)
					{
					 $ELROAdresse = (string) $device['address'];
					 $ELROType = (string) $device['data'];
					 $InstName = (string) $device['id'];
						
					// Anpassen der Daten
					//$ELROType = ucfirst($ELROType); //erster Buchstabe gro�
					$ELROAdresse = str_replace(".", "", $ELROAdresse);
					$this->ELROCreateInstance($InstName, $ELROAdresse, $ELROType, $CategoryID);
					}
				}
			else
				{
				exit("Datei ".$file." konnte nicht ge�ffnet werden.");
				}
		}			
		
	protected function Light1ImportNeo($CategoryID)
		{
			$directory = $this->ReadPropertyString('directory');
			$devicetype = "LEDS";
			$subtype = "LED1";
			$this->NEOJSONImport($devicetype, $directory, $CategoryID, $subtype);	
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
				exit("Datei ".$file." konnte nicht ge�ffnet werden.");
				}
		}

	protected function Light2ImportNeo($CategoryID)
		{
			$directory = $this->ReadPropertyString('directory');
			$devicetype = "L2";
			$subtype = "LED2";
			$this->NEOJSONImport($devicetype, $directory, $CategoryID, $subtype);	
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
				exit("Datei ".$file." konnte nicht ge�ffnet werden.");
				}
			
		}
	
	// Homematic	
	protected function HomematicImportNeo($CategoryID)
		{
			$directory = $this->ReadPropertyString('directory');
			$devicetype = "HM";
			$subtype = "HM";
			$this->NEOJSONImport($devicetype, $directory, $CategoryID, $subtype);			
		}
		
	protected function HomematicImportCreator($CategoryID)
		{
			$directory = $this->ReadPropertyString('directory');
			$file = IPS_GetKernelDir().$directory.'devices.xml';
			$type = "HM";
						
			if (file_exists($file))
				{
				//echo "Datei wurde gefunden";
				$xml = new SimpleXMLElement(file_get_contents($file));
					foreach($xml->xpath("//device[@type='".$type."']") as $device)
					{
					 $HomematicAdress = (string) $device['address'];
					 $HomematicData = (string) $device['data'];
					 $InstName = (string) $device['id'];
					 $HomematicSNR = (string) $device['snr'];
					 $HomematicType = (string) $device['typecode'];
					// Anpassen der Daten
					//$HomematicType = ucfirst($HomematicType); //erster Buchstabe gro�
					$HomematicAdress = str_replace(".", "", $HomematicAdress);
					$Ident = $HomematicAdress;
					$this->HomematicCreateInstance($InstName, $Ident, $HomematicAdress, $HomematicData, $HomematicSNR, $HomematicType, $CategoryID);
					
					}
				}
			else
				{
				exit("Datei ".$file." konnte nicht ge�ffnet werden.");
				}
		}	

	//Type
	/*
	* IT (Intertechno)
	* FS20
	* CODE (IR Codes)
	* LEDS
	* L2
	* ELRO
	*/	
	protected function NEOJSONImport($devicetype, $directory, $CategoryID, $subtype)
	{
		//echo "NEOJSONImport";
		// get file
		$file =  IPS_GetKernelDir().$directory.'device_db';

		// convert the string to a json object
		$json = json_decode(file_get_contents($file));
	
		//rooms auslesen
		$rooms = $json->rooms;
		$ImportCategoryID = $this->ReadPropertyInteger('ImportCategoryID');
		$roomcatid = $this->SetupCategory("R�ume", $ImportCategoryID);	
		
		$roomsneo = array();
		foreach ($rooms as $key => $room)
			{
				$roomname = $room->name;
				$roomindex = $room->index;
				$roomnameprogs = stripos($roomname, "_progs&sysvars");
				$roomnamecamera = stripos($roomname, "_cameras");
				$roomnamewebpages = stripos($roomname, "_webpages");
				if(($roomnamewebpages === false) && ($roomnameprogs === false) && ($roomnamecamera === false))
				{
					$roomsneo[$key] = array("name" => $roomname, "index" => $roomindex);
					$this->SetupCategory($roomname, $roomcatid);
				}
			}
		
			
		//var_dump($roomsneo);
	
	
	
		// copy the devices array to a php var
		$devices = $json->devices;
		
		// listing devices
		foreach ($devices as $device)
		{
		   $name = $device->name; //Device name
			$sys = $device->info->sys; //System
			//sys ist aio beim AIO Gateway und type IT (Intertechno), FS20, CODE (IR)oder (RF:01) , Lightmanager LEDS, L2, RT (Somfy), 
			if ($sys == "aio" && isset($device->info->type))
			{
				$type = $device->info->type; //Type
				if ($type == $devicetype)
				{
					if (isset($device->info->address)) {
						$address = $device->info->address; //Adresse
						$Ident = $address;
						}
					if (isset($device->info->data)) {
						$data = $device->info->data; //Switch / Dimmer / shutter
						}
					if (isset($device->info->address) && isset($device->info->data)) //Lightmanager hat keinen data typ
					   {
						//passende Instanz anlegen
						switch ($type)
						   {
								case "FS20": //FS20
									// Anpassen der Daten
									$FS20Type = ucfirst($data); //erster Buchstabe gro�
									$AIOFS20Adresse = str_replace(".", "", $address);
									$this->FS20CreateInstance($name, $Ident, $AIOFS20Adresse, $FS20Type, $CategoryID);
									 break;
								case "RT": //Somfy
									// Anpassen der Daten
									$SomfyType = $data;
									$SomfyAdresse = $address;
									$this->SomfyCreateInstance($name, $Ident, $address, $data, $CategoryID);
									 break;
								case "ELRO": //ELRO
									// Anpassen der Daten
									$ELROType = $data;
									$ELROAdresse = $address;
									$this->ELROCreateInstance($name, $Ident, $ELROAdresse, $ELROType, $CategoryID);
									 break;
								case "HM": // Homematic
									// Anpassen der Daten
									$HomematicAdress = $address;
									$HomematicData = $data;
									$HomematicSNR = $device->info->snr; // Seriennummer
									$HomematicType = $device->info->typecode; // Typencode
									// Anpassen der Daten
									//$HomematicType = ucfirst($HomematicType); //erster Buchstabe gro�
									$HomematicAdress = str_replace(".", "", $HomematicAdress);
									$Ident = $HomematicAdress;
									$this->HomematicCreateInstance($name, $Ident, $HomematicAdress, $HomematicData, $HomematicSNR, $HomematicType, $CategoryID);
									break;	 
								case "IT": //Intertechno
									// Anpassen der Daten
									$adress = str_split($address);
									$ITType = ucfirst($data); //erster Buchstabe gro�
									$ITDeviceCode = $adress[2]+1; //Devicecode auf Original umrechen +1
									$ITFamilyCode = $adress[0]; // Zahlencode in Buchstaben Familencode umwandeln
									$hexsend = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
									$itfc = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J");
									$ITFamilyCode = str_replace($hexsend, $itfc, $ITFamilyCode);
									$this->ITCreateInstance($name, $Ident, $ITFamilyCode, $ITDeviceCode, $ITType, $CategoryID);
									 break;
							}
					   }
					if (isset($device->info->address) && !isset($device->info->data)) //Lightmanager hat keinen data typ
						{
						//passende Instanz anlegen
						switch ($type)
						   {
								case "LEDS": //Light Manager 1
									$this->Light1CreateInstance($name, $Ident, $address, $CategoryID);
									 break;
								case "L2": //Light Manager 2
									$this->Light2CreateInstance($name, $Ident, $address, $CategoryID);
									 break;			
							}
						}
					//IR oder RF Codes adress (IR:01) Sendediode oder RF:01
					if (isset($device->info->ircodes) && $subtype == "RF" && $address == "RF:01") // Funkger�t
						{
							$codes = $device->info->ircodes->codes;
							$key = $device->info->ircodes->codes;
							$count = count($key);
							for ($i = 0; $i <= $count-1; $i++)
							{
								$Ident = $subtype."_".$i;
							}	
							
							$InsID = $this->RFCreateInstance($name, $Ident, $CategoryID);
							
							$rfcodes = array();
							for ($i = 0; $i <= $count-1; $i++)
							{
								$rfcodes[$i][0]  = $key[$i]->key;
								$rfcodes[$i][1] = $key[$i]->code;
								$code = $rfcodes[$i][1];
								$valcode = substr($code, 0, 1);
								//del instanz
								if ($valcode == "{")
									{
										$this->DeleteInstance($InsID);
										break;
									}
							}	
							$this->RFAddCode($InsID, $rfcodes, $count); 
						}
					elseif(isset($device->info->ircodes) && $subtype == "IR" && $address == "IR:01") // IR Ger�t
						{
							$key = $device->info->ircodes->codes;
							$count = count($key);
							for ($i = 0; $i <= $count-1; $i++)
							{
								$Ident = $subtype."_".$i;
							}
							$InsID = $this->IRCreateInstance($name, $Ident, $CategoryID);
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
											$this->DeleteInstance($InsID);
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