<?

require_once(__DIR__ . "/../AIOGatewayClass.php");  // diverse Klassen

class AIOFS20Device extends IPSModule
{
	
    public function Create()
    {
        //Never delete this line!
        parent::Create();
		
		//These lines are parsed on Symcon Startup or Instance creation
        //You cannot use variables here. Just static values.
        // 1. Verfügbarer AIOSplitter wird verbunden oder neu erzeugt, wenn nicht vorhanden.
        $this->ConnectParent("{7E03C651-E5BF-4EC6-B1E8-397234992DB4}");
		
		$this->RegisterPropertyString("HC1", "");
		$this->RegisterPropertyString("HC2", "");
		$this->RegisterPropertyString("Adresse", "");
		$this->RegisterPropertyString("AIOAdresse", "");
		$this->RegisterPropertyString("FS20Type", "Switch");
		$this->RegisterPropertyBoolean("LearnFS20Address", false);	
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
     *
     */
	protected function ValidateConfiguration()
		{
			$HC1 = $this->ReadPropertyString("HC1");
			$HC2 = $this->ReadPropertyString("HC2");
			$FS20Adresse = $this->ReadPropertyString("Adresse");
			$AIOFS20Adresse = $this->ReadPropertyString("AIOAdresse");
			$FS20Type = $this->ReadPropertyString("FS20Type");
			$LearnFS20Address = $this->ReadPropertyBoolean('LearnFS20Address');
				
			if ($LearnFS20Address)
				{
					$this->Learn();
				}
			elseif ($AIOFS20Adresse != '')
				{
					//AIOFS20Adresse prüfen
					if (strlen($AIOFS20Adresse)<6 or strlen($AIOFS20Adresse)>6)//Länge prüfen
						{
							$this->SetStatus(207);	
						}
					else
						{
						$this->SetupProfiles();
						$this->SetupVar();
						// Status aktiv
						$this->SetStatus(102);		
						}
						
				}
			elseif ( $HC1 == '' || $HC2 == '' || $FS20Adresse == '')
				{
					// Status inaktiv
					$this->SetStatus(202);
				}
			else 
			{	
				
				
				//Eingabe überprüfen Länge 4 Zeichen nur Zahlen
				if (strlen($HC1)<4 or strlen($HC1)>4)//Länge prüfen
					{
						$this->SetStatus(204);	
					}
				elseif (strlen($HC2)<4 or strlen($HC2)>4)//Länge prüfen
					{
						$this->SetStatus(205);
					}
				elseif (strlen($FS20Adresse)<4 or strlen($FS20Adresse)>4)//Länge prüfen
					{
						$this->SetStatus(206);
					}
				elseif (!ctype_digit($HC1))//Nur Zahlen
					{
						$this->SetStatus(204);
					}
				elseif (!ctype_digit($HC2))//Nur Zahlen
					{
						$this->SetStatus(205);
					}
				elseif (!ctype_digit($FS20Adresse))//Nur Zahlen
					{
						$this->SetStatus(206);
					}
				else
					{
						// Status aktiv
						$this->SetStatus(102);	
						$this->SetupVar();
						$this->SetupProfiles();
				
					}	
					
			}	
			
			
			
			
		}
	
	protected function SetupProfiles()
		{
			// Profile anlegen
			$this->RegisterProfileIntegerEx("Dimmer.AIOFS20", "Intensity", "", "", Array(
                                             Array(0, "0 %",  "", -1),
                                             Array(1, "10 %",  "", -1),
                                             Array(2, "20 %",  "", -1),
                                             Array(3, "30 %",  "", -1),
                                             Array(4, "40 %",  "", -1),
											 Array(5, "50 %",  "", -1),
											 Array(6, "60 %",  "", -1),
											 Array(7, "70 %",  "", -1),
											 Array(8, "80 %",  "", -1),
											 Array(9, "90 %",  "", -1),
											 Array(10, "100 %", "", -1)
						));
		}
	
	protected function SetupVar()
		{
			$FS20Type = $this->ReadPropertyString("FS20Type");
			//Status-Variablen anlegen
			$stateId = $this->RegisterVariableBoolean("Status", "Status", "~Switch", 1);
			$this->EnableAction("Status");
			
			// Variablen bei Dimmer anlegen
			if ($FS20Type === "Dimmer")
				{
					$this->RegisterVariableInteger("Dimmer", "Dimmer", "Dimmer.AIOFS20", 2);
					$this->EnableAction("Dimmer");
				}		
		}
	
	
	
	public function RequestAction($Ident, $Value)
    {
        switch($Ident) {
            case "Status":
                $this->SetPowerState($Value);
				break;
			case "Dimmer":
                switch($Value) {
                    case 0: //0
						$this->Set0();
                        break;
                    case 1: //10
                        $this->Set10();
                        break;
                    case 2: //20
                        $this->Set20();
                        break;
                    case 3: //30
                        $this->Set30();
                        break;
                    case 4: //40
                        $this->Set40();
                        break;
					case 5: //50
                        $this->Set50();
                        break;
					case 6: //60
                        $this->Set60();
                        break;
					case 7: //70
                        $this->Set70();
                        break;
					case 8: //80
                        $this->Set80();
                        break;
					case 9: //90
                        $this->Set90();
                        break;
					case 10: //100
                        $this->Set100();
                        break;		
                }
                break;	
            default:
                throw new Exception("Invalid ident");
        }
    }
	
		
	protected function SetPowerState($state) {
		if ($state === true)
		{
		$action = "1000";
		return $this->SendCommand($action);
		}
		else
		{
		$action = "0000";
		return $this->SendCommand($action);
		}
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
	
	protected function GetPassword(){
		$ParentID = $this->GetParent();
		$GatewayPassword = IPS_GetProperty($ParentID, 'Passwort');
		return $GatewayPassword;
	}
	
	
	 public function On() {
        $command = "1000";
		return $this->SendCommand($command);
        }
		
	public function Off() {
		$command = "0000";
        return $this->SendCommand($command);
        }
	
	public function Last() {
		$command = "1100";
        return $this->SendCommand($command);
        }	
		
	public function Toggle() {
		$command = "1200";
        return $this->SendCommand($command);
        }

	public function DimUp() {
		$command = "1300";
        return $this->SendCommand($command);
        }

	public function DimDown() {
		$command = "1400";
        return $this->SendCommand($command);
        }	
	
	// DIM0 - Auf 0% dimmen
	public function Set0() {
		$command = "DIM0";
        return $this->SendCommand($command);
        }
	
	// 0100 - Auf 6,25% dimmen
	public function Set6() {
		$command = "0100";
        return $this->SendCommand($command);
        }	
	
	// 0200 - Auf 12,50% dimmen (im Creator ~10%)
	public function Set10() {
		$command = "0200";
        return $this->SendCommand($command);
        }	
	
	// 0300 - Auf 18,75% dimmen (im Creator ~20%)
	public function Set20() {
		$command = "0300";
        return $this->SendCommand($command);
        }	
	
	// 0400 - Auf 25,00% dimmen
	public function Set25() {
		$command = "0400";
        return $this->SendCommand($command);
        }	
	
	// 0500 - Auf 31,25% dimmen (im Creator ~30%)
	public function Set30() {
		$command = "0500";
        return $this->SendCommand($command);
        }	
	
	// 0600 - Auf 37,50% dimmen (im Creator ~40%)
	public function Set40() {
		$command = "0600";
        return $this->SendCommand($command);
        }	
	
	// 0700 - Auf 43,75% dimmen
	public function Set44() {
		$command = "0700";
        return $this->SendCommand($command);
        }	
	
	// 0800 - Auf 50,00% dimmen (im Creator ~50%)
	public function Set50() {
		$command = "0800";
        return $this->SendCommand($command);
        }	
	
	// 0900 - Auf 59,25% dimmen (im Creator ~60%)
	public function Set60() {
		$command = "0900";
        return $this->SendCommand($command);
        }	
	
	// 0A00 - Auf 62,50% dimmen
	public function Set63() {
		$command = "0A00";
        return $this->SendCommand($command);
        }	
	
	// 0B00 - Auf 68,75% dimmen (im Creator ~70%)
	public function Set70() {
		$command = "0B00";
        return $this->SendCommand($command);
        }
	
	// 0C00 - Auf 75,00% dimmen
	public function Set75() {
		$command = "0C00";
        return $this->SendCommand($command);
        }
	
	// 0D00 - Auf 81,25% dimmen (im Creator ~80%)
	public function Set80() {
		$command = "0D00";
        return $this->SendCommand($command);
        }
	
	// 0E00 - Auf 87,50% dimmen (im Creator ~90%)
	public function Set90() {
		$command = "0E00";
        return $this->SendCommand($command);
        }
		
	// 0F00 - Auf 93,75% dimmen
	public function Set94() {
		$command = "0F00";
        return $this->SendCommand($command);
        }	
	
	// DIM100 - Auf 100% dimmen
	public function Set100() {
		$command = "DIM100";
        return $this->SendCommand($command);
        }	
	
	//Senden eines Befehls an FS20
	// Sendestring FS20 {IP Gateway}/command?XC_FNC=SendSC&type=FS20&data={FS20 Send Adresse}{Command} 
	private $response = false;
	protected function SendCommand($command)
	{
		$FS20 = $this->Calculate();
		$ip_aiogateway = $this->GetIPGateway();
		IPS_LogMessage( "FS20 Adresse:" , $FS20 );
		IPS_LogMessage( "FS20 Command:" , $command );
		$GatewayPassword = $this->GetPassword();
		
		switch($command) 
		{
                    case "1000": //An
						SetValueBoolean($this->GetIDForIdent('Status'), true);
						 
						if (IPS_StatusVariableExists($this->InstanceID, "Dimmer"))
						{
						SetValueInteger($this->GetIDForIdent('Dimmer'), 10);	
						}
						break;
                    case "0000": //Aus
                        SetValueBoolean($this->GetIDForIdent('Status'), false);
						if (IPS_StatusVariableExists($this->InstanceID, "Dimmer"))
						{
						SetValueInteger($this->GetIDForIdent('Dimmer'), 0);	
						}
						break;
					case "DIM0": //0
                        SetValueBoolean($this->GetIDForIdent('Status'), false);
						SetValueInteger($this->GetIDForIdent('Dimmer'), 0);
						$command = "0000";
                        break;
					case "0200": //10
                        SetValueInteger($this->GetIDForIdent('Dimmer'), 1);
                        break;	
                    case "0300": //20
                        SetValueInteger($this->GetIDForIdent('Dimmer'), 2);
                        break;
                    case "0500": //30
                        SetValueInteger($this->GetIDForIdent('Dimmer'), 3);
                        break;
                    case "0600": //40
                        SetValueInteger($this->GetIDForIdent('Dimmer'), 4);
                        break;
					case "0800": //50
                        SetValueInteger($this->GetIDForIdent('Dimmer'), 5);
                        break;
					case "0900": //60
                        SetValueInteger($this->GetIDForIdent('Dimmer'), 6);
                        break;
					case "0B00": //70
                        SetValueInteger($this->GetIDForIdent('Dimmer'), 7);
                        break;
					case "0D00": //80
                        SetValueInteger($this->GetIDForIdent('Dimmer'), 8);
                        break;
					case "0E00": //90
                        SetValueInteger($this->GetIDForIdent('Dimmer'), 9);
                        break;
					case "DIM100": //100
                        SetValueBoolean($this->GetIDForIdent('Status'), true);
						SetValueInteger($this->GetIDForIdent('Dimmer'), 10);
						$command = "1000";
						break;	
		}
		
		if ($GatewayPassword !== "")
		{
			$gwcheck = file_get_contents("http://".$this->GetIPGateway()."/command?XC_USER=user&XC_PASS=".$GatewayPassword."&XC_FNC=SendSC&type=FS20&data=".$FS20.$command);
			IPS_LogMessage( "AIOGateway:" , "Senden an Gateway mit Passwort" );
		}
		else
		{
			$gwcheck = file_get_contents("http://".$this->GetIPGateway()."/command?XC_FNC=SendSC&type=FS20&data=".$FS20.$command);
		}
        if ($gwcheck == "{XC_SUC}")
			{
			$this->response = true;	
			}
		return $this->response;
	}
	
	
	//Anmelden eines FS20 Geräts an das a.i.o. gateway:
	//http://{IP-Adresse-des-Gateways}/command?XC_FNC=LearnSC&type=FS20
	public function Learn()
		{
		$GatewayPassword = $this->GetPassword();
		if ($GatewayPassword !== "")
		{
			$address = file_get_contents("http://".$this->GetIPGateway()."/command?XC_USER=user&XC_PASS=".$GatewayPassword."&XC_FNC=LearnSC&type=FS20");
		}
		else
		{
			$address = file_get_contents("http://".$this->GetIPGateway()."/command?XC_FNC=LearnSC&type=FS20");
		}	
		//kurze Pause während das Gateway im Lernmodus ist
		IPS_Sleep(1000); //1000 ms
		if ($address == "{XC_ERR}Failed to learn code")//Bei Fehler
			{
			$this->response = false;
			$instance = IPS_GetInstance($this->InstanceID)["InstanceID"];
			$address = "Das Gateway konnte keine Adresse empfangen.";
			IPS_LogMessage( "FS20 Adresse:" , $address );
			echo "Die Adresse vom FS20 Gerät konnte nicht angelernt werden.";
			IPS_SetProperty($instance, "LearnFS20Address", false); //Haken entfernen.			
			}
		else
			{
				//Adresse auswerten {XC_SUC}
				//bei Erfolg {XC_SUC}{"CODE":"123403"} 
				(string)$address = substr($address, 17, 6);
				IPS_LogMessage( "FS20 Adresse:" , $address );
				//echo "Adresse des FS20 Geräts: ".$address;
				$this->AddAddress($address);
				$this->response = true;	
			}
		
		return $this->response;
		}
	
	//IT Adresse hinzufügen
	protected function AddAddress($address)
	{
		$instance = IPS_GetInstance($this->InstanceID)["InstanceID"];
		IPS_SetProperty($instance, "AIOAdresse", $address); //FS20 Adresse setzten.
		IPS_SetProperty($instance, "LearnFS20Address", false); //Haken entfernen.
		IPS_ApplyChanges($instance); //Neue Konfiguration übernehmen
		IPS_LogMessage( "FS20 Adresse hinzugefügt:" , $address );
		// Status aktiv
		$this->SetStatus(102);	
		$this->SetupVar();
		$this->SetupProfiles();	
	}

	
	//Berechnung des FS20 Codes
	protected function Calculate()
	{
		$HC1 = $this->ReadPropertyString("HC1");
		$HC2 = $this->ReadPropertyString("HC2");
		$FS20Adresse = $this->ReadPropertyString("Adresse");
		$AIOFS20Adresse = $this->ReadPropertyString("AIOAdresse");
		if ($AIOFS20Adresse != "")
			{
			$FS20_send = $AIOFS20Adresse;
			return $FS20_send;
			}
		else
			{
			$FS20_Code = $HC1.$HC2.$FS20Adresse;
			//print_r($FS20_Code);
			$arr1 = str_split($FS20_Code);
			//print_r($arr1);
			/* Stelle um 1 reduzieren */
			for ($i = 0; $i <= 11; $i++)
				{
				$arr1[$i] = $arr1[$i] -1; 
				}
			/* Aufteilung in Zweierblöcke */
			/* Die jeweils erste Zahl eines Blocks wird mit 4 multipliziert und mit der zweiten Zahl addiert */
			for ($i = 0; $i <= 10; $i=$i+2)
				{
				$arr2[$i] = $arr1[$i] * 4 + $arr1[$i+1];
			}
			/* Jeder Block wird nun in seine Hexadezimaldarstellung überführt (0-9, A-F) */
			for ($i = 0; $i <= 10; $i=$i+2)
				{
				$arr2[$i] = dechex($arr2[$i]);
				}
			$FS20_send = $arr2[0].$arr2[2].$arr2[4].$arr2[6].$arr2[8].$arr2[10];
			return $FS20_send;
			}
		
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