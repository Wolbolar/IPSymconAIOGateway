<?

require_once(__DIR__ . "/../AIOGatewayClass.php");  // diverse Klassen

class AIODooyaDevice extends IPSModule
{
	
    public function Create()
    {
        //Never delete this line!
        parent::Create();
		
		//These lines are parsed on Symcon Startup or Instance creation
        //You cannot use variables here. Just static values.
        // 1. Verfügbarer AIOSplitter wird verbunden oder neu erzeugt, wenn nicht vorhanden.
        $this->ConnectParent("{7E03C651-E5BF-4EC6-B1E8-397234992DB4}");
		$this->RegisterPropertyString("Adresse", "");
		    
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
			
			$AIODooyaAdresse = $this->ReadPropertyString("Adresse");
			
				
			
			if ($AIODooyaAdresse != '')
					{
						//AIODooyaAdresse prüfen
						if (strlen($AIODooyaAdresse)<8 or strlen($AIODooyaAdresse)>8)//Länge prüfen
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
			elseif ($AIODooyaAdresse == '')
			{
				// Status inaktiv
				$this->SetStatus(202);
			}
			else 
			{	
				
				
					// Status aktiv
					$this->SetStatus(102);	
					$this->SetupVar();
					$this->SetupProfiles();
				
				
			}	
			
			
			
			
		}
	
	protected function SetupProfiles()
		{
			// Profile anlegen
			$this->RegisterProfileIntegerEx("Dooya.AIO", "Shutter", "", "", Array(
                                             Array(0, "Down",  "", -1),
                                             Array(1, "Stop",  "", -1),
											 Array(2, "Up",  "", -1)
						));
		}
	
	protected function SetupVar()
		{
			//Status-Variablen anlegen
			$stateId = $this->RegisterVariableInteger("Dooya", "Dooya", "Dooya.AIO", 1);
			$this->EnableAction("Dooya");
			
			
		}
	
	
	
	public function RequestAction($Ident, $Value)
    {
        switch($Ident) {
            case "Dooya":
                switch($Value) {
                    case 0: //Down
						$state = false; 
                        SetValueInteger($this->GetIDForIdent('Dooya'), $Value);
						$this->Down();
                        break;
                    case 1: //Stop
                        $this->Stop();
						SetValueInteger($this->GetIDForIdent('Dooya'), $Value);
                        break;
					case 2: //Up
                        $this->Up();
						SetValueInteger($this->GetIDForIdent('Dooya'), $Value);
                        break;	
                }
                break;	
            default:
                throw new Exception("Invalid ident");
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
	
	protected function GetPasswort(){
		$ParentID = $this->GetParent();
		$GatewayPassword = IPS_GetProperty($ParentID, 'Passwort');
		return $GatewayPassword;
	}
	
	public function Up() {
        $command = "22";
		return $this->SendCommand($command);
        }
	
	public function Down() {
        $command = "44";
		return $this->SendCommand($command);
        }
	
	public function Stop() {
        $command = "55";
		return $this->SendCommand($command);
        }
	
	//Senden eines Befehls an Dooya
	// Sendestring {IP Gateway}/command?XC_FNC=SendSC&type=DY&data={Dooya Send Adresse 8 stellig}{Command} 
	private $response = false;
	protected function SendCommand($address) {
		$address = $this->ReadPropertyString('Adresse');
		IPS_LogMessage( "Adresse:" , $address );
		IPS_LogMessage( "Dooya Command:" , $command );
		$GatewayPassword = $this->GatewayPassword();
		if ($GatewayPassword != "")
		{
			$gwcheck = file_get_contents("http://".$this->GetIPGateway()."/command?XC_USER=user&XC_PASS=".$GatewayPassword."&XC_FNC=SendSC&type=RT&data=".$command.$address);
		}
		else
		{
			$gwcheck = file_get_contents("http://".$this->GetIPGateway()."/command?XC_FNC=SendSC&type=RT&data=".$command.$address);
		}
		
		if ($gwcheck == "{XC_SUC}")
			{
			$this->response = true;	
			}
		return $this->response;
		}
	
	// Befehle 20 auf / 40 ab / 10 stop
		
	
	
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