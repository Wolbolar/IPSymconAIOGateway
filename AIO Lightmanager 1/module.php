<?

require_once(__DIR__ . "/../AIOGatewayClass.php");  // diverse Klassen

class AIOLightmanager1 extends IPSModule
{

    
    public function Create()
    {
        //Never delete this line!
        parent::Create();

        // 1. Verfügbarer AIOSplitter wird verbunden oder neu erzeugt, wenn nicht vorhanden.
        $this->ConnectParent("{7E03C651-E5BF-4EC6-B1E8-397234992DB4}");
		
		$this->RegisterPropertyString("LEDAdresse", "");
		$this->RegisterPropertyBoolean("LearnAddressLED", false);
       
    }


    public function ApplyChanges()
    {
        //Never delete this line!
        parent::ApplyChanges();
		
		
		// Adresse prüfen
        $LEDAdresse = $this->ReadPropertyString('LEDAdresse');
		$LearnAddressLED = $this->ReadPropertyString('LearnAddressLED');
				
		if ($LearnAddressLED)
		{
			$this->Learn();
		}
		elseif ( $LEDAdresse == '')
        {
            // Status inaktiv
            $this->SetStatus(104);
        }
		else 
		{
			//Eingabe überprüfen
			if (strlen($LEDAdresse)<3 or strlen($LEDAdresse)>3)
				{
					$this->SetStatus(202);	
				}
			else
				{
				// Status aktiv
				$this->SetStatus(102);

				// Profile anlegen
				$this->RegisterProfileColor("Farbe.AIOLight1", "Paintbrush", "", "");
				$this->RegisterProfileIntegerEx("Szene.AIOLight1", "Sofa", "", "", Array(
													 Array(0, "Fade3",  "", -1),
													 Array(1, "Fade7",  "", -1),
													 Array(2, "Jump3",  "", -1),
													 Array(3, "Jump7",  "", -1),
													 Array(4, "Auto",  "", -1),
													 Array(5, "Flash",  "", -1)
				));
				$this->RegisterProfileIntegerEx("Brightness.AIOLight1", "Intensity", "", "", Array(
													 Array(0, "Down",  "", -1),
													 Array(1, "Up",  "", -1)
													
				));
				$this->RegisterProfileIntegerEx("Speed.AIOLight1", "Motion", "", "", Array(
													 Array(0, "SpeedDown",  "", -1),
													 Array(1, "SpeedUp",  "", -1)
													
				));

				//Status-Variablen anlegen
				$stateID = $this->RegisterVariableBoolean("Status", "Status", "~Switch", 1);
				$this->EnableAction("Status");
				
				//Farbe
				$stateID = $this->RegisterVariableInteger("Farbe", "Farbe", "Farbe.AIOLight1", 2);
				$this->EnableAction("Farbe");
				
				//Farbszenen
				$stateID = $this->RegisterVariableInteger("Szene", "Szene", "Szene.AIOLight1", 3);
				$this->EnableAction("Szene");
				
				//Play / Stop
				//$stateID = $this->RegisterVariableInteger("Play", "Play", "", 4);
				//$this->EnableAction("Play");
				
				//Helligkeit
				$stateID = $this->RegisterVariableInteger("Brightness", "Brightness", "Brightness.AIOLight1", 5);
				$this->EnableAction("Brightness");
				
				//Geschwindigkeit
				$stateID = $this->RegisterVariableInteger("Speed", "Speed", "Speed.AIOLight1", 6);
				$this->EnableAction("Speed");
				
				}
			
		}	
		

        
	}
	
	/**
    * Die folgenden Funktionen stehen automatisch zur Verfügung, wenn das Modul über die "Module Control" eingefügt wurden.
    * Die Funktionen werden, mit dem selbst eingerichteten Prefix, in PHP und JSON-RPC wiefolgt zur Verfügung gestellt:
    *
    *
    */
		
	public function RequestAction($Ident, $Value)
		{
			$adress = $this->ReadPropertyString("LEDAdresse");
			switch($Ident) {
				case "Status":
					$this->SetPowerState($Value);
					break;
				case "Farbe":
					switch($Value) {
						case 0: //Red
							$this->Red();
							break;
						case 1: //Orange
							$this->Orange();
							break;
						case 2: //Yellow
							$this->Yellow();
							break;
						case 3: //Green
							$this->Green();
							break;
						case 4: //Cyan
							$this->Cyan();
							break;
						case 5: //Blue
							$this->Blue();
							break;
						case 6: //Purple
							$this->Purple();
							break;
						case 7: //White
							$this->White();
							break;
					}
					break;	
				case "Szene":
					switch($Value) {
						case 0: //Fade3
							$this->Fade3();
							break;
						case 1: //Fade7
							$this->Fade7();
							break;
						case 2: //Jump3
							$this->Jump3();
							break;
						case 3: //Jump7
							$this->Jump7();
							break;
						case 4: //Auto
							$this->Auto();
							break;
						case 5: //Flash
							$this->Flash();
							break;
					}
					break;	
				case "Play":
					$this->Play_Pause();
					break;
				case "Brightness":
					switch($Value) {
						case 0: //Up
							$this->Up();
							break;
						case 1: //Down
							$this->Down();
							break;
					}
					break;	
				case "Speed":
					switch($Value) {
						case 0: //SpeedUp
							$this->SpeedDown();
							break;
						case 1: //SpeedDown
							$this->SpeedUp();
							break;
					}
					break;	
				default:
					throw new Exception("Invalid ident");
			}
		}	
		
	//IP Gateway 
	protected function GetIPGateway(){
			$ParentID = $this->GetParent();
			$IPGateway = IPS_GetProperty($ParentID, 'Host');
			return $IPGateway;
		}

	protected function GetPassword(){
		$ParentID = $this->GetParent();
		$GatewayPassword = IPS_GetProperty($ParentID, 'Passwort');
		return $GatewayPassword;
	}	
	
	protected function GetParent()
		{
			$instance = IPS_GetInstance($this->InstanceID);//array
			return ($instance['ConnectionID'] > 0) ? $instance['ConnectionID'] : false;//ConnectionID
		}
		
		
	protected function SetPowerState($state) {
			if ($state === true)
			{
			$adress = $this->ReadPropertyString("LEDAdresse");
			$command = "0C0";
			SetValueBoolean($this->GetIDForIdent('Status'), $state);
			return $this->Send_LED($adress, $command);
			}
			else
			{
			$adress = $this->ReadPropertyString("LEDAdresse");
			$command = "0C0";
			SetValueBoolean($this->GetIDForIdent('Status'), $state);
			return $this->Send_LED($adress, $command);
			}
		}
		
	public function Power() {
            $adress = $this->ReadPropertyString("LEDAdresse");
			$command = "0C0";
			return $this->Send_LED($adress, $command);
        }
		
		
		
	//Anlernen an Gateway
	// http://{GATEWAY_IP}/command?XC_FNC=learnSC&type=LS
		
	//Senden eines Befehls an LED Controller
	// Aufruf LED
	// http://{GATEWAY_IP}/command?XC_FNC=SendSC&type=LS&data=AAACMD
	// String /command?XC_FNC=SendSC&type=LS&data=
	// Der Wert für data setzt sich hierbei zusammen aus Adresse (AAA) und Kommando (CMD)
	// Beispiel: schalte ABC auf gelb:
	// http://{GATEWAY_IP}/command?XC_FNC=SendSC&type=LS&data=ABC0F0
	private $response = false;
	protected function Send_LED($adress, $command)
	{
		$response = false;
		$GatewayPassword = $this->GetPassword();
		IPS_LogMessage( "LED Adresse:" , $adress );
		IPS_LogMessage( "LED Command:" , $command );
		if ($GatewayPassword !== "")
		{
			$gwcheck = file_get_contents("http://".$this->GetIPGateway()."/command?XC_USER=user&XC_PASS=".$GatewayPassword."&XC_FNC=SendSC&type=LS&data=".$adress.$command);
		}
		else
		{
			$gwcheck = file_get_contents("http://".$this->GetIPGateway()."/command?XC_FNC=SendSC&type=LS&data=".$adress.$command);
		}
		if ($gwcheck == "{XC_SUC}")
			{
			$this->response = true;	
			}
		elseif ($gwcheck == "{XC_AUTH}")
			{
			$this->response = false;
			echo "Keine Authentifizierung möglich. Das Passwort für das Gateway ist falsch."
			}
		return $this->response;
	}
		
	
		
	public function Up()
		{
			$adress = $this->ReadPropertyString("LEDAdresse");
			$command = "003";
			SetValueInteger($this->GetIDForIdent('Brightness'), 0);
			return $this->Send_LED($adress, $command);
		}
		
	public function Down()
		{
			$adress = $this->ReadPropertyString("LEDAdresse");
			$command = "00C";
			SetValueInteger($this->GetIDForIdent('Brightness'), 1);
			return $this->Send_LED($adress, $command);
		}
		
	public function Play_Pause()
		{
			$adress = $this->ReadPropertyString("LEDAdresse");
			$command = "030";
			return $this->Send_LED($adress, $command);
		}
		
	public function Red()
		{
			$adress = $this->ReadPropertyString("LEDAdresse");
			$command = "00F";
			SetValueInteger($this->GetIDForIdent('Farbe'), 0);
			return $this->Send_LED($adress, $command);
		}
		
	public function Green()
		{
			$adress = $this->ReadPropertyString("LEDAdresse");
			$command = "033";
			SetValueInteger($this->GetIDForIdent('Farbe'), 3);
			return $this->Send_LED($adress, $command);
		}
		
	public function Blue()
		{
			$adress = $this->ReadPropertyString("LEDAdresse");
			$command = "0C3";
			SetValueInteger($this->GetIDForIdent('Farbe'), 5);
			return $this->Send_LED($adress, $command);
		}
		
	public function White()
		{
			$adress = $this->ReadPropertyString("LEDAdresse");
			$command = "03C";
			SetValueInteger($this->GetIDForIdent('Farbe'), 7);
			return $this->Send_LED($adress, $command);
		}
		
	public function Orange()
		{
			$adress = $this->ReadPropertyString("LEDAdresse");
			$command = "0CC";
			SetValueInteger($this->GetIDForIdent('Farbe'), 1);
			return $this->Send_LED($adress, $command);
		}
		
	public function Yellow()
		{
			$adress = $this->ReadPropertyString("LEDAdresse");
			$command = "0F0";
			SetValueInteger($this->GetIDForIdent('Farbe'), 2);
			return $this->Send_LED($adress, $command);
		}
		
	public function Cyan()
		{
			$adress = $this->ReadPropertyString("LEDAdresse");
			$command = "303";
			SetValueInteger($this->GetIDForIdent('Farbe'), 4);
			return $this->Send_LED($adress, $command);
		}
		
	public function Purple()
		{
			$adress = $this->ReadPropertyString("LEDAdresse");
			$command = "C03";
			SetValueInteger($this->GetIDForIdent('Farbe'), 6);
			return $this->Send_LED($adress, $command);
		}
		
	public function Auto()
		{
			$adress = $this->ReadPropertyString("LEDAdresse");
			$command = "30C";
			SetValueInteger($this->GetIDForIdent('Szene'), 4);
			return $this->Send_LED($adress, $command);
		}
		
	public function Jump3()
		{
			$adress = $this->ReadPropertyString("LEDAdresse");
			$command = "C0C";
			SetValueInteger($this->GetIDForIdent('Szene'), 2);
			return $this->Send_LED($adress, $command);
		}
		
	public function Fade3()
		{
			$adress = $this->ReadPropertyString("LEDAdresse");
			$command = "C30";
			SetValueInteger($this->GetIDForIdent('Szene'), 0);
			return $this->Send_LED($adress, $command);
		}
		
	public function Flash()
		{
			$adress = $this->ReadPropertyString("LEDAdresse");
			$command = "CC0";
			SetValueInteger($this->GetIDForIdent('Szene'), 5);
			return $this->Send_LED($adress, $command);
		}
		
	public function Jump7()
		{
			$adress = $this->ReadPropertyString("LEDAdresse");
			$command = "3C0";
			SetValueInteger($this->GetIDForIdent('Szene'), 3);
			return $this->Send_LED($adress, $command);
		}
		
	public function Fade7()
		{
			$adress = $this->ReadPropertyString("LEDAdresse");
			$command = "300";
			SetValueInteger($this->GetIDForIdent('Szene'), 1);
			return $this->Send_LED($adress, $command);
		}
		
	public function SpeedUp()
		{
			$adress = $this->ReadPropertyString("LEDAdresse");
			$command = "330";
			SetValueInteger($this->GetIDForIdent('Speed'), 0);
			return $this->Send_LED($adress, $command);
		}
		
	public function SpeedDown()
		{
			$adress = $this->ReadPropertyString("LEDAdresse");
			$command = "C00";
			SetValueInteger($this->GetIDForIdent('Speed'), 1);
			return $this->Send_LED($adress, $command);
		}
	
	//Anmelden eines LED Controllers an das a.i.o. gateway:
	//http://{IP-Adresse-des-Gateways}/command?XC_FNC=learnSC&type=LS
	public function Learn()
		{
		$ip_aiogateway = $this->GetIPGateway();
		$GatewayPassword = $this->GetPassword();
		if ($GatewayPassword !== "")
		{
			$address = file_get_contents("http://".$this->GetIPGateway()."/command?XC_USER=user&XC_PASS=".$GatewayPassword."&XC_FNC=learnSC&type=LS");
		}
		else
		{
			$address = file_get_contents("http://".$ip_aiogateway."/command?XC_FNC=learnSC&type=LS");
		}
		
		//kurze Pause während das Gateway im Lernmodus ist
		IPS_Sleep(1000); //1000 ms
		if ($address == "{XC_ERR}Failed to learn code")
			{
			$this->response = false;
			$instance = IPS_GetInstance($this->InstanceID)["InstanceID"];
			$address = "Das Gateway konnte keine Adresse empfangen.";
			IPS_LogMessage( "LED Adresse:" , $address );
			echo "Die Adresse des LED Controllers konnte nicht angelernt werden.";
			IPS_SetProperty($instance, "LearnAddressLED", false); //Haken entfernen.			
			}
		else
			{
				//Adresse auswerten {XC_SUC}
				//bei Erfolg {XC_SUC}{"CODE","ABCDEF00"} erste 6 Stellen sind die Adresse
				(string)$address = substr($address, 17, 3);
				IPS_LogMessage( "LED Adresse:" , $address );
				//echo "Adresse des LED Controllers: ".$address;
				$this->AddAddress($address);
				$this->response = true;	
			}
		
		return $this->response;
		}
	
	//LED Adresse hinzufügen
	protected function AddAddress($address)
	{
		$instance = IPS_GetInstance($this->InstanceID)["InstanceID"];
		IPS_SetProperty($instance, "LEDAdresse", $address); //Adresse setzten.
		IPS_SetProperty($instance, "LearnAddressLED", false); //Haken entfernen.
		IPS_ApplyChanges($instance); //Neue Konfiguration übernehmen
		IPS_LogMessage( "LED Controller Adresse hinzugefügt:" , $address );	
	}
	
	protected function RegisterProfileInteger($Name, $Icon, $Prefix, $Suffix, $MinValue, $MaxValue, $StepSize) {
        
        if(!IPS_VariableProfileExists($Name)) {
            IPS_CreateVariableProfile($Name, 1);
        } else {
            $profile = IPS_GetVariableProfile($Name);
            if($profile['ProfileType'] != 1)
            throw new Exception("Variable profile type does not match for profile ".$Name);
        }
        
        IPS_SetVariableProfileIcon($Name, $Icon);
        IPS_SetVariableProfileText($Name, $Prefix, $Suffix);
        IPS_SetVariableProfileValues($Name, $MinValue, $MaxValue, $StepSize);
		// boolean IPS_SetVariableProfileAssociation ( string $ProfilName, float $Wert, string $Name, string $Icon, integer $Farbe ) Farbwert im HTML Farbcode (z.b. 0x0000FF für Blau). Sonderfall: -1 für transparent
		IPS_SetVariableProfileAssociation($Name, 1, "Wert 1", "Speaker", 0xFFFFFF);
        
    }
	
	protected function RegisterProfileColor($Name, $Icon, $Prefix, $Suffix) {
        
        if(!IPS_VariableProfileExists($Name)) {
            IPS_CreateVariableProfile($Name, 1);
        } else {
            $profile = IPS_GetVariableProfile($Name);
            if($profile['ProfileType'] != 1)
            throw new Exception("Variable profile type does not match for profile ".$Name);
        }
        $MinValue = 0;
		$MaxValue = 7;
		$StepSize = 1;
        IPS_SetVariableProfileIcon($Name, $Icon);
        IPS_SetVariableProfileText($Name, $Prefix, $Suffix);
        IPS_SetVariableProfileValues($Name, $MinValue, $MaxValue, $StepSize);
		// boolean IPS_SetVariableProfileAssociation ( string $ProfilName, float $Wert, string $Name, string $Icon, integer $Farbe ) Farbwert im HTML Farbcode (z.b. 0x0000FF für Blau). Sonderfall: -1 für transparent
		IPS_SetVariableProfileAssociation($Name, 0, "Rot", "", 0xFE2E2E);
		IPS_SetVariableProfileAssociation($Name, 1, "Orange", "", 0xFFBF00);
		IPS_SetVariableProfileAssociation($Name, 2, "Gelb", "", 0xF7FE2E);
		IPS_SetVariableProfileAssociation($Name, 3, "Grün", "", 0x64FE2E);
		IPS_SetVariableProfileAssociation($Name, 4, "Cyan", "", 0x81F7F3);
		IPS_SetVariableProfileAssociation($Name, 5, "Blau", "", 0x0000FF);
		IPS_SetVariableProfileAssociation($Name, 6, "Lila", "", 0xDA81F5);
		IPS_SetVariableProfileAssociation($Name, 7, "Weiß", "", 0xFFFFFF);
        
    }
	
	protected function RegisterProfileIntegerEx($Name, $Icon, $Prefix, $Suffix, $Associations) {
        if ( sizeof($Associations) === 0 ){
            $MinValue = 0;
            $MaxValue = 0;
        } else {
            $MinValue = $Associations[0][0];
            $MaxValue = $Associations[sizeof($Associations)-1][0];
        }
        
        $this->RegisterProfileInteger($Name, $Icon, $Prefix, $Suffix, $MinValue, $MaxValue, 0);
        
        foreach($Associations as $Association) {
            IPS_SetVariableProfileAssociation($Name, $Association[0], $Association[1], $Association[2], $Association[3]);
        }
        
    }	
	
}

?>