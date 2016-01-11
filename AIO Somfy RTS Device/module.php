<?

require_once(__DIR__ . "/../AIOGatewayClass.php");  // diverse Klassen

class AIOSomfyRTSDevice extends IPSModule
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
			
			$AIORTSAdresse = $this->ReadPropertyString("Adresse");
			
				
			
			if ($AIORTSAdresse != '')
					{
						//AIORTSAdresse prüfen
						if (strlen($AIORTSAdresse)<6 or strlen($AIORTSAdresse)>6)//Länge prüfen
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
			elseif ($AIORTSAdresse == '')
			{
				// Status inaktiv
				$this->SetStatus(202);
			}
			else 
			{	
				
				
				//Eingabe überprüfen Länge 4 Zeichen nur Zahlen
				
						// Status aktiv
						$this->SetStatus(102);	
						$this->SetupVar();
						$this->SetupProfiles();
				
				
			}	
			
			
			
			
		}
	
	protected function SetupProfiles()
		{
			// Profile anlegen
			$this->RegisterProfileIntegerEx("Somfy.AIORTS", "Information", "", "", Array(
                                             Array(0, "Down",  "", -1),
                                             Array(1, "Up",  "", -1)
						));
		}
	
	protected function SetupVar()
		{
			//Status-Variablen anlegen
			$stateId = $this->RegisterVariableInteger("Somfy", "Somfy", "Somfy.AIORTS", 1);
			$this->EnableAction("Somfy");
			
			
		}
	
	
	
	public function RequestAction($Ident, $Value)
    {
        switch($Ident) {
            case "Somfy":
                switch($Value) {
                    case 0: //Down
						$state = false; 
                        SetValueBoolean($this->GetIDForIdent('Status'), $state);
						SetValueInteger($this->GetIDForIdent('Dimmer'), $Value);
						$this->SetPowerState($state);
                        break;
                    case 1: //Up
                        $this->Set10();
						SetValueInteger($this->GetIDForIdent('Dimmer'), $Value);
                        break;
                }
                break;	
            default:
                throw new Exception("Invalid ident");
        }
    }
	
	protected function PowerSetState ($state){
	SetValueBoolean($this->GetIDForIdent('Status'), $state);
	return $this->SetPowerState($state);	
	}
	
	protected function SetPowerState($state) {
		if ($state === true)
		{
		$action = "1000";
		return $this->SendCommand($this->Calculate(), $action, $this->GetIPGateway());
		}
		else
		{
		$action = "0000";
		return $this->SendCommand($this->Calculate(), $action, $this->GetIPGateway());
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
	
	public function Up() {
        $address = $this->ReadPropertyInteger('Adresse');
		$command = "20";
		return $this->SendCommand($address, $command, $this->GetIPGateway());
        }
	
	public function Down() {
        $address = $this->ReadPropertyInteger('Adresse');
		$command = "40";
		return $this->SendCommand($address, $command, $this->GetIPGateway());
        }
	
	public function Stop() {
        $address = $this->ReadPropertyInteger('Adresse');
		$command = "10";
		return $this->SendCommand($address, $command, $this->GetIPGateway());
        }
	
	//Senden eines Befehls an Somfy RTS
	// Sendestring RTS {IP Gateway}/command?XC_FNC=SendSC&type=RT&data={RTS Send Adresse}{Command} 
	private $response = false;
	protected function SendCommand($address, $command, $ip_aiogateway) {
		IPS_LogMessage( "Adresse:" , $address );
		IPS_LogMessage( "RTS Command:" , $command );
        $gwcheck = file_get_contents("http://".$ip_aiogateway."/command?XC_FNC=SendSC&type=RT&data=".$address.$command);
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