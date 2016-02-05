<?

require_once(__DIR__ . "/../AIOGatewayClass.php");  // diverse Klassen

class AIOLightmanager2 extends IPSModule
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

		//Mögliche Prüfungen durchführen
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
			
			if (strlen($LEDAdresse)<6 or strlen($LEDAdresse)>6)
				{
					$this->SetStatus(202);	
				}
			else
				{
					// Status aktiv
					$this->SetStatus(102);
					
					// Profile anlegen
					$this->RegisterProfileColor("Farbe.AIOLight2", "Paintbrush", "", "");
					$this->RegisterProfileIntegerEx("Cursor.AIOLight2", "Bulb", "", "", Array(
														 Array(0, "Left",  "", -1),
														 Array(1, "Up",  "", -1),
														 Array(2, "Down",  "", -1),
														 Array(3, "Right",  "", -1)
					));
					$this->RegisterProfileIntegerEx("Brightness.AIOLight2", "Intensity", "", "", Array(
														 Array(0, "Stufe 1",  "", -1),
														 Array(1, "Stufe 2",  "", -1),
														 Array(2, "Stufe 3",  "", -1),
														 Array(3, "Stufe 4",  "", -1),
														 Array(4, "Stufe 5",  "", -1),
														 Array(5, "Stufe 6",  "", -1),
														 Array(6, "Stufe 7",  "", -1),
														 Array(7, "Stufe 8",  "", -1),
														 Array(8, "Stufe 9",  "", -1)
														 
														
					));
					

					//Status-Variablen anlegen
					$stateID = $this->RegisterVariableBoolean("Status", "Status", "~Switch", 1);
					$this->EnableAction("Status");
					
					//Farbe
					$colorID = $this->RegisterVariableInteger("Farbe", "Farbe", "Farbe.AIOLight2", 2);
					$this->EnableAction("Farbe");
					
					//Cursor
					$cursorID = $this->RegisterVariableInteger("Cursor", "Cursor", "Cursor.AIOLight2", 3);
					$this->EnableAction("Cursor");
					
					//Helligkeit
					$brightnessID = $this->RegisterVariableInteger("Helligkeit", "Helligkeit", "Brightness.AIOLight2", 4);
					$this->EnableAction("Helligkeit");
					
					//Farbauswahl
					$colorselectID = $this->RegisterVariableInteger("Farbauswahl", "Farbauswahl", "~HexColor", 5);
					$this->EnableAction("Farbauswahl");
					
								
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
			$address = $this->ReadPropertyString("LEDAdresse");
			switch($Ident) {
				case "Status":
					$this->LMPowerSetState($Value);
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
				case "Cursor":
					switch($Value) {
						case 0: //Left
							$this->Left();
							break;
						case 1: //Up
							$this->Up();
							break;
						case 2: //Down
							$this->Down();
							break;
						case 3: //Right
							$this->Right();
							break;
					}
					break;
				case "Farbauswahl":
					$this->Colorselect($Value);
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
		
	protected function LMPowerSetState (boolean $state){
			SetValueBoolean($this->GetIDForIdent('Status'), $state);
			return $this->SetPowerState($state);	
		}
		
	protected function SetPowerState(boolean $state) {
			if ($state === true)
			{
			$address = $this->ReadPropertyString("LEDAdresse");
			$command = "02";
			return $this->Send_LED($address, $command);
			}
			else
			{
			$address = $this->ReadPropertyString("LEDAdresse");
			$command = "01";
			return $this->Send_LED($address, $command);
			}
		}
		
	public function Power() {
            $address = $this->ReadPropertyString("LEDAdresse");
			$command = "02";
			return $this->Send_LED($address, $command);
        }
	
	public function PowerOn() {
            $address = $this->ReadPropertyString("LEDAdresse");
			$command = "02";
			return $this->Send_LED($address, $command);
        }
	
	public function PowerOff() {
            $address = $this->ReadPropertyString("LEDAdresse");
			$command = "01";
			return $this->Send_LED($address, $command);
        }

	public function Left() {
            $address = $this->ReadPropertyString("LEDAdresse");
			$command = "05";
			SetValueInteger($this->GetIDForIdent('Cursor'), 0);
			return $this->Send_LED($address, $command);
        }
			
	public function LeftHold() {
            $address = $this->ReadPropertyString("LEDAdresse");
			$command = "07";
			return $this->Send_LED($address, $command);
        }
	
	public function Right() {
            $address = $this->ReadPropertyString("LEDAdresse");
			$command = "06";
			SetValueInteger($this->GetIDForIdent('Cursor'), 3);
			return $this->Send_LED($address, $command);
        }
	
	public function Up() {
            $address = $this->ReadPropertyString("LEDAdresse");
			$command = "03";
			SetValueInteger($this->GetIDForIdent('Cursor'), 1);
			return $this->Send_LED($address, $command);
        }
	
	public function Down() {
            $address = $this->ReadPropertyString("LEDAdresse");
			$command = "04";
			SetValueInteger($this->GetIDForIdent('Cursor'), 2);
			return $this->Send_LED($address, $command);
        }
		
	public function Red() {
            $address = $this->ReadPropertyString("LEDAdresse");
			$command = "0198";
			$Arraddress = str_split($address);
			$ArrCommand = str_split($command);
			$Arraddress[4] = dechex(hexdec($Arraddress[4]) + $ArrCommand[0]);
			$Arraddress[5] = dechex(hexdec($Arraddress[5]) + $ArrCommand[1]);
			$address = $Arraddress[0].$Arraddress[1].$Arraddress[2].$Arraddress[3].$Arraddress[4].$Arraddress[5];
			$command = $ArrCommand[2].$ArrCommand[3];
			SetValueInteger($this->GetIDForIdent('Farbe'), 0);
			return $this->Send_LED($address, $command);
        }
			
	public function Purple() {
            $address = $this->ReadPropertyString("LEDAdresse");
			$command = "28";
			SetValueInteger($this->GetIDForIdent('Farbe'), 6);
			return $this->Send_LED($address, $command);
        }
	
	public function Blue() {
            $address = $this->ReadPropertyString("LEDAdresse");
			$command = "50";
			SetValueInteger($this->GetIDForIdent('Farbe'), 5);
			return $this->Send_LED($address, $command);
        }
		
	public function Cyan() {
            $address = $this->ReadPropertyString("LEDAdresse");
			$command = "98";
			SetValueInteger($this->GetIDForIdent('Farbe'), 4);
			return $this->Send_LED($address, $command);
        }	
	
	public function Green() {
            $address = $this->ReadPropertyString("LEDAdresse");
			$command = "F0";
			SetValueInteger($this->GetIDForIdent('Farbe'), 3);
			return $this->Send_LED($address, $command);
        }
	
	public function Yellow() {
            $address = $this->ReadPropertyString("LEDAdresse");
			$command = "0150";
			$Arraddress = str_split($address);
			$ArrCommand = str_split($command);
			$Arraddress[4] = dechex(hexdec($Arraddress[4]) + $ArrCommand[0]);
			$Arraddress[5] = dechex(hexdec($Arraddress[5]) + $ArrCommand[1]);
			$address = $Arraddress[0].$Arraddress[1].$Arraddress[2].$Arraddress[3].$Arraddress[4].$Arraddress[5];
			$command = $ArrCommand[2].$ArrCommand[3];
			SetValueInteger($this->GetIDForIdent('Farbe'), 2);
			return $this->Send_LED($address, $command);
        }
	
	public function White() {
            $address = $this->ReadPropertyString("LEDAdresse");
			$command = "06";
			SetValueInteger($this->GetIDForIdent('Farbe'), 7);
			return $this->Send_LED($address, $command);
        }
	
	public function Orange() {
            $address = $this->ReadPropertyString("LEDAdresse");
			$command = "0170";
			$Arraddress = str_split($address);
			$ArrCommand = str_split($command);
			$Arraddress[4] = dechex(hexdec($Arraddress[4]) + $ArrCommand[0]);
			$Arraddress[5] = dechex(hexdec($Arraddress[5]) + $ArrCommand[1]);
			$address = $Arraddress[0].$Arraddress[1].$Arraddress[2].$Arraddress[3].$Arraddress[4].$Arraddress[5];
			$command = $ArrCommand[2].$ArrCommand[3];
			SetValueInteger($this->GetIDForIdent('Farbe'), 1);
			return $this->Send_LED($address, $command);
        }
	
	public function Auto() {
            $address = $this->ReadPropertyString("LEDAdresse");
			$command = "07";
			return $this->Send_LED($address, $command);
        }
		
	public function Color()
		{
            $address = $this->ReadPropertyString("LEDAdresse");
			$command = "06"; // color RGB Farbwert
			return $this->Send_LED($address, $command);
        }
		
		
	public function Colorselect(integer $Value)
		{
            SetValueInteger($this->GetIDForIdent('Farbauswahl'), $Value);
			
			// HEX-Wert in einzelne Werte für Rot / Grün / Blau zerlegen
			$r = (($Value >> 16) & 0xFF);
			$g = (($Value >> 8) & 0xFF);
			$b = (($Value >> 0) & 0xFF);
			
			// Farbsättigung
			/**
			Berechnung der Helligkeit aus den RGB-Werten mit fs = 255
			http://www.w3.org/TR/2006/WD-WCAG20-20060427/appendixA.html#luminosity-contrastdef

			 Der Controller hat insgesamt 9 Helligkeitsstufen.
			*/
			$fs=255;
			$Helligkeit= 0.2126 * pow(($r/$fs), 2.2) + 0.7152 * pow(($g/$fs), 2.2) + 0.0722 * pow(($b/$fs), 2.2);
			$Helligkeitsstufe = intval(($Helligkeit * 9) + 1);
			$Helligkeitsstufe_alt = $this->ReadPropertyInteger("Helligkeit");
			$Anzahl = $Helligkeitsstufe - $Helligkeitsstufe_alt;
			SetValue($this->GetIDForIdent("Helligkeit"), $Helligkeitsstufe);

			// Umwandeln der RGB Werte
			$hsv =  $this->RGBtoHSV($r, $g, $b);
			$address = $this->ReadPropertyString("LEDAdresse");
			/**
			Holen der 6-stelligen Hex Stringadresse des LM II Controllers
			 Diese muss um 0X ergänzt und mit 00 verlängert werden ---> 0xAdresse00.

			 Ferner werden für die Helligkeitsregelung die Hex Adressen für Up (+3) und
			Down (+) benötigt.
			
			Buchstaben der Hex Werte müssen in Grossbuchstaben umgewandelt werden.
			*/
			$Adresse_Hex = "0x".$address."00";
			$Adresse_Int = hexdec($Adresse_Hex);
			$Adresse_Up_Hex = strtoupper (dechex($Adresse_Int + 3));
			$Adresse_Down_Hex = strtoupper (dechex($Adresse_Int + 4));
			
			/**
			 Der Controller hat insgesamt 128 Farbcodes ---> es gibt 128 Raster mit je 2.8125°. Aufgrund des
			 hsv Wertes wird das Raster bestimmt.

			Der Farbkreis beginnt mit Rot bei 0°. Innerhalb der Codesequenz des Controllers befindet sich Rot
			 auf Index = 103. Deshalb müssen die Werte bis zum Index 103 jeweils verringert werden, um den Übergang
			 zu Gelb, Orange ... zu erhalten. Ab Index 104 muss mit dem letzten Index 128 angefangen werden (lila)
			und dann immer verringert werden bis rot erreicht ist.
			
			Dabei ist zu beachten, dass die gültigen Codes nur die Endstellen 0, 7, 8 und F haben und somit entweder
			7 oder 1 zu addieren ist.
			 
			*/
			$hsv = intval($hsv / 2.8125) + 1;
			
			if ($hsv > 103) {
			   $hsv = 232 - $hsv;
			}
			else {
			   $hsv = 104 - $hsv;
			}

			$Int1 = intval(($hsv - 1) / 4) * 16;

			$Rest = ($hsv - 1) % 4;
			switch ($Rest)
				{
				   case 0:
					  $Int2 = 0;
					  break;
				   case 1:
					  $Int2 = 7;
					  break;
				   case 2:
					  $Int2 = 8;
					  break;
				   case 3:
					  $Int2 = 15;
					  break;
				}
			
			

			// Adresse zum Senden des Farbcodes bilden

			$Adresse_Int = $Adresse_Int + $Int1 + $Int2;
			$address = strtoupper (dechex($Adresse_Int));
			$command = ""; // command ist schon in address enthalten
			return $this->Send_LED($address, $command, $this->GetIPGateway());
	
			// Setzen der Helligkeit nachdem die Farbe eingestellt worden ist
			if ($Anzahl > 0) {
			   for ($i = 1; $i <= $Anzahl; $i++)
				{
				  $this->Up();
				}
			}

			if ($Anzahl < 0)
			{
				for ($i = -1; $i >= $Anzahl; $i--)
				{
				  $this->Down();
				}
			}

			
			
        }
	
	
	/**
	 *     Umwandeln der RGB-Werte in ein Farbwert des HSV-Farbraum
	 *        RGB Werte:          0-255, 0-255, 0-255
	 *        H Wert:                   0-360°
	 *        H Wert: 0-199
	 */
	protected function RGBtoHSV($R, $G, $B)
		{
			$R = ($R / 255);
			$G = ($G / 255);
			$B = ($B / 255);

			$maxRGB = max($R, $G, $B);
			$minRGB = min($R, $G, $B);
			$chroma = $maxRGB - $minRGB;

			if ($chroma == 0)
				return 0;

			if ($R == $minRGB)
				$h = 3 - (($G - $B) / $chroma);
			elseif ($B == $minRGB)
				$h = 1 - (($R - $G) / $chroma);
			else // $G == $minRGB
				$h = 5 - (($B - $R) / $chroma);

			$Hue = intval((60 * $h));
			return $Hue;
		}	
	




	
		
	//Anlernen an Gateway
	// http://{GATEWAY_IP}/command?XC_FNC=learnSC&type=L2
	public function Learn()
		{
		$ip_aiogateway = $this->GetIPGateway();
		$GatewayPassword = $this->GetPassword();
		if ($GatewayPassword != "")
		{
			$address = file_get_contents("http://".$this->GetIPGateway()."/command?XC_USER=user&XC_PASS=".$GatewayPassword."&XC_FNC=learnSC&type=L2");
		}
		else
		{
			$address = file_get_contents("http://".$ip_aiogateway."/command?XC_FNC=learnSC&type=L2");
		}
		//kurze Pause während das Gateway im Lernmodus ist
		IPS_Sleep(1000); //1000 ms
		if ($address == "{XC_ERR}Failed to learn code")
			{
			$this->response = false;
			$instance = IPS_GetInstance($this->InstanceID)["InstanceID"];
			$address = "Das Gateway konnte keine Adresse empfangen.";
			IPS_LogMessage( "LED Adresse:" , $address );
			IPS_SetProperty($instance, "LearnAddressLED", false); //Haken entfernen.
			echo "Die Adresse des LED Controllers konnte nicht angelernt werden.";	
			}
		else
			{
				//Adresse auswerten {XC_SUC}
				//bei Erfolg {XC_SUC}{"CODE","ABCDEF00"} erste 6 Stellen sind die Adresse
				(string)$address = substr($address, 17, 6);
				$this->AddAddress($address);
				IPS_LogMessage( "LED Adresse:" , $address );
				echo "Adresse des LED Controllers: ".$address;
				$this->response = true;	
			}
		
		
		return $this->response;
		}
	
	//LED Adresse hinzufügen
	protected function AddAddress(string $address)
	{
		$instance = IPS_GetInstance($this->InstanceID)["InstanceID"];
		IPS_SetProperty($instance, "LEDAdresse", $address); //Adresse setzten.
		IPS_SetProperty($instance, "LearnAddressLED", false); //Haken entfernen.
		IPS_ApplyChanges($instance); //Neue Konfiguration übernehmen
		IPS_LogMessage( "LED Controller Adresse hinzugefügt:" , $address );	
	}
		
	//Senden eines Befehls an LED Controller
	// Aufruf LED Controller 2
	// http://{GATEWAY_IP}/command?XC_FNC=SendSC&type=L2&data=AAACMD
	// String /command?XC_FNC=SendSC&type=LS&data=
	// Der Wert für data setzt sich hierbei zusammen aus Adresse (AAA) und Kommando (CMD)
	// Beispiel: schalte ABC auf gelb:
	// http://{GATEWAY_IP}/command?XC_FNC=SendSC&type=L2&data=ABC0F0
	private $response = false;
	protected function Send_LED($address, $command)
		{
		$GatewayPassword = $this->GetPassword();
		IPS_LogMessage( "IP AIO Gateway:" , $ip_aiogateway );
		IPS_LogMessage( "LED Adresse:" , $address );
		IPS_LogMessage( "LED Command:" , $command );
		if ($GatewayPassword != "")
		{
			$gwcheck = file_get_contents("http://".$this->GetIPGateway()."/command?XC_USER=user&XC_PASS=".$GatewayPassword."&XC_FNC=SendSC&type=L2&data=".$address.$command);
		}
		else
		{
			$gwcheck = file_get_contents("http://".$this->GetIPGateway()."/command?XC_FNC=SendSC&type=L2&data=".$address.$command);
		}
		if ($gwcheck == "{XC_SUC}")
			{
			$this->response = true;	
			}
		return $this->response;
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